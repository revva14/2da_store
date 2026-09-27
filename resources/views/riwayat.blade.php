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
  a.link-review{ cursor:pointer; }
  a.link-review:hover{ text-decoration:underline; }

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

  /* ---------- MODAL: FORM ULASAN ---------- */
  .modal-ulasan-overlay{
    position:fixed; inset:0;
    background:rgba(40,20,8,.45);
    display:flex; align-items:center; justify-content:center;
    padding:24px;
    z-index:200;
  }
  .modal-ulasan-overlay[hidden]{ display:none; }
  .modal-ulasan{
    position:relative;
    background: var(--white);
    width:100%; max-width:620px;
    max-height:90vh;
    overflow-y:auto;
    border-radius:16px;
    padding:34px 34px 28px;
    box-shadow:0 30px 60px -20px rgba(40,20,8,.45);
  }
  .modal-ulasan::before{
    content:"";
    position:absolute; top:0; left:0; right:0; height:6px;
    border-radius:16px 16px 0 0;
    background:linear-gradient(90deg, var(--orange), var(--orange-dark), var(--orange));
  }
  .modal-ulasan-close{
    position:absolute; top:22px; right:22px;
    width:30px; height:30px;
    display:flex; align-items:center; justify-content:center;
    color: var(--ink-soft);
    border-radius:50%;
    transition: background .2s ease, color .2s ease;
  }
  .modal-ulasan-close:hover{ background: var(--cream-soft); color: var(--ink); }
  .modal-ulasan-close svg{ width:18px; height:18px; }

  .modal-ulasan-badge{
    display:inline-flex; align-items:center; gap:6px;
    background:#fdebd9; color: var(--orange-dark);
    font-size:11px; font-weight:700;
    padding:6px 14px;
    border-radius: var(--radius-pill);
    margin-bottom:14px;
  }
  .modal-ulasan-badge svg{ width:12px; height:12px; fill: var(--orange-dark); }

  .modal-ulasan h2{
    font-family: var(--font-display);
    font-weight:800;
    font-size:22px;
    color: var(--ink);
    margin-bottom:6px;
  }
  .modal-ulasan-sub{
    font-size:12.5px;
    color: var(--ink-soft);
    margin-bottom:22px;
  }
  .modal-ulasan-sub strong{ color: var(--ink); }

  .modal-ulasan-order{
    display:flex; align-items:center; gap:14px;
    background: var(--cream-soft);
    border-radius:10px;
    padding:14px 16px;
    margin-bottom:26px;
  }
  .modal-ulasan-order-icon{
    width:38px; height:38px; flex:none;
    display:flex; align-items:center; justify-content:center;
    background:#fdebd9; color: var(--orange-dark);
    border-radius:10px;
  }
  .modal-ulasan-order-icon svg{ width:18px; height:18px; }
  .modal-ulasan-order-items{ flex:1 1 auto; min-width:0; }
  .modal-ulasan-order-items p{
    font-size:12.5px;
    color: var(--ink);
    margin-bottom:2px;
  }
  .modal-ulasan-order-items p:last-child{ margin-bottom:0; }
  .modal-ulasan-order-items strong{ font-weight:700; }
  .modal-ulasan-order-total{ text-align:right; flex:none; }
  .modal-ulasan-order-total .value{
    display:block;
    font-family: var(--font-display);
    font-weight:700;
    font-size:15px;
    color: var(--orange-dark);
  }
  .modal-ulasan-order-total .count{
    display:block;
    font-size:9.5px;
    letter-spacing:.05em;
    color: var(--ink-soft);
    margin-top:3px;
  }

  .modal-ulasan-block{ margin-bottom:24px; }
  .modal-ulasan-label{
    font-size:11.5px;
    font-weight:700;
    letter-spacing:.02em;
    text-transform:uppercase;
    color: var(--ink);
  }
  .modal-ulasan-label.center{ text-align:center; margin-bottom:16px; }
  .modal-ulasan-label .soft{
    font-weight:600;
    text-transform:none;
    letter-spacing:0;
    color: var(--ink-soft);
  }
  .modal-ulasan-label-row{
    display:flex; align-items:center; justify-content:space-between;
    margin-bottom:8px;
  }
  .modal-ulasan-counter{ font-size:11px; color: var(--ink-soft); }

  .modal-ulasan-stars{
    display:flex; justify-content:center; gap:8px;
    margin-bottom:10px;
  }
  .modal-ulasan-stars .star{
    width:38px; height:38px;
    color:#e2d6c8;
    transition: color .15s ease, transform .1s ease;
  }
  .modal-ulasan-stars .star svg{ width:100%; height:100%; }
  .modal-ulasan-stars .star:hover{ transform:scale(1.08); }
  .modal-ulasan-stars .star.filled{ color:#f5a623; }
  .modal-ulasan-rating-text{
    text-align:center;
    font-size:13px;
    font-weight:600;
    color: var(--ink-soft);
  }
  .modal-ulasan-rating-text[hidden]{ display:none; }
  .modal-ulasan-rating-text .num{ color: var(--orange-dark); font-weight:800; }
  .modal-ulasan-rating-warning{
    text-align:center;
    font-size:12px;
    font-weight:600;
    color:#c0392b;
    margin-top:8px;
  }
  .modal-ulasan-rating-warning[hidden]{ display:none; }

  .modal-ulasan-chips{
    display:flex; flex-wrap:wrap; gap:8px;
    margin-top:12px;
  }
  .modal-ulasan-chips .chip{
    display:inline-flex; align-items:center; gap:6px;
    background: var(--cream-soft);
    border:1.5px solid transparent;
    color: var(--ink);
    font-size:12px; font-weight:600;
    padding:8px 16px;
    border-radius: var(--radius-pill);
    transition: border-color .2s ease, background .2s ease, color .2s ease;
  }
  .modal-ulasan-chips .chip:hover{ background:#f0e4d6; }
  .modal-ulasan-chips .chip .chip-check{ display:none; width:13px; height:13px; }
  .modal-ulasan-chips .chip.selected{
    background:#fdf3e8;
    border-color: var(--orange);
    color: var(--orange-dark);
  }
  .modal-ulasan-chips .chip.selected .chip-check{ display:inline-block; }

  #ulasanText{
    width:100%;
    border:1.5px solid #e6d6c8;
    border-radius:10px;
    padding:14px 16px;
    font-size:12.5px;
    color: var(--ink);
    resize:vertical;
    min-height:90px;
    font-family:inherit;
  }
  #ulasanText:focus{ outline:2px solid rgba(217,119,55,.2); border-color: var(--orange); }
  #ulasanText::placeholder{ color:#b7a596; }

  .modal-ulasan-photos{ display:flex; align-items:center; gap:16px; margin-top:12px; flex-wrap:wrap; }
  .photo-add{
    width:78px; height:78px; flex:none;
    display:flex; flex-direction:column; align-items:center; justify-content:center; gap:4px;
    border:1.5px dashed #d8c4b0;
    border-radius:10px;
    color: var(--ink-soft);
    font-size:10.5px; font-weight:600;
    cursor:pointer;
    transition: border-color .2s ease, background .2s ease;
  }
  .photo-add:hover{ border-color: var(--orange); background: var(--cream-soft); }
  .photo-add svg{ width:18px; height:18px; }
  .photo-hint p{ font-size:11.5px; color: var(--ink-soft); margin-bottom:2px; }
  .photo-hint p:last-child{ margin-bottom:0; }
  .photo-hint strong{ color: var(--ink); }
  .photo-thumb{
    position:relative;
    width:78px; height:78px; flex:none;
    border-radius:10px; overflow:hidden;
  }
  .photo-thumb img{ width:100%; height:100%; object-fit:cover; display:block; }
  .photo-thumb button{
    position:absolute; top:4px; right:4px;
    width:18px; height:18px;
    background:rgba(0,0,0,.55); color:#fff;
    border-radius:50%;
    display:flex; align-items:center; justify-content:center;
  }
  .photo-thumb button svg{ width:10px; height:10px; }

  .modal-ulasan-toggle-row{
    display:flex; align-items:center; justify-content:space-between; gap:16px;
    padding-top:18px; margin-bottom:22px;
    border-top:1px solid rgba(122,59,18,.1);
  }
  .modal-ulasan-toggle-row .soft.small{ font-size:11px; color: var(--ink-soft); margin-top:2px; }
  .switch{ position:relative; display:inline-block; width:40px; height:22px; flex:none; }
  .switch input{ opacity:0; width:0; height:0; }
  .switch .slider{
    position:absolute; inset:0;
    background:#e2d6c8; border-radius: var(--radius-pill);
    transition: background .2s ease;
    cursor:pointer;
  }
  .switch .slider::before{
    content:""; position:absolute;
    width:16px; height:16px; left:3px; top:3px;
    background:#fff; border-radius:50%;
    transition: transform .2s ease;
  }
  .switch input:checked + .slider{ background: var(--orange); }
  .switch input:checked + .slider::before{ transform:translateX(18px); }

  .modal-ulasan-actions{
    display:flex; align-items:center; justify-content:flex-end; gap:12px;
    padding-top:20px;
    border-top:1px solid rgba(122,59,18,.14);
  }
  .modal-ulasan-actions .btn-primary-sm svg{ width:14px; height:14px; }

  @media (max-width:560px){
    .modal-ulasan{ padding:26px 20px 22px; }
    .modal-ulasan-order{ flex-wrap:wrap; }
    .modal-ulasan-order-total{ text-align:left; }
    .modal-ulasan-actions{ flex-direction:column-reverse; align-items:stretch; }
    .modal-ulasan-actions .btn-outline-sm, .modal-ulasan-actions .btn-primary-sm{ justify-content:center; }
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

@forelse($orders as $order)

    @php
        $statusClass = match ($order->status) {
            'selesai' => 'success',
            'batal' => 'cancelled',
            default => 'progress',
        };

        $statusText = match ($order->status) {
            'baru' => 'Menunggu',
            'dapur' => 'Sedang Diproses',
            'antar' => 'Dalam Pengantaran',
            'selesai' => 'Selesai',
            'batal' => 'Dibatalkan',
            default => 'Menunggu',
        };

        $paymentText = match ($order->metode_pembayaran) {
            'qris' => 'QRIS',
            'va' => 'Virtual Account',
            'cod' => 'COD',
            default => strtoupper($order->metode_pembayaran ?? '-'),
        };

        $paymentStatus = match ($order->payment_status) {
            'settlement',
            'capture',
            'paid' => 'Pembayaran berhasil',

            'cancel',
            'cancelled' => 'Pembayaran dibatalkan',

            default => 'Menunggu pembayaran',
        };
    @endphp

    <div
        class="riwayat-card"
        data-date="{{ $order->created_at->format('Y-m-d') }}"
    >

        <div class="riwayat-top">

            <div>
                <div class="riwayat-id-row">

                    <h3>#{{ $order->no_pesanan }}</h3>

                    <span class="status-badge {{ $statusClass }}">
                        {{ $statusText }}
                    </span>

                </div>

                <p class="riwayat-meta">
                    {{ $order->created_at->locale(app()->getLocale())->translatedFormat('j M Y, H:i') }}
                    WIB
                    &bull;
                    {{ $order->alamat }}
                </p>
            </div>

            <div class="riwayat-total">

                <span class="label">
                    {{ __('riwayat.total_bill') }}
                </span>

                <span class="value">
                    Rp {{ number_format($order->total, 0, ',', '.') }}
                </span>

                <span class="pay-status">
                    {{ $paymentText }}
                    &bull;
                    {{ $paymentStatus }}
                </span>

            </div>

        </div>


        <div class="riwayat-body">

            <div class="riwayat-items">

                @foreach($order->items as $item)

                    <p>
                        <strong>
                            {{ $item->qty }}x
                            {{ $item->nama_produk ?? 'Produk' }}
                        </strong>
                    </p>

                @endforeach

            </div>


            @if($order->status === 'antar')

                <div class="riwayat-courier">

                    <p class="name">
                        Dalam Pengantaran
                    </p>

                    <p class="detail">
                        {{ $order->metode_pengiriman }}
                    </p>

                </div>

            @elseif($order->status === 'selesai')

                @if(!empty($order->rating))

                    <span class="link-review">

                        <svg viewBox="0 0 20 20">
                            <path d="M10 1l2.755 5.91L19 7.64l-4.5 4.386L15.51 18 10 14.911 4.49 18l1.01-5.973L1 7.64l6.245-.73z"/>
                        </svg>

                        {{ $rt('rated', 'Sudah Dinilai') }}: {{ number_format($order->rating->nilai, 1) }}
                        ({{ $order->rating->label }})

                    </span>

                @else

                    <a href="#" class="link-review" data-review-open>

                        <svg viewBox="0 0 20 20">
                            <path d="M10 1l2.755 5.91L19 7.64l-4.5 4.386L15.51 18 10 14.911 4.49 18l1.01-5.973L1 7.64l6.245-.73z"/>
                        </svg>

                        {{ __('riwayat.write_review') }}

                    </a>

                @endif

            @endif

        </div>


        <div class="riwayat-footer">

            <span class="riwayat-invoice-note">

                @if($order->status === 'batal')

                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <circle cx="12" cy="12" r="9"/>
                        <line x1="15" y1="9" x2="9" y2="15"/>
                        <line x1="9" y1="9" x2="15" y2="15"/>
                    </svg>

                    Pesanan dibatalkan sebelum diproses

                @else

                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M9 12l2 2 4-4"/>
                        <circle cx="12" cy="12" r="9"/>
                    </svg>

                    {{ __('riwayat.invoice_no') }}
                    {{ $order->no_pesanan }}

                @endif

            </span>


            @if($order->status === 'batal')

                <div class="riwayat-actions">

                    <a href="/menulogin" class="btn-soft-sm">

                        <svg
                            width="14"
                            height="14"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M1 4v6h6"/>
                            <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/>
                        </svg>

                        {{ __('riwayat.order_again') }}

                    </a>

                </div>

            @endif

        </div>

    </div>

@empty

    <div class="riwayat-card">

        <div class="riwayat-body">

            <div class="riwayat-items">

                <p>
                    Belum ada pesanan.
                </p>

            </div>

        </div>

    </div>

@endforelse
          <p class="riwayat-empty" id="riwayatEmpty" hidden>{{ $rt('empty', 'Tidak ada pesanan yang cocok.') }}</p>

        </div>
      </div>
    </div>
  </section>

  @include('detail')

  <!-- MODAL: FORM ULASAN -->
  <div class="modal-ulasan-overlay" id="modalUlasan" hidden>
    <div class="modal-ulasan" role="dialog" aria-modal="true" aria-labelledby="modalUlasanTitle">
      <button type="button" class="modal-ulasan-close" data-review-close aria-label="{{ $rt('close', 'Tutup') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>

      <span class="modal-ulasan-badge">
        <svg viewBox="0 0 20 20"><path d="M10 1l2.755 5.91L19 7.64l-4.5 4.386L15.51 18 10 14.911 4.49 18l1.01-5.973L1 7.64l6.245-.73z"/></svg>
        {{ $rt('review_form_badge', 'Form Ulasan') }}
      </span>
      <h2 id="modalUlasanTitle">{{ $rt('review_title', 'Beri Ulasan & Penilaian') }}</h2>
      <p class="modal-ulasan-sub">{{ $rt('order_label', 'Pesanan') }} <strong id="ulasanOrderId">#2DA-00000</strong> &bull; <span id="ulasanOrderDate">-</span></p>

      <div class="modal-ulasan-order">
        <span class="modal-ulasan-order-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2l1.5 4h9L18 2"/><path d="M3.5 7h17l-1.2 12.2a2 2 0 0 1-2 1.8H6.7a2 2 0 0 1-2-1.8L3.5 7z"/><line x1="9" y1="11" x2="9" y2="15"/><line x1="15" y1="11" x2="15" y2="15"/></svg>
        </span>
        <div class="modal-ulasan-order-items" id="ulasanOrderItems"></div>
        <div class="modal-ulasan-order-total">
          <span class="value" id="ulasanOrderTotal">Rp 0</span>
          <span class="count" id="ulasanOrderCount">0 {{ $rt('item_unit', 'ITEM') }}</span>
        </div>
      </div>

      <div class="modal-ulasan-block">
        <p class="modal-ulasan-label center">{{ $rt('review_question', 'Bagaimana pengalaman jajanmu kali ini?') }}</p>
        <div class="modal-ulasan-stars" id="ulasanStars">
          @for ($i = 1; $i <= 5; $i++)
          <button type="button" class="star" data-star="{{ $i }}" aria-label="{{ $i }} bintang">
            <svg viewBox="0 0 20 20" fill="currentColor"><path d="M10 1l2.755 5.91L19 7.64l-4.5 4.386L15.51 18 10 14.911 4.49 18l1.01-5.973L1 7.64l6.245-.73z"/></svg>
          </button>
          @endfor
        </div>
        <p class="modal-ulasan-rating-text" id="ulasanRatingText" hidden>
          <span class="num" id="ulasanRatingNum">0.0</span> &bull; <span id="ulasanRatingLabel"></span>
        </p>
        <p class="modal-ulasan-rating-warning" id="ulasanRatingWarning" hidden>{{ $rt('review_rating_required', 'Yuk, kasih bintang dulu ya!') }}</p>
      </div>

      <div class="modal-ulasan-block">
        <p class="modal-ulasan-label">{{ $rt('review_tags_label', 'Apa yang paling kamu sukai?') }} <span class="soft">({{ $rt('review_tags_hint', 'Bisa pilih lebih dari satu') }})</span></p>
        <div class="modal-ulasan-chips" id="ulasanChips">
          @foreach ([
            $rt('tag_taste', 'Rasa Juara'),
            $rt('tag_portion', 'Porsi Pas'),
            $rt('tag_fresh', 'Masih Panas & Renyah'),
            $rt('tag_fast', 'Pengantaran Cepat'),
            $rt('tag_packaging', 'Kemasan Rapi'),
            $rt('tag_price', 'Harga Ramah di Kantong'),
          ] as $tag)
          <button type="button" class="chip" data-chip>
            <svg class="chip-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            {{ $tag }}
          </button>
          @endforeach
        </div>
      </div>

      <div class="modal-ulasan-block">
        <div class="modal-ulasan-label-row">
          <p class="modal-ulasan-label" style="text-transform:none;letter-spacing:0;">{{ $rt('review_text_label', 'Tulis Ulasan atau Masukan') }} <span class="soft">({{ $rt('optional', 'Opsional') }})</span></p>
          <span class="modal-ulasan-counter"><span id="ulasanTextCount">0</span>/300</span>
        </div>
        <textarea id="ulasanText" maxlength="300" placeholder="{{ $rt('review_text_placeholder', 'Ceritakan pengalaman jajanmu...') }}"></textarea>
      </div>

      <div class="modal-ulasan-block" style="margin-bottom:0;">
        <p class="modal-ulasan-label" style="text-transform:none;letter-spacing:0;">{{ $rt('review_photo_label', 'Foto Makanan') }} <span class="soft">({{ $rt('review_photo_hint', 'Maksimal 1 foto') }})</span></p>
        <div class="modal-ulasan-photos" id="ulasanPhotos">
          <label class="photo-add" id="ulasanPhotoAdd">
            <input type="file" accept="image/jpeg,image/png" hidden id="ulasanPhotoInput">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
            <span>+ {{ $rt('add', 'Tambah') }}</span>
          </label>
          <div class="photo-hint" id="ulasanPhotoHint">
            <p><strong>{{ $rt('review_photo_formats_label', 'Format yang didukung:') }}</strong> JPG, PNG.</p>
            <p>{{ $rt('review_photo_note', 'Bantu teman jajan melihat tampilan asli pesananmu!') }}</p>
          </div>
        </div>
      </div>

      <div class="modal-ulasan-toggle-row">
        <div>
          <p class="modal-ulasan-label" style="text-transform:none;letter-spacing:0;">{{ $rt('review_anon_label', 'Kirim Secara Anonim') }}</p>
          <p class="soft small">{{ $rt('review_anon_note', 'Nama akunmu akan disamarkan menjadi R***a pada ulasan publik') }}</p>
        </div>
        <label class="switch">
          <input type="checkbox" id="ulasanAnonim">
          <span class="slider"></span>
        </label>
      </div>

      <div class="modal-ulasan-actions">
        <button type="button" class="btn-outline-sm" data-review-close>{{ $rt('review_later', 'Nanti Saja') }}</button>
        <button type="button" class="btn-primary-sm" id="ulasanSubmit">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 9v4"/><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
          {{ $rt('review_submit', 'Kirim Ulasan') }}
        </button>
      </div>
    </div>
  </div>

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

    // dipakai oleh modal Form Ulasan supaya total transaksi, badge status, dan koin
    // langsung ikut ter-update setelah ulasan dikirim
    window.TwodaRiwayat = { refresh: function () { updateCounts(); } };

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
<script>
  // Modal "Form Ulasan" -- dipicu dari link "Tulis Ulasan" di tiap pesanan.
  // Setelah dikirim, kartu pesanan itu diubah jadi "Sudah diulas" (badge bintang),
  // disimpan supaya tetap begitu walau halaman dibuka ulang, lalu total transaksi
  // dan koin (di sidebar akun) dihitung ulang lewat window.TwodaRiwayat.refresh().
  (function () {
    var overlay   = document.getElementById('modalUlasan');
    if (!overlay) return;

    var ratedLabelText = @js($rt('rated', 'Sudah Dinilai'));
    var starIconSvg = '<svg viewBox="0 0 20 20"><path d="M10 1l2.755 5.91L19 7.64l-4.5 4.386L15.51 18 10 14.911 4.49 18l1.01-5.973L1 7.64l6.245-.73z"/></svg>';
    var STORE_KEY = 'twoda_reviewed_orders';

    function ratedHTMLFor(rating, label) {
      var text = ratedLabelText + ': ' + Number(rating).toFixed(1) + (label ? ' (' + label + ')' : '');
      return starIconSvg + text;
    }

    var ratingLabels = {
      1: @js($rt('review_rating_1', 'Kurang Sesuai Selera')),
      2: @js($rt('review_rating_2', 'Boleh Ditingkatkan')),
      3: @js($rt('review_rating_3', 'Lumayan Enak')),
      4: @js($rt('review_rating_4', 'Enak & Memuaskan')),
      5: @js($rt('review_rating_5', 'Sangat Lezat & Memuaskan!'))
    };

    var stars       = [].slice.call(document.querySelectorAll('#ulasanStars .star'));
    var ratingText  = document.getElementById('ulasanRatingText');
    var ratingNum   = document.getElementById('ulasanRatingNum');
    var ratingLabel = document.getElementById('ulasanRatingLabel');
    var ratingWarn  = document.getElementById('ulasanRatingWarning');
    var chips       = [].slice.call(document.querySelectorAll('#ulasanChips .chip'));
    var textArea    = document.getElementById('ulasanText');
    var textCount   = document.getElementById('ulasanTextCount');
    var photoAdd    = document.getElementById('ulasanPhotoAdd');
    var photoInput  = document.getElementById('ulasanPhotoInput');
    var photoWrap   = document.getElementById('ulasanPhotos');
    var anonim      = document.getElementById('ulasanAnonim');
    var submitBtn   = document.getElementById('ulasanSubmit');

    var currentRating = 0;
    var currentCard   = null;
    var photoCount    = 0;

    function getReviewed() {
      try { return JSON.parse(localStorage.getItem(STORE_KEY) || '[]'); } catch (e) { return []; }
    }
    function saveReviewed(list) {
      try { localStorage.setItem(STORE_KEY, JSON.stringify(list)); } catch (e) {}
    }
    function orderIdOf(card) {
      var h3 = card.querySelector('.riwayat-id-row h3');
      return h3 ? h3.textContent.replace('#', '').trim() : '';
    }

    // ganti link "Tulis Ulasan" jadi span "Sudah Dinilai: x.x (label)" (persis format kartu yang sudah pernah diulas)
    function markCardReviewed(card, rating, label) {
      var link = card.querySelector('a.link-review');
      if (link) {
        var span = document.createElement('span');
        span.className = 'link-review';
        span.innerHTML = ratedHTMLFor(rating, label);
        link.parentNode.replaceChild(span, link);
      }
      if (window.TwodaRiwayat) window.TwodaRiwayat.refresh();
    }

    // pulihkan status "sudah diulas" dari localStorage saat halaman dibuka lagi
    // (rating & label ikut disimpan supaya teksnya tetap sama walau halaman dibuka ulang)
    (function restore() {
      var reviewed = getReviewed();
      if (!reviewed.length) return;
      document.querySelectorAll('.riwayat-card').forEach(function (card) {
        var found = reviewed.filter(function (r) { return r.id === orderIdOf(card); })[0];
        if (found) markCardReviewed(card, found.rating, found.label);
      });
    })();

    function resetForm() {
      currentRating = 0;
      photoCount = 0;
      renderStars(0);
      ratingText.hidden = true;
      ratingWarn.hidden = true;
      chips.forEach(function (c) { c.classList.remove('selected'); });
      textArea.value = '';
      textCount.textContent = '0';
      anonim.checked = false;
      photoWrap.querySelectorAll('.photo-thumb').forEach(function (t) { t.remove(); });
      photoAdd.hidden = false;
      photoInput.value = '';
    }

    function renderStars(n) {
      stars.forEach(function (s) {
        s.classList.toggle('filled', parseInt(s.dataset.star, 10) <= n);
      });
    }

    function openModal(card) {
      currentCard = card;
      resetForm();

      var idEl   = document.getElementById('ulasanOrderId');
      var dateEl = document.getElementById('ulasanOrderDate');
      var itemsEl = document.getElementById('ulasanOrderItems');
      var totalEl = document.getElementById('ulasanOrderTotal');
      var countEl = document.getElementById('ulasanOrderCount');

      idEl.textContent = '#' + orderIdOf(card);
      var meta = card.querySelector('.riwayat-meta');
      dateEl.textContent = meta ? meta.textContent.split('\u2022')[0].trim() : '';

      var itemPs = card.querySelectorAll('.riwayat-items p');
      itemsEl.innerHTML = '';
      itemPs.forEach(function (p) { itemsEl.appendChild(p.cloneNode(true)); });
      countEl.textContent = itemPs.length + ' ' + @js($rt('item_unit', 'ITEM'));

      var totalVal = card.querySelector('.riwayat-total .value');
      totalEl.textContent = totalVal ? totalVal.textContent.trim() : 'Rp 0';

      overlay.hidden = false;
      document.body.style.overflow = 'hidden';
    }

    function closeModal() {
      overlay.hidden = true;
      document.body.style.overflow = '';
      currentCard = null;
    }

    document.querySelectorAll('[data-review-open]').forEach(function (a) {
      a.addEventListener('click', function (e) {
        e.preventDefault();
        var card = a.closest('.riwayat-card');
        if (card) openModal(card);
      });
    });

    document.querySelectorAll('[data-review-close]').forEach(function (b) {
      b.addEventListener('click', closeModal);
    });
    overlay.addEventListener('click', function (e) {
      if (e.target === overlay) closeModal();
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && !overlay.hidden) closeModal();
    });

    stars.forEach(function (s) {
      s.addEventListener('click', function () {
        currentRating = parseInt(s.dataset.star, 10);
        renderStars(currentRating);
        ratingText.hidden = false;
        ratingWarn.hidden = true;
        ratingNum.textContent = currentRating.toFixed(1);
        ratingLabel.textContent = ratingLabels[currentRating] || '';
      });
    });

    chips.forEach(function (c) {
      c.addEventListener('click', function () { c.classList.toggle('selected'); });
    });

    textArea.addEventListener('input', function () {
      textCount.textContent = textArea.value.length;
    });

    photoAdd.addEventListener('click', function (e) {
      if (photoCount >= 1) e.preventDefault();
    });
    photoInput.addEventListener('change', function () {
      [].slice.call(photoInput.files).forEach(function (file) {
        if (photoCount >= 1 || !/^image\/(jpeg|png)$/.test(file.type)) return;
        photoCount++;
        var reader = new FileReader();
        reader.onload = function (ev) {
          var thumb = document.createElement('div');
          thumb.className = 'photo-thumb';
          thumb.innerHTML = '<img src="' + ev.target.result + '" alt="">' +
            '<button type="button" aria-label="{{ $rt('remove', 'Hapus') }}">' +
            '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>';
          thumb.querySelector('button').addEventListener('click', function () {
            thumb.remove();
            photoCount--;
            photoAdd.hidden = false;
          });
          photoWrap.insertBefore(thumb, photoAdd);
          if (photoCount >= 1) photoAdd.hidden = true;
        };
        reader.readAsDataURL(file);
      });
      photoInput.value = '';
    });

    submitBtn.addEventListener('click', function () {
      if (!currentRating) {
        ratingWarn.hidden = false;
        return;
      }
      if (currentCard) {
        var id = orderIdOf(currentCard);
        var label = ratingLabels[currentRating] || '';
        markCardReviewed(currentCard, currentRating, label);
        var reviewed = getReviewed().filter(function (r) { return r.id !== id; });
        reviewed.push({ id: id, rating: currentRating, label: label });
        saveReviewed(reviewed);
      }
      closeModal();
    });
  })();
</script>
@endpush