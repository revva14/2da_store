<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard &amp; Rekap - 2da Store</title>
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

        .layout { display: flex; min-height: 100vh; }

        /* ===== MAIN ===== */
        .main { flex: 1; padding: 19px 25.5px 51px; min-width: 0; }

        .head { display: flex; justify-content: space-between; align-items: flex-start; margin-top: 6.5px; gap: 19px; }
        .head h1 { font-size: 24px; font-weight: 600; letter-spacing: -.01em; }
        .head p { color: var(--muted); font-size: 12px; line-height: 1.45; max-width: 304px; margin-top: 5px; }
        .head-actions { display: flex; flex-direction: column; gap: 11px; align-items: flex-start; }
        .tabs { display: flex; gap: 3px; background: var(--cream); padding: 5px; border-radius: 11px; }
        .tabs button { border: 0; background: transparent; padding: 6.5px 13px; border-radius: 8px; font: inherit; font-size: 10.5px; color: var(--muted); cursor: pointer; transition: background .25s, color .25s; }
        .tabs button.active { background: #fff; color: var(--ink); font-weight: 600; box-shadow: 0 2px 5px rgba(0,0,0,.05); }
        .filters { display: flex; align-items: center; gap: 22.5px; }
        .date { display: flex; align-items: center; gap: 6.5px; background: #fff; border-radius: 9.5px; padding: 8px 13px; font-size: 10.5px; font-weight: 500; cursor: pointer; }
        .btn-export { display: flex; align-items: center; gap: 6.5px; background: var(--brown); color: #fff; padding: 9.5px 16px; border-radius: 9.5px; font-size: 10.5px; font-weight: 500; box-shadow: 0 5px 11px rgba(163,74,10,.3); transition: transform .25s, box-shadow .25s; }
        .btn-export:hover { transform: translateY(-2px); box-shadow: 0 8px 14.5px rgba(163,74,10,.35); }

        /* ===== STAT CARDS ===== */
        .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 19px; margin-top: 25.5px; }
        .card { background: var(--card); border-radius: 19px; box-shadow: 0 5px 19px rgba(180,110,50,.07); }
        .stat { padding: 19px; position: relative; overflow: hidden; transition: transform .3s, box-shadow .3s; animation: rise .6s ease both; }
        .stat:hover { transform: translateY(-4px); box-shadow: 0 9.5px 24px rgba(180,110,50,.14); }
        .stat:nth-child(2) { animation-delay: .08s; } .stat:nth-child(3) { animation-delay: .16s; } .stat:nth-child(4) { animation-delay: .24s; }
        .stat-top { display: flex; justify-content: space-between; align-items: center; }
        .ico { width: 38.5px; height: 38.5px; border-radius: 11px; display: grid; place-items: center; color: var(--brown); }
        .ico.a { background: #fcd9c8; } .ico.b { background: #fcd3c1; } .ico.c { background: #fbe1a8; } .ico.d { background: #fcd9c8; }
        .trend { font-size: 9.5px; font-weight: 600; color: var(--green); background: #eef4e6; padding: 3px 8px; border-radius: 8px; display: flex; align-items: center; gap: 3px; }
        .stat .label { margin-top: 14.5px; font-size: 10.5px; color: var(--muted); }
        .stat .value { font-size: 26px; font-weight: 600; line-height: 1.15; letter-spacing: .01em; }
        .stat .value small { font-size: 12px; font-weight: 500; letter-spacing: 0; }
        .stat .sub { display: flex; gap: 6.5px; align-items: center; margin-top: 8px; font-size: 9.5px; color: var(--muted); line-height: 1.35; }
        .top-star { font-size: 9px; font-weight: 700; color: #fff; background: var(--brown); padding: 3px 8px; border-radius: 8px; letter-spacing: .03em; }
        .champ { list-style: none; margin-top: 6.5px; display: flex; flex-direction: column; gap: 6.5px; }
        .champ li { display: flex; align-items: center; justify-content: space-between; font-size: 10.5px; font-weight: 600; }
        .champ li span.qty { font-size: 9px; font-weight: 600; color: var(--brown); background: #f8e2d3; padding: 4px 8px; border-radius: 9.5px; }

        /* ===== CHART & CATEGORY ===== */
        .grid-2 { display: grid; grid-template-columns: 1.85fr 1fr; gap: 19px; margin-top: 25.5px; align-items: start; }
        .panel { padding: 25.5px; }
        .panel h2 { font-size: 19px; font-weight: 600; }
        .panel .desc { font-size: 9.5px; color: var(--muted); margin-top: 3px; line-height: 1.45; }
        .chart-head { display: flex; justify-content: space-between; gap: 13px; }
        .legend { display: flex; gap: 17.5px; font-size: 9.5px; font-weight: 500; }
        .legend span { display: flex; align-items: center; gap: 5px; }
        .legend i { width: 8px; height: 8px; border-radius: 50%; display: inline-block; }
        .chart-wrap { position: relative; margin-top: 6.5px; }
        .peak-tag { position: absolute; top: 3px; left: 47%; display: flex; align-items: center; gap: 6.5px; background: #fbeadb; border-radius: 9.5px; padding: 6.5px 11px; font-size: 9px; font-weight: 600; box-shadow: 0 5px 11px rgba(0,0,0,.06); animation: float 3s ease-in-out infinite; }
        .peak-tag svg { color: var(--brown); }
        .line-draw { stroke-dasharray: 1400; stroke-dashoffset: 1400; animation: draw 2s ease forwards; }
        .area-fade { opacity: 0; animation: fade 1.6s .4s ease forwards; }
        .chart-x { display: flex; justify-content: space-between; padding: 0 21px 0 16px; font-size: 9.5px; color: var(--muted); text-align: center; }
        .chart-x b { color: var(--brown); font-weight: 600; }
        .ratios { display: grid; grid-template-columns: repeat(3, 1fr); gap: 13px; background: #fdf3ea; border-radius: 13px; padding: 13px; margin-top: 16px; }
        .ratios small { display: block; font-size: 9px; font-weight: 600; }
        .ratios strong { font-size: 16px; font-weight: 600; color: var(--brown); }

        .cat-list { margin-top: 16px; display: flex; flex-direction: column; gap: 14.5px; }
        .cat-row .row { display: flex; justify-content: space-between; gap: 9.5px; font-size: 9.5px; font-weight: 500; }
        .cat-row .row .name { display: flex; gap: 6.5px; align-items: flex-start; }
        .cat-row .row .name i { width: 6.5px; height: 6.5px; border-radius: 50%; margin-top: 3px; flex-shrink: 0; }
        .cat-row .row .amt { text-align: right; }
        .bar { height: 6.5px; border-radius: 5px; background: #f1ece7; margin-top: 6.5px; overflow: hidden; }
        .bar span { display: block; height: 100%; border-radius: 5px; animation: grow 1.2s ease both; transform-origin: left; }
        .fav { display: flex; gap: 11px; background: #fbeadb; border-radius: 13px; padding: 11px; margin-top: 19px; align-items: center; }
        .fav img { width: 45px; height: 45px; border-radius: 9.5px; object-fit: cover; background: #e9d3c0; }
        .fav small { display: block; font-size: 8px; font-weight: 700; color: var(--brown); letter-spacing: .05em; line-height: 1.3; }
        .fav strong { display: block; font-size: 11px; font-weight: 600; }
        .fav p { font-size: 9.5px; color: var(--muted); line-height: 1.35; }

        /* ===== TABLE ===== */
        .table-panel { margin-top: 25.5px; padding: 25.5px; }
        .table-head { display: flex; justify-content: space-between; align-items: flex-start; gap: 13px; }
        .table-head .actions { display: flex; gap: 9.5px; }
        .btn-soft { display: flex; align-items: center; gap: 6.5px; background: #fdf3ea; padding: 9.5px 14.5px; border-radius: 9.5px; font-size: 10.5px; font-weight: 500; transition: background .25s; }
        .btn-soft:hover { background: #fae4d0; }
        table { width: 100%; border-collapse: collapse; margin-top: 19px; }
        thead th { background: #fdf1e6; font-size: 9px; font-weight: 600; letter-spacing: .06em; color: var(--muted); padding: 13px 6.5px; text-align: center; }
        thead th:first-child { border-radius: 11px 0 0 11px; text-align: left; padding-left: 80px; }
        thead th:last-child { border-radius: 0 11px 11px 0; }
        tbody td { padding: 14.5px 6.5px; text-align: center; font-size: 12px; color: var(--muted); border-bottom: 1px solid var(--line); }
        tbody tr { transition: background .2s; }
        tbody tr:hover { background: #fffaf5; }
        tbody td:first-child { text-align: left; padding-left: 80px; color: var(--ink); font-weight: 500; }
        tbody td:first-child i { width: 6.5px; height: 6.5px; border-radius: 50%; display: inline-block; margin-right: 6.5px; background: #efe4da; }
        tbody tr:first-child td:first-child i { background: var(--brown); }
        tbody td.pesanan { color: var(--ink); font-weight: 600; }
        tbody td.minuman { color: var(--brown); }
        tbody td.net { color: var(--ink); font-weight: 600; }
        tfoot td { background: #f7e9dc; padding: 16px 6.5px; text-align: center; font-size: 16px; font-weight: 600; color: var(--brown); }
        tfoot td:first-child { border-radius: 11px 0 0 11px; text-align: left; padding-left: 80px; color: var(--ink); }
        tfoot td:last-child { border-radius: 0 11px 11px 0; }
        tfoot td.plain { color: var(--muted); }
        .pager { display: flex; justify-content: space-between; align-items: center; margin-top: 25.5px; font-size: 9.5px; color: var(--muted); }
        .pager .ctrl { display: flex; align-items: center; gap: 13px; color: var(--ink); font-weight: 500; }
        .pager .ctrl span.arrow { width: 29px; height: 29px; border-radius: 8px; background: #fdf3ea; display: grid; place-items: center; color: #a99b92; cursor: pointer; }

        /* ===== FILTER TANGGAL (popover, hanya muncul saat kolom tanggal diklik) ===== */
        .date-pop { position: absolute; z-index: 30; top: 0; left: 0; width: 292px; max-width: calc(100vw - 24px); background: #fff; border: 1px solid var(--line); border-radius: 13px; padding: 14px; box-shadow: 0 9.5px 24px rgba(180,110,50,.18); font-size: 10.5px; }
        .date-pop[hidden] { display: none; }
        .dp-title { font-size: 9px; font-weight: 600; letter-spacing: .06em; color: var(--muted); margin-bottom: 8px; }
        .dp-presets { display: flex; flex-wrap: wrap; gap: 6px; }
        .dp-presets button { border: 0; background: var(--cream); color: var(--muted); font: inherit; font-size: 10px; padding: 6px 10px; border-radius: 8px; cursor: pointer; transition: background .2s, color .2s; }
        .dp-presets button:hover { background: #fae4d0; }
        .dp-presets button.active { background: var(--brown); color: #fff; }
        .dp-fields { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-top: 14px; }
        .dp-fields label { display: block; font-size: 9px; font-weight: 600; letter-spacing: .04em; color: var(--muted); }
        .dp-fields input { display: block; width: 100%; margin-top: 4px; font: inherit; font-size: 10.5px; color: var(--ink); background: #fff; border: 1px solid var(--line); border-radius: 9.5px; padding: 7px 8px; outline: none; }
        .dp-fields input:focus { border-color: var(--orange); }
        .dp-err { margin-top: 8px; font-size: 9.5px; font-weight: 500; color: #b3402e; }
        .dp-err[hidden] { display: none; }
        .dp-actions { display: flex; justify-content: flex-end; gap: 8px; margin-top: 14px; }
        .dp-actions button { border: 0; font: inherit; font-size: 10.5px; font-weight: 500; padding: 8px 14px; border-radius: 9.5px; cursor: pointer; }
        .dp-cancel { background: #fdf3ea; color: var(--ink); }
        .dp-apply { background: var(--brown); color: #fff; box-shadow: 0 5px 11px rgba(163,74,10,.3); }
        .trend.down { color: #b3402e; background: #fbe6e1; }
        .trend.down svg { transform: scaleY(-1); }

        /* ===== ANIMASI ===== */
        @keyframes rise { from { opacity: 0; transform: translateY(13px); } to { opacity: 1; transform: none; } }
        @keyframes draw { to { stroke-dashoffset: 0; } }
        @keyframes fade { to { opacity: 1; } }
        @keyframes grow { from { transform: scaleX(0); } to { transform: scaleX(1); } }
        @keyframes float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-4px); } }

        @media (max-width: 1100px) {
            .stats { grid-template-columns: repeat(2, 1fr); }
            .grid-2 { grid-template-columns: 1fr; }
        }
        @media (max-width: 800px) {
            .head { flex-direction: column; }
            .table-panel { overflow-x: auto; }
        }

        /* ===== CETAK / SIMPAN PDF (hanya tabel rekap) ===== */
        @media print {
            body.print-rekap { background: #fff; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            body.print-rekap .layout > *:not(.main) { display: none !important; }
            body.print-rekap .main > *:not(.table-panel) { display: none !important; }
            body.print-rekap .main { padding: 0; }
            body.print-rekap .table-panel { margin-top: 0; padding: 0; box-shadow: none; }
            body.print-rekap .table-head .actions,
            body.print-rekap .pager .ctrl { display: none !important; }
        }
    </style>
</head>
<body>
@php
    // Data tabel rekap (statis sesuai desain). Ganti dengan data dari controller bila sudah siap.
    $rekap = [
        ['Minggu, 07 Okt 2024', 76, 65, 125, 'Rp 950.000',   'Rp 950.000'],
        ['Sabtu, 06 Okt 2024',  88, 75, 145, 'Rp 1.100.000', 'Rp 1.100.000'],
        ['Jumat, 05 Okt 2024',  60, 50, 100, 'Rp 750.000',   'Rp 750.000'],
        ['Kamis, 04 Okt 2024',  48, 40, 80,  'Rp 600.000',   'Rp 600.000'],
        ['Rabu, 03 Okt 2024',   44, 35, 75,  'Rp 550.000',   'Rp 550.000'],
        ['Selasa, 02 Okt 2024', 44, 35, 75,  'Rp 550.000',   'Rp 550.000'],
        ['Senin, 01 Okt 2024',  40, 20, 80,  'Rp 500.000',   'Rp 500.000'],
    ];

    // ---- Data riwayat untuk filter tanggal & tab Per Hari / Minggu / Bulan (CONTOH) ----
    // Baris 01-07 Okt 2024 diambil langsung dari $rekap di atas.
    // Hari-hari sebelumnya (01 Jul - 30 Sep 2024) dibuat otomatis sebagai data contoh.
    // Bila data sudah dari controller, cukup isi $rekapSemua dengan data asli, satu baris per hari:
    //   d = tanggal (Y-m-d), l = label baris tabel, p = pesanan, m = minuman, j = jajanan, g = gross (= net)
    $bulanSingkat = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    $namaHari     = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']; // 01 Okt 2024 = Senin, mengikuti data di atas
    $polaPekan    = [40, 44, 44, 48, 60, 88, 76];
    $pekanLalu    = [36, 40, 40, 44, 56, 80, 72];   // 24-30 Sep 2024 => total Rp 4.600.000 (sesuai "vs Rp 4.600.000 lalu")
    $faktorPekan  = [0.95, 0.90, 0.97, 0.93, 0.88, 0.94, 0.91, 0.96, 0.89, 0.92, 0.95, 0.90, 0.93];

    $rekapSemua = [];
    foreach ($rekap as $r) {
        preg_match('/(\d{2}) Okt 2024/', $r[0], $cocok);
        $rekapSemua[] = [
            'd' => '2024-10-' . $cocok[1],
            'l' => $r[0],
            'p' => $r[1],
            'm' => $r[2],
            'j' => $r[3],
            'g' => (int) preg_replace('/\D/', '', $r[4]),
        ];
    }

    $acuan = new DateTime('2024-10-01');
    for ($i = 1; $i <= 92; $i++) {                                  // 30 Sep ... 01 Jul 2024
        $tgl     = (clone $acuan)->modify('-' . $i . ' days');
        $idx     = (7 - ($i % 7)) % 7;                              // urutan hari: 0 = Senin ... 6 = Minggu
        $pekanKe = intdiv($i - 1, 7);                               // 0 = pekan tepat sebelum 01 Okt
        $pesanan = $pekanKe === 0
            ? $pekanLalu[$idx]
            : 2 * (int) round($polaPekan[$idx] * $faktorPekan[($pekanKe - 1) % count($faktorPekan)] / 2);
        $minuman = (int) round($pesanan * 0.82);
        $rekapSemua[] = [
            'd' => $tgl->format('Y-m-d'),
            'l' => $namaHari[$idx] . ', ' . $tgl->format('d') . ' ' . $bulanSingkat[(int) $tgl->format('n') - 1] . ' ' . $tgl->format('Y'),
            'p' => $pesanan,
            'm' => $minuman,
            'j' => (int) ($pesanan * 2.5) - $minuman,
            'g' => $pesanan * 12500,
        ];
    }
@endphp

<div class="layout">

    @include('partials.sidebaradmin')

    {{-- ================= KONTEN UTAMA ================= --}}
    <main class="main">

        @include('partials.navbaradmin')


        <div class="head">
            <div>
                <h1>Rekapitulasi Penjualan</h1>
                <p>Pantau performa omset jajanan &amp; minuman segar 2da Store secara realtime.</p>
            </div>
            <div class="head-actions">
                <div class="tabs">
                    <button class="active" data-tab="day">Per Hari</button>
                    <button data-tab="week">Per Minggu</button>
                    <button data-tab="month">Per Bulan</button>
                </div>
                <div class="filters">
                    <div class="date" id="dateBtn" role="button" tabindex="0" aria-haspopup="true" aria-expanded="false">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--brown)" stroke-width="2"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/></svg>
                        <span id="dateLabel">01 Okt 2024 - 07 Okt 2024</span>
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                    </div>
                    <a href="{{ url('/admin/rekap/ekspor') }}" class="btn-export" id="btnExport">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3v12M7 10l5 5 5-5M4 20h16"/></svg>
                        Ekspor Rekap
                    </a>

                    <div class="date-pop" id="datePop" hidden>
                        <div class="dp-title">RENTANG CEPAT</div>
                        <div class="dp-presets" id="dpPresets">
                            <button type="button" data-preset="7">7 Hari Terakhir</button>
                            <button type="button" data-preset="14">14 Hari Terakhir</button>
                            <button type="button" data-preset="30">30 Hari Terakhir</button>
                            <button type="button" data-preset="bulan-ini">Bulan Ini</button>
                            <button type="button" data-preset="bulan-lalu">Bulan Lalu</button>
                        </div>
                        <div class="dp-fields">
                            <label>DARI<input type="date" id="dateFrom"></label>
                            <label>SAMPAI<input type="date" id="dateTo"></label>
                        </div>
                        <div class="dp-err" id="dateErr" hidden></div>
                        <div class="dp-actions">
                            <button type="button" class="dp-cancel" id="dpCancel">Batal</button>
                            <button type="button" class="dp-apply" id="dpApply">Terapkan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== KARTU STATISTIK ===== --}}
        <section class="stats">
            <div class="card stat">
                <div class="stat-top">
                    <div class="ico a"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="6" width="18" height="12" rx="2"/><circle cx="12" cy="12" r="2.5"/></svg></div>
                    <span class="trend" id="trendNet"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M3 17l6-6 4 4 8-8M15 7h6v6"/></svg><span class="tv">+8.7%</span></span>
                </div>
                <div class="label">Total Pendapatan Bersih</div>
                <div class="value" id="statNet">Rp 5.000.000</div>
                <div class="sub">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M8 12l3 3 5-6"/></svg>
                    <span id="subNet">vs Rp 4.600.000 lalu</span>
                </div>
            </div>

            <div class="card stat">
                <div class="stat-top">
                    <div class="ico b"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 3h12v18l-3-2-3 2-3-2-3 2z"/><path d="M9 8h6M9 12h6"/></svg></div>
                    <span class="trend" id="trendOrders"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M3 17l6-6 4 4 8-8M15 7h6v6"/></svg><span class="tv">+8.2%</span></span>
                </div>
                <div class="label">Pesanan Sukses Selesai</div>
                <div class="value" id="statOrders">400 <small>transaksi</small></div>
                <div class="sub">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                    <span id="subOrders">Total 1.000 porsi terjual<br>(100% selesai)</span>
                </div>
            </div>

            <div class="card stat">
                <div class="stat-top">
                    <div class="ico c"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 8h14l-1 12H6z"/><path d="M9 8a3 3 0 016 0"/></svg></div>
                    <span class="trend" id="trendAov"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M7 17L17 7M8 7h9v9"/></svg><span class="tv">+4.5%</span></span>
                </div>
                <div class="label">Rata-rata Nilai Order (AOV)</div>
                <div class="value" id="statAov">Rp 12.500</div>
                <div class="sub">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--brown)" stroke-width="2"><path d="M4 10a8 5 0 0116 0z"/><path d="M4 14h16M5 18h14"/></svg>
                    <span id="subAov">~2.5 porsi / pesanan (Rp<br>5.000/porsi)</span>
                </div>
            </div>

            <div class="card stat">
                <div class="stat-top">
                    <div class="ico d"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3c1 4 5 5 5 10a5 5 0 01-10 0c0-2 1-3 2-4 0 2 1 3 2 3 0-3-1-5 1-9z"/></svg></div>
                    <span class="top-star">TOP STAR</span>
                </div>
                <div class="label">Juara Terlaris Minggu Ini</div>
                <ul class="champ">
                    <li>1. Corndog Mini Mozarella <span class="qty">238<br>pcs</span></li>
                    <li>2. Pop Ice Chocolate <span class="qty">192<br>cup</span></li>
                    <li>3. Tempura Jontor <span class="qty">164 pcs</span></li>
                </ul>
            </div>
        </section>

        {{-- ===== TREN & KATEGORI ===== --}}
        <section class="grid-2">
            <div class="card panel">
                <div class="chart-head">
                    <div>
                        <h2>Tren Penjualan &amp; Jam Sibuk</h2>
                        <p class="desc">Rangkuman transaksi kotor dan omset riil penjualan dengan harga<br>pas tanpa promo / diskon.</p>
                    </div>
                    <div class="legend">
                        <span><i style="background:var(--brown)"></i>Minuman</span>
                        <span><i style="background:var(--gold)"></i>Jajanan &amp;<br>Cemilan</span>
                    </div>
                </div>

                <div class="chart-wrap">
                    <div class="peak-tag">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2L4 14h7l-1 8 9-12h-7z"/></svg>
                        Peak Rush: 14:00 - 17:00 WIB
                    </div>
                    <svg viewBox="0 0 660 330" width="100%" preserveAspectRatio="none" style="height:264px">
                        <defs>
                            <linearGradient id="gOrange" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0" stop-color="#ffb98a" stop-opacity=".75"/>
                                <stop offset="1" stop-color="#ffe6d2" stop-opacity="0"/>
                            </linearGradient>
                            <linearGradient id="gGold" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0" stop-color="#e9c777" stop-opacity=".35"/>
                                <stop offset="1" stop-color="#fff2d6" stop-opacity="0"/>
                            </linearGradient>
                        </defs>
                        <g stroke="#f0e4d9" stroke-dasharray="4 5">
                            <line x1="0" y1="70" x2="660" y2="70"/>
                            <line x1="0" y1="170" x2="660" y2="170"/>
                        </g>
                        {{-- area & garis Minuman --}}
                        <path class="area-fade" d="M8,250 C70,190 150,150 230,125 S340,75 400,62 S470,45 510,60 S540,100 542,120 L542,300 L8,300 Z" fill="url(#gOrange)"/>
                        <path class="line-draw" d="M8,250 C70,190 150,150 230,125 S340,75 400,62 S470,45 510,60 S540,100 542,120" fill="none" stroke="#ff8a3d" stroke-width="2.5"/>
                        {{-- area & garis Jajanan --}}
                        <path class="area-fade" d="M8,275 C70,245 150,225 230,200 S340,150 400,135 S470,115 510,128 S540,160 542,178 L542,300 L8,300 Z" fill="url(#gGold)"/>
                        <path class="line-draw" d="M8,275 C70,245 150,225 230,200 S340,150 400,135 S470,115 510,128 S540,160 542,178" fill="none" stroke="#d6a63a" stroke-width="2.5"/>
                        {{-- penanda puncak --}}
                        <circle cx="412" cy="58" r="5" fill="#fff" stroke="var(--brown)" stroke-width="2"/>
                        <circle cx="514" cy="62" r="3.5" fill="#ff8a3d"/>
                    </svg>
                    <div class="chart-x">
                        <span>09:00</span><span>11:00</span><span>13:00</span><span>15:00</span><span><b>17:00<br>(Puncak)</b></span><span>19:00</span><span>21:00</span>
                    </div>
                </div>

                <div class="ratios">
                    <div><small>Rasio Penjualan Minuman</small><strong>58.4%</strong></div>
                    <div><small>Rasio Penjualan Jajanan</small><strong style="color:#8a5a0a">41.6%</strong></div>
                    <div><small>Durasi Pemenuhan Rata2</small><strong style="color:#8a5a0a">4.8 Menit</strong></div>
                </div>
            </div>

            <div class="card panel">
                <div class="chart-head">
                    <div>
                        <h2>Kategori Menu</h2>
                        <p class="desc">Rangkuman transaksi kotor dan omset riil penjualan dengan harga pas tanpa promo / diskon.</p>
                    </div>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--brown)" stroke-width="2" style="flex-shrink:0"><path d="M12 3a9 9 0 109 9h-9z"/><path d="M15 3.5A9 9 0 0120.5 9H15z"/></svg>
                </div>

                <div class="cat-list">
                    <div class="cat-row">
                        <div class="row"><span class="name"><i style="background:var(--brown)"></i>Jajanan Gurih &amp; Gorengan</span><span class="amt">Rp 2.200.000<br>(44%)</span></div>
                        <div class="bar"><span style="width:44%; background:var(--brown)"></span></div>
                    </div>
                    <div class="cat-row">
                        <div class="row"><span class="name"><i style="background:var(--gold)"></i>Minuman Dingin (Pop Ice &amp; Good Day)</span><span class="amt">Rp<br>1.600.000<br>(32%)</span></div>
                        <div class="bar"><span style="width:32%; background:var(--gold)"></span></div>
                    </div>
                    <div class="cat-row">
                        <div class="row"><span class="name"><i style="background:var(--green)"></i>Jajanan Pedas (Tempura Jontor)</span><span class="amt">Rp 800.000<br>(16%)</span></div>
                        <div class="bar"><span style="width:16%; background:var(--green)"></span></div>
                    </div>
                    <div class="cat-row">
                        <div class="row"><span class="name"><i style="background:#7a5a4e"></i>Jajanan Manis (Roti Maryam)</span><span class="amt">Rp 400.000<br>(8%)</span></div>
                        <div class="bar"><span style="width:8%; background:#7a5a4e"></span></div>
                    </div>
                </div>

                <div class="fav">
                    <img src="{{ asset('images/corndog.jpg') }}" alt="Corndog Mini Mozarella">
                    <div>
                        <small>MENU FAVORIT<br>PELANGGAN</small>
                        <strong>Corndog Mini Mozarella</strong>
                        <p>Penjualan tertinggi tanpa potongan harga / diskon.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ===== DETAIL BUKU REKAP ===== --}}
        <section class="card table-panel">
            <div class="table-head">
                <div>
                    <h2 style="font-size:19px;font-weight:600">Detail Buku Rekap Penjualan</h2>
                    <p class="desc" style="font-size:9.5px;color:var(--muted);margin-top:3px">Rangkuman transaksi kotor dan omset riil penjualan dengan harga pas tanpa promo / diskon.</p>
                </div>
                <div class="actions">
                    <a href="{{ url('/admin/rekap/unduh-csv') }}" class="btn-soft" id="btnCsv">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 3h9l4 4v14H6z"/><path d="M9 13h6M9 17h6"/></svg>
                        Unduh CSV
                    </a>
                    <a href="{{ url('/admin/rekap/unduh-pdf') }}" class="btn-soft" id="btnPdf">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 3h9l4 4v14H6z"/><path d="M9 14h6"/></svg>
                        Unduh PDF
                    </a>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>TANGGAL / HARI</th>
                        <th>PESANAN</th>
                        <th>MINUMAN (CUP)</th>
                        <th>JAJANAN (PCS)</th>
                        <th>GROSS TOTAL</th>
                        <th>NET OMSET MASUK</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rekap as $row)
                        <tr>
                            <td><i></i>{{ $row[0] }}</td>
                            <td class="pesanan">{{ $row[1] }}</td>
                            <td class="minuman">{{ $row[2] }}</td>
                            <td>{{ $row[3] }}</td>
                            <td>{{ $row[4] }}</td>
                            <td class="net">{{ $row[5] }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td>Total Periode Ini</td>
                        <td>400</td>
                        <td>320</td>
                        <td class="plain">680</td>
                        <td>Rp 5.000.000</td>
                        <td>Rp 5.000.000</td>
                    </tr>
                </tfoot>
            </table>

            <div class="pager">
                <span id="pagerInfo">Menampilkan 7 hari transaksi terakhir (01 - 07 Oktober 2024)</span>
                <div class="ctrl">
                    <span class="arrow" id="pagePrev" role="button" tabindex="0" aria-label="Halaman sebelumnya"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 6l-6 6 6 6"/></svg></span>
                    <span id="pageInfo">Halaman 1 dari 1</span>
                    <span class="arrow" id="pageNext" role="button" tabindex="0" aria-label="Halaman berikutnya"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 6l6 6-6 6"/></svg></span>
                </div>
            </div>
        </section>

    </main>
</div>

<script>
(function () {
    'use strict';

    /* ================== DATA ==================
       Berasal dari variabel rekapSemua di blok PHP paling atas. Satu objek = satu hari:
       d = tanggal (YYYY-MM-DD), l = label baris, p = pesanan, m = minuman, j = jajanan, g = gross (= net) */
    var DATA = @json($rekapSemua);
    DATA.sort(function (a, b) { return a.d < b.d ? -1 : 1; });

    var MIN = DATA[0].d;
    var MAX = DATA[DATA.length - 1].d;
    var PAGE_SIZE = 7;

    var BLN = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    var BLN_FULL = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    var UNIT = { day: 'hari', week: 'minggu', month: 'bulan' };
    var UNIT_CAP = { day: 'Hari', week: 'Minggu', month: 'Bulan' };
    var FIRST_TH = { day: 'TANGGAL / HARI', week: 'PERIODE MINGGU', month: 'PERIODE BULAN' };

    // Tampilan bawaan (sama dengan isi halaman saat pertama dibuka)
    var DEF_TO = MAX;
    var DEF_FROM = addDays(MAX, -6);
    var state = { tab: 'day', from: DEF_FROM, to: DEF_TO, page: 1 };
    var printAll = false;

    function $(id) { return document.getElementById(id); }

    /* ================== HELPER ================== */
    function pad(n) { return (n < 10 ? '0' : '') + n; }
    function parse(iso) { var p = iso.split('-'); return new Date(Date.UTC(+p[0], +p[1] - 1, +p[2])); }
    function toISO(d) { return d.getUTCFullYear() + '-' + pad(d.getUTCMonth() + 1) + '-' + pad(d.getUTCDate()); }
    function addDays(iso, n) { var d = parse(iso); d.setUTCDate(d.getUTCDate() + n); return toISO(d); }
    function maxISO(a, b) { return a > b ? a : b; }
    function minISO(a, b) { return a < b ? a : b; }
    function fmtNum(n) { return String(Math.round(n)).replace(/\B(?=(\d{3})+(?!\d))/g, '.'); }
    function fmtRp(n) { return 'Rp ' + fmtNum(n); }
    function dShort(iso) { var d = parse(iso); return pad(d.getUTCDate()) + ' ' + BLN[d.getUTCMonth()] + ' ' + d.getUTCFullYear(); }

    // "01 - 07 Okt 2024" / "29 Sep - 05 Okt 2024" / "30 Des 2024 - 05 Jan 2025"
    function rangeText(from, to, names) {
        var a = parse(from), b = parse(to);
        var da = pad(a.getUTCDate()), db = pad(b.getUTCDate());
        var ma = names[a.getUTCMonth()], mb = names[b.getUTCMonth()];
        var ya = a.getUTCFullYear(), yb = b.getUTCFullYear();
        if (from === to) return db + ' ' + mb + ' ' + yb;
        if (ya === yb && a.getUTCMonth() === b.getUTCMonth()) return da + ' - ' + db + ' ' + mb + ' ' + yb;
        if (ya === yb) return da + ' ' + ma + ' - ' + db + ' ' + mb + ' ' + yb;
        return da + ' ' + ma + ' ' + ya + ' - ' + db + ' ' + mb + ' ' + yb;
    }

    /* ================== HITUNG DATA ================== */
    function sum(from, to) {
        var t = { n: 0, p: 0, m: 0, j: 0, g: 0 };
        DATA.forEach(function (r) {
            if (r.d >= from && r.d <= to) { t.n++; t.p += r.p; t.m += r.m; t.j += r.j; t.g += r.g; }
        });
        return t;
    }

    // Kelompokkan data sesuai tab. Hasil diurutkan dari yang terbaru.
    function group(tab, from, to) {
        var rows = [];
        if (tab === 'day') {
            for (var i = DATA.length - 1; i >= 0; i--) {
                var r = DATA[i];
                if (r.d >= from && r.d <= to) rows.push({ label: r.l, p: r.p, m: r.m, j: r.j, g: r.g });
            }
        } else if (tab === 'week') {
            // blok 7 hari, dihitung mundur dari tanggal akhir rentang
            var end = to;
            while (end >= from) {
                var start = maxISO(from, addDays(end, -6));
                var w = sum(start, end);
                if (w.n) rows.push({ label: rangeText(start, end, BLN), p: w.p, m: w.m, j: w.j, g: w.g });
                end = addDays(start, -1);
            }
        } else {
            var y = parse(to).getUTCFullYear();
            var mo = parse(to).getUTCMonth();
            var fy = parse(from).getUTCFullYear();
            var fm = parse(from).getUTCMonth();
            while (y > fy || (y === fy && mo >= fm)) {
                var first = y + '-' + pad(mo + 1) + '-01';
                var last = toISO(new Date(Date.UTC(y, mo + 1, 0)));
                var b = sum(maxISO(from, first), minISO(to, last));
                if (b.n) rows.push({ label: BLN_FULL[mo] + ' ' + y, p: b.p, m: b.m, j: b.j, g: b.g });
                mo--;
                if (mo < 0) { mo = 11; y--; }
            }
        }
        return rows;
    }

    /* ================== ELEMEN ================== */
    var tabs = [].slice.call(document.querySelectorAll('.tabs button'));
    var tbody = document.querySelector('.table-panel tbody');
    var tfootCells = document.querySelectorAll('.table-panel tfoot td');
    var thFirst = document.querySelector('.table-panel thead th');
    var pagerInfo = $('pagerInfo');
    var pageInfo = $('pageInfo');
    var dateLabel = $('dateLabel');

    var catInfo = [].slice.call(document.querySelectorAll('.cat-list .cat-row')).map(function (row) {
        var amt = row.querySelector('.amt');
        return {
            amt: amt,
            orig: amt.innerHTML,
            pct: parseFloat(row.querySelector('.bar span').style.width),
            name: row.querySelector('.name').textContent.trim()
        };
    });

    // Simpan tampilan awal kartu statistik: angka pada desain dipakai apa adanya untuk rentang bawaan
    var SNAP_IDS = ['trendNet', 'statNet', 'subNet', 'trendOrders', 'statOrders', 'subOrders', 'trendAov', 'statAov', 'subAov'];
    var snap = {};
    SNAP_IDS.forEach(function (id) { snap[id] = { html: $(id).innerHTML, cls: $(id).className }; });

    function restoreStats() {
        SNAP_IDS.forEach(function (id) { $(id).innerHTML = snap[id].html; $(id).className = snap[id].cls; });
        catInfo.forEach(function (c) { c.amt.innerHTML = c.orig; });
    }

    /* ================== RENDER ================== */
    function setTrend(id, cur, prev, ok) {
        var el = $(id), tv = el.querySelector('.tv');
        if (!ok || !prev) { tv.textContent = '-'; el.classList.remove('down'); return; }
        var pct = (cur - prev) / prev * 100;
        tv.textContent = (pct >= 0 ? '+' : '-') + Math.abs(pct).toFixed(1) + '%';
        el.classList.toggle('down', pct < 0);
    }

    function renderStats() {
        var cur = sum(state.from, state.to);
        var len = Math.round((parse(state.to) - parse(state.from)) / 86400000) + 1;
        var prev = sum(addDays(state.from, -len), addDays(state.from, -1));
        var hasPrev = prev.n === len;              // data pembanding lengkap?
        var porsi = cur.m + cur.j;
        var aov = cur.p ? cur.g / cur.p : 0;

        $('statNet').textContent = fmtRp(cur.g);
        $('statOrders').innerHTML = fmtNum(cur.p) + ' <small>transaksi</small>';
        $('statAov').textContent = fmtRp(aov);

        setTrend('trendNet', cur.g, prev.g, hasPrev);
        setTrend('trendOrders', cur.p, prev.p, hasPrev);
        setTrend('trendAov', aov, prev.p ? prev.g / prev.p : 0, hasPrev);

        $('subNet').textContent = hasPrev ? 'vs ' + fmtRp(prev.g) + ' lalu' : 'belum ada data pembanding';
        $('subOrders').innerHTML = 'Total ' + fmtNum(porsi) + ' porsi terjual<br>(100% selesai)';
        $('subAov').innerHTML = '~' + (cur.p ? (porsi / cur.p).toFixed(1) : '0.0') + ' porsi / pesanan (Rp<br>' + fmtNum(porsi ? cur.g / porsi : 0) + '/porsi)';

        catInfo.forEach(function (c) {
            var sep = /^Rp<br>/.test(c.orig) ? '<br>' : ' ';
            c.amt.innerHTML = 'Rp' + sep + fmtNum(cur.g * c.pct / 100) + '<br>(' + c.pct + '%)';
        });
    }

    function td(text, cls, dot) {
        var el = document.createElement('td');
        if (cls) el.className = cls;
        if (dot) el.appendChild(document.createElement('i'));
        el.appendChild(document.createTextNode(text));
        return el;
    }

    function pagerText(total, page) {
        var range = rangeText(state.from, state.to, BLN_FULL);
        if (total <= PAGE_SIZE || printAll) {
            return 'Menampilkan ' + total + ' ' + UNIT[state.tab] + ' transaksi' + (state.to === MAX ? ' terakhir' : '') + ' (' + range + ')';
        }
        var a = (page - 1) * PAGE_SIZE + 1;
        var b = Math.min(page * PAGE_SIZE, total);
        return 'Menampilkan ' + a + ' - ' + b + ' dari ' + total + ' ' + UNIT[state.tab] + ' transaksi (' + range + ')';
    }

    function render() {
        var rows = group(state.tab, state.from, state.to);
        var pages = Math.max(1, Math.ceil(rows.length / PAGE_SIZE));
        state.page = Math.min(Math.max(1, state.page), pages);
        var shown = printAll ? rows : rows.slice((state.page - 1) * PAGE_SIZE, state.page * PAGE_SIZE);

        thFirst.textContent = FIRST_TH[state.tab];
        tbody.innerHTML = '';
        shown.forEach(function (r) {
            var tr = document.createElement('tr');
            tr.appendChild(td(r.label, '', true));
            tr.appendChild(td(fmtNum(r.p), 'pesanan'));
            tr.appendChild(td(fmtNum(r.m), 'minuman'));
            tr.appendChild(td(fmtNum(r.j)));
            tr.appendChild(td(fmtRp(r.g)));
            tr.appendChild(td(fmtRp(r.g), 'net'));
            tbody.appendChild(tr);
        });

        var t = sum(state.from, state.to);
        tfootCells[1].textContent = fmtNum(t.p);
        tfootCells[2].textContent = fmtNum(t.m);
        tfootCells[3].textContent = fmtNum(t.j);
        tfootCells[4].textContent = fmtRp(t.g);
        tfootCells[5].textContent = fmtRp(t.g);

        pagerInfo.textContent = pagerText(rows.length, state.page);
        pageInfo.textContent = 'Halaman ' + state.page + ' dari ' + pages;
        dateLabel.textContent = dShort(state.from) + ' - ' + dShort(state.to);
        tabs.forEach(function (b) { b.classList.toggle('active', b.getAttribute('data-tab') === state.tab); });

        // Kartu statistik & kategori mengikuti rentang tanggal (bukan tab)
        if (state.from === DEF_FROM && state.to === DEF_TO) restoreStats(); else renderStats();
    }

    /* ================== TAB & PAGER ================== */
    tabs.forEach(function (b) {
        b.addEventListener('click', function () {
            state.tab = b.getAttribute('data-tab');
            state.page = 1;
            render();
        });
    });

    function onActivate(el, fn) {
        el.addEventListener('click', fn);
        el.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); fn(e); }
        });
    }
    onActivate($('pagePrev'), function () { state.page--; render(); });
    onActivate($('pageNext'), function () { state.page++; render(); });

    /* ================== FILTER TANGGAL ================== */
    var pop = $('datePop'), dateBtn = $('dateBtn');
    var fromIn = $('dateFrom'), toIn = $('dateTo'), errEl = $('dateErr');
    var presetBtns = [].slice.call(document.querySelectorAll('#dpPresets button'));
    fromIn.min = MIN; toIn.min = MIN;
    fromIn.max = MAX; toIn.max = MAX;

    function presetRange(key) {
        var to = MAX, from;
        if (key === '7') from = addDays(MAX, -6);
        else if (key === '14') from = addDays(MAX, -13);
        else if (key === '30') from = addDays(MAX, -29);
        else if (key === 'bulan-ini') from = MAX.slice(0, 8) + '01';
        else {                                            // bulan lalu
            var d = parse(MAX.slice(0, 8) + '01');
            d.setUTCDate(0);                              // hari terakhir bulan sebelumnya
            to = toISO(d);
            from = to.slice(0, 8) + '01';
        }
        return { from: maxISO(from, MIN), to: to };
    }

    function markPresets() {
        var found = false;                                  // sorot satu rentang cepat saja
        presetBtns.forEach(function (b) {
            var r = presetRange(b.getAttribute('data-preset'));
            var on = !found && r.from === state.from && r.to === state.to;
            if (on) found = true;
            b.classList.toggle('active', on);
        });
    }

    function showErr(msg) { errEl.textContent = msg; errEl.hidden = false; }

    function openPop() {
        fromIn.value = state.from;
        toIn.value = state.to;
        errEl.hidden = true;
        markPresets();
        pop.hidden = false;
        // posisikan tepat di bawah kolom tanggal (koordinat halaman)
        var r = dateBtn.getBoundingClientRect();
        var left = Math.min(r.left, document.documentElement.clientWidth - pop.offsetWidth - 12);
        pop.style.left = (Math.max(12, left) + window.pageXOffset) + 'px';
        pop.style.top = (r.bottom + window.pageYOffset + 8) + 'px';
        dateBtn.setAttribute('aria-expanded', 'true');
    }
    function closePop() {
        pop.hidden = true;
        dateBtn.setAttribute('aria-expanded', 'false');
    }

    function applyRange(from, to) {
        if (!from || !to) { showErr('Pilih tanggal mulai dan tanggal akhir.'); return; }
        if (from > to) { showErr('Tanggal mulai tidak boleh setelah tanggal akhir.'); return; }
        if (from < MIN || to > MAX) { showErr('Data tersedia untuk ' + dShort(MIN) + ' - ' + dShort(MAX) + '.'); return; }
        state.from = from;
        state.to = to;
        state.page = 1;
        closePop();
        render();
    }

    onActivate(dateBtn, function () { if (pop.hidden) openPop(); else closePop(); });
    presetBtns.forEach(function (b) {
        b.addEventListener('click', function () {
            var r = presetRange(b.getAttribute('data-preset'));
            applyRange(r.from, r.to);
        });
    });
    $('dpApply').addEventListener('click', function () { applyRange(fromIn.value, toIn.value); });
    $('dpCancel').addEventListener('click', closePop);
    document.addEventListener('click', function (e) {
        if (!pop.hidden && !pop.contains(e.target) && !dateBtn.contains(e.target)) closePop();
    });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closePop(); });
    window.addEventListener('resize', closePop);

    /* ================== EKSPOR ================== */
    function csvCell(v) {
        v = String(v);
        return /[";\r\n]/.test(v) ? '"' + v.replace(/"/g, '""') + '"' : v;
    }

    function downloadCsv(matrix, filename) {
        var text = matrix.map(function (row) { return row.map(csvCell).join(';'); }).join('\r\n');
        var blob = new Blob(['\uFEFF' + text], { type: 'text/csv;charset=utf-8;' });
        var url = URL.createObjectURL(blob);
        var a = document.createElement('a');
        a.href = url;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        a.remove();
        setTimeout(function () { URL.revokeObjectURL(url); }, 1000);
    }

    function tableMatrix() {
        var rows = group(state.tab, state.from, state.to);
        var t = sum(state.from, state.to);
        var out = [[FIRST_TH[state.tab], 'PESANAN', 'MINUMAN (CUP)', 'JAJANAN (PCS)', 'GROSS TOTAL (RP)', 'NET OMSET MASUK (RP)']];
        rows.forEach(function (r) { out.push([r.label, r.p, r.m, r.j, r.g, r.g]); });
        out.push(['Total Periode Ini', t.p, t.m, t.j, t.g, t.g]);
        return out;
    }

    function summaryMatrix() {
        var t = sum(state.from, state.to);
        var out = [
            ['Rekapitulasi Penjualan 2da Store'],
            ['Periode', dShort(state.from) + ' - ' + dShort(state.to)],
            ['Tampilan', 'Per ' + UNIT_CAP[state.tab]],
            [],
            ['RINGKASAN'],
            ['Total Pendapatan Bersih (Rp)', t.g],
            ['Pesanan Sukses Selesai (transaksi)', t.p],
            ['Total Porsi Terjual', t.m + t.j],
            ['Rata-rata Nilai Order / AOV (Rp)', t.p ? Math.round(t.g / t.p) : 0],
            [],
            ['KATEGORI MENU', 'OMSET (RP)', 'PERSEN (%)']
        ];
        catInfo.forEach(function (c) { out.push([c.name, Math.round(t.g * c.pct / 100), c.pct]); });
        out.push([]);
        return out.concat(tableMatrix());
    }

    function fileName(prefix) {
        return prefix + '_' + state.from + '_' + state.to + '_per-' + UNIT[state.tab] + '.csv';
    }

    $('btnCsv').addEventListener('click', function (e) {
        e.preventDefault();
        downloadCsv(tableMatrix(), fileName('rekap-penjualan'));
    });
    $('btnExport').addEventListener('click', function (e) {
        e.preventDefault();
        downloadCsv(summaryMatrix(), fileName('ekspor-rekap'));
    });

    // "Unduh PDF": buka dialog cetak yang hanya berisi tabel rekap (pilih "Simpan sebagai PDF")
    $('btnPdf').addEventListener('click', function (e) {
        e.preventDefault();
        var oldTitle = document.title;
        var done = false;
        function restore() {
            if (done) return;
            done = true;
            window.removeEventListener('afterprint', restore);
            printAll = false;
            document.body.classList.remove('print-rekap');
            document.title = oldTitle;
            render();
        }
        window.addEventListener('afterprint', restore);
        document.title = 'Rekap Penjualan ' + dShort(state.from) + ' - ' + dShort(state.to);
        printAll = true;
        document.body.classList.add('print-rekap');
        render();
        window.print();
    });
})();
</script>
</body>
</html>