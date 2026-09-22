<header class="site-nav">
  <div class="container nav-inner">
    <a href="/" class="logo">
      <img src="{{ asset('images/logo.png') }}" alt="2DA Store" class="logo-img">
    </a>
    <nav class="nav-links">
      <a href="/beranda" class="{{ request()->is('beranda') ? 'active' : '' }}">{{ __('Beranda') }}</a>
      <a href="/menu" class="{{ request()->is('menu') ? 'active' : '' }}">{{ __('Menu') }}</a>
      <a href="/cara-pesan" class="{{ request()->is('cara-pesan') ? 'active' : '' }}">{{ __('Cara Pesan') }}</a>
      <a href="/testimoni" class="{{ request()->is('testimoni') ? 'active' : '' }}">{{ __('Testimoni') }}</a>
    </nav>
    <div style="display:flex; align-items:center; gap:16px;">
      @include('partials.langswitch')
      <a href="/login" class="btn btn-nav">{{ __('Masuk') }}</a>
      <button class="hamburger" id="hamburgerBtn" aria-label="Buka menu">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
  <div class="mobile-menu" id="mobileMenu">
    <a href="/beranda" class="{{ request()->is('beranda') ? 'active' : '' }}">{{ __('Beranda') }}</a>
    <a href="/menu" class="{{ request()->is('menu') ? 'active' : '' }}">{{ __('Menu') }}</a>
    <a href="/cara-pesan" class="{{ request()->is('cara-pesan') ? 'active' : '' }}">{{ __('Cara Pesan') }}</a>
    <a href="/testimoni" class="{{ request()->is('testimoni') ? 'active' : '' }}">{{ __('Testimoni') }}</a>
  </div>
</header>