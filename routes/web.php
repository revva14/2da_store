<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\UlasanController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\MidtransController;


/*
|--------------------------------------------------------------------------
| PRODUK
|--------------------------------------------------------------------------
*/

Route::resource('produk', ProdukController::class);


/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('beranda');
});


/*
|--------------------------------------------------------------------------
| BAHASA
|--------------------------------------------------------------------------
*/

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session(['locale' => $locale]);
    }

    return back();
})->name('lang.switch');


/*
|--------------------------------------------------------------------------
| BEFORE LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/beranda', [BerandaController::class, 'index'])
    ->name('beranda');

Route::get('/produk', fn () => view('produk'))
    ->name('produk');

Route::get('/menu', fn () => view('menu'))
    ->name('menu');

Route::get('/navbarlogin', fn () => view('navbarlogin'))
    ->name('navbarlogin');

Route::get('/testimoni', [TestimoniController::class, 'index'])
    ->name('testimoni');

Route::post('/testimoni/{ulasan}/membantu', [TestimoniController::class, 'membantu'])
    ->name('testimoni.membantu');

Route::get('/cara-pesan', fn () => view('cara-pesan'))
    ->name('cara-pesan');

Route::get('/tentang', fn () => view('tentang'))
    ->name('tentang');

Route::get('/hubungi', fn () => view('hubungi'))
    ->name('hubungi');


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/registrasi', [AuthController::class, 'showRegisterForm'])
        ->name('register');

    Route::post('/registrasi', [AuthController::class, 'register']);

    Route::get('/lupa-password', function () {
        return back()->with(
            'info',
            'Fitur reset kata sandi masih dalam pengembangan.'
        );
    })->name('password.request');
});


/*
|--------------------------------------------------------------------------
| WEBHOOK MIDTRANS
|
| Dipanggil oleh server Midtrans (bukan user yang login), jadi TIDAK
| pakai middleware 'auth' -- keamanannya sudah lewat verifikasi
| signature_key di dalam MidtransController::notification().
|--------------------------------------------------------------------------
*/

Route::post('/midtrans/notification', [MidtransController::class, 'notification'])
    ->name('midtrans.notification');


/*
|--------------------------------------------------------------------------
| AFTER LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

Route::get('/berandalogin', fn () => view('berandalogin'))
    ->name('berandalogin');

Route::get('/menulogin', fn () => view('menulogin'))
    ->name('menulogin');

Route::get('/produklogin', fn () => view('produklogin'))
    ->name('produklogin');

Route::get('/cara-pesanlogin', fn () => view('cara-pesanlogin'))
    ->name('cara-pesanlogin');

Route::get('/testimonilogin', [TestimoniController::class, 'indexLogin'])
    ->name('testimonilogin');

Route::get('/tentanglogin', fn () => view('tentanglogin'))
    ->name('tentanglogin');

Route::get('/hubungilogin', fn () => view('hubungilogin'))
    ->name('hubungilogin');


/*
|--------------------------------------------------------------------------
| PESANAN / CHECKOUT
|--------------------------------------------------------------------------
*/

Route::get('/pesanan', fn () => view('pesanan'))
    ->name('pesanan');

Route::post('/pesanan', [PesananController::class, 'store'])
    ->name('pesanan.store');

Route::post('/midtrans/token', [MidtransController::class, 'getSnapToken'])
    ->name('midtrans.token');

/*
|--------------------------------------------------------------------------
| KERANJANG
|--------------------------------------------------------------------------
*/

Route::get('/tambah-keranjang', fn () => view('tambah-keranjang'))
    ->name('tambah-keranjang');

Route::get('/keranjang', fn () => view('keranjang'))
    ->name('keranjang');

Route::get('/cart-script', fn () => view('cart-script'))
    ->name('cart-script');


/*
|--------------------------------------------------------------------------
| AKUN
|--------------------------------------------------------------------------
*/

Route::get('/biodata', [AkunController::class, 'biodata'])
    ->name('biodata');

Route::put('/biodata', [AkunController::class, 'updateBiodata'])
    ->name('biodata.update');

