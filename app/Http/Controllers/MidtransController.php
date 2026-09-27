<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Config as MidtransConfig;
use Midtrans\Snap;

class MidtransController extends Controller
{
    public function __construct()
    {
        MidtransConfig::$serverKey = config('midtrans.server_key');
        MidtransConfig::$isProduction = config('midtrans.is_production');
        MidtransConfig::$isSanitized = true;
        MidtransConfig::$is3ds = true;
    }

    /**
     * Membuat Snap Token berdasarkan transaksi
     * yang sudah tersimpan di database.
     */
    public function getSnapToken(Request $request)
    {
        $request->validate([
            'transaksi_id' => 'required|integer',
        ]);

        try {
            $transaksi = Transaksi::with('items')
                ->where('id_transaksi', $request->transaksi_id)
                ->where('user_id', auth()->id())
                ->firstOrFail();

            // Kalau token sudah pernah dibuat,
            // gunakan token yang lama.
            if (!empty($transaksi->snap_token)) {
                return response()->json([
                    'snap_token' => $transaksi->snap_token,
                ]);
            }

            $params = [
                'transaction_details' => [
                    'order_id' => $transaksi->no_pesanan,
                    'gross_amount' => (int) $transaksi->total,
                ],

                'customer_details' => [
                    'first_name' => $transaksi->nama_penerima,
                    'phone' => $transaksi->no_whatsapp,

                    'billing_address' => [
                        'address' => $transaksi->alamat,
                    ],
                ],
            ];

            $snapToken = Snap::getSnapToken($params);

            // Simpan token ke transaksi
            $transaksi->update([
                'snap_token' => $snapToken,
                'payment_status' => 'pending',
            ]);

            return response()->json([
                'snap_token' => $snapToken,
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return response()->json([
                'message' => 'Transaksi tidak ditemukan.',
            ], 404);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Gagal membuat transaksi Midtrans: ' . $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Menerima notification dari Midtrans.
     */
    public function notification(Request $request)
    {
        try {
            $orderId = $request->input('order_id');
            $statusCode = $request->input('status_code');
            $grossAmount = $request->input('gross_amount');
            $signatureKey = $request->input('signature_key');

            // Validasi data wajib
            if (!$orderId || !$statusCode || !$grossAmount || !$signatureKey) {
                return response()->json([
                    'message' => 'Data notification tidak lengkap.',
                ], 400);
            }

            // Cek signature dari Midtrans
            $expectedSignature = hash(
                'sha512',
                $orderId
                . $statusCode
                . $grossAmount
                . config('midtrans.server_key')
            );

            if (!hash_equals($expectedSignature, $signatureKey)) {
                Log::warning('Midtrans notification signature tidak valid.', [
                    'order_id' => $orderId,
                ]);

                return response()->json([
                    'message' => 'Signature tidak valid.',
                ], 403);
            }

            // Cari transaksi berdasarkan nomor pesanan
            $transaksi = Transaksi::where(
                'no_pesanan',
                $orderId
            )->first();

            if (!$transaksi) {
                Log::warning('Transaksi Midtrans tidak ditemukan.', [
                    'order_id' => $orderId,
                ]);

                return response()->json([
                    'message' => 'Transaksi tidak ditemukan.',
                ], 404);
            }

            $transactionStatus = $request->input('transaction_status');
            $fraudStatus = $request->input('fraud_status');
            $transactionId = $request->input('transaction_id');

            /*
             * Tentukan status pembayaran.
             */
            $paymentStatus = $transactionStatus;

            if (
                $transactionStatus === 'capture'
                && $fraudStatus === 'challenge'
            ) {
                $paymentStatus = 'challenge';
            }

            // Update transaksi
            $transaksi->update([
                'midtrans_transaction_id' => $transactionId,
                'payment_status' => $paymentStatus,
            ]);

            Log::info('Midtrans notification berhasil diproses.', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'payment_status' => $paymentStatus,
            ]);

            return response()->json([
                'ok' => true,
            ]);

        } catch (\Throwable $e) {

            Log::error('Midtrans notification error.', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Notification gagal diproses.',
            ], 500);
        }
    }
}