@extends('layouts.app')

@php
  // Produk dipilih lewat ?p=slug, mis. /produklogin?p=cireng-isi-ayam-suwir (tanpa route baru)
  $slug    = request('p', 'corndog-mini-mozzarella');
  $product = config("menu.$slug");
  abort_if(!$product, 404);
  $related = collect(config('menu'))->except($slug)->take(3)->all();
@endphp

@section('title', $product['name'] . ' — 2DA Store')

@push('styles')
<link href="https://fonts.googleapis.com/css2?Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  /* Semua style di-scope ke .produk-page supaya tidak bentrok dengan navbar/footer/layout */
  .produk-page{
    --pf-font: 'Plus Jakarta Sans', 'Inter', sans-serif;
    --pf-bg: #FFF8F5;
    --pf-bg-2: #FFF3EE;
    --pf-ink: #2B1407;
    --pf-muted: #5C4B42;
    --pf-brand: #9F4A00;
    --pf-brand-soft: #FFEFE8;
    --pf-peach: #FDDFD0;
    --pf-green: #3A6B1E;
    --pf-line: #F0DDD3;
    --pf-shadow: 0 8px 24px -10px rgba(122,59,18,.18);

    font-family: var(--pf-font);
    color: var(--pf-ink);
    background: var(--pf-bg);
  }
  .produk-page button{ font-family: var(--pf-font); }
  .produk-page svg{ display:block; flex:none; }

  /* ---------- DETAIL ---------- */
  .pd-detail{ padding: 30px 0 34px; }

  .pd-grid{
    display:grid;
    grid-template-columns: 1fr 1fr;
    gap: 48px;
    align-items:start;
  }

  /* ----- gallery ----- */
  .pd-gallery-main{
    position:relative;
    border-radius: 32px;
    overflow:hidden;
    aspect-ratio: 4/3;
    background:#fff;
    box-shadow: var(--pf-shadow);
  }
  .pd-gallery-main img{
    width:100%; height:100%;
    object-fit:cover;
    transition: transform .6s ease;
  }
  .pd-gallery-main:hover img{ transform: scale(1.04); }

  /* ----- info ----- */
  .pd-title{
    font-family: var(--pf-font);
    font-weight:800;
    font-size:28px;
    line-height:1.1;
    letter-spacing:-0.035em;
    color: var(--pf-ink);
    margin-bottom:10px;
  }

  .pd-meta{
    display:flex;
    align-items:center;
    flex-wrap:wrap;
    gap: 14px;
    font-size:14px;
  }
  .pd-rating{
    display:inline-flex;
    align-items:center;
    gap:6px;
    background: #FFEEE2;
    border-radius:999px;
    padding: 4px 12px;
    font-size:13.5px;
    color: var(--pf-muted);
  }
  .pd-rating svg{ color: var(--pf-brand); }
  .pd-rating b{ color: var(--pf-ink); font-weight:700; }
  .pd-dot{
    width:5px; height:5px;
    border-radius:50%;
    background:#E2CFC4;
  }
  .pd-sold b{ font-weight:800; }
  .pd-happy{
    display:inline-flex;
    align-items:center;
    gap:5px;
    color: var(--pf-green);
    font-size:13.5px;
    font-weight:700;
  }

  .pd-price-box{
    margin-top: 24px;
    background: linear-gradient(135deg, #FFEFE8, #FFF3EE);
    border-radius: 32px;
    padding: 18px 16px;
    box-shadow: 0 10px 24px -14px rgba(122,59,18,.25);
  }
  .pd-price-box strong{
    display:block;
    font-weight:800;
    font-size:28px;
    line-height:1.1;
    letter-spacing:-0.03em;
    color: var(--pf-brand);
  }

  .pd-desc{
    margin-top: 24px;
    font-size:14px;
    line-height:1.6;
    color: var(--pf-muted);
  }
  .pd-desc strong{ color: var(--pf-ink); font-weight:700; }

  .pd-divider{
    border:none;
    height:1px;
    background: var(--pf-line);
    margin: 24px 0 26px;
  }

  /* ----- option groups ----- */
  .pd-group-head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    margin-bottom:10px;
  }
  .pd-group-title{
    display:flex;
    align-items:center;
    gap:8px;
    font-size:15px;
    font-weight:700;
    letter-spacing:-0.01em;
    color: var(--pf-ink);
  }
  .pd-group-title svg{ color: var(--pf-brand); }
  .pd-badge{
    background: var(--pf-peach);
    color: var(--pf-brand);
    font-size:12px;
    font-weight:700;
    padding: 4px 10px;
    border-radius:999px;
    white-space:nowrap;
  }
  .pd-hint{
    font-size:12.5px;
    color: var(--pf-muted);
    white-space:nowrap;
  }

  .pd-options{
    display:grid;
    grid-template-columns: 1fr 1fr;
    gap: 5px 4px;
  }
  .pd-group + .pd-group{ margin-top: 26px; }

  .pd-opt{
    position:relative;
    display:flex;
    align-items:center;
    gap:10px;
    background:#fff;
    border-radius:6px;
    padding: 0 10px 0 9px;
    min-height: 56px;
    cursor:pointer;
    transition: box-shadow .2s ease, transform .2s ease;
  }
  .pd-opt.compact{ min-height: 34px; }
  .pd-opt:hover{ box-shadow: var(--pf-shadow); }
  .pd-opt input{
    position:absolute;
    opacity:0;
    pointer-events:none;
  }
  .pd-opt:has(input:focus-visible){ outline:2px solid var(--pf-brand); outline-offset:2px; }

  .pd-radio{
    width:18px; height:18px;
    border-radius:50%;
    border:1.5px solid #9d8d84;
    flex:none;
    position:relative;
    transition: border-color .2s ease;
  }
  .pd-radio::after{
    content:"";
    position:absolute;
    inset:3px;
    border-radius:50%;
    background: var(--pf-brand);
    transform: scale(0);
    transition: transform .2s ease;
  }
  .pd-opt input:checked ~ .pd-radio{ border-color: var(--pf-brand); }
  .pd-opt input:checked ~ .pd-radio::after{ transform: scale(1); }

  .pd-check{
    width:16px; height:16px;
    border-radius:3px;
    border:1.5px solid #9d8d84;
    flex:none;
    display:flex; align-items:center; justify-content:center;
    color:#fff;
    transition: background .2s ease, border-color .2s ease;
  }
  .pd-check svg{ width:11px; height:11px; opacity:0; transition: opacity .15s ease; }
  .pd-opt input:checked ~ .pd-check{ background: var(--pf-brand); border-color: var(--pf-brand); }
  .pd-opt input:checked ~ .pd-check svg{ opacity:1; }

  .pd-opt-text{ flex:1; min-width:0; }
  .pd-opt-text b{
    display:block;
    font-size:13.5px;
    font-weight:600;
    line-height:1.3;
    color: var(--pf-ink);
  }
  .pd-opt-text span{
    display:block;
    font-size:12.5px;
    color: var(--pf-muted);
    line-height:1.3;
  }
  .pd-opt-price{
    font-size:12.5px;
    font-weight:700;
    white-space:nowrap;
    color: var(--pf-brand);
  }
  .pd-opt-price.free{ color: var(--pf-green); }

  /* ----- order card ----- */
  .pd-order{
    margin-top: 24px;
    background: #FFFBF9;
    border-radius: 32px;
    padding: 20px 16px 16px;
    box-shadow: 0 16px 34px -18px rgba(122,59,18,.35);
  }
  .pd-order-top{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    padding: 0 0 16px;
  }
  .pd-order-label{
    font-size:13px;
    color: var(--pf-muted);
    margin-bottom: 8px;
  }
  .pd-qty{
    display:flex;
    align-items:center;
    gap:10px;
  }
  .pd-qty button{
    width:34px; height:34px;
    border-radius:50%;
    background: var(--pf-peach);
    color: var(--pf-ink);
    display:flex; align-items:center; justify-content:center;
    transition: transform .15s ease, background .2s ease;
  }
  .pd-qty button:hover{ background:#FBCDB6; }
  .pd-qty button:active{ transform: scale(.9); }
  .pd-qty output{
    min-width:27px;
    text-align:center;
    font-size:16px;
    font-weight:800;
  }
  .pd-total{ text-align:right; padding-top: 3px; }
  .pd-total .pd-order-label{ margin-bottom: 2px; }
  .pd-total strong{
    display:block;
    font-size:20px;
    font-weight:800;
    letter-spacing:-0.02em;
    color: var(--pf-brand);
    line-height:1.2;
  }

  .pd-add{
    width:100%;
    height:48px;
    border-radius:999px;
    background: var(--pf-brand);
    color:#fff;
    font-size:14px;
    font-weight:700;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    box-shadow: 0 12px 22px -10px rgba(122,59,18,.6);
    transition: transform .18s ease, box-shadow .18s ease, background .2s ease;
  }
  .pd-add:hover{ background:#843C00; box-shadow: 0 16px 26px -10px rgba(122,59,18,.65); }
  .pd-add:active{ transform: scale(.98); }

  /* ---------- PRODUK LAINNYA ---------- */
  .pd-more{
    background: var(--pf-bg-2);
    padding: 44px 0 46px;
  }
  .pd-more-head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom: 24px;
    gap:16px;
  }
  .pd-more-head h2{
    font-size:24px;
    font-weight:800;
    letter-spacing:-0.035em;
    color: var(--pf-ink);
    line-height:1.15;
  }
  .pd-more-link{
    display:inline-flex;
    align-items:center;
    gap:6px;
    font-size:14px;
    font-weight:700;
    color: var(--pf-brand);
    transition: gap .2s ease;
  }
  .pd-more-link:hover{ gap:10px; }

  .pd-more-grid{
    display:grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
  }
  .pd-mini{
    background:#fff;
    border-radius: 32px;
    padding: 16px;
    box-shadow: 0 10px 28px -14px rgba(122,59,18,.25);
    transition: transform .25s ease, box-shadow .25s ease;
  }
  .pd-mini:hover{
    transform: translateY(-4px);
    box-shadow: 0 18px 34px -16px rgba(122,59,18,.35);
  }
  .pd-mini-media{
    height:200px;
    border-radius:6px;
    overflow:hidden;
    background:#eee;
  }
  .pd-mini-media img{
    width:100%; height:100%;
    object-fit:cover;
    transition: transform .5s ease;
  }
  .pd-mini:hover .pd-mini-media img{ transform: scale(1.05); }

  .pd-mini-row{
    display:flex;
    align-items:baseline;
    justify-content:space-between;
    gap:10px;
    margin-top: 12px;
  }
  .pd-mini-row h3{
    font-size:16px;
    font-weight:700;
    letter-spacing:-0.03em;
    line-height:1.2;
    color: var(--pf-ink);
  }
  .pd-mini-row .price{
    font-family: var(--pf-font);
    font-size:15px;
    font-weight:800;
    letter-spacing:-0.02em;
    color: var(--pf-brand);
  }
  .pd-mini p{
    margin-top:6px;
    font-size:13px;
    line-height:1.3;
    color: var(--pf-muted);
  }
  .pd-mini-btn{
    margin-top:16px;
    width:100%;
    height:36px;
    border-radius:999px;
    background: var(--pf-brand-soft);
    color: var(--pf-ink);
    font-size:14px;
    font-weight:600;
    display:flex; align-items:center; justify-content:center;
    gap:8px;
    transition: background .2s ease, transform .15s ease;
  }
  .pd-mini-btn:hover{ background: var(--pf-peach); }
  .pd-mini-btn:active{ transform: scale(.98); }

  /* card "Produk Lainnya" bisa diklik ke detailnya */
  .pd-mini{ position:relative; }
  .pd-mini-link{ color:inherit; text-decoration:none; }
  .pd-mini-link::after{ content:''; position:absolute; inset:0; z-index:1; border-radius:32px; }
  .pd-mini-btn{ position:relative; z-index:2; }

  /* ---------- RESPONSIVE ---------- */
  @media (max-width: 980px){
    .pd-grid{ grid-template-columns:1fr; gap:32px; }
    .pd-more-grid{ grid-template-columns:1fr; }
    .pd-title{ font-size:26px; }
    .pd-price-box strong{ font-size:26px; }
    .pd-more-head h2{ font-size:22px; }
  }
  @media (max-width: 560px){
    .pd-options{ grid-template-columns:1fr; }
    .pd-group-head{ flex-wrap:wrap; }
    .pd-title{ font-size:24px; }
  }

  @media (prefers-reduced-motion: reduce){
    .produk-page *{ transition:none !important; animation:none !important; }
  }
</style>
@endpush

@section('content')
<div class="produk-page">

  {{-- ===================== DETAIL PRODUK ===================== --}}
  <section class="pd-detail">
    <div class="container">
      <form class="pd-grid" id="orderForm" method="POST" action="{{ url('/keranjang/tambah') }}">
        @csrf
        <input type="hidden" name="produk" value="{{ $slug }}">

        {{-- KIRI: gambar --}}
        <div class="reveal">
          <div class="pd-gallery-main">
            <img src="{{ asset('images/' . $product['img']) }}" alt="{{ $product['name'] }}">
          </div>
        </div>

        {{-- KANAN: info & opsi --}}
        <div class="reveal" style="transition-delay:.08s">
          <h1 class="pd-title">{{ $product['name'] }}</h1>

          <div class="pd-meta">
            <span class="pd-rating">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
              <b>{{ $product['rating'] }}</b> ({{ $product['reviews'] }} ulasan)
            </span>
            @if (!empty($product['sold']))
            <span class="pd-dot"></span>
            <span class="pd-sold">Terjual <b>{{ $product['sold'] }}</b> porsi</span>
            @endif
            @if (!empty($product['puas']))
            <span class="pd-dot"></span>
            <span class="pd-happy">
              <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 10v11H3V10h4z"/><path d="M7 10l4-8a2.3 2.3 0 0 1 2.2 2.8L12.5 8H19a2 2 0 0 1 2 2.4l-1.6 8A2 2 0 0 1 17.4 20H7"/></svg>
              {{ $product['puas'] }} Puas
            </span>
            @endif
          </div>

          <div class="pd-price-box">
            <strong>Rp {{ number_format($product['price'], 0, ',', '.') }}</strong>
          </div>

          <p class="pd-desc">
            {!! $product['detail'] ?? e($product['desc']) !!}
          </p>

          <hr class="pd-divider">

          @foreach (($product['options'] ?? []) as $group)
          <div class="pd-group">
            <div class="pd-group-head">
              <div class="pd-group-title">
                @if ($group['type'] === 'radio')
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-4"/><path d="M8 9h4M8 13h3"/><path d="M19.4 3.6a1.9 1.9 0 0 1 0 2.7L14 11.7 11 12.5l.8-3 5.4-5.4a1.9 1.9 0 0 1 2.2 0z"/></svg>
                @else
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 8v8M8 12h8"/></svg>
                @endif
                {{ $loop->iteration }}. {{ $group['title'] }}
              </div>
              @if (!empty($group['note']))
                <span class="{{ $group['type'] === 'radio' ? 'pd-badge' : 'pd-hint' }}">{{ $group['note'] }}</span>
              @endif
            </div>

            <div class="pd-options">
              @foreach ($group['items'] as $opt)
                @php $extra = $opt['extra'] ?? 0; @endphp
                @if ($group['type'] === 'radio')
                <label class="pd-opt">
                  <input type="radio" name="{{ $group['name'] }}" value="{{ $opt['name'] }}" data-extra="{{ $extra }}" {{ $loop->first ? 'checked' : '' }}>
                  <span class="pd-radio"></span>
                  <span class="pd-opt-text"><b>{{ $opt['name'] }}</b>@if (!empty($opt['desc']))<span>{{ $opt['desc'] }}</span>@endif</span>
                  @if ($extra > 0)
                    <span class="pd-opt-price">+Rp {{ number_format($extra, 0, ',', '.') }}</span>
                  @else
                    <span class="pd-opt-price free">Gratis</span>
                  @endif
                </label>
                @else
                <label class="pd-opt compact">
                  <input type="checkbox" name="{{ $group['name'] }}" value="{{ $opt['name'] }}" data-extra="{{ $extra }}">
                  <span class="pd-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg></span>
                  <span class="pd-opt-text"><b>{{ $opt['name'] }}</b></span>
                  @if ($extra > 0)
                    <span class="pd-opt-price">+Rp {{ number_format($extra, 0, ',', '.') }}</span>
                  @else
                    <span class="pd-opt-price free">Gratis</span>
                  @endif
                </label>
                @endif
              @endforeach
            </div>
          </div>
          @endforeach

          {{-- Jumlah & tombol --}}
          <div class="pd-order">
            <div class="pd-order-top">
              <div>
                <div class="pd-order-label">Atur Jumlah Pesanan</div>
                <div class="pd-qty">
                  <button type="button" id="qtyMinus" aria-label="Kurangi jumlah">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14"/></svg>
                  </button>
                  <output id="qtyValue">1</output>
                  <input type="hidden" name="qty" id="qtyInput" value="1">
                  <button type="button" id="qtyPlus" aria-label="Tambah jumlah">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
                  </button>
                </div>
              </div>
              <div class="pd-total">
                <div class="pd-order-label">Total Subtotal:</div>
                <strong id="subtotal">Rp {{ number_format($product['price'], 0, ',', '.') }}</strong>
              </div>
            </div>

            <button type="submit" class="pd-add">
              + Masukkan ke Keranjang
            </button>
          </div>
        </div>
      </form>
    </div>
  </section>

  {{-- ===================== PRODUK LAINNYA ===================== --}}
  <section class="pd-more">
    <div class="container">
      <div class="pd-more-head reveal">
        <h2>Produk Lainnya</h2>
        <a href="{{ url('/menu') }}" class="pd-more-link">
          Lihat Semua Menu
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
      </div>

      <div class="pd-more-grid">
        @foreach ($related as $rSlug => $r)
        <article class="pd-mini reveal" style="transition-delay:{{ $loop->index * 0.08 }}s">
          <div class="pd-mini-media">
            <img src="{{ asset('images/' . $r['img']) }}" alt="{{ $r['name'] }}" loading="lazy">
          </div>
          <div class="pd-mini-row">
            <h3><a href="{{ url('/produklogin?p=' . $rSlug) }}" class="pd-mini-link">{{ $r['name'] }}</a></h3>
            <span class="price">Rp {{ number_format($r['price'], 0, ',', '.') }}</span>
          </div>
          <p>{{ $r['desc'] }}</p>
          <button type="button" class="pd-mini-btn" data-produk="{{ $rSlug }}">
            + Tambah
          </button>
        </article>
        @endforeach
      </div>
    </div>
  </section>

</div>
@endsection

@push('scripts')
<script>
  (function () {
    const BASE_PRICE = {{ (int) $product['price'] }};
    const form      = document.getElementById('orderForm');
    const qtyValue  = document.getElementById('qtyValue');
    const qtyInput  = document.getElementById('qtyInput');
    const subtotal  = document.getElementById('subtotal');
    let qty = 1;

    const rupiah = (n) => 'Rp ' + n.toLocaleString('id-ID');

    function recalc() {
      let extra = 0;
      form.querySelectorAll('input[data-extra]:checked').forEach(el => {
        extra += parseInt(el.dataset.extra, 10) || 0;
      });
      subtotal.textContent = rupiah((BASE_PRICE + extra) * qty);
      qtyValue.textContent = qty;
      qtyInput.value = qty;
    }

    form.addEventListener('change', recalc);
    document.getElementById('qtyMinus').addEventListener('click', () => {
      if (qty > 1) { qty--; recalc(); }
    });
    document.getElementById('qtyPlus').addEventListener('click', () => {
      qty++; recalc();
    });


    recalc();
  })();
</script>
@endpush