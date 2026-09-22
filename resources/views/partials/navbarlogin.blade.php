<header class="site-nav">
  <div class="container nav-inner">
    <a href="/berandalogin" class="logo">
      <img src="{{ asset('images/logo.png') }}" alt="2DA Store" class="logo-img">
    </a>
    <nav class="nav-links">
      <a href="/berandalogin" class="{{ request()->is('berandalogin') ? 'active' : '' }}">{{ __('Beranda') }}</a>
      <a href="/menulogin" class="{{ request()->is('menulogin') ? 'active' : '' }}">{{ __('Menu') }}</a>
      <a href="/cara-pesanlogin" class="{{ request()->is('cara-pesanlogin') ? 'active' : '' }}">{{ __('Cara Pesan') }}</a>
      <a href="/testimonilogin" class="{{ request()->is('testimonilogin') ? 'active' : '' }}">{{ __('Testimoni') }}</a>
    </nav>
    <div style="display:flex; align-items:center; gap:16px;">
      @include('partials.langswitch')
      <a href="/keranjang" class="nav-icon-btn {{ request()->is('keranjang') ? 'active' : '' }}" aria-label="{{ __('Keranjang') }}">
        <img src="{{ asset('images/keranjang.png') }}" alt="{{ __('Keranjang') }}">
      </a>
      <a href="/biodata" class="nav-icon-btn" aria-label="{{ __('Profil') }}">
        <img src="{{ asset('images/user.png') }}" alt="{{ __('Profil') }}">
      </a>
      <button class="hamburger" id="hamburgerBtn" aria-label="Buka menu">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
  <div class="mobile-menu" id="mobileMenu">
    <a href="/berandalogin" class="{{ request()->is('berandalogin') ? 'active' : '' }}">{{ __('Beranda') }}</a>
    <a href="/menulogin" class="{{ request()->is('menulogin') ? 'active' : '' }}">{{ __('Menu') }}</a>
    <a href="/cara-pesanlogin" class="{{ request()->is('cara-pesanlogin') ? 'active' : '' }}">{{ __('Cara Pesan') }}</a>
    <a href="/testimonilogin" class="{{ request()->is('testimonilogin') ? 'active' : '' }}">{{ __('Testimoni') }}</a>
  </div>
</header>

@push('styles')
<style>
  /* ---------- ICON BUTTONS (profil & keranjang setelah login) ---------- */
  .nav-icon-btn{
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    color: var(--ink);
    background: transparent;
    transition: background .2s ease, color .2s ease;
  }
  .nav-icon-btn:hover{
    background: var(--cream-soft);
    color: var(--orange);
  }
  .nav-icon-btn img{
    width: 20px;
    height: 20px;
    object-fit: contain;
  }
  .nav-icon-badge{
    position: absolute;
    top: 0px;
    right: 0px;
    min-width: 16px;
    height: 16px;
    padding: 0 4px;
    border-radius: 999px;
    background: var(--orange);
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    line-height: 16px;
    text-align: center;
  }
</style>
@endpush