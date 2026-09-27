@extends('layouts.applogin')

@section('title', __('pengaturan.page_title'))

@php
  $currentLocale = app()->getLocale();
  // fallback: kalau key belum ada di lang/pengaturan.php, pakai teks default ini
  // (biar tidak tampil mentah seperti "pengaturan.current_password_ph")
  $pt = fn($key, $default) => \Illuminate\Support\Facades\Lang::has('pengaturan.'.$key) ? __('pengaturan.'.$key) : $default;
@endphp

@push('styles')
<style>
  /* ---------- ACCOUNT PAGE (sama seperti biodata & riwayat) ---------- */
  .account-page{
    padding: 48px 0 90px;
    position:relative;
    overflow:hidden;
  }
  .account-page::before{
    content:"";
    position:absolute;
    top:-120px; left:-160px;
    width:520px; height:520px;
    background: radial-gradient(circle, var(--peach) 0%, transparent 70%);
    opacity:.6;
    pointer-events:none;
    z-index:0;
  }
  .account-page .container{ position:relative; z-index:1; }

  .account-grid{
    display:grid;
    grid-template-columns: 320px 1fr;
    gap:28px;
    align-items:start;
  }

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

  /* ---------- MAIN COLUMN ---------- */
  .account-main{
    display:flex;
    flex-direction:column;
    gap:24px;
  }

  .btn-outline-sm{
    display:inline-flex;
    align-items:center;
    gap:6px;
    background: var(--white);
    border:1.5px solid #e6d6c8;
    color: var(--ink);
    font-size:12px;
    font-weight:600;
    padding:10px 18px;
    border-radius: var(--radius-pill);
    white-space:nowrap;
    transition: border-color .2s ease, background .2s ease;
  }
  .btn-outline-sm:hover{ border-color: var(--brown); background: var(--cream-soft); }

  .btn-outline-danger{
    display:inline-flex;
    align-items:center;
    gap:6px;
    background: var(--white);
    border:1.5px solid #e3a5a0;
    color:#c0392b;
    font-size:12px;
    font-weight:700;
    padding:10px 18px;
    border-radius: var(--radius-pill);
    white-space:nowrap;
    transition: background .2s ease;
  }
  .btn-outline-danger:hover{ background:#fbe9e8; }

  /* tombol yang dibungkus <form> (Putuskan & Hapus Akun) tampil sama seperti link biasa */
  form.inline-form{ margin:0; display:inline-flex; }
  button.btn-outline-danger{ font-family:inherit; cursor:pointer; }
  button.action-link{ font-family:inherit; cursor:pointer; background:none; border:0; padding:0; }

  .btn-primary-sm{
    display:inline-flex;
    align-items:center;
    gap:8px;
    background: var(--orange);
    color:#fff;
    font-size:13px;
    font-weight:700;
    padding:12px 22px;
    border-radius: var(--radius-pill);
    white-space:nowrap;
    border:none;
    cursor:pointer;
    transition: background .2s ease;
  }
  .btn-primary-sm:hover{ background: var(--orange-dark); }

  /* ---------- SETTINGS CARD (base) ---------- */
  .settings-card{
    background: var(--white);
    border-radius: 10px;
    padding: 32px 34px;
    box-shadow: 0 14px 30px -18px rgba(60,30,10,.22);
  }
  .settings-card h1{
    font-family: var(--font-display);
    font-weight:800;
    font-size:19px;
    color: var(--ink);
    margin-bottom:6px;
  }
  .settings-card > p.settings-lead{
    font-size:12.5px;
    color: var(--ink-soft);
    max-width:560px;
  }
  .settings-divider{
    border:none;
    border-top:1px solid rgba(122,59,18,.09);
    margin:22px 0 26px;
  }
  .settings-block-title{
    font-family: var(--font-display);
    font-weight:700;
    font-size:14.5px;
    color: var(--ink);
    margin-bottom:5px;
  }
  .settings-block-desc{
    font-size:12px;
    color: var(--ink-soft);
    margin-bottom:20px;
  }

  /* ---------- PASSWORD FIELDS ---------- */
  .field-label{
    display:block;
    font-size:10px;
    letter-spacing:.05em;
    text-transform:uppercase;
    color: var(--ink-soft);
    margin-bottom:8px;
    font-weight:700;
  }
  .password-field{ position:relative; margin-bottom:22px; }
  .password-field input{
    width:100%;
    background: var(--cream-soft);
    border:1px solid rgba(122,59,18,.1);
    border-radius: 10px;
    padding:13px 44px 13px 16px;
    font-size:13px;
    color: var(--ink);
  }
  .password-field input::placeholder{ color:#b7a596; }
  .password-field input:focus{ outline:2px solid rgba(217,119,55,.25); }
  .password-field .toggle-eye{
    position:absolute;
    right:14px; top:50%;
    transform:translateY(-50%);
    background:none;
    border:none;
    color:#b7a596;
    cursor:pointer;
    display:flex;
  }
  .password-field .toggle-eye svg{ width:17px; height:17px; }

  .password-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
  }

  .strength-row{
    display:flex;
    align-items:center;
    justify-content:space-between;
    flex-wrap:wrap;
    gap:14px;
    margin-bottom:26px;
  }
  .strength-row .label{
    font-size:12.5px;
    color: var(--ink-soft);
  }
  .strength-bars span{
    width:34px; height:5px;
    border-radius:3px;
    background:#e6d6c8;
    transition: background .2s ease;
  }
  .strength-bars span.filled.weak{ background:#e74c3c; }
  .strength-bars span.filled.medium{ background:#e0a83e; }
  .strength-bars span.filled.strong{ background:#8bc34a; }
  .strength-bars span.filled.very-strong{ background:#4f7a35; }
  .strength-row .label strong{ font-weight:700; }
  .strength-row .label strong.weak{ color:#c0392b; }
  .strength-row .label strong.medium{ color:#b9770e; }
  .strength-row .label strong.strong{ color:#5f9a3b; }
  .strength-row .label strong.very-strong{ color:#4f7a35; }

  .field-error{
    font-size:11.5px;
    color:#c0392b;
    margin:-16px 0 18px;
  }

  .settings-card .actions-end{
    display:flex;
    justify-content:flex-end;
  }

  /* ---------- CONNECTED ACCOUNTS ---------- */
  .connected-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
  }
  .connected-item{
    background: var(--cream-soft);
    border-radius: 10px;
    padding:20px 22px;
  }
  .connected-item-head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
    margin-bottom:12px;
  }
  .connected-item-head .title{
    display:flex;
    align-items:center;
    gap:10px;
    font-size:13.5px;
    font-weight:700;
    color: var(--ink);
  }
  .connected-item-head .title svg{ width:20px; height:20px; color: var(--orange-dark); flex:none; }
  .status-pill{
    display:inline-flex;
    align-items:center;
    gap:5px;
    background:#e8f3de;
    color:#4f7a35;
    font-size:10px;
    font-weight:700;
    letter-spacing:.03em;
    padding:5px 10px;
    border-radius: var(--radius-pill);
    white-space:nowrap;
  }
  .status-pill svg{ width:11px; height:11px; }
  .connected-item .value{
    font-size:13px;
    font-weight:700;
    color: var(--ink);
    margin-bottom:3px;
  }
  .connected-item .desc{
    font-size:11.5px;
    color: var(--ink-soft);
  }
  .connected-item-footer{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
    margin-top:16px;
    padding-top:14px;
    border-top:1px solid rgba(122,59,18,.1);
  }
  .connected-item-footer .muted{ font-size:11.5px; color: var(--ink-soft); }
  .connected-item-footer .action-link{
    font-size:12px;
    font-weight:700;
    color: var(--ink);
  }
  .connected-item-footer .action-link:hover{ color: var(--orange-dark); }

  /* ---------- PRIVACY & DANGER ZONE ---------- */
  .privacy-row{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
    flex-wrap:wrap;
    background: var(--cream-soft);
    border-radius: 10px;
    padding:20px 22px;
    margin-bottom:16px;
  }
  .privacy-row:last-child{ margin-bottom:0; }
  .privacy-row .title{
    font-size:13.5px;
    font-weight:700;
    color: var(--ink);
    margin-bottom:5px;
  }
  .privacy-row .desc{
    font-size:12px;
    color: var(--ink-soft);
    max-width:560px;
  }
  .privacy-row.danger{
    background:#fdeeed;
    border:1px solid #f3c8c4;
  }
  .privacy-row.danger .title{ color:#c0392b; }
  .privacy-row.danger .desc{ color:#a85a52; }
  .privacy-row.danger .desc strong{ color:#8f3a33; }

  /* ---------- RESPONSIVE ---------- */
  @media (max-width: 980px){
    .account-grid{ grid-template-columns:1fr; }
    .password-grid{ grid-template-columns:1fr; }
    .connected-grid{ grid-template-columns:1fr; }
  }
  @media (max-width: 560px){
    .settings-card{ padding:24px 20px; }
    .privacy-row{ flex-direction:column; align-items:flex-start; }
  }
</style>
@endpush

@section('content')

  <section class="account-page reveal">
    <div class="container">
      <div class="account-grid">

        <!-- SIDEBAR -->
        {{-- totalPesanan: dummy sementara, samakan dgn jumlah $orders di route /riwayat (web.php) --}}
        @include('partials.sidebarakun', ['active' => 'pengaturan', 'totalPesanan' => 5])

        <!-- MAIN -->
        <div class="account-main">

          <!-- KEAMANAN & AUTENTIKASI -->
          <div class="settings-card">
            <h1>{{ __('pengaturan.security_title') }}</h1>
            <p class="settings-lead">{{ __('pengaturan.security_lead') }}</p>

            <hr class="settings-divider">

            <div class="settings-block-title">{{ __('pengaturan.change_password') }}</div>
            <p class="settings-block-desc">{{ __('pengaturan.password_rule') }}</p>

            <form action="{{ url('/akun/password') }}" method="POST" id="formUbahSandi">
              @csrf
              @method('PUT')

              <label class="field-label">{{ __('pengaturan.current_password') }}</label>
              <div class="password-field">
                <input type="password" name="current_password" placeholder="{{ $pt('current_password_ph', '••••••••••••') }}" autocomplete="current-password" required>
                <button type="button" class="toggle-eye" data-target-eye>
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a21.86 21.86 0 0 1 5.06-6.94M9.9 4.24A10.94 10.94 0 0 1 12 4c7 0 11 8 11 8a21.82 21.82 0 0 1-2.16 3.19"/><path d="M14.12 14.12a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                </button>
              </div>
              @error('current_password')
                <p class="field-error">{{ $message }}</p>
              @enderror

              <div class="password-grid">
                <div>
                  <label class="field-label">{{ __('pengaturan.new_password') }}</label>
                  <div class="password-field" style="margin-bottom:0;">
                    <input type="password" name="password" id="passwordBaru" placeholder="{{ __('pengaturan.new_password_ph') }}" autocomplete="new-password" required>
                    <button type="button" class="toggle-eye" data-target-eye>
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                  </div>
                  @error('password')
                    <p class="field-error">{{ $message }}</p>
                  @enderror
                </div>
                <div>
                  <label class="field-label">{{ __('pengaturan.confirm_password') }}</label>
                  <div class="password-field" style="margin-bottom:0;">
                    <input type="password" name="password_confirmation" placeholder="{{ __('pengaturan.confirm_password_ph') }}" autocomplete="new-password" required>
                    <button type="button" class="toggle-eye" data-target-eye>
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                  </div>
                </div>
              </div>

              <div class="strength-row" style="margin-top:22px;">
                <span class="label" id="strengthLabelWrap" style="display:none;">{{ __('pengaturan.strength_label') }}: <strong id="strengthText"></strong></span>
                <div class="strength-bars" id="strengthBars">
                  <span></span><span></span><span></span><span></span>
                </div>
              </div>

              <div class="actions-end">
                <button type="submit" class="btn-primary-sm">
                  <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg>
                  {{ __('pengaturan.update_password') }}
                </button>
              </div>
            </form>
          </div>

          <!-- AKUN TERHUBUNG -->
          <div class="settings-card">
            <h1>{{ __('pengaturan.connected_title') }}</h1>
            <p class="settings-lead">{{ __('pengaturan.connected_lead') }}</p>

            <hr class="settings-divider">

            <div class="connected-grid">
              <div class="connected-item">
                <div class="connected-item-head">
                  <span class="title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="10" r="3"/><path d="M6.5 19a6 6 0 0 1 11 0"/></svg>
                    Google Account
                  </span>
                  <span class="status-pill">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ __('pengaturan.connected_status') }}
                  </span>
                </div>
                <p class="value">{{ auth()->user()->email }}</p>
                <p class="desc">{{ __('pengaturan.google_desc') }}</p>
                <div class="connected-item-footer">
                  <span class="muted">{{ __('pengaturan.auto_synced') }}</span>
                  <form action="/akun/google" method="POST" class="inline-form" onsubmit="return confirm(@js(__('pengaturan.confirm_disconnect')));">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-link">{{ __('pengaturan.disconnect') }}</button>
                  </form>
                </div>
              </div>

              <div class="connected-item">
                <div class="connected-item-head">
                  <span class="title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    {{ __('pengaturan.whatsapp_name') }}
                  </span>
                  <span class="status-pill">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ __('pengaturan.connected_status') }}
                  </span>
                </div>
                <p class="value">{{ auth()->user()->phone }}</p>
                <p class="desc">{{ __('pengaturan.whatsapp_desc') }}</p>
                <div class="connected-item-footer">
                  <span class="muted">{{ __('pengaturan.verification_active') }}</span>
                  <a href="/biodata" class="action-link">{{ __('pengaturan.change_number') }}</a>
                </div>
              </div>
            </div>
          </div>

          <!-- PRIVASI & PENONAKTIFAN AKUN -->
          <div class="settings-card">
            <h1>{{ __('pengaturan.privacy_title') }}</h1>
            <p class="settings-lead">{{ __('pengaturan.privacy_lead') }}</p>

            <hr class="settings-divider">

            <div class="privacy-row">
              <div>
                <p class="title">{{ __('pengaturan.download_title') }}</p>
                <p class="desc">{{ __('pengaturan.download_desc', ['orders' => auth()->user()->transaksi()->count()]) }}</p>
              </div>
              <a href="/akun/arsip" class="btn-outline-sm">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                {{ __('pengaturan.download_button') }}
              </a>
            </div>

            <div class="privacy-row danger">
              <div>
                <p class="title">{{ __('pengaturan.delete_title') }}</p>
                <p class="desc">{!! __('pengaturan.delete_desc') !!}</p>
              </div>
              <form action="/akun" method="POST" class="inline-form" onsubmit="return confirm(@js(__('pengaturan.confirm_delete')));">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-outline-danger">{{ __('pengaturan.delete_button') }}</button>
              </form>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

@endsection

@push('scripts')
<script>
  // Toggle tampil/sembunyi kata sandi
  document.querySelectorAll('[data-target-eye]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var input = btn.closest('.password-field').querySelector('input');
      input.type = input.type === 'password' ? 'text' : 'password';
    });
  });

  // Indikator kekuatan kata sandi baru (dihitung live, bukan statis)
  (function () {
    var input = document.getElementById('passwordBaru');
    if (!input) return;

    var labelWrap = document.getElementById('strengthLabelWrap');
    var textEl = document.getElementById('strengthText');
    var bars = document.querySelectorAll('#strengthBars span');

    function scorePassword(val) {
      var score = 0;
      if (val.length >= 8) score++;
      if (/[a-z]/.test(val)) score++;
      if (/[A-Z]/.test(val)) score++;
      if (/[0-9]/.test(val)) score++;
      if (/[^A-Za-z0-9]/.test(val)) score++;
      return score;
    }

    function render() {
      var val = input.value;

      bars.forEach(function (b) { b.className = ''; });

      if (!val) {
        labelWrap.style.display = 'none';
        return;
      }

      var score = scorePassword(val);
      var level, filled, cls;
      if (score <= 1) { level = 'Lemah'; filled = 1; cls = 'weak'; }
      else if (score === 2) { level = 'Sedang'; filled = 2; cls = 'medium'; }
      else if (score <= 4) { level = 'Kuat'; filled = 3; cls = 'strong'; }
      else { level = 'Sangat Kuat'; filled = 4; cls = 'very-strong'; }

      labelWrap.style.display = '';
      textEl.textContent = level;
      textEl.className = cls;
      bars.forEach(function (b, i) {
        b.className = i < filled ? 'filled ' + cls : '';
      });
    }

    input.addEventListener('input', render);
    render();
  })();
</script>
@endpush