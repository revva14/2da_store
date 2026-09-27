<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login (views/login.blade.php).
     */
    public function showLoginForm(): View
    {
        return view('login');
    }

    /**
     * Proses submit form login.
     * Cocok dengan form di login.blade.php: name="email", name="password", name="remember".
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            // Pesan generik (tidak bilang "email tidak ditemukan" / "password salah" terpisah)
            // supaya tidak membocorkan email mana yang terdaftar.
            return back()
                ->withErrors(['email' => 'Email atau kata sandi yang kamu masukkan salah.'])
                ->onlyInput('email');
        }

        // Cegah session fixation.
        $request->session()->regenerate();

        if (Auth::user()->is_admin) {
            return redirect('/admin/dashboard');
        }

return redirect()->intended('/berandalogin');

return redirect()->intended('/berandalogin');
    }

    /**
     * Tampilkan halaman registrasi (views/registrasi.blade.php).
     */
    public function showRegisterForm(): View
    {
        return view('registrasi');
    }

    /**
     * Proses submit form registrasi.
     * Cocok dengan form di registrasi.blade.php: name, email, password,
     * password_confirmation, agreement (checkbox syarat & ketentuan).
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'agreement' => ['accepted'],
        ], [
            'name.required'         => 'Nama lengkap wajib diisi.',
            'email.required'        => 'Email wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'email.unique'          => 'Email ini sudah terdaftar. Coba masuk saja.',
            'password.required'     => 'Kata sandi wajib diisi.',
            'password.min'          => 'Kata sandi minimal 8 karakter.',
            'password.confirmed'    => 'Konfirmasi kata sandi tidak cocok.',
            'agreement.accepted'    => 'Kamu harus menyetujui Syarat & Ketentuan terlebih dahulu.',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            // Hash::make dipakai eksplisit supaya tetap aman walau proyek belum
            // pakai cast 'hashed' otomatis di model User (Laravel 10+).
            'password' => Hash::make($validated['password']),
        ]);

        // Sengaja TIDAK auto-login di sini -- setelah daftar, user diarahkan
        // ke halaman login dulu supaya harus masuk manual pakai akun barunya.
        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan masuk dengan email dan kata sandi kamu.');
    }

    /**
     * Logout — dipanggil lewat POST (bukan link GET) supaya aman dari CSRF/prefetch.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}