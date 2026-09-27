<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'user_id',
        'no_pesanan',
        'nama_penerima',
        'no_whatsapp',
        'alamat',
        'catatan_driver',
        'catatan_dapur',
        'metode_pengiriman',
        'label_pengiriman',
        'metode_pembayaran',
        'bukti_pembayaran',
        'subtotal',
        'ongkir',
        'total',
        'snap_token',
        'midtrans_transaction_id',
        'payment_status',
        'status',
    ];

    protected $casts = [
        'subtotal' => 'integer',
        'ongkir' => 'integer',
        'total' => 'integer',
    ];

    public function items()
    {
        return $this->hasMany(
            TransaksiItem::class,
            'transaksi_id',
            'id_transaksi'
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}