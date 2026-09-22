<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Akun &amp; Pelanggan - 2da Store</title>
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
        button { font-family: inherit; }

        .layout { display: flex; min-height: 100vh; }
        .main { flex: 1; padding: 19px 26px 51px; min-width: 0; }
        .card { background: var(--card); border-radius: 19px; box-shadow: 0 5px 19px rgba(180,110,50,.07); }

        /* ===== HEADER ===== */
        .head { display: flex; justify-content: space-between; align-items: center; gap: 19px; padding: 19px 19px 19px; margin-top: 6px; background: linear-gradient(90deg, #fff 60%, #fff6ee 100%); animation: rise .6s ease both; }
        .head h1 { font-size: 24px; font-weight: 600; letter-spacing: -.01em; }
        .head p { color: var(--muted); font-size: 11.5px; line-height: 1.5; max-width: 480px; margin-top: 5px; }
        .btn-export { display: flex; align-items: center; gap: 8px; background: #f0e3d6; color: var(--muted); padding: 11px 19px; border-radius: 11px; font-size: 12px; font-weight: 500; margin-right: 16px; transition: transform .25s, background .25s; }
        .btn-export:hover { transform: translateY(-2px); background: #ead8c5; }

        /* ===== STATS ===== */
        .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-top: 26px; align-items: start; }
        .stat { padding: 16px; transition: transform .3s, box-shadow .3s; animation: rise .6s ease both; }
        .stat:hover { transform: translateY(-4px); box-shadow: 0 10px 24px rgba(180,110,50,.14); }
        .stat:nth-child(2) { animation-delay: .08s; } .stat:nth-child(3) { animation-delay: .16s; } .stat:nth-child(4) { animation-delay: .24s; }
        .stat-top { display: flex; justify-content: space-between; align-items: center; }
        .sico { width: 32px; height: 32px; border-radius: 10px; display: grid; place-items: center; color: var(--brown); }
        .sico.a { background: #fbe0d0; } .sico.b { background: #fbe6a8; } .sico.c { background: #fbe0d8; } .sico.d { background: #f3ebe4; color: var(--muted); }
        .chip { font-size: 8.5px; font-weight: 600; padding: 3px 8px; border-radius: 8px; }
        .chip.a { background: #f3ebe4; color: var(--muted); }
        .chip.b { background: #fbedb5; color: #8a5a0a; }
        .chip.c { background: var(--orange); color: #fff; }
        .stat .num { font-size: 30px; font-weight: 600; line-height: 1.1; margin-top: 13px; color: #7a5346; letter-spacing: -.01em; }
        .stat .lbl { font-size: 10.5px; font-weight: 500; margin-top: 3px; }
        .stat .note { display: flex; align-items: center; gap: 5px; font-size: 9.5px; color: var(--muted); margin-top: 11px; }
        .prog { height: 5px; border-radius: 4px; background: #f1ece7; margin-top: 11px; overflow: hidden; }
        .prog span { display: block; height: 100%; border-radius: 4px; background: var(--orange); transform-origin: left; animation: grow 1.2s ease both; }

        /* ===== PANEL DAFTAR ===== */
        .panel { margin-top: 26px; padding: 19px; animation: rise .6s .15s ease both; }
        .p-head { display: flex; justify-content: space-between; align-items: center; gap: 16px; }
        .p-head h2 { font-size: 19px; font-weight: 600; }
        .p-head p { font-size: 10.5px; color: var(--muted); margin-top: 3px; }
        .p-tools { display: flex; align-items: center; gap: 10px; }
        .p-search { display: flex; align-items: center; gap: 8px; background: #fdf1e6; border-radius: 10px; padding: 9px 12px; width: 205px; color: var(--muted); }
        .p-search input { border: 0; outline: 0; background: transparent; font: inherit; font-size: 10px; width: 100%; color: var(--ink); }
        .p-search input::placeholder { color: #a99b92; }
        .p-sort { width: 27px; height: 27px; border-radius: 8px; background: #fdf1e6; border: 0; color: var(--muted); display: grid; place-items: center; cursor: pointer; transition: background .2s; }
        .p-sort:hover { background: #fae4d0; }

        .tabs { display: flex; gap: 10px; margin-top: 19px; }
        .tab { border: 0; background: #fdf1e6; color: var(--ink); font-size: 10.5px; font-weight: 500; padding: 9px 16px; border-radius: 18px; cursor: pointer; transition: background .2s, transform .2s; }
        .tab:hover { background: #fae4d0; transform: translateY(-1px); }
        .tab.active { background: #7a5346; color: #fff; font-weight: 600; }

        .table-wrap { margin-top: 19px; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead th { background: #fbeadb; font-size: 9px; font-weight: 600; letter-spacing: .05em; color: var(--muted); padding: 12px 8px; text-align: left; line-height: 1.5; }
        thead th:first-child { padding-left: 13px; border-radius: 6px 0 0 6px; }
        thead th:last-child { border-radius: 0 6px 6px 0; }
        thead th.r { text-align: right; }
        tbody tr { transition: background .2s; animation: rise .5s ease both; }
        tbody tr:hover { background: #fffaf5; }
        tbody tr:nth-child(2) { animation-delay: .05s; } tbody tr:nth-child(3) { animation-delay: .1s; } tbody tr:nth-child(4) { animation-delay: .15s; } tbody tr:nth-child(5) { animation-delay: .2s; }
        tbody td { padding: 14px 8px; vertical-align: middle; }
        tbody td:first-child { padding-left: 13px; }
        tbody tr.blocked { opacity: .8; }
        .who { display: flex; align-items: center; gap: 10px; }
        .av { position: relative; width: 32px; height: 32px; border-radius: 50%; background: #fbdcc8; color: var(--brown); font-size: 13.5px; font-weight: 600; display: grid; place-items: center; flex-shrink: 0; overflow: hidden; }
        .av img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
        .av.pale { background: #fbe4e0; color: #c86a5a; }
        .av.solid { background: var(--brown); color: #fff; }
        .who strong { display: flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 500; }
        .who strong .root { font-size: 8px; font-weight: 700; color: #fff; background: var(--orange); padding: 1px 6px; border-radius: 4px; letter-spacing: .03em; }
        .who small { display: block; font-size: 10px; color: var(--muted); margin-top: 2px; white-space: nowrap; max-width: 250px; overflow: hidden; text-overflow: ellipsis; }
        tr.blocked .who strong, tr.blocked .who small { color: #8a7d75; }
        .role { display: inline-flex; align-items: center; gap: 5px; font-size: 8.5px; font-weight: 500; line-height: 1.25; padding: 6px 10px; border-radius: 14px; background: #f3ebe4; color: var(--muted); }
        .role i { width: 5px; height: 5px; border-radius: 50%; background: #a99b92; flex-shrink: 0; }
        .role.admin { background: #fbe0d0; color: var(--ink); font-weight: 600; }
        .role.admin i { background: var(--brown); }
        .reg { font-size: 10px; line-height: 1.45; }
        .status { display: inline-flex; align-items: center; gap: 5px; font-size: 9px; font-weight: 600; padding: 5px 10px; border-radius: 12px; }
        .status i { width: 5px; height: 5px; border-radius: 50%; background: currentColor; }
        .status.aktif { background: #fbe0d0; color: var(--brown); }
        .status.blok { background: #fbdcdc; color: var(--red); }
        .aksi { display: grid; place-items: center; width: 26px; height: 26px; border-radius: 50%; background: #f7ede4; color: var(--muted); border: 0; cursor: pointer; transition: background .2s, transform .2s; }
        .aksi:hover { background: #fbdcc8; transform: scale(1.08); }

        .foot { display: flex; justify-content: space-between; align-items: center; background: #fdf1e6; border-radius: 12px; padding: 13px 16px; margin-top: 26px; font-size: 10px; color: var(--muted); }
        .pager { display: flex; gap: 6px; align-items: center; }
        .pager span { min-width: 24px; height: 24px; border-radius: 7px; font-size: 9.5px; font-weight: 600; color: var(--ink); display: grid; place-items: center; padding: 0 6px; cursor: pointer; transition: background .2s; background: #fff; }
        .pager span:hover { background: #fae4d0; }
        .pager span.on { background: var(--orange); color: #fff; }
        .pager span.dis { background: transparent; color: #c9bdb4; }
        .pager span.dots { background: transparent; cursor: default; color: var(--muted); }

        /* ===== FUNGSI: menu urutkan & baris kosong (hanya muncul saat dipakai) ===== */
        .p-tools { position: relative; }
        .p-sort.on { background: #fae4d0; color: var(--brown); }
        .sort-menu { position: absolute; top: calc(100% + 8px); right: 0; z-index: 20; min-width: 176px; padding: 6px; background: var(--card); border: 1px solid var(--line); border-radius: 12px; box-shadow: 0 10px 24px rgba(180,110,50,.18); }
        .sort-menu button { display: block; width: 100%; text-align: left; border: 0; background: transparent; color: var(--ink); font-size: 10.5px; font-weight: 500; padding: 9px 12px; border-radius: 8px; cursor: pointer; transition: background .2s; }
        .sort-menu button:hover { background: #fdf1e6; }
        .sort-menu button.on { background: #fbe0d0; color: var(--brown); font-weight: 600; }
        .sort-menu button.bahaya { color: var(--red); }
        tr[data-peran="pengguna"] .ikon-admin, tr[data-peran="admin"] .ikon-titik { display: none; }
        .pilih-role { display: grid; gap: 8px; margin-top: 12px; }
        .opsi-role { display: flex; align-items: center; gap: 10px; padding: 11px 14px; border: 1px solid var(--line); border-radius: 12px; color: var(--ink); font-size: 12px; font-weight: 500; cursor: pointer; transition: background .2s, border-color .2s; }
        .opsi-role:hover { background: #fdf1e6; }
        .opsi-role.on { background: #fbe0d0; border-color: var(--orange); }
        .opsi-role input { accent-color: var(--orange); }
        .aksi-menu { position: fixed; right: auto; }
        .toast { position: fixed; left: 50%; bottom: 28px; transform: translateX(-50%); z-index: 60; background: #7a5346; color: #fff; font-size: 11px; font-weight: 500; padding: 10px 16px; border-radius: 12px; box-shadow: 0 10px 24px rgba(122,83,70,.3); }
        .modal { position: fixed; inset: 0; z-index: 50; display: grid; place-items: center; padding: 16px; background: rgba(31,20,16,.4); }
        .modal[hidden] { display: none; }
        .modal-box { width: min(420px, 100%); padding: 22px; }
        .modal-box h3 { font-size: 17px; font-weight: 600; }
        .modal-isi { margin-top: 12px; font-size: 11.5px; color: var(--muted); line-height: 1.6; }
        .detail-baris { display: flex; justify-content: space-between; gap: 16px; padding: 9px 0; border-bottom: 1px solid var(--line); }
        .detail-baris:last-child { border-bottom: 0; }
        .detail-baris strong { color: var(--ink); font-weight: 500; text-align: right; word-break: break-word; }
        .modal-aksi { display: flex; justify-content: flex-end; gap: 10px; margin-top: 18px; }
        .modal-aksi button { border: 0; border-radius: 11px; padding: 10px 18px; font-size: 11.5px; font-weight: 600; cursor: pointer; transition: background .2s; }
        .btn-batal { background: #f0e3d6; color: var(--muted); }
        .btn-batal:hover { background: #ead8c5; }
        .btn-ok { background: var(--orange); color: #fff; }
        .btn-ok.bahaya { background: var(--red); }
        tbody tr.kosong td { padding: 36px 8px; text-align: center; font-size: 11px; color: var(--muted); }

        /* ===== ANIMASI ===== */
        @keyframes rise { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: none; } }
        @keyframes grow { from { transform: scaleX(0); } to { transform: scaleX(1); } }

        @media (max-width: 1100px) {
            .stats { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 800px) {
            .head, .p-head { flex-direction: column; align-items: flex-start; }
            .tabs { flex-wrap: wrap; }
        }
    </style>
</head>
<body>
@php
    // Data pengguna (statis sesuai desain). Ganti dengan data dari controller bila sudah siap.
    $pengguna = [
        ['id' => 1, 'nama' => 'Anisa Rahmawati', 'ini' => 'AR', 'foto' => 'images/users/anisa.jpg', 'email' => 'anisa.rahma@gmail.com',    'hp' => '0812-9844-3211', 'root' => false, 'admin' => false, 'reg' => '14 Jan 2024', 'status' => 'aktif', 'blok' => false],
        ['id' => 2, 'nama' => 'Fajar Hidayat',   'ini' => 'FH', 'foto' => 'images/users/fajar.jpg', 'email' => 'fajar.manager@2dastore.id', 'hp' => '0811-3344-9…',   'root' => false, 'admin' => true,  'reg' => '10 Okt 2023', 'status' => 'aktif', 'blok' => false],
        ['id' => 3, 'nama' => 'Siti Kusuma',     'ini' => 'SK', 'foto' => null, 'email' => 'siti.k@yahoo.com',           'hp' => '0878-5544-3321', 'root' => false, 'admin' => false, 'reg' => '22 Feb 2024', 'status' => 'aktif', 'blok' => false],
        ['id' => 4, 'nama' => 'Rian Anggoro',    'ini' => 'RA', 'foto' => null, 'email' => 'rian.fake@mail.com',         'hp' => '0899-2314-1100', 'root' => false, 'admin' => false, 'reg' => '01 Mar 2024', 'status' => 'blok', 'blok' => true],
        ['id' => 5, 'nama' => 'Budi Santoso (Anda)', 'ini' => 'BS', 'foto' => null, 'email' => 'owner@2dastore.id',      'hp' => '0811-2233-4455', 'root' => true,  'admin' => true,  'reg' => '01 Jan 2023', 'status' => 'aktif', 'blok' => false],
    ];

    // Jumlah untuk label tab, dihitung dari data di atas
    $jmlSemua     = count($pengguna);
    $jmlAdmin     = count(array_filter($pengguna, fn ($u) => $u['admin']));
    $jmlPengguna  = $jmlSemua - $jmlAdmin;
    $fmt          = fn ($n) => number_format($n, 0, ',', '.');
@endphp

<div class="layout">

    @include('partials.sidebaradmin')

    <main class="main">

        @include('partials.navbaradmin')

        <header class="card head">
            <div>
                <h1>Kelola Akun &amp; Pelanggan</h1>
                <p>Pantau otentikasi staf gerai, aktivitas transaksi pesanan pelanggan, serta manajemen hak akses pengguna 2da Store.</p>
            </div>
            <a href="{{ url('/admin/pengguna/ekspor') }}" class="btn-export" id="btnEkspor">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3v12M7 10l5 5 5-5M4 20h16"/></svg>
                Export CSV / Excel
            </a>
        </header>

        {{-- ===== STATISTIK ===== --}}
        <section class="stats">
            <div class="card stat">
                <div class="stat-top">
                    <div class="sico a"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="3"/><circle cx="5" cy="10" r="2.2"/><circle cx="19" cy="10" r="2.2"/><path d="M6.5 20c0-3 2.5-5 5.5-5s5.500 2 5.500 5"/></svg></div>
                    <span class="chip a">+12% bln lalu</span>
                </div>
                <div class="num">1.240</div>
                <div class="lbl">Total Pelanggan Terdaftar</div>
                <div class="prog"><span style="width:50%"></span></div>
            </div>
            <div class="card stat">
                <div class="stat-top">
                    <div class="sico b"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3c1 4 5 5 5 10a5 5 0 01-10 0c0-2 1-3 2-4 0 2 1 3 2 3 0-3-1-5 1-9z"/></svg></div>
                    <span class="chip b">72.1% Retensi</span>
                </div>
                <div class="num">895</div>
                <div class="lbl">Pengguna Aktif Bulan Ini</div>
                <div class="note"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M3 17l6-6 4 4 8-8"/></svg>Interaksi checkout &gt; 1× kali</div>
            </div>
            <div class="card stat">
                <div class="stat-top">
                    <div class="sico c"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20c0-3.500 3-6 6.500-6s6.500 2.500 6.500 6"/><path d="M19 8v6M16 11h6"/></svg></div>
                    <span class="chip c">Minggu Ini</span>
                </div>
                <div class="num">+74</div>
                <div class="lbl">Pelanggan Baru Sign-up</div>
            </div>
            <div class="card stat">
                <div class="stat-top">
                    <div class="sico d"><svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="15" rx="2"/><circle cx="9" cy="12" r="2"/><path d="M6 17c0-1.500 1.500-2.500 3-2.500s3 1 3 2.500M15 11h3M15 15h3M9 3v3M15 3v3"/></svg></div>
                </div>
                <div class="num">2</div>
                <div class="lbl">Total Akun Admin Toko</div>
            </div>
        </section>

        {{-- ===== DAFTAR AKUN ===== --}}
        <section class="card panel">
            <div class="p-head">
                <div>
                    <h2>Daftar Akun Pengguna &amp; Hak Akses</h2>
                    <p>Kelola kredensial akun pelanggan, kasir outlet, dan super admin</p>
                </div>
                <div class="p-tools">
                    <label class="p-search">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M20 20l-4-4"/></svg>
                        <input type="text" id="cari" placeholder="Cari nama, email, no HP..." autocomplete="off">
                    </label>
                    <button type="button" class="p-sort" id="btnUrut" aria-label="Urutkan" aria-haspopup="true" aria-expanded="false">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 20V5M4 9l4-4 4 4M16 4v15M12 15l4 4 4-4"/></svg>
                    </button>
                    <div class="sort-menu" id="menuUrut" hidden>
                        <button type="button" data-urut="bawaan" class="on">Urutan bawaan</button>
                        <button type="button" data-urut="nama-az">Nama (A–Z)</button>
                        <button type="button" data-urut="nama-za">Nama (Z–A)</button>
                        <button type="button" data-urut="terbaru">Registrasi terbaru</button>
                        <button type="button" data-urut="terlama">Registrasi terlama</button>
                    </div>
                </div>
            </div>

            <div class="tabs">
                <button type="button" class="tab active" data-filter="semua">Semua Pengguna (<span data-jml="semua">{{ $fmt($jmlSemua) }}</span>)</button>
                <button type="button" class="tab" data-filter="pengguna">Pengguna (<span data-jml="pengguna">{{ $fmt($jmlPengguna) }}</span>)</button>
                <button type="button" class="tab" data-filter="admin">Admin (<span data-jml="admin">{{ $fmt($jmlAdmin) }}</span>)</button>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>PROFIL &amp; KONTAK</th>
                            <th>PERAN &amp; HAK<br>AKSES</th>
                            <th>REGISTRASI</th>
                            <th>STATUS AKUN</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="isiTabel">
                        @foreach ($pengguna as $u)
                            <tr class="{{ $u['blok'] ? 'blocked' : '' }}"
                                data-i="{{ $loop->index }}"
                                data-peran="{{ $u['admin'] ? 'admin' : 'pengguna' }}"
                                data-cari="{{ mb_strtolower($u['nama'].' '.$u['email'].' '.$u['hp'].' '.preg_replace('/\D/', '', $u['hp'])) }}"
                                data-nama="{{ mb_strtolower($u['nama']) }}"
                                data-reg="{{ $u['reg'] }}">
                                <td>
                                    <div class="who">
                                        <div class="av {{ $u['blok'] ? 'pale' : '' }} {{ $u['root'] ? 'solid' : '' }}">
                                            {{ $u['ini'] }}
                                            @if ($u['foto'])
                                                <img src="{{ asset($u['foto']) }}" alt="{{ $u['nama'] }}" onerror="this.style.display='none'">
                                            @endif
                                        </div>
                                        <div>
                                            <strong>{{ $u['nama'] }}@if ($u['root'])<span class="root">ROOT</span>@endif</strong>
                                            <small>{{ $u['email'] }} • {{ $u['hp'] }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="role {{ $u['admin'] ? 'admin' : '' }}"><i></i>{{ $u['admin'] ? 'Admin' : 'Pengguna' }}</span>
                                </td>
                                <td>
                                    <div class="reg">
                                        {{ $u['reg'] }}
                                    </div>
                                </td>
                                <td>
                                    <span class="status {{ $u['status'] }}"><i></i>{{ $u['blok'] ? 'Diblokir' : 'Aktif' }}</span>
                                </td>
                                <td>
                                    <button type="button" class="aksi" data-i="{{ $loop->index }}" aria-label="{{ $u['admin'] ? 'Hak akses' : 'Aksi lainnya' }}" aria-haspopup="true" aria-expanded="false">
                                        <svg class="ikon-admin" width="13" height="13" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M12 2l8 3v6c0 5-3.500 9-8 11-4.500-2-8-6-8-11V5z"/><path d="M9 12l2 2 4-4" stroke="#f7ede4" stroke-width="2" fill="none"/></svg>
                                        <svg class="ikon-titik" width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><circle cx="5" cy="12" r="1.6"/><circle cx="12" cy="12" r="1.6"/><circle cx="19" cy="12" r="1.6"/></svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        <tr class="kosong" id="barisKosong" hidden>
                            <td colspan="5">Tidak ada pengguna yang cocok. Coba kata kunci atau filter lain.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="foot">
                <span id="infoJumlah">Menampilkan 1 - {{ min(6, $jmlSemua) }} dari {{ $fmt($jmlSemua) }} total pengguna</span>
                <div class="pager" id="pager"></div>
            </div>
        </section>

    </main>
</div>

{{-- Menu aksi baris, modal detail/konfirmasi, dan toast (tersembunyi sampai dipakai) --}}
<div class="sort-menu aksi-menu" id="menuAksi" hidden></div>
<div class="modal" id="modal" hidden>
    <div class="card modal-box" role="dialog" aria-modal="true" aria-labelledby="modalJudul">
        <h3 id="modalJudul"></h3>
        <div class="modal-isi" id="modalIsi"></div>
        <div class="modal-aksi">
            <button type="button" class="btn-batal" id="modalBatal">Tutup</button>
            <button type="button" class="btn-ok" id="modalOk" hidden></button>
        </div>
    </div>
</div>
<div class="toast" id="toast" hidden></div>

<script>
(function () {
    var DATA = @json($pengguna);
    var PER_HALAMAN = 6;

    var tbody     = document.getElementById('isiTabel');
    var kosong    = document.getElementById('barisKosong');
    var inputCari = document.getElementById('cari');
    var tabs      = document.querySelectorAll('.tabs .tab');
    var pager     = document.getElementById('pager');
    var info      = document.getElementById('infoJumlah');
    var btnUrut   = document.getElementById('btnUrut');
    var menuUrut  = document.getElementById('menuUrut');
    var btnEkspor = document.getElementById('btnEkspor');

    var BULAN = { jan: 0, feb: 1, mar: 2, apr: 3, mei: 4, may: 4, jun: 5, jul: 6, agu: 7, ags: 7, agt: 7, aug: 7, sep: 8, okt: 9, oct: 9, nov: 10, des: 11, dec: 11 };

    function tanggal(teks) {
        var p = String(teks).trim().toLowerCase().split(/\s+/);
        var b = BULAN[(p[1] || '').slice(0, 3)];
        return new Date(+p[2], b === undefined ? 0 : b, +p[0]).getTime() || 0;
    }

    function angka(n) { return Number(n).toLocaleString('id-ID'); }

    // Ambil data tiap baris dari atribut data-* sekali saja
    var items = Array.prototype.slice.call(tbody.querySelectorAll('tr[data-i]')).map(function (tr) {
        return {
            tr: tr,
            i: +tr.dataset.i,
            peran: tr.dataset.peran,
            cari: tr.dataset.cari,
            nama: tr.dataset.nama,
            tgl: tanggal(tr.dataset.reg)
        };
    });

    var pembanding = {
        'bawaan':  function (a, b) { return a.i - b.i; },
        'nama-az': function (a, b) { return a.nama.localeCompare(b.nama, 'id') || a.i - b.i; },
        'nama-za': function (a, b) { return b.nama.localeCompare(a.nama, 'id') || a.i - b.i; },
        'terbaru': function (a, b) { return b.tgl - a.tgl || a.i - b.i; },
        'terlama': function (a, b) { return a.tgl - b.tgl || a.i - b.i; }
    };

    var state = { filter: 'semua', q: '', urut: 'bawaan', hal: 1 };
    var hasil = [];

    function daftarHalaman(sekarang, semua) {
        var set = {};
        [1, sekarang - 1, sekarang, sekarang + 1, semua].forEach(function (n) {
            if (n >= 1 && n <= semua) set[n] = true;
        });
        var nums = Object.keys(set).map(Number).sort(function (a, b) { return a - b; });
        var out = [];
        nums.forEach(function (n, k) {
            if (k) {
                var selisih = n - nums[k - 1];
                if (selisih === 2) out.push(n - 1);
                else if (selisih > 2) out.push('...');
            }
            out.push(n);
        });
        return out;
    }

    function tambahSpan(teks, kelas, klik) {
        var s = document.createElement('span');
        s.textContent = teks;
        if (kelas) s.className = kelas;
        if (klik) s.addEventListener('click', klik);
        pager.appendChild(s);
    }

    function keHalaman(n) { state.hal = n; render(); }

    function render() {
        hasil = items.filter(function (it) {
            return (state.filter === 'semua' || it.peran === state.filter) &&
                   (!state.q || it.cari.indexOf(state.q) !== -1);
        }).sort(pembanding[state.urut]);

        var total   = hasil.length;
        var jmlHal  = Math.max(1, Math.ceil(total / PER_HALAMAN));
        if (state.hal > jmlHal) state.hal = jmlHal;
        var mulai   = (state.hal - 1) * PER_HALAMAN;
        var tampil  = hasil.slice(mulai, mulai + PER_HALAMAN);

        // Urutan DOM: yang tampil dulu, sisanya (disembunyikan) menyusul
        var sisa  = items.filter(function (it) { return tampil.indexOf(it) === -1; });
        var urutan = tampil.concat(sisa);
        urutan.forEach(function (it, k) {
            it.tr.hidden = k >= tampil.length;
            if (tbody.children[k] !== it.tr) tbody.insertBefore(it.tr, tbody.children[k]);
        });
        kosong.hidden = total > 0;

        info.textContent = total
            ? 'Menampilkan ' + angka(mulai + 1) + ' - ' + angka(mulai + tampil.length) + ' dari ' + angka(total) + ' total pengguna'
            : 'Tidak ada pengguna ditemukan';

        pager.textContent = '';
        tambahSpan('‹', state.hal === 1 ? 'dis' : '', state.hal > 1 ? function () { keHalaman(state.hal - 1); } : null);
        daftarHalaman(state.hal, jmlHal).forEach(function (n) {
            if (n === '...') tambahSpan('...', 'dots');
            else tambahSpan(angka(n), n === state.hal ? 'on' : '', n === state.hal ? null : function () { keHalaman(n); });
        });
        tambahSpan('›', state.hal === jmlHal ? 'dis' : '', state.hal < jmlHal ? function () { keHalaman(state.hal + 1); } : null);
    }

    // ===== Pencarian =====
    inputCari.addEventListener('input', function () {
        state.q = inputCari.value.trim().toLowerCase();
        state.hal = 1;
        render();
    });

    // ===== Tab peran =====
    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            tabs.forEach(function (t) { t.classList.remove('active'); });
            tab.classList.add('active');
            state.filter = tab.dataset.filter;
            state.hal = 1;
            render();
        });
    });

    // ===== Urutkan =====
    function tutupMenu() {
        menuUrut.hidden = true;
        btnUrut.setAttribute('aria-expanded', 'false');
    }
    btnUrut.addEventListener('click', function (e) {
        e.stopPropagation();
        tutupAksi();
        var buka = menuUrut.hidden;
        menuUrut.hidden = !buka;
        btnUrut.setAttribute('aria-expanded', buka ? 'true' : 'false');
    });
    menuUrut.addEventListener('click', function (e) {
        var b = e.target.closest('button[data-urut]');
        if (!b) return;
        state.urut = b.dataset.urut;
        state.hal = 1;
        menuUrut.querySelectorAll('button').forEach(function (x) { x.classList.toggle('on', x === b); });
        btnUrut.classList.toggle('on', state.urut !== 'bawaan');
        tutupMenu();
        render();
    });
    document.addEventListener('click', function (e) {
        if (!menuUrut.hidden && !menuUrut.contains(e.target)) tutupMenu();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') tutupMenu();
    });

    // ===== Export CSV (isi = hasil filter/pencarian saat ini, semua halaman) =====
    function aman(v) {
        v = String(v == null ? '' : v);
        if (/^[=+\-@\t\r]/.test(v)) v = "'" + v; // cegah formula injection di Excel
        return '"' + v.replace(/"/g, '""') + '"';
    }
    btnEkspor.addEventListener('click', function (e) {
        e.preventDefault();
        var baris = [['Nama', 'Email', 'No HP', 'Peran', 'Registrasi', 'Status']];
        hasil.forEach(function (it) {
            var u = DATA[it.i];
            baris.push([u.nama, u.email, u.hp, u.admin ? 'Admin' : 'Pengguna', u.reg, u.blok ? 'Diblokir' : 'Aktif']);
        });
        var csv  = '\uFEFF' + baris.map(function (r) { return r.map(aman).join(','); }).join('\r\n');
        var url  = URL.createObjectURL(new Blob([csv], { type: 'text/csv;charset=utf-8;' }));
        var a    = document.createElement('a');
        a.href = url;
        a.download = 'pengguna-2da-store.csv';
        document.body.appendChild(a);
        a.click();
        a.remove();
        setTimeout(function () { URL.revokeObjectURL(url); }, 1000);
    });

    // ===== Aksi per baris =====
    var menuAksi   = document.getElementById('menuAksi');
    var modal      = document.getElementById('modal');
    var modalJudul = document.getElementById('modalJudul');
    var modalIsi   = document.getElementById('modalIsi');
    var modalOk    = document.getElementById('modalOk');
    var modalBatal = document.getElementById('modalBatal');
    var toastEl    = document.getElementById('toast');
    var aksiBtn    = null;
    var aksiOk     = null;
    var timerToast = null;

    function toast(teks) {
        toastEl.textContent = teks;
        toastEl.hidden = false;
        clearTimeout(timerToast);
        timerToast = setTimeout(function () { toastEl.hidden = true; }, 2200);
    }

    function tutupAksi() {
        menuAksi.hidden = true;
        if (aksiBtn) aksiBtn.setAttribute('aria-expanded', 'false');
        aksiBtn = null;
    }

    function bukaModal(judul, isiFn, teksOk, fnOk, bahaya) {
        modalJudul.textContent = judul;
        modalIsi.textContent = '';
        isiFn(modalIsi);
        aksiOk = fnOk || null;
        modalOk.hidden = !fnOk;
        if (fnOk) {
            modalOk.textContent = teksOk;
            modalOk.className = 'btn-ok' + (bahaya ? ' bahaya' : '');
        }
        modalBatal.textContent = fnOk ? 'Batal' : 'Tutup';
        modal.hidden = false;
        (fnOk ? modalOk : modalBatal).focus();
    }
    function tutupModal() { modal.hidden = true; aksiOk = null; }

    modalBatal.addEventListener('click', tutupModal);
    modalOk.addEventListener('click', function () {
        var f = aksiOk;
        tutupModal();
        if (f) f();
    });
    modal.addEventListener('click', function (e) { if (e.target === modal) tutupModal(); });

    function tampilDetail(u) {
        bukaModal(u.nama, function (box) {
            [
                ['Email', u.email],
                ['No HP', u.hp],
                ['Peran', u.admin ? 'Admin' : 'Pengguna'],
                ['Registrasi', u.reg],
                ['Status akun', u.blok ? 'Diblokir' : 'Aktif']
            ].forEach(function (r) {
                var baris = document.createElement('div');
                baris.className = 'detail-baris';
                var k = document.createElement('span');
                k.textContent = r[0];
                var v = document.createElement('strong');
                v.textContent = r[1];
                baris.appendChild(k);
                baris.appendChild(v);
                box.appendChild(baris);
            });
        });
    }

    function salin(teks) {
        if (navigator.clipboard && window.isSecureContext) return navigator.clipboard.writeText(teks);
        return new Promise(function (ok, gagal) {
            var t = document.createElement('textarea');
            t.value = teks;
            t.style.position = 'fixed';
            t.style.opacity = '0';
            document.body.appendChild(t);
            t.select();
            try { document.execCommand('copy') ? ok() : gagal(); } catch (err) { gagal(err); }
            t.remove();
        });
    }

    function setBlokir(tr, u, blok) {
        u.blok = blok;
        u.status = blok ? 'blok' : 'aktif';
        tr.classList.toggle('blocked', blok);
        tr.querySelector('.av').classList.toggle('pale', blok);
        var st = tr.querySelector('.status');
        st.classList.toggle('aktif', !blok);
        st.classList.toggle('blok', blok);
        st.lastChild.nodeValue = blok ? 'Diblokir' : 'Aktif';
    }

    function hitungTab() {
        var admin = items.filter(function (it) { return it.peran === 'admin'; }).length;
        var jml = { semua: items.length, admin: admin, pengguna: items.length - admin };
        document.querySelectorAll('[data-jml]').forEach(function (el) {
            el.textContent = angka(jml[el.dataset.jml]);
        });
    }

    function setRole(tr, u, admin) {
        var it = items.filter(function (x) { return x.tr === tr; })[0];
        u.admin = admin;
        it.peran = admin ? 'admin' : 'pengguna';
        tr.dataset.peran = it.peran;
        var role = tr.querySelector('.role');
        role.classList.toggle('admin', admin);
        role.lastChild.nodeValue = admin ? 'Admin' : 'Pengguna';
        tr.querySelector('button.aksi').setAttribute('aria-label', admin ? 'Hak akses' : 'Aksi lainnya');
        hitungTab();
        render();
    }

    function ubahRole(tr, u) {
        var awal  = u.admin ? 'admin' : 'pengguna';
        var pilih = awal;
        bukaModal('Edit role', function (box) {
            var p = document.createElement('p');
            p.textContent = 'Pilih role untuk ' + u.nama + '.';
            box.appendChild(p);
            var grup = document.createElement('div');
            grup.className = 'pilih-role';
            [['admin', 'Admin'], ['pengguna', 'Pengguna']].forEach(function (o) {
                var label = document.createElement('label');
                label.className = 'opsi-role' + (o[0] === pilih ? ' on' : '');
                var radio = document.createElement('input');
                radio.type = 'radio';
                radio.name = 'role';
                radio.value = o[0];
                radio.checked = o[0] === pilih;
                radio.addEventListener('change', function () {
                    pilih = o[0];
                    Array.prototype.forEach.call(grup.children, function (l) { l.classList.toggle('on', l === label); });
                });
                label.appendChild(radio);
                label.appendChild(document.createTextNode(o[1]));
                grup.appendChild(label);
            });
            box.appendChild(grup);
        }, 'Simpan', function () {
            if (pilih === awal) { toast('Role tidak berubah'); return; }
            setRole(tr, u, pilih === 'admin');
            toast('Role diubah menjadi ' + (pilih === 'admin' ? 'Admin' : 'Pengguna'));
        });
    }

    function konfirmasiBlokir(tr, u) {
        var blok = !u.blok;
        bukaModal(blok ? 'Blokir akun?' : 'Aktifkan kembali akun?', function (box) {
            var p = document.createElement('p');
            p.textContent = 'Status akun ' + u.nama + ' akan diubah menjadi ' + (blok ? 'Diblokir.' : 'Aktif.');
            box.appendChild(p);
        }, blok ? 'Ya, blokir' : 'Ya, aktifkan', function () {
            setBlokir(tr, u, blok);
            toast(blok ? 'Akun diblokir' : 'Akun diaktifkan kembali');
        }, blok);
    }

    function itemAksi(teks, fn, bahaya) {
        var b = document.createElement('button');
        b.type = 'button';
        b.textContent = teks;
        if (bahaya) b.className = 'bahaya';
        b.addEventListener('click', function () { tutupAksi(); fn(); });
        menuAksi.appendChild(b);
    }

    function bukaAksi(btn) {
        var u  = DATA[+btn.dataset.i];
        var tr = btn.closest('tr');
        tutupMenu();
        menuAksi.textContent = '';
        itemAksi('Lihat detail', function () { tampilDetail(u); });
        if (!u.root) itemAksi('Edit role', function () { ubahRole(tr, u); });
        itemAksi('Salin email', function () {
            salin(u.email).then(function () { toast('Email disalin'); }, function () { toast('Gagal menyalin email'); });
        });
        if (!u.root) {
            itemAksi(u.blok ? 'Aktifkan kembali' : 'Blokir akun', function () { konfirmasiBlokir(tr, u); }, !u.blok);
        }
        menuAksi.hidden = false;
        var r = btn.getBoundingClientRect();
        var w = menuAksi.offsetWidth, h = menuAksi.offsetHeight;
        var kiri = Math.max(8, Math.min(r.right - w, window.innerWidth - w - 8));
        var atas = r.bottom + 6;
        if (atas + h > window.innerHeight - 8) atas = r.top - h - 6;
        menuAksi.style.left = kiri + 'px';
        menuAksi.style.top  = Math.max(8, atas) + 'px';
        aksiBtn = btn;
        btn.setAttribute('aria-expanded', 'true');
    }

    tbody.addEventListener('click', function (e) {
        var btn = e.target.closest('button.aksi');
        if (!btn) return;
        e.stopPropagation();
        if (aksiBtn === btn) { tutupAksi(); return; }
        tutupAksi();
        bukaAksi(btn);
    });
    document.addEventListener('click', function (e) {
        if (!menuAksi.hidden && !menuAksi.contains(e.target)) tutupAksi();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;
        tutupAksi();
        tutupModal();
    });
    window.addEventListener('resize', tutupAksi);
    window.addEventListener('scroll', tutupAksi, true);

    render();
})();
</script>
</body>
</html>