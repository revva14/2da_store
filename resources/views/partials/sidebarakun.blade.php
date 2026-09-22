{{--
  Sidebar akun (profil + menu). Dipakai di halaman: biodata, alamat, riwayat, pengaturan.
  Pemakaian:  @include('partials.sidebarakun', ['active' => 'biodata'])
  Nilai active: biodata | alamat | riwayat | pengaturan
  (kalau tidak diisi, menu aktif ditentukan otomatis dari URL)

  Kotak "Koin Didapat": 10 koin untuk setiap pesanan yang sudah diulas.
  Angkanya dihitung di halaman Riwayat (dari kartu pesanan yang berstatus "Sudah diulas"),
  disimpan di localStorage 'twoda_coins', lalu dibaca di sini supaya sama di semua halaman akun.
  (nanti tinggal diganti data dari database)
--}}
@php
  $active = $active ?? null;
  $isActive = fn($key) => $active ? $active === $key : request()->is($key, $key.'/*');

  // teks kotak koin (kalau key di lang/*/akun.php belum ditambah, pakai teks bawaan)
  $isEn      = app()->getLocale() === 'en';
  $coinLabel = \Illuminate\Support\Facades\Lang::has('akun.coins_earned')
      ? __('akun.coins_earned') : ($isEn ? 'Coins Earned' : 'Koin Didapat');
  $coinTpl   = \Illuminate\Support\Facades\Lang::has('akun.coins_value')
      ? __('akun.coins_value', ['count' => '{n}']) : ($isEn ? '{n} Coins' : '{n} Koin');
@endphp

@push('styles')
<style>
  /* ---------- PROFILE CARD ---------- */
  .profile-card{
    background: var(--white);
    border-radius: 10px;
    padding: 34px 26px 26px;
    text-align:center;
    box-shadow: 0 14px 30px -18px rgba(60,30,10,.22);
    margin-bottom:20px;
  }
  .profile-avatar{
    width:96px; height:96px;
    margin:0 auto 16px;
    border-radius:50%;
    overflow:hidden;
    border:4px solid var(--cream-soft);
    box-shadow: 0 8px 18px -8px rgba(60,30,10,.35);
  }
  .profile-avatar img{ width:100%; height:100%; object-fit:cover; }

  .profile-name{
    font-family: var(--font-display);
    font-weight:800;
    font-size:17px;
    color: var(--ink);
    margin-bottom:4px;
  }
  .profile-email{
    font-size:12px;
    color: var(--ink-soft);
    margin-bottom:14px;
  }

  .profile-badge{
    display:inline-flex;
    align-items:center;
    gap:6px;
    background:#e8f3de;
    color:#4f7a35;
    font-size:11px;
    font-weight:600;
    padding:6px 14px;
    border-radius: var(--radius-pill);
    margin-bottom:22px;
  }
  .profile-badge::before{
    content:"";
    width:7px; height:7px;
    border-radius:50%;
    background:#5f9a3b;
    flex:none;
  }

  .profile-stats{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:10px;
    padding-top:18px;
    border-top:1px solid rgba(122,59,18,.1);
  }
  .stat-box{
    background: var(--cream-soft);
    border-radius: 10px;
    padding:12px 12px;
    text-align:left;
  }
  .stat-label{
    display:block;
    font-size:9px;
    letter-spacing:.04em;
    text-transform:uppercase;
    color: var(--ink-soft);
    margin-bottom:4px;
  }
  .stat-value{
    font-family: var(--font-display);
    font-weight:700;
    font-size:14px;
    color: var(--ink);
  }
  .stat-value.accent{ color: var(--orange-dark); }

  /* ---------- ACCOUNT MENU ---------- */
  .account-menu{
    background: var(--white);
    border-radius: 10px;
    box-shadow: 0 14px 30px -18px rgba(60,30,10,.22);
    overflow:hidden;
  }
  .account-menu-item{
    display:flex;
    align-items:center;
    gap:12px;
    padding:16px 20px;
    font-size:13px;
    font-weight:600;
    color: var(--ink);
    border-bottom:1px solid rgba(122,59,18,.07);
    transition: background .2s ease, color .2s ease;
  }
  .account-menu-item:last-child{ border-bottom:none; }
  .account-menu-item svg{ width:18px; height:18px; flex:none; }
  .account-menu-item .menu-arrow{ margin-left:auto; opacity:.55; width:16px; height:16px; }
  .account-menu-item.active{ background: var(--orange); color:#fff; }
  .account-menu-item:not(.active):hover{ background: var(--cream-soft); }
  .account-menu-item.logout{ color:#c0392b; }
</style>
@endpush

<aside>
  <div class="profile-card">
    <div class="profile-avatar">
      <img src="{{ asset('images/profil-reva.jpg') }}" alt="{{ __('akun.avatar_alt', ['name' => 'Reva Aulia A.']) }}">
    </div>
    <h2 class="profile-name">Reva Aulia A.</h2>
    <p class="profile-email">revanjai@email.com</p>
    <span class="profile-badge">{{ __('akun.joined') }}</span>

    <div class="profile-stats">
      <div class="stat-box">
        <span class="stat-label">{{ __('akun.total_orders') }}</span>
        <span class="stat-value">{{ __('akun.menu_count', ['count' => 38]) }}</span>
      </div>
      <div class="stat-box">
        <span class="stat-label">{{ $coinLabel }}</span>
        <span class="stat-value accent" id="sidebarCoins" data-tpl="{{ $coinTpl }}">{{ str_replace('{n}', '0', $coinTpl) }}</span>
      </div>
    </div>
  </div>

  <nav class="account-menu">
    <a href="/biodata" class="account-menu-item{{ $isActive('biodata') ? ' active' : '' }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      {{ __('akun.menu_biodata') }}
      <svg class="menu-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
    </a>
    <a href="/alamat" class="account-menu-item{{ $isActive('alamat') ? ' active' : '' }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
      {{ __('akun.menu_address') }}
      <svg class="menu-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
    </a>
    <a href="/riwayat" class="account-menu-item{{ $isActive('riwayat') ? ' active' : '' }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="9" y1="13" x2="15" y2="13"/><line x1="9" y1="17" x2="15" y2="17"/></svg>
      {{ __('akun.menu_history') }}
      <svg class="menu-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
    </a>
    <a href="/pengaturan" class="account-menu-item{{ $isActive('pengaturan') ? ' active' : '' }}">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
      {{ __('akun.menu_settings') }}
      <svg class="menu-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
    </a>
    <a href="/logout" class="account-menu-item logout">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
      {{ __('akun.menu_logout') }}
    </a>
  </nav>
</aside>

@push('scripts')
<script>
  // Koin akun (10 koin per pesanan yang sudah diulas) -- dihitung & disimpan oleh halaman Riwayat
  (function () {
    var el = document.getElementById('sidebarCoins');
    if (!el) return;
    function render(n) {
      n = parseInt(n, 10) || 0;
      el.textContent = el.dataset.tpl.replace('{n}', n.toLocaleString('id-ID'));
    }
    try { render(localStorage.getItem('twoda_coins')); } catch (e) {}
    window.addEventListener('twoda:coins', function (e) { render(e.detail.coins); });
  })();
</script>
@endpush