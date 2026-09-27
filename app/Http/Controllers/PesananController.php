<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string'],
            'driver_note' => ['nullable', 'string', 'max:2000'],
            'kitchen_note' => ['nullable', 'string', 'max:2000'],
            'shipping_label' => ['nullable', 'string', 'max:100'],
            'shipping_cost' => ['required', 'integer', 'min:0'],
            'payment' => ['required', 'in:qris,va,cod'],
            'subtotal' => ['required', 'integer', 'min:0'],
            'total' => ['required', 'integer', 'min:0'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.id' => ['required', 'string'],
            'items.*.qty' => ['required', 'integer', 'min:1'],
            'items.*.opts' => ['nullable', 'array'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Ambil produk dari config/menu.php
        |--------------------------------------------------------------------------
        */
        $products = collect(config('menu'))->keyBy(
            fn ($p, $key) => $key
        );

        $subtotal = 0;
        $items = [];

        foreach ($data['items'] as $item) {
            $product = $products->get($item['id']);

            abort_unless(
                $product,
                422,
                'Produk tidak ditemukan: ' . $item['id']
            );

            $opts = $item['opts'] ?? [];

            $extra = collect($opts)->sum(
                fn ($o) => (int) ($o['extra'] ?? 0)
            );

            $harga = (int) $product['price'] + $extra;

            $lineSubtotal = $harga * (int) $item['qty'];

            $subtotal += $lineSubtotal;

            $items[] = [
                'product' => $product,
                'item' => $item,
                'opts' => $opts,
                'harga' => $harga,
                'lineSubtotal' => $lineSubtotal,
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Hitung ulang harga di server
        |--------------------------------------------------------------------------
        */
        $ongkir = (int) $data['shipping_cost'];
        $total = $subtotal + $ongkir;

        /*
        |--------------------------------------------------------------------------
        | Simpan transaksi
        |--------------------------------------------------------------------------
        */
        $transaksi = DB::transaction(function () use (
            $data,
            $items,
            $subtotal,
            $ongkir,
            $total
        ) {
            $no = '2DA-' . strtoupper(
                substr(bin2hex(random_bytes(4)), 0, 5)
            );

            $t = Transaksi::create([
                'user_id' => auth()->id(),

                'no_pesanan' => $no,

                'nama_penerima' => $data['nama'],
                'no_whatsapp' => $data['phone'],
                'alamat' => $data['address'],

                'catatan_driver' => $data['driver_note'] ?? null,
                'catatan_dapur' => $data['kitchen_note'] ?? null,

                'metode_pengiriman' =>
                    str_contains(
                        strtolower($data['shipping_label'] ?? ''),
                        'pick'
                    )
                        ? 'pickup'
                        : 'delivery',

                'label_pengiriman' =>
                    $data['shipping_label'] ?? null,

                'metode_pembayaran' => $data['payment'],

                'bukti_pembayaran' => null,

                'subtotal' => $subtotal,
                'ongkir' => $ongkir,
                'total' => $total,

                // Midtrans
                'snap_token' => null,
                'midtrans_transaction_id' => null,
                'payment_status' => 'pending',

                // Status pesanan
                'status' => 'baru',
            ]);

            /*
            |--------------------------------------------------------------------------
            | Simpan item transaksi
            |--------------------------------------------------------------------------
            */
            foreach ($items as $row) {
                $t->items()->create([
                    'product_slug' => $row['item']['id'],
                    'nama_produk' => $row['product']['name'],
                    'harga' => $row['harga'],
                    'qty' => $row['item']['qty'],
                    'opsi' => $row['opts'],
                    'subtotal' => $row['lineSubtotal'],
                ]);
            }

            return $t;
        });

        /*
        |--------------------------------------------------------------------------
        | PENTING
        |
        | id       = id_transaksi (INTEGER)
        | no_pesanan = nomor pesanan 2DA-XXXXX
        |--------------------------------------------------------------------------
        */
        return response()->json([
            'ok' => true,

            // Untuk MidtransController
            'id' => (int) $transaksi->id_transaksi,
            'transaksi_id' => (int) $transaksi->id_transaksi,

            // Untuk ditampilkan ke user
            'no_pesanan' => $transaksi->no_pesanan,

            'message' => 'Pesanan berhasil disimpan.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - DAFTAR PESANAN
    |--------------------------------------------------------------------------
    */
    public function adminIndex()
    {
        $orders = Transaksi::with('items')
            ->latest()
            ->get();

        $pesanan = $orders->map(function ($o) {

            $created = $o->created_at;

            $agoSeconds = $created
                ? max(0, now()->diffInSeconds($created))
                : 0;

            $items = $o->items->map(fn ($i) => [
                'q' => (int) $i->qty,
                'n' => $i->nama_produk,
                'note' => collect($i->opsi ?? [])
                    ->pluck('name')
                    ->implode(', '),
                'h' => (int) $i->harga,
            ])->values()->all();

            $first = !empty($items)
                ? $items[0]['q'] . '× ' . $items[0]['n']
                : '';

            $rest = array_slice($items, 1);

            return [
                'no' => preg_replace(
                    '/^2DA-/',
                    '',
                    $o->no_pesanan
                ),

                'id' => '#' . $o->no_pesanan,

                'jam' => $created?->format('H:i'),

                'ago' => $agoSeconds < 60
                    ? $agoSeconds . ' dtk lalu'
                    : floor($agoSeconds / 60) . ' mnt lalu',

                'nama' => $o->nama_penerima,
                'hp' => $o->no_whatsapp,

                'detail' => $first,

                'sub' => count($rest)
                    ? '+' . implode(
                        ', ',
                        array_map(
                            fn ($i) => $i['q'] . '× ' . $i['n'],
                            $rest
                        )
                    )
                    : '',

                'tipe' => $o->metode_pengiriman === 'pickup'
                    ? 'Pick-up'
                    : 'Delivery',

                'bayar' =>
                    strtoupper($o->metode_pembayaran) === 'COD'
                        ? 'COD Tunai'
                        : strtoupper($o->metode_pembayaran)
                            . ' '
                            . (
                                $o->payment_status === 'settlement'
                                    ? 'Lunas'
                                    : 'Pending'
                            ),

                'status' => $o->status,

                'menitDapur' =>
                    $o->status === 'dapur'
                        ? $created?->diffInMinutes(now())
                        : 0,

                'catatan' => trim(
                    ($o->catatan_driver ?? '') .
                    ' ' .
                    ($o->catatan_dapur ?? '')
                ),

                // Total asli dari DB (sudah termasuk ongkir), dipakai
                // FE supaya tidak salah hitung ulang dari item saja.
                'total' => (int) $o->total,

                'items' => $items,
            ];
        })->values();

        $hitung = array_fill_keys(
            ['baru', 'dapur', 'antar', 'selesai', 'batal'],
            0
        );

        foreach ($orders as $o) {
            $hitung[$o->status] =
                ($hitung[$o->status] ?? 0) + 1;
        }

        /*
        |--------------------------------------------------------------------------
        | OMSET TERKONFIRMASI
        |
        | Dianggap "terkonfirmasi" = pesanan yang statusnya sudah "selesai".
        | Kalau maksudnya beda (misal payment_status = settlement), tinggal
        | ganti kondisi where() di bawah ini.
        |--------------------------------------------------------------------------
        */
        $selesai = $orders->where('status', 'selesai');

        $omsetTerkonfirmasi = (int) $selesai->sum('total');

        $totalSelesai = $selesai->count();

        $qrisSelesai = $selesai->filter(
            fn ($o) => strtoupper($o->metode_pembayaran) !== 'COD'
        )->count();

        $persenQris = $totalSelesai
            ? (int) round($qrisSelesai / $totalSelesai * 100)
            : 0;

        return view(
            'admin.pesanan',
            compact(
                'pesanan',
                'hitung',
                'omsetTerkonfirmasi',
                'persenQris'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - UPDATE STATUS PESANAN
    |--------------------------------------------------------------------------
    */
    public function updateStatus(
        Request $request,
        string $no
    ) {
        $data = $request->validate([
            'status' => [
                'required',
                'in:baru,dapur,antar,selesai,batal'
            ],
        ]);

        $fullNo = str_starts_with($no, '2DA-')
            ? $no
            : '2DA-' . $no;

        $o = Transaksi::where(
            'no_pesanan',
            $fullNo
        )->firstOrFail();

        $o->update([
            'status' => $data['status']
        ]);

        return response()->json([
            'ok' => true,
            'status' => $o->status
        ]);
    }
}