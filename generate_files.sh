#!/bin/bash
# ============================================================
# Script untuk membuat semua file sinkronisasi menu admin & user
# Jalankan dari ROOT folder project Laravel kamu:
#   bash generate_files.sh
# ============================================================
set -e

mkdir -p database/migrations
mkdir -p database/seeders
mkdir -p app/Models
mkdir -p app/Http/Controllers/Admin
mkdir -p resources/views/admin

echo '-> Membuat database/migrations/2026_09_22_000000_create_products_table.php'
cat > "database/migrations/2026_09_22_000000_create_products_table.php" << 'FILE_EOF'
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // dipakai di URL /produklogin?p=slug DAN sebagai key data di menulogin.blade.php
            $table->string('slug')->unique();

            // ===== field yang dipakai halaman USER (menulogin.blade.php) =====
            $table->string('name');                 // nama produk
            $table->text('desc')->nullable();       // deskripsi
            $table->string('cats');                 // 'gurih' | 'manis' | 'minuman'
            $table->string('img')->nullable();      // nama file di public/images
            $table->unsignedInteger('price')->default(0);
            $table->decimal('rating', 2, 1)->default(4.8);
            $table->unsignedInteger('reviews')->default(0);

            // ===== field tambahan yang dipakai halaman ADMIN (menu.blade.php) =====
            $table->string('sku')->nullable();
            $table->unsignedInteger('stock')->default(0);
            $table->boolean('is_hot')->default(false);   // badge "hot/favorit"
            $table->boolean('is_active')->default(true); // status jual (switch di admin)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

FILE_EOF

echo '-> Membuat app/Models/Product.php'
cat > "app/Models/Product.php" << 'FILE_EOF'
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
        'reviews'   => 'integer',
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

FILE_EOF

echo '-> Membuat database/seeders/ProductSeeder.php'
cat > "database/seeders/ProductSeeder.php" << 'FILE_EOF'
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

FILE_EOF

