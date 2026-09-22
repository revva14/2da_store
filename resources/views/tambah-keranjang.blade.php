{{--
  POP-UP TAMBAH KE KERANJANG
  Dipakai lewat: @include('tambah-keranjang', ['products' => $products])
  Dibuka lewat : window.tkOpen(slug, tombolPemicu)

  Isi pop-up (foto, nama, harga, rating, saus/topping) diambil dari config/menu.php
  sesuai produk yang diklik. Form-nya dikirim ke /keranjang/tambah.
--}}
@php
  $tkData = collect($products ?? config('menu'))->map(function ($p, $slug) {
      return [
          'slug'    => $slug,
          'name'    => $p['name'],
          'img'     => asset('images/' . $p['img']),
          'rating'  => $p['rating'],
          'reviews' => $p['reviews'],
          'price'   => (int) $p['price'],
          'options' => $p['options'] ?? [],
      ];
  })->all();
@endphp

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  /* ============================================================
     POP-UP TAMBAH KE KERANJANG  (semua class diawali .tk- supaya
     tidak bentrok dengan class lain di halaman)
     ============================================================ */
  html.tk-lock{ overflow:hidden; }

  .tk-modal{
    --tk-font: 'Plus Jakarta Sans', 'Inter', sans-serif;
    --tk-ink: #2B1407;
    --tk-muted: #5C4B42;
    --tk-soft: #8a7768;
    --tk-brand: #9F4A00;
    --tk-brand-dark: #7d3a00;
    --tk-peach: #FDDFD0;
    --tk-tint: #FFF1EA;
    --tk-line: #F0DDD3;
    --tk-green: #3A6B1E;

    position:fixed;
    inset:0;
    z-index:2000;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:20px;
    font-family: var(--tk-font);
    color: var(--tk-ink);
    opacity:0;
    transition: opacity .2s ease;
  }
  .tk-modal[hidden]{ display:none; }
  .tk-modal.is-open{ opacity:1; }
  .tk-modal button{ font-family: var(--tk-font); }
  .tk-modal svg{ display:block; flex:none; }

  .tk-backdrop{
    position:absolute;
    inset:0;
    background: rgba(59,31,20,.45);
    backdrop-filter: blur(3px);
  }

  /* ---------- KARTU ---------- */
  .tk-card{
    position:relative;
    display:flex;
    flex-direction:column;
    width:100%;
    max-width:512px;
    max-height:92vh;
    max-height:min(92dvh, 740px);
    background:#fff;
    border-radius:28px;
    overflow:hidden;
    box-shadow: 0 30px 60px -20px rgba(60,30,10,.4);
    transform: translateY(20px) scale(.97);
    transition: transform .28s cubic-bezier(.2,.8,.2,1);
  }
  .tk-modal.is-open .tk-card{ transform:none; }

  /* ---------- HEADER ---------- */
  .tk-head{
    display:flex;
    align-items:center;
    gap:14px;
    padding:17px 16px;
    background: linear-gradient(135deg, #FFEFE8, #FFF3EE);
    border-bottom:1px solid var(--tk-line);
  }
  .tk-thumb{
    width:55px; height:55px;
    border-radius:14px;
    object-fit:cover;
    flex:none;
    background:#eee;
  }
  .tk-head-info{ flex:1; min-width:0; }
  .tk-rating{
    display:flex;
    align-items:center;
    gap:5px;
    font-size:12px;
    color: var(--tk-soft);
  }
  .tk-rating svg{ color:#E0A526; }
  .tk-rating b{ color: var(--tk-ink); font-weight:800; }
  .tk-name{
    font-size:20px;
    font-weight:800;
    letter-spacing:-0.02em;
    line-height:1.2;
    margin-top:2px;
  }
  .tk-price{
    font-size:20px;
    font-weight:800;
    letter-spacing:-0.02em;
    color: var(--tk-brand);
    margin-top:3px;
  }
  .tk-close{
    align-self:flex-start;
    width:36px; height:36px;
    border:0;
    border-radius:50%;
    background: var(--tk-peach);
    color: var(--tk-ink);
    display:flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
    flex:none;
    transition: transform .2s ease, background .2s ease;
  }
  .tk-close:hover{ background:#f8cdb6; transform: rotate(90deg); }
  .tk-close:active{ transform: rotate(90deg) scale(.92); }

  /* ---------- ISI (bisa di-scroll) ---------- */
  .tk-body{
    flex:1;
    min-height:0;
    overflow-y:auto;
    overscroll-behavior:contain;
    padding:24px 24px 26px;
  }
  .tk-body:empty{ display:none; }

  .tk-group + .tk-group{ margin-top:26px; }
  .tk-group-head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
  }
  .tk-group-head h3{
    font-size:17px;
    font-weight:800;
    letter-spacing:-0.01em;
    line-height:1.3;
  }
  .tk-badge{
    background: var(--tk-peach);
    color: var(--tk-brand);
    font-size:11px;
    font-weight:800;
    letter-spacing:.02em;
    padding:4px 10px;
    border-radius:999px;
    white-space:nowrap;
  }
  .tk-optional{
    font-size:13px;
    color: var(--tk-soft);
    white-space:nowrap;
  }
  .tk-hint{
    margin:3px 0 12px;
    font-size:12px;
    color: var(--tk-soft);
  }

  .tk-options{ display:flex; flex-direction:column; gap:10px; }

  .tk-row{
    position:relative;
    display:flex;
    align-items:center;
    gap:12px;
    min-height:46px;
    padding:0 16px;
    background:#fff;
    border:1px solid var(--tk-line);
    border-radius:16px;
    cursor:pointer;
    transition: border-color .18s ease, background .18s ease, box-shadow .18s ease, transform .12s ease;
  }
  .tk-row:hover{ border-color:#e3c3b1; }
  .tk-row:active{ transform: scale(.995); }
  .tk-row.is-checked{
    background: var(--tk-tint);
    border-color: var(--tk-brand);
    box-shadow: 0 0 0 1px var(--tk-brand);
  }
  .tk-row input{
    position:absolute;
    opacity:0;
    pointer-events:none;
  }

  .tk-mark{
    position:relative;
    width:20px; height:20px;
    border:1.5px solid var(--tk-soft);
    background:#fff;
    flex:none;
    transition: border-color .18s ease, background .18s ease;
  }
  .tk-mark.radio{ border-radius:50%; }
  .tk-mark.radio::after{
    content:'';
    position:absolute;
    inset:4px;
    border-radius:50%;
    background: var(--tk-brand);
    transform: scale(0);
    transition: transform .18s ease;
  }
  .tk-mark.check{ border-radius:5px; }
  .tk-mark.check svg{
    position:absolute;
    inset:1px;
    width:14px; height:14px;
    color:#fff;
    transform: scale(0);
    transition: transform .18s ease;
  }
  .tk-row.is-checked .tk-mark{ border-color: var(--tk-brand); }
  .tk-row.is-checked .tk-mark.radio::after{ transform: scale(1); }
  .tk-row.is-checked .tk-mark.check{ background: var(--tk-brand); }
  .tk-row.is-checked .tk-mark.check svg{ transform: scale(1); }
  .tk-row input:focus-visible + .tk-mark{ outline:2px solid var(--tk-brand); outline-offset:2px; }

  .tk-opt-name{
    flex:1;
    font-size:14px;
    font-weight:700;
    line-height:1.3;
  }
  .tk-opt-price{
    font-size:11.5px;
    font-weight:800;
    color: var(--tk-brand);
    white-space:nowrap;
  }
  .tk-opt-price.free{ color: var(--tk-green); font-weight:700; font-size:12px; }

  /* ---------- FOOTER ---------- */
  .tk-foot{
    display:flex;
    align-items:center;
    gap:14px;
    padding:16px 18px;
    background:#fff;
    border-top:1px solid var(--tk-line);
  }
  .tk-qty{
    display:flex;
    align-items:center;
    gap:6px;
    padding:5px;
    background:#FFF3EE;
    border:1px solid #F6D3BC;
    border-radius:999px;
    flex:none;
  }
  .tk-qty button{
    width:34px; height:34px;
    border:0;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
    transition: transform .15s ease, background .2s ease;
  }
  .tk-qty button:active{ transform: scale(.88); }
  .tk-qty .minus{ background: var(--tk-peach); color: var(--tk-ink); }
  .tk-qty .minus:hover{ background:#f8cdb6; }
  .tk-qty .plus{ background: var(--tk-brand); color:#fff; }
  .tk-qty .plus:hover{ background: var(--tk-brand-dark); }
  .tk-qty output{
    min-width:26px;
    text-align:center;
    font-size:17px;
    font-weight:700;
  }

  .tk-add{
    flex:1;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:12px;
    min-height:64px;
    padding:10px 22px;
    border:0;
    border-radius:999px;
    background: var(--tk-brand);
    color:#fff;
    font-size:15px;
    font-weight:800;
    line-height:1.35;
    text-align:center;
    cursor:pointer;
    box-shadow: 0 14px 24px -10px rgba(159,74,0,.55);
    transition: background .2s ease, transform .1s ease;
  }
  .tk-add:hover{ background: var(--tk-brand-dark); }
  .tk-add:active{ transform: scale(.97); }

  .tk-close:focus-visible,
  .tk-qty button:focus-visible,
  .tk-add:focus-visible{ outline:2px solid var(--tk-brand); outline-offset:2px; }

  /* ---------- POP-UP BERHASIL DITAMBAHKAN ---------- */
  .tk-done-card{
    max-width:400px;
    align-items:center;
    text-align:center;
    padding:32px 26px 24px;
  }
  .tk-done-icon{
    width:64px; height:64px;
    border-radius:50%;
    background: var(--tk-tint);
    color: var(--tk-brand);
    display:flex;
    align-items:center;
    justify-content:center;
    margin-bottom:16px;
  }
  .tk-done-title{
    font-size:20px;
    font-weight:800;
    letter-spacing:-0.02em;
  }
  .tk-done-text{
    margin-top:6px;
    font-size:14px;
    line-height:1.5;
    color: var(--tk-muted);
  }
  .tk-done-text b{ color: var(--tk-ink); }
  .tk-done-actions{
    display:flex;
    gap:10px;
    width:100%;
    margin-top:22px;
  }
  .tk-btn{
    flex:1;
    min-height:48px;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:0 14px;
    border:0;
    border-radius:999px;
    font-size:14px;
    font-weight:800;
    text-decoration:none;
    cursor:pointer;
    transition: background .2s ease, transform .1s ease;
  }
  .tk-btn:active{ transform: scale(.97); }
  .tk-btn.ghost{ background: var(--tk-peach); color: var(--tk-ink); }
  .tk-btn.ghost:hover{ background:#f8cdb6; }
  .tk-btn.solid{
    background: var(--tk-brand);
    color:#fff;
    box-shadow: 0 12px 20px -10px rgba(159,74,0,.55);
  }
  .tk-btn.solid:hover{ background: var(--tk-brand-dark); }
  .tk-btn:focus-visible{ outline:2px solid var(--tk-brand); outline-offset:2px; }

  /* ---------- RESPONSIVE ---------- */
  @media (max-width: 560px){
    .tk-modal{ padding:12px; }
    .tk-name, .tk-price{ font-size:18px; }
    .tk-body{ padding:20px 18px 22px; }
    .tk-foot{ padding:14px; gap:10px; }
    .tk-add{ font-size:14px; padding:10px 16px; gap:10px; }
  }

  @media (prefers-reduced-motion: reduce){
    .tk-modal, .tk-card, .tk-row, .tk-mark, .tk-mark::after, .tk-mark svg,
    .tk-close, .tk-qty button, .tk-add{ transition:none; }
  }
</style>
@endpush

<div class="tk-modal" id="tkModal" role="dialog" aria-modal="true" aria-labelledby="tkName" hidden>
  <div class="tk-backdrop" data-tk-close></div>

  <form class="tk-card" id="tkForm" method="POST" action="{{ url('/keranjang/tambah') }}">
    @csrf
    <input type="hidden" name="produk" id="tkSlug" value="">
    <input type="hidden" name="qty" id="tkQty" value="1">

    {{-- HEADER: foto, rating, nama, harga --}}
    <div class="tk-head">
      <img class="tk-thumb" id="tkThumb" alt="">
      <div class="tk-head-info">
        <div class="tk-rating">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
          <b id="tkRating"></b>
          <span id="tkReviews"></span>
        </div>
        <div class="tk-name" id="tkName"></div>
        <div class="tk-price" id="tkPrice"></div>
      </div>
      <button type="button" class="tk-close" data-tk-close aria-label="Tutup">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
      </button>
    </div>

    {{-- ISI: pilihan saus & topping (diisi lewat JS sesuai produk) --}}
    <div class="tk-body" id="tkBody"></div>

    {{-- FOOTER: jumlah & tombol --}}
    <div class="tk-foot">
      <div class="tk-qty">
        <button type="button" class="minus" id="tkMinus" aria-label="Kurangi jumlah">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><path d="M5 12h14"/></svg>
        </button>
        <output id="tkQtyValue" aria-live="polite">1</output>
        <button type="button" class="plus" id="tkPlus" aria-label="Tambah jumlah">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>
        </button>
      </div>

      <button type="submit" class="tk-add">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="20" r="1.4"/><circle cx="18" cy="20" r="1.4"/><path d="M2 3h2.5l2.2 11.2a1.6 1.6 0 0 0 1.6 1.3h9.2a1.6 1.6 0 0 0 1.6-1.2L21 7H8"/><path d="M13 4v4M11 6h4"/></svg>
        <span id="tkAddText">+ Masukkan ke Keranjang</span>
      </button>
    </div>
  </form>
</div>

{{-- POP-UP KONFIRMASI: muncul setelah item berhasil masuk keranjang --}}
<div class="tk-modal" id="tkDone" role="dialog" aria-modal="true" aria-labelledby="tkDoneTitle" hidden>
  <div class="tk-backdrop" data-tk-done-close></div>

  <div class="tk-card tk-done-card">
    <div class="tk-done-icon">
      <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12l5 5L20 7"/></svg>
    </div>
    <div class="tk-done-title" id="tkDoneTitle">Berhasil ditambahkan!</div>
    <p class="tk-done-text" id="tkDoneText"></p>

    <div class="tk-done-actions">
      <button type="button" class="tk-btn ghost" data-tk-done-close>Lanjut Belanja</button>
      <a class="tk-btn solid" id="tkDoneCart" href="{{ url('/keranjang') }}">Lihat Keranjang</a>
    </div>
  </div>
</div>

@push('scripts')
@include('partials.cart-script')
<script>
  (function () {
    const DATA = @json($tkData);

    const modal    = document.getElementById('tkModal');
    const form     = document.getElementById('tkForm');
    const bodyEl   = document.getElementById('tkBody');
    const qtyValue = document.getElementById('tkQtyValue');
    const qtyInput = document.getElementById('tkQty');
    const addText  = document.getElementById('tkAddText');

    let current     = null;
    let qty         = 1;
    let lastTrigger = null;
    let hideTimer   = null;

    const rupiah = (n) => 'Rp ' + n.toLocaleString('id-ID');
    const esc = (s) => String(s).replace(/[&<>"']/g, (c) => ({
      '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
    }[c]));

    const CHECK_SVG = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12l5 5L20 7"/></svg>';

    // ---------- isi pop-up sesuai produk ----------
    function renderGroups(p) {
      return (p.options || []).map((g) => {
        const isRadio = g.type === 'radio';
        const hint = g.hint || (isRadio
          ? 'Pilih salah satu opsi favorit Anda.'
          : 'Bisa pilih lebih dari satu untuk rasa lebih mantap.');

        const rows = g.items.map((o, i) => {
          const extra = o.extra || 0;
          const price = extra > 0
            ? '<span class="tk-opt-price">+' + rupiah(extra) + '</span>'
            : '<span class="tk-opt-price free">Gratis</span>';

          return '<label class="tk-row">' +
            '<input type="' + (isRadio ? 'radio' : 'checkbox') + '"' +
              ' name="' + esc(g.name) + '"' +
              ' value="' + esc(o.name) + '"' +
              ' data-extra="' + extra + '"' +
              (isRadio && i === 0 ? ' checked' : '') + '>' +
            '<span class="tk-mark ' + (isRadio ? 'radio' : 'check') + '">' + (isRadio ? '' : CHECK_SVG) + '</span>' +
            '<span class="tk-opt-name">' + esc(o.name) + '</span>' +
            price +
          '</label>';
        }).join('');

        return '<section class="tk-group">' +
          '<div class="tk-group-head">' +
            '<h3>' + esc(g.title) + '</h3>' +
            (isRadio
              ? '<span class="tk-badge">WAJIB (PILIH 1)</span>'
              : '<span class="tk-optional">Opsional</span>') +
          '</div>' +
          '<p class="tk-hint">' + esc(hint) + '</p>' +
          '<div class="tk-options">' + rows + '</div>' +
        '</section>';
      }).join('');
    }

    function syncChecked() {
      bodyEl.querySelectorAll('.tk-row').forEach((row) => {
        row.classList.toggle('is-checked', row.querySelector('input').checked);
      });
    }

    function recalc() {
      let extra = 0;
      form.querySelectorAll('input[data-extra]:checked').forEach((el) => {
        extra += parseInt(el.dataset.extra, 10) || 0;
      });
      qtyValue.textContent = qty;
      qtyInput.value = qty;
      addText.textContent = '+ Masukkan ke Keranjang \u2013 ' + rupiah((current.price + extra) * qty);
    }

    function fill(p) {
      current = p;
      qty = 1;

      document.getElementById('tkSlug').value = p.slug;
      const thumb = document.getElementById('tkThumb');
      thumb.src = p.img;
      thumb.alt = p.name;
      document.getElementById('tkRating').textContent  = p.rating;
      document.getElementById('tkReviews').textContent = '(' + p.reviews + ' ulasan)';
      document.getElementById('tkName').textContent    = p.name;
      document.getElementById('tkPrice').textContent   = rupiah(p.price);

      bodyEl.innerHTML = renderGroups(p);
      bodyEl.scrollTop = 0;
      syncChecked();
      recalc();
    }

    // ---------- buka / tutup ----------
    window.tkOpen = function (slug, trigger) {
      if (!DATA[slug]) return;
      lastTrigger = trigger || null;
      fill(DATA[slug]);

      clearTimeout(hideTimer);
      modal.hidden = false;
      requestAnimationFrame(() => modal.classList.add('is-open'));
      document.documentElement.classList.add('tk-lock');
      form.querySelector('.tk-add').focus({ preventScroll: true });
    };

    function closeModal() {
      modal.classList.remove('is-open');
      document.documentElement.classList.remove('tk-lock');
      hideTimer = setTimeout(() => { modal.hidden = true; }, 220);
      if (lastTrigger) lastTrigger.focus({ preventScroll: true });
    }

    modal.querySelectorAll('[data-tk-close]').forEach((el) => el.addEventListener('click', closeModal));

    // ---------- interaksi ----------
    form.addEventListener('change', () => { syncChecked(); recalc(); });

    // ---------- pop-up "berhasil ditambahkan" ----------
    const done     = document.getElementById('tkDone');
    const doneText = document.getElementById('tkDoneText');
    let doneTimer  = null;

    function openDone(name, n) {
      doneText.innerHTML = n + '\u00d7 <b>' + esc(name) + '</b> sudah masuk ke keranjang.';
      clearTimeout(doneTimer);
      done.hidden = false;
      requestAnimationFrame(() => done.classList.add('is-open'));
      document.documentElement.classList.add('tk-lock');
      document.getElementById('tkDoneCart').focus({ preventScroll: true });
    }

    function closeDone() {
      done.classList.remove('is-open');
      document.documentElement.classList.remove('tk-lock');
      doneTimer = setTimeout(() => { done.hidden = true; }, 220);
      if (lastTrigger) lastTrigger.focus({ preventScroll: true });
    }

    done.querySelectorAll('[data-tk-done-close]').forEach((el) => el.addEventListener('click', closeDone));

    // ---------- kirim ke keranjang ----------
    // Simpan ke TwodaCart (localStorage, dibaca halaman keranjang), tutup pop-up pilihan,
    // lalu tampilkan pop-up konfirmasi. Tidak langsung pindah halaman.
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      if (!current) return;

      const opts = Array.from(form.querySelectorAll('input[data-extra]:checked')).map((el) => ({
        name: el.value,
        extra: parseInt(el.dataset.extra, 10) || 0
      }));

      const name = current.name;
      const n    = qty;
      window.TwodaCart.add(current.slug, n, opts);

      closeModal();
      openDone(name, n);
    });

    document.getElementById('tkMinus').addEventListener('click', () => {
      if (qty > 1) { qty--; recalc(); }
    });
    document.getElementById('tkPlus').addEventListener('click', () => {
      qty++; recalc();
    });

    document.addEventListener('keydown', (e) => {
      const active = !done.hidden ? done : (!modal.hidden ? modal : null);
      if (!active) return;

      if (e.key === 'Escape') { (active === done ? closeDone : closeModal)(); return; }

      // fokus tetap di dalam pop-up saat tekan Tab
      if (e.key === 'Tab') {
        const all = active.querySelectorAll('button:not([disabled]), input:not([disabled]), a[href]');
        const focusables = Array.from(all).filter((el) => el.offsetParent !== null || el === document.activeElement);
        const first = focusables[0];
        const last  = focusables[focusables.length - 1];
        if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
        else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
      }
    });
  })();
</script>
@endpush