Route::get('/riwayat', function () {
    $orders = collect([
 
        // 1) SEDANG DIANTAR — mirip contoh #2DA-89211
        (object) [
            'kode_pesanan'      => '2DA-89211',
            'no_pesanan'        => 'INV-20261023-089211',
            'no_invoice'        => 'INV/20261023/2DA/89211',
            'status'            => 'antar',
            'created_at'        => \Carbon\Carbon::now()->setTime(11, 20),
            'lokasi_label'      => 'Rumah Tinggal',
            'alamat'            => 'Tebet Barat Dalam VI',
            'total'             => 25000,
            'metode_pembayaran' => 'qris',
            'payment_status'    => 'settlement',
            'metode_pengiriman' => 'Kurir 2DA Store',
            'kurir'             => (object) [
                'nama'      => 'Kang Rahmat',
                'kendaraan' => 'Honda Vario',
                'estimasi'  => '8 mnt lagi',
            ],
            'rating'            => null,
            'catatan_status'    => null,
            'items'             => collect([
                (object) ['qty' => 2, 'nama_produk' => 'Corndog Mini Mozzarella', 'catatan' => 'Saos Sambal & Mayo Gerih'],
                (object) ['qty' => 1, 'nama_produk' => 'Cireng Isi Mini', 'catatan' => 'Bumbu Tabur Pedas'],
            ]),
        ],
 
        // 2) SELESAI & SUDAH DINILAI — mirip contoh #2DA-87104
        (object) [
            'kode_pesanan'      => '2DA-87104',
            'no_pesanan'        => 'INV-20261022-087104',
            'no_invoice'        => 'INV/20261022/2DA/87104',
            'status'            => 'selesai',
            'created_at'        => \Carbon\Carbon::yesterday()->setTime(14, 15),
            'lokasi_label'      => 'Kantor Menara Karya (Studio)',
            'alamat'            => 'Kantor Menara Karya',
            'total'             => 35000,
            'metode_pembayaran' => 'qris',
            'payment_status'    => 'settlement',
            'metode_pengiriman' => 'Kurir 2DA Store',
            'kurir'             => null,
            'rating'            => (object) [
                'nilai' => 5.0,
                'label' => 'Sangat Lezat',
            ],
            'catatan_status'    => 'Pesanan diterima resepsionis',
            'items'             => collect([
                (object) ['qty' => 2, 'nama_produk' => 'Corndog Mini Mozzarella', 'catatan' => 'Saus Sambal'],
                (object) ['qty' => 1, 'nama_produk' => 'Cireng Isi Mini', 'catatan' => null],
                (object) ['qty' => 2, 'nama_produk' => 'Pop Ice Chocolate', 'catatan' => null],
            ]),
        ],
 
        // 3) SELESAI & BELUM DINILAI (COD) — mirip contoh #2DA-84920
        (object) [
            'kode_pesanan'      => '2DA-84920',
            'no_pesanan'        => 'INV-20261012-084920',
            'no_invoice'        => 'INV/20261012/2DA/84920',
            'status'            => 'selesai',
            'created_at'        => \Carbon\Carbon::parse('2026-10-12 19:30:00'),
            'lokasi_label'      => 'Tebet Barat Dalam VI',
            'alamat'            => 'Tebet Barat Dalam VI',
            'total'             => 10000,
            'metode_pembayaran' => 'cod',
            'payment_status'    => 'paid',
            'metode_pengiriman' => 'Ambil Sendiri',
            'kurir'             => null,
            'rating'            => null, // null = belum diulas -> tombol "Beri Ulasan"
            'catatan_status'    => null,
            'items'             => collect([
                (object) ['qty' => 1, 'nama_produk' => 'Corndog Mini Mozzarella', 'catatan' => 'Saus Mayo'],
                (object) ['qty' => 1, 'nama_produk' => 'Ice Good Day Freeze', 'catatan' => 'Extra Ice'],
            ]),
        ],
 
        // 4) SEDANG DI DAPUR — contoh tambahan untuk status lain
        (object) [
            'kode_pesanan'      => '2DA-91007',
            'no_pesanan'        => 'INV-20261023-091007',
            'no_invoice'        => 'INV/20261023/2DA/91007',
            'status'            => 'dapur',
            'created_at'        => \Carbon\Carbon::now()->subMinutes(20),
            'lokasi_label'      => 'Kos Wonokromo',
            'alamat'            => 'Jl. Wonokromo No. 5',
            'total'             => 22000,
            'metode_pembayaran' => 'va',
            'payment_status'    => 'paid',
            'metode_pengiriman' => 'Gojek Instant',
            'kurir'             => null,
            'rating'            => null,
            'catatan_status'    => null,
            'items'             => collect([
                (object) ['qty' => 4, 'nama_produk' => 'Cireng Isi Ayam', 'catatan' => 'Pedas Sedang'],
            ]),
        ],
 
        // 5) DIBATALKAN — contoh status batal
        (object) [
            'kode_pesanan'      => '2DA-80215',
            'no_pesanan'        => 'INV-20261016-080215',
            'no_invoice'        => 'INV/20261016/2DA/80215',
            'status'            => 'batal',
            'created_at'        => \Carbon\Carbon::now()->subDays(7),
            'lokasi_label'      => 'Rumah Tinggal',
            'alamat'            => 'Jl. Merdeka No. 12, Surabaya',
            'total'             => 20000,
            'metode_pembayaran' => 'qris',
            'payment_status'    => 'cancelled',
            'metode_pengiriman' => 'Kurir 2DA Store',
            'kurir'             => null,
            'rating'            => null,
            'catatan_status'    => 'Pesanan dibatalkan sebelum diproses',
            'items'             => collect([
                (object) ['qty' => 4, 'nama_produk' => 'Cireng Isi Ayam', 'catatan' => null],
            ]),
        ],
 
    ]);
 
    return view('riwayat', compact('orders'));
})->name('riwayat');

