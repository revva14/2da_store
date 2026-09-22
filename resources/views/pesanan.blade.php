@extends('layouts.applogin')

@section('title', '2DA Store — Formulir Pemesanan')

@push('styles')
<style>
  .chip{
    display:inline-flex;
    align-items:center;
    font-size:10.5px;
    font-weight:700;
    letter-spacing:.04em;
    text-transform:uppercase;
    padding:5px 12px;
    border-radius: var(--radius-pill);
  }
  .chip-count{ background: var(--peach); color: var(--orange-dark); }
  .req{ color:#c0432f; }

  /* ---------- LAYOUT ---------- */
  .checkout-layout{
    display:grid;
    grid-template-columns: 2fr 1fr;
    gap: 28px;
    padding-top: 36px;
    padding-bottom: 100px;
    align-items:start;
  }

  /* ---------- BANNER ---------- */
  .checkout-banner{
    background: var(--peach);
    border-radius: 10px;
    padding: 26px 30px;
    margin-bottom: 22px;
  }
  .checkout-banner h1{
    font-family: var(--font-display);
    font-weight:800;
    font-size:24px;
    color: var(--ink);
    margin-bottom:8px;
  }
  .checkout-banner p{
    font-size:13.5px;
    color: var(--ink-soft);
  }

  /* ---------- SECTION CARD ---------- */
  .checkout-section{
    background: var(--white);
    border-radius: 10px;
    padding: 26px 30px;
    margin-bottom: 18px;
    box-shadow: 0 8px 20px -18px rgba(60,30,10,.25);
  }
  .checkout-section h2{
    font-family: var(--font-display);
    font-weight:700;
    font-size:17px;
    color: var(--ink);
  }
  .section-head{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:18px;
  }
  .section-head h2{ margin-bottom:0; }
  .section-note{
    font-size:11px;
    font-weight:700;
    letter-spacing:.04em;
    text-transform:uppercase;
    color: var(--ink-soft);
  }
  .section-sub{
    font-size:13px;
    color: var(--ink-soft);
    margin: -10px 0 14px;
  }

  /* ---------- FIELDS ---------- */
  .form-row{
    display:grid;
    grid-template-columns: 1fr 1fr;
    gap:16px;
    margin-bottom:16px;
  }
  .field-block{ margin-bottom:16px; }
  .field-block:last-child{ margin-bottom:0; }
  .field-label{
    display:block;
    font-size:11.5px;
    font-weight:700;
    letter-spacing:.03em;
    text-transform:uppercase;
    color: var(--ink-soft);
    margin-bottom:8px;
  }
  .checkout-section input[type="text"],
  .checkout-section textarea{
    width:100%;
    background: var(--cream-soft);
    border:1px solid rgba(0,0,0,.06);
    border-radius: 10px;
    padding:13px 16px;
    font-size:14px;
    font-family:inherit;
    color: var(--ink);
  }
  .checkout-section textarea{ resize:vertical; }
  .checkout-section input:focus,
  .checkout-section textarea:focus{
    outline:2px solid var(--orange);
    outline-offset:1px;
  }

  .phone-input{ display:flex; }
  .phone-prefix{
    background: var(--peach);
    color: var(--brown-dark);
    font-weight:600;
    font-size:14px;
    padding:13px 14px;
    border-radius: 10px;
    display:flex; align-items:center;
    flex:none;
  }
  .phone-input input{
    border-radius: 0 10px 10px 0 !important;
    flex:1;
  }

  /* ---------- SHIPPING ---------- */
  .shipping-options{
    display:grid;
    grid-template-columns: repeat(3, 1fr);
    gap:16px;
  }
  .ship-card{
    display:block;
    background: var(--cream-soft);
    border: 2px solid transparent;
    border-radius: 10px;
    padding:16px;
    cursor:pointer;
    transition: border-color .2s ease, background .2s ease;
  }
  .ship-card.active{ background: var(--white); border-color: var(--orange); }
  .ship-label-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:8px;
  }
  .ship-label{
    font-size:11px;
    font-weight:700;
    letter-spacing:.03em;
    text-transform:uppercase;
    color: var(--ink-soft);
  }
  .ship-desc{
    font-size:13px;
    color: var(--ink-soft);
    margin-bottom:14px;
  }
  .ship-bottom{
    display:flex;
    justify-content:space-between;
    align-items:center;
  }
  .ship-price{
    font-family: var(--font-display);
    font-weight:800;
    font-size:18px;
    color: var(--ink);
  }
  .ship-card input[type="radio"]{
    width:18px; height:18px;
    accent-color: var(--orange);
  }

  .tag{
    display:inline-flex;
    align-items:center;
    font-size:9.5px;
    font-weight:700;
    letter-spacing:.03em;
    text-transform:uppercase;
    padding:4px 9px;
    border-radius: var(--radius-pill);
  }
  .tag-tercepat{ background: var(--brown-dark); color:#fff; }
  .tag-hemat{ background: var(--peach); color: var(--orange-dark); }
  .tag-gratis{ background:#e3f3d9; color:#3e7d3f; }
  .tag-instan{ background:#2f6b3a; color:#fff; }
  .tag-terlaris{ background: var(--orange); color:#fff; }

  /* ---------- PAYMENT ---------- */
  .payment-options{ display:flex; flex-direction:column; gap:12px; }
  .pay-row{
    display:flex;
    align-items:center;
    gap:14px;
    background: var(--cream-soft);
    border: 2px solid transparent;
    border-radius: 10px;
    padding:16px;
    cursor:pointer;
    transition: border-color .2s ease, background .2s ease;
  }
  .pay-row.active{ background: var(--white); border-color: var(--orange); }
  .pay-row input[type="radio"]{
    width:18px; height:18px;
    accent-color: var(--orange);
    flex:none;
  }
  .pay-body{ flex:1; }
  .pay-top{
    display:flex;
    align-items:center;
    gap:10px;
    margin-bottom:4px;
  }
  .pay-name{ font-weight:700; font-size:14px; color: var(--ink); }
  .pay-desc{ font-size:12.5px; color: var(--ink-soft); }
  .pay-badge{
    flex:none;
    background: var(--cream-soft);
    border:1px solid rgba(0,0,0,.08);
    padding:6px 12px;
    border-radius: var(--radius-pill);
    font-size:11px;
    font-weight:700;
    color: var(--ink-soft);
  }
  .pay-row.active .pay-badge{ background: var(--peach); color: var(--orange-dark); border-color:transparent; }

  .upload-proof{
    display:none;
    margin-top:16px;
    padding-top:16px;
    border-top:1px solid rgba(0,0,0,.08);
  }
  .upload-proof.show{ display:block; }
  .upload-proof .upload-hint{
    font-size:12px;
    color: var(--ink-soft);
    margin:-2px 0 10px;
  }
  .upload-proof input[type="file"]{
    width:100%;
    background: var(--cream-soft);
    border:1px dashed rgba(0,0,0,.15);
    border-radius: 10px;
    padding:14px 16px;
    font-size:13px;
    font-family:inherit;
    color: var(--ink-soft);
  }
  .upload-dropzone{
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    gap:8px;
    text-align:center;
    background: var(--cream-soft);
    border:1.5px dashed rgba(0,0,0,.18);
    border-radius: 10px;
    padding:32px 16px;
    cursor:pointer;
    transition: border-color .2s ease, background .2s ease;
  }
  .upload-dropzone:hover{ border-color: var(--orange); background: var(--white); }
  .upload-dropzone.has-file{ border-style:solid; border-color: var(--orange); background: var(--white); }
  .upload-icon{
    width:40px; height:40px;
    border-radius:50%;
    background: var(--peach);
    color: var(--orange-dark);
    font-size:18px;
    display:flex; align-items:center; justify-content:center;
  }
  .upload-text{
    font-size:13px;
    font-weight:600;
    color: var(--ink-soft);
  }
  .upload-dropzone.has-file .upload-text{ color: var(--ink); }

  /* ---------- SUMMARY ---------- */
  .checkout-summary{
    background: var(--white);
    border-radius: 10px;
    padding: 26px;
    box-shadow: 0 10px 24px -18px rgba(60,30,10,.3);
  }
  .summary-head{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:18px;
  }
  .summary-head h2{
    font-family: var(--font-display);
    font-weight:700;
    font-size:17px;
    color: var(--ink);
  }

  .summary-items{
    display:flex;
    flex-direction:column;
    gap:14px;
    padding-bottom:18px;
    margin-bottom:16px;
    border-bottom:1px solid rgba(0,0,0,.08);
  }
  .summary-item{ display:flex; gap:12px; }
  .summary-item-media{
    width:52px; height:52px;
    border-radius:10px;
    overflow:hidden;
    flex:none;
    background:#eee;
  }
  .summary-item-media img{ width:100%; height:100%; object-fit:cover; }
  .summary-item-body{ flex:1; }
  .summary-item-top{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:8px;
  }
  .summary-item-name{ font-weight:700; font-size:13px; color: var(--ink); }
  .summary-item-price{ font-weight:700; font-size:13px; color: var(--ink); white-space:nowrap; }
  .summary-item-meta{
    display:flex;
    align-items:center;
    gap:8px;
    font-size:11.5px;
    color: var(--ink-soft);
    margin-top:4px;
  }
  .summary-item-note{
    font-size:11px;
    color: var(--ink-soft);
    margin-top:2px;
  }

  .summary-totals{ margin-bottom:16px; }
  .total-row{
    display:flex;
    justify-content:space-between;
    font-size:13px;
    color: var(--ink-soft);
    margin-bottom:10px;
  }

  .summary-divider{
    border:none;
    border-top:1px solid rgba(0,0,0,.08);
    margin: 4px 0 16px;
  }

  .grand-total{
    display:flex;
    justify-content:space-between;
    align-items:flex-end;
    margin-bottom:18px;
  }
  .grand-total-label{
    font-size:11px;
    font-weight:700;
    letter-spacing:.03em;
    text-transform:uppercase;
    color: var(--ink-soft);
  }
  .grand-total-sub{ font-size:11px; color: var(--ink-soft); margin-top:2px; }
  .grand-total-value{
    font-family: var(--font-display);
    font-weight:800;
    font-size:26px;
    color: var(--orange-dark);
  }

  .btn-confirm{
    display:block;
    width:100%;
    background: var(--orange);
    color:#fff;
    font-weight:700;
    font-size:14.5px;
    padding:16px;
    text-align:center;
    border-radius: var(--radius-pill);
    box-shadow: 0 12px 24px -10px rgba(217,123,41,.6);
    transition: background .2s ease, transform .1s ease;
  }
  .btn-confirm:hover{ background: var(--orange-dark); }
  .btn-confirm:active{ transform: scale(0.98); }

  .confirm-note{
    text-align:center;
    font-size:11px;
    color: var(--ink-soft);
    background: var(--cream-soft);
    padding:10px;
    border-radius: var(--radius-md);
    margin-top:12px;
  }

  /* ---------- RESPONSIVE (khusus halaman ini) ---------- */
  @media (max-width: 980px){
    .checkout-layout{ grid-template-columns: 1fr; }
    .form-row{ grid-template-columns: 1fr; }
    .shipping-options{ grid-template-columns: 1fr; }
  }
</style>
@endpush

@section('content')

  <div class="container checkout-layout">

    <div class="checkout-main">

      <div class="checkout-banner reveal">
        <h1>Formulir Pemesanan</h1>
        <p>Lengkapi alamat dan instruksi pengiriman agar pesanan kamu tiba hangat dan higienis.</p>
      </div>

      <form id="checkoutForm">

        <section class="checkout-section reveal">
          <div class="section-head">
            <h2>1. Data Penerima</h2>
          </div>

          <div class="form-row">
            <div class="field-block">
              <label class="field-label">Nama Lengkap Pemesan <span class="req">*</span></label>
              <input type="text" id="namaPenerima" value="Siti Zulaikha">
            </div>
            <div class="field-block">
              <label class="field-label">Nomor WhatsApp Aktif <span class="req">*</span></label>
              <div class="phone-input">
                <span class="phone-prefix">+62</span>
                <input type="text" id="waPenerima" value="81298765432">
              </div>
            </div>
          </div>

          <div class="field-block">
            <label class="field-label">Alamat Lengkap Pengantaran <span class="req">*</span></label>
            <textarea rows="3" id="alamatPenerima">Jl. Tanimbar No. 13 Kelurahan Kasin Kecamatan Klojen kota Malang</textarea>
          </div>

          <div class="field-block">
            <label class="field-label">Catatan Driver &amp; Titik Temu</label>
            <input type="text" id="catatanDriver" value="Pagar hitam motif kayu, tekan bel kanan. Titip pos satpam jika sedang keluar.">
          </div>
        </section>

        <section class="checkout-section reveal">
          <h2 style="margin-bottom:18px;">2. Opsi Pengiriman</h2>

          <div class="shipping-options" id="shippingOptions">
            <label class="ship-card active" data-cost="10000">
              <div class="ship-label-row">
                <span class="ship-label">Instant Kurir</span>
                <span class="tag tag-tercepat">Tercepat</span>
              </div>
              <p class="ship-desc">20 – 35 menit tiba</p>
              <div class="ship-bottom">
                <span class="ship-price">Rp 10.000</span>
                <input type="radio" name="shipping" checked>
              </div>
            </label>

            <label class="ship-card" data-cost="5000">
              <div class="ship-label-row">
                <span class="ship-label">Sameday</span>
                <span class="tag tag-hemat">Hemat</span>
              </div>
              <p class="ship-desc">1 – 2 jam estimasi</p>
              <div class="ship-bottom">
                <span class="ship-price">Rp 5.000</span>
                <input type="radio" name="shipping">
              </div>
            </label>

            <label class="ship-card" data-cost="0">
              <div class="ship-label-row">
                <span class="ship-label">Pick Up</span>
                <span class="tag tag-gratis">Gratis</span>
              </div>
              <p class="ship-desc">Outlet 2DA Store</p>
              <div class="ship-bottom">
                <span class="ship-price">Rp 0</span>
                <input type="radio" name="shipping">
              </div>
            </label>
          </div>
        </section>

        <section class="checkout-section reveal">
          <div class="section-head">
            <h2>3. Catatan Khusus Dapur</h2>
            <span class="section-note">Opsional</span>
          </div>
          <p class="section-sub">Punya preferensi bumbu atau tingkat kematangan? Chef kami akan menyesuaikannya.</p>
          <div class="field-block">
            <textarea rows="2" id="catatanDapur" placeholder="Opsional"></textarea>
          </div>
        </section>

        <section class="checkout-section reveal">
          <div class="section-head">
            <h2>4. Metode Pembayaran</h2>
          </div>

          <div class="payment-options" id="paymentOptions">
            <label class="pay-row active" data-method="qris">
              <input type="radio" name="payment" checked>
              <div class="pay-body">
                <div class="pay-top">
                  <span class="pay-name">QRIS Real-Time</span>
                  <span class="tag tag-instan">Instan</span>
                </div>
                <p class="pay-desc">BCA, GoPay, OVO, ShopeePay, DANA &amp; semua e-wallet</p>
              </div>
              <span class="pay-badge">QRIS</span>
            </label>

            <label class="pay-row" data-method="va">
              <input type="radio" name="payment">
              <div class="pay-body">
                <div class="pay-top">
                  <span class="pay-name">Virtual Account Bank</span>
                </div>
                <p class="pay-desc">BCA, Mandiri, BNI, BRI (Otomatis dicek tanpa bukti transfer)</p>
              </div>
              <span class="pay-badge">VA</span>
            </label>

            <label class="pay-row" data-method="cod">
              <input type="radio" name="payment">
              <div class="pay-body">
                <div class="pay-top">
                  <span class="pay-name">Bayar di Tempat (COD)</span>
                </div>
                <p class="pay-desc">Serahkan uang pas ke kurir 2DA Store saat tiba</p>
              </div>
              <span class="pay-badge">CASH</span>
            </label>
          </div>

          <div class="upload-proof show" id="uploadProof">
            <label class="field-label">Upload Bukti Pembayaran <span class="req">*</span></label>
            <p class="upload-hint">Screenshot bukti bayar QRIS/transfer, format JPG/PNG, maks 5MB.</p>
            <label class="upload-dropzone" for="proofFile" id="uploadDropzone">
              <span class="upload-icon">⬆</span>
              <span class="upload-text" id="uploadFileName">Klik untuk pilih file, atau seret ke sini</span>
              <input type="file" accept="image/*" id="proofFile" hidden>
            </label>
          </div>
        </section>

      </form>
    </div>

    <aside class="checkout-summary reveal">
      <div class="summary-head">
        <h2>Ringkasan Pesanan</h2>
        <span class="chip chip-count" id="itemCount">0 Item</span>
      </div>

      <div class="summary-items" id="summaryItems"></div>

      <div class="summary-totals">
        <div class="total-row">
          <span>Subtotal Item</span>
          <span id="subtotalItem">Rp 0</span>
        </div>
        <div class="total-row">
          <span>Ongkos Kirim (3.2 km)</span>
          <span id="shippingCostLabel">Rp 10.000</span>
        </div>
      </div>

      <hr class="summary-divider">

      <div class="grand-total">
        <div>
          <div class="grand-total-label">Total Pembayaran</div>
          <div class="grand-total-sub">Termasuk pajak &amp; kemasan</div>
        </div>
        <div class="grand-total-value" id="grandTotal">Rp 0</div>
      </div>

      <button type="submit" form="checkoutForm" class="btn-confirm">Konfirmasi &amp; Pesan Sekarang →</button>
      <p class="confirm-note">Pesanan diproses langsung dari dapur higienis 2DA Store</p>
    </aside>

  </div>

@endsection

@push('scripts')
@include('partials.cart-script')
<script>
  // Item pesanan = item yang dicentang di halaman keranjang (dibaca dari TwodaCart)
  const orderItems = TwodaCart.checkoutItems();
  const SUBTOTAL = orderItems.reduce(function (sum, i) { return sum + PRODUCTS[i.id].price * i.qty; }, 0);

  const shippingOptions = document.querySelectorAll('.ship-card');
  const paymentOptions = document.querySelectorAll('.pay-row');
  const shippingCostLabel = document.getElementById('shippingCostLabel');
  const grandTotal = document.getElementById('grandTotal');

  let currentShippingCost = 10000;

  function formatRupiah(n){
    return 'Rp ' + n.toLocaleString('id-ID');
  }

  function recalcTotal(){
    shippingCostLabel.textContent = formatRupiah(currentShippingCost);
    const total = SUBTOTAL + currentShippingCost;
    grandTotal.textContent = formatRupiah(total);
  }

  shippingOptions.forEach(card => {
    card.addEventListener('click', () => {
      shippingOptions.forEach(c => {
        c.classList.remove('active');
        c.querySelector('input[type="radio"]').checked = false;
      });
      card.classList.add('active');
      card.querySelector('input[type="radio"]').checked = true;
      currentShippingCost = parseInt(card.dataset.cost, 10);
      recalcTotal();
    });
  });

  const uploadProof = document.getElementById('uploadProof');

  function toggleUploadProof(method){
    uploadProof.classList.toggle('show', method === 'qris' || method === 'va');
  }

  paymentOptions.forEach(row => {
    row.addEventListener('click', () => {
      paymentOptions.forEach(r => {
        r.classList.remove('active');
        r.querySelector('input[type="radio"]').checked = false;
      });
      row.classList.add('active');
      row.querySelector('input[type="radio"]').checked = true;
      toggleUploadProof(row.dataset.method);
    });
  });

  toggleUploadProof('qris');

  // Update tampilan dropzone saat file dipilih
  const proofFile = document.getElementById('proofFile');
  const uploadDropzone = document.getElementById('uploadDropzone');
  const uploadFileName = document.getElementById('uploadFileName');
  proofFile.addEventListener('change', () => {
    if (proofFile.files.length > 0) {
      uploadFileName.textContent = proofFile.files[0].name;
      uploadDropzone.classList.add('has-file');
    } else {
      uploadFileName.textContent = 'Klik untuk pilih file, atau seret ke sini';
      uploadDropzone.classList.remove('has-file');
    }
  });

  // ---------- Ringkasan pesanan ----------
  const summaryItems = document.getElementById('summaryItems');
  document.getElementById('itemCount').textContent = orderItems.length + ' Item';
  document.getElementById('subtotalItem').textContent = formatRupiah(SUBTOTAL);

  if (orderItems.length === 0) {
    summaryItems.innerHTML = '<p class="summary-item-note">Belum ada produk di pesanan ini. <a href="/keranjang">Kembali ke keranjang</a></p>';
  } else {
    summaryItems.innerHTML = orderItems.map(function (i) {
      const p = PRODUCTS[i.id];
      return `
        <div class="summary-item">
          <div class="summary-item-media"><img src="${p.image}" alt="${p.name}"></div>
          <div class="summary-item-body">
            <div class="summary-item-top">
              <span class="summary-item-name">${p.name}</span>
              <span class="summary-item-price">${formatRupiah(p.price * i.qty)}</span>
            </div>
            <div class="summary-item-meta">
              ${p.label ? `<span class="tag tag-terlaris">${p.label}</span>` : ''}
              <span>${i.qty}x @ ${formatRupiah(p.price)}</span>
            </div>
          </div>
        </div>`;
    }).join('');
  }

  // ---------- Konfirmasi pesanan ----------
  document.getElementById('checkoutForm').addEventListener('submit', (e) => {
    e.preventDefault();

    if (orderItems.length === 0) {
      alert('Belum ada produk yang dipesan. Pilih menu dulu ya.');
      window.location.href = '/menulogin';
      return;
    }

    const nama = document.getElementById('namaPenerima').value.trim();
    const wa = document.getElementById('waPenerima').value.trim();
    const alamat = document.getElementById('alamatPenerima').value.trim();
    if (!nama || !wa || !alamat) {
      alert('Mohon lengkapi nama, nomor WhatsApp, dan alamat pengantaran.');
      return;
    }

    const activePay = document.querySelector('.pay-row.active');
    const method = activePay ? activePay.dataset.method : 'qris';
    if (method === 'qris' && proofFile.files.length === 0) {
      alert('Upload bukti pembayaran QRIS dulu ya.');
      return;
    }

    const activeShip = document.querySelector('.ship-card.active .ship-label');
    const now = new Date();
    TwodaOrders.add({
      id: '2DA-' + String(now.getTime()).slice(-5),
      createdAt: now.toISOString(),
      name: nama,
      phone: '+62' + wa.replace(/^0+/, ''),
      address: alamat,
      driverNote: document.getElementById('catatanDriver').value.trim(),
      kitchenNote: document.getElementById('catatanDapur').value.trim(),
      shippingLabel: activeShip ? activeShip.textContent.trim() : '',
      shippingCost: currentShippingCost,
      payment: method,
      proofName: proofFile.files.length ? proofFile.files[0].name : '',
      items: orderItems.map(function (i) { return { id: i.id, qty: i.qty }; }),
      subtotal: SUBTOTAL,
      total: SUBTOTAL + currentShippingCost
    });

    // item yang sudah dipesan keluar dari keranjang
    TwodaCart.removeMany(orderItems.map(function (i) { return i.id; }));
    TwodaCart.clearCheckout();

    alert('Pesanan kamu sedang diproses. Terima kasih sudah belanja di 2DA Store!');
    window.location.href = '/riwayat';
  });

  recalcTotal();
</script>
@endpush