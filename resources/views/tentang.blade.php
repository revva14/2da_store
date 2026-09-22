@extends('layouts.app')

@section('title', 'Tentang Kami — 2DA Store')

@push('styles')
<style>
  /* Variabel warna khusus halaman ini (nama diubah dari aslinya --cream/--cream-soft/
     --orange/--orange-dark supaya TIDAK menimpa variabel shared punya navbar & footer) */
  :root{
    --cream:#fdf1e0;
    --tg-cream-soft: #fef7f0;
    --cream-glow: #fbe1d0;
    --brown-900: #3c2a20;
    --brown-800: #4a3528;
    --brown-700: #5a4335;
    --brown-600: #6b5040;
    --tg-orange: #e8783c;
    --tg-orange-dark: #d9672c;
    --green-badge: #b7e07a;
    --yellow-badge: #f3cf6a;
    --text-body: #6b5c50;
  }

  main{
    font-family: 'Segoe UI', Poppins, Arial, sans-serif;
    background: var(--tg-cream-soft);
    color: var(--brown-900);
    line-height: 1.6;
  }

  /* HERO — disamakan dengan hero halaman Hubungi Kami */
  .hero{
    position:relative;
    text-align:center;
    padding: 180px 24px 170px;
    min-height: 540px;
    display:flex;
    flex-direction:column;
    justify-content:center;
    overflow:hidden;
    background:radial-gradient(circle at 50% 30%, #fbdcc4 0%, var(--cream) 70%);    
}
  .hero-eyebrow{
    display:inline-block;
    color: var(--tg-orange-dark);
    font-size: 15px;
    margin-bottom: 6px;
    font-weight:600;
  }
  .hero h1{
    font-size: clamp(36px, 5vw, 52px);
    color: var(--tg-orange-dark);
    font-weight: 800;
    margin: 6px 0 28px;
  }
  .hero p{
    max-width: 680px;
    margin: 0 auto;
    color: var(--brown-700);
    font-size: 17px;
  }

  /* CERITA KAMI */
  .story{
    padding: 70px 24px;
    background: var(--tg-cream-soft);
  }
  .story-grid{
    display:grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items:center;
    max-width: 1160px;
    margin: 0 auto;
  }
  .story-eyebrow{
    font-size: 14px;
    color: var(--tg-orange-dark);
    font-weight: 600;
    margin-bottom: 10px;
  }
  .story-text h2{
    font-size: 34px;
    font-weight: 800;
    color: var(--brown-900);
    margin: 0 0 20px;
  }
  .story-text p{
    color: var(--text-body);
    font-size: 15.5px;
    margin-bottom: 16px;
  }
  .story-img{
    border-radius: 14px;
    overflow:hidden;
    box-shadow: 0 20px 40px rgba(60,42,32,.15);
  }
  .story-img img{ width:100%; height: 100%; object-fit: cover; }

  /* FILOSOFI */
  .philosophy{
    background: var(--cream-glow);
    padding: 80px 24px;
    text-align:center;
  }
  .philosophy h2{
    font-size: 34px;
    font-weight: 800;
    color: var(--tg-orange-dark);
    margin-bottom: 14px;
  }
  /* .container dipakai bareng navbar/footer (beda ukuran punya shared layout),
     jadi ukuran aslinya di-scope khusus section ini saja */
  .philosophy .container{
    max-width: 1200px;
    padding: 0 24px;
  }
  .philosophy > .container > p{
    max-width: 520px;
    margin: 0 auto 48px;
    color: var(--brown-700);
    font-size: 16px;
  }
  .philosophy-grid{
    display:grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    max-width: 1160px;
    margin: 0 auto;
  }
  .philosophy-card{
    background: var(--white);
    border-radius: 16px;
    padding: 30px 26px;
    text-align:left;
    box-shadow: 0 10px 25px rgba(60,42,32,.06);
  }
  .philosophy-badge{
    width: 34px;
    height: 34px;
    border-radius: 50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
    font-size: 14px;
    color: var(--brown-900);
    margin-bottom: 18px;
  }
  .philosophy-badge.orange{ background: var(--tg-orange); color: var(--white); }
  .philosophy-badge.green{ background: var(--green-badge); }
  .philosophy-badge.yellow{ background: var(--yellow-badge); }

  .philosophy-card h3{
    font-size: 19px;
    font-weight: 700;
    margin: 0 0 10px;
    color: var(--brown-900);
  }
  .philosophy-card p{
    font-size: 14.5px;
    color: var(--text-body);
    margin:0;
  }

  /* KOMITMEN */
  .commitment{
    padding: 90px 24px;
    background: var(--tg-cream-soft);
  }
  .commitment-grid{
    display:grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items:center;
    max-width: 1160px;
    margin: 0 auto;
  }
  .commitment-img{
    border-radius: 14px;
    overflow:hidden;
    box-shadow: 0 20px 40px rgba(60,42,32,.15);
  }
  .commitment-img img{ width:100%; object-fit:cover; }
  .commitment-text h2{
    font-size: 32px;
    font-weight: 800;
    margin: 0 0 20px;
    color: var(--brown-900);
  }
  .commitment-text p{
    color: var(--text-body);
    font-size: 15.5px;
    margin-bottom: 16px;
  }
  .btn-explore{
    display:inline-block;
    margin-top: 12px;
    background: var(--brown-800);
    color: var(--white);
    padding: 14px 30px;
    border-radius: 999px;
    font-weight: 600;
    font-size: 14.5px;
    border:none;
    cursor:pointer;
    transition: background .2s ease, transform .2s ease;
  }
  .btn-explore:hover{ background: var(--brown-900); transform: translateY(-1px); }

  /* ---------- RESPONSIVE (khusus halaman ini) ---------- */
  @media (max-width: 900px){
    .story-grid, .commitment-grid{ grid-template-columns: 1fr; }
    .story-grid .story-img{ order:-1; }
    .philosophy-grid{ grid-template-columns: 1fr; }
    .hero{ padding: 130px 24px 120px; min-height: 420px; }
  }

  /* Reveal animation on load (mekanisme aslinya: animation on-paint,
     beda dari .reveal scroll-observer di halaman lain, tapi tetap aman
     dipakai bareng karena animation lebih diprioritaskan dari transition) */
  .reveal{
    animation: revealIn .7s ease forwards;
  }
  @keyframes revealIn{
    from{ opacity:0; transform: translateY(16px); }
    to{ opacity:1; transform: translateY(0); }
  }

  @media (prefers-reduced-motion: reduce){
    .reveal{ animation: none; opacity:1; transform:none; }
  }

  main a:focus-visible, main button:focus-visible{
    outline: 2px solid var(--tg-orange-dark);
    outline-offset: 2px;
  }
</style>
@endpush

@section('content')

  <!-- HERO -->
  <section class="hero">
    <div class="reveal">
      <h1>Tentang Kami</h1>
      <p>
        Kami percaya jajanan sehari-hari nggak harus biasa-biasa saja.
        Semua berawal dari ide sederhana: menghadirkan jajanan-jajanan favorit
        dengan rasa autentik, diolah higienis, dan dikirim hangat langsung ke depan pintu Anda.
      </p>
    </div>
  </section>

  <!-- CERITA KAMI -->
  <section class="story">
    <div class="story-grid">
      <div class="story-text">
        <div class="story-eyebrow">Cerita Kami</div>
        <h2>Lahirnya 2DA Store</h2>
        <p>
          Semua bermula dari dapur kecil yang penuh aroma jajanan khas jalanan —
          gorengan hangat, camilan manis, dan jajanan tradisional yang selalu
          berhasil bikin kangen. Dari situ kami sadar, banyak orang rindu jajanan
          seperti ini tapi susah dapat yang benar-benar bersih, segar, dan rasanya
          pas seperti dulu.
        </p>
        <p>
          Kini, 2DA Store bukan sekadar tempat jajan online. Kami adalah teman
          ngemil harian Anda, menghadirkan jajanan-jajanan pilihan yang diproses
          dengan standar kebersihan ketat, tanpa mengorbankan cita rasa aslinya.
          Setiap jajanan yang kami kirim dibuat dengan resep yang dijaga
          kualitasnya, dari tangan-tangan yang paham betul cara bikin jajanan enak.
        </p>
      </div>
      <div class="story-img">
        <img src="{{ asset('images/herobaru.png') }}" alt="Aneka jajanan gorengan khas jalanan">
      </div>
    </div>
  </section>

  <!-- FILOSOFI -->
  <section class="philosophy">
    <div class="container">
      <h2>Filosofi Kami</h2>
      <p>Prinsip-prinsip yang memandu segala hal yang kami sumber, ciptakan, dan bagikan kepada Anda.</p>
      <div class="philosophy-grid">
        <div class="philosophy-card">
          <div class="philosophy-badge orange">1</div>
          <h3>Bahan Pilihan</h3>
          <p>Kami hanya pakai bahan-bahan segar dan berkualitas dari pemasok terpercaya, tanpa kompromi pada rasa maupun keamanan pangan.</p>
        </div>
        <div class="philosophy-card">
          <div class="philosophy-badge green">2</div>
          <h3>Proses Higienis</h3>
          <p>Setiap jajanan diolah dengan standar kebersihan yang ketat, mulai dari dapur sampai kemasan, supaya tetap aman dan nikmat saat sampai di tangan Anda.</p>
        </div>
        <div class="philosophy-card">
          <div class="philosophy-badge yellow">3</div>
          <h3>Kehangatan Rasa Rumahan</h3>
          <p>Kami menjaga cita rasa asli jajanan tradisional, dibuat dengan sepenuh hati seperti buatan sendiri di rumah.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- KOMITMEN -->
  <section class="commitment">
    <div class="commitment-grid">
      <div class="commitment-img">
        <img src="{{ asset('images/corndog2.jpg') }}" alt="Corndog digoreng hangat">
      </div>
      <div class="commitment-text">
        <h2>Komitmen untuk Anda</h2>
        <p>
          Seiring bertumbuhnya 2DA Store, janji kami tetap sama: menghadirkan
          jajanan jalanan terbaik dengan kualitas terjaga, harga bersahabat, dan
          pengiriman yang selalu hangat sampai tujuan.
        </p>
        <p>
          Terima kasih sudah mempercayakan 2DA Store menemani hari-hari Anda.
          Yuk, jelajahi menu kami dan temukan jajanan favoritmu!
        </p>
        <button class="btn-explore" id="exploreBtn">Jelajahi Produk Kami</button>
      </div>
    </div>
  </section>

@endsection

@push('scripts')
<script>
  // Tombol "Jelajahi Produk Kami" scroll ke menu (atau ganti sesuai kebutuhan)
  document.getElementById('exploreBtn').addEventListener('click', function(){
    const menu = document.querySelector('#menu');
    if(menu){
      menu.scrollIntoView({ behavior: 'smooth' });
    } else {
      window.location.href = '#menu';
    }
  });
</script>
@endpush