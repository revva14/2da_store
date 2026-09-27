<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Ulasan &amp; Feedback - 2da Store</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg: #fff6ee;
            --card: #ffffff;
            --ink: #1f1410;
            --muted: #6b5d55;
            --brown: #a34a0a;
            --orange: #ff8a3d;
            --orange-soft: #fde3d0;
            --cream: #fdf1e6;
            --green: #6f9b4f;
            --gold: #d6a63a;
            --red: #c0182b;
            --line: #f1e4d8;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { background: var(--bg); color: var(--ink); font-family: 'Outfit', system-ui, sans-serif; }
        a { text-decoration: none; color: inherit; }
        svg { display: block; }
        button, textarea { font-family: inherit; }

        .layout { display: flex; min-height: 100vh; }
        .main { flex: 1; padding: 19px 26px 51px; min-width: 0; }
        .card { background: var(--card); border-radius: 19px; box-shadow: 0 5px 19px rgba(180,110,50,.07); }

        /* ===== HEADER ===== */
        .head { display: flex; justify-content: space-between; align-items: flex-start; gap: 19px; margin-top: 4px; }
        .head h1 { font-size: 24px; font-weight: 600; letter-spacing: -.01em; margin-top: 4px; }
        .head p { color: var(--muted); font-size: 12px; line-height: 1.45; max-width: 380px; margin-top: 5px; }
        .btn-dl { display: flex; align-items: center; gap: 9px; background: #f0e3d6; color: var(--ink); padding: 11px 19px; border-radius: 11px; font-size: 12.5px; font-weight: 500; margin-top: 19px; transition: transform .25s, background .25s; }
        .btn-dl:hover { transform: translateY(-2px); background: #ead8c5; }

        /* ===== RINGKASAN ===== */
        .sum { display: grid; grid-template-columns: 1.35fr 1.75fr 1fr; gap: 19px; margin-top: 26px; align-items: start; }
        .box { padding: 19px; position: relative; overflow: hidden; animation: rise .6s ease both; }
        .box:nth-child(2) { animation-delay: .08s; } .box:nth-child(3) { animation-delay: .16s; }
        .box .ttl { font-size: 9.5px; font-weight: 600; letter-spacing: .04em; color: var(--ink); }
        .score { display: flex; align-items: baseline; gap: 8px; margin-top: 16px; position: relative; }
        .score strong { font-size: 32px; font-weight: 600; color: #7a5346; letter-spacing: .01em; }
        .score span { font-size: 15px; font-weight: 500; color: var(--muted); }
        .stars-row { display: flex; align-items: center; gap: 8px; margin-top: 4px; font-size: 11px; position: relative; }
        .stars { display: inline-flex; gap: 2px; color: #f5b731; font-size: 14px; letter-spacing: 1px; line-height: 1; }
        .stars .off { color: #ecd9c8; }
        .rec { font-size: 10px; color: var(--muted); line-height: 1.5; margin-top: 10px; position: relative; }
        .resp { display: flex; align-items: center; gap: 10px; border-top: 1px solid var(--line); margin-top: 22px; padding-top: 19px; }
        .resp .ic { width: 32px; height: 32px; border-radius: 10px; background: #edf3e6; color: #4a6a2a; display: grid; place-items: center; flex-shrink: 0; }
        .resp strong { display: block; font-size: 12px; font-weight: 600; }
        .resp small { display: block; font-size: 10px; color: var(--muted); line-height: 1.4; }
        .resp .good { margin-left: auto; background: #e6efd8; color: #4a6a2a; font-size: 9px; font-weight: 600; padding: 6px 9px; border-radius: 12px; line-height: 1.25; display: flex; align-items: center; gap: 5px; }
        .resp .good i { width: 5px; height: 5px; border-radius: 50%; background: var(--green); flex-shrink: 0; }

        .dist-head { display: flex; justify-content: space-between; font-size: 9.5px; }
        .dist-head span { font-weight: 400; color: var(--muted); }
        .dist { margin-top: 30px; display: flex; flex-direction: column; gap: 10px; }
        .dist-row { display: flex; align-items: center; gap: 8px; font-size: 9.5px; font-weight: 600; }
        .dist-row .n { width: 22px; display: flex; align-items: center; gap: 3px; }
        .dist-row .n em { color: #f5b731; font-style: normal; }
        .dist-row .track { flex: 1; height: 7px; border-radius: 5px; background: #f1ece7; overflow: hidden; margin-left: 12px; }
        .dist-row .track span { display: block; height: 100%; border-radius: 5px; transform-origin: left; animation: grow 1.2s ease both; }
        .dist-row .c { width: 28px; text-align: right; font-weight: 500; }
        .dist-pad { height: 28px; }

        .aspek { display: flex; flex-direction: column; gap: 14px; margin-top: 14px; }
        .aspek .a-row .top { display: flex; align-items: center; justify-content: space-between; gap: 8px; font-size: 10px; font-weight: 500; }
        .aspek .a-row .top span { display: flex; align-items: center; gap: 6px; line-height: 1.25; }
        .aspek .a-row .top svg { color: var(--brown); flex-shrink: 0; }
        .aspek .a-row .top b { font-weight: 600; }
        .aspek .bar { height: 5px; border-radius: 4px; background: #f1ece7; margin-top: 6px; overflow: hidden; }
        .aspek .bar span { display: block; height: 100%; border-radius: 4px; background: #8fb16a; transform-origin: left; animation: grow 1.2s ease both; }
        .aspek-note { text-align: center; font-size: 9.5px; color: var(--muted); line-height: 1.9; margin-top: 22px; }

        /* ===== FILTER ===== */
        .filter { margin-top: 26px; padding: 19px; }
        .f-main { display: flex; justify-content: space-between; align-items: center; gap: 16px; }
        .f-chips { display: flex; flex-wrap: wrap; gap: 10px; max-width: 470px; }
        .fchip { border: 0; background: #fdf1e6; font-size: 10px; font-weight: 500; padding: 7px 13px; border-radius: 16px; display: flex; align-items: center; gap: 5px; color: var(--ink); cursor: pointer; transition: background .2s, transform .2s; }
        .fchip:hover { background: #fae4d0; transform: translateY(-1px); }
        .fchip.active { background: #7a5346; color: #fff; font-weight: 600; }
        .fchip em { color: #f5b731; font-style: normal; }
        .fchip em.red { color: var(--red); }
        .f-status { display: flex; align-items: center; gap: 24px; }
        .f-status > span { font-size: 9.5px; font-weight: 500; color: var(--muted); line-height: 1.4; }
        .seg { display: flex; background: #f3e6da; border-radius: 12px; padding: 4px; gap: 4px; }
        .seg button { border: 0; background: transparent; font-size: 9.5px; font-weight: 500; color: var(--ink); padding: 8px 16px; border-radius: 9px; cursor: pointer; line-height: 1.25; display: flex; align-items: center; gap: 5px; transition: background .2s; }
        .seg button.active { background: #fff; font-weight: 600; box-shadow: 0 2px 5px rgba(0,0,0,.05); }
        .seg button b { background: var(--brown); color: #fff; font-size: 9px; font-weight: 600; border-radius: 10px; padding: 1px 6px; }
        .f-sub { display: flex; align-items: center; gap: 13px; border-top: 1px solid var(--line); margin-top: 19px; padding-top: 19px; }
        .f-search { display: flex; align-items: center; gap: 9px; background: #fdf1e6; border-radius: 10px; padding: 9px 13px; width: 230px; color: var(--muted); }
        .f-search input { border: 0; outline: 0; background: transparent; font: inherit; font-size: 10px; width: 100%; color: var(--ink); }
        .f-search input::placeholder { color: #a99b92; }
        .f-select { background: #fdf1e6; border-radius: 10px; padding: 9px 13px; font-size: 10px; font-weight: 500; }
        .f-select select { border: 0; outline: 0; background: transparent; font: inherit; font-size: 10px; font-weight: 500; color: var(--ink); cursor: pointer; }
        .f-sort { margin-left: auto; margin-right: 74px; font-size: 10px; display: flex; gap: 10px; }
        .f-sort b { font-weight: 600; }

        /* ===== ULASAN ===== */
        .review { margin-top: 19px; padding: 19px; position: relative; animation: rise .6s ease both; }
        .review.urgent { box-shadow: 0 0 0 1px #f0dccb, 0 5px 19px rgba(180,110,50,.07); }
        .r-head { display: flex; gap: 13px; align-items: flex-start; }
        .av { width: 40px; height: 40px; border-radius: 50%; background: #fbdcc8; color: var(--brown); font-size: 16px; font-weight: 600; display: grid; place-items: center; flex-shrink: 0; }
        .r-name { display: flex; align-items: center; gap: 7px; flex-wrap: wrap; }
        .r-name strong { font-size: 15px; font-weight: 600; }
        .tag { display: inline-flex; align-items: center; gap: 4px; font-size: 8.5px; font-weight: 600; padding: 3px 8px; border-radius: 10px; }
        .tag.ver { background: #edf3e6; color: #4a6a2a; }
        .tag.pin { background: #fbe6d8; color: var(--brown); }
        .tag.urg { background: #fbdcdc; color: var(--red); }
        .tag.urg i { width: 5px; height: 5px; border-radius: 50%; background: var(--red); }
        .r-meta { display: flex; align-items: center; gap: 8px; font-size: 9.5px; color: var(--muted); margin-top: 4px; }
        .r-meta b { font-size: 10px; font-weight: 600; color: var(--ink); }
        .r-meta .dot::before { content: '•'; margin-right: 2px; }
        .r-tools { position: absolute; top: 19px; right: 19px; display: flex; gap: 8px; }
        .tool { width: 21px; height: 21px; border-radius: 50%; background: #f7ede4; color: var(--muted); display: grid; place-items: center; border: 0; cursor: pointer; transition: background .2s, transform .2s; }
        .tool:hover { background: #fbdcc8; transform: scale(1.08); }
        .tool.on { background: #fbdcc8; color: var(--brown); }
        .items { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 12px; }
        .item { display: flex; align-items: center; gap: 6px; background: #fdf1e6; font-size: 9px; font-weight: 500; color: var(--muted); padding: 5px 11px; border-radius: 9px; }
        .r-text { font-size: 14px; line-height: 1.85; margin-top: 12px; max-width: 900px; }
        .photo { position: relative; width: 77px; height: 77px; border-radius: 10px; background: #d9c2ad; overflow: hidden; margin-top: 14px; }
        .photo img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }

        .reply { background: #f7ebdf; border-left: 3px solid var(--brown); border-radius: 10px; padding: 14px 16px; margin-top: 19px; }
        .reply .rh { display: flex; align-items: center; justify-content: space-between; }
        .reply .rh span { display: flex; align-items: center; gap: 9px; font-size: 10px; font-weight: 600; }
        .reply .rh i { width: 19px; height: 19px; border-radius: 50%; background: var(--brown); color: #fff; font-style: normal; font-size: 10px; display: grid; place-items: center; }
        .reply .rh small { font-size: 9.5px; color: var(--muted); font-weight: 400; }
        .reply p { font-size: 11px; line-height: 1.6; color: var(--muted); margin-top: 7px; max-width: 880px; }
        .reply .acts { display: flex; gap: 12px; margin-top: 7px; font-size: 9px; font-weight: 500; }
        .reply .acts a, .reply .acts button { display: flex; align-items: center; gap: 4px; transition: color .2s; background: none; border: 0; padding: 0; margin: 0; font: inherit; color: inherit; cursor: pointer; }
        .reply .acts a:first-child { color: var(--brown); }
        .reply .acts a:hover, .reply .acts button:hover { text-decoration: underline; }
        .reply .acts form { display: contents; }

        .form { background: #f7ebdf; border-radius: 12px; padding: 13px 13px 10px; margin-top: 19px; }
        .form .fh { display: flex; align-items: center; justify-content: space-between; font-size: 10px; font-weight: 600; }
        .form .fh span { display: flex; align-items: center; gap: 6px; }
        .tpl { display: flex; align-items: center; gap: 8px; font-size: 9px; font-weight: 500; color: var(--muted); }
        .tpl button { border: 0; background: #fff; color: var(--ink); font-size: 9px; font-weight: 500; padding: 5px 10px; border-radius: 8px; cursor: pointer; transition: background .2s; }
        .tpl button:hover { background: #fae4d0; }
        .form textarea { width: 100%; height: 51px; border: 0; outline: 0; resize: none; background: #fff; border-radius: 10px; padding: 11px 13px; font-size: 10.5px; margin-top: 10px; color: var(--ink); }
        .form textarea::placeholder { color: #a99b92; }
        .tpl.bottom { justify-content: center; margin-top: 12px; padding-bottom: 4px; }

        .foot { display: flex; justify-content: space-between; align-items: center; background: #fff; border-radius: 16px; padding: 13px 13px; margin-top: 26px; font-size: 10px; color: var(--muted); box-shadow: 0 5px 19px rgba(180,110,50,.07); }
        .pager { display: flex; gap: 8px; align-items: center; }
        .pager span { min-width: 25px; height: 25px; border-radius: 8px; background: #fdf1e6; font-size: 10px; font-weight: 600; color: var(--ink); display: grid; place-items: center; padding: 0 6px; cursor: pointer; transition: background .2s; }
        .pager span:hover { background: #fae4d0; }
        .pager span.on { background: var(--brown); color: #fff; }
        .pager span.dots { background: transparent; cursor: default; }
        .pager a { min-width: 25px; height: 25px; border-radius: 8px; background: #fdf1e6; font-size: 10px; font-weight: 600; color: var(--ink); display: grid; place-items: center; padding: 0 6px; cursor: pointer; transition: background .2s; text-decoration: none; }
        .pager a:hover { background: #fae4d0; }

        /* ===== ANIMASI ===== */
        @keyframes rise { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: none; } }
        @keyframes grow { from { transform: scaleX(0); } to { transform: scaleX(1); } }

        @media (max-width: 1100px) {
            .sum { grid-template-columns: 1fr; }
            .f-main { flex-direction: column; align-items: flex-start; }
        }
        @media (max-width: 800px) {
            .head { flex-direction: column; }
            .f-sub { flex-wrap: wrap; }
            .f-sort { margin: 0; }
            .r-tools { position: static; margin-top: 10px; }
        }
    </style>
</head>
<body>
<div class="layout">

    @include('partials.sidebaradmin')

    <main class="main">

        @include('partials.navbaradmin')

        <div class="head">
            <div>
                <h1>Kelola Ulasan &amp; Feedback</h1>
                <p>Pantau ulasan pelanggan, kelola reputasi citarasa, dan berikan tanggapan instan secara profesional.</p>
            </div>
            <a href="{{ route('admin.ulasan.unduh') }}" class="btn-dl">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3v12M7 10l5 5 5-5M4 20h16"/></svg>
                Unduh Rekap
            </a>
        </div>

        @if (session('success'))
            <p style="margin-top:14px; padding:12px 16px; border-radius:12px; background:#e6efd8; color:#4a6a2a; font-size:12.5px; font-weight:500;">{{ session('success') }}</p>
        @endif

        {{-- ===== RINGKASAN ===== --}}
        <section class="sum">
            <div class="card box b1">
                <div class="ttl">SKOR KEPUASAN KUMULATIF</div>
                <div class="score"><strong>{{ number_format($rataRata, 1) }}</strong><span>/5.0</span></div>
                <div class="stars-row">
                    <span class="stars">@for ($s = 1; $s <= 5; $s++)<span class="{{ $s <= round($rataRata) ? '' : 'off' }}">★</span>@endfor</span>
                    <span>{{ $totalUlasan }} Total Ulasan</span>
                </div>
                <p class="rec">{{ $totalUlasan ? round(($distribusi[5] + $distribusi[4]) / $totalUlasan * 100) : 0 }}% pembeli merekomendasikan jajanan &amp;<br>kopi 2da Store kepada kerabat terdekat.</p>
                <div class="resp">
                    <div class="ic"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v13H9l-5 4z"/><path d="M9 10l2 2 4-4"/></svg></div>
                    <div>
                        <strong>{{ $responseRate }}% Respons</strong>
                        <small>{{ $sudahDibalas }} dari {{ $totalUlasan }}<br>dibalas</small>
                    </div>
                    <span class="good"><i></i>{{ $responseRate >= 80 ? 'Sangat' : 'Perlu' }}<br>{{ $responseRate >= 80 ? 'Baik' : 'Ditingkatkan' }}</span>
                </div>
            </div>

            <div class="card box">
                <div class="dist-head"><div class="ttl">DISTRIBUSI RATING BINTANG</div><span>Semua Waktu</span></div>
                <div class="dist">
                    @php $warna = [5 => 'var(--orange)', 4 => '#fbb98a', 3 => 'var(--gold)', 2 => '#8a4a3a', 1 => 'var(--red)']; @endphp
                    @for ($bintang = 5; $bintang >= 1; $bintang--)
                        @php $persen = $totalUlasan ? round($distribusi[$bintang] / $totalUlasan * 100, 1) : 0; @endphp
                        <div class="dist-row"><span class="n">{{ $bintang }} <em>★</em></span><div class="track"><span style="width:{{ $persen }}%; background:{{ $warna[$bintang] }}"></span></div><span class="c">{{ $distribusi[$bintang] }}</span></div>
                    @endfor
                </div>
                <div class="dist-pad"></div>
            </div>

            <div class="card box">
                <div class="ttl">ASPEK PALING DISUKAI</div>
                <div class="aspek">
                    <div class="a-row">
                        <div class="top"><span><svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor"><path d="M6 2v8a2 2 0 002 2v10h2V12a2 2 0 002-2V2h-1.500v6h-1V2H8.500v6h-1V2zM17 2c-2 1.500-3 4-3 7 0 2 1 3 3 3v10h2V2z"/></svg>Rasa Makanan &amp;<br>Minuman</span><b>4.9</b></div>
                        <div class="bar"><span style="width:98%"></span></div>
                    </div>
                    <div class="a-row">
                        <div class="top"><span><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 9h16v11H4zM3 6h18v3H3zM12 6v14M12 6c-1-3-5-3-5 0M12 6c1-3 5-3 5 0"/></svg>Kualitas Kemasan</span><b>4.8</b></div>
                        <div class="bar"><span style="width:96%"></span></div>
                    </div>
                    <div class="a-row">
                        <div class="top"><span><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>Kecepatan<br>Penyajian</span><b>4.7</b></div>
                        <div class="bar"><span style="width:94%"></span></div>
                    </div>
                </div>
                <div class="aspek-note">Diperbarui setiap batch<br>pesanan</div>
            </div>
        </section>

        {{-- ===== FILTER ===== --}}
        <form method="GET" action="{{ route('admin.ulasan') }}">
        <section class="card filter">
            <div class="f-main">
                <div class="f-chips" id="ratingChips">
                    <button type="submit" name="rating" value="" class="fchip {{ request('rating') ? '' : 'active' }}">Semua Rating ({{ $totalUlasan }})</button>
                    <button type="submit" name="rating" value="5" class="fchip {{ request('rating') === '5' ? 'active' : '' }}"><em>★</em> 5 Bintang ({{ $distribusi[5] }})</button>
                    <button type="submit" name="rating" value="4" class="fchip {{ request('rating') === '4' ? 'active' : '' }}"><em>★</em> 4 Bintang ({{ $distribusi[4] }})</button>
                    <button type="submit" name="rating" value="3" class="fchip {{ request('rating') === '3' ? 'active' : '' }}"><em>★</em> 3 Bintang ({{ $distribusi[3] }})</button>
                    <button type="submit" name="rating" value="1-2" class="fchip {{ request('rating') === '1-2' ? 'active' : '' }}"><em class="red">★</em> 1–2 Bintang ({{ $ratingSatuDua }})</button>
                </div>
                <div class="f-status">
                    <span>STATUS<br>BALASAN:</span>
                    <div class="seg" id="statusSeg">
                        <button type="submit" name="status" value="" class="{{ request('status') ? '' : 'active' }}">Semua</button>
                        <button type="submit" name="status" value="belum" class="{{ request('status') === 'belum' ? 'active' : '' }}">Belum<br>Dibalas <b>{{ $belumDibalas }}</b></button>
                        <button type="submit" name="status" value="sudah" class="{{ request('status') === 'sudah' ? 'active' : '' }}">Sudah<br>Dibalas</button>
                    </div>
                </div>
            </div>
            <div class="f-sub">
                <label class="f-search">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M20 20l-4-4"/></svg>
                    <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari ulasan, kata kunci, pembeli...">
                </label>
                <button type="submit" class="f-select" style="border:0; cursor:pointer;">Terapkan Pencarian</button>
                <div class="f-sort"><span>Urutkan:</span><b>Terbaru</b></div>
            </div>
        </section>
        </form>

        {{-- ===== DAFTAR ULASAN ===== --}}
        @forelse ($ulasan as $r)
            <article class="card review {{ $r->butuh_segera ? 'urgent' : '' }}" id="ulasan-{{ $r->id }}">
                <div class="r-head">
                    <div class="av">{{ $r->inisial }}</div>
                    <div>
                        <div class="r-name">
                            <strong>{{ $r->nama }}</strong>
                            <span class="tag ver"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><circle cx="12" cy="12" r="9"/><path d="M8 12l3 3 5-6"/></svg>Verified Buyer</span>
                            @if ($r->is_pinned)
                                <span class="tag pin"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M9 3h6l-1 6 3 3v2H7v-2l3-3zM12 14v7"/></svg>Disematkan di Beranda</span>
                            @endif
                            @if ($r->butuh_segera)
                                <span class="tag urg"><i></i>Butuh Balasan Segera</span>
                            @endif
                        </div>
                        <div class="r-meta">
                            <span class="stars" style="font-size:12px">@for ($s = 1; $s <= 5; $s++)<span class="{{ $s <= $r->rating ? '' : 'off' }}">★</span>@endfor</span>
                            <b>{{ number_format($r->rating, 1) }}</b>
                            <span class="dot">{{ $r->created_at->translatedFormat('d M Y, H:i') }} WIB</span>
                            @if ($r->no_pesanan)
                                <span class="dot">No. Pesanan: {{ $r->no_pesanan }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="r-tools">
                    <button type="button" class="tool tool-pin {{ $r->is_pinned ? 'on' : '' }}" data-id="{{ $r->id }}" aria-label="Sematkan di beranda">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor"><path d="M9 3h6l-1 6 3 3v2H7v-2l3-3z"/><path d="M12 14v7" stroke="currentColor" stroke-width="2"/></svg>
                    </button>
                </div>

                @if ($r->item_pesanan)
                    <div class="items">
                        @foreach ($r->item_pesanan as $it)
                            <span class="item"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="var(--brown)" stroke-width="2"><path d="M4 10a8 5 0 0116 0z"/><path d="M4 14h16M5 18h14"/></svg>{{ $it }}</span>
                        @endforeach
                    </div>
                @endif

                <p class="r-text">“{{ $r->komentar }}”</p>

                @if ($r->foto)
                    <div class="photo"><img src="{{ asset($r->foto) }}" alt="Foto ulasan {{ $r->nama }}" onerror="this.style.display='none'"></div>
                @endif

                @if ($r->sudah_dibalas)
                    <div class="reply" id="reply-view-{{ $r->id }}">
                        <div class="rh">
                            <span><i>2</i>Respon Resmi Toko (2da Store Admin)</span>
                            <small>{{ optional($r->balasan_at)->translatedFormat('d M Y, H:i') }} WIB</small>
                        </div>
                        <p>{{ $r->balasan }}</p>
                        <div class="acts">
                            <a href="#" onclick="event.preventDefault(); document.getElementById('reply-view-{{ $r->id }}').hidden = true; document.getElementById('reply-form-{{ $r->id }}').hidden = false;"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 20l1-5L17 3l4 4L9 19z"/></svg>Edit Balasan</a>
                            <form action="{{ route('admin.ulasan.balasan.hapus', $r) }}" method="POST" onsubmit="return confirm('Hapus balasan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7h16M9 7V4h6v3M6 7l1 13h10l1-13"/></svg>Hapus</button>
                            </form>
                        </div>
                    </div>
                @endif

                <form class="form" id="reply-form-{{ $r->id }}" action="{{ route('admin.ulasan.balas', $r) }}" method="POST" {{ $r->sudah_dibalas ? 'hidden' : '' }}>
                    @csrf
                    <div class="fh">
                        <span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 14L4 9l5-5M4 9h10a6 6 0 016 6v3"/></svg>{{ $r->sudah_dibalas ? 'Edit Balasan' : 'Balas Ulasan Pelanggan' }}</span>
                        <div class="tpl"><span>Template Cepat:</span><button type="button" data-tpl="Halo Kak {{ explode(' ', $r->nama)[0] }}! Terima kasih banyak atas ulasannya. Kami senang sekali Kakak menikmati jajanan 2da Store. Ditunggu orderan berikutnya ya kak!">+ Tanggapan Ramah</button><button type="button" data-tpl="Terima kasih atas masukannya, Kak {{ explode(' ', $r->nama)[0] }}. Evaluasi ini akan segera kami tindaklanjuti agar kualitas dan kemasan pesanan semakin baik.">+ Terima Kasih Evaluasi</button></div>
                    </div>
                    <textarea name="balasan" placeholder="Tulis balasan sopan dan ramah dari admin 2da Store...">{{ $r->sudah_dibalas ? $r->balasan : '' }}</textarea>
                    <div class="tpl bottom">
                        <span>Template Cepat:</span>
                        <button type="button" data-tpl="Halo Kak {{ explode(' ', $r->nama)[0] }}! Terima kasih banyak atas ulasannya. Kami senang sekali Kakak menikmati jajanan 2da Store. Ditunggu orderan berikutnya ya kak!">+ Tanggapan Ramah</button>
                        <button type="button" data-tpl="Terima kasih atas masukannya, Kak {{ explode(' ', $r->nama)[0] }}. Evaluasi ini akan segera kami tindaklanjuti agar kualitas dan kemasan pesanan semakin baik.">+ Terima Kasih Evaluasi</button>
                        <button type="submit" style="margin-left:auto; background:var(--brown); color:#fff; border:0; padding:8px 16px; border-radius:8px; font-size:9.5px; font-weight:600; cursor:pointer;">Kirim Balasan</button>
                    </div>
                </form>
            </article>
        @empty
            <div class="card" style="padding:30px; text-align:center; color:var(--muted); font-size:12.5px; margin-top:19px;">
                Belum ada ulasan yang cocok dengan filter ini.
            </div>
        @endforelse

        <div class="foot">
            <span>Menampilkan {{ $ulasan->firstItem() ?? 0 }} - {{ $ulasan->lastItem() ?? 0 }} dari {{ $ulasan->total() }} total ulasan</span>
            <div class="pager">{{ $ulasan->onEachSide(1)->links('vendor.pagination.pager') }}</div>
        </div>

    </main>
</div>

<script>
    // Template cepat: isi otomatis kotak balasan
    document.querySelectorAll('.form').forEach(function (form) {
        var area = form.querySelector('textarea');
        form.querySelectorAll('[data-tpl]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                area.value = btn.dataset.tpl;
                area.focus();
            });
        });
    });

    // Tombol sematkan: simpan ke server via AJAX supaya benar-benar tersimpan
    // dan langsung tampil di halaman testimoni user.
    var csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    document.querySelectorAll('.tool-pin').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var id = btn.dataset.id;
            fetch('/admin/ulasan/' + id + '/sematkan', {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
            })
                .then(function (res) { return res.json(); })
                .then(function (data) {
                    btn.classList.toggle('on', data.is_pinned);
                })
                .catch(function () {
                    alert('Gagal menyimpan status sematkan, coba lagi.');
                });
        });
    });
</script>
</body>
</html>