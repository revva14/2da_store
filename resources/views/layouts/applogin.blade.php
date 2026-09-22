<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', '2DA Store — Nikmati Jajanan Favorit')</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
  :root{
    --cream: #FCEFDD;
    --cream-soft: #FDF6EC;
    --ink: #241206;
    --ink-soft: #4a3626;
    --orange: #D97B29;
    --orange-dark: #B85F16;
    --brown: #7A3B12;
    --brown-dark: #5C2C0C;
    --peach: #FAD9C7;
    --pink-card: #FBDCD8;
    --pink-card-2: #FCE3E0;
    --footer: #3B1F14;
    --footer-soft: #cbb6a9;
    --white: #ffffff;
    --radius-lg: 28px;
    --radius-md: 18px;
    --radius-pill: 10px;
    --font-display: 'Poppins', sans-serif;
    --font-body: 'Inter', sans-serif;
  }

  *{ box-sizing:border-box; margin:0; padding:0; }

  html{ scroll-behavior:smooth; }

  body{
    font-family: var(--font-body);
    color: var(--ink);
    background: var(--cream);
    line-height:1.5;
    -webkit-font-smoothing: antialiased;
  }

  img{ max-width:100%; display:block; }

  a{ text-decoration:none; color:inherit; }

  ul{ list-style:none; }

  button{ font-family:inherit; cursor:pointer; border:none; }

  .container{
    max-width:1240px;
    margin:0 auto;
    padding:0 80px;
  }

  /* ---------- NAV ---------- */
  header.site-nav{
  position: sticky;
  top:0;
  z-index:100;
  background: var(--cream);
  padding: 18px 0;
  }

  .nav-inner{
    display:flex;
    align-items:center;
    justify-content:space-between;
  }

  .logo{
    display:flex;
    align-items:center;
    gap:8px;
    font-family: var(--font-display);
    font-weight:800;
    font-size:14px;
    color: var(--brown-dark);
  }

  .logo-img{
  height: 50px;
  width: auto;
  display: block;
  }

  .logo .badge{
    width: 28pxpx; 
    height: 28pxpx;
    border-radius:50%;
    background: linear-gradient(135deg,#F7B267,#D97B29);
    display:flex; align-items:center; justify-content:center;
    font-size:14px;
  }

  .nav-links{
    display:flex;
    gap:28px;
    font-size:14px;
    font-weight:500;
  }

  .nav-links a{
    position:relative;
    transition: color .2s ease;
  }
  .nav-links a:hover, .nav-links a.active{ color: var(--brown-dark); }
  .nav-links a.active::after{
    content:"";
    position:absolute;
    left:0; right:0; bottom:-6px;
    height:2px;
    background: var(--orange);
    border-radius:2px;
  }

  .btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    font-weight:600;
    font-size:13.5px;
    padding:10px 20px;
    border-radius: var(--radius-pill);
    transition: transform .18s ease, box-shadow .18s ease, background .2s ease;
  }
  .btn:active{ transform: scale(0.97); }

  .btn-primary{
    background: var(--orange);
    color:#fff;
    box-shadow: 0 10px 20px -8px rgba(122,59,18,.55);
  }
  .btn-primary:hover{ background: var(--brown); box-shadow:0 14px 24px -8px rgba(122,59,18,.6); }

  .btn-outline{
    background:transparent;
    border:1.5px solid #d8c7b6;
    color: var(--ink);
  }
  .btn-outline:hover{ border-color:var(--brown); background: rgba(122,59,18,.06); }

  .btn-nav{
    background: var(--orange);
    color:#fff;
    padding:9px 20px;
    font-size:13px;
    border-radius:20px;
  }
  .btn-nav:hover{ background: var(--orange-dark); }

  /* ---------- ICON BUTTONS (profil & keranjang setelah login) ---------- */
  .nav-icon-btn{
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    color: var(--ink);
    background: transparent;
    transition: background .2s ease, color .2s ease;
  }
  .nav-icon-btn:hover{
    background: var(--cream-soft);
    color: var(--orange);
  }
  .nav-icon-btn img{
    width: 20px;
    height: 20px;
    object-fit: contain;
  }
  .nav-icon-badge{
    position: absolute;
    top: 0px;
    right: 0px;
    min-width: 16px;
    height: 16px;
    padding: 0 4px;
    border-radius: 999px;
    background: var(--orange);
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    line-height: 16px;
    text-align: center;
  }

  .hamburger{
    display:none;
    flex-direction:column;
    gap:5px;
    background:none;
    padding:6px;
  }
  .hamburger span{
    width:24px; height:2px; background:var(--ink); border-radius:2px;
    transition: all .25s ease;
  }

  /* ---------- HERO ---------- */
  .hero{
    position:relative;
    min-height: 90vh;
    padding: 40px 0;
    display: flex;
    background:
      linear-gradient(180deg, rgba(30,15,5,.55), rgba(30,15,5,.5)),
      url('{{ asset('images/herobaru.png') }}') center/cover no-repeat;
    color:#fff;
    text-align:center;
    align-items: center;
    justify-content: center;
  }

  .hero-inner{
    width: 100%;
  }

  .hero-copy{
    max-width:760px;
    margin:0 auto;
  }

  .hero-copy .eyebrow{
    display:inline-block;
    font-size:13px;
    font-weight:600;
    letter-spacing:.06em;
    text-transform:uppercase;
    color: var(--peach);
    margin-bottom:16px;
  }

  .hero-copy h1{
    font-family: var(--font-display);
    font-weight:800;
    font-size:40px;
    line-height:1.12;
    letter-spacing:-0.5px;
    color:#fff;
    margin-bottom:22px;
  }

  .hero-copy p{
    font-size:14px;
    color: rgba(255,255,255,.92);
    max-width: 560px;
    margin:0 auto 32px;
  }

  .hero-actions{
    display:flex;
    gap:16px;
    flex-wrap:wrap;
    justify-content:center;
  }

  .hero .btn-outline{
    border-color: rgba(255,255,255,.65);
    color:#fff;
  }
  .hero .btn-outline:hover{
    background: rgba(255,255,255,.12);
    border-color:#fff;
  }

  /* ---------- PRODUCTS ---------- */
  .section{ padding: 64px 0; }

  .section-head{
    text-align:center;
    max-width:640px;
    margin:0 auto 56px;
  }

  .section-head .kicker{
    font-family: var(--font-display);
    font-weight:800;
    font-size:26px;
    margin-bottom:14px;
    color: var(--ink);
  }
  .section-head .kicker .accent{ color: var(--orange); }

  .section-head p{
    color: var(--ink-soft);
    font-size:15px;
  }

  .products-grid{
    display:grid;
    grid-template-columns: repeat(3, 1fr);
    gap:24px;
  }

  .product-card{
    display:flex;
    flex-direction:column;
    width: 100%;
  }

  .product-media{
    position:relative;
    border-radius: var(--radius-lg);
    overflow:hidden;
    aspect-ratio: 1/1;
    width: 100%;
    margin: 0 0 12px 0;
    background: #eee;
    max-height: 300px;
  }
  .product-media img{
    width:100%; height:100%; object-fit:cover;
    transition: transform .5s ease;
  }
  .product-card:hover .product-media img{ transform: scale(1.06); }

  .tag{
    position:absolute;
    top:16px; left:16px;
    background: var(--orange);
    color:#fff;
    font-size:11px;
    font-weight:700;
    letter-spacing:.04em;
    padding:6px 14px;
    border-radius: var(--radius-pill);
    text-transform:uppercase;
  }

  .product-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
    padding: 0 10px;
  }

  .product-row h3{
    font-family: var(--font-display);
    font-weight:700;
    font-size:17px;
    color: var(--ink);
  }

  .price{
    font-family: var(--font-display);
    font-weight:700;
    font-size:14.5px;
    color: var(--orange-dark);
    white-space:nowrap;
    text-align:right;
  }

  .product-card .desc{
    font-size:14px;
    color: var(--ink-soft);
    margin-top:6px;
    padding: 0 10px;
    width: 100%;
    max-width:100%;
  }

  .section-cta{
    text-align:center;
    margin-top:56px;
  }

  .link-cta{
    font-weight:700;
    font-size:13.5px;
    letter-spacing:.06em;
    text-transform:uppercase;
    color: var(--orange-dark);
    border-bottom:2px solid transparent;
    padding-bottom:4px;
    transition: border-color .2s ease;
  }
  .link-cta:hover{ border-color: var(--orange-dark); }

  /* ---------- QUALITY (peach) ---------- */
  .quality{
    background: linear-gradient(180deg, var(--cream) 0%, var(--peach) 50%, var(--cream) 100%);
    padding: 100px 0;
    position:relative;
    overflow:hidden;
  }

  .quality-inner{
    max-width:720px;
    margin:0 auto;
    text-align:center;
    position:relative;
    z-index:1;
  }

  .quality h2{
    font-family: var(--font-display);
    font-weight:800;
    font-size:28px;
    margin-bottom:32px;
  }
  .quality h2 .accent{ color: var(--brown-dark); }
  .quality h2 .dark{ color: var(--ink); }

  .quality p{
    font-size:14px;
    color: var(--ink-soft);
    margin-bottom:22px;
  }

  .quality .cta-link{
    display:inline-block;
    margin-top:20px;
    font-weight:700;
    font-size:14px;
    letter-spacing:.04em;
    color: var(--brown-dark);
    border-bottom: 2px solid var(--brown-dark);
    padding-bottom:4px;
  }

  /* ---------- TESTIMONIALS ---------- */
  .testimonials{ padding: 72px 0; }

  .testi-grid{
    display:grid;
    grid-template-columns: 1.05fr 0.95fr;
    gap:28px;
    margin-top:20px;
  }

  .testi-card{
    background: var(--cream);
    box-shadow: 0 14px 30px rgba(59, 31, 20, 0.15);
    border-radius: var(--radius-lg);
    padding:32px;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    min-height:200px;
    transition: transform .2s ease, box-shadow .2s ease;
  }
  .testi-card:hover{
    transform: translateY(-6px);
    box-shadow: 0 18px 32px -16px rgba(60,30,10,.28);
  }
  .testi-card blockquote{
    font-family: var(--font-display);
    font-style:italic;
    font-weight:500;
    font-size:16px;
    line-height:1.5;
    color: var(--ink);
    margin-bottom:28px;
  }

  .testi-author{
    display:flex;
    align-items:center;
    gap:14px;
  }

  .avatar{
    width:44px; height:44px;
    border-radius:50%;
    background: linear-gradient(135deg,#f3b6a8,#e88a76);
    flex:none;
  }

  .testi-author .name{
    font-weight:700;
    font-size:14.5px;
    color: var(--brown-dark);
  }
  .testi-author .role{
    font-size:12px;
    letter-spacing:.05em;
    text-transform:uppercase;
    color: var(--ink-soft);
  }

  /* ---------- FOOTER ---------- */
  footer{
    background: var(--footer);
    color: var(--footer-soft);
    padding: 48px 0 0;
  }

  .footer-grid{
    display:grid;
    grid-template-columns: 1.4fr 1fr 1fr;
    gap:40px;
    padding-bottom:50px;
    border-bottom:1px solid rgba(255,255,255,.08);
  }

  .footer-brand h3{
    font-family: var(--font-display);
    font-weight:800;
    color:#fff;
    font-size:19px;
    margin-bottom:16px;
  }
  .footer-brand p{
    font-size:13.5px;
    line-height:1.7;
    max-width:320px;
    margin-bottom:22px;
  }

  .socials{ display:flex; gap:10px; }
  .socials a{
    width:32px; 
    height:32px;
    border-radius:50%;
    background:#fff;
    display:flex; align-items:center; justify-content:center;
    transition: transform .2s ease;
    overflow: hidden;
  }
  .socials a:hover{ transform: translateY(-3px); }
  .socials a img{
  width:16px;                   
  height:16px;
  object-fit:contain;
  }

  footer h4{
    color:#fff;
    font-family: var(--font-display);
    font-weight:700;
    font-size:14px;
    margin-bottom:20px;
  }

  footer .footer-links li{ margin-bottom:14px; }
  footer .footer-links a{
    font-size:13px;
    transition: color .2s ease;
  }
  footer .footer-links a:hover{ color:#fff; }

  .footer-bottom{
    text-align:center;
    font-size:13px;
    padding:26px 0;
    color: rgba(255,255,255,.5);
  }

  /* ---------- RESPONSIVE ---------- */
  @media (max-width: 980px){
    .container{ padding:0 28px; }
    .nav-links{ display:none; }
    .hamburger{ display:flex; }
    .hero-copy h1{ font-size:32px; }
    .products-grid{ grid-template-columns:1fr; }
    .testi-grid{ grid-template-columns:1fr; }
    .footer-grid{ grid-template-columns:1fr; gap:32px; }
    .quality h2{ font-size:28px; }
  }

  @media (max-width: 560px){
    .hero{ padding:110px 0 90px; }
    .hero-copy h1{ font-size:30px; }
    .section{ padding:64px 0; }
    .testi-card{ padding:24px; }
  }

  /* mobile nav */
  .mobile-menu{
    display:none;
    flex-direction:column;
    gap:18px;
    padding: 20px 28px 28px;
    background: var(--cream-soft);
    border-top:1px solid rgba(0,0,0,.06);
  }
  .mobile-menu.open{ display:flex; }
  .mobile-menu a{ font-weight:600; font-size:15px; }

  /* reveal animation */
  .reveal{
    opacity:0;
    transform: translateY(24px);
    transition: opacity .7s ease, transform .7s ease;
  }
  .reveal.in-view{
    opacity:1;
    transform:none;
  }
</style>
@stack('styles')
</head>
<body class="@yield('body-class')">

@include('partials.navbarlogin')

<main>
@yield('content')
</main>

@include('partials.footerlogin')

<script>
  // Mobile menu toggle
  const hamburgerBtn = document.getElementById('hamburgerBtn');
  const mobileMenu = document.getElementById('mobileMenu');
  hamburgerBtn.addEventListener('click', () => {
    mobileMenu.classList.toggle('open');
  });
  mobileMenu.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => mobileMenu.classList.remove('open'));
  });

  // Active nav link sudah ditentukan lewat Blade (request()->routeIs()) di partials/navbar.blade.php

  // Scroll reveal
  const revealEls = document.querySelectorAll('.reveal');
  const io = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('in-view');
        io.unobserve(entry.target);
      }
    });
  }, { threshold: 0.15 });
  revealEls.forEach(el => io.observe(el));

  // Dipakai halaman yang membuat elemen .reveal lewat JS (mis. kartu testimoni)
  // setelah script ini jalan, supaya elemen itu tetap ikut ter-observe.
  window.observeReveal = (el) => io.observe(el);
</script>

@stack('scripts')

</body>
</html>