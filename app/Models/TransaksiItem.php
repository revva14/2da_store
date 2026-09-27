<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiItem extends Model
{
    protected $table = 'transaksi_items';
    protected $fillable = ['transaksi_id','product_slug','nama_produk','harga','qty','opsi','subtotal'];
    protected $casts = ['harga'=>'integer','qty'=>'integer','subtotal'=>'integer','opsi'=>'array'];
    public function transaksi() { return $this->belongsTo(Transaksi::class, 'transaksi_id', 'id_transaksi'); }
}
