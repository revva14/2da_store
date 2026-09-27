@extends('layouts.applogin')

@section('title', '2DA Store — Keranjang Anda')

@push('styles')
<style>
  /* ---------- SUBTOTAL BAR (mengambang, tetap kelihatan saat discroll, center) ---------- */
  .cart-floating-bar{
    position: fixed;
    bottom: 24px;
    left: 31%;
    transform: translateX(-50%);
    z-index: 200;
    width: 500px;
    background: var(--brown-dark);
    color: #fff;
    border-radius: var(--radius-pill);
    padding: 14px 14px 14px 22px;
    display:flex;
    justify-content:center;
    align-items:center;
    gap:200px;
    box-shadow: 0 12px 28px -10px rgba(0,0,0,.35);
    transition: transform .3s ease;
  }
  .cart-floating-bar.hide-on-footer{
    transform: translateX(-100%) translateY(250%);
    pointer-events: none;
  }
  /* Keranjang pendek (footer sudah kelihatan tanpa scroll): bar menempel di bawah daftar item,
     supaya tombol "Lanjut ke Pembayaran" tidak ikut tersembunyi oleh footer */
  .cart-floating-bar.docked{
    position: static;
    transform: none !important;
    pointer-events: auto !important;
    width: 100%;
    max-width: 500px;
    margin: 24px auto 0;
    gap: 24px;
    justify-content: space-between;
  }
  .cart-floating-bar .floating-label{
    font-size:12px;
    opacity:.85;
  }
  .cart-floating-bar .floating-subtotal{
    font-family: var(--font-display);
    font-weight:700;
    font-size:16px;
    white-space:auto;
  }
  .btn-checkout-floating{
    background: #ffff;
    color:var(--brown-dark);
    font-weight:700;
    font-size:13px;
    padding:10px 20px;
    border-radius: var(--radius-pill);
    white-space:auto;
    transition: background .2s ease;
  }
  .btn-checkout-floating:hover{ background: #ffff; }
  .btn-checkout-floating.disabled{
    background:rgba(255,255,255,.25);
    pointer-events:none;
  }

  /* ---------- CART PAGE HEAD ---------- */
  .cart-page-head{ padding: 40px 0 20px; }
  .cart-page-head h1{
    font-family: var(--font-display);
    font-weight:800;
    font-size:24px;
    color: var(--ink);
    margin-bottom:8px;
  }
  .cart-page-head p{
    color: var(--ink-soft);
    font-size:13.5px;
  }

  /* ---------- LAYOUT ---------- */
  /* Hanya ada satu kolom (cart-main) di halaman ini, jadi dibuat 1fr penuh.
     Sebelumnya "2fr 1fr" menyisakan kolom kedua kosong tanpa isi,
     sehingga konten terlihat tidak full/mepet ke kiri saat keranjang kosong. */
  .cart-layout{
    display:grid;
    grid-template-columns: 1fr;
    gap: 20px;
    padding-bottom: 70px;
    align-items:start;
  }

  .cart-main{
    display:flex;
    flex-direction:column;
    gap:14px;
  }

  .cart-select-all{
    display:flex;
    justify-content:space-between;
    align-items:center;
    background: var(--white);
    border-radius: var(--radius-md);
    padding: 12px 16px;
    box-shadow: 0 8px 20px -16px rgba(60,30,10,.2);
  }
  .select-all-label{
    display:flex;
    align-items:center;
    gap:10px;
    font-size:13.5px;
    font-weight:700;
    color: var(--ink);
    cursor:pointer;
  }
  .select-all-label input[type="checkbox"]{
    width:18px; height:18px;
    accent-color: var(--orange);
    cursor:pointer;
  }
  .select-all-count{
    font-size:12px;
    color: var(--ink-soft);
  }

  .cart-items{
    display:flex;
    flex-direction:column;
    gap: 14px;
  }

  /* ---------- CART ITEM ---------- */
  .cart-item{
    background: var(--white);
    border-radius: var(--radius-md);
    padding: 14px;
    display:flex;
    align-items:flex-start;
    gap: 14px;
    width: 100%;
    box-shadow: 0 8px 20px -16px rgba(60,30,10,.2);
    transition: transform .18s ease, box-shadow .18s ease, opacity .2s ease;
  }
  .cart-item:hover{
    transform: translateY(-3px);
    box-shadow: 0 12px 24px -14px rgba(60,30,10,.3);
  }
  .cart-item.unavailable{
    opacity:.6;
  }
  .cart-item.unavailable:hover{
    transform:none;
    box-shadow: 0 8px 20px -16px rgba(60,30,10,.2);
  }

  .cart-item-checkbox{
    width:18px; height:18px;
    margin-top:2px;
    accent-color: var(--orange);
    flex:none;
    cursor:pointer;
  }
  .cart-item-checkbox:disabled{ cursor:not-allowed; }

  .cart-item-media{
    width: 72px;
    height: 72px;
    border-radius: 12px;
    overflow:hidden;
    flex:none;
    background:#eee;
  }
  .cart-item-media img{ width:100%; height:100%; object-fit:cover; }

  .cart-item-body{
    flex:1;
    display:flex;
    flex-direction:column;
  }

  .cart-item-top{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:10px;
  }
  .cart-item-name-row{
    display:flex;
    align-items:center;
    gap:8px;
    flex-wrap:wrap;
  }
  .cart-item-top h3{
    font-family: var(--font-display);
    font-weight:700;
    font-size:14.5px;
    color: var(--ink);
  }
  .cart-item-price{
    font-family: var(--font-display);
    font-weight:700;
    font-size:13.5px;
    color: var(--orange-dark);
    white-space:nowrap;
  }
  .tag-oos{
    background:#f1e2da;
    color:#a3392a;
    font-size:9.5px;
    font-weight:700;
    letter-spacing:.03em;
    text-transform:uppercase;
    padding:3px 8px;
    border-radius: var(--radius-pill);
  }

  .cart-item-desc{
    font-size:12px;
    color: var(--ink-soft);
    margin-top:2px;
  }

  .cart-item-bottom{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-top:auto;
    padding-top:10px;
  }

  .qty-stepper{
    display:flex;
    align-items:center;
    background: var(--cream-soft);
    border-radius: var(--radius-pill);
    padding: 3px;
  }
  .qty-stepper button{
    width:26px; height:26px;
    border-radius:50%;
    background: transparent;
    font-size:13px;
    font-weight:600;
    color: var(--ink);
    display:flex; align-items:center; justify-content:center;
    transition: background .2s ease;
  }
  .qty-stepper button:hover{ background: #fff; }
  .qty-stepper button:disabled{
    opacity:.35;
    cursor:not-allowed;
    background: transparent;
  }
  .qty-stepper .qty-value{
    width:24px;
    text-align:center;
    font-weight:700;
    font-size:12.5px;
  }

  .remove-link{
    color:#c0432f;
    font-size:12px;
    font-weight:600;
    text-decoration:underline;
  }
  .remove-link:hover{ color:#a3392a; }

  .btn-checkout{
    display:block;
    width:100%;
    background: var(--orange);
    color:#fff;
    font-weight:700;
    font-size:13.5px;
    padding:13px;
    text-align:center;
    border-radius: var(--radius-pill);
    box-shadow: 0 12px 24px -10px rgba(217,123,41,.6);
    transition: background .2s ease, transform .1s ease;
  }
  .btn-checkout:hover{ background: var(--orange-dark); }
  .btn-checkout:active{ transform: scale(0.98); }
  .btn-checkout.disabled{
    background:#d8c7b6;
    box-shadow:none;
    pointer-events:none;
  }

  .empty-cart{
    text-align:center;
    padding: 40px 20px;
    color: var(--ink-soft);
    font-size:13.5px;
    display:none;
    background: var(--white);
    border-radius: var(--radius-md);
  }
  .empty-cart.show{ display:block; }
  .empty-cart-cta{
    display:inline-block;
    margin-top:14px;
    background: var(--orange);
    color:#fff;
    font-weight:700;
    font-size:13px;
    padding:10px 22px;
    border-radius: var(--radius-pill);
    transition: background .2s ease;
  }
  .empty-cart-cta:hover{ background: var(--orange-dark); }

  /* ---------- RESPONSIVE (khusus halaman ini) ---------- */
  @media (max-width: 900px){
    .cart-layout{ grid-template-columns: 1fr; }
  }
  @media (max-width: 560px){
    .cart-item{ flex-direction:column; }
    .cart-item-media{ width:100%; height:130px; }
    .cart-page-head h1{ font-size:20px; }
  }
</style>
@endpush

@section('content')

  <div class="container">

    <div class="cart-page-head reveal">
      <h1>Keranjang Anda</h1>
      <p>Tinjau kembali barang pilihan Anda sebelum melanjutkan pembayaran.</p>
    </div>

    <div class="cart-layout">

      <div class="cart-main">

        <div class="cart-select-all reveal">
          <label class="select-all-label">
            <input type="checkbox" id="selectAllCheckbox" checked>
            <span>Pilih Semua Produk</span>
          </label>
          <span class="select-all-count" id="selectedCount">0 dipilih</span>
        </div>

        <div class="cart-items" id="cartItems">

          <div class="empty-cart" id="emptyCart">
            <p>Keranjang kamu masih kosong.</p>
            <a href="/menulogin" class="empty-cart-cta">Belanja Sekarang</a>
          </div>

        </div>

        <div class="cart-floating-bar reveal" id="cartFloatingBar">
          <div>
            <div class="floating-label">Subtotal</div>
            <div class="floating-subtotal" id="floatingSubtotal">Rp 0</div>
          </div>
          <a href="/pesanan" class="btn-checkout-floating" id="floatingCheckoutBtn">Lanjut ke Pembayaran</a>
        </div>

      </div>
    </div>

  </div>

@endsection

@push('scripts')
@include('partials.cart-script')
<script>
  function formatRupiah(n){
    return n.toLocaleString('id-ID');
  }
  function escHtml(s){
    return String(s).replace(/[&<>"']/g, function (c) {
      return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c];
    });
  }

  const cartItems = document.getElementById('cartItems');
  const emptyCart = document.getElementById('emptyCart');
  const selectAllCheckbox = document.getElementById('selectAllCheckbox');
  const selectedCount = document.getElementById('selectedCount');
  const floatingSubtotal = document.getElementById('floatingSubtotal');
  const floatingCheckoutBtn = document.getElementById('floatingCheckoutBtn');
  const cartFloatingBar = document.getElementById('cartFloatingBar');
  const shipping = 0;

  // Isi keranjang dibaca dari TwodaCart (localStorage), bukan lagi ditulis manual di HTML
  function renderCart(){
    TwodaCart.items().forEach(function (it) {
      const p = PRODUCTS[it.id];
      if (!p) return; // produk tidak dikenal, lewati
      const el = document.createElement('div');
      el.className = 'cart-item reveal';
      const unit = p.price + (it.extra || 0);
      const optText = (it.opts || []).map(function (o) { return escHtml(o.name); }).join(', ');
      el.dataset.id = it.key;
      el.dataset.price = unit;
      el.dataset.qty = it.qty;
      el.dataset.available = 'true';
      el.innerHTML = `
        <input type="checkbox" class="cart-item-checkbox" checked>
        <div class="cart-item-media">
          <img src="${p.image}" alt="${p.name}">
        </div>
        <div class="cart-item-body">
          <div class="cart-item-top">
            <h3>${p.name}</h3>
            <span class="cart-item-price">Rp ${formatRupiah(unit * it.qty)}</span>
          </div>
          <p class="cart-item-desc">${p.short}${optText ? (p.short ? ' \u2022 ' : '') + optText : ''}</p>
          <div class="cart-item-bottom">
            <div class="qty-stepper">
              <button type="button" class="qty-minus">−</button>
              <span class="qty-value">${it.qty}</span>
              <button type="button" class="qty-plus">+</button>
            </div>
            <a href="#" class="remove-link">Hapus</a>
          </div>
        </div>`;
      cartItems.insertBefore(el, emptyCart);
      if (window.observeReveal) window.observeReveal(el);
    });
  }
  renderCart();

  // Bar subtotal melayang di bawah layar; kalau seluruh isi halaman (termasuk andai bar ikut
  // ditempel di alur) sudah muat dalam satu layar tanpa scroll, bar ditempel (docked) di bawah
  // daftar item. Kalau halaman lebih panjang dari itu, bar mengambang mengikuti scroll dan baru
  // disembunyikan saat sudah benar-benar discroll ke ujung bawah halaman.
  //
  // Dipakai tinggi total dokumen (document.documentElement.scrollHeight) vs tinggi layar --
  // bukan posisi elemen <footer> -- supaya cuma ada SATU ukuran acuan. Versi sebelumnya
  // membandingkan posisi footer dengan dua cara berbeda untuk menentukan "docked" dan
  // "hide-on-footer", sehingga ada celah: halaman yang nyaris pas satu layar (mis. keranjang
  // isi 2 produk) dianggap "tidak cukup pendek untuk docked" padahal footer-nya sudah kelihatan
  // dikit di bawah, akibatnya bar disembunyikan tapi tidak pernah ditempel balik -> bar hilang
  // total. Dengan satu formula, kasus ini tidak mungkin terjadi lagi.
  function layoutBar(){
    if (!cartFloatingBar) return;

    const wasDocked = cartFloatingBar.classList.contains('docked');
    const barSpace = cartFloatingBar.offsetHeight + 24; // tinggi bar + margin atasnya saat docked
    // Tinggi total halaman TANPA kontribusi bar (karena saat docked, bar ikut menambah scrollHeight)
    const contentHeight = wasDocked
      ? document.documentElement.scrollHeight - barSpace
      : document.documentElement.scrollHeight;

    const fits = (contentHeight + barSpace) <= window.innerHeight;
    cartFloatingBar.classList.toggle('docked', fits);

    if (fits) {
      cartFloatingBar.classList.remove('hide-on-footer');
    } else {
      // Halaman lebih panjang dari satu layar: sembunyikan hanya saat sudah discroll
      // sampai benar-benar ke ujung bawah halaman (bukan sekadar footer mulai muncul).
      const scrolledToBottom = (window.scrollY + window.innerHeight) >= (document.documentElement.scrollHeight - 4);
      cartFloatingBar.classList.toggle('hide-on-footer', scrolledToBottom);
    }
  }

  window.addEventListener('scroll', layoutBar, { passive: true });
  window.addEventListener('resize', layoutBar);
  window.addEventListener('load', layoutBar);

  function getAvailableItems(){
    return Array.from(cartItems.querySelectorAll('.cart-item')).filter(i => i.dataset.available === 'true');
  }

  function recalculate(){
    const allItems = cartItems.querySelectorAll('.cart-item');
    const availableItems = getAvailableItems();
    let subtotal = 0;
    let selected = 0;

    allItems.forEach(item => {
      const price = parseInt(item.dataset.price, 10);
      const qty = parseInt(item.querySelector('.qty-value').textContent, 10);
      item.dataset.qty = qty;
      item.querySelector('.cart-item-price').textContent = 'Rp ' + formatRupiah(price * qty);

      const isAvailable = item.dataset.available === 'true';
      if (isAvailable) {
        item.querySelector('.qty-minus').disabled = qty <= 1;

        const checkbox = item.querySelector('.cart-item-checkbox');
        if (checkbox.checked) {
          subtotal += price * qty;
          selected++;
        }
      }
    });

    floatingSubtotal.textContent = 'Rp ' + formatRupiah(subtotal);
    selectedCount.textContent = selected + ' dipilih';

    selectAllCheckbox.checked = availableItems.length > 0 && selected === availableItems.length;
    floatingCheckoutBtn.classList.toggle('disabled', selected === 0);

    const isEmpty = allItems.length === 0;
    emptyCart.classList.toggle('show', isEmpty);
    layoutBar();
  }

  selectAllCheckbox.addEventListener('change', () => {
    getAvailableItems().forEach(item => {
      item.querySelector('.cart-item-checkbox').checked = selectAllCheckbox.checked;
    });
    recalculate();
  });

  cartItems.addEventListener('change', (e) => {
    if (e.target.classList.contains('cart-item-checkbox')) {
      recalculate();
    }
  });

  cartItems.addEventListener('click', (e) => {
    const item = e.target.closest('.cart-item');
    if (!item) return;

    if (e.target.classList.contains('qty-plus')) {
      const qtyEl = item.querySelector('.qty-value');
      qtyEl.textContent = parseInt(qtyEl.textContent, 10) + 1;
      TwodaCart.setQty(item.dataset.id, parseInt(qtyEl.textContent, 10));
      recalculate();
    }

    if (e.target.classList.contains('qty-minus')) {
      const qtyEl = item.querySelector('.qty-value');
      const current = parseInt(qtyEl.textContent, 10);
      if (current > 1) {
        qtyEl.textContent = current - 1;
        TwodaCart.setQty(item.dataset.id, current - 1);
        recalculate();
      }
    }

    if (e.target.classList.contains('remove-link')) {
      e.preventDefault();
      TwodaCart.remove(item.dataset.id);
      item.remove();
      recalculate();
    }
  });

  recalculate();

  // Simpan item yang dicentang, lalu lanjut ke halaman pesanan
  floatingCheckoutBtn.addEventListener('click', function () {
    const ids = Array.from(cartItems.querySelectorAll('.cart-item'))
      .filter(function (i) { return i.querySelector('.cart-item-checkbox').checked && i.dataset.available === 'true'; })
      .map(function (i) { return i.dataset.id; });
    TwodaCart.setCheckout(ids);
  });
</script>
@endpush