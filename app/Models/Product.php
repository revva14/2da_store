<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug', 'name', 'desc', 'cats', 'img',
        'price', 'rating', 'reviews',
        'sku', 'stock', 'is_hot', 'is_active',
    ];

    protected $casts = [
        'price'     => 'integer',
        'rating'    => 'float',
        'stock'     => 'integer',
        'is_hot'    => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Satu-satunya tempat mapping kategori -> label & ikon.
     * Dipakai baik di menu.blade.php (admin) maupun bisa dipakai
     * ulang di menulogin.blade.php kalau nanti perlu.
     */
    public static function categoryMeta(): array
    {
        return [
            'gurih'   => ['label' => 'Makanan Gurih', 'icon' => '🥐', 'class' => ''],
            'manis'   => ['label' => 'Makanan Manis', 'icon' => '🥞', 'class' => 'manis'],
            'minuman' => ['label' => 'Minuman',        'icon' => '🥤', 'class' => 'minuman'],
        ];
    }

    public function getCategoryLabelAttribute(): string
    {
        return self::categoryMeta()[$this->cats]['label'] ?? ucfirst($this->cats);
    }

    public function getCategoryIconAttribute(): string
    {
        return self::categoryMeta()[$this->cats]['icon'] ?? '🍽️';
    }

    public function getCategoryClassAttribute(): string
    {
        return self::categoryMeta()[$this->cats]['class'] ?? '';
    }

    // dipakai di admin (thumbnail) & bisa dipakai ulang di menulogin.blade.php
    public function getImgUrlAttribute(): string
    {
        return $this->img
            ? asset('images/' . $this->img)
            : asset('images/placeholder-menu.png');
    }

    public function getStockStatusAttribute(): string
    {
        if ($this->stock === 0) return 'empty';
        if ($this->stock < 10) return 'low';
        return 'ok';
    }
}