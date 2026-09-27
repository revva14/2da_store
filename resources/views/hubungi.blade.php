@extends('layouts.app')

@section('title', 'Hubungi Kami - 2DA Store')

@push('styles')
<style>
  /* ==========================================================
     Style khusus halaman Hubungi Kami — di-scope dalam
     .hubungi-page supaya tidak bentrok dengan class/variable
     global milik layouts.app (mis. .hero, .footer-grid, --orange).
     Semua nilai & aturan di bawah ini sama persis dengan
     hubungi_kami.html aslinya.
     ========================================================== */
  .hubungi-page{
    --cream:#fdf1e0;
    --cream-soft:#fdf6ea;
    --orange:#f5943c;
    --orange-dark:#c2661f;
    --brown-footer:#4d3428;
    --text-dark:#241a12;
    --text-muted:#7a6b5d;
    --white:#ffffff;
    --border:#f0e2cd;
    --green:#3e7d3f;
    --green-bg:#e9f2e3;
    --yellow-bg:#fbe9b0;
    --peach-bg:#fbe2cf;

    font-family:'Poppins','Segoe UI',sans-serif;
    background:var(--cream);
    color:var(--text-dark);
  }
  .hubungi-page *{ box-sizing:border-box; }

  /* ---------- Hero ---------- */
  .hubungi-page .hero{
    background:radial-gradient(circle at 50% 30%, #fbdcc4 0%, var(--cream) 70%);
    text-align:center;
    padding:180px 24px 170px;
    min-height:540px;
    display:flex;
    flex-direction:column;
    justify-content:center;
  }
  .hubungi-page .hero h1{
    font-size:44px;
    font-weight:800;
    color:var(--orange-dark);
    margin-bottom:26px;
  }
  .hubungi-page .hero p{
    font-size:17px;
    color:#5c4a3c;
    max-width:680px;
    margin:0 auto;
    line-height:1.7;
  }

  /* ---------- Info cards ---------- */
  .hubungi-page .info-cards{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:24px;
    padding:0 64px;
    margin-top:20px;
  }
  .hubungi-page .info-card{
    background:var(--white);
    border-radius:20px;
    padding:26px;
    display:flex;
    flex-direction:column;
  }
  .hubungi-page .info-card h3{ font-size:19px; font-weight:800; margin-bottom:10px; }
  .hubungi-page .info-card p{ font-size:14px; color:var(--text-muted); line-height:1.6; flex:1; margin-bottom:20px; }

  .hubungi-page .info-btn{
    border:none;
    border-radius:999px;
    padding:14px;
    font-weight:700;
    font-size:14px;
    cursor:pointer;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    text-decoration:none;
  }
  .hubungi-page .btn-green{ background:var(--green); color:#fff; }
  .hubungi-page .btn-green:hover{ background:#336a34; }
  .hubungi-page .btn-brown{ background:var(--brown-footer); color:#fff; }
  .hubungi-page .btn-brown:hover{ background:#3a271e; }
  .hubungi-page .btn-peach{ background:var(--peach-bg); color:var(--orange-dark); }
  .hubungi-page .btn-peach:hover{ background:#f6d2b2; }

  /* ---------- Contact + FAQ section ---------- */
  .hubungi-page .contact-section{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:24px;
    padding:60px 64px 90px;
    align-items:start;
  }

  .hubungi-page .contact-form-card{
    background:var(--cream-soft);
    border-radius:20px;
    padding:30px;
  }
  .hubungi-page .contact-form-card h2{
    font-size:22px;
    font-weight:800;
    display:flex;
    align-items:center;
    gap:10px;
    margin-bottom:10px;
  }
  .hubungi-page .contact-form-card > p{
    font-size:14px;
    color:var(--text-muted);
    margin-bottom:24px;
    line-height:1.6;
  }

  .hubungi-page .form-row{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:18px;
    margin-bottom:18px;
  }
  .hubungi-page label.field-label{
    display:block;
    font-size:14px;
    font-weight:600;
    margin-bottom:8px;
  }
  .hubungi-page label.field-label .req{ color:#c0432f; }

  .hubungi-page .input-icon{
    position:relative;
  }
  .hubungi-page .input-icon span{
    position:absolute;
    left:14px; top:50%;
    transform:translateY(-50%);
    font-size:15px;
    color:var(--text-muted);
  }
  .hubungi-page .input-icon input, .hubungi-page .input-icon select{
    width:100%;
    padding:13px 14px;
    border:1px solid var(--border);
    border-radius:12px;
    background:var(--white);
    font-size:14.5px;
    font-family:inherit;
    color:var(--text-dark);
  }
  .hubungi-page select{ appearance:none; cursor:pointer; }

  .hubungi-page textarea{
    width:100%;
    padding:13px 14px;
    border:1px solid var(--border);
    border-radius:12px;
    background:var(--white);
    font-size:14.5px;
    font-family:inherit;
    min-height:90px;
    resize:vertical;
  }
  .hubungi-page input:focus, .hubungi-page textarea:focus, .hubungi-page select:focus{
    outline:2px solid var(--orange);
    outline-offset:1px;
  }

  .hubungi-page .field-block{ margin-bottom:20px; }

  .hubungi-page .send-btn{
    background:var(--orange);
    color:#fff;
    border:none;
    border-radius:999px;
    padding:14px 28px;
    font-weight:700;
    font-size:14.5px;
    cursor:pointer;
    display:inline-flex;
    align-items:center;
    gap:8px;
    margin-bottom:26px;
  }
  .hubungi-page .send-btn:hover{ background:var(--orange-dark); }

  /* FAQ card */
  .hubungi-page .faq-card{
    background:var(--white);
    border-radius:20px;
    padding:30px;
    margin-bottom:24px;
  }
  .hubungi-page .faq-card h2{ font-size:20px; font-weight:800; margin-bottom:20px; }
  .hubungi-page .faq-item{ border-bottom:1px solid var(--border); }
  .hubungi-page .faq-item:last-child{ border-bottom:none; }
  .hubungi-page .faq-question{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:16px 0;
    cursor:pointer;
    font-weight:700;
    font-size:14.5px;
  }
  .hubungi-page .faq-question .chevron{
    color:var(--orange-dark);
    transition:transform .2s ease;
    flex-shrink:0;
    margin-left:12px;
  }
  .hubungi-page .faq-item.open .chevron{ transform:rotate(180deg); }
  .hubungi-page .faq-answer{
    max-height:0;
    overflow:hidden;
    transition:max-height .25s ease;
    font-size:13.5px;
    color:var(--text-muted);
    line-height:1.6;
  }
  .hubungi-page .faq-answer p{ padding-bottom:16px; }

  .hubungi-page .testimonial-card{
    background:var(--white);
    border-radius:20px;
    padding:26px;
    margin-bottom:20px;
  }
  .hubungi-page .stars{ color:#f0b429; font-size:16px; margin-bottom:6px; }
  .hubungi-page .rating-label{ float:right; font-size:13px; font-weight:700; color:var(--text-dark); }
  .hubungi-page .testimonial-card blockquote{
    font-style:italic;
    font-size:14.5px;
    color:#4a3c30;
    line-height:1.6;
    margin:14px 0 16px;
  }
  .hubungi-page .testimonial-author{ display:flex; align-items:center; gap:10px; }
  .hubungi-page .testimonial-author img{ width:38px;height:38px;border-radius:50%; object-fit:cover; }
  .hubungi-page .testimonial-author .name{ font-size:14px; font-weight:700; }
  .hubungi-page .testimonial-author .role{ font-size:12.5px; color:var(--text-muted); }

  .hubungi-page .problem-note{
    display:flex;
    gap:12px;
    align-items:flex-start;
    font-size:13.5px;
    color:var(--text-muted);
    line-height:1.6;
  }
  .hubungi-page .problem-note .bolt{ font-size:18px; margin-top:2px; }
  .hubungi-page .problem-note strong{ color:var(--text-dark); }
  .hubungi-page .problem-note a{ color:var(--orange-dark); font-weight:700; text-decoration:none; }

  @media (max-width:980px){
    .hubungi-page .info-cards{ padding-left:24px; padding-right:24px; }
    .hubungi-page .contact-section{ padding-left:24px; padding-right:24px; }
    .hubungi-page .info-cards{ grid-template-columns:1fr; }
    .hubungi-page .contact-section{ grid-template-columns:1fr; }
    .hubungi-page .form-row{ grid-template-columns:1fr; }
    .hubungi-page .hero{ padding:130px 24px 120px; min-height:420px; }
    .hubungi-page .hero h1{ font-size:32px; }
  }
</style>
@endpush

@section('content')
<div class="hubungi-page">

  <div class="hero reveal">
    <h1>Hubungi Kami</h1>
    <p>
      Kami percaya jajanan sehari-hari nggak harus biasa-biasa saja.
      Semua berawal dari ide sederhana: menghadirkan jajanan-jajanan favorit
      dengan rasa autentik, diolah higienis, dan dikirim hangat langsung ke depan pintu Anda.
    </p>
  </div>

  <div class="info-cards">
    <div class="info-card reveal">
      <h3>Chat Admin WhatsApp</h3>
      <p>Respon cepat dalam 5–10 menit untuk bantuan pesanan langsung hari ini, ketersediaan menu favorit, atau pengantaran kilat.</p>
      <a class="info-btn btn-green" href="https://wa.me/6283129656507" target="_blank">Hubungi WA: 0831-2965-6507</a>
    </div>

    <div class="info-card reveal">
      <h3>Pesanan Jumlah Besar / Event</h3>
      <p>Pesan paket snack box corndog leleh &amp; cireng renyah kenyal untuk pesta ulang tahun, arisan keluarga, atau meeting kantor.</p>
      <a class="info-btn btn-brown" href="https://wa.me/6283129656507" target="_blank">Konsultasi Katering</a>
    </div>

    <div class="info-card reveal">
      <h3>Outlet &amp; Jam Buka</h3>
      <p>Jl. Tebet Raya No. 45, Jakarta Selatan. Buka setiap hari pukul 10.00 – 21.00 WIB untuk takeaway dan ojek online.</p>
      <a class="info-btn btn-peach" href="https://maps.google.com" target="_blank">Buka di Google Maps</a>
    </div>
  </div>

  <div class="contact-section">

    <!-- Form kirim pesan -->
    <div class="contact-form-card reveal">
      <h2>Kirim Pesan Cepat ke Admin</h2>
      <p>Ada komplain atau butuh penawaran custom? Tinggalkan detail di bawah, admin kami akan segera merespon via email atau WhatsApp.</p>

      <form id="contactForm">
        <div class="form-row">
          <div>
            <label class="field-label">Nama Kamu <span class="req">*</span></label>
            <div class="input-icon">
              <input type="text" id="namaKamu" placeholder="Contoh: Budi Santoso">
            </div>
          </div>
          <div>
            <label class="field-label">Email / No WhatsApp <span class="req">*</span></label>
            <div class="input-icon">
              <input type="text" id="kontak" placeholder="0812xxxx atau nama@email.com">
            </div>
          </div>
        </div>

        <div class="field-block">
          <label class="field-label">Kategori Pertanyaan <span class="req">*</span></label>
          <div class="input-icon">
            <select id="kategori">
              <option value="" selected disabled>Pilih kategori kebutuhanmu...</option>
              <option value="pesanan">Status Pesanan</option>
              <option value="katering">Pesanan Katering / Event</option>
              <option value="pembayaran">Pembayaran &amp; Refund</option>
              <option value="lainnya">Lainnya</option>
            </select>
          </div>
        </div>

        <div class="field-block">
          <label class="field-label">Detail Pesan / Pertanyaan <span class="req">*</span></label>
          <textarea id="detailPesan" placeholder="Tuliskan nomor pesanan, tanggal acara, atau hal yang ingin kamu tanyakan..."></textarea>
        </div>

        <button type="submit" class="send-btn">Kirim Pesan ke Admin</button>
      </form>
    </div>

    <!-- FAQ + Testimoni -->
    <div>
      <div class="faq-card reveal">
        <h2>Pertanyaan Sering Diajukan (FAQ)</h2>
        <div id="faqList">
          <div class="faq-item">
            <div class="faq-question">
              <span>Berapa lama estimasi pengiriman pesanan?</span>
              <span class="chevron">⌄</span>
            </div>
            <div class="faq-answer">
              <p>Instant Kurir tiba dalam 20–35 menit, sementara Sameday diantar dalam 1–2 jam tergantung jarak dan antrian dapur.</p>
            </div>
          </div>
          <div class="faq-item">
            <div class="faq-question">
              <span>Bisa dikirim ke luar kota (produk frozen)?</span>
              <span class="chevron">⌄</span>
            </div>
            <div class="faq-answer">
              <p>Bisa, untuk luar kota kami sediakan varian frozen yang dikemas khusus dan dikirim via kurir instan/reguler sesuai domisili.</p>
            </div>
          </div>
          <div class="faq-item">
            <div class="faq-question">
              <span>Bagaimana metode pembayaran pesanan?</span>
              <span class="chevron">⌄</span>
            </div>
            <div class="faq-answer">
              <p>Kami menerima QRIS real-time, Virtual Account (BCA, Mandiri, BNI, BRI), serta COD untuk area tertentu.</p>
            </div>
          </div>
          <div class="faq-item">
            <div class="faq-question">
              <span>Apakah ada minimal order untuk katering acara?</span>
              <span class="chevron">⌄</span>
            </div>
            <div class="faq-answer">
              <p>Untuk paket katering/event, minimal pemesanan adalah 20 box dan disarankan H-2 sebelum acara berlangsung.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="testimonial-card reveal">
        <span class="rating-label">4.8 / 5.0 Rating CS</span>
        <div class="stars">★★★★☆</div>
        <blockquote>
          "Admin WhatsApp ramah banget pas pesen 60 box corndog mozza buat event kampus. Tepat waktu, masih anget renyah, dan dapet bonus extra saus. Recommended!"
        </blockquote>
        <div class="testimonial-author">
          <img src="{{ asset('images/profil-reva.jpg') }}" alt="Nadia Omara">
          <div>
            <div class="name">Nadia Omara</div>
            <div class="role">Koordinator Acara BEM UI</div>
          </div>
        </div>
      </div>

      <div class="problem-note reveal">
        <div>
          <strong>Pesanan Bermasalah?</strong><br>
          Hubungi hotline instan CS: <a href="tel:+6283129656507">0831-2965-6507</a> untuk retur atau refund cepat.
        </div>
      </div>
    </div>

  </div>

</div>
@endsection

@push('scripts')
<script>
  // FAQ accordion
  document.querySelectorAll(".hubungi-page .faq-item").forEach(item => {
    const question = item.querySelector(".faq-question");
    const answer = item.querySelector(".faq-answer");

    question.addEventListener("click", () => {
      const isOpen = item.classList.contains("open");

      document.querySelectorAll(".hubungi-page .faq-item").forEach(i => {
        i.classList.remove("open");
        i.querySelector(".faq-answer").style.maxHeight = null;
      });

      if (!isOpen) {
        item.classList.add("open");
        answer.style.maxHeight = answer.scrollHeight + "px";
      }
    });
  });

  // Contact form submit
  document.getElementById("contactForm").addEventListener("submit", (e) => {
    e.preventDefault();

    const nama = document.getElementById("namaKamu").value.trim();
    const kontak = document.getElementById("kontak").value.trim();
    const kategori = document.getElementById("kategori").value;
    const detail = document.getElementById("detailPesan").value.trim();

    if (!nama || !kontak || !kategori || !detail) {
      alert("Mohon lengkapi semua kolom yang wajib diisi.");
      return;
    }

    // Belum ada backend untuk menerima pesan, jadi pesan dikirim lewat WhatsApp admin
    const kategoriLabel = document.getElementById("kategori").selectedOptions[0].textContent;
    const pesan = `Halo Admin 2DA Store, saya ${nama} (${kontak}).\nKategori: ${kategoriLabel}\n\n${detail}`;
    window.open("https://wa.me/6283129656507?text=" + encodeURIComponent(pesan), "_blank", "noopener");
    e.target.reset();
  });
</script>
@endpush