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
    display:flex;
    align-items:center;
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

  .ship-card.active{
    background: var(--white);
    border-color: var(--orange);
  }

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
    width:18px;
    height:18px;
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
  .payment-options{
    display:flex;
    flex-direction:column;
    gap:12px;
  }

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

  .pay-row.active{
    background: var(--white);
    border-color: var(--orange);
  }

  .pay-row input[type="radio"]{
    width:18px;
    height:18px;
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

  .pay-name{
    font-weight:700;
    font-size:14px;
    color: var(--ink);
  }

  .pay-desc{
    font-size:12.5px;
    color: var(--ink-soft);
  }

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

  .pay-row.active .pay-badge{
    background: var(--peach);
    color: var(--orange-dark);
    border-color:transparent;
  }

  .upload-proof{
    display:none;
    margin-top:16px;
    padding-top:16px;
    border-top:1px solid rgba(0,0,0,.08);
  }

  .upload-proof.show{
    display:block;
  }

  .upload-proof .upload-hint{
    font-size:12px;
    color: var(--ink-soft);
    margin:-2px 0 10px;
  }

  .upload-proof input[type="file"]{
    width:100%;
    background: var(--cream-soft);
    border:1px dashed rgba(0,0,0,.15);
    border-radius:10px;
    padding:14px 16px;
    font-size:13px;
    font-family:inherit;
    color:var(--ink-soft);
  }

  .upload-dropzone{
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    gap:8px;
    text-align:center;
    background:var(--cream-soft);
    border:1.5px dashed rgba(0,0,0,.18);
    border-radius:10px;
    padding:32px 16px;
    cursor:pointer;
    transition:border-color .2s ease, background .2s ease;
  }

  .upload-dropzone:hover{
    border-color:var(--orange);
    background:var(--white);
  }

  .upload-dropzone.has-file{
    border-style:solid;
    border-color:var(--orange);
    background:var(--white);
  }

  .upload-icon{
    width:40px;
    height:40px;
    border-radius:50%;
    background:var(--peach);
    color:var(--orange-dark);
    font-size:18px;
    display:flex;
    align-items:center;
    justify-content:center;
  }

  .upload-text{
    font-size:13px;
    font-weight:600;
    color:var(--ink-soft);
  }

  .upload-dropzone.has-file .upload-text{
    color:var(--ink);
  }

  /* ---------- SUMMARY ---------- */
  .checkout-summary{
    background:var(--white);
    border-radius:10px;
    padding:26px;
    box-shadow:0 10px 24px -18px rgba(60,30,10,.3);
    position:sticky;
    top:100px;
    align-self:start;
  }

  .summary-head{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:18px;
  }

  .summary-head h2{
    font-family:var(--font-display);
    font-weight:700;
    font-size:17px;
    color:var(--ink);
  }

  .summary-items{
    display:flex;
    flex-direction:column;
    gap:14px;
    padding-bottom:18px;
    margin-bottom:16px;
    border-bottom:1px solid rgba(0,0,0,.08);
  }

  .summary-item{
    display:flex;
    gap:12px;
  }

  .summary-item-media{
    width:52px;
    height:52px;
    border-radius:10px;
    overflow:hidden;
    flex:none;
    background:#eee;
  }

  .summary-item-media img{
    width:100%;
    height:100%;
    object-fit:cover;
  }

  .summary-item-body{
    flex:1;
  }

  .summary-item-top{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:8px;
  }

  .summary-item-name{
    font-weight:700;
    font-size:13px;
    color:var(--ink);
  }

  .summary-item-price{
    font-weight:700;
    font-size:13px;
    color:var(--ink);
    white-space:nowrap;
  }

  .summary-item-meta{
    display:flex;
    align-items:center;
    gap:8px;
    font-size:11.5px;
    color:var(--ink-soft);
    margin-top:4px;
  }

  .summary-item-note{
    font-size:11px;
    color:var(--ink-soft);
    margin-top:2px;
  }

  .summary-totals{
    margin-bottom:16px;
  }

  .total-row{
    display:flex;
    justify-content:space-between;
    font-size:13px;
    color:var(--ink-soft);
    margin-bottom:10px;
  }

  .summary-divider{
    border:none;
    border-top:1px solid rgba(0,0,0,.08);
    margin:4px 0 16px;
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
    color:var(--ink-soft);
  }

  .grand-total-sub{
    font-size:11px;
    color:var(--ink-soft);
    margin-top:2px;
  }

  .grand-total-value{
    font-family:var(--font-display);
    font-weight:800;
    font-size:26px;
    color:var(--orange-dark);
  }

  .btn-confirm{
    display:block;
    width:100%;
    background:var(--orange);
    color:#fff;
    font-weight:700;
    font-size:14.5px;
    padding:16px;
    text-align:center;
    border-radius:var(--radius-pill);
    box-shadow:0 12px 24px -10px rgba(217,123,41,.6);
    transition:background .2s ease, transform .1s ease;
    border:none;
    cursor:pointer;
  }

  .btn-confirm:hover{
    background:var(--orange-dark);
  }

  .btn-confirm:active{
    transform:scale(0.98);
  }

  .confirm-note{
    text-align:center;
    font-size:11px;
    color:var(--ink-soft);
    background:var(--cream-soft);
    padding:10px;
    border-radius:var(--radius-md);
    margin-top:12px;
  }

  /* ---------- RESPONSIVE ---------- */
  @media (max-width:980px){
    .checkout-layout{
      grid-template-columns:1fr;
    }

    .form-row{
      grid-template-columns:1fr;
    }

    .shipping-options{
      grid-template-columns:1fr;
    }
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
            <label class="field-label">
              Nama Lengkap Pemesan <span class="req">*</span>
            </label>
            <input type="text" id="namaPenerima" value="Siti Zulaikha">
          </div>

          <div class="field-block">
            <label class="field-label">
              Nomor WhatsApp Aktif <span class="req">*</span>
            </label>

            <div class="phone-input">
              <span class="phone-prefix">+62</span>
              <input type="text" id="waPenerima" value="81298765432">
            </div>
          </div>

        </div>

        <div class="field-block">
          <label class="field-label">
            Alamat Lengkap Pengantaran <span class="req">*</span>
          </label>

          <textarea rows="3" id="alamatPenerima">Jl. Tanimbar No. 13 Kelurahan Kasin Kecamatan Klojen kota Malang</textarea>
        </div>

        <div class="field-block">
          <label class="field-label">
            Catatan Driver &amp; Titik Temu
          </label>

          <input
            type="text"
            id="catatanDriver"
            value="Pagar hitam motif kayu, tekan bel kanan. Titip pos satpam jika sedang keluar."
          >
        </div>

      </section>

      <section class="checkout-section reveal">

        <h2 style="margin-bottom:18px;">
          2. Opsi Pengiriman
        </h2>

        <div class="shipping-options" id="shippingOptions">

          <label class="ship-card active" data-cost="10000">

            <div class="ship-label-row">
              <span class="ship-label">Instant Kurir</span>
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

        <p class="section-sub">
          Punya preferensi bumbu atau tingkat kematangan? Chef kami akan menyesuaikannya.
        </p>

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
              </div>

              <p class="pay-desc">
                BCA, GoPay, OVO, ShopeePay, DANA &amp; semua e-wallet
              </p>

            </div>

          </label>

          <label class="pay-row" data-method="cod">

            <input type="radio" name="payment">

            <div class="pay-body">

              <div class="pay-top">
                <span class="pay-name">Bayar di Tempat (COD)</span>
              </div>

              <p class="pay-desc">
                Serahkan uang pas ke kurir 2DA Store saat tiba
              </p>

            </div>

          </label>

        </div>

        <!--
            Upload bukti pembayaran sengaja disembunyikan.
            QRIS dan VA sekarang ditangani oleh Midtrans Snap.
        -->
        <div
          class="upload-proof"
          id="uploadProof"
          style="display:none;"
        >
          <input type="file" accept="image/*" id="proofFile" hidden>
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
        <div class="grand-total-label">
          Total Pembayaran
        </div>

        <div class="grand-total-sub">
          Termasuk pajak &amp; kemasan
        </div>
      </div>

      <div
        class="grand-total-value"
        id="grandTotal"
      >
        Rp 0
      </div>

    </div>

    <button
      type="submit"
      form="checkoutForm"
      class="btn-confirm"
    >
      Konfirmasi &amp; Pesan Sekarang →
    </button>

    <p class="confirm-note">
      Pesanan diproses langsung dari dapur higienis 2DA Store
    </p>

  </aside>

</div>

@endsection

@include('partials.cart-script')

@push('scripts')

<script
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}">
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // =====================================================
    // AMBIL ITEM DARI KERANJANG
    // =====================================================

    function getLocalStorage(key, fallback) {
        try {
            const data = localStorage.getItem(key);

            if (!data) {
                return fallback;
            }

            return JSON.parse(data);
        } catch (error) {
            console.error('Gagal membaca localStorage:', error);
            return fallback;
        }
    }

    const cartItems = getLocalStorage('twoda_cart', []);
    const checkoutKeys = getLocalStorage('twoda_checkout', []);

    // Hanya item yang dipilih dari halaman keranjang
    const orderItems = cartItems.filter(function (item) {
        return checkoutKeys.includes(item.key);
    });

    console.log('Cart:', cartItems);
    console.log('Checkout Keys:', checkoutKeys);
    console.log('Order Items:', orderItems);


    // =====================================================
    // HITUNG SUBTOTAL
    // =====================================================

    const SUBTOTAL = orderItems.reduce(function (sum, item) {

        const product = PRODUCTS[item.id];

        if (!product) {
            console.warn('Produk tidak ditemukan:', item.id);
            return sum;
        }

        let harga = Number(product.price || 0);

        // Tambahan harga opsi
        if (Array.isArray(item.opts)) {
            item.opts.forEach(function (opt) {
                harga += Number(opt.extra || 0);
            });
        }

        return sum + (harga * Number(item.qty || 0));

    }, 0);


    // =====================================================
    // ELEMENT
    // =====================================================

    const shippingOptions =
        document.querySelectorAll('.ship-card');

    const paymentOptions =
        document.querySelectorAll('.pay-row');

    const shippingCostLabel =
        document.getElementById('shippingCostLabel');

    const grandTotal =
        document.getElementById('grandTotal');

    const summaryItems =
        document.getElementById('summaryItems');

    const itemCount =
        document.getElementById('itemCount');

    const subtotalItem =
        document.getElementById('subtotalItem');

    const checkoutForm =
        document.getElementById('checkoutForm');

    const uploadProof =
        document.getElementById('uploadProof');

    const proofFile =
        document.getElementById('proofFile');

    const uploadDropzone =
        document.getElementById('uploadDropzone');

    const uploadFileName =
        document.getElementById('uploadFileName');

    let currentShippingCost = 10000;


    // =====================================================
    // FORMAT RUPIAH
    // =====================================================

    function formatRupiah(number) {
        return 'Rp ' + Number(number || 0).toLocaleString('id-ID');
    }


    // =====================================================
    // TOTAL
    // =====================================================

    function recalcTotal() {

        shippingCostLabel.textContent =
            formatRupiah(currentShippingCost);

        const total =
            SUBTOTAL + currentShippingCost;

        grandTotal.textContent =
            formatRupiah(total);
    }


    // =====================================================
    // SHIPPING
    // =====================================================

    shippingOptions.forEach(function (card) {

        card.addEventListener('click', function () {

            shippingOptions.forEach(function (c) {
                c.classList.remove('active');

                const radio =
                    c.querySelector('input[type="radio"]');

                if (radio) {
                    radio.checked = false;
                }
            });

            card.classList.add('active');

            const radio =
                card.querySelector('input[type="radio"]');

            if (radio) {
                radio.checked = true;
            }

            currentShippingCost =
                parseInt(card.dataset.cost || 0, 10);

            recalcTotal();
        });

    });


    // =====================================================
    // PAYMENT
    // =====================================================

    function toggleUploadProof() {

        // QRIS dan VA sekarang menggunakan Midtrans.
        // Tidak perlu upload bukti pembayaran manual.

        if (uploadProof) {
            uploadProof.classList.remove('show');
            uploadProof.style.display = 'none';
        }

    }


    paymentOptions.forEach(function (row) {

        row.addEventListener('click', function () {

            paymentOptions.forEach(function (r) {

                r.classList.remove('active');

                const radio =
                    r.querySelector('input[type="radio"]');

                if (radio) {
                    radio.checked = false;
                }

            });

            row.classList.add('active');

            const radio =
                row.querySelector('input[type="radio"]');

            if (radio) {
                radio.checked = true;
            }

            toggleUploadProof();

        });

    });

    toggleUploadProof();


    // =====================================================
    // FILE BUKTI PEMBAYARAN
    // =====================================================

    if (proofFile) {

        proofFile.addEventListener('change', function () {

            if (proofFile.files.length > 0) {

                uploadFileName.textContent =
                    proofFile.files[0].name;

                uploadDropzone.classList.add('has-file');

            } else {

                uploadFileName.textContent =
                    'Klik untuk pilih file, atau seret ke sini';

                uploadDropzone.classList.remove('has-file');

            }

        });

    }


    // =====================================================
    // RINGKASAN PESANAN
    // =====================================================

    itemCount.textContent =
        orderItems.length + ' Item';

    subtotalItem.textContent =
        formatRupiah(SUBTOTAL);


    if (orderItems.length === 0) {

        summaryItems.innerHTML = `
            <p class="summary-item-note">
                Belum ada produk di pesanan ini.
                <a href="/keranjang">Kembali ke keranjang</a>
            </p>
        `;

    } else {

        summaryItems.innerHTML =
            orderItems.map(function (item) {

                const product =
                    PRODUCTS[item.id];

                if (!product) {
                    return '';
                }

                let harga = Number(product.price || 0);

                if (Array.isArray(item.opts)) {

                    item.opts.forEach(function (opt) {
                        harga += Number(opt.extra || 0);
                    });

                }

                const totalItem =
                    harga * Number(item.qty || 0);

                return `
                    <div class="summary-item">

                        <div class="summary-item-media">
                            <img
                                src="${product.image}"
                                alt="${product.name}"
                            >
                        </div>

                        <div class="summary-item-body">

                            <div class="summary-item-top">

                                <span class="summary-item-name">
                                    ${product.name}
                                </span>

                                <span class="summary-item-price">
                                    ${formatRupiah(totalItem)}
                                </span>

                            </div>

                            <div class="summary-item-meta">

                                <span>
                                    ${item.qty}x @ ${formatRupiah(harga)}
                                </span>

                            </div>

                        </div>

                    </div>
                `;

            }).join('');

    }


    // =====================================================
    // KONFIRMASI PESANAN
    // =====================================================

    checkoutForm.addEventListener('submit', async function (e) {

        e.preventDefault();


        // -------------------------------------------------
        // CEK ITEM
        // -------------------------------------------------

        if (orderItems.length === 0) {

            alert(
                'Belum ada produk yang dipilih dari keranjang.'
            );

            window.location.href = '/keranjang';

            return;
        }


        // -------------------------------------------------
        // DATA PENERIMA
        // -------------------------------------------------

        const nama =
            document.getElementById('namaPenerima')
                .value
                .trim();

        const wa =
            document.getElementById('waPenerima')
                .value
                .trim();

        const alamat =
            document.getElementById('alamatPenerima')
                .value
                .trim();


        if (!nama || !wa || !alamat) {

            alert(
                'Mohon lengkapi nama, nomor WhatsApp, dan alamat pengantaran.'
            );

            return;
        }


        // -------------------------------------------------
        // PAYMENT METHOD
        // -------------------------------------------------

        const activePay =
            document.querySelector('.pay-row.active');

        const method =
            activePay
                ? activePay.dataset.method
                : 'qris';


        // -------------------------------------------------
        // SHIPPING
        // -------------------------------------------------

        const activeShip =
            document.querySelector('.ship-card.active .ship-label');


        // -------------------------------------------------
        // PAYLOAD
        // -------------------------------------------------

        const payload =
            new FormData();

        payload.append(
            '_token',
            document.querySelector(
                'meta[name="csrf-token"]'
            ).content
        );

        payload.append(
            'nama',
            nama
        );

        payload.append(
            'phone',
            '+62' + wa.replace(/^0+/, '')
        );

        payload.append(
            'address',
            alamat
        );

        payload.append(
            'driver_note',
            document.getElementById(
                'catatanDriver'
            ).value.trim()
        );

        payload.append(
            'kitchen_note',
            document.getElementById(
                'catatanDapur'
            ).value.trim()
        );

        payload.append(
            'shipping_label',
            activeShip
                ? activeShip.textContent.trim()
                : ''
        );

        payload.append(
            'shipping_cost',
            String(currentShippingCost)
        );

        payload.append(
            'payment',
            method
        );

        payload.append(
            'subtotal',
            String(SUBTOTAL)
        );

        payload.append(
            'total',
            String(
                SUBTOTAL + currentShippingCost
            )
        );


        // -------------------------------------------------
        // ITEMS
        // -------------------------------------------------

        orderItems.forEach(function (item, index) {

            payload.append(
                `items[${index}][id]`,
                item.id
            );

            payload.append(
                `items[${index}][qty]`,
                String(item.qty)
            );


            if (Array.isArray(item.opts)) {

                item.opts.forEach(function (opt, optIndex) {

                    payload.append(
                        `items[${index}][opts][${optIndex}][name]`,
                        opt.name || ''
                    );

                    payload.append(
                        `items[${index}][opts][${optIndex}][extra]`,
                        String(opt.extra || 0)
                    );

                });

            }

        });


        // -------------------------------------------------
        // BUTTON
        // -------------------------------------------------

        const btn =
            document.querySelector('.btn-confirm');

        const oldText =
            btn.textContent;

        btn.disabled = true;

        btn.textContent =
            'Menyimpan pesanan...';


        try {

            // =================================================
            // SIMPAN PESANAN
            // =================================================

            const response =
                await fetch(
                    '{{ route('pesanan.store') }}',
                    {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json'
                        },
                        body: payload
                    }
                );


            const result =
                await response.json();


            if (!response.ok) {

                throw new Error(
                    result.message ||
                    'Pesanan gagal disimpan.'
                );

            }


            // =================================================
            // QRIS / VA → MIDTRANS
            // =================================================

            if (
                method === 'qris' ||
                method === 'va'
            ) {

                btn.textContent =
                    'Membuka pembayaran...';


                const tokenResponse =
                    await fetch(
                        '{{ route('midtrans.token') }}',
                        {
                            method: 'POST',

                            headers: {

                                'Content-Type':
                                    'application/json',

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    document.querySelector(
                                        'meta[name="csrf-token"]'
                                    ).content
                            },

                            body: JSON.stringify({
                                transaksi_id: result.id
                            })
                        }
                    );


                const tokenResult =
                    await tokenResponse.json();


                if (!tokenResponse.ok) {

                    throw new Error(
                        tokenResult.message ||
                        'Gagal membuat pembayaran Midtrans.'
                    );

                }


                if (!tokenResult.snap_token) {

                    throw new Error(
                        'Snap Token Midtrans tidak ditemukan.'
                    );

                }


                // -------------------------------------------------
                // HAPUS ITEM YANG SUDAH DIBUAT PESANAN
                // -------------------------------------------------

                const currentCart =
                    getLocalStorage(
                        'twoda_cart',
                        []
                    );


                const selectedKeys =
                    orderItems.map(function (item) {
                        return item.key;
                    });


                const remainingCart =
                    currentCart.filter(function (item) {

                        return !selectedKeys.includes(
                            item.key
                        );

                    });


                localStorage.setItem(
                    'twoda_cart',
                    JSON.stringify(remainingCart)
                );

                localStorage.setItem(
                    'twoda_checkout',
                    JSON.stringify([])
                );


                // -------------------------------------------------
                // BUKA MIDTRANS
                // -------------------------------------------------

                if (
                    typeof window.snap === 'undefined'
                ) {

                    throw new Error(
                        'Midtrans Snap belum berhasil dimuat. Refresh halaman lalu coba lagi.'
                    );

                }


                window.snap.pay(
                    tokenResult.snap_token,
                    {

                        onSuccess: function () {

                            alert(
                                'Pembayaran berhasil diproses.'
                            );

                            window.location.href =
                                '/riwayat';

                        },


                        onPending: function () {

                            alert(
                                'Pembayaran belum selesai. Silakan selesaikan pembayaran.'
                            );

                            window.location.href =
                                '/riwayat';

                        },


                        onError: function () {

                            alert(
                                'Terjadi masalah pada pembayaran Midtrans.'
                            );

                            window.location.href =
                                '/riwayat';

                        },


                        onClose: function () {

                            alert(
                                'Jendela pembayaran ditutup. Pesanan tetap tersimpan dan bisa dibayar kembali.'
                            );

                            window.location.href =
                                '/riwayat';

                        }

                    }
                );

                return;
            }


            // =================================================
            // COD
            // =================================================

            const currentCart =
                getLocalStorage(
                    'twoda_cart',
                    []
                );


            const selectedKeys =
                orderItems.map(function (item) {
                    return item.key;
                });


            const remainingCart =
                currentCart.filter(function (item) {

                    return !selectedKeys.includes(
                        item.key
                    );

                });


            localStorage.setItem(
                'twoda_cart',
                JSON.stringify(remainingCart)
            );

            localStorage.setItem(
                'twoda_checkout',
                JSON.stringify([])
            );


            alert(
                'Pesanan ' +
                result.id +
                ' berhasil disimpan dan masuk ke admin.'
            );


            window.location.href =
                '/riwayat';


        } catch (error) {

            console.error(error);

            alert(
                error.message ||
                'Terjadi kesalahan saat menyimpan pesanan.'
            );

            btn.disabled = false;

            btn.textContent =
                oldText;

        }

    });


    // =====================================================
    // TOTAL AWAL
    // =====================================================

    recalcTotal();

});
</script>
@endpush