<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $fillable = [
        'nama_toko',
        'whatsapp',
        'tagline',
        'alamat',
        'catatan_patokan',
        'logo_path',
        'latitude',
        'longitude',
        'qris_aktif',
        'tunai_aktif',
        'transfer_aktif',
        'status_buka',
        'jam_buka_weekday',
        'jam_tutup_weekday',
        'jam_buka_weekend',
        'jam_tutup_weekend',
        'libur_mulai',
        'libur_selesai',
        'auto_accept',
        'notif_suara',
        'ukuran_kertas',
    ];

    protected $casts = [
        'qris_aktif'     => 'boolean',
        'tunai_aktif'    => 'boolean',
        'transfer_aktif' => 'boolean',
        'status_buka'    => 'boolean',
        'auto_accept'    => 'boolean',
        'notif_suara'    => 'boolean',
        'latitude'       => 'float',
        'longitude'      => 'float',
        'libur_mulai'    => 'date',
        'libur_selesai'  => 'date',
    ];

    protected $table = 'settings';
}