<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    /**
     * Simpan pengaturan toko. Dipanggil oleh fetch() di admin/pengaturan.blade.php
     * lewat POST /admin/pengaturan.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'nama_toko'        => ['required', 'string', 'max:100'],
            'whatsapp'         => ['required', 'string', 'max:20'],
            'tagline'          => ['nullable', 'string', 'max:150'],
            'alamat'           => ['required', 'string'],
            'catatan_patokan'  => ['nullable', 'string', 'max:255'],
            'latitude'         => ['nullable', 'numeric', 'between:-90,90'],
            'longitude'        => ['nullable', 'numeric', 'between:-180,180'],
            'logo'             => ['nullable', 'image', 'max:2048'],

            'qris_aktif'       => ['required', 'boolean'],
            'tunai_aktif'      => ['required', 'boolean'],
            'transfer_aktif'   => ['required', 'boolean'],

            'status_buka'      => ['required', 'boolean'],
            'jam_buka_weekday'   => ['nullable', 'date_format:H:i'],
            'jam_tutup_weekday'  => ['nullable', 'date_format:H:i'],
            'jam_buka_weekend'   => ['nullable', 'date_format:H:i'],
            'jam_tutup_weekend'  => ['nullable', 'date_format:H:i'],
            'libur_mulai'      => ['nullable', 'date'],
            'libur_selesai'    => ['nullable', 'date', 'after_or_equal:libur_mulai'],

            'auto_accept'      => ['required', 'boolean'],
            'notif_suara'      => ['required', 'boolean'],
            'ukuran_kertas'    => ['required', 'in:58,80'],
        ]);

        // Singleton settings row (selalu satu baris untuk satu toko)
        $pengaturan = Pengaturan::first() ?? new Pengaturan();

        if ($request->hasFile('logo')) {
            if ($pengaturan->logo_path) {
                Storage::disk('public')->delete($pengaturan->logo_path);
            }
            $validated['logo_path'] = $request->file('logo')->store('logo-toko', 'public');
        }

        $pengaturan->fill($validated);
        $pengaturan->save();

        return response()->json([
            'message'    => 'Pengaturan toko berhasil disimpan.',
            'pengaturan' => $pengaturan,
        ]);
    }

    /**
     * Tes cetak struk ke printer thermal. Dipanggil oleh fetch() di
     * admin/pengaturan.blade.php lewat POST /admin/pengaturan/tes-cetak.
     *
     * NOTE: implementasi asli tergantung driver printer yang dipakai
     * (mis. escpos-php via USB/LAN). Ini masih stub sukses-selalu.
     */
    public function tesCetak(Request $request)
    {
        // TODO: panggil service/print driver yang sebenarnya di sini.

        return response()->json([
            'message' => 'Perintah tes cetak terkirim.',
        ]);
    }
}