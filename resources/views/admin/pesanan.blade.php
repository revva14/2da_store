<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Pesanan - 2da Store</title>
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
            --line: #f1e4d8;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { background: var(--bg); color: var(--ink); font-family: 'Outfit', system-ui, sans-serif; }
        a { text-decoration: none; color: inherit; }
        svg { display: block; }
        button { font-family: inherit; }

        .layout { display: flex; min-height: 100vh; }
        .main { flex: 1; padding: 19px 25.5px 51px; min-width: 0; }
        .card { background: var(--card); border-radius: 19px; box-shadow: 0 5px 19px rgba(180,110,50,.07); }

        /* ===== HEADER ===== */
        .head { display: flex; justify-content: space-between; align-items: flex-start; margin-top: 6.5px; gap: 19px; }
        .head h1 { font-size: 24px; font-weight: 600; letter-spacing: -.01em; margin-top: 6.5px; }
        .head p { color: var(--muted); font-size: 12px; line-height: 1.45; max-width: 320px; margin-top: 5px; }
        .head-actions { display: flex; gap: 11px; }
        .btn { display: flex; align-items: center; gap: 6.5px; padding: 11px 14.5px; border-radius: 9.5px; font-size: 12px; font-weight: 500; border: 0; cursor: pointer; transition: transform .25s, box-shadow .25s, background .25s; }
        .btn:hover { transform: translateY(-2px); }
        .btn-brown { background: var(--brown); color: #fff; box-shadow: 0 5px 11px rgba(163,74,10,.3); }
        .btn-brown:hover { box-shadow: 0 8px 14.5px rgba(163,74,10,.35); }
        .btn-soft { background: #f3e6da; color: var(--ink); }
        .btn-soft:hover { background: #ecd9c8; }

        /* ===== STATS ===== */
        .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 13px; margin-top: 25.5px; }
        .stat { padding: 19px; display: flex; justify-content: space-between; align-items: center; gap: 9.5px; transition: transform .3s, box-shadow .3s; animation: rise .6s ease both; }
        .stat:hover { transform: translateY(-4px); box-shadow: 0 9.5px 24px rgba(180,110,50,.14); }
        .stat:nth-child(2) { animation-delay: .08s; } .stat:nth-child(3) { animation-delay: .16s; } .stat:nth-child(4) { animation-delay: .24s; }
        .stat .lbl { font-size: 9.5px; font-weight: 500; letter-spacing: .04em; color: var(--muted); }
        .stat .num { font-size: 32px; font-weight: 600; line-height: 1.1; margin-top: 3px; }
        .stat .num.brown { color: #7a5346; }
        .stat .num.money { font-size: 21px; line-height: 1.15; }
        .stat .note { display: flex; align-items: center; gap: 5px; font-size: 9.5px; font-weight: 500; margin-top: 5px; }
        .stat .note.brown { color: var(--brown); font-weight: 600; }
        .stat .note.green { color: var(--brown); font-weight: 600; }
        .sico { width: 38.5px; height: 38.5px; border-radius: 11px; display: grid; place-items: center; color: var(--brown); flex-shrink: 0; }
        .sico.a { background: #fcd9c8; } .sico.b { background: #fcd3c1; } .sico.c { background: #fbdcd0; } .sico.d { background: #fbe1a8; }
        .dot-b { width: 6.5px; height: 6.5px; border-radius: 50%; background: var(--brown); display: inline-block; animation: pulse 1.8s infinite; }

        /* ===== TABS ===== */
        .tabs { display: flex; flex-wrap: wrap; gap: 9.5px; margin-top: 22.5px; }
        .tab { display: flex; align-items: center; gap: 8px; background: #fff; border: 0; border-radius: 17.5px; padding: 9px 13px; font-size: 11px; font-weight: 500; color: var(--ink); cursor: pointer; transition: background .25s, transform .25s; }
        .tab:hover { transform: translateY(-2px); }
        .tab b { font-weight: 600; font-size: 10.5px; background: #f1ece7; border-radius: 9.5px; padding: 2px 7px; }
        .tab.active { background: #7a5346; color: #fff; }
        .tab.active b { background: rgba(255,255,255,.22); color: #fff; }
        .tab b.hot { background: var(--brown); color: #fff; }
        .tab b.red { background: #fbd9d9; color: #c0392b; }
        .tab .d { width: 6.5px; height: 6.5px; border-radius: 50%; background: var(--brown); }

        /* ===== BANNER ===== */
        .banner { display: flex; align-items: center; gap: 11px; background: #f5e6dc; border-radius: 14.5px; padding: 13px; margin-top: 19px; }
        .banner .bi { width: 32px; height: 32px; border-radius: 9.5px; background: var(--brown); color: #fff; display: grid; place-items: center; flex-shrink: 0; }
        .banner strong { display: block; font-size: 12px; font-weight: 600; }
        .banner span { font-size: 10px; color: var(--muted); }
        .banner .btn { margin-left: auto; padding: 8px 14.5px; font-size: 10.5px; }

        /* ===== BODY GRID ===== */
        .body-grid { display: grid; grid-template-columns: 1fr 277px; gap: 19px; margin-top: 19px; align-items: start; }
        .filter { padding: 11px; display: grid; grid-template-columns: 1.6fr 1fr 1fr; gap: 5px; border-radius: 16px; }
        .filter .f { display: flex; align-items: center; gap: 8px; background: #fdf1e6; border-radius: 9.5px; padding: 9.5px 11px; font-size: 10.5px; }
        .filter input { border: 0; outline: 0; background: transparent; font: inherit; font-size: 10.5px; width: 100%; color: var(--ink); }
        .filter input::placeholder { color: #a99b92; }
        .filter select { width: 100%; border: 0; outline: 0; background: transparent; font: inherit; font-size: 10.5px; font-weight: 500; color: var(--ink); cursor: pointer; }
        .filter .f.center { justify-content: center; }

        .list { margin-top: 13px; border-radius: 17.5px; overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        thead th { background: #fdf1e6; font-size: 9.5px; font-weight: 600; letter-spacing: .06em; color: var(--brown); padding: 14.5px 9.5px; text-align: left; }
        thead th:first-child { padding-left: 13px; }
        tbody tr { cursor: pointer; transition: background .2s; }
        tbody tr:hover { background: #fffaf5; }
        tbody tr.selected { background: #fffaf5; }
        tbody td { padding: 16px 9.5px; border-bottom: 1px solid var(--line); vertical-align: middle; font-size: 11px; }
        tbody td:first-child { padding-left: 13px; }
        .oid { width: 59px; }
        .oid strong { display: block; font-size: 12px; font-weight: 600; color: var(--brown); line-height: 1.3; }
        .oid.done strong { color: var(--ink); }
        .oid small { display: block; font-size: 10.5px; color: var(--muted); line-height: 1.5; }
        .oid .ago { display: flex; gap: 3px; align-items: flex-start; }
        .cust { display: flex; align-items: center; gap: 8px; width: 104px; }
        .av { width: 25.5px; height: 25.5px; border-radius: 50%; background: #fbd9c4; color: var(--brown); font-size: 9px; font-weight: 700; display: grid; place-items: center; flex-shrink: 0; }
        .cust strong { display: block; font-size: 10.5px; font-weight: 500; line-height: 1.3; }
        .cust small { display: block; font-size: 10.5px; color: var(--muted); line-height: 1.4; }
        .det { max-width: 160px; font-size: 12px; line-height: 1.4; }
        .det small { display: block; font-size: 10px; color: var(--muted); margin-top: 2px; }
        .tot strong { display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px; }
        .tot .tags { display: flex; gap: 5px; }
        .tag { font-size: 9.5px; font-weight: 500; padding: 4px 8px; border-radius: 11px; line-height: 1.25; text-align: center; }
        .tag.type { background: #f5e6dc; color: var(--muted); }
        .tag.pay { background: #fbd9c4; color: var(--brown); font-weight: 600; }
        .pill { display: inline-flex; align-items: center; gap: 6.5px; border-radius: 17.5px; padding: 8px 13px; font-size: 9px; font-weight: 700; letter-spacing: .04em; text-align: center; line-height: 1.2; }
        .pill i { width: 4px; height: 4px; border-radius: 50%; background: currentColor; flex-shrink: 0; }
        .pill.baru { background: var(--brown); color: #fff; }
        .pill.dapur { background: #fbe08a; color: #7a4a0a; }
        .pill.antar { background: #fbd9c4; color: var(--brown); }
        .pill.selesai { background: #f1ece7; color: var(--muted); }
        .list-foot { display: flex; justify-content: space-between; align-items: center; background: #fdf1e6; padding: 11px 13px; font-size: 10px; color: var(--muted); }
        .pager { display: flex; gap: 5px; align-items: center; }
        .pager span { min-width: 24px; height: 21px; border-radius: 6.5px; background: #fff; font-size: 9.5px; font-weight: 600; color: var(--ink); display: grid; place-items: center; padding: 0 6.5px; cursor: pointer; transition: background .2s; }
        .pager span:hover { background: #fae4d0; }
        .pager span.on { background: var(--brown); color: #fff; }

        /* ===== DETAIL TIKET ===== */
        .ticket { padding: 19px; animation: rise .6s .2s ease both; }
        .t-head { display: flex; justify-content: space-between; align-items: center; gap: 9.5px; }
        .t-head .ttl { display: flex; align-items: center; gap: 6.5px; }
        .t-head h3 { font-size: 16px; font-weight: 600; line-height: 1.2; }
        .badge-new { background: var(--brown); color: #fff; font-size: 9px; font-weight: 700; letter-spacing: .04em; border-radius: 11px; padding: 6.5px 11px; text-align: center; line-height: 1.25; }
        .t-id { display: flex; justify-content: space-between; align-items: flex-start; margin-top: 14.5px; gap: 6.5px; }
        .t-id h2 { font-size: 21px; font-weight: 600; }
        .t-id .time { font-size: 10.5px; color: var(--muted); margin-top: 3px; line-height: 1.6; }
        .t-id .right { text-align: right; }
        .pickup { background: #fbd9c4; color: var(--brown); font-size: 9.5px; font-weight: 500; padding: 6.5px 11px; border-radius: 13px; text-align: center; line-height: 1.3; }
        .t-id .qr { font-size: 9.5px; font-weight: 600; color: var(--brown); margin-top: 6.5px; line-height: 1.3; }
        .t-cust { display: flex; align-items: center; gap: 9.5px; background: #fbeadb; border-radius: 13px; padding: 13px; margin-top: 14.5px; }
        .t-cust .av { width: 32px; height: 32px; background: #7a5346; color: #fff; font-size: 12px; }
        .t-cust strong { display: block; font-size: 12px; font-weight: 600; }
        .t-cust small { font-size: 10.5px; color: var(--muted); }
        .t-cust .chat { margin-left: auto; width: 25.5px; height: 25.5px; border-radius: 8px; background: #fff; color: var(--brown); display: grid; place-items: center; }
        .t-items h4 { font-size: 10.5px; font-weight: 600; margin-top: 17.5px; }
        .item { display: flex; align-items: flex-start; gap: 8px; margin-top: 11px; }
        .item .q { font-size: 9.5px; font-weight: 600; color: var(--brown); background: #fbd9c4; border-radius: 5px; padding: 3px 5px; flex-shrink: 0; margin-top: 2px; }
        .item.plain .q { background: #f5e6dc; color: var(--muted); }
        .item .nm { flex: 1; font-size: 12px; line-height: 1.35; }
        .item .nm small { display: block; font-size: 10px; color: var(--muted); }
        .item .pr { font-size: 10.5px; font-weight: 500; }
        .note-box { background: #f5e6dc; border-radius: 11px; padding: 11px 13px; margin-top: 14.5px; }
        .note-box b { display: flex; align-items: center; gap: 5px; font-size: 9px; font-weight: 700; letter-spacing: .04em; color: var(--brown); }
        .note-box p { font-size: 10px; font-style: italic; color: var(--muted); line-height: 1.45; margin-top: 5px; }
        .sum { margin-top: 19px; display: flex; flex-direction: column; gap: 8px; font-size: 10px; color: var(--muted); }
        .sum div { display: flex; justify-content: space-between; }
        .sum .grand { color: var(--ink); font-size: 12px; font-weight: 600; margin-top: 3px; align-items: center; }
        .sum .grand span:last-child { color: var(--brown); font-size: 16px; }
        .t-actions { display: grid; grid-template-columns: 1.1fr 1fr; gap: 9.5px; margin-top: 19px; }
        .t-actions .btn { justify-content: center; font-size: 10.5px; padding: 11px 9.5px; text-align: center; line-height: 1.2; }
        .btn-red { background: #fbe0dc; color: #c0392b; }
        .btn-red:hover { background: #f8d0ca; }

        /* ===== ANIMASI ===== */
        @keyframes rise { from { opacity: 0; transform: translateY(13px); } to { opacity: 1; transform: none; } }
        @keyframes pulse { 0%,100% { box-shadow: 0 0 0 0 rgba(163,74,10,.4); } 50% { box-shadow: 0 0 0 5px rgba(163,74,10,0); } }

        @media (max-width: 1200px) {
            .stats { grid-template-columns: repeat(2, 1fr); }
            .body-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 800px) {
            .head { flex-direction: column; }
            .list { overflow-x: auto; }
        }
    
        /* ===== FUNGSI TAMBAHAN ===== */
        .pill.batal { background: #fbdcdc; color: #c0182b; }
        .badge-new.dapur { background: #fbe08a; color: #7a4a0a; }
        .badge-new.antar { background: #fbd9c4; color: var(--brown); }
        .badge-new.selesai { background: #f1ece7; color: var(--muted); }
        .badge-new.batal { background: #fbdcdc; color: #c0182b; }
        .pager span.dis { opacity: .4; cursor: not-allowed; }
        .pager span.dots { background: transparent; cursor: default; }
        .btn[disabled], .btn.is-disabled { opacity: .45; cursor: not-allowed; pointer-events: none; }
        .tab b { transition: transform .25s; }
        .tab b.bump { transform: scale(1.25); }
        tbody tr.empty td { text-align: center; color: var(--muted); font-size: 12px; padding: 32px 12px; cursor: default; }
        tbody tr.empty:hover { background: transparent; }
        .banner.hidden { display: none; }
        .t-actions { position: relative; }
        .alur-menu { position: absolute; right: 0; top: calc(50% + 4px); z-index: 5; background: #fff; border-radius: 12px; box-shadow: 0 10px 28px rgba(80,40,10,.18); padding: 6px; min-width: 190px; display: none; }
        .alur-menu.open { display: block; animation: rise .2s ease both; }
        .alur-menu button { display: block; width: 100%; text-align: left; border: 0; background: transparent; padding: 9px 12px; border-radius: 8px; font-size: 12px; font-weight: 500; color: var(--ink); cursor: pointer; }
        .alur-menu button:hover { background: #fdf1e6; }
        .alur-menu button.cur { color: var(--brown); font-weight: 700; }
        .toast { position: fixed; left: 50%; bottom: 24px; transform: translate(-50%, 20px); background: #2b1a10; color: #fff; padding: 11px 18px; border-radius: 12px; font-size: 12.5px; opacity: 0; pointer-events: none; transition: opacity .25s, transform .25s; z-index: 50; }
        .toast.show { opacity: 1; transform: translate(-50%, 0); }
        .item .pr { width: 46px; text-align: right; }
        .cust-link { display: contents; }

        /* ===== CETAK (slip dapur / batch thermal) ===== */
        #printArea { display: none; }
        .slip { width: 58mm; padding: 4mm 3mm; font-family: 'Courier New', monospace; font-size: 11px; color: #000; page-break-after: always; }
        .slip h4 { text-align: center; font-size: 13px; margin-bottom: 2px; }
        .slip .c { text-align: center; }
        .slip hr { border: 0; border-top: 1px dashed #000; margin: 5px 0; }
        .slip .row { display: flex; justify-content: space-between; gap: 6px; }
        .slip .note { margin-top: 4px; font-style: italic; }
        @media print {
            .layout, .toast { display: none !important; }
            #printArea { display: block; }
            body, html { background: #fff; }
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
                <h1>Kelola Pesanan</h1>
                <p>Pantau alur pesanan masuk, konfirmasi instan, serta kendali tiket cetak dapur.</p>
            </div>
            <div class="head-actions">
                <a href="{{ url('/admin/pesanan') }}" class="btn btn-brown" id="btnRefresh">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12a8 8 0 0113.7-5.6L20 9M20 4v5h-5M20 12a8 8 0 01-13.7 5.6L4 15M4 20v-5h5"/></svg>
                    Refresh Pesanan
                </a>
                <button type="button" class="btn btn-soft" id="btnBatch">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 8h8M8 12h8M8 16h5"/></svg>
                    Cetak Batch Thermal
                </button>
            </div>
        </div>

        {{-- ===== STATISTIK ===== --}}
        <section class="stats">
            <div class="card stat">
                <div>
                    <div class="lbl">PESANAN HARI INI</div>
                    <div class="num" id="statSemua">48</div>
                    <div class="note"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M3 17l6-6 4 4 8-8"/></svg>+18.4% vs kemarin</div>
                </div>
                <div class="sico a"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 3h12v18l-3-2-3 2-3-2-3 2z"/><path d="M9 8h6M9 12h6"/></svg></div>
            </div>
            <div class="card stat">
                <div>
                    <div class="lbl">PESANAN BARU</div>
                    <div class="num brown" style="color:var(--brown)" id="statBaru">6</div>
                    <div class="note brown"><i class="dot-b"></i>Butuh tanggapan</div>
                </div>
                <div class="sico b"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 16V11a6 6 0 0112 0v5l2 2H4z"/><path d="M10 21h4"/></svg></div>
            </div>
            <div class="card stat">
                <div>
                    <div class="lbl">DIPROSES DAPUR</div>
                    <div class="num brown" id="statDapur">12</div>
                    <div class="note"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 3v5M12 3v5M16 3v5M4 12h16l-2 8H6z"/></svg>Rata-rata 11 mnt</div>
                </div>
                <div class="sico c"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 4c-1 2 1 3 0 5M12 4c-1 2 1 3 0 5M16 4c-1 2 1 3 0 5M4 13h16a8 8 0 01-16 0z"/></svg></div>
            </div>
            <div class="card stat">
                <div>
                    <div class="lbl">OMSET TERKONFIRMASI</div>
                    <div class="num money">Rp<br>2.418.000</div>
                    <div class="note green"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="6" width="18" height="12" rx="2"/><circle cx="12" cy="12" r="2.5"/></svg>94% QRIS Settlement</div>
                </div>
                <div class="sico d"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 20V8l3-4h6l3 4v12z"/><path d="M8 12h8M8 16h8"/></svg></div>
            </div>
        </section>

        {{-- ===== TAB STATUS ===== --}}
        <div class="tabs" id="tabs">
            <button type="button" class="tab active" data-tab="semua">Semua Pesanan <b data-cnt="semua">48</b></button>
            <button type="button" class="tab" data-tab="baru"><i class="d"></i>Pesanan Baru <b class="hot" data-cnt="baru">6</b></button>
            <button type="button" class="tab" data-tab="dapur">Sedang Diproses <b data-cnt="dapur">12</b></button>
            <button type="button" class="tab" data-tab="antar">Siap Diambil/Diantar <b data-cnt="antar">8</b></button>
            <button type="button" class="tab" data-tab="selesai">Selesai <b data-cnt="selesai">20</b></button>
            <button type="button" class="tab" data-tab="batal">Dibatalkan <b class="red" data-cnt="batal">2</b></button>
        </div>

        {{-- ===== BANNER ===== --}}
        <div class="banner" id="banner">
            <div class="bi"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 8h14l-1 12H6z"/><path d="M9 8a3 3 0 016 0"/><path d="M9.5 14l2 2 3-3.5"/></svg></div>
            <div>
                <strong id="bannerTitle">6 Pesanan baru menanti konfirmasi kilat</strong>
                <span>Konfirmasi secepatnya agar tim barista &amp; juru masak 2da Store dapat mulai menyiapkan pesanan.</span>
            </div>
            <button type="button" class="btn btn-brown" id="btnTerimaSemua">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M2 13l4 4 8-9M12 15l2 2 8-9"/></svg>
                <span id="btnTerimaSemuaTxt">Terima Semua (6)</span>
            </button>
        </div>

        <div class="body-grid">

            {{-- ===== DAFTAR PESANAN ===== --}}
            <div>
                <div class="card filter">
                    <label class="f">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M20 20l-4-4"/></svg>
                        <input type="text" id="fSearch" placeholder="Cari ID pesanan, nama pembeli, atau menu...">
                    </label>
                    <div class="f center">
                        <select id="fTipe">
                            <option value="">Semua Tipe Ambil</option>
                            <option value="Pick-up">Pick-up</option>
                            <option value="Delivery">Delivery</option>
                        </select>
                    </div>
                    <div class="f center">
                        <select id="fBayar">
                            <option value="">Semua Pembayaran</option>
                            <option value="QRIS">QRIS</option>
                            <option value="COD">COD Tunai</option>
                        </select>
                    </div>
                </div>

                <div class="card list">
                    <table>
                        <thead>
                            <tr>
                                <th>ID &amp;<br>WAKTU</th>
                                <th>PELANGGAN</th>
                                <th>DETAIL PESANAN</th>
                                <th>TIPE &amp; TOTAL</th>
                                <th style="text-align:center">STATUS</th>
                            </tr>
                        </thead>
                        <tbody id="rows"></tbody>
                    </table>
                    <div class="list-foot">
                        <span id="listInfo">Menampilkan 4 dari 48 total pesanan aktif</span>
                        <div class="pager" id="pager"></div>
                    </div>
                </div>
            </div>

            {{-- ===== DETAIL TIKET (diisi otomatis oleh JS) ===== --}}
            <aside class="card ticket" id="ticket"></aside>
        </div>

    </main>
</div>

<div class="toast" id="toast" role="status" aria-live="polite"></div>
<div id="printArea"></div>

<script>
(function () {
    'use strict';

    /* ============ KONFIGURASI ============ */
    var CONFIG = {
        // Ubah ke true kalau route PATCH /admin/pesanan/{no}/status sudah dibuat di Laravel
        simpanKeServer: false,
        csrf: (document.querySelector('meta[name="csrf-token"]') || {}).content || '',
        urlStatus: function (no) { return '{{ url('/admin/pesanan') }}/' + encodeURIComponent(no) + '/status'; }
    };

    /* ============ DATA ============ */
    // Controller boleh mengirim $pesanan & $hitung; kalau tidak ada, dipakai data contoh sesuai desain.
    var DEMO_AWAL = [
        { no: '8921', id: '#2DA-8921', jam: '10:24', ago: '5 mnt lalu',  nama: 'Nisa Fitria',     hp: '0812-9844-3211', detail: '2× Corndog Mini Mozarella, 1× Pop Ice...', sub: '+1 Cireng Isi Mini', tipe: 'Pick-up',  bayar: 'QRIS Lunas', status: 'baru',
          catatan: 'Tolong corndog-nya digoreng fresh ya kak, saus keju dibanyakin. Terima kasih banyak!',
          items: [ { q: 2, n: 'Corndog Mini Mozarella', note: 'Saus Keju & Saus Sambal', h: 5000 }, { q: 1, n: 'Pop Ice Chocolate', note: 'Topping Choco Granule', h: 5000 }, { q: 1, n: 'Cireng Isi Mini', note: 'Isi Ayam Pedas Daun Jeruk', h: 5000 } ] },
        { no: '8920', id: '#2DA-8920', jam: '10:18', ago: '11 mnt lalu', nama: 'Rendra Pratama',  hp: '0857-1120-9981', detail: '3× Tahu Crispy, 2× Tempura Jontor', sub: '2× Good Day Freeze', tipe: 'Delivery', bayar: 'QRIS Lunas', status: 'dapur', menitDapur: 11, catatan: '',
          items: [ { q: 3, n: 'Tahu Crispy', note: '', h: 5000 }, { q: 2, n: 'Tempura Jontor', note: '', h: 5000 }, { q: 2, n: 'Good Day Freeze', note: '', h: 5000 } ] },
        { no: '8919', id: '#2DA-8919', jam: '10:05', ago: '24 mnt lalu', nama: 'Dewi Anggraini',  hp: '0813-8877-2100', detail: '3× Roti Maryam Mini', sub: '2× Pop Ice Chocolate', tipe: 'Delivery', bayar: 'COD Tunai', status: 'antar', catatan: '',
          items: [ { q: 3, n: 'Roti Maryam Mini', note: '', h: 5000 }, { q: 2, n: 'Pop Ice Chocolate', note: '', h: 5000 } ] },
        { no: '8918', id: '#2DA-8918', jam: '09:42', ago: '47 mnt lalu', nama: 'Fahri Hamzah',    hp: '0821-4433-2199', detail: '4× Corndog Mini Mozarella, 2× Tahu Crispy', sub: '2× Good Day Freeze', tipe: 'Pick-up',  bayar: 'QRIS Lunas', status: 'selesai', catatan: '',
          items: [ { q: 4, n: 'Corndog Mini Mozarella', note: '', h: 5000 }, { q: 2, n: 'Tahu Crispy', note: '', h: 5000 }, { q: 2, n: 'Good Day Freeze', note: '', h: 5000 } ] }
    ];

    // Data contoh: 4 pesanan dari desain + 44 pesanan buatan = 48 pesanan, sehingga angka di tab
    // selalu sama dengan isi tabel. Data ini tetap (tidak acak setiap dimuat).
    function demoData() {
        var out = DEMO_AWAL.slice();
        var menu = ['Corndog Mini Mozarella', 'Cireng Isi Mini', 'Tahu Crispy', 'Roti Maryam Mini', 'Tempura Jontor', 'Pop Ice Chocolate', 'Good Day Freeze'];
        var depan = ['Aulia', 'Bagas', 'Citra', 'Dani', 'Eka', 'Farah', 'Gilang', 'Hana', 'Indra', 'Jihan', 'Kevin', 'Lestari', 'Maya', 'Naufal', 'Olivia', 'Putra', 'Qori', 'Rina', 'Salsa', 'Tegar', 'Umar', 'Vina', 'Wahyu', 'Yuni'];
        var belakang = ['Saputra', 'Wijaya', 'Lestari', 'Hakim', 'Permata', 'Nugroho', 'Ramadhan', 'Kurniawan', 'Maharani', 'Setiawan', 'Firmansyah', 'Utami', 'Hidayat', 'Pangestu', 'Susanto'];
        var kode = ['0811', '0812', '0813', '0821', '0822', '0852', '0857', '0878', '0881', '0895'];
        var seed = 20241007;
        function rnd(n) { seed = (seed * 16807) % 2147483647; return seed % n; }
        function pad4(n) { return ('0000' + n).slice(-4); }
        function jam(m) { return ('0' + Math.floor(m / 60)).slice(-2) + ':' + ('0' + (m % 60)).slice(-2); }

        var urut = [], i;
        for (i = 0; i < 5; i++) { urut.push('baru'); }
        for (i = 0; i < 11; i++) { urut.push('dapur'); }
        for (i = 0; i < 7; i++) { urut.push('antar'); }
        for (i = 0; i < 21; i++) { urut.push(i === 6 || i === 15 ? 'batal' : 'selesai'); }

        var menitKini = 10 * 60 + 29, menit = 9 * 60 + 42;
        for (i = 0; i < urut.length; i++) {
            menit -= 3 + rnd(3);
            var selisih = menitKini - menit;
            var ago = selisih < 60 ? selisih + ' mnt lalu' : Math.floor(selisih / 60) + ' jam' + (selisih % 60 ? ' ' + (selisih % 60) + ' mnt' : '') + ' lalu';

            var n = 2 + rnd(2), dipakai = [], items = [];
            while (items.length < n) {
                var k = rnd(menu.length);
                if (dipakai.indexOf(k) === -1) { dipakai.push(k); items.push({ q: 1 + rnd(4), n: menu[k], note: '', h: 5000 }); }
            }
            var teks = items.map(function (it) { return it.q + '× ' + it.n; });
            var detail = n === 3 ? teks[0] + ', ' + teks[1] : teks[0];
            var sub = n === 3 ? teks[2] : teks[1];

            var tipe = rnd(2) ? 'Delivery' : 'Pick-up';
            var bayar = rnd(5) === 0 ? 'COD Tunai' : 'QRIS Lunas';
            var no = String(8917 - i);
            out.push({
                no: no, id: '#2DA-' + no, jam: jam(menit), ago: ago,
                nama: depan[rnd(depan.length)] + ' ' + belakang[rnd(belakang.length)],
                hp: kode[rnd(kode.length)] + '-' + pad4(rnd(10000)) + '-' + pad4(rnd(10000)),
                detail: detail, sub: sub, tipe: tipe, bayar: bayar, status: urut[i],
                menitDapur: Math.max(1, Math.min(selisih, 20)), catatan: '', items: items
            });
        }
        return out;
    }

    function hitung(list) {
        var c = { baru: 0, dapur: 0, antar: 0, selesai: 0, batal: 0 };
        list.forEach(function (o) { c[o.status] = (c[o.status] || 0) + 1; });
        return c;
    }

    var DATA_SERVER = @json($pesanan ?? null);
    var DATA = DATA_SERVER || demoData();
    // Kalau server mengirim data per halaman, kirim juga $hitung (jumlah per status seluruh data).
    var CNT = @json($hitung ?? null) || hitung(DATA);

    var now0 = Date.now();
    DATA.forEach(function (o) {
        o.no = String(o.no);
        o.ini = o.ini || inisial(o.nama);
        if (o.status === 'dapur') { o.mulai = now0 - (o.menitDapur || 0) * 60000; }
    });

    var PAGE_SIZE = 4;
    var state = { tab: 'semua', q: '', tipe: '', bayar: '', page: 1, sel: DATA.length ? DATA[0].no : null };

    /* ============ HELPER ============ */
    function $(id) { return document.getElementById(id); }
    function esc(s) { return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]; }); }
    function rp(n) { return 'Rp ' + String(n).replace(/\B(?=(\d{3})+(?!\d))/g, '.'); }
    function inisial(nama) { return String(nama || '?').split(/\s+/).slice(0, 2).map(function (w) { return w.charAt(0).toUpperCase(); }).join(''); }
    function total(o) { return o.items.reduce(function (a, i) { return a + i.q * i.h; }, 0); }
    function waLink(hp) { var d = String(hp).replace(/\D/g, ''); if (d.charAt(0) === '0') { d = '62' + d.slice(1); } return 'https://wa.me/' + d; }
    function find(no) { return DATA.filter(function (o) { return o.no === no; })[0]; }
    function isQris(o) { return /^QRIS/i.test(o.bayar); }
    function statusLabel(o) {
        if (o.status === 'baru') { return 'PESANAN BARU'; }
        if (o.status === 'dapur') { return 'DI DAPUR (' + Math.max(0, Math.floor((Date.now() - (o.mulai || Date.now())) / 60000)) + ' MNT)'; }
        if (o.status === 'antar') { return o.tipe === 'Delivery' ? 'SIAP DIANTAR' : 'SIAP DIAMBIL'; }
        if (o.status === 'selesai') { return 'SELESAI'; }
        return 'DIBATALKAN';
    }
    var TAB_LABEL = { baru: 'Pesanan Baru', dapur: 'Sedang Diproses', antar: 'Siap Diambil/Diantar', selesai: 'Selesai', batal: 'Dibatalkan' };

    var toastTimer;
    function toast(msg) {
        var t = $('toast');
        t.textContent = msg;
        t.classList.add('show');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(function () { t.classList.remove('show'); }, 2600);
    }

    /* ============ AKSI STATUS ============ */
    function sync(o) {
        if (!CONFIG.simpanKeServer) { return; }
        fetch(CONFIG.urlStatus(o.no), {
            method: 'PATCH',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CONFIG.csrf },
            body: JSON.stringify({ status: o.status })
        }).then(function (r) { if (!r.ok) { throw new Error(r.status); } })
          .catch(function () { toast('Gagal menyimpan ke server, coba refresh.'); });
    }

    function setStatus(o, st, pesan) {
        if (!o || o.status === st) { return; }
        CNT[o.status] = Math.max(0, (CNT[o.status] || 0) - 1);
        CNT[st] = (CNT[st] || 0) + 1;
        o.status = st;
        if (st === 'dapur') { o.mulai = Date.now(); }
        sync(o);
        renderAll();
        toast(pesan || ('Pesanan ' + o.id + ' → ' + (TAB_LABEL[st] || st)));
    }

    var NEXT = { baru: 'dapur', dapur: 'antar', antar: 'selesai' };
    var NEXT_MSG = {
        baru: function (o) { return 'Pesanan ' + o.id + ' diterima & masuk dapur'; },
        dapur: function (o) { return 'Pesanan ' + o.id + ' siap ' + (o.tipe === 'Delivery' ? 'diantar' : 'diambil'); },
        antar: function (o) { return 'Pesanan ' + o.id + ' selesai'; }
    };

    /* ============ RENDER ============ */
    function totalCount() { return Object.keys(CNT).reduce(function (a, k) { return a + CNT[k]; }, 0); }

    function renderStats() {
        var semua = totalCount();
        $('statSemua').textContent = semua;
        $('statBaru').textContent = CNT.baru;
        $('statDapur').textContent = CNT.dapur;
        document.querySelectorAll('[data-cnt]').forEach(function (b) {
            var k = b.getAttribute('data-cnt');
            var v = k === 'semua' ? semua : CNT[k];
            if (String(v) !== b.textContent) {
                b.textContent = v;
                b.classList.add('bump');
                setTimeout(function () { b.classList.remove('bump'); }, 250);
            }
        });
        var ada = CNT.baru > 0;
        $('banner').classList.toggle('hidden', !ada);
        $('bannerTitle').textContent = CNT.baru + ' Pesanan baru menanti konfirmasi kilat';
        $('btnTerimaSemuaTxt').textContent = 'Terima Semua (' + CNT.baru + ')';
    }

    function visible() {
        var q = state.q.toLowerCase();
        return DATA.filter(function (o) {
            if (state.tab !== 'semua' && o.status !== state.tab) { return false; }
            if (state.tipe && o.tipe !== state.tipe) { return false; }
            if (state.bayar === 'QRIS' && !isQris(o)) { return false; }
            if (state.bayar === 'COD' && !/^COD/i.test(o.bayar)) { return false; }
            if (q) {
                var hay = (o.id + ' ' + o.no + ' ' + o.nama + ' ' + o.hp + ' ' + String(o.hp).replace(/\D/g, '') + ' ' + o.detail + ' ' + o.sub + ' ' + o.items.map(function (i) { return i.n; }).join(' ')).toLowerCase();
                if (hay.indexOf(q) === -1) { return false; }
            }
            return true;
        });
    }

    function renderPager(jumlah) {
        var pages = Math.max(1, Math.ceil(jumlah / PAGE_SIZE));
        if (state.page > pages) { state.page = pages; }
        var awal = Math.max(1, Math.min(state.page - 1, pages - 2));
        var akhir = Math.min(pages, awal + 2);
        function hal(n) { return '<span class="' + (n === state.page ? 'on' : '') + '" data-p="' + n + '">' + n + '</span>'; }
        var titik = '<span class="dots">…</span>';
        var h = '<span class="' + (state.page === 1 ? 'dis' : '') + '" data-p="prev">Prev</span>';
        if (awal > 1) { h += hal(1); if (awal > 2) { h += titik; } }
        for (var n = awal; n <= akhir; n++) { h += hal(n); }
        if (akhir < pages) { if (akhir < pages - 1) { h += titik; } h += hal(pages); }
        h += '<span class="' + (state.page === pages ? 'dis' : '') + '" data-p="next">Next</span>';
        $('pager').innerHTML = h;
        return pages;
    }

    function renderList() {
        var semuaCocok = visible();
        renderPager(semuaCocok.length);
        var list = semuaCocok.slice((state.page - 1) * PAGE_SIZE, state.page * PAGE_SIZE);
        var html = list.map(function (o) {
            var icon = o.status === 'selesai'
                ? '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" style="margin-top:5px"><circle cx="12" cy="12" r="9"/><path d="M8 12l3 3 5-6"/></svg>'
                : '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="var(--brown)" stroke-width="2.4" style="margin-top:5px"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>';
            return '<tr data-no="' + esc(o.no) + '" class="' + (o.no === state.sel ? 'selected' : '') + '">' +
                '<td><div class="oid ' + (o.status === 'selesai' ? 'done' : '') + '"><strong>' + esc(o.id) + '</strong><small>' + esc(o.jam) + '</small><small class="ago">' + icon + '• ' + esc(o.ago) + '</small></div></td>' +
                '<td><div class="cust"><div class="av">' + esc(o.ini) + '</div><div><strong>' + esc(o.nama) + '</strong><small>' + esc(o.hp) + '</small></div></div></td>' +
                '<td><div class="det">' + esc(o.detail) + '<small>' + esc(o.sub) + '</small></div></td>' +
                '<td><div class="tot"><strong>' + rp(total(o)) + '</strong><div class="tags"><span class="tag type">' + esc(o.tipe) + '</span><span class="tag pay">' + esc(o.bayar) + '</span></div></div></td>' +
                '<td style="text-align:center"><span class="pill ' + o.status + '"><i></i>' + esc(statusLabel(o)) + '</span></td>' +
                '</tr>';
        }).join('');
        if (!list.length) { html = '<tr class="empty"><td colspan="5">Tidak ada pesanan yang cocok dengan filter.</td></tr>'; }
        $('rows').innerHTML = html;
        $('listInfo').textContent = 'Menampilkan ' + list.length + ' dari ' + semuaCocok.length + ' total pesanan aktif';
    }

    function renderTicket() {
        var o = find(state.sel);
        var box = $('ticket');
        if (!o) {
            box.innerHTML = '<div style="text-align:center;color:var(--muted);font-size:13px;padding:40px 8px">Pilih pesanan untuk melihat detail tiket.</div>';
            return;
        }
        var items = o.items.map(function (i, idx) {
            return '<div class="item ' + (idx === 0 ? '' : 'plain') + '"><span class="q">' + i.q + 'x</span><div class="nm">' + esc(i.n) + (i.note ? '<small>' + esc(i.note) + '</small>' : '') + '</div><span class="pr">' + rp(i.q * i.h) + '</span></div>';
        }).join('');
        var sub = total(o);
        var pickup = o.tipe === 'Pick-up';
        var aktif = !!NEXT[o.status];
        var nextTxt = { baru: 'Terima &amp;<br>Masak', dapur: 'Tandai<br>Siap', antar: 'Selesaikan<br>Pesanan', selesai: 'Pesanan<br>Selesai', batal: 'Pesanan<br>Dibatalkan' }[o.status];
        var alur = ['baru', 'dapur', 'antar', 'selesai'].map(function (k) {
            return '<button type="button" data-act="alur-set" data-st="' + k + '" class="' + (o.status === k ? 'cur' : '') + '">' + (o.status === k ? '✓ ' : '') + TAB_LABEL[k] + '</button>';
        }).join('');

        box.innerHTML =
            '<div class="t-head"><div class="ttl"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--brown)" stroke-width="2"><path d="M6 3h12v18l-3-2-3 2-3-2-3 2z"/><path d="M9 8h6M9 12h6"/></svg><h3>Detail Tiket<br>Pesanan</h3></div>' +
            '<span class="badge-new ' + (o.status === 'baru' ? '' : o.status) + '">' + esc(statusLabel(o)).replace('PESANAN BARU', 'PESANAN<br>BARU').replace(' (', '<br>(') + '</span></div>' +
            '<div class="t-id"><div><h2>' + esc(o.id) + '</h2><div class="time">' + esc(o.jam) + ' WIB • ' + esc(o.ago).replace(' lalu', '<br>yang lalu') + '</div></div>' +
            '<div class="right"><div class="pickup">' + (pickup ? 'Ambil Sendiri<br>(Pick-up)' : 'Diantar<br>(Delivery)') + '</div><div class="qr">' + (isQris(o) ? 'QRIS • Lunas<br>Otomatis' : 'COD • Tunai<br>Bayar di Tempat') + '</div></div></div>' +
            '<div class="t-cust"><div class="av">' + esc(o.ini) + '</div><div><strong>' + esc(o.nama) + '</strong><small>' + esc(o.hp) + '</small></div>' +
            '<a href="' + waLink(o.hp) + '" target="_blank" rel="noopener" class="chat" aria-label="Chat WhatsApp"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v13H9l-5 4z"/><path d="M8 9h8M8 13h5"/></svg></a></div>' +
            '<div class="t-items"><h4>Item Dipesan (' + o.items.length + ' Item)</h4>' + items + '</div>' +
            (o.catatan ? '<div class="note-box"><b><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v13H9l-5 4z"/><path d="M8 9h8"/></svg>CATATAN PELANGGAN:</b><p>"' + esc(o.catatan) + '"</p></div>' : '') +
            '<div class="sum"><div><span>Subtotal Makanan &amp; Minuman</span><span>' + rp(sub) + '</span></div><div><span>Biaya Layanan &amp; Pengemasan</span><span>Rp 0 (Gratis)</span></div><div><span>Ongkos Kirim</span><span>' + (pickup ? 'Rp 0 (Pick-up)' : 'Rp 0 (Gratis)') + '</span></div><div class="grand"><span>Total Tagihan</span><span>' + rp(sub) + '</span></div></div>' +
            '<div class="t-actions">' +
            '<button type="button" class="btn btn-brown ' + (aktif ? '' : 'is-disabled') + '" data-act="next"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 3v4M12 3v4M16 3v4M3 11h18a9 9 0 01-18 0z"/></svg>' + nextTxt + '</button>' +
            '<button type="button" class="btn btn-soft" data-act="alur"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 8h14l-3-3M20 16H6l3 3"/></svg>Ubah Alur</button>' +
            '<button type="button" class="btn btn-soft" data-act="slip"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 9V3h10v6M7 17H4v-8h16v8h-3M7 14h10v7H7z"/></svg>Slip Dapur</button>' +
            '<button type="button" class="btn btn-red ' + ((o.status === 'selesai' || o.status === 'batal') ? 'is-disabled' : '') + '" data-act="tolak"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M6 6l12 12M18 6L6 18"/></svg>Tolak<br>Pesanan</button>' +
            '<div class="alur-menu" id="alurMenu">' + alur + '</div>' +
            '</div>';
    }

    function renderAll() { renderStats(); renderList(); renderTicket(); }

    /* ============ CETAK ============ */
    function slipHtml(o) {
        var lines = o.items.map(function (i) {
            return '<div class="row"><span>' + i.q + 'x ' + esc(i.n) + '</span></div>' + (i.note ? '<div style="padding-left:14px">- ' + esc(i.note) + '</div>' : '');
        }).join('');
        return '<div class="slip"><h4>2DA STORE</h4><div class="c">SLIP DAPUR</div><hr>' +
            '<div class="row"><span>' + esc(o.id) + '</span><span>' + esc(o.jam) + '</span></div>' +
            '<div>' + esc(o.nama) + '</div><div>' + esc(o.tipe) + ' | ' + esc(o.bayar) + '</div><hr>' + lines + '<hr>' +
            (o.catatan ? '<div class="note">Catatan: ' + esc(o.catatan) + '</div><hr>' : '') +
            '<div class="row"><b>TOTAL</b><b>' + rp(total(o)) + '</b></div></div>';
    }
    function cetak(orders) {
        $('printArea').innerHTML = orders.map(slipHtml).join('');
        window.print();
    }

    /* ============ EVENT ============ */
    $('rows').addEventListener('click', function (e) {
        var tr = e.target.closest('tr[data-no]');
        if (!tr) { return; }
        state.sel = tr.getAttribute('data-no');
        renderList();
        renderTicket();
        if (window.matchMedia && window.matchMedia('(max-width: 1200px)').matches) {
            $('ticket').scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });

    $('tabs').addEventListener('click', function (e) {
        var b = e.target.closest('.tab');
        if (!b) { return; }
        state.tab = b.getAttribute('data-tab');
        state.page = 1;
        document.querySelectorAll('#tabs .tab').forEach(function (t) { t.classList.toggle('active', t === b); });
        renderList();
    });

    $('pager').addEventListener('click', function (e) {
        var el = e.target.closest('[data-p]');
        if (!el || el.classList.contains('dis')) { return; }
        var v = el.getAttribute('data-p');
        state.page = v === 'prev' ? state.page - 1 : v === 'next' ? state.page + 1 : parseInt(v, 10);
        renderList();
    });

    $('fSearch').addEventListener('input', function () { state.q = this.value.trim(); state.page = 1; renderList(); });
    $('fTipe').addEventListener('change', function () { state.tipe = this.value; state.page = 1; renderList(); });
    $('fBayar').addEventListener('change', function () { state.bayar = this.value; state.page = 1; renderList(); });

    $('btnTerimaSemua').addEventListener('click', function () {
        var baru = DATA.filter(function (o) { return o.status === 'baru'; });
        if (!CNT.baru) { return; }
        if (!confirm('Terima semua ' + CNT.baru + ' pesanan baru dan kirim ke dapur?')) { return; }
        baru.forEach(function (o) { setStatus(o, 'dapur', ''); });
        // pesanan baru lain yang belum dimuat di halaman ini tetap dihitung
        var sisa = CNT.baru;
        if (sisa > 0) { CNT.dapur += sisa; CNT.baru = 0; }
        renderAll();
        toast('Semua pesanan baru diterima & masuk dapur');
    });

    $('btnRefresh').addEventListener('click', function (e) {
        e.preventDefault();
        // Data dari server: muat ulang halaman ini. Data contoh: cukup segarkan tampilan (timer dapur, dll).
        if (DATA_SERVER !== null) { window.location.reload(); return; }
        renderAll();
        toast('Data pesanan diperbarui');
    });

    $('btnBatch').addEventListener('click', function () {
        var baru = DATA.filter(function (o) { return o.status === 'baru'; });
        if (!baru.length) { toast('Tidak ada pesanan baru untuk dicetak.'); return; }
        cetak(baru);
    });

    $('ticket').addEventListener('click', function (e) {
        var btn = e.target.closest('[data-act]');
        var o = find(state.sel);
        if (!btn || !o) { return; }
        var act = btn.getAttribute('data-act');
        var menu = $('alurMenu');

        if (act === 'next') {
            if (!NEXT[o.status]) { return; }
            setStatus(o, NEXT[o.status], NEXT_MSG[o.status](o));
        } else if (act === 'alur') {
            menu.classList.toggle('open');
        } else if (act === 'alur-set') {
            setStatus(o, btn.getAttribute('data-st'));
        } else if (act === 'slip') {
            cetak([o]);
        } else if (act === 'tolak') {
            if (o.status === 'selesai' || o.status === 'batal') { return; }
            if (confirm('Tolak pesanan ' + o.id + ' dari ' + o.nama + '?')) { setStatus(o, 'batal', 'Pesanan ' + o.id + ' ditolak'); }
        }
    });

    document.addEventListener('click', function (e) {
        var menu = $('alurMenu');
        if (menu && menu.classList.contains('open') && !e.target.closest('[data-act="alur"]') && !e.target.closest('#alurMenu')) {
            menu.classList.remove('open');
        }
    });

    // Label "DI DAPUR (n MNT)" ikut berjalan
    setInterval(function () {
        renderList();
        var o = find(state.sel), menu = $('alurMenu');
        if (o && o.status === 'dapur' && !(menu && menu.classList.contains('open'))) { renderTicket(); }
    }, 30000);

    renderAll();
})();
</script>
</body>
</html>