echo '-> Membuat app/Http/Controllers/Admin/MenuController.php'
cat > "app/Http/Controllers/Admin/MenuController.php" << 'FILE_EOF'
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name')->get();

        return view('admin.menu', compact('products'));
    }

    public function create()
    {
        return view('admin.menu-form', [
            'product'    => new Product(),
            'categories' => Product::categoryMeta(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['name']) . '-' . Str::lower(Str::random(4));

        if ($request->hasFile('img')) {
            $data['img'] = $this->storeImage($request->file('img'));
        }

        Product::create($data);

        return redirect('/admin/menu')->with('success', 'Menu baru berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        return view('admin.menu-form', [
            'product'    => $product,
            'categories' => Product::categoryMeta(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validated($request);

        if ($request->hasFile('img')) {
            $this->deleteImage($product->img);
            $data['img'] = $this->storeImage($request->file('img'));
        }

        $product->update($data);

        return redirect('/admin/menu')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $this->deleteImage($product->img);
        $product->delete();

        return back()->with('success', 'Menu berhasil dihapus.');
    }

    // dipanggil dari tombol +/- stepper stok (AJAX) supaya beneran tersimpan
    public function updateStock(Request $request, Product $product)
    {
        $request->validate(['step' => 'required|integer']);

        $product->stock = max(0, $product->stock + $request->integer('step'));
        if ($product->stock === 0) {
            $product->is_active = false;
        }
        $product->save();

        return response()->json([
            'stock'     => $product->stock,
            'is_active' => $product->is_active,
        ]);
    }

    // dipanggil dari switch status jual (AJAX)
    public function toggleStatus(Product $product)
    {
        $product->is_active = ! $product->is_active;
        $product->save();

        return response()->json(['is_active' => $product->is_active]);
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name'   => 'required|string|max:120',
            'desc'   => 'nullable|string|max:500',
            'cats'   => 'required|in:gurih,manis,minuman',
            'price'  => 'required|integer|min:0',
            'sku'    => 'nullable|string|max:30',
            'stock'  => 'required|integer|min:0',
            'img'    => 'nullable|image|max:2048',
        ]);

        // checkbox: kalau tidak dicentang, browser tidak mengirim field-nya sama
        // sekali, jadi harus dibaca manual biar bisa "dimatikan" juga.
        $data['is_hot']    = $request->boolean('is_hot');
        $data['is_active'] = $request->boolean('is_active');

        unset($data['img']); // img ditangani terpisah lewat storeImage()

        return $data;
    }

    private function storeImage($file): string
    {
        $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
            . '.' . $file->getClientOriginalExtension();

        // disimpan di public/images supaya path-nya sama persis dengan yang
        // dipakai menulogin.blade.php: asset('images/' . $p['img'])
        $file->move(public_path('images'), $filename);

        return $filename;
    }

    private function deleteImage(?string $filename): void
    {
        if ($filename && file_exists(public_path('images/' . $filename))) {
            @unlink(public_path('images/' . $filename));
        }
    }
}

FILE_EOF

echo '-> Membuat resources/views/admin/menu.blade.php'
cat > "resources/views/admin/menu.blade.php" << 'FILE_EOF'
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Menu & Stok Jajanan - 2da Store</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg: #fff6ee;
            --card: #ffffff;
            --ink: #1f1410;
            --muted: #6b5d55;
            --brown: #a34a0a;
            --orange: #ff8a3d;
            --orange-soft: #fde3d0;
            --cream: #fdf1e6;
            --green: #6f9b4f;
            --gold: #d6a63a;
            --red: #c0182b;
            --blue: #3d78c9;
            --line: #f1e4d8;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { background: var(--bg); color: var(--ink); font-family: 'Outfit', system-ui, sans-serif; }
        a { text-decoration: none; color: inherit; }
        svg { display: block; }
        button { font-family: inherit; }

        .layout { display: flex; min-height: 100vh; }
        .main { flex: 1; padding: 19px 26px 51px; min-width: 0; }
        .card { background: var(--card); border-radius: 19px; box-shadow: 0 5px 19px rgba(180,110,50,.07); }

        /* ===== HEADER ===== */
        .head { display: flex; justify-content: space-between; align-items: flex-start; margin-top: 6px; gap: 19px; }
        .head h1 { font-size: 24px; font-weight: 600; letter-spacing: -.01em; margin-top: 6px; }
        .head p { color: var(--muted); font-size: 12px; line-height: 1.45; max-width: 380px; margin-top: 5px; }
        .head-actions { display: flex; gap: 11px; }
        .btn { display: flex; align-items: center; justify-content: center; gap: 8px; padding: 12px 20px; border-radius: 11px; font-size: 12.5px; font-weight: 500; border: 0; cursor: pointer; text-align: center; line-height: 1.25; transition: transform .25s, box-shadow .25s, background .25s; }
        .btn:hover { transform: translateY(-2px); }
        .btn-soft { background: #f3e6da; color: var(--muted); }
        .btn-soft:hover { background: #ecd9c8; }
        .btn-orange { background: var(--orange); color: #fff; box-shadow: 0 5px 12px rgba(255,138,61,.35); }
        .btn-orange:hover { box-shadow: 0 8px 16px rgba(255,138,61,.4); }

        /* ===== STATS ===== */
        .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-top: 26px; }
        .stat { padding: 16px 16px 19px; transition: transform .3s, box-shadow .3s; animation: rise .6s ease both; border-radius: 19px; }
        .stat:hover { transform: translateY(-4px); box-shadow: 0 10px 24px rgba(180,110,50,.14); }
        .stat:nth-child(2) { animation-delay: .08s; } .stat:nth-child(3) { animation-delay: .16s; } .stat:nth-child(4) { animation-delay: .24s; }
        .stat-top { display: flex; justify-content: space-between; align-items: center; }
        .sico { width: 35px; height: 35px; border-radius: 11px; display: grid; place-items: center; color: var(--brown); }
        .sico.a { background: #fbe6d8; } .sico.b { background: #fbe9b8; } .sico.c { background: #fdf0c8; } .sico.d { background: #fbe0e0; color: #c0182b; }
        .chip { font-size: 9px; font-weight: 600; padding: 3px 8px; border-radius: 8px; }
        .chip.a { background: #fbe6d8; color: var(--brown); }
        .chip.b { background: #fbedb5; color: #8a5a0a; }
        .chip.c { background: #fdf0c8; color: #8a5a0a; }
        .chip.d { background: #fbdcdc; color: var(--red); }
        .stat .num { font-size: 30px; font-weight: 600; line-height: 1.1; margin-top: 12px; }
        .stat .num.red { color: var(--red); }
        .stat .row { display: flex; justify-content: space-between; align-items: baseline; font-size: 10.5px; margin-top: 2px; }
        .stat .row b { font-weight: 500; }
        .stat .row span { color: var(--muted); }
        .stat .row span.red { color: var(--red); font-weight: 600; }
        .stat .row span.dark { color: var(--ink); font-weight: 600; }
        .prog { height: 5px; border-radius: 4px; background: #f1ece7; margin-top: 9px; overflow: hidden; }
        .prog span { display: block; height: 100%; border-radius: 4px; transform-origin: left; animation: grow 1.2s ease both; transition: width .3s ease; }

        /* ===== FILTER ===== */
        .filter { padding: 16px; margin-top: 26px; }
        .f-top { display: flex; justify-content: space-between; align-items: center; gap: 16px; }
        .f-search { display: flex; align-items: center; gap: 10px; background: #fdf1e6; border-radius: 11px; padding: 10px 13px; width: 512px; max-width: 100%; color: var(--muted); }
        .f-search input { border: 0; outline: 0; background: transparent; font: inherit; font-size: 12px; width: 100%; color: var(--ink); }
        .f-search input::placeholder { color: #a99b92; }
        .f-count { font-size: 10.5px; font-weight: 500; padding-right: 10px; border-right: 1px solid var(--line); white-space: nowrap; }
        .f-row { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
        .f-label { font-size: 9.5px; font-weight: 600; letter-spacing: .05em; color: var(--muted); margin-right: 4px; }
        .f-title { display: flex; justify-content: space-between; margin-top: 18px; }
        .f-title small { font-size: 9.5px; font-weight: 400; color: var(--muted); letter-spacing: 0; }
        .fchip { border: 0; background: #fdf1e6; font-size: 9.5px; font-weight: 500; padding: 6px 13px; border-radius: 16px; display: flex; align-items: center; gap: 5px; color: var(--ink); cursor: pointer; transition: background .2s, transform .2s; }
        .fchip:hover { background: #fae4d0; transform: translateY(-1px); }
        .fchip.active { background: #7a5346; color: #fff; font-weight: 600; }
        .fchip.soft-active { background: #f3e6da; font-weight: 600; }
        .fchip i { width: 6px; height: 6px; border-radius: 50%; display: inline-block; }
        .f-status { margin-top: 14px; }

        /* ===== TABLE ===== */
        .list { margin-top: 26px; border-radius: 19px; overflow: hidden; background: #fff; box-shadow: 0 5px 19px rgba(180,110,50,.07); }
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        thead th { background: #fbeadb; font-size: 9.5px; font-weight: 600; letter-spacing: .06em; color: var(--muted); padding: 16px 10px; text-align: center; line-height: 1.4; }
        thead th:first-child { text-align: left; padding-left: 24px; }
        thead th:nth-child(1) { width: 30%; }
        thead th:nth-child(2) { width: 13%; }
        thead th:nth-child(3) { width: 12%; }
        thead th:nth-child(4) { width: 20%; }
        thead th:nth-child(5) { width: 13%; }
        thead th:nth-child(6) { width: 12%; }
        tbody tr { transition: background .2s; animation: rise .5s ease both; }
        tbody tr:hover { background: #fffaf5; }
        tbody tr.hidden { display: none !important; }
        tbody td { padding: 14px 10px; border-bottom: 1px solid var(--line); text-align: center; vertical-align: middle; }
        tbody td:first-child { text-align: left; padding-left: 24px; }
        .prod { display: flex; align-items: center; gap: 12px; }
        .thumb { width: 45px; height: 45px; border-radius: 11px; background: #f5ebe0; overflow: hidden; flex-shrink: 0; }
        .thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .prod strong { display: block; font-size: 13px; font-weight: 600; }
        .prod .desc-mini { display: block; font-size: 10.5px; color: var(--muted); margin-top: 2px; max-width: 260px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .sku { display: flex; align-items: center; gap: 8px; margin-top: 3px; font-size: 10px; }
        .sku b { font-size: 9px; font-weight: 700; color: var(--brown); background: #fbe6d8; padding: 2px 7px; border-radius: 4px; }
        .sku span { color: var(--muted); }
        .sku span.hot { color: var(--brown); font-weight: 500; }
        .cat { display: inline-flex; align-items: center; gap: 6px; font-size: 9.5px; font-weight: 500; line-height: 1.25; text-align: left; padding: 6px 13px; border-radius: 14px; background: #fbe6d8; color: var(--muted); }
        .cat.manis { background: #fbedb5; color: #7a4a0a; }
        .cat.minuman { background: #dbe9fa; color: #2f5c9c; }
        .price strong { display: block; font-size: 15px; font-weight: 600; line-height: 1.2; }
        .price small { display: block; font-size: 9.5px; color: var(--muted); margin-top: 3px; line-height: 1.4; }
        .stepper { display: inline-flex; align-items: center; background: #fdf1e6; border-radius: 12px; padding: 4px; gap: 10px; box-shadow: inset 0 0 0 2px #fbeadb; }
        .stepper button { width: 24px; height: 24px; border-radius: 8px; border: 0; background: #fff; font-size: 13px; color: var(--ink); cursor: pointer; display: grid; place-items: center; transition: background .2s, transform .2s; }
        .stepper button:hover { background: #fae4d0; transform: scale(1.08); }
        .stepper .qty { min-width: 22px; text-align: center; font-size: 13px; font-weight: 500; }
        .stepper.low .qty { color: var(--brown); }
        .stepper.empty .qty { color: var(--red); font-weight: 700; }
        .stock-badge { display: inline-flex; align-items: center; gap: 5px; margin-top: 6px; font-size: 9px; font-weight: 500; padding: 3px 10px; border-radius: 10px; background: #edf3e6; color: #4a6a2a; }
        .stock-badge i { width: 5px; height: 5px; border-radius: 50%; background: var(--green); }
        .stock-badge.warn { background: #fdf0c8; color: #8a5a0a; }
        .stock-badge.warn i { background: #f5b731; }
        .stock-badge.danger { background: #fbdcdc; color: var(--red); }
        .stock-badge.danger i { background: var(--red); }
        .stock-box { display: flex; flex-direction: column; align-items: center; }
        .sw { display: flex; flex-direction: column; align-items: center; gap: 6px; font-size: 9.5px; color: var(--muted); }
        .switch { position: relative; width: 34px; height: 21px; border-radius: 12px; background: var(--green); border: 0; cursor: pointer; transition: background .25s; }
        .switch::after { content: ''; position: absolute; top: 2px; right: 2px; width: 17px; height: 17px; border-radius: 50%; background: #fff; transition: right .25s; }
        .switch.off { background: #d8ccc3; }
        .switch.off::after { right: 15px; }
        .actions { display: flex; justify-content: center; gap: 16px; color: var(--muted); }
        .actions a, .actions button { background: none; border: 0; color: inherit; cursor: pointer; transition: color .2s, transform .2s; }
        .actions a:hover { color: var(--brown); transform: translateY(-2px); }
        .actions button:hover { color: var(--red); transform: translateY(-2px); }

        .list-foot { display: flex; justify-content: space-between; align-items: center; background: #fdf1e6; padding: 13px 13px; font-size: 10px; color: var(--muted); }
        .list-foot .left { display: flex; align-items: center; gap: 8px; }
        .list-foot .sel { background: #fff; color: var(--ink); font-weight: 600; padding: 5px 13px; border-radius: 8px; min-width: 80px; }
        .pager { display: flex; gap: 6px; align-items: center; }
        .pager span { min-width: 26px; height: 26px; border-radius: 8px; background: #fff; font-size: 10px; font-weight: 600; color: var(--ink); display: grid; place-items: center; padding: 0 10px; cursor: pointer; transition: background .2s; }
        .pager span:hover { background: #fae4d0; }
        .pager span.on { background: var(--orange); color: #fff; }
        .pager span.dis { background: transparent; color: #a99b92; font-weight: 500; cursor: default; }

        .no-data { text-align: center; padding: 30px !important; color: var(--muted); font-size: 13px; font-weight: 500; }
        .flash { margin-top: 20px; padding: 12px 18px; border-radius: 12px; background: #e9f3e0; color: #3f6a26; font-size: 12.5px; font-weight: 500; }

        /* ===== ANIMASI ===== */
        @keyframes rise { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: none; } }
        @keyframes grow { from { transform: scaleX(0); } to { transform: scaleX(1); } }
        tbody tr:nth-child(2) { animation-delay: .05s; } tbody tr:nth-child(3) { animation-delay: .1s; } tbody tr:nth-child(4) { animation-delay: .15s; }
        tbody tr:nth-child(5) { animation-delay: .2s; } tbody tr:nth-child(6) { animation-delay: .25s; } tbody tr:nth-child(7) { animation-delay: .3s; }

        @media (max-width: 1100px) {
            .stats { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 800px) {
            .head { flex-direction: column; }
            .list { overflow-x: auto; }
            .f-top { flex-direction: column; align-items: stretch; }
        }
    </style>
</head>
<body>
@php
    // Data sekarang datang dari database (tabel products), bukan array statis lagi.
    // $products dikirim dari App\Http\Controllers\Admin\MenuController@index

    $categoryMeta = \App\Models\Product::categoryMeta();

    $total       = $products->count();
    $lowCount    = $products->where('stock', '>', 0)->where('stock', '<', 10)->count();
    $emptyCount  = $products->where('stock', 0)->count();
    $catCounts   = $products->groupBy('cats')->map->count();
    $activeCats  = collect($categoryMeta)->filter(fn ($m, $key) => ($catCounts[$key] ?? 0) > 0)->count();
@endphp

<div class="layout">

    @include('partials.sidebaradmin')

    <main class="main">

        @include('partials.navbaradmin')

        <div class="head">
            <div>
                <h1>Kelola Menu &amp; Stok Jajanan</h1>
                <p>Atur varian produk, harga jual, deskripsi, foto, serta kendalikan ketersediaan stok gerai secara instan. Data di sini otomatis muncul di halaman menu pelanggan.</p>
            </div>
            <div class="head-actions">
                <a href="{{ url('/admin/kategori') }}" class="btn btn-soft">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3l4 7H8z"/><rect x="3" y="14" width="7" height="7" rx="1"/><circle cx="17.5" cy="17.5" r="3.5"/></svg>
                    Kelola<br>Kategori
                </a>
                <a href="{{ url('/admin/menu/tambah') }}" class="btn btn-orange">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 8v8M8 12h8"/></svg>
                    Tambah Menu<br>Baru
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="flash">{{ session('success') }}</div>
        @endif

        {{-- ===== STATISTIK ===== --}}
        <section class="stats">
            <div class="card stat">
                <div class="stat-top">
                    <div class="sico a"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 10a8 5 0 0116 0z"/><path d="M4 14h16M5 18h14"/></svg></div>
                </div>
                <div class="num" id="stat-total">{{ $total }}</div>
                <div class="row"><b>Total Menu Aktif</b><span id="stat-total-label">{{ $total }} Terdaftar</span></div>
                <div class="prog"><span style="width:100%; background:var(--orange)"></span></div>
            </div>
            <div class="card stat">
                <div class="stat-top">
                    <div class="sico b"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M4 12h16M12 3v18"/></svg></div>
                    <span class="chip b">{{ $activeCats }} Grup Aktif</span>
                </div>
                <div class="num">{{ count($categoryMeta) }}</div>
                <div class="row"><b>Kategori Menu</b><span>{{ $activeCats }} / {{ count($categoryMeta) }} Terisi</span></div>
                <div class="prog"><span style="width:{{ count($categoryMeta) ? round($activeCats / count($categoryMeta) * 100) : 0 }}%; background:var(--gold)"></span></div>
            </div>
            <div class="card stat">
                <div class="stat-top">
                    <div class="sico c"><svg width="19" height="19" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M12 3l10 18H2z"/><path d="M12 10v4M12 17v1" stroke="#fdf0c8" stroke-width="2"/></svg></div>
                    <span class="chip c">Segera Restok</span>
                </div>
                <div class="num" id="stat-low">{{ $lowCount }}</div>
                <div class="row"><b>Stok Menipis</b><span class="dark">&lt; 10 Porsi</span></div>
                <div class="prog"><span id="stat-low-bar" style="width:{{ $total ? round($lowCount / $total * 100) : 0 }}%; background:#f5b731"></span></div>
            </div>
            <div class="card stat">
                <div class="stat-top">
                    <div class="sico d"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 4h3l2.5 11h9L20 7H7"/><circle cx="10" cy="19" r="1.5"/><circle cx="17" cy="19" r="1.5"/></svg></div>
                    <span class="chip d">Perlu Tindakan</span>
                </div>
                <div class="num red" id="stat-empty">{{ $emptyCount }}</div>
                <div class="row"><b>Menu Habis ({{ $emptyCount }})</b><span class="red">Dapur Kosong</span></div>
                <div class="prog"><span id="stat-empty-bar" style="width:{{ $total ? round($emptyCount / $total * 100) : 0 }}%; background:var(--red)"></span></div>
            </div>
        </section>

        {{-- ===== FILTER ===== --}}
        <section class="card filter">
            <div class="f-top">
                <label class="f-search">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M20 20l-4-4"/></svg>
                    <input type="text" id="searchInput" placeholder="Cari nama jajanan, deskripsi, atau kode SKU...">
                </label>
                <span class="f-count" id="filterCount">Menampilkan {{ $total }} dari {{ $total }} Item</span>
            </div>

            <div class="f-title">
                <span class="f-label">KATEGORI MENU:</span>
                <small>Pilih untuk menyaring</small>
            </div>
            <div class="f-row f-category" style="margin-top:2px">
                <button class="fchip active" data-cat="all">Semua ({{ $total }})</button>
                @foreach ($categoryMeta as $key => $meta)
                    <button class="fchip" data-cat="{{ $key }}">{{ $meta['icon'] }} {{ $meta['label'] }} ({{ $catCounts[$key] ?? 0 }})</button>
                @endforeach
            </div>

            <div class="f-row f-status">
                <button class="fchip soft-active" data-status="all">Semua Status</button>
                <button class="fchip" data-status="available"><i style="background:var(--green)"></i>Tersedia</button>
                <button class="fchip" data-status="low"><i style="background:#f5b731"></i>Menipis</button>
                <button class="fchip" data-status="empty"><i style="background:var(--red)"></i>Habis ({{ $emptyCount }})</button>
            </div>
        </section>

        {{-- ===== TABEL MENU ===== --}}
        <section class="list">
            <table>
                <thead>
                    <tr>
                        <th>PRODUK / SKU</th>
                        <th>KATEGORI</th>
                        <th>HARGA<br>JUAL</th>
                        <th>KELOLA STOK<br>REALTIME</th>
                        <th>STATUS<br>JUAL</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody id="menuTableBody">
                    @foreach ($products as $p)
                        <tr data-id="{{ $p->id }}" data-category="{{ $p->cats }}">
                            <td>
                                <div class="prod">
                                    <div class="thumb"><img src="{{ $p->img_url }}" alt="{{ $p->name }}" loading="lazy"></div>
                                    <div>
                                        <strong class="item-nama">{{ $p->name }}</strong>
                                        <span class="desc-mini">{{ $p->desc }}</span>
                                        <div class="sku">
                                            <b class="item-sku">SKU: {{ $p->sku ?? '—' }}</b>
                                            <span class="{{ $p->is_hot ? 'hot' : '' }}">{{ $p->is_hot ? 'Favorit' : '' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="cat {{ $p->category_class }}"><span>{{ $p->category_icon }}</span><span class="cat-text">{!! str_replace(' ', '<br>', e($p->category_label)) !!}</span></span></td>
                            <td>
                                <div class="price">
                                    <strong>Rp<br>{{ number_format($p->price, 0, ',', '.') }}</strong>
                                </div>
                            </td>
                            <td>
                                <div class="stock-box">
                                    <div class="stepper {{ $p->stock == 0 ? 'empty' : ($p->stock < 10 ? 'low' : '') }}">
                                        <button type="button" data-step="-1" aria-label="Kurangi stok">−</button>
                                        <span class="qty">{{ $p->stock }}</span>
                                        <button type="button" data-step="1" aria-label="Tambah stok">+</button>
                                    </div>
                                    <span class="stock-badge {{ $p->stock == 0 ? 'danger' : ($p->stock < 10 ? 'warn' : '') }}">
                                        <i></i>
                                        <em style="font-style:normal">
                                            @if($p->stock == 0)
                                                Stok Habis
                                            @elseif($p->stock < 10)
                                                Menipis: {{ $p->stock }} Porsi
                                            @else
                                                Tersedia ({{ $p->stock }})
                                            @endif
                                        </em>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="sw">
                                    <button type="button" class="switch {{ !$p->is_active ? 'off' : '' }}" aria-label="Status jual"></button>
                                    <span class="sw-label">{{ $p->is_active ? 'Tersedia' : 'Nonaktif' }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="{{ url('/admin/menu/'.$p->id.'/edit') }}" aria-label="Ubah menu">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h12M3 11h8M3 16h6"/><path d="M14 20l1-4 6-6 3 3-6 6z" transform="translate(-2 -1)"/></svg>
                                    </a>
                                    <form action="{{ url('/admin/menu/'.$p->id) }}" method="POST" onsubmit="return confirm('Hapus menu ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" aria-label="Hapus menu">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7h16M9 7V4h6v3M6 7l1 13h10l1-13"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    <tr id="noDataRow" class="hidden">
                        <td colspan="6" class="no-data">Tidak ada menu yang sesuai dengan pencarian / filter.</td>
                    </tr>
                </tbody>
            </table>

            <div class="list-foot">
                <div class="left">
                    <span>Baris per halaman:</span>
                    <span class="sel">10 item</span>
                    <span style="margin-left:8px" id="footCount">{{ $total ? '1 - '.$total : '0' }} dari {{ $total }} menu</span>
                </div>
                <div class="pager">
                    <span class="dis">Sebelumnya</span><span class="on">1</span><span class="dis">Berikutnya</span>
                </div>
            </div>
        </section>

    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    var rows = Array.from(document.querySelectorAll('#menuTableBody tr[data-id]'));
    var totalCount = rows.length;

    var searchInput = document.getElementById('searchInput');
    var filterCountEl = document.getElementById('filterCount');
    var footCountEl = document.getElementById('footCount');
    var noDataRow = document.getElementById('noDataRow');

    var selectedCategory = 'all';
    var selectedStatus = 'all';

    function updateStats() {
        var lowCount = 0;
        var emptyCount = 0;

        rows.forEach(function (row) {
            var qty = parseInt(row.querySelector('.qty').textContent, 10);
            if (qty === 0) emptyCount++;
            else if (qty < 10) lowCount++;
        });

        document.getElementById('stat-low').textContent = lowCount;
        document.getElementById('stat-empty').textContent = emptyCount;

        var lowPct = totalCount ? Math.round((lowCount / totalCount) * 100) : 0;
        var emptyPct = totalCount ? Math.round((emptyCount / totalCount) * 100) : 0;

        document.getElementById('stat-low-bar').style.width = lowPct + '%';
        document.getElementById('stat-empty-bar').style.width = emptyPct + '%';
    }

    function applyFilter() {
        var query = searchInput.value.toLowerCase().trim();
        var visibleCount = 0;

        rows.forEach(function (row) {
            var nama = row.querySelector('.item-nama').textContent.toLowerCase();
            var desc = row.querySelector('.desc-mini').textContent.toLowerCase();
            var sku = row.querySelector('.item-sku').textContent.toLowerCase();
            var category = row.getAttribute('data-category');
            var qty = parseInt(row.querySelector('.qty').textContent, 10);

            var matchSearch = nama.includes(query) || desc.includes(query) || sku.includes(query);
            var matchCategory = (selectedCategory === 'all') || (category === selectedCategory);

            var matchStatus = false;
            if (selectedStatus === 'all') matchStatus = true;
            else if (selectedStatus === 'available') matchStatus = qty >= 10;
            else if (selectedStatus === 'low') matchStatus = qty > 0 && qty < 10;
            else if (selectedStatus === 'empty') matchStatus = qty === 0;

            var show = matchSearch && matchCategory && matchStatus;
            row.classList.toggle('hidden', !show);
            if (show) visibleCount++;
        });

        noDataRow.classList.toggle('hidden', visibleCount !== 0);
        filterCountEl.textContent = 'Menampilkan ' + visibleCount + ' dari ' + totalCount + ' Item';
        footCountEl.textContent = (visibleCount > 0 ? '1 - ' + visibleCount : '0') + ' dari ' + totalCount + ' menu';

        updateStats();
    }

    searchInput.addEventListener('input', applyFilter);

    document.querySelectorAll('.f-category .fchip').forEach(function (chip) {
        chip.addEventListener('click', function () {
            document.querySelectorAll('.f-category .fchip').forEach(function (c) { c.classList.remove('active'); });
            chip.classList.add('active');
            selectedCategory = chip.getAttribute('data-cat');
            applyFilter();
        });
    });

    document.querySelectorAll('.f-status .fchip').forEach(function (chip) {
        chip.addEventListener('click', function () {
            document.querySelectorAll('.f-status .fchip').forEach(function (c) { c.classList.remove('soft-active'); });
            chip.classList.add('soft-active');
            selectedStatus = chip.getAttribute('data-status');
            applyFilter();
        });
    });

    // Stepper stok & switch status -> sekarang beneran disimpan ke server (AJAX)
    rows.forEach(function (row) {
        var productId = row.getAttribute('data-id');
        var stepper = row.querySelector('.stepper');
        var qtyEl = row.querySelector('.qty');
        var badge = row.querySelector('.stock-badge');
        var label = badge.querySelector('em');
        var sw = row.querySelector('.switch');
        var swLabel = row.querySelector('.sw-label');

        function renderStockUI(n, isActive) {
            stepper.classList.remove('low', 'empty');
            badge.classList.remove('warn', 'danger');

            if (n === 0) {
                stepper.classList.add('empty');
                badge.classList.add('danger');
                label.textContent = 'Stok Habis';
            } else if (n < 10) {
                stepper.classList.add('low');
                badge.classList.add('warn');
                label.textContent = 'Menipis: ' + n + ' Porsi';
            } else {
                label.textContent = 'Tersedia (' + n + ')';
            }

            sw.classList.toggle('off', !isActive);
            swLabel.textContent = isActive ? 'Tersedia' : 'Nonaktif';
        }

        row.querySelectorAll('.stepper button').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                var step = parseInt(btn.dataset.step, 10);

                fetch('/admin/menu/' + productId + '/stock', {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ step: step }),
                })
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    qtyEl.textContent = data.stock;
                    renderStockUI(data.stock, data.is_active);
                    applyFilter();
                })
                .catch(function () { alert('Gagal menyimpan perubahan stok. Coba lagi.'); });
            });
        });

        sw.addEventListener('click', function () {
            fetch('/admin/menu/' + productId + '/status', {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
            })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                sw.classList.toggle('off', !data.is_active);
                swLabel.textContent = data.is_active ? 'Tersedia' : 'Nonaktif';
            })
            .catch(function () { alert('Gagal menyimpan status jual. Coba lagi.'); });
        });
    });

    updateStats();
});
</script>
</body>
</html>

FILE_EOF

echo '-> Membuat resources/views/admin/menu-form.blade.php'
cat > "resources/views/admin/menu-form.blade.php" << 'FILE_EOF'
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product->exists ? 'Ubah Menu' : 'Tambah Menu' }} - 2da Store</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #fff6ee; --card: #ffffff; --ink: #1f1410; --muted: #6b5d55;
            --brown: #a34a0a; --orange: #ff8a3d; --cream: #fdf1e6; --red: #c0182b; --line: #f1e4d8;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background: var(--bg); color: var(--ink); font-family: 'Outfit', system-ui, sans-serif; }
        .wrap { max-width: 720px; margin: 40px auto; padding: 0 20px 60px; }
        .card { background: var(--card); border-radius: 19px; box-shadow: 0 5px 19px rgba(180,110,50,.07); padding: 28px 30px; }
        h1 { font-size: 22px; font-weight: 600; margin-bottom: 6px; }
        .sub { color: var(--muted); font-size: 12.5px; margin-bottom: 24px; }
        label { display: block; font-size: 11.5px; font-weight: 600; color: var(--muted); margin: 18px 0 6px; letter-spacing: .02em; }
        input[type=text], input[type=number], textarea, select {
            width: 100%; border: 1px solid var(--line); background: var(--cream); border-radius: 10px;
            padding: 11px 14px; font: inherit; font-size: 13px; color: var(--ink);
        }
        textarea { resize: vertical; min-height: 80px; }
        .row2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .check { display: flex; align-items: center; gap: 8px; margin-top: 16px; font-size: 12.5px; }
        .check input { width: auto; }
        .img-preview { width: 110px; height: 110px; border-radius: 12px; object-fit: cover; background: #f5ebe0; margin-top: 10px; display: block; }
        .err { color: var(--red); font-size: 11px; margin-top: 4px; }
        .actions { display: flex; gap: 12px; margin-top: 28px; }
        .btn { flex: 1; padding: 13px; border-radius: 11px; border: 0; font-size: 13px; font-weight: 600; cursor: pointer; text-align: center; }
        .btn-orange { background: var(--orange); color: #fff; }
        .btn-soft { background: #f3e6da; color: var(--muted); }
    </style>
</head>
<body>
<div class="wrap">
    <div class="card">
        <h1>{{ $product->exists ? 'Ubah Menu' : 'Tambah Menu Baru' }}</h1>
        <p class="sub">Field ini yang dipakai juga di halaman menu pelanggan: nama, deskripsi, gambar, harga &amp; kategori.</p>

        @if ($errors->any())
            <div class="err">
                <ul style="padding-left:16px">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ $product->exists ? url('/admin/menu/'.$product->id) : url('/admin/menu') }}"
              method="POST" enctype="multipart/form-data">
            @csrf
            @if ($product->exists) @method('PUT') @endif

            <label for="name">Nama Produk</label>
            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required>

            <label for="desc">Deskripsi</label>
            <textarea id="desc" name="desc">{{ old('desc', $product->desc) }}</textarea>

            <div class="row2">
                <div>
                    <label for="cats">Kategori</label>
                    <select id="cats" name="cats" required>
                        @foreach ($categories as $key => $meta)
                            <option value="{{ $key }}" {{ old('cats', $product->cats) === $key ? 'selected' : '' }}>
                                {{ $meta['icon'] }} {{ $meta['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="price">Harga Jual (Rp)</label>
                    <input type="number" id="price" name="price" min="0" value="{{ old('price', $product->price) }}" required>
                </div>
            </div>

            <div class="row2">
                <div>
                    <label for="sku">SKU (opsional)</label>
                    <input type="text" id="sku" name="sku" value="{{ old('sku', $product->sku) }}">
                </div>
                <div>
                    <label for="stock">Stok Awal</label>
                    <input type="number" id="stock" name="stock" min="0" value="{{ old('stock', $product->stock ?? 0) }}" required>
                </div>
            </div>

            <label for="img">Foto Produk</label>
            <input type="file" id="img" name="img" accept="image/*" onchange="previewImg(this)">
            <img id="imgPreview" class="img-preview"
                 src="{{ $product->exists && $product->img ? $product->img_url : '' }}"
                 style="{{ $product->exists && $product->img ? '' : 'display:none' }}">

            <div class="check">
                <input type="checkbox" id="is_hot" name="is_hot" value="1" {{ old('is_hot', $product->is_hot) ? 'checked' : '' }}>
                <label for="is_hot" style="margin:0">Tandai sebagai menu favorit / pedas (badge "Hot")</label>
            </div>
            <div class="check">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $product->exists ? $product->is_active : true) ? 'checked' : '' }}>
                <label for="is_active" style="margin:0">Tampilkan &amp; jual di halaman menu pelanggan</label>
            </div>

            <div class="actions">
                <a href="{{ url('/admin/menu') }}" class="btn btn-soft">Batal</a>
                <button type="submit" class="btn btn-orange">{{ $product->exists ? 'Simpan Perubahan' : 'Tambah Menu' }}</button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImg(input) {
        var preview = document.getElementById('imgPreview');
        if (input.files && input.files[0]) {
            preview.src = URL.createObjectURL(input.files[0]);
            preview.style.display = 'block';
        }
    }
</script>
</body>
</html>

FILE_EOF

echo ""
echo "Semua file berhasil dibuat."
echo ""
echo "Langkah selanjutnya:"
echo "1. Tambahkan isi routes_addition.php ke routes/web.php (lihat file terpisah)"
echo "2. php artisan migrate"
echo "3. php artisan db:seed --class=ProductSeeder"
