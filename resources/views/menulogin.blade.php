@extends('layouts.applogin')

@section('title', __('menu.page_title'))
@section('body-class', 'page-menu')
@php
  $imgFolder = 'images/';

  // Data produk ada di config/menu.php (dipakai juga oleh halaman detail)
  $products = config('menu');

  $totalProducts = count($products);
@endphp
@push('styles')
<style>
  /* ============================================================
     HALAMAN KATALOG MENU  (semua class diawali .mn- supaya tidak
     bentrok dengan class di layouts/applogin.blade.php)
     ============================================================ */
  .page-menu{
    --mn-brown: #A34A0B;
    --mn-price: #B85410;
    --mn-dark: #3B1F14;
    --mn-muted: #8a7768;
  }

  .mn-page{
    background: var(--cream, #FFF2EA);
  }

  /* ---------- HEADER KATALOG ---------- */
  .mn-hero{
    text-align:center;
    background: radial-gradient(circle at 50% 30%, #fbdcc4 0%, var(--cream, #FFF2EA) 70%);
    padding: 28px 0 44px;
  }


  .mn-title{
    font-family: var(--font-display);
    font-weight:700;
    font-size:36px;
    line-height:1.15;
    letter-spacing:-0.5px;
    color: var(--mn-brown);
    margin:14px 0 12px;
  }

  .mn-subtitle{
    max-width:640px;
    margin:0 auto;
    font-size:15px;
    line-height:1.6;
    color: var(--ink-soft);
  }

  /* ---------- SEARCH ---------- */
  .mn-search{
    position:relative;
    max-width:640px;
    margin:26px auto 0;
  }
  .mn-search svg{
    position:absolute;
    left:22px; top:50%;
    transform:translateY(-50%);
    width:18px; height:18px;
    color: var(--ink);
    pointer-events:none;
  }
  .mn-search input{
    width:100%;
    height:54px;
    border:none;
    outline:none;
    background:#fff;
    border-radius:999px;
    padding:0 24px 0 58px;
    font-family: var(--font-body);
    font-size:14px;
    color: var(--ink);
    box-shadow: 0 8px 22px -12px rgba(59,31,20,.25);
    transition: box-shadow .2s ease;
  }
  .mn-search input::placeholder{ color:#9a8b7f; }
  .mn-search input:focus{ box-shadow: 0 0 0 2px var(--orange), 0 8px 22px -12px rgba(59,31,20,.25); }

  /* ---------- FILTER CHIPS ---------- */
  .mn-chips{
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
    gap:10px;
    margin-top:24px;
  }
  .mn-chip{
    background:#fff;
    color: var(--ink);
    font-family: var(--font-display);
    font-weight:600;
    font-size:13.5px;
    padding:11px 26px;
    border-radius:999px;
    box-shadow: 0 6px 16px -12px rgba(59,31,20,.35);
    transition: background .2s ease, color .2s ease, transform .18s ease;
  }
  .mn-chip:hover{ background:#FFE9DB; }
  .mn-chip:active{ transform: scale(.97); }
  .mn-chip.active{
    background: var(--mn-brown);
    color:#fff;
    box-shadow: 0 10px 18px -10px rgba(122,59,18,.7);
  }

  /* ---------- BARIS INFO & URUTKAN ---------- */
  .mn-meta{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:16px;
    flex-wrap:wrap;
    margin: 34px 0 22px;
    font-size:12.5px;
  }
  .mn-count{
    display:flex;
    align-items:center;
    gap:6px;
    color: var(--ink);
    font-weight:600;
  }
  .mn-count svg{ width:14px; height:14px; color: var(--orange); }
  .mn-count .soft{ color: var(--mn-muted); font-weight:500; }

  .mn-list{ padding-bottom:64px; }

  /* ---------- GRID PRODUK ---------- */
  .mn-grid{
    display:grid;
    grid-template-columns: repeat(3, 1fr);
    gap:22px;
  }
  .mn-item[hidden]{ display:none; }

  .mn-card{
    background:#fff;
    border-radius: var(--radius-lg);
    overflow:hidden;
    display:flex;
    flex-direction:column;
    height:100%;
    box-shadow: 0 14px 30px -18px rgba(59,31,20,.28);
    transition: transform .25s ease, box-shadow .25s ease;
  }
  .mn-card:hover{
    transform: translateY(-6px);
    box-shadow: 0 22px 36px -18px rgba(59,31,20,.38);
  }

  .mn-media{
    position:relative;
    aspect-ratio: 4/3;
    overflow:hidden;
    background:#eee;
  }
  .mn-media img{
    width:100%; height:100%;
    object-fit:cover;
    transition: transform .5s ease;
  }
  .mn-card:hover .mn-media img{ transform: scale(1.06); }

  .mn-rating{
    position:absolute;
    right:12px; bottom:12px;
    display:inline-flex;
    align-items:center;
    gap:4px;
    background:rgba(255,255,255,.94);
    border-radius:12px;
    padding:4px 10px;
    font-size:11.5px;
    color: var(--mn-muted);
    box-shadow: 0 4px 10px -4px rgba(0,0,0,.25);
  }
  .mn-rating svg{ width:11px; height:11px; color: var(--orange); fill: var(--orange); stroke: var(--orange); }
  .mn-rating b{ color: var(--ink); font-weight:700; }

  .mn-body{
    padding:18px 18px 18px;
    display:flex;
    flex-direction:column;
    flex:1;
  }
  .mn-body h3{
    font-family: var(--font-display);
    font-weight:600;
    font-size:19px;
    line-height:1.3;
    color: var(--ink);
    margin-bottom:8px;
  }
  .mn-desc{
    font-size:13.5px;
    line-height:1.55;
    color: var(--ink-soft);
    display:-webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
    overflow:hidden;
    min-height: calc(1.55em * 2);
  }

  .mn-foot{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:12px;
    margin-top:auto;
    padding-top:14px;
  }
  .mn-price small{
    display:block;
    font-size:11.5px;
    color: var(--mn-muted);
    margin-bottom:1px;
  }
  .mn-price strong{
    font-family: var(--font-display);
    font-weight:700;
    font-size:21px;
    letter-spacing:-.2px;
    color: var(--mn-price);
  }

  .mn-add{
    display:inline-flex;
    align-items:center;
    gap:8px;
    background: var(--mn-dark);
    color:#fff;
    font-family: var(--font-display);
    font-weight:600;
    font-size:13px;
    padding:11px 20px;
    border-radius:999px;
    transition: background .2s ease, transform .18s ease;
  }
  .mn-add:hover{ background: var(--mn-brown); }
  .mn-add:active{ transform: scale(.95); }
  .mn-add.pop{ animation: mnPop .35s ease; }
  @keyframes mnPop{
    0%{ transform:scale(1); }
    45%{ transform:scale(1.12); }
    100%{ transform:scale(1); }
  }

  .mn-empty{
    text-align:center;
    padding:60px 0 20px;
    color: var(--ink-soft);
    font-size:15px;
  }
  .mn-empty[hidden]{ display:none; }

  /* ---------- CARD BISA DIKLIK (stretched link ke detail produk) ---------- */
  .mn-card{ position:relative; }
  .mn-link{ color:inherit; text-decoration:none; }
  .mn-link::after{
    content:'';
    position:absolute;
    inset:0;
    z-index:1;
  }
  .mn-card:has(.mn-link:focus-visible){ outline:2px solid var(--mn-brown); outline-offset:3px; }
  .mn-link:focus-visible{ outline:none; }
  .mn-add{ position:relative; z-index:2; } /* tombol Tambah tetap di atas link */

  /* ---------- RESPONSIVE ---------- */
  @media (max-width: 980px){
    .mn-title{ font-size:32px; }
    .mn-grid{ grid-template-columns: repeat(2, 1fr); }
  }
  @media (max-width: 640px){
    .mn-title{ font-size:28px; }
    .mn-grid{ grid-template-columns:1fr; }
    .mn-chip{ padding:10px 18px; font-size:13px; }
  }

  @media (prefers-reduced-motion: reduce){
    .mn-card, .mn-media img, .mn-add{ transition:none; }
    .mn-add.pop{ animation:none; }
  }
</style>
@endpush

@section('content')
<div class="mn-page">

  {{-- ====================== HEADER KATALOG ====================== --}}
  <section class="mn-hero">
    <div class="container">
      <h1 class="mn-title">{{ __('menu.hero_title') }}</h1>
      <p class="mn-subtitle">{{ __('menu.hero_subtitle') }}</p>

      <div class="mn-search">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        <input type="search" id="mnSearch" placeholder="{{ __('menu.search_placeholder') }}" autocomplete="off" aria-label="{{ __('menu.search_label') }}">
      </div>

      <div class="mn-chips" id="mnChips">
        <button type="button" class="mn-chip active" data-cat="semua">{{ __('menu.all_menu') }} ({{ $totalProducts }})</button>
        <button type="button" class="mn-chip" data-cat="gurih">{{ __('menu.savory') }}</button>
        <button type="button" class="mn-chip" data-cat="manis">{{ __('menu.sweet') }}</button>
        <button type="button" class="mn-chip" data-cat="minuman">{{ __('menu.drinks') }}</button>
      </div>
    </div>
  </section>

  {{-- ====================== DAFTAR PRODUK ====================== --}}
  <section class="mn-list">
    <div class="container">

      <div class="mn-meta">
        <div class="mn-count">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/></svg>
          <span>{{ __('menu.showing') }} <span id="mnCount">{{ $totalProducts }}</span> {{ __('menu.products') }}</span>
          <span class="soft">&bull; {{ __('menu.fresh_note') }}</span>
        </div>
      </div>

      <div class="mn-grid" id="mnGrid">
        @foreach ($products as $slug => $p)
          <div class="mn-item reveal"
               style="transition-delay: {{ ($loop->index % 3) * 0.08 }}s"
               data-search="{{ \Illuminate\Support\Str::lower($p['name'] . ' ' . $p['desc']) }}"
               data-cats="{{ $p['cats'] }}">
            <article class="mn-card">
              <div class="mn-media">
                <img src="{{ asset($imgFolder . $p['img']) }}" alt="{{ $p['name'] }}" loading="lazy">
                <span class="mn-rating">
                  <svg viewBox="0 0 24 24" stroke-width="1" stroke-linejoin="round" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                  <b>{{ $p['rating'] }}</b> ({{ $p['reviews'] }})
                </span>
              </div>

              <div class="mn-body">
                <h3><a href="{{ url('/produklogin?p=' . $slug) }}" class="mn-link">{{ $p['name'] }}</a></h3>
                <p class="mn-desc">{{ $p['desc'] }}</p>

                <div class="mn-foot">
                  <div class="mn-price">
                    <small>{{ __('menu.price') }}</small>
                    <strong>Rp {{ number_format($p['price'], 0, ',', '.') }}</strong>
                  </div>
                  <button type="button" class="mn-add"
                          data-slug="{{ $slug }}"
                          aria-haspopup="dialog">
                    + {{ __('menu.add') }}
                  </button>
                </div>
              </div>
            </article>
          </div>
        @endforeach
      </div>

      <p class="mn-empty" id="mnEmpty" hidden>{{ __('menu.empty') }}</p>
    </div>
  </section>

  {{-- ====================== POP-UP TAMBAH KE KERANJANG ====================== --}}
  @include('tambah-keranjang', ['products' => $products])

</div>
@endsection

@push('scripts')
<script>
  (function () {
    const grid     = document.getElementById('mnGrid');
    const items    = Array.from(grid.querySelectorAll('.mn-item'));
    const search   = document.getElementById('mnSearch');
    const chips    = document.querySelectorAll('#mnChips .mn-chip');
    const countEl  = document.getElementById('mnCount');
    const emptyEl  = document.getElementById('mnEmpty');

    let activeCat = 'semua';

    // Filter kategori + pencarian
    function applyFilter() {
      const q = search.value.trim().toLowerCase();
      let visible = 0;

      items.forEach(item => {
        const inCat  = activeCat === 'semua' || item.dataset.cats.split(' ').includes(activeCat);
        const inText = !q || item.dataset.search.includes(q);
        const show   = inCat && inText;
        item.hidden = !show;
        if (show) visible++;
      });

      countEl.textContent = visible;
      emptyEl.hidden = visible !== 0;
    }

    chips.forEach(chip => {
      chip.addEventListener('click', () => {
        chips.forEach(c => c.classList.remove('active'));
        chip.classList.add('active');
        activeCat = chip.dataset.cat;
        applyFilter();
      });
    });

    search.addEventListener('input', applyFilter);

    // Tombol "+ Tambah" — buka pop-up pilihan saus/topping (partial tambah-keranjang)
    document.querySelectorAll('.mn-add').forEach(btn => {
      btn.addEventListener('click', () => {
        btn.classList.remove('pop');
        void btn.offsetWidth; // restart animasi
        btn.classList.add('pop');

        if (window.tkOpen) window.tkOpen(btn.dataset.slug, btn);
      });
    });
  })();
</script>
@endpush