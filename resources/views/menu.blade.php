@extends('layouts.app')

@section('title', 'Katalog Menu — 2DA Store')
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

  /* ---------- POP-UP "LOGIN DULU" (untuk user yang belum login) ---------- */
  .mn-lock{ overflow:hidden; }
  .mn-modal{
    position:fixed;
    inset:0;
    z-index:2000;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:20px;
    opacity:0;
    transition: opacity .2s ease;
  }
  .mn-modal[hidden]{ display:none; }
  .mn-modal.is-open{ opacity:1; }
  .mn-modal-backdrop{
    position:absolute;
    inset:0;
    background:rgba(59,31,20,.45);
    backdrop-filter: blur(3px);
  }
  .mn-modal-card{
    position:relative;
    width:100%;
    max-width:400px;
    background:#fff;
    border-radius:28px;
    padding:32px 28px 24px;
    text-align:center;
    box-shadow: 0 30px 60px -20px rgba(59,31,20,.45);
    transform: translateY(12px) scale(.97);
    transition: transform .25s ease;
  }
  .mn-modal.is-open .mn-modal-card{ transform:none; }

  .mn-modal-x{
    position:absolute;
    top:14px; right:14px;
    width:34px; height:34px;
    border:0;
    border-radius:50%;
    background:transparent;
    color: var(--mn-muted);
    cursor:pointer;
    display:flex;
    align-items:center;
    justify-content:center;
    transition: background .2s ease;
  }
  .mn-modal-x:hover{ background:#FFE9DB; }
  .mn-modal-x svg{ width:18px; height:18px; }

  .mn-modal-icon{
    width:64px; height:64px;
    border-radius:50%;
    background:#FFE9DB;
    color: var(--mn-brown);
    display:flex;
    align-items:center;
    justify-content:center;
    margin:0 auto 16px;
  }
  .mn-modal-icon svg{ width:28px; height:28px; }

  .mn-modal-card h2{
    font-family: var(--font-display);
    font-weight:700;
    font-size:22px;
    line-height:1.25;
    color: var(--mn-dark);
    margin-bottom:8px;
  }
  .mn-modal-card p{
    font-size:14px;
    line-height:1.6;
    color: var(--ink-soft);
  }
  .mn-modal-card p b{ color: var(--ink); font-weight:600; }

  .mn-modal-actions{
    display:flex;
    flex-direction:column;
    gap:8px;
    margin-top:22px;
  }
  .mn-modal-login{
    display:block;
    background: var(--mn-brown);
    color:#fff;
    font-family: var(--font-display);
    font-weight:600;
    font-size:14px;
    padding:13px 20px;
    border-radius:999px;
    text-decoration:none;
    transition: background .2s ease, transform .18s ease;
  }
  .mn-modal-login:hover{ background: var(--mn-dark); }
  .mn-modal-login:active{ transform: scale(.97); }
  .mn-modal-later{
    border:0;
    background:transparent;
    cursor:pointer;
    font-family: var(--font-display);
    font-weight:600;
    font-size:13.5px;
    color: var(--mn-muted);
    padding:10px;
    border-radius:999px;
    transition: background .2s ease, color .2s ease;
  }
  .mn-modal-later:hover{ background:#FFF2EA; color: var(--mn-dark); }
  .mn-modal-login:focus-visible,
  .mn-modal-later:focus-visible,
  .mn-modal-x:focus-visible{ outline:2px solid var(--mn-brown); outline-offset:2px; }

  @media (prefers-reduced-motion: reduce){
    .mn-modal, .mn-modal-card{ transition:none; }
  }

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
      <h1 class="mn-title">Katalog Menu 2DA Store</h1>
      <p class="mn-subtitle">Nikmati pilihan camilan hangat dan lezat kami, dibuat dengan bahan premium untuk menemani momen santai Anda setiap hari.</p>

      <div class="mn-search">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        <input type="search" id="mnSearch" placeholder="Cari camilan atau minuman favoritmu..." autocomplete="off" aria-label="Cari menu">
      </div>

      <div class="mn-chips" id="mnChips">
        <button type="button" class="mn-chip active" data-cat="semua">Semua Menu ({{ $totalProducts }})</button>
        <button type="button" class="mn-chip" data-cat="gurih">Makanan Gurih</button>
        <button type="button" class="mn-chip" data-cat="manis">Makanan Manis</button>
        <button type="button" class="mn-chip" data-cat="minuman">Minuman</button>
      </div>
    </div>
  </section>

  {{-- ====================== DAFTAR PRODUK ====================== --}}
  <section class="mn-list">
    <div class="container">

      <div class="mn-meta">
        <div class="mn-count">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/></svg>
          <span>Menampilkan <span id="mnCount">{{ $totalProducts }}</span> Produk</span>
          <span class="soft">&bull; Siap dibuat fresh hangat</span>
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
                <h3><a href="{{ url('/produk?p=' . $slug) }}" class="mn-link">{{ $p['name'] }}</a></h3>
                <p class="mn-desc">{{ $p['desc'] }}</p>

                <div class="mn-foot">
                  <div class="mn-price">
                    <small>Harga</small>
                    <strong>Rp {{ number_format($p['price'], 0, ',', '.') }}</strong>
                  </div>
                  <button type="button" class="mn-add"
                          data-name="{{ $p['name'] }}"
                          aria-haspopup="dialog">
                    + Tambah
                  </button>
                </div>
              </div>
            </article>
          </div>
        @endforeach
      </div>

      <p class="mn-empty" id="mnEmpty" hidden>Menu yang kamu cari belum tersedia. Coba kata kunci lain.</p>
    </div>
  </section>

  {{-- ====================== POP-UP LOGIN DULU ====================== --}}
  <div class="mn-modal" id="mnLoginModal" role="dialog" aria-modal="true"
       aria-labelledby="mnLoginTitle" aria-describedby="mnLoginDesc" hidden>
    <div class="mn-modal-backdrop" data-close></div>
    <div class="mn-modal-card">
      <button type="button" class="mn-modal-x" data-close aria-label="Tutup">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
      </button>

      <div class="mn-modal-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
      </div>

      <h2 id="mnLoginTitle">Login dulu, yuk!</h2>
      <p id="mnLoginDesc">Untuk menambahkan <b id="mnLoginItem">menu ini</b> ke keranjang, kamu perlu masuk ke akunmu terlebih dahulu.</p>

      <div class="mn-modal-actions">
        <a href="{{ url('/login') }}" class="mn-modal-login">Login Sekarang</a>
        <button type="button" class="mn-modal-later" data-close>Nanti Saja</button>
      </div>
    </div>
  </div>

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

    // Tombol "Tambah" — user belum login, jadi tampilkan pop-up ajakan login
    const modal   = document.getElementById('mnLoginModal');
    const itemEl  = document.getElementById('mnLoginItem');
    const loginEl = modal.querySelector('.mn-modal-login');
    let lastTrigger = null;
    let hideTimer   = null;

    function openModal(btn) {
      lastTrigger = btn;
      itemEl.textContent = btn.dataset.name ? '\u201C' + btn.dataset.name + '\u201D' : 'menu ini';

      clearTimeout(hideTimer);
      modal.hidden = false;
      requestAnimationFrame(() => modal.classList.add('is-open'));
      document.documentElement.classList.add('mn-lock');
      loginEl.focus();
    }

    function closeModal() {
      modal.classList.remove('is-open');
      document.documentElement.classList.remove('mn-lock');
      hideTimer = setTimeout(() => { modal.hidden = true; }, 200);
      if (lastTrigger) lastTrigger.focus();
    }

    document.querySelectorAll('.mn-add').forEach(btn => {
      btn.addEventListener('click', () => {
        btn.classList.remove('pop');
        void btn.offsetWidth; // restart animasi
        btn.classList.add('pop');
        openModal(btn);
      });
    });

    modal.querySelectorAll('[data-close]').forEach(el => el.addEventListener('click', closeModal));

    document.addEventListener('keydown', (e) => {
      if (modal.hidden) return;

      if (e.key === 'Escape') { closeModal(); return; }

      // fokus tetap di dalam pop-up saat tekan Tab
      if (e.key === 'Tab') {
        const focusables = modal.querySelectorAll('a[href], button:not([disabled])');
        const first = focusables[0];
        const last  = focusables[focusables.length - 1];
        if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
        else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
      }
    });
  })();
</script>
@endpush