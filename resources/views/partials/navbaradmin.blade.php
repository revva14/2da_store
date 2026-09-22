{{-- resources/views/partials/navbaradmin.blade.php --}}
{{-- Membutuhkan variabel CSS (:root) dari layout/halaman: --cream, --brown, --orange, --muted, --ink, dll. --}}
<style>
    .topbar { display: flex; align-items: center; gap: 11px; }
    .search { flex: 1; display: flex; align-items: center; gap: 8px; background: #fff; border-radius: 9.5px; padding: 9.5px 11px; color: var(--muted); }
    .search input { border: 0; outline: 0; background: transparent; font: inherit; font-size: 11px; width: 100%; color: var(--ink); }
    .search input::placeholder { color: #a99b92; }
    .receiving { display: flex; align-items: center; gap: 6.5px; background: #fff; border-radius: 16px; padding: 6.5px 11px; font-size: 9.5px; font-weight: 500; color: var(--brown); }
    .receiving i { width: 7px; height: 7px; border-radius: 50%; background: var(--brown); display: inline-block; animation: pulse 1.8s infinite; }
    .bell { position: relative; width: 29px; height: 29px; border-radius: 50%; background: var(--cream); display: grid; place-items: center; }
    .bell span { position: absolute; top: -2px; right: -2px; width: 13px; height: 13px; border-radius: 50%; background: var(--brown); color: #fff; font-size: 8px; display: grid; place-items: center; }
    @keyframes pulse { 0%,100% { box-shadow: 0 0 0 0 rgba(163,74,10,.4); } 50% { box-shadow: 0 0 0 5px rgba(163,74,10,0); } }
</style>

<div class="topbar">
    <label class="search">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M20 20l-4-4"/></svg>
        <input type="text" placeholder="Cari pesanan, menu, atau pelanggan...">
    </label>
    <div class="receiving"><i></i>Menerima Pesanan</div>
    <div class="bell">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 16V11a6 6 0 0112 0v5l2 2H4z"/><path d="M10 21h4"/></svg>
        <span>3</span>
    </div>
</div>