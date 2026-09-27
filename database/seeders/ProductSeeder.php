<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Menarik data yang SUDAH ADA di config/menu.php supaya
     * halaman user (menulogin.blade.php) tidak kehilangan data
     * saat kita pindah ke tabel products.
     *
     * Field yang tidak ada di config (sku, stock, is_hot) diberi
     * nilai default aman — silakan lengkapi lewat halaman admin
     * setelah migrasi selesai.
     */
    public function run(): void
    {
        $configProducts = config('menu', []);

        if (empty($configProducts)) {
            $this->command->warn('config/menu.php kosong atau tidak ditemukan — tidak ada data yang di-seed. Tambahkan menu manual lewat halaman admin.');
            return;
        }

        foreach ($configProducts as $slug => $p) {
            // config lama bisa punya 'cats' berisi lebih dari satu token
            // (mis. "gurih semua") -> ambil token kategori utama yang valid
            $validCats  = array_keys(Product::categoryMeta());
            $catsTokens = explode(' ', $p['cats'] ?? 'gurih');
            $mainCat    = collect($catsTokens)->first(fn ($c) => in_array($c, $validCats, true)) ?? 'gurih';

            Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'name'      => $p['name'] ?? $slug,
                    'desc'      => $p['desc'] ?? '',
                    'cats'      => $mainCat,
                    'img'       => $p['img'] ?? null,
                    'price'     => $p['price'] ?? 0,
                    'rating'    => $p['rating'] ?? 4.8,
                    'reviews'   => $p['reviews'] ?? 0,
                    'sku'       => null,
                    'stock'     => 20,
                    'is_hot'    => false,
                    'is_active' => true,
                ]
            );
        }

        $this->command->info(count($configProducts) . ' produk berhasil dipindahkan dari config/menu.php ke tabel products.');
    }
}

