@extends('layouts.applogin')

@section('title', __('riwayat.page_title'))

@push('styles')
<style>
  /* ---------- ACCOUNT PAGE (sama seperti biodata) ---------- */
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
    transition: background .2s ease;
  }
  .btn-primary-sm:hover{ background: var(--orange-dark); }

  .btn-soft-sm{
    display:inline-flex;
    align-items:center;
    gap:6px;
    background:#fdebd9;
    color: var(--orange-dark);
    font-size:12px;
    font-weight:700;
    padding:10px 18px;
    border-radius: var(--radius-pill);
    white-space:nowrap;
    transition: background .2s ease;
  }
  .btn-soft-sm:hover{ background:#fbdfc0; }

  .link-review{
    display:inline-flex;
    align-items:center;
    gap:6px;
    font-size:12.5px;
    font-weight:700;
    color: var(--orange-dark);
  }
  .link-review svg{ width:15px; height:15px; fill: var(--orange-dark); }

  /* ---------- BILLING SUMMARY CARD ---------- */
  .billing-card{
    background: var(--white);
    border-radius: 10px;
    padding: 30px 32px;
    box-shadow: 0 14px 30px -18px rgba(60,30,10,.22);
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:24px;
    flex-wrap:wrap;
  }
  .billing-card h1{
    font-family: var(--font-display);
    font-weight:800;
    font-size:20px;
    color: var(--ink);
    margin-bottom:8px;
  }
  .billing-card p{
    font-size:12.5px;
    color: var(--ink-soft);
    max-width:440px;
    margin-bottom:18px;
  }
  .billing-total-box{
    display:inline-block;
    background: var(--cream-soft);
    border-radius: 10px;
    padding:14px 20px;
  }
  .billing-total-box .label{
    display:block;
    font-size:9.5px;
    letter-spacing:.05em;
    text-transform:uppercase;
    color: var(--ink-soft);
    margin-bottom:4px;
  }
  .billing-total-box .value{
    font-family: var(--font-display);
    font-weight:700;
    font-size:16px;
    color: var(--ink);
  }

  /* ---------- FILTER & SEARCH BAR ---------- */
  .filter-bar{
    background: var(--white);
    border-radius: 10px;
    box-shadow: 0 14px 30px -18px rgba(60,30,10,.22);
    padding:16px 18px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:16px;
    flex-wrap:nowrap;
  }
  .filter-tabs{
    display:flex;
    flex-wrap:wrap;
    gap:8px;
    flex:0 1 auto;
    min-width:0;
  }
  .filter-tab{
    background: var(--cream-soft);
    color: var(--ink);
    font-size:12.5px;
    font-weight:600;
    padding:9px 16px;
    border-radius: var(--radius-pill);
    border:none;
    cursor:pointer;
    transition: background .2s ease, color .2s ease;
  }
  .filter-tab:hover{ background:#f0e4d6; }
  .filter-tab.active{ background: var(--orange); color:#fff; }

  .filter-search{
    display:flex;
    align-items:center;
    gap:10px;
    flex:1 1 auto;
    justify-content:flex-end;
    min-width:170px;
  }
  .search-box{
    position:relative;
    width:100%;
    max-width:260px;
  }
  .search-box svg{
    position:absolute;
    left:14px; top:50%;
    transform:translateY(-50%);
    width:15px; height:15px;
    color:#b7a596;
  }
  .search-box input{
    width:100%;
    background: var(--cream-soft);
    border:1px solid rgba(122,59,18,.08);
    border-radius: var(--radius-pill);
    padding:10px 16px 10px 38px;
    font-size:12.5px;
    color: var(--ink);
  }
  .search-box input::placeholder{ color:#b7a596; }
  .search-box input:focus{ outline:2px solid rgba(217,119,55,.25); }

  .icon-btn{
    width:38px; height:38px;
    display:flex; align-items:center; justify-content:center;
    background: var(--cream-soft);
    border:1px solid rgba(122,59,18,.08);
    border-radius: var(--radius-pill);
    color: var(--ink);
    flex:none;
    transition: background .2s ease;
  }
  .icon-btn{ cursor:pointer; }
  .icon-btn:hover{ background:#f0e4d6; }
  .icon-btn.active{ background: var(--orange); border-color: var(--orange); color:#fff; }
  .icon-btn svg{ width:16px; height:16px; }
  .date-wrap{ position:relative; flex:none; }
  .date-wrap input[type="date"]{
    position:absolute; left:0; bottom:0;
    width:38px; height:38px;
    opacity:0; pointer-events:none;
    border:0; padding:0;
  }

  /* ---------- RIWAYAT (ORDER HISTORY) CARDS ---------- */
  .riwayat-card{
    background: var(--white);
    border-radius: 10px;
    padding: 28px 30px;
    box-shadow: 0 14px 30px -18px rgba(60,30,10,.22);
  }
  .riwayat-card[hidden]{ display:none; }
  .riwayat-card.highlight{
    box-shadow: 0 0 0 2px rgba(217,119,55,.35), 0 14px 30px -18px rgba(60,30,10,.22);
  }

  .riwayat-top{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:16px;
    flex-wrap:wrap;
  }
  .riwayat-id-row{
    display:flex;
    align-items:center;
    gap:10px;
    flex-wrap:wrap;
  }
  .riwayat-id-row h3{
    font-family: var(--font-display);
    font-weight:800;
    font-size:15px;
    color: var(--ink);
  }
  .status-badge{
    font-size:10.5px;
    font-weight:700;
    letter-spacing:.02em;
    padding:5px 12px;
    border-radius: var(--radius-pill);
    white-space:nowrap;
  }
  .status-badge.progress{ background:#fdebd9; color: var(--orange-dark); }
  .status-badge.success{ background:#e8f3de; color:#4f7a35; }
  .status-badge.cancelled{ background:#fbe4e1; color:#c0392b; }

  .riwayat-meta{
    font-size:12px;
    color: var(--ink-soft);
    margin-top:6px;
  }

  .riwayat-total{ text-align:right; }
  .riwayat-total .label{
    display:block;
    font-size:9.5px;
    letter-spacing:.05em;
    text-transform:uppercase;
    color: var(--ink-soft);
    margin-bottom:4px;
  }
  .riwayat-total .value{
    font-family: var(--font-display);
    font-weight:700;
    font-size:17px;
    color: var(--ink);
  }
  .riwayat-total .value.accent{ color: var(--orange-dark); }
  .riwayat-total .pay-status{
    display:block;
    font-size:11px;
    font-weight:600;
    margin-top:3px;
    color:#4f7a35;
  }
  .riwayat-total .pay-status.muted{ color: var(--ink-soft); }

  .riwayat-body{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
    flex-wrap:wrap;
    margin-top:20px;
    padding-top:20px;
    border-top:1px solid rgba(122,59,18,.08);
  }
  .riwayat-items p{
    font-size:12.5px;
    color: var(--ink);
    margin-bottom:4px;
  }
  .riwayat-items p:last-child{ margin-bottom:0; }
  .riwayat-items strong{ font-weight:700; }

  .riwayat-courier{
    background: var(--cream-soft);
    border-radius: 10px;
    padding:12px 16px;
    flex:none;
  }
  .riwayat-courier .name{
    font-size:12.5px;
    font-weight:700;
    color: var(--ink);
  }
  .riwayat-courier .detail{
    font-size:11px;
    color: var(--ink-soft);
    margin-top:2px;
  }

  .riwayat-footer{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:16px;
    flex-wrap:wrap;
    margin-top:20px;
    padding-top:20px;
    border-top:1px solid rgba(122,59,18,.08);
  }
  .riwayat-invoice-note{
    display:inline-flex;
    align-items:center;
    gap:6px;
    font-size:11.5px;
    color: var(--ink-soft);
  }
  .riwayat-invoice-note svg{ width:14px; height:14px; color:#5f9a3b; flex:none; }
  .riwayat-actions{
    display:flex;
    align-items:center;
    gap:10px;
    flex-wrap:wrap;
  }

  .riwayat-empty{
    text-align:center;
    padding:34px 16px;
    font-size:13px;
    color: var(--ink-soft);
    background: var(--white);
    border-radius:10px;
    box-shadow: 0 14px 30px -18px rgba(60,30,10,.22);
  }
  .riwayat-empty[hidden]{ display:none; }

  /* ---------- RESPONSIVE ---------- */
  @media (max-width: 980px){
    .account-grid{ grid-template-columns:1fr; }
    .billing-card{ flex-direction:column; align-items:flex-start; }
  }
  @media (max-width: 560px){
    .riwayat-card{ padding:22px 18px; }
    .riwayat-total{ text-align:left; }
    .filter-bar{ flex-direction:column; align-items:stretch; }
    .filter-search{ justify-content:stretch; }
    .search-box{ max-width:none; }
  }
</style>
@endpush

@section('content')

  <section class="account-page">
    <div class="container">
      <div class="account-grid">

        <!-- SIDEBAR -->
        @include('partials.sidebarakun', ['active' => 'riwayat'])

        <!-- MAIN -->
        <div class="account-main">

          <!-- RINGKASAN TAGIHAN BULANAN -->
          <div class="billing-card">
            <div>
              <h1>{{ __('riwayat.billing_title') }}</h1>
              <p>{{ __('riwayat.billing_lead') }}</p>
              <div class="billing-total-box">
                <span class="label">{{ __('riwayat.total_transaction') }}</span>
                <span class="value" id="billingTotal">Rp 385.000</span>
              </div>
            </div>
          </div>

          <!-- FILTER & PENCARIAN -->
          <div class="filter-bar">
            <div class="filter-tabs">
              <button type="button" class="filter-tab active" data-filter="all">{{ __('riwayat.tab_all', ['count' => 18]) }}</button>
              <button type="button" class="filter-tab" data-filter="ongoing">{{ __('riwayat.tab_ongoing', ['count' => 1]) }}</button>
              <button type="button" class="filter-tab" data-filter="done">{{ __('riwayat.tab_done', ['count' => 16]) }}</button>
              <button type="button" class="filter-tab" data-filter="cancelled">{{ __('riwayat.tab_cancelled', ['count' => 1]) }}</button>
            </div>
            <div class="filter-search">
              <div class="search-box">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" id="riwayatSearch" autocomplete="off" placeholder="{{ __('riwayat.search_ph') }}" aria-label="{{ __('riwayat.search_ph') }}">
              </div>
              @php
                $rt = fn($key, $default) => \Illuminate\Support\Facades\Lang::has('riwayat.'.$key) ? __('riwayat.'.$key) : $default;
              @endphp
              <div class="date-wrap">
                <button type="button" class="icon-btn" id="riwayatDateBtn" title="{{ $rt('filter_date', 'Filter tanggal') }}" aria-label="{{ $rt('filter_date', 'Filter tanggal') }}" data-title-on="{{ $rt('filter_date_clear', 'Hapus filter tanggal') }}" data-title-off="{{ $rt('filter_date', 'Filter tanggal') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
              </button>
                <input type="date" id="riwayatDate" tabindex="-1" aria-hidden="true">
              </div>
            </div>
          </div>

          <!-- DAFTAR PESANAN -->

          <!-- Pesanan #1: Dalam Pengantaran -->
          <div class="riwayat-card highlight" data-date="{{ now()->toDateString() }}">
            <div class="riwayat-top">
              <div>
                <div class="riwayat-id-row">
                  <h3>#2DA-89211</h3>
                  <span class="status-badge progress">{{ __('riwayat.status_delivering') }}</span>
                </div>
                <p class="riwayat-meta">{{ __('riwayat.today') }}, 11:20 WIB &bull; Tebet Barat Dalam VI (Rumah Tinggal)</p>
              </div>
              <div class="riwayat-total">
                <span class="label">{{ __('riwayat.total_bill') }}</span>
                <span class="value accent">Rp 25.000</span>
                <span class="pay-status">{{ __('riwayat.pay_qris_paid') }}</span>
              </div>
            </div>

            <div class="riwayat-body">
              <div class="riwayat-items">
                <p><strong>2x Corndog Mini Mozarella</strong> (Saos Sambal &amp; Mayo Gurih)</p>
                <p><strong>1x Cireng Isi Mini</strong> (Bumbu Tabur Pedas)</p>
              </div>
              <div class="riwayat-courier">
                <p class="name">{{ __('riwayat.courier', ['name' => 'Kang Rahmat']) }}</p>
                <p class="detail">Honda Vario &bull; {{ __('riwayat.eta_8min') }}</p>
              </div>
            </div>

            <div class="riwayat-footer">
              <span class="riwayat-invoice-note">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="9"/></svg>
                {{ __('riwayat.invoice_no') }} INV/20241018/2DA/89211
              </span>
              <div class="riwayat-actions">
                <a href="#" class="btn-outline-sm" data-modal-open="modalDetailPesanan">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-1"/><path d="M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2"/><line x1="9" y1="14" x2="15" y2="14"/><line x1="9" y1="18" x2="15" y2="18"/></svg>
                  {{ __('riwayat.detail_invoice') }}
                </a>
              </div>
            </div>
          </div>

          <!-- Pesanan #2: Selesai -->
          <div class="riwayat-card" data-date="{{ now()->subDay()->toDateString() }}">
            <div class="riwayat-top">
              <div>
                <div class="riwayat-id-row">
                  <h3>#2DA-87104</h3>
                  <span class="status-badge success">{{ __('riwayat.status_done') }}</span>
                </div>
                <p class="riwayat-meta">{{ __('riwayat.yesterday') }}, 14:15 WIB &bull; Kantor Menara Karya (Studio)</p>
              </div>
              <div class="riwayat-total">
                <span class="label">{{ __('riwayat.total_bill') }}</span>
                <span class="value">Rp 35.000</span>
                <span class="pay-status">{{ __('riwayat.pay_qris_paid') }}</span>
              </div>
            </div>

            <div class="riwayat-body">
              <div class="riwayat-items">
                <p><strong>2x Corndog Mini Mozarella</strong> (Saus Sambal)</p>
                <p><strong>1x Cireng Isi Mini + 2x Pop Ice Chocolate</strong></p>
              </div>
              <span class="link-review">
                <svg viewBox="0 0 20 20"><path d="M10 1l2.755 5.91L19 7.64l-4.5 4.386L15.51 18 10 14.911 4.49 18l1.01-5.973L1 7.64l6.245-.73z"/></svg>
                {{ __('riwayat.rated') }}
              </span>
            </div>

            <div class="riwayat-footer">
              <span class="riwayat-invoice-note">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="9"/></svg>
                {{ __('riwayat.received_reception') }}
              </span>
              <div class="riwayat-actions">
                <a href="/invoice/2DA-87104" class="btn-outline-sm">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                  {{ __('riwayat.download_invoice') }}
                </a>
                <a href="/menulogin" class="btn-soft-sm">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 4v6h6"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg>
                  {{ __('riwayat.order_again') }}
                </a>
              </div>
            </div>
          </div>

          <!-- Pesanan #3: Selesai -->
          <div class="riwayat-card" data-date="2024-10-12">
            <div class="riwayat-top">
              <div>
                <div class="riwayat-id-row">
                  <h3>#2DA-84920</h3>
                  <span class="status-badge success">{{ __('riwayat.status_done') }}</span>
                </div>
                <p class="riwayat-meta">{{ __('riwayat.sample_date') }}, 19:30 WIB &bull; Tebet Barat Dalam VI</p>
              </div>
              <div class="riwayat-total">
                <span class="label">{{ __('riwayat.total_bill') }}</span>
                <span class="value">Rp 10.000</span>
                <span class="pay-status muted">{{ __('riwayat.pay_cod_done') }}</span>
              </div>
            </div>

            <div class="riwayat-body">
              <div class="riwayat-items">
                <p><strong>1x Corndog Mini Mozarella</strong> (Saus Mayo)</p>
                <p><strong>1x Ice Good Day Freeze</strong> (Extra Ice)</p>
              </div>
              <a href="/form-pesanan?pesanan=2DA-84920" class="link-review">
                <svg viewBox="0 0 20 20"><path d="M10 1l2.755 5.91L19 7.64l-4.5 4.386L15.51 18 10 14.911 4.49 18l1.01-5.973L1 7.64l6.245-.73z"/></svg>
                {{ __('riwayat.write_review') }}
              </a>
            </div>

            <div class="riwayat-footer">
              <span class="riwayat-invoice-note">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="9"/></svg>
                {{ __('riwayat.invoice_no') }} INV/20241012/2DA/84920
              </span>
              <div class="riwayat-actions">
                <a href="/invoice/2DA-84920" class="btn-outline-sm">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                  {{ __('riwayat.download_invoice') }}
                </a>
                <a href="/menulogin" class="btn-soft-sm">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 4v6h6"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg>
                  {{ __('riwayat.order_again') }}
                </a>
              </div>
            </div>
          </div>

          <!-- Pesanan: Selesai (2024-10-10) -->
          <div class="riwayat-card" data-date="2024-10-10">
            <div class="riwayat-top">
              <div>
                <div class="riwayat-id-row">
                  <h3>#2DA-84512</h3>
                  <span class="status-badge success">{{ __('riwayat.status_done') }}</span>
                </div>
                <p class="riwayat-meta">{{ \Carbon\Carbon::parse('2024-10-10')->locale(app()->getLocale())->translatedFormat('j M Y') }}, 12:40 WIB &bull; Kantor Menara Karya (Studio)</p>
              </div>
              <div class="riwayat-total">
                <span class="label">{{ __('riwayat.total_bill') }}</span>
                <span class="value">Rp 30.000</span>
                <span class="pay-status">{{ __('riwayat.pay_qris_paid') }}</span>
              </div>
            </div>

            <div class="riwayat-body">
              <div class="riwayat-items">
                <p><strong>2x Corndog Mini Mozarella</strong> (Saus Sambal)</p>
                <p><strong>1x Cireng Isi Mini</strong> (Bumbu Tabur Pedas)</p>
              </div>
              <span class="link-review">
                <svg viewBox="0 0 20 20"><path d="M10 1l2.755 5.91L19 7.64l-4.5 4.386L15.51 18 10 14.911 4.49 18l1.01-5.973L1 7.64l6.245-.73z"/></svg>
                {{ __('riwayat.rated') }}
              </span>
            </div>

            <div class="riwayat-footer">
              <span class="riwayat-invoice-note">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="9"/></svg>
                {{ __('riwayat.received_reception') }}
              </span>
              <div class="riwayat-actions">
                <a href="/invoice/2DA-84512" class="btn-outline-sm">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                  {{ __('riwayat.download_invoice') }}
                </a>
                <a href="/menulogin" class="btn-soft-sm">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 4v6h6"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg>
                  {{ __('riwayat.order_again') }}
                </a>
              </div>
            </div>
          </div>

          <!-- Pesanan: Dibatalkan (2024-10-09) -->
          <div class="riwayat-card" data-date="2024-10-09">
            <div class="riwayat-top">
              <div>
                <div class="riwayat-id-row">
                  <h3>#2DA-84377</h3>
                  <span class="status-badge cancelled">{{ $rt('status_cancelled', 'Dibatalkan') }}</span>
                </div>
                <p class="riwayat-meta">{{ \Carbon\Carbon::parse('2024-10-09')->locale(app()->getLocale())->translatedFormat('j M Y') }}, 19:05 WIB &bull; Tebet Barat Dalam VI (Rumah Tinggal)</p>
              </div>
              <div class="riwayat-total">
                <span class="label">{{ __('riwayat.total_bill') }}</span>
                <span class="value">Rp 30.000</span>
                <span class="pay-status muted">{{ $rt('pay_cancelled', 'Pembayaran dibatalkan') }}</span>
              </div>
            </div>

            <div class="riwayat-body">
              <div class="riwayat-items">
                <p><strong>3x Corndog Mini Mozarella</strong> (Saus Mayo)</p>
                <p><strong>1x Ice Good Day Freeze</strong></p>
              </div>
            </div>

            <div class="riwayat-footer">
              <span class="riwayat-invoice-note">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                {{ $rt('cancelled_note', 'Pesanan dibatalkan sebelum diproses') }}
              </span>
              <div class="riwayat-actions">
                <a href="/menulogin" class="btn-soft-sm">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 4v6h6"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg>
                  {{ __('riwayat.order_again') }}
                </a>
              </div>
            </div>
          </div>

          <!-- Pesanan: Selesai (2024-10-08) -->
          <div class="riwayat-card" data-date="2024-10-08">
            <div class="riwayat-top">
              <div>
                <div class="riwayat-id-row">
                  <h3>#2DA-84105</h3>
                  <span class="status-badge success">{{ __('riwayat.status_done') }}</span>
                </div>
                <p class="riwayat-meta">{{ \Carbon\Carbon::parse('2024-10-08')->locale(app()->getLocale())->translatedFormat('j M Y') }}, 13:10 WIB &bull; Kantor Menara Karya (Studio)</p>
              </div>
              <div class="riwayat-total">
                <span class="label">{{ __('riwayat.total_bill') }}</span>
                <span class="value">Rp 25.000</span>
                <span class="pay-status muted">{{ __('riwayat.pay_cod_done') }}</span>
              </div>
            </div>

            <div class="riwayat-body">
              <div class="riwayat-items">
                <p><strong>2x Corndog Mini Mozarella</strong> (Saos Sambal &amp; Mayo Gurih)</p>
                <p><strong>1x Cireng Isi Mini</strong> (Bumbu Tabur Original)</p>
              </div>
              <span class="link-review">
                <svg viewBox="0 0 20 20"><path d="M10 1l2.755 5.91L19 7.64l-4.5 4.386L15.51 18 10 14.911 4.49 18l1.01-5.973L1 7.64l6.245-.73z"/></svg>
                {{ __('riwayat.rated') }}
              </span>
            </div>

            <div class="riwayat-footer">
              <span class="riwayat-invoice-note">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="9"/></svg>
                {{ __('riwayat.received_reception') }}
              </span>
              <div class="riwayat-actions">
                <a href="/invoice/2DA-84105" class="btn-outline-sm">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                  {{ __('riwayat.download_invoice') }}
                </a>
                <a href="/menulogin" class="btn-soft-sm">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 4v6h6"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg>
                  {{ __('riwayat.order_again') }}
                </a>
              </div>
            </div>
          </div>

          <!-- Pesanan: Selesai (2024-10-06) -->
          <div class="riwayat-card" data-date="2024-10-06">
            <div class="riwayat-top">
              <div>
                <div class="riwayat-id-row">
                  <h3>#2DA-83840</h3>
                  <span class="status-badge success">{{ __('riwayat.status_done') }}</span>
                </div>
                <p class="riwayat-meta">{{ \Carbon\Carbon::parse('2024-10-06')->locale(app()->getLocale())->translatedFormat('j M Y') }}, 15:45 WIB &bull; Kantor Menara Karya (Studio)</p>
              </div>
              <div class="riwayat-total">
                <span class="label">{{ __('riwayat.total_bill') }}</span>
                <span class="value">Rp 45.000</span>
                <span class="pay-status">{{ __('riwayat.pay_qris_paid') }}</span>
              </div>
            </div>

            <div class="riwayat-body">
              <div class="riwayat-items">
                <p><strong>3x Corndog Mini Mozarella</strong> (Saus Sambal)</p>
                <p><strong>2x Cireng Isi Mini</strong> (Bumbu Tabur Pedas)</p>
                <p><strong>2x Pop Ice Chocolate</strong></p>
              </div>
              <span class="link-review">
                <svg viewBox="0 0 20 20"><path d="M10 1l2.755 5.91L19 7.64l-4.5 4.386L15.51 18 10 14.911 4.49 18l1.01-5.973L1 7.64l6.245-.73z"/></svg>
                {{ __('riwayat.rated') }}
              </span>
            </div>

            <div class="riwayat-footer">
              <span class="riwayat-invoice-note">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="9"/></svg>
                {{ __('riwayat.received_reception') }}
              </span>
              <div class="riwayat-actions">
                <a href="/invoice/2DA-83840" class="btn-outline-sm">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                  {{ __('riwayat.download_invoice') }}
                </a>
                <a href="/menulogin" class="btn-soft-sm">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 4v6h6"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg>
                  {{ __('riwayat.order_again') }}
                </a>
              </div>
            </div>
          </div>

          <!-- Pesanan: Selesai (2024-10-04) -->
          <div class="riwayat-card" data-date="2024-10-04">
            <div class="riwayat-top">
              <div>
                <div class="riwayat-id-row">
                  <h3>#2DA-83422</h3>
                  <span class="status-badge success">{{ __('riwayat.status_done') }}</span>
                </div>
                <p class="riwayat-meta">{{ \Carbon\Carbon::parse('2024-10-04')->locale(app()->getLocale())->translatedFormat('j M Y') }}, 18:20 WIB &bull; Tebet Barat Dalam VI (Rumah Tinggal)</p>
              </div>
              <div class="riwayat-total">
                <span class="label">{{ __('riwayat.total_bill') }}</span>
                <span class="value">Rp 20.000</span>
                <span class="pay-status">{{ $rt('pay_va_paid', 'Virtual Account &bull; Lunas') }}</span>
              </div>
            </div>

            <div class="riwayat-body">
              <div class="riwayat-items">
                <p><strong>2x Corndog Mini Mozarella</strong> (Saus Mayo)</p>
                <p><strong>1x Pop Ice Chocolate</strong></p>
              </div>
              <span class="link-review">
                <svg viewBox="0 0 20 20"><path d="M10 1l2.755 5.91L19 7.64l-4.5 4.386L15.51 18 10 14.911 4.49 18l1.01-5.973L1 7.64l6.245-.73z"/></svg>
                {{ __('riwayat.rated') }}
              </span>
            </div>

            <div class="riwayat-footer">
              <span class="riwayat-invoice-note">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="9"/></svg>
                {{ __('riwayat.received_reception') }}
              </span>
              <div class="riwayat-actions">
                <a href="/invoice/2DA-83422" class="btn-outline-sm">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                  {{ __('riwayat.download_invoice') }}
                </a>
                <a href="/menulogin" class="btn-soft-sm">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 4v6h6"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg>
                  {{ __('riwayat.order_again') }}
                </a>
              </div>
            </div>
          </div>

          <!-- Pesanan: Selesai (2024-10-03) -->
          <div class="riwayat-card" data-date="2024-10-03">
            <div class="riwayat-top">
              <div>
                <div class="riwayat-id-row">
                  <h3>#2DA-83091</h3>
                  <span class="status-badge success">{{ __('riwayat.status_done') }}</span>
                </div>
                <p class="riwayat-meta">{{ \Carbon\Carbon::parse('2024-10-03')->locale(app()->getLocale())->translatedFormat('j M Y') }}, 12:15 WIB &bull; Kantor Menara Karya (Studio)</p>
              </div>
              <div class="riwayat-total">
                <span class="label">{{ __('riwayat.total_bill') }}</span>
                <span class="value">Rp 35.000</span>
                <span class="pay-status muted">{{ __('riwayat.pay_cod_done') }}</span>
              </div>
            </div>

            <div class="riwayat-body">
              <div class="riwayat-items">
                <p><strong>2x Corndog Mini Mozarella</strong> (Saus Sambal)</p>
                <p><strong>1x Cireng Isi Mini + 2x Pop Ice Chocolate</strong></p>
              </div>
              <a href="/form-pesanan?pesanan=2DA-83091" class="link-review">
                <svg viewBox="0 0 20 20"><path d="M10 1l2.755 5.91L19 7.64l-4.5 4.386L15.51 18 10 14.911 4.49 18l1.01-5.973L1 7.64l6.245-.73z"/></svg>
                {{ __('riwayat.write_review') }}
              </a>
            </div>

            <div class="riwayat-footer">
              <span class="riwayat-invoice-note">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="9"/></svg>
                {{ __('riwayat.invoice_no') }} INV/20241003/2DA/83091
              </span>
              <div class="riwayat-actions">
                <a href="/invoice/2DA-83091" class="btn-outline-sm">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                  {{ __('riwayat.download_invoice') }}
                </a>
                <a href="/menulogin" class="btn-soft-sm">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 4v6h6"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg>
                  {{ __('riwayat.order_again') }}
                </a>
              </div>
            </div>
          </div>

          <!-- Pesanan: Selesai (2024-10-01) -->
          <div class="riwayat-card" data-date="2024-10-01">
            <div class="riwayat-top">
              <div>
                <div class="riwayat-id-row">
                  <h3>#2DA-82764</h3>
                  <span class="status-badge success">{{ __('riwayat.status_done') }}</span>
                </div>
                <p class="riwayat-meta">{{ \Carbon\Carbon::parse('2024-10-01')->locale(app()->getLocale())->translatedFormat('j M Y') }}, 20:00 WIB &bull; Tebet Barat Dalam VI (Rumah Tinggal)</p>
              </div>
              <div class="riwayat-total">
                <span class="label">{{ __('riwayat.total_bill') }}</span>
                <span class="value">Rp 15.000</span>
                <span class="pay-status">{{ __('riwayat.pay_qris_paid') }}</span>
              </div>
            </div>

            <div class="riwayat-body">
              <div class="riwayat-items">
                <p><strong>1x Cireng Isi Mini</strong> (Bumbu Tabur Pedas)</p>
                <p><strong>1x Ice Good Day Freeze</strong> (Extra Ice)</p>
              </div>
              <span class="link-review">
                <svg viewBox="0 0 20 20"><path d="M10 1l2.755 5.91L19 7.64l-4.5 4.386L15.51 18 10 14.911 4.49 18l1.01-5.973L1 7.64l6.245-.73z"/></svg>
                {{ __('riwayat.rated') }}
              </span>
            </div>

            <div class="riwayat-footer">
              <span class="riwayat-invoice-note">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="9"/></svg>
                {{ __('riwayat.received_reception') }}
              </span>
              <div class="riwayat-actions">
                <a href="/invoice/2DA-82764" class="btn-outline-sm">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                  {{ __('riwayat.download_invoice') }}
                </a>
                <a href="/menulogin" class="btn-soft-sm">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 4v6h6"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg>
                  {{ __('riwayat.order_again') }}
                </a>
              </div>
            </div>
          </div>

          <!-- Pesanan: Selesai (2024-09-28) -->
          <div class="riwayat-card" data-date="2024-09-28">
            <div class="riwayat-top">
              <div>
                <div class="riwayat-id-row">
                  <h3>#2DA-82310</h3>
                  <span class="status-badge success">{{ __('riwayat.status_done') }}</span>
                </div>
                <p class="riwayat-meta">{{ \Carbon\Carbon::parse('2024-09-28')->locale(app()->getLocale())->translatedFormat('j M Y') }}, 13:30 WIB &bull; Kantor Menara Karya (Studio)</p>
              </div>
              <div class="riwayat-total">
                <span class="label">{{ __('riwayat.total_bill') }}</span>
                <span class="value">Rp 40.000</span>
                <span class="pay-status">{{ __('riwayat.pay_qris_paid') }}</span>
              </div>
            </div>

            <div class="riwayat-body">
              <div class="riwayat-items">
                <p><strong>4x Corndog Mini Mozarella</strong> (Saus Sambal)</p>
                <p><strong>2x Ice Good Day Freeze</strong> (Extra Ice)</p>
              </div>
              <span class="link-review">
                <svg viewBox="0 0 20 20"><path d="M10 1l2.755 5.91L19 7.64l-4.5 4.386L15.51 18 10 14.911 4.49 18l1.01-5.973L1 7.64l6.245-.73z"/></svg>
                {{ __('riwayat.rated') }}
              </span>
            </div>

            <div class="riwayat-footer">
              <span class="riwayat-invoice-note">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="9"/></svg>
                {{ __('riwayat.received_reception') }}
              </span>
              <div class="riwayat-actions">
                <a href="/invoice/2DA-82310" class="btn-outline-sm">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                  {{ __('riwayat.download_invoice') }}
                </a>
                <a href="/menulogin" class="btn-soft-sm">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 4v6h6"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg>
                  {{ __('riwayat.order_again') }}
                </a>
              </div>
            </div>
          </div>

          <!-- Pesanan: Dibatalkan (2024-09-26) -->
          <div class="riwayat-card" data-date="2024-09-26">
            <div class="riwayat-top">
              <div>
                <div class="riwayat-id-row">
                  <h3>#2DA-81985</h3>
                  <span class="status-badge cancelled">{{ $rt('status_cancelled', 'Dibatalkan') }}</span>
                </div>
                <p class="riwayat-meta">{{ \Carbon\Carbon::parse('2024-09-26')->locale(app()->getLocale())->translatedFormat('j M Y') }}, 17:50 WIB &bull; Tebet Barat Dalam VI (Rumah Tinggal)</p>
              </div>
              <div class="riwayat-total">
                <span class="label">{{ __('riwayat.total_bill') }}</span>
                <span class="value">Rp 25.000</span>
                <span class="pay-status muted">{{ $rt('pay_cancelled', 'Pembayaran dibatalkan') }}</span>
              </div>
            </div>

            <div class="riwayat-body">
              <div class="riwayat-items">
                <p><strong>1x Corndog Mini Mozarella</strong> (Saos Sambal &amp; Mayo Gurih)</p>
                <p><strong>2x Cireng Isi Mini</strong> (Bumbu Tabur Original)</p>
              </div>
            </div>

            <div class="riwayat-footer">
              <span class="riwayat-invoice-note">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                {{ $rt('cancelled_note', 'Pesanan dibatalkan sebelum diproses') }}
              </span>
              <div class="riwayat-actions">
                <a href="/menulogin" class="btn-soft-sm">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 4v6h6"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg>
                  {{ __('riwayat.order_again') }}
                </a>
              </div>
            </div>
          </div>

          <!-- Pesanan: Selesai (2024-09-23) -->
          <div class="riwayat-card" data-date="2024-09-23">
            <div class="riwayat-top">
              <div>
                <div class="riwayat-id-row">
                  <h3>#2DA-81530</h3>
                  <span class="status-badge success">{{ __('riwayat.status_done') }}</span>
                </div>
                <p class="riwayat-meta">{{ \Carbon\Carbon::parse('2024-09-23')->locale(app()->getLocale())->translatedFormat('j M Y') }}, 11:45 WIB &bull; Kantor Menara Karya (Studio)</p>
              </div>
              <div class="riwayat-total">
                <span class="label">{{ __('riwayat.total_bill') }}</span>
                <span class="value">Rp 30.000</span>
                <span class="pay-status">{{ __('riwayat.pay_qris_paid') }}</span>
              </div>
            </div>

            <div class="riwayat-body">
              <div class="riwayat-items">
                <p><strong>2x Corndog Mini Mozarella</strong> (Saus Mayo)</p>
                <p><strong>1x Cireng Isi Mini</strong></p>
                <p><strong>1x Pop Ice Chocolate</strong></p>
              </div>
              <span class="link-review">
                <svg viewBox="0 0 20 20"><path d="M10 1l2.755 5.91L19 7.64l-4.5 4.386L15.51 18 10 14.911 4.49 18l1.01-5.973L1 7.64l6.245-.73z"/></svg>
                {{ __('riwayat.rated') }}
              </span>
            </div>

            <div class="riwayat-footer">
              <span class="riwayat-invoice-note">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="9"/></svg>
                {{ __('riwayat.received_reception') }}
              </span>
              <div class="riwayat-actions">
                <a href="/invoice/2DA-81530" class="btn-outline-sm">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                  {{ __('riwayat.download_invoice') }}
                </a>
                <a href="/menulogin" class="btn-soft-sm">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 4v6h6"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg>
                  {{ __('riwayat.order_again') }}
                </a>
              </div>
            </div>
          </div>

          <!-- Pesanan: Selesai (2024-09-17) -->
          <div class="riwayat-card" data-date="2024-09-17">
            <div class="riwayat-top">
              <div>
                <div class="riwayat-id-row">
                  <h3>#2DA-80642</h3>
                  <span class="status-badge success">{{ __('riwayat.status_done') }}</span>
                </div>
                <p class="riwayat-meta">{{ \Carbon\Carbon::parse('2024-09-17')->locale(app()->getLocale())->translatedFormat('j M Y') }}, 14:00 WIB &bull; Kantor Menara Karya (Studio)</p>
              </div>
              <div class="riwayat-total">
                <span class="label">{{ __('riwayat.total_bill') }}</span>
                <span class="value">Rp 35.000</span>
                <span class="pay-status">{{ __('riwayat.pay_qris_paid') }}</span>
              </div>
            </div>

            <div class="riwayat-body">
              <div class="riwayat-items">
                <p><strong>3x Corndog Mini Mozarella</strong> (Saus Sambal)</p>
                <p><strong>1x Ice Good Day Freeze</strong></p>
                <p><strong>1x Cireng Isi Mini</strong></p>
              </div>
              <a href="/form-pesanan?pesanan=2DA-80642" class="link-review">
                <svg viewBox="0 0 20 20"><path d="M10 1l2.755 5.91L19 7.64l-4.5 4.386L15.51 18 10 14.911 4.49 18l1.01-5.973L1 7.64l6.245-.73z"/></svg>
                {{ __('riwayat.write_review') }}
              </a>
            </div>

            <div class="riwayat-footer">
              <span class="riwayat-invoice-note">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="9"/></svg>
                {{ __('riwayat.invoice_no') }} INV/20240917/2DA/80642
              </span>
              <div class="riwayat-actions">
                <a href="/invoice/2DA-80642" class="btn-outline-sm">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                  {{ __('riwayat.download_invoice') }}
                </a>
                <a href="/menulogin" class="btn-soft-sm">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 4v6h6"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg>
                  {{ __('riwayat.order_again') }}
                </a>
              </div>
            </div>
          </div>

          <!-- Pesanan: Selesai (2024-09-09) -->
          <div class="riwayat-card" data-date="2024-09-09">
            <div class="riwayat-top">
              <div>
                <div class="riwayat-id-row">
                  <h3>#2DA-79788</h3>
                  <span class="status-badge success">{{ __('riwayat.status_done') }}</span>
                </div>
                <p class="riwayat-meta">{{ \Carbon\Carbon::parse('2024-09-09')->locale(app()->getLocale())->translatedFormat('j M Y') }}, 12:25 WIB &bull; Kantor Menara Karya (Studio)</p>
              </div>
              <div class="riwayat-total">
                <span class="label">{{ __('riwayat.total_bill') }}</span>
                <span class="value">Rp 40.000</span>
                <span class="pay-status">{{ __('riwayat.pay_qris_paid') }}</span>
              </div>
            </div>

            <div class="riwayat-body">
              <div class="riwayat-items">
                <p><strong>3x Corndog Mini Mozarella</strong> (Saos Sambal &amp; Mayo Gurih)</p>
                <p><strong>2x Cireng Isi Mini</strong> (Bumbu Tabur Original)</p>
                <p><strong>1x Pop Ice Chocolate</strong></p>
              </div>
              <span class="link-review">
                <svg viewBox="0 0 20 20"><path d="M10 1l2.755 5.91L19 7.64l-4.5 4.386L15.51 18 10 14.911 4.49 18l1.01-5.973L1 7.64l6.245-.73z"/></svg>
                {{ __('riwayat.rated') }}
              </span>
            </div>

            <div class="riwayat-footer">
              <span class="riwayat-invoice-note">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="9"/></svg>
                {{ __('riwayat.received_reception') }}
              </span>
              <div class="riwayat-actions">
                <a href="/invoice/2DA-79788" class="btn-outline-sm">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                  {{ __('riwayat.download_invoice') }}
                </a>
                <a href="/menulogin" class="btn-soft-sm">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 4v6h6"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg>
                  {{ __('riwayat.order_again') }}
                </a>
              </div>
            </div>
          </div>

          <p class="riwayat-empty" id="riwayatEmpty" hidden>{{ $rt('empty', 'Tidak ada pesanan yang cocok.') }}</p>

        </div>
      </div>
    </div>
  </section>

  @include('detail')

@endsection

@push('scripts')
@include('partials.cart-script')
<script>
  // Pesanan yang baru dibuat dari halaman pesanan tampil paling atas
  // (dibaca dari TwodaOrders; nanti diganti data dari database)
  (function renderNewOrders() {
    if (typeof TwodaOrders === 'undefined' || typeof PRODUCTS === 'undefined') return;
    const orders = TwodaOrders.list();
    const firstCard = document.querySelector('.riwayat-card');
    if (!orders.length || !firstCard) return;

    const payLabel = {
      qris: @js(__('riwayat.pay_qris_pending')),
      va: @js(__('riwayat.pay_va_pending')),
      cod: @js(__('riwayat.pay_cod_pending'))
    };
    const checkIcon = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="9"/></svg>';
    function rupiah(n) { return 'Rp ' + Number(n).toLocaleString('id-ID'); }
    function pad(n) { return String(n).padStart(2, '0'); }
    function esc(s) {
      return String(s).replace(/[&<>"']/g, function (c) {
        return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
      });
    }

    orders.forEach(function (o, idx) {
      const d = new Date(o.createdAt);
      const sameDay = d.toDateString() === new Date().toDateString();
      const when = (sameDay ? @js(__('riwayat.today')) : d.toLocaleDateString(@js(app()->getLocale() === 'id' ? 'id-ID' : 'en-US'), { day: 'numeric', month: 'short', year: 'numeric' }))
        + ', ' + pad(d.getHours()) + ':' + pad(d.getMinutes()) + ' WIB';
      const ymd = d.getFullYear() + pad(d.getMonth() + 1) + pad(d.getDate());
      const addr = String(o.address || '');
      const addrShort = addr.length > 40 ? addr.slice(0, 40) + '…' : addr;
      const items = (o.items || []).filter(function (i) { return PRODUCTS[i.id]; }).map(function (i) {
        return '<p><strong>' + i.qty + 'x ' + esc(PRODUCTS[i.id].name) + '</strong></p>';
      }).join('');

      const card = document.createElement('div');
      card.className = 'riwayat-card' + (idx === 0 ? ' highlight' : '');
      card.dataset.date = d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate());
      card.innerHTML = `
        <div class="riwayat-top">
          <div>
            <div class="riwayat-id-row">
              <h3>#${esc(o.id)}</h3>
              <span class="status-badge progress">{{ __('riwayat.status_waiting') }}</span>
            </div>
            <p class="riwayat-meta">${when} &bull; ${esc(addrShort)}</p>
          </div>
          <div class="riwayat-total">
            <span class="label">{{ __('riwayat.total_bill') }}</span>
            <span class="value accent">${rupiah(o.total)}</span>
            <span class="pay-status">${payLabel[o.payment] || ''}</span>
          </div>
        </div>
        <div class="riwayat-body">
          <div class="riwayat-items">${items}</div>
        </div>
        <div class="riwayat-footer">
          <span class="riwayat-invoice-note">
            ${checkIcon}
            {{ __('riwayat.invoice_no') }} INV/${ymd}/2DA/${esc(String(o.id).replace('2DA-', ''))}
          </span>
        </div>`;
      firstCard.parentNode.insertBefore(card, firstCard);
    });
  })();
</script>
<script>
  // Filter status (Semua / Berlangsung / Selesai / Dibatalkan) + pencarian + filter tanggal
  (function () {
    var tabs      = [].slice.call(document.querySelectorAll('.filter-tab'));
    var search    = document.getElementById('riwayatSearch');
    var dateBtn   = document.getElementById('riwayatDateBtn');
    var dateInput = document.getElementById('riwayatDate');
    var empty     = document.getElementById('riwayatEmpty');
    var status    = 'all';
    var COIN_PER_REVIEW = 10; // koin yang didapat per pesanan yang sudah diulas

    // status kartu dibaca dari badge-nya, jadi kartu pesanan baru (dibuat lewat JS) ikut terfilter
    function cardStatus(card) {
      var badge = card.querySelector('.status-badge');
      if (!badge) return '';
      if (badge.classList.contains('progress'))  return 'ongoing';
      if (badge.classList.contains('success'))   return 'done';
      if (badge.classList.contains('cancelled')) return 'cancelled';
      return '';
    }

    // angka di tab (Semua / Berlangsung / Selesai / Dibatalkan) dihitung dari kartu yang ada
    function updateCounts() {
      var c = { all: 0, ongoing: 0, done: 0, cancelled: 0 };
      var sum = 0;
      var reviewed = 0;
      document.querySelectorAll('.riwayat-card').forEach(function (card) {
        var s = cardStatus(card);
        c.all++;
        if (c[s] !== undefined) c[s]++;
        // total transaksi = jumlah nominal pesanan yang tidak dibatalkan
        if (s !== 'cancelled') {
          var v = card.querySelector('.riwayat-total .value');
          sum += v ? (parseInt(v.textContent.replace(/\D/g, ''), 10) || 0) : 0;
        }
        // pesanan selesai yang sudah diulas (span.link-review = "Sudah diulas", a.link-review = "Tulis ulasan")
        if (s === 'done' && card.querySelector('span.link-review')) reviewed++;
      });
      var totalEl = document.getElementById('billingTotal');
      if (totalEl) totalEl.textContent = 'Rp ' + sum.toLocaleString('id-ID');

      // koin yang sudah didapat -> disimpan supaya sidebar akun (semua halaman) menampilkan angka yang sama
      var coins = reviewed * COIN_PER_REVIEW;
      try { localStorage.setItem('twoda_coins', String(coins)); } catch (e) {}
      window.dispatchEvent(new CustomEvent('twoda:coins', { detail: { coins: coins } }));
      tabs.forEach(function (tab) {
        var n = c[tab.dataset.filter];
        if (n !== undefined) tab.textContent = tab.textContent.replace(/\d+/, n);
      });
    }

    // teks yang dicari: no. pesanan, tanggal/alamat, daftar menu, kurir (bukan label tombol)
    function cardText(card) {
      var parts = [];
      ['.riwayat-id-row h3', '.riwayat-meta', '.riwayat-items', '.riwayat-courier'].forEach(function (sel) {
        var el = card.querySelector(sel);
        if (el) parts.push(el.textContent);
      });
      return parts.join(' ').replace(/\s+/g, ' ').toLowerCase();
    }

    function apply() {
      var q = search.value.trim().toLowerCase();
      var date = dateInput.value;
      var shown = 0;
      document.querySelectorAll('.riwayat-card').forEach(function (card) {
        var ok = true;
        if (status !== 'all' && cardStatus(card) !== status) ok = false;
        if (ok && date && card.dataset.date !== date) ok = false;
        if (ok && q && cardText(card).indexOf(q) === -1) ok = false;
        card.hidden = !ok;
        if (ok) shown++;
      });
      empty.hidden = shown !== 0;
      dateBtn.classList.toggle('active', !!date);
      var t = date ? dateBtn.dataset.titleOn : dateBtn.dataset.titleOff;
      dateBtn.title = t;
      dateBtn.setAttribute('aria-label', t);
    }

    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        status = tab.dataset.filter;
        tabs.forEach(function (t) { t.classList.toggle('active', t === tab); });
        apply();
      });
    });

    search.addEventListener('input', apply);

    // tombol kalender: klik -> pilih tanggal; klik lagi saat aktif -> hapus filter tanggal
    dateBtn.addEventListener('click', function () {
      if (dateInput.value) { dateInput.value = ''; apply(); return; }
      try { dateInput.showPicker(); } catch (e) { dateInput.focus(); dateInput.click(); }
    });
    dateInput.addEventListener('change', apply);

    updateCounts();

    // link "Detail & Invoice" membuka modal, jangan lompat ke atas halaman
    document.querySelectorAll('a[data-modal-open][href="#"]').forEach(function (a) {
      a.addEventListener('click', function (e) { e.preventDefault(); });
    });
  })();
</script>
@endpush