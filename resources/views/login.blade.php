<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Masuk ke Akun - 2DA Store</title>

  <!-- Jika punya file CSS global (seperti variabel warna/reset), panggil di sini -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

  <style>
    /* Reset & Base Style Halaman Login */
    body {
      margin: 0;
      padding: 0;
      background-color: #f8f9fa;
      font-family: system-ui, -apple-system, sans-serif;
    }

    .login-promo-tags span {
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }

    .tag-icon {
      width: 16px;
      height: 16px;
      object-fit: contain;
    }

    /* Styling Ikon Gambar */
    .btn-google .btn-icon {
      width: 18px;
      height: 18px;
      object-fit: contain;
    }

    .login-badge-category .badge-icon {
      width: 16px;
      height: 16px;
      object-fit: contain;
    }

    .login-input-wrap .input-icon-left {
      position: absolute;
      left: 14px;
      width: 18px;
      height: 18px;
      object-fit: contain;
      pointer-events: none;
      opacity: 0.55; 
      filter: sepia(100%) hue-rotate(350deg) saturate(200%);
    }

    /* Sembunyikan ikon toggle password bawaan Edge / Chrome / Safari */
    input[type="password"]::-ms-reveal,
    input[type="password"]::-ms-clear {
      display: none;
    }

    input[type="password"]::-webkit-contacts-auto-fill-button,
    input[type="password"]::-webkit-credentials-auto-fill-button {
      visibility: hidden;
      pointer-events: none;
      position: absolute;
      right: 0;
    }

    .toggle-password {
      position: absolute;
      right: 14px;
      background: transparent;
      border: none;
      cursor: pointer;
      padding: 0;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .toggle-password .eye-img {
      width: 18px;
      height: 18px;
      object-fit: contain;
      opacity: 0.6;
      transition: opacity 0.2s ease;
    }

    .toggle-password:hover .eye-img {
      opacity: 1;
    }

    /* ===================== LOGIN PAGE ===================== */
    .container {
      max-width: 1100px;
      width: 100%;
      margin: 0 auto;
      padding: 0 20px;
    }

    .login-section {
      padding: 56px 0;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-wrapper {
      max-width: 1024px;
      width: 100%;
      margin: 0 auto;
      background: #fff;
      border-radius: var(--radius-lg, 16px);
      box-shadow: 0 14px 30px rgba(59, 31, 20, 0.15);
      overflow: hidden;
      display: flex !important;
      flex-direction: row !important;
      flex-wrap: nowrap !important;
      align-items: stretch;
    }

    /* ---------- PANEL KIRI ---------- */
    .login-promo {
      flex: 1 1 50%;
      min-width: 0;
      background: linear-gradient(160deg, var(--cream-soft, #FFF8F0) 0%, var(--peach, #FFE5D9) 100%);
      padding: 32px;
      display: flex;
      flex-direction: column;
    }

    .login-promo-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      margin-bottom: 24px;
      flex-wrap: wrap;
    }

    .login-badge-category {
      background: #fff;
      border-radius: 999px;
      padding: 8px 16px;
      font-size: 13px;
      font-weight: 600;
      color: var(--ink-soft, #555);
      display: flex;
      align-items: center;
      gap: 8px;
      white-space: nowrap;
    }

    .login-hero-media {
      position: relative;
      border-radius: var(--radius-md, 12px);
      overflow: hidden;
      margin-bottom: 24px;
      background: var(--peach, #FFE5D9);
    }
    .login-hero-media img {
      width: 100%;
      height: 280px;
      object-fit: cover;
    }

    .login-badge-bestseller {
      position: absolute;
      top: 16px;
      left: 16px;
      background: #3EA85B;
      color: #fff;
      font-size: 12px;
      font-weight: 700;
      padding: 6px 14px;
      border-radius: 999px;
    }

    .login-badge-rating {
      position: absolute;
      bottom: 16px;
      left: 16px;
      background: rgba(36, 18, 6, 0.72);
      color: #fff;
      font-size: 13px;
      font-weight: 600;
      padding: 8px 16px;
      border-radius: 999px;
    }
    .login-badge-rating .star { color: #FFC94A; }
    .login-badge-rating .muted { font-weight: 400; opacity: .85; }

    .login-promo-heading {
      font-family: var(--font-display, inherit);
      font-size: 27px;
      font-weight: 800;
      color: var(--ink, #222);
      margin-bottom: 12px;
      line-height: 1.25;
    }

    .login-promo-text {
      font-size: 15px;
      color: var(--ink-soft, #555);
      line-height: 1.6;
      margin-bottom: 20px;
    }

    .login-promo-divider {
      border: none;
      border-top: 1px solid rgba(122, 59, 18, 0.18);
      margin-bottom: 18px;
    }

    .login-promo-tags {
      display: flex;
      gap: 12px;
      flex-wrap: wrap;
    }
    .login-promo-tags span {
      background: #fff;
      border-radius: 999px;
      padding: 8px 14px;
      font-size: 12.5px;
      font-weight: 600;
      color: var(--ink-soft, #555);
      white-space: nowrap;
    }

    /* ---------- PANEL KANAN ---------- */
    .login-form-panel {
      flex: 1 1 50%;
      min-width: 0;
      padding: 48px 44px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .login-welcome-pill {
      display: inline-block;
      background: var(--pink-card-2, #FFE3E3);
      color: var(--orange-dark, #D97B29);
      font-size: 12.5px;
      font-weight: 700;
      padding: 6px 14px;
      border-radius: 999px;
      margin-bottom: 18px;
      width: fit-content;
    }

    .login-form-title {
      font-family: var(--font-display, inherit);
      font-size: 30px;
      font-weight: 800;
      color: var(--ink, #222);
      margin-bottom: 10px;
    }

    .login-form-subtitle {
      font-size: 14.5px;
      color: var(--ink-soft, #555);
      line-height: 1.6;
      margin-bottom: 26px;
    }

    .btn-google {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      padding: 13px 16px;
      border-radius: var(--radius-md, 10px);
      border: 1px solid #EADFCB;
      background: #fff;
      font-size: 14.5px;
      font-weight: 700;
      color: var(--ink, #222);
      margin-bottom: 22px;
      transition: background .2s ease, border-color .2s ease;
      cursor: pointer;
    }
    .btn-google:hover { background: var(--cream-soft, #FFF8F0); border-color: #e2d3b3; }

    .login-divider-row {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 22px;
    }
    .login-divider-row::before,
    .login-divider-row::after {
      content: "";
      flex: 1;
      height: 1px;
      background: #EFE6D6;
    }
    .login-divider-row span {
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.5px;
      color: var(--ink-soft, #777);
      white-space: nowrap;
    }

    .login-field { margin-bottom: 18px; }
    .login-field label {
      display: block;
      font-size: 13.5px;
      font-weight: 700;
      color: var(--ink, #222);
      margin-bottom: 8px;
    }

    .login-input-wrap {
      position: relative;
      display: flex;
      align-items: center;
    }
    .login-input-wrap .icon-left {
      position: absolute;
      left: 14px;
      color: #B4A387;
      font-size: 15px;
      pointer-events: none;
    }
    .login-input-wrap input {
      width: 100%;
      padding: 13px 14px 13px 40px;
      border-radius: var(--radius-md, 10px);
      border: 1px solid #EADFCB;
      background: var(--cream-soft, #FFF8F0);
      font-family: inherit;
      font-size: 14.5px;
      color: var(--ink, #222);
      outline: none;
      transition: border-color .2s ease, box-shadow .2s ease;
    }
    .login-input-wrap input::placeholder { color: #BCAD93; }
    .login-input-wrap input:focus {
      border-color: var(--orange, #D97B29);
      box-shadow: 0 0 0 3px rgba(217, 123, 41, 0.15);
    }

    .field-error {
      display: block;
      color: #c0392b;
      font-size: 12.5px;
      margin-top: 6px;
    }

    .login-row-between {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin: 4px 0 22px;
      flex-wrap: wrap;
      gap: 10px;
    }
    .remember-me {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 13.5px;
      color: var(--ink-soft, #555);
    }
    .remember-me input { accent-color: var(--orange, #D97B29); width: 15px; height: 15px; }

    .link-orange {
      color: var(--orange-dark, #D97B29);
      font-size: 13.5px;
      font-weight: 700;
      text-decoration: none;
    }
    .link-orange:hover { text-decoration: underline; }

    .btn-submit {
      width: 100%;
      background: var(--orange, #D97B29);
      color: #fff;
      border: none;
      border-radius: var(--radius-md, 10px);
      padding: 15px 16px;
      font-size: 15.5px;
      font-weight: 700;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      box-shadow: 0 10px 20px -8px rgba(122, 59, 18, .45);
      transition: background .2s ease, transform .15s ease, box-shadow .2s ease;
      margin-bottom: 22px;
      cursor: pointer;
    }
    .btn-submit:hover {
      background: var(--orange-dark, #B85F18);
      transform: translateY(-1px);
      box-shadow: 0 14px 24px -8px rgba(122, 59, 18, .5);
    }

    .login-signup-text {
      text-align: center;
      font-size: 14px;
      color: var(--ink-soft, #555);
    }

    .logo-img {
  max-height: 40px; /* Atur batas tinggi logo di sini */
  width: auto;       /* Lebar otomatis menyesuaikan proporsi */
  object-fit: contain;
}

    /* RESPONSIVE (tetap kanan-kiri, tidak pernah ditumpuk) */
    @media (max-width: 860px){
      .container { padding: 0 14px; }
      .login-wrapper { border-radius: 20px; }
      .login-promo { flex: 1 1 42%; padding: 20px; }
      .login-form-panel { flex: 1 1 58%; padding: 28px 20px; }
      .login-hero-media img { height: 160px; }
      .login-promo-heading { font-size: 18px; margin-bottom: 8px; }
      .login-promo-text { font-size: 12.5px; margin-bottom: 12px; }
      .login-form-title { font-size: 24px; }
    }

    @media (max-width: 640px){
      .container { padding: 0 8px; }
      .login-section { padding: 16px 0; }
      .login-wrapper { border-radius: 14px; }
      .login-promo { flex: 1 1 38%; padding: 12px; }
      .login-form-panel { flex: 1 1 62%; padding: 18px 12px; }
      .login-promo-header { margin-bottom: 12px; }
      .login-promo-heading { font-size: 13px; margin-bottom: 6px; line-height: 1.2; }
      .login-promo-text { font-size: 10px; margin-bottom: 8px; }
      .login-promo-divider { margin-bottom: 10px; }
      .login-promo-tags { gap: 6px; }
      .login-promo-tags span { font-size: 9px; padding: 4px 7px; }
      .login-form-title { font-size: 17px; margin-bottom: 6px; }
      .login-form-subtitle { font-size: 11px; margin-bottom: 12px; }
      .login-hero-media img { height: 100px; }
      .login-hero-media { margin-bottom: 12px; }
      .login-badge-category { font-size: 9px; padding: 4px 8px; }
      .login-badge-bestseller, .login-badge-rating { font-size: 8px; padding: 3px 7px; }
      .logo-img { max-height: 22px; }
      .btn-google, .btn-submit { padding: 10px 12px; font-size: 12px; }
      .login-field { margin-bottom: 10px; }
      .login-field label { font-size: 11px; margin-bottom: 5px; }
      .login-input-wrap input { padding: 9px 10px 9px 32px; font-size: 12px; }
    }
  </style>
</head>
<body>

<section class="login-section">
  <div class="container">
    <div class="login-wrapper">

      <!-- ===================== PANEL KIRI (PROMO) ===================== -->
      <div class="login-promo">

        <div class="login-promo-header reveal">
          <a href="/" class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="2DA Store" class="logo-img">
          </a>

          <div class="login-badge-category">
            Jajanan &amp; Minuman Kekinian
          </div>
        </div>

        <div class="login-hero-media reveal">
          <img src="{{ asset('images/herobaru.png') }}" alt="Corndog Mozza dan Es Teh Buah">
          <div class="login-badge-bestseller">Best Seller: Tempura Jontor</div>
          <div class="login-badge-rating"><span class="star">★</span> 4.9 <span class="muted">(2.4k+ ulasan pembeli)</span></div>
        </div>

        <h2 class="login-promo-heading reveal">Ngemil Enak, Mood Auto Naik!</h2>
        <p class="login-promo-text reveal">
          Temukan aneka corndog renyah, tempura jontor extra pedas, dan es jus buah segar favoritmu.
        </p>

        <hr class="login-promo-divider">

        <div class="login-promo-tags reveal">
          <span><img src="{{ asset('images/check.png') }}" alt="Check" class="tag-icon">100% Halal &amp; Higienis</span>
          <span><img src="{{ asset('images/motorbike.png') }}" alt="Rocket" class="tag-icon">Siap Kirim Hangat</span>
        </div>
      </div>

      <!-- ===================== PANEL KANAN (FORM LOGIN) ===================== -->
      <div class="login-form-panel reveal">

        <span class="login-welcome-pill">Selamat Datang!</span>
        <h2 class="login-form-title">Masuk ke Akun</h2>
        <p class="login-form-subtitle">Masuk untuk kumpulkan poin jajan &amp; nikmati promo diskon spesial.</p>

        @if (session('success'))
          <div class="login-flash-success" style="background:#e6f6ea; color:#1e7a34; border:1px solid #bfe6c9; border-radius:8px; padding:10px 14px; font-size:13px; margin-bottom:14px;">
            {{ session('success') }}
          </div>
        @endif

        @if (Route::has('login.google'))
          <button type="button" class="btn-google" onclick="window.location.href='{{ route('login.google') }}'">
            <img src="{{ asset('images/google.png') }}" alt="Google" class="btn-icon"> Lanjut dengan Google
          </button>
        @else 
          <button type="button" class="btn-google" disabled title="Login Google belum diaktifkan" style="opacity:.6; cursor:not-allowed;">
            <img src="{{ asset('images/google.png') }}" alt="Google" class="btn-icon"> Lanjut dengan Google
          </button>
        @endif

        <div class="login-divider-row"><span>ATAU MENGGUNAKAN EMAIL</span></div>

        <form method="POST" action="{{ route('login') }}">
          @csrf

          <div class="login-field">
            <label for="email">Email</label>
            <div class="login-input-wrap">
              <span class="icon-left">@</span>
              <input type="email" id="email" name="email" placeholder="nama@email.com" value="{{ old('email') }}" required autofocus>
            </div>
            @error('email')
              <small class="field-error">{{ $message }}</small>
            @enderror
          </div>

          <div class="login-field">
            <label for="password">Kata Sandi</label>
            <div class="login-input-wrap">
              <img src="{{ asset('images/padlock.png') }}" alt="Lock" class="input-icon-left">
              <input type="password" id="password" name="password" placeholder="Masukkan kata sandi kamu" required>
              <button type="button" class="toggle-password" id="togglePassword" aria-label="Tampilkan kata sandi">
                <img id="eyeIcon" src="https://cdn-icons-png.flaticon.com/128/709/709612.png" alt="Show Password" class="eye-img">
              </button>
            </div>
            @error('password')
              <small class="field-error">{{ $message }}</small>
            @enderror
          </div>

          <div class="login-row-between">
            <label class="remember-me">
              <input type="checkbox" name="remember">
              Ingat Saya
            </label>
            <a href="{{ route('password.request') }}" class="link-orange">Lupa Kata Sandi?</a>
          </div>

          <button type="submit" class="btn-submit">Masuk Sekarang →</button>
        </form>

        <p class="login-signup-text">
          Belum punya akun? <a href="{{ route('register') }}" class="link-orange">Daftar Akun Baru</a>
        </p>
      </div>

    </div>
  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    const urlEyeOpen = 'https://cdn-icons-png.flaticon.com/128/709/709612.png';
    const urlEyeClose = 'https://cdn-icons-png.flaticon.com/128/2767/2767146.png';

    togglePassword.addEventListener('click', function () {
      const isHidden = passwordInput.getAttribute('type') === 'password';
      
      // Ubah tipe input (text/password)
      passwordInput.setAttribute('type', isHidden ? 'text' : 'password');
      
      eyeIcon.src = isHidden ? urlEyeClose : urlEyeOpen;
    });
  });
</script>

</body>
</html>