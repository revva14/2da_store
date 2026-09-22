<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\GoogleController;

Route::resource('produk', ProdukController::class);

Route::get('/', function () {
    return view('welcome');
});

// en id
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session(['locale' => $locale]);
    }
    return back();
})->name('lang.switch');

// BEFORE LOGIN 
Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');
Route::get('/produk', fn() => view('produk'))->name('produk');
Route::get('/menu', fn() => view('menu'))->name('menu');
Route::get('/navbarlogin', fn() => view('navbarlogin'))->name('navbarlogin');
Route::get('/testimoni', fn() => view('testimoni'))->name('testimoni');
Route::get('/cara-pesan', fn() => view('cara-pesan'))->name('cara-pesan');
Route::get('/tentang', fn() => view('tentang'))->name('tentang');
Route::get('/hubungi', fn() => view('hubungi'))->name('hubungi');

// Route Auth & Halaman Login/Registrasi
Route::get('/login', fn() => view('login'))->name('login');
Route::post('/login', function() {
    // Penanganan sementara saat form login di-submit
    return redirect()->route('berandalogin');
});

Route::get('/registrasi', fn() => view('registrasi'))->name('registrasi');
Route::get('/register', fn() => view('registrasi'))->name('register'); // Penanganan route name 'register'

// Lupa Password (sementara di-redirect ke login atau halaman lupa password jika ada)
Route::get('/forgot-password', fn() => view('login'))->name('password.request');

// Google Login
Route::get('/login/google', [GoogleController::class, 'redirect'])->name('login.google');
Route::get('/login/google/callback', [GoogleController::class, 'callback'])->name('login.google.callback');

// AFTER LOGIN
Route::get('/berandalogin', fn() => view('berandalogin'))->name('berandalogin');
Route::get('/menulogin', fn() => view('menulogin'))->name('menulogin');
Route::get('/produklogin', fn() => view('produklogin'))->name('produklogin');
Route::get('/cara-pesanlogin', fn() => view('cara-pesanlogin'))->name('cara-pesanlogin');
Route::get('/testimonilogin', fn() => view('testimonilogin'))->name('testimonilogin');
Route::get('/tentanglogin', fn() => view('tentanglogin'))->name('tentanglogin');
Route::get('/hubungilogin', fn() => view('hubungilogin'))->name('hubungilogin');
Route::get('/pesanan', fn() => view('pesanan'))->name('pesanan');
Route::get('/tambah-keranjang', fn() => view('tambah-keranjang'))->name('tambah-keranjang');
Route::get('/keranjang', fn() => view('keranjang'))->name('keranjang');
Route::get('/cart-script', fn() => view('cart-script'))->name('cart-script');
Route::get('/biodata', fn() => view('biodata'))->name('biodata');
Route::get('/riwayat', fn() => view('riwayat'))->name('riwayat');
Route::get('/alamat', fn() => view('alamat'))->name('alamat');
Route::get('/detail', fn() => view('detail'))->name('detail');
Route::get('/pengaturan', fn() => view('pengaturan'))->name('pengaturan');
Route::get('/logout', fn() => view('logout'))->name('logout');

// ADMIN
Route::get('/admin/dashboard', fn() => view('admin/dashboard'))->name('admin/dashboard');
Route::get('/admin/pesanan', fn() => view('admin/pesanan'))->name('admin/pesanan');
Route::get('/admin/menu', fn() => view('admin/menu'))->name('admin/menu');
Route::get('/admin/pengguna', fn() => view('admin/pengguna'))->name('admin/pengguna');
Route::get('/admin/ulasan', fn() => view('admin/ulasan'))->name('admin/ulasan');