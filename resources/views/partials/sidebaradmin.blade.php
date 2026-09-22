{{-- resources/views/partials/sidebaradmin.blade.php --}}
{{-- Membutuhkan variabel CSS (:root) dari layout/halaman: --cream, --brown, --orange, --muted, --ink, dll. --}}
<style>
    /* ===== SIDEBAR ===== */
    .sidebar { width: 220px; flex-shrink: 0; padding: 18px 16px; background: #fdf1e6; display: flex; flex-direction: column; gap: 12px; position: sticky; top: 0; height: 100vh; overflow-y: auto; }
    .brand { display: flex; align-items: center; gap: 9px; }
    .brand img { width: 26px; height: 26px; border-radius: 7px; object-fit: cover; background: #f1e4d8; }
    .brand strong { display: block; font-size: 15px; font-weight: 600; line-height: 1; }
    .brand small { font-size: 8.5px; font-weight: 600; letter-spacing: .05em; color: var(--muted); }
    .store-status { display: flex; align-items: center; justify-content: space-between; background: #fff; border-radius: 10px; padding: 8px 10px; font-size: 11px; font-weight: 500; }
    .store-status .dot { width: 7px; height: 7px; border-radius: 50%; background: var(--brown); display: inline-block; margin-right: 6px; }
    .store-status .badge { font-size: 9px; font-weight: 600; color: var(--brown); background: var(--cream); padding: 2px 7px; border-radius: 7px; }
    .nav-label { font-size: 9px; font-weight: 600; letter-spacing: .07em; color: var(--muted); margin: 4px 0 -4px 6px; }
    .nav { display: flex; flex-direction: column; gap: 3px; }
    .nav a { display: flex; align-items: center; gap: 9px; padding: 9px 11px; border-radius: 11px; font-size: 12px; font-weight: 500; transition: background .25s, transform .25s; }
    .nav a svg { width: 16px; height: 16px; flex-shrink: 0; }
    .nav a:hover { background: #fbe6d3; transform: translateX(3px); }
    .nav a.active { background: var(--orange); color: #fff; box-shadow: 0 4px 10px rgba(255,138,61,.3); }
    .nav a .pill { margin-left: auto; font-size: 9px; font-weight: 600; color: var(--brown); background: #fbd9c4; padding: 2px 7px; border-radius: 8px; }
    .logout { margin-top: auto; }
    .logout a { display: flex; align-items: center; gap: 8px; background: #f3e4d6; padding: 10px 12px; border-radius: 10px; font-size: 11px; font-weight: 500; transition: background .25s; }
    .logout a svg { width: 15px; height: 15px; }
    .logout a:hover { background: #ecd6c2; }
    @media (max-width: 800px) { .sidebar { display: none; } }
</style>

<aside class="sidebar">
    <div class="brand">
        <img src="{{ asset('images/logo.png') }}" alt="Logo 2da Store">
        <div>
            <strong>2DA Store</strong>
            <small>JAJANAN & MINUMAN</small>
        </div>
    </div>

    <div class="store-status">
        <span><i class="dot"></i>Toko Buka</span>
        <span class="badge">AKTIF</span>
    </div>

    <div class="nav-label">MENU UTAMA</div>
    <nav class="nav">
        <a href="{{ url('/admin/dashboard') }}" class="{{ request()->is('admin/dashboard*') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            Dashboard & Rekap
        </a>
        <a href="{{ url('/admin/pesanan') }}" class="{{ request()->is('admin/pesanan*') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 3h12v18l-3-2-3 2-3-2-3 2z"/><path d="M9 8h6M9 12h6"/></svg>
            Kelola Pesanan <span class="pill">8 Baru</span>
        </a>
        <a href="{{ url('/admin/menu') }}" class="{{ request()->is('admin/menu*') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 3l16 16M20 3L4 19"/></svg>
            Kelola Menu
        </a>
    </nav>

    <div class="nav-label">MANAJEMEN & ULASAN</div>
    <nav class="nav">
        <a href="{{ url('/admin/pengguna') }}" class="{{ request()->is('admin/pengguna*') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20c0-3.5 3-6 6.5-6s6.5 2.5 6.5 6"/><path d="M16 4.5a3.5 3.5 0 010 7M18 14c2 .7 3.5 2.6 3.5 5"/></svg>
            Kelola Pengguna
        </a>
        <a href="{{ url('/admin/ulasan') }}" class="{{ request()->is('admin/ulasan*') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v13H9l-5 4z"/><path d="M8 9h8M8 13h5"/></svg>
            Kelola Ulasan
        </a>
    </nav>

    <div class="nav-label">KONFIGURASI</div>
    <nav class="nav">
        <a href="{{ url('/admin/pengaturan') }}" class="{{ request()->is('admin/pengaturan*') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 9l2-5h12l2 5"/><path d="M4 9v11h16V9"/><path d="M4 9c0 2 4 2 4 0 0 2 4 2 4 0 0 2 4 2 4 0 0 2 4 2 4 0"/></svg>
            Pengaturan Toko
        </a>
    </nav>

    <div class="logout">
        <form action="{{ url('/logout') }}" method="POST">
            @csrf
            <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 4H5v16h4"/><path d="M11 12h10M17 8l4 4-4 4"/></svg>
                Keluar dari Akun
            </a>
        </form>
    </div>
</aside>