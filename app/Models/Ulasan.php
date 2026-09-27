<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'nama',
        'inisial',
        'kategori',
        'rating',
        'komentar',
        'foto',
        'no_pesanan',
        'item_pesanan',
        'helpful_count',
        'is_pinned',
        'balasan',
        'balasan_at',
    ];

    protected $casts = [
        'item_pesanan'  => 'array',
        'is_pinned'     => 'boolean',
        'rating'        => 'integer',
        'helpful_count' => 'integer',
        'balasan_at'    => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeTerbaru($query)
    {
        return $query->orderByDesc('is_pinned')->orderByDesc('created_at');
    }

    // Inisial otomatis dari nama kalau kolom 'inisial' kosong.
    public function getInisialAttribute($value): string
    {
        if (! empty($value)) {
            return strtoupper($value);
        }

        $parts = preg_split('/\s+/', trim($this->nama ?? ''));
        $ini   = strtoupper(mb_substr($parts[0] ?? '', 0, 1) . mb_substr($parts[1] ?? '', 0, 1));

        return $ini !== '' ? $ini : 'US';
    }

    public function getSudahDibalasAttribute(): bool
    {
        return ! empty($this->balasan);
    }

    // Dianggap butuh perhatian segera kalau rating rendah dan belum dibalas admin.
    public function getButuhSegeraAttribute(): bool
    {
        return $this->rating <= 3 && ! $this->sudah_dibalas;
    }

    // Ikon kartu ulasan di halaman testimoni user, dipetakan dari kategori/grup.
    public function getIconAttribute(): string
    {
        return match ($this->kategori) {
            'minuman' => 'cup',
            'roti'    => 'cake',
            'goreng'  => 'chef',
            default   => 'fork',
        };
    }
}