Route::get('/alamat', fn () => view('alamat'))
    ->name('alamat');

Route::get('/detail', fn () => view('detail'))
    ->name('detail');

Route::get('/pengaturan', fn () => view('pengaturan'))
    ->name('pengaturan');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

}); // tutup Route::middleware('auth') -- AFTER LOGIN s/d AKUN


/*
|--------------------------------------------------------------------------
| ADMIN
|
| Semua rute di bawah ini (ADMIN, ADMIN PENGATURAN, ADMIN MENU) wajib
| login DAN is_admin = true (lihat App\Http\Middleware\EnsureUserIsAdmin).
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {

Route::get('/admin/dashboard', fn () => view('admin/dashboard'))
    ->name('admin.dashboard');

Route::get('/admin/pesanan', [PesananController::class, 'adminIndex'])
    ->name('admin.pesanan');

Route::patch('/admin/pesanan/{no}/status', [PesananController::class, 'updateStatus'])
    ->name('admin.pesanan.status');

Route::get('/admin/pengguna', [PenggunaController::class, 'index'])
    ->name('admin.pengguna');

Route::get('/admin/ulasan', [UlasanController::class, 'index'])
    ->name('admin.ulasan');

Route::get('/admin/ulasan/unduh', [UlasanController::class, 'unduh'])
    ->name('admin.ulasan.unduh');

Route::post('/admin/ulasan/{ulasan}/balas', [UlasanController::class, 'balas'])
    ->name('admin.ulasan.balas');

Route::delete('/admin/ulasan/{ulasan}/balasan/hapus', [UlasanController::class, 'hapusBalasan'])
    ->name('admin.ulasan.balasan.hapus');

Route::patch('/admin/ulasan/{ulasan}/sematkan', [UlasanController::class, 'togglePin'])
    ->name('admin.ulasan.sematkan');


/*
|--------------------------------------------------------------------------
| ADMIN PENGATURAN
|--------------------------------------------------------------------------
*/

Route::get('/admin/pengaturan', function () {
    $pengaturan = \App\Models\Pengaturan::first();

    return view('admin/pengaturan', compact('pengaturan'));
})->name('admin.pengaturan');

Route::post('/admin/pengaturan', [PengaturanController::class, 'update'])
    ->name('admin.pengaturan.update');

Route::post('/admin/pengaturan/tes-cetak', [PengaturanController::class, 'tesCetak'])
    ->name('admin.pengaturan.tes-cetak');


/*
|--------------------------------------------------------------------------
| ADMIN MENU
|--------------------------------------------------------------------------
*/

Route::get('/admin/menu', [MenuController::class, 'index'])
    ->name('admin.menu');

Route::get('/admin/menu/tambah', [MenuController::class, 'create'])
    ->name('admin.menu.tambah');

Route::post('/admin/menu', [MenuController::class, 'store'])
    ->name('admin.menu.store');

Route::get('/admin/menu/{product}/edit', [MenuController::class, 'edit'])
    ->name('admin.menu.edit');

Route::put('/admin/menu/{product}', [MenuController::class, 'update'])
    ->name('admin.menu.update');

Route::delete('/admin/menu/{product}', [MenuController::class, 'destroy'])
    ->name('admin.menu.destroy');

Route::patch('/admin/menu/{product}/stock', [MenuController::class, 'updateStock'])
    ->name('admin.menu.stock');

Route::patch('/admin/menu/{product}/status', [MenuController::class, 'toggleStatus'])
    ->name('admin.menu.status');

}); // tutup Route::middleware(['auth', 'admin'])