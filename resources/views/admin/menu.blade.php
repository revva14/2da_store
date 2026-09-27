<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Menu & Stok Jajanan - 2da Store</title>
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
            --blue: #3d78c9;
            --line: #f1e4d8;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { background: var(--bg); color: var(--ink); font-family: 'Outfit', system-ui, sans-serif; }
        a { text-decoration: none; color: inherit; }
        svg { display: block; }
        button { font-family: inherit; }

        .layout { display: flex; min-height: 100vh; }
        .main { flex: 1; padding: 19px 26px 51px; min-width: 0; }
        .card { background: var(--card); border-radius: 19px; box-shadow: 0 5px 19px rgba(180,110,50,.07); }

        /* ===== HEADER ===== */
        .head { display: flex; justify-content: space-between; align-items: flex-start; margin-top: 6px; gap: 19px; }
        .head h1 { font-size: 24px; font-weight: 600; letter-spacing: -.01em; margin-top: 6px; }
        .head p { color: var(--muted); font-size: 12px; line-height: 1.45; max-width: 380px; margin-top: 5px; }
        .head-actions { display: flex; gap: 11px; }
        .btn { display: flex; align-items: center; justify-content: center; gap: 8px; padding: 12px 20px; border-radius: 11px; font-size: 12.5px; font-weight: 500; border: 0; cursor: pointer; text-align: center; line-height: 1.25; transition: transform .25s, box-shadow .25s, background .25s; }
        .btn:hover { transform: translateY(-2px); }
        .btn-soft { background: #f3e6da; color: var(--muted); }
        .btn-soft:hover { background: #ecd9c8; }
        .btn-orange { background: var(--orange); color: #fff; box-shadow: 0 5px 12px rgba(255,138,61,.35); }
        .btn-orange:hover { box-shadow: 0 8px 16px rgba(255,138,61,.4); }

        /* ===== STATS ===== */
        .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-top: 26px; }
        .stat { padding: 16px 16px 19px; transition: transform .3s, box-shadow .3s; animation: rise .6s ease both; border-radius: 19px; }
        .stat:hover { transform: translateY(-4px); box-shadow: 0 10px 24px rgba(180,110,50,.14); }
        .stat:nth-child(2) { animation-delay: .08s; } .stat:nth-child(3) { animation-delay: .16s; } .stat:nth-child(4) { animation-delay: .24s; }
        .stat-top { display: flex; justify-content: space-between; align-items: center; }
        .sico { width: 35px; height: 35px; border-radius: 11px; display: grid; place-items: center; color: var(--brown); }
        .sico.a { background: #fbe6d8; } .sico.b { background: #fbe9b8; } .sico.c { background: #fdf0c8; } .sico.d { background: #fbe0e0; color: #c0182b; }
        .chip { font-size: 9px; font-weight: 600; padding: 3px 8px; border-radius: 8px; }
        .chip.a { background: #fbe6d8; color: var(--brown); }
        .chip.b { background: #fbedb5; color: #8a5a0a; }
        .chip.c { background: #fdf0c8; color: #8a5a0a; }
        .chip.d { background: #fbdcdc; color: var(--red); }
        .stat .num { font-size: 30px; font-weight: 600; line-height: 1.1; margin-top: 12px; }
        .stat .num.red { color: var(--red); }
        .stat .row { display: flex; justify-content: space-between; align-items: baseline; font-size: 10.5px; margin-top: 2px; }
        .stat .row b { font-weight: 500; }
        .stat .row span { color: var(--muted); }
        .stat .row span.red { color: var(--red); font-weight: 600; }
        .stat .row span.dark { color: var(--ink); font-weight: 600; }
        .prog { height: 5px; border-radius: 4px; background: #f1ece7; margin-top: 9px; overflow: hidden; }
        .prog span { display: block; height: 100%; border-radius: 4px; transform-origin: left; animation: grow 1.2s ease both; transition: width .3s ease; }

        /* ===== FILTER ===== */
        .filter { padding: 16px; margin-top: 26px; }
        .f-top { display: flex; justify-content: space-between; align-items: center; gap: 16px; }
        .f-search { display: flex; align-items: center; gap: 10px; background: #fdf1e6; border-radius: 11px; padding: 10px 13px; width: 512px; max-width: 100%; color: var(--muted); }
        .f-search input { border: 0; outline: 0; background: transparent; font: inherit; font-size: 12px; width: 100%; color: var(--ink); }
        .f-search input::placeholder { color: #a99b92; }
        .f-count { font-size: 10.5px; font-weight: 500; padding-right: 10px; border-right: 1px solid var(--line); white-space: nowrap; }
        .f-row { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
        .f-label { font-size: 9.5px; font-weight: 600; letter-spacing: .05em; color: var(--muted); margin-right: 4px; }
        .f-title { display: flex; justify-content: space-between; margin-top: 18px; }
        .f-title small { font-size: 9.5px; font-weight: 400; color: var(--muted); letter-spacing: 0; }
        .fchip { border: 0; background: #fdf1e6; font-size: 9.5px; font-weight: 500; padding: 6px 13px; border-radius: 16px; display: flex; align-items: center; gap: 5px; color: var(--ink); cursor: pointer; transition: background .2s, transform .2s; }
        .fchip:hover { background: #fae4d0; transform: translateY(-1px); }
        .fchip.active { background: #7a5346; color: #fff; font-weight: 600; }
        .fchip.soft-active { background: #f3e6da; font-weight: 600; }
        .fchip i { width: 6px; height: 6px; border-radius: 50%; display: inline-block; }
        .f-status { margin-top: 14px; }

        /* ===== TABLE ===== */
        .list { margin-top: 26px; border-radius: 19px; overflow: hidden; background: #fff; box-shadow: 0 5px 19px rgba(180,110,50,.07); }
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        thead th { background: #fbeadb; font-size: 9.5px; font-weight: 600; letter-spacing: .06em; color: var(--muted); padding: 16px 10px; text-align: center; line-height: 1.4; }
        thead th:first-child { text-align: left; padding-left: 24px; }
        thead th:nth-child(1) { width: 30%; }
        thead th:nth-child(2) { width: 13%; }
        thead th:nth-child(3) { width: 12%; }
        thead th:nth-child(4) { width: 20%; }
        thead th:nth-child(5) { width: 13%; }
        thead th:nth-child(6) { width: 12%; }
        tbody tr { transition: background .2s; animation: rise .5s ease both; }
        tbody tr:hover { background: #fffaf5; }
        tbody tr.hidden { display: none !important; }
        tbody td { padding: 14px 10px; border-bottom: 1px solid var(--line); text-align: center; vertical-align: middle; }
        tbody td:first-child { text-align: left; padding-left: 24px; }
        .prod { display: flex; align-items: center; gap: 12px; }
        .thumb { width: 45px; height: 45px; border-radius: 11px; background: #f5ebe0; overflow: hidden; flex-shrink: 0; }
        .thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .prod strong { display: block; font-size: 13px; font-weight: 600; }
        .prod .desc-mini { display: block; font-size: 10.5px; color: var(--muted); margin-top: 2px; max-width: 260px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .sku { display: flex; align-items: center; gap: 8px; margin-top: 3px; font-size: 10px; }
        .sku b { font-size: 9px; font-weight: 700; color: var(--brown); background: #fbe6d8; padding: 2px 7px; border-radius: 4px; }
        .sku span { color: var(--muted); }
        .sku span.hot { color: var(--brown); font-weight: 500; }
        .cat { display: inline-flex; align-items: center; gap: 6px; font-size: 9.5px; font-weight: 500; line-height: 1.25; text-align: left; padding: 6px 13px; border-radius: 14px; background: #fbe6d8; color: var(--muted); }
        .cat.manis { background: #fbedb5; color: #7a4a0a; }
        .cat.minuman { background: #dbe9fa; color: #2f5c9c; }
        .price strong { display: block; font-size: 15px; font-weight: 600; line-height: 1.2; }
        .price small { display: block; font-size: 9.5px; color: var(--muted); margin-top: 3px; line-height: 1.4; }
        .stepper { display: inline-flex; align-items: center; background: #fdf1e6; border-radius: 12px; padding: 4px; gap: 10px; box-shadow: inset 0 0 0 2px #fbeadb; }
        .stepper button { width: 24px; height: 24px; border-radius: 8px; border: 0; background: #fff; font-size: 13px; color: var(--ink); cursor: pointer; display: grid; place-items: center; transition: background .2s, transform .2s; }
        .stepper button:hover { background: #fae4d0; transform: scale(1.08); }
        .stepper .qty { min-width: 22px; text-align: center; font-size: 13px; font-weight: 500; }
        .stepper.low .qty { color: var(--brown); }
        .stepper.empty .qty { color: var(--red); font-weight: 700; }
        .stock-badge { display: inline-flex; align-items: center; gap: 5px; margin-top: 6px; font-size: 9px; font-weight: 500; padding: 3px 10px; border-radius: 10px; background: #edf3e6; color: #4a6a2a; }
        .stock-badge i { width: 5px; height: 5px; border-radius: 50%; background: var(--green); }
        .stock-badge.warn { background: #fdf0c8; color: #8a5a0a; }
        .stock-badge.warn i { background: #f5b731; }
        .stock-badge.danger { background: #fbdcdc; color: var(--red); }
        .stock-badge.danger i { background: var(--red); }
        .stock-box { display: flex; flex-direction: column; align-items: center; }
        .sw { display: flex; flex-direction: column; align-items: center; gap: 6px; font-size: 9.5px; color: var(--muted); }
        .switch { position: relative; width: 34px; height: 21px; border-radius: 12px; background: var(--green); border: 0; cursor: pointer; transition: background .25s; }
        .switch::after { content: ''; position: absolute; top: 2px; right: 2px; width: 17px; height: 17px; border-radius: 50%; background: #fff; transition: right .25s; }
        .switch.off { background: #d8ccc3; }
        .switch.off::after { right: 15px; }
        .actions { display: flex; justify-content: center; gap: 16px; color: var(--muted); }
        .actions a, .actions button { background: none; border: 0; color: inherit; cursor: pointer; transition: color .2s, transform .2s; }
        .actions a:hover { color: var(--brown); transform: translateY(-2px); }
        .actions button:hover { color: var(--red); transform: translateY(-2px); }

        .list-foot { display: flex; justify-content: space-between; align-items: center; background: #fdf1e6; padding: 13px 13px; font-size: 10px; color: var(--muted); }
        .list-foot .left { display: flex; align-items: center; gap: 8px; }
        .list-foot .sel { background: #fff; color: var(--ink); font-weight: 600; padding: 5px 13px; border-radius: 8px; min-width: 80px; }
        .pager { display: flex; gap: 6px; align-items: center; }
        .pager span { min-width: 26px; height: 26px; border-radius: 8px; background: #fff; font-size: 10px; font-weight: 600; color: var(--ink); display: grid; place-items: center; padding: 0 10px; cursor: pointer; transition: background .2s; }
        .pager span:hover { background: #fae4d0; }
        .pager span.on { background: var(--orange); color: #fff; }
        .pager span.dis { background: transparent; color: #a99b92; font-weight: 500; cursor: default; }

        .no-data { text-align: center; padding: 30px !important; color: var(--muted); font-size: 13px; font-weight: 500; }
        .flash { margin-top: 20px; padding: 12px 18px; border-radius: 12px; background: #e9f3e0; color: #3f6a26; font-size: 12.5px; font-weight: 500; }


        /* ===== MODAL TAMBAH / EDIT MENU ===== */
        .menu-modal {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .menu-modal.show { display: flex; }
        .menu-modal-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(31, 20, 16, .48);
            backdrop-filter: blur(3px);
        }
        .menu-modal-card {
            position: relative;
            z-index: 1;
            width: min(920px, 96vw);
            height: min(820px, 92vh);
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 24px 70px rgba(31,20,16,.25);
            display: flex;
            flex-direction: column;
            animation: modalIn .22s ease both;
        }
        .menu-modal-head {
            min-height: 58px;
            padding: 12px 18px 12px 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            border-bottom: 1px solid var(--line);
            background: #fffaf5;
        }
        .menu-modal-title {
            font-size: 15px;
            font-weight: 600;
        }
        .menu-modal-subtitle {
            color: var(--muted);
            font-size: 10.5px;
            margin-top: 2px;
        }
        .menu-modal-close {
            width: 34px;
            height: 34px;
            border: 0;
            border-radius: 10px;
            background: #f3e6da;
            color: var(--muted);
            cursor: pointer;
            display: grid;
            place-items: center;
            transition: .2s;
            flex-shrink: 0;
        }
        .menu-modal-close:hover {
            background: #ecd9c8;
            color: var(--ink);
            transform: scale(1.04);
        }
        .menu-modal-body {
            flex: 1;
            min-height: 0;
            background: #fff;
        }
        .menu-modal-body iframe {
            width: 100%;
            height: 100%;
            border: 0;
            display: block;
            background: #fff;
        }
        body.modal-open { overflow: hidden; }

        @keyframes modalIn {
            from { opacity: 0; transform: translateY(10px) scale(.985); }
            to { opacity: 1; transform: none; }
        }

        @media (max-width: 600px) {
            .menu-modal { padding: 10px; }
            .menu-modal-card {
                width: 100%;
                height: 96vh;
                border-radius: 16px;
            }
        }

        /* ===== ANIMASI ===== */
        @keyframes rise { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: none; } }
        @keyframes grow { from { transform: scaleX(0); } to { transform: scaleX(1); } }
        tbody tr:nth-child(2) { animation-delay: .05s; } tbody tr:nth-child(3) { animation-delay: .1s; } tbody tr:nth-child(4) { animation-delay: .15s; }
        tbody tr:nth-child(5) { animation-delay: .2s; } tbody tr:nth-child(6) { animation-delay: .25s; } tbody tr:nth-child(7) { animation-delay: .3s; }

        @media (max-width: 1100px) {
            .stats { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 800px) {
            .head { flex-direction: column; }
            .list { overflow-x: auto; }
            .f-top { flex-direction: column; align-items: stretch; }
        }
    </style>
</head>
<body>
@php
    // Data sekarang datang dari database (tabel products), bukan array statis lagi.
    // $products dikirim dari App\Http\Controllers\Admin\MenuController@index

    $categoryMeta = \App\Models\Product::categoryMeta();

    $total       = $products->count();
    $lowCount    = $products->where('stock', '>', 0)->where('stock', '<', 10)->count();
    $emptyCount  = $products->where('stock', 0)->count();
    $catCounts   = $products->groupBy('cats')->map->count();
    $activeCats  = collect($categoryMeta)->filter(fn ($m, $key) => ($catCounts[$key] ?? 0) > 0)->count();
@endphp

<div class="layout">

    @include('partials.sidebaradmin')

    <main class="main">

        @include('partials.navbaradmin')

        <div class="head">
            <div>
                <h1>Kelola Menu Stok Jajanan</h1>
                <p>Atur varian produk, harga jual, deskripsi, foto, serta kendalikan ketersediaan stok gerai secara instan. Data di sini otomatis muncul di halaman menu pelanggan.</p>
            </div>
            <div class="head-actions">
                <a href="{{ url('/admin/kategori') }}" class="btn btn-soft">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3l4 7H8z"/><rect x="3" y="14" width="7" height="7" rx="1"/><circle cx="17.5" cy="17.5" r="3.5"/></svg>
                    Kelola<br>Kategori
                </a>
                <button type="button" class="btn btn-orange js-menu-modal" data-url="{{ url('/admin/menu/tambah') }}" data-title="Tambah Menu Baru">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 8v8M8 12h8"/></svg>
                    Tambah Menu<br>Baru
                </button>
            </div>
        </div>

        @if (session('success'))
            <div class="flash">{{ session('success') }}</div>
        @endif

        {{-- ===== STATISTIK ===== --}}
        <section class="stats">
            <div class="card stat">
                <div class="stat-top">
                    <div class="sico a"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 10a8 5 0 0116 0z"/><path d="M4 14h16M5 18h14"/></svg></div>
                </div>
                <div class="num" id="stat-total">{{ $total }}</div>
                <div class="row"><b>Total Menu Aktif</b><span id="stat-total-label">{{ $total }} Terdaftar</span></div>
                <div class="prog"><span style="width:100%; background:var(--orange)"></span></div>
            </div>
            <div class="card stat">
                <div class="stat-top">
                    <div class="sico b"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M4 12h16M12 3v18"/></svg></div>
                    <span class="chip b">{{ $activeCats }} Grup Aktif</span>
                </div>
                <div class="num">{{ count($categoryMeta) }}</div>
                <div class="row"><b>Kategori Menu</b><span>{{ $activeCats }} / {{ count($categoryMeta) }} Terisi</span></div>
                <div class="prog"><span style="width:{{ count($categoryMeta) ? round($activeCats / count($categoryMeta) * 100) : 0 }}%; background:var(--gold)"></span></div>
            </div>
            <div class="card stat">
                <div class="stat-top">
                    <div class="sico c"><svg width="19" height="19" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M12 3l10 18H2z"/><path d="M12 10v4M12 17v1" stroke="#fdf0c8" stroke-width="2"/></svg></div>
                    <span class="chip c">Segera Restok</span>
                </div>
                <div class="num" id="stat-low">{{ $lowCount }}</div>
                <div class="row"><b>Stok Menipis</b><span class="dark">&lt; 10 Porsi</span></div>
                <div class="prog"><span id="stat-low-bar" style="width:{{ $total ? round($lowCount / $total * 100) : 0 }}%; background:#f5b731"></span></div>
            </div>
            <div class="card stat">
                <div class="stat-top">
                    <div class="sico d"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 4h3l2.5 11h9L20 7H7"/><circle cx="10" cy="19" r="1.5"/><circle cx="17" cy="19" r="1.5"/></svg></div>
                    <span class="chip d">Perlu Tindakan</span>
                </div>
                <div class="num red" id="stat-empty">{{ $emptyCount }}</div>
                <div class="row"><b>Menu Habis ({{ $emptyCount }})</b><span class="red">Dapur Kosong</span></div>
                <div class="prog"><span id="stat-empty-bar" style="width:{{ $total ? round($emptyCount / $total * 100) : 0 }}%; background:var(--red)"></span></div>
            </div>
        </section>

        {{-- ===== FILTER ===== --}}
        <section class="card filter">
            <div class="f-top">
                <label class="f-search">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M20 20l-4-4"/></svg>
                    <input type="text" id="searchInput" placeholder="Cari nama jajanan, deskripsi, atau kode SKU...">
                </label>
                <span class="f-count" id="filterCount">Menampilkan {{ $total }} dari {{ $total }} Item</span>
            </div>

            <div class="f-title">
                <span class="f-label">KATEGORI MENU:</span>
                <small>Pilih untuk menyaring</small>
            </div>
            <div class="f-row f-category" style="margin-top:2px">
                <button class="fchip active" data-cat="all">Semua ({{ $total }})</button>
                @foreach ($categoryMeta as $key => $meta)
                    <button class="fchip" data-cat="{{ $key }}">{{ $meta['label'] }} ({{ $catCounts[$key] ?? 0 }})</button>
                @endforeach
            </div>

            <div class="f-row f-status">
                <button class="fchip soft-active" data-status="all">Semua Status</button>
                <button class="fchip" data-status="available"><i style="background:var(--green)"></i>Tersedia</button>
                <button class="fchip" data-status="low"><i style="background:#f5b731"></i>Menipis</button>
                <button class="fchip" data-status="empty"><i style="background:var(--red)"></i>Habis ({{ $emptyCount }})</button>
            </div>
        </section>

        {{-- ===== TABEL MENU ===== --}}
        <section class="list">
            <table>
                <thead>
                    <tr>
                        <th>PRODUK / SKU</th>
                        <th>KATEGORI</th>
                        <th>HARGA<br>JUAL</th>
                        <th>STOK</th>
                        <th>STATUS<br>JUAL</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody id="menuTableBody">
                    @foreach ($products as $p)
                        <tr data-id="{{ $p->id }}" data-category="{{ $p->cats }}">
                            <td>
                                <div class="prod">
                                    <div class="thumb"><img src="{{ $p->img_url }}" alt="{{ $p->name }}" loading="lazy"></div>
                                    <div>
                                        <strong class="item-nama">{{ $p->name }}</strong>
                                        <span class="desc-mini">{{ $p->desc }}</span>
                                        <div class="sku">
                                            <b class="item-sku">SKU: {{ $p->sku ?? '—' }}</b>
                                            <span class="{{ $p->is_hot ? 'hot' : '' }}">{{ $p->is_hot ? 'Favorit' : '' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="cat {{ $p->category_class }}"><span class="cat-text">{!! str_replace(' ', '<br>', e($p->category_label)) !!}</span></span></td>
                            <td>
                                <div class="price">
                                    <strong>Rp<br>{{ number_format($p->price, 0, ',', '.') }}</strong>
                                </div>
                            </td>
                            <td>
                                <div class="stock-box">
                                    <div class="stepper {{ $p->stock == 0 ? 'empty' : ($p->stock < 10 ? 'low' : '') }}">
                                        <button type="button" data-step="-1" aria-label="Kurangi stok">−</button>
                                        <span class="qty">{{ $p->stock }}</span>
                                        <button type="button" data-step="1" aria-label="Tambah stok">+</button>
                                    </div>
                                    <span class="stock-badge {{ $p->stock == 0 ? 'danger' : ($p->stock < 10 ? 'warn' : '') }}">
                                        <i></i>
                                        <em style="font-style:normal">
                                            @if($p->stock == 0)
                                                Stok Habis
                                            @elseif($p->stock < 10)
                                                Menipis: {{ $p->stock }} Porsi
                                            @else
                                                Tersedia ({{ $p->stock }})
                                            @endif
                                        </em>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="sw">
                                    <button type="button" class="switch {{ !$p->is_active ? 'off' : '' }}" aria-label="Status jual"></button>
                                    <span class="sw-label">{{ $p->is_active ? 'Tersedia' : 'Nonaktif' }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="actions">
                                    <button type="button" class="js-menu-modal" data-url="{{ url('/admin/menu/'.$p->id.'/edit') }}" data-title="Ubah Menu" aria-label="Ubah menu">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h12M3 11h8M3 16h6"/><path d="M14 20l1-4 6-6 3 3-6 6z" transform="translate(-2 -1)"/></svg>
                                    </button>
                                    <form action="{{ url('/admin/menu/'.$p->id) }}" method="POST" onsubmit="return confirm('Hapus menu ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" aria-label="Hapus menu">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7h16M9 7V4h6v3M6 7l1 13h10l1-13"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    <tr id="noDataRow" class="hidden">
                        <td colspan="6" class="no-data">Tidak ada menu yang sesuai dengan pencarian / filter.</td>
                    </tr>
                </tbody>
            </table>

            <div class="list-foot">
                <div class="left">
                    <span>Baris per halaman:</span>
                    <span class="sel">10 item</span>
                    <span style="margin-left:8px" id="footCount">{{ $total ? '1 - '.$total : '0' }} dari {{ $total }} menu</span>
                </div>
                <div class="pager">
                    <span class="dis">Sebelumnya</span><span class="on">1</span><span class="dis">Berikutnya</span>
                </div>
            </div>
        </section>

    </main>
</div>

<!-- Modal Tambah / Edit Menu -->
<div id="menuModal" class="menu-modal" aria-hidden="true">
    <div class="menu-modal-backdrop" data-close-menu-modal></div>
    <div class="menu-modal-card" role="dialog" aria-modal="true" aria-labelledby="menuModalTitle">
        <div class="menu-modal-head">
            <div>
                <div id="menuModalTitle" class="menu-modal-title">Tambah Menu Baru</div>
                <div class="menu-modal-subtitle">Form dibuka tanpa meninggalkan halaman menu.</div>
            </div>
            <button type="button" class="menu-modal-close" id="closeMenuModal" aria-label="Tutup">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M6 6l12 12M18 6L6 18"/>
                </svg>
            </button>
        </div>
        <div class="menu-modal-body">
            <iframe id="menuModalFrame" title="Form menu"></iframe>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // ===== MODAL TAMBAH / EDIT MENU =====
    var menuModal = document.getElementById('menuModal');
    var menuModalFrame = document.getElementById('menuModalFrame');
    var menuModalTitle = document.getElementById('menuModalTitle');
    var closeMenuModalBtn = document.getElementById('closeMenuModal');

    function closeMenuModal(reload) {
        menuModal.classList.remove('show');
        menuModal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-open');

        if (reload) {
            window.location.reload();
        }
    }

    function openMenuModal(url, title) {
        menuModalTitle.textContent = title || 'Kelola Menu';
        menuModalFrame.src = url;
        menuModal.classList.add('show');
        menuModal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');
    }

    document.querySelectorAll('.js-menu-modal').forEach(function (trigger) {
        trigger.addEventListener('click', function () {
            openMenuModal(trigger.dataset.url, trigger.dataset.title);
        });
    });

    closeMenuModalBtn.addEventListener('click', function () {
        closeMenuModal(false);
    });

    document.querySelectorAll('[data-close-menu-modal]').forEach(function (el) {
        el.addEventListener('click', function () {
            closeMenuModal(false);
        });
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && menuModal.classList.contains('show')) {
            closeMenuModal(false);
        }
    });

    // Setelah form di dalam iframe berhasil submit dan redirect ke halaman index,
    // tutup modal lalu refresh tabel agar data terbaru langsung terlihat.
    menuModalFrame.addEventListener('load', function () {
        try {
            var framePath = menuModalFrame.contentWindow.location.pathname;
            var isMenuIndex = /\/admin\/menu\/?$/.test(framePath);
            if (isMenuIndex && menuModal.classList.contains('show')) {
                closeMenuModal(true);
            }
        } catch (e) {
            // Aman diabaikan jika browser membatasi akses iframe.
        }
    });

    var rows = Array.from(document.querySelectorAll('#menuTableBody tr[data-id]'));
    var totalCount = rows.length;

    var searchInput = document.getElementById('searchInput');
    var filterCountEl = document.getElementById('filterCount');
    var footCountEl = document.getElementById('footCount');
    var noDataRow = document.getElementById('noDataRow');

    var selectedCategory = 'all';
    var selectedStatus = 'all';

    function updateStats() {
        var lowCount = 0;
        var emptyCount = 0;

        rows.forEach(function (row) {
            var qty = parseInt(row.querySelector('.qty').textContent, 10);
            if (qty === 0) emptyCount++;
            else if (qty < 10) lowCount++;
        });

        document.getElementById('stat-low').textContent = lowCount;
        document.getElementById('stat-empty').textContent = emptyCount;

        var lowPct = totalCount ? Math.round((lowCount / totalCount) * 100) : 0;
        var emptyPct = totalCount ? Math.round((emptyCount / totalCount) * 100) : 0;

        document.getElementById('stat-low-bar').style.width = lowPct + '%';
        document.getElementById('stat-empty-bar').style.width = emptyPct + '%';
    }

    function applyFilter() {
        var query = searchInput.value.toLowerCase().trim();
        var visibleCount = 0;

        rows.forEach(function (row) {
            var nama = row.querySelector('.item-nama').textContent.toLowerCase();
            var desc = row.querySelector('.desc-mini').textContent.toLowerCase();
            var sku = row.querySelector('.item-sku').textContent.toLowerCase();
            var category = row.getAttribute('data-category');
            var qty = parseInt(row.querySelector('.qty').textContent, 10);

            var matchSearch = nama.includes(query) || desc.includes(query) || sku.includes(query);
            var matchCategory = (selectedCategory === 'all') || (category === selectedCategory);

            var matchStatus = false;
            if (selectedStatus === 'all') matchStatus = true;
            else if (selectedStatus === 'available') matchStatus = qty >= 10;
            else if (selectedStatus === 'low') matchStatus = qty > 0 && qty < 10;
            else if (selectedStatus === 'empty') matchStatus = qty === 0;

            var show = matchSearch && matchCategory && matchStatus;
            row.classList.toggle('hidden', !show);
            if (show) visibleCount++;
        });

        noDataRow.classList.toggle('hidden', visibleCount !== 0);
        filterCountEl.textContent = 'Menampilkan ' + visibleCount + ' dari ' + totalCount + ' Item';
        footCountEl.textContent = (visibleCount > 0 ? '1 - ' + visibleCount : '0') + ' dari ' + totalCount + ' menu';

        updateStats();
    }

    searchInput.addEventListener('input', applyFilter);

    document.querySelectorAll('.f-category .fchip').forEach(function (chip) {
        chip.addEventListener('click', function () {
            document.querySelectorAll('.f-category .fchip').forEach(function (c) { c.classList.remove('active'); });
            chip.classList.add('active');
            selectedCategory = chip.getAttribute('data-cat');
            applyFilter();
        });
    });

    document.querySelectorAll('.f-status .fchip').forEach(function (chip) {
        chip.addEventListener('click', function () {
            document.querySelectorAll('.f-status .fchip').forEach(function (c) { c.classList.remove('soft-active'); });
            chip.classList.add('soft-active');
            selectedStatus = chip.getAttribute('data-status');
            applyFilter();
        });
    });

    // Stepper stok & switch status -> sekarang beneran disimpan ke server (AJAX)
    rows.forEach(function (row) {
        var productId = row.getAttribute('data-id');
        var stepper = row.querySelector('.stepper');
        var qtyEl = row.querySelector('.qty');
        var badge = row.querySelector('.stock-badge');
        var label = badge.querySelector('em');
        var sw = row.querySelector('.switch');
        var swLabel = row.querySelector('.sw-label');

        function renderStockUI(n, isActive) {
            stepper.classList.remove('low', 'empty');
            badge.classList.remove('warn', 'danger');

            if (n === 0) {
                stepper.classList.add('empty');
                badge.classList.add('danger');
                label.textContent = 'Stok Habis';
            } else if (n < 10) {
                stepper.classList.add('low');
                badge.classList.add('warn');
                label.textContent = 'Menipis: ' + n + ' Porsi';
            } else {
                label.textContent = 'Tersedia (' + n + ')';
            }

            sw.classList.toggle('off', !isActive);
            swLabel.textContent = isActive ? 'Tersedia' : 'Nonaktif';
        }

        row.querySelectorAll('.stepper button').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                var step = parseInt(btn.dataset.step, 10);

                fetch('/admin/menu/' + productId + '/stock', {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ step: step }),
                })
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    qtyEl.textContent = data.stock;
                    renderStockUI(data.stock, data.is_active);
                    applyFilter();
                })
                .catch(function () { alert('Gagal menyimpan perubahan stok. Coba lagi.'); });
            });
        });

        sw.addEventListener('click', function () {
            fetch('/admin/menu/' + productId + '/status', {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
            })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                sw.classList.toggle('off', !data.is_active);
                swLabel.textContent = data.is_active ? 'Tersedia' : 'Nonaktif';
            })
            .catch(function () { alert('Gagal menyimpan status jual. Coba lagi.'); });
        });
    });

    updateStats();
});
</script>
</body>
</html>