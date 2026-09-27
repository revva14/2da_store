<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pengaturan Toko - 2da Store</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
    </style>
</head>
<body>
<div class="layout">
    @include('partials.sidebaradmin')

    <div class="ps-main" style="flex:1; min-width:0;">
        @include('partials.navbaradmin')

    <style>
        .ps-main{ font-family: 'Poppins','Segoe UI',sans-serif; }
        .ps-wrap{ background:#FBF4EA; padding:23px 29px; min-height:100vh; }
        .ps-headrow{ display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:20px; gap:14.5px; flex-wrap:wrap; }
        .ps-title{ font-size:24.5px; font-weight:700; color:#241A12; margin:0 0 6px 0; }
        .ps-subtitle{ color:#8A7C6E; font-size:11px; line-height:1.5; max-width:461px; margin:0; }
        .ps-headbtns{ display:flex; gap:8.5px; }
        .btn-batal{ background:#F1E7D8; color:#4B3B2A; border:none; padding:10px 18.5px; border-radius:10px; font-weight:600; font-size:11px; cursor:pointer; }
        .btn-simpan{ background:#EE7C33; color:#fff; border:none; padding:10px 18.5px; border-radius:10px; font-weight:600; font-size:11px; cursor:pointer; box-shadow:0 4.5px 10px rgba(238,124,51,0.35); }

        .ps-grid{ display:grid; grid-template-columns:1.85fr 1fr; gap:16px; align-items:start; }
        @media (max-width:1100px){ .ps-grid{ grid-template-columns:1fr; } }

        .ps-card{ background:#fff; border-radius:16px; padding:20px; box-shadow:0 1.5px 7px rgba(60,40,20,0.05); margin-bottom:16px; }
        .ps-card-head{ display:flex; align-items:flex-start; gap:10px; margin-bottom:14.5px; }
        .ps-card-icon{ width:33px; height:33px; min-width:33px; border-radius:8.5px; background:#FBE1C8; color:#E8792E; display:flex; align-items:center; justify-content:center; font-size:14.5px; }
        .ps-card-title{ font-size:13.5px; font-weight:700; color:#241A12; margin:0 0 3px 0; }
        .ps-card-desc{ font-size:9.5px; color:#9A8C7D; margin:0; line-height:1.45; }
        .ps-card-head-flex{ display:flex; justify-content:space-between; align-items:flex-start; width:100%; }

        .badge{ display:inline-block; font-size:8.5px; font-weight:600; padding:3.5px 8.5px; border-radius:14.5px; }
        .badge-orange{ background:#FBE1C8; color:#C1631C; }

        .ps-box{ background:#FAF1E4; border-radius:11.5px; padding:13px 14.5px; margin-bottom:16px; }
        .ps-box-flex{ display:flex; align-items:center; gap:11.5px; flex-wrap:wrap; }
        .logo-box{ width:56px; height:56px; background:#fff; border-radius:10px; display:flex; align-items:center; justify-content:center; padding:4.5px; }
        .logo-box img{ max-width:100%; max-height:100%; }
        .logo-info{ flex:1; min-width:115px; }
        .logo-info-title{ font-weight:600; color:#241A12; font-size:11px; margin-bottom:7px; }
        .btn-white{ background:#fff; border:0.5px solid #EFE3D3; color:#4B3B2A; font-size:9.5px; font-weight:600; padding:6px 10px; border-radius:7px; cursor:pointer; margin-right:6px; }

        .ps-field-row{ display:flex; gap:21.5px; flex-wrap:wrap; margin-bottom:16px; }
        .ps-field{ flex:1; min-width:158.5px; }
        .ps-field label{ display:block; font-size:10px; font-weight:600; color:#241A12; margin-bottom:6px; }
        .req{ color:#E8792E; }
        .ps-input{ display:flex; align-items:center; gap:6px; border-bottom:1px solid #EFE3D3; padding-bottom:7px; color:#3A2E22; font-size:11px; }
        .ps-input i{ color:#B9A78E; font-size:10px; }
        .ps-input input, .ps-input textarea{ border:none; outline:none; background:transparent; font:inherit; color:inherit; width:100%; padding:0; resize:none; }
        .ps-input textarea{ line-height:1.4; }

        .ps-box-between{ display:flex; justify-content:space-between; align-items:center; gap:11.5px; flex-wrap:wrap; }
        .coord-title{ font-weight:600; color:#241A12; font-size:11px; margin-bottom:3px; }
        .coord-sub{ color:#9A8C7D; font-size:9.5px; }
        .btn-outline{ background:#fff; border:0.5px solid #EFE3D3; color:#4B3B2A; font-weight:600; font-size:9.5px; padding:7px 11.5px; border-radius:7px; cursor:pointer; white-space:nowrap; }

        .pay-row{ display:flex; align-items:flex-start; gap:10px; background:#FAF1E4; border-radius:11.5px; padding:11.5px 13px; margin-bottom:10px; }
        .pay-icon{ width:27.5px; height:27.5px; min-width:27.5px; background:#fff; border-radius:7px; display:flex; align-items:center; justify-content:center; color:#E8792E; font-size:11.5px; }
        .pay-title{ font-weight:600; color:#241A12; font-size:11px; margin-right:6px; }
        .pay-desc{ color:#9A8C7D; font-size:9.5px; margin-top:3px; line-height:1.4; }
        .pay-right{ margin-left:auto; }

        .toggle{ position:relative; display:inline-block; width:33px; height:18.5px; }
        .toggle input{ opacity:0; width:0; height:0; }
        .slider{ position:absolute; cursor:pointer; inset:0; background:#E4D8C6; border-radius:24.5px; transition:.2s; }
        .slider:before{ position:absolute; content:""; height:14.5px; width:14.5px; left:2px; bottom:2px; background:#fff; border-radius:50%; transition:.2s; }
        .toggle input:checked + .slider{ background:#EE7C33; }
        .toggle input:checked + .slider:before{ transform:translateX(14.5px); }

        .bottom-two{ display:flex; gap:11.5px; flex-wrap:wrap; }
        .mini-box{ flex:1; min-width:158.5px; background:#FAF1E4; border-radius:11.5px; padding:11.5px 14.5px; display:flex; justify-content:space-between; align-items:center; }
        .mini-label{ font-size:8.5px; font-weight:700; color:#9A8C7D; letter-spacing:.03em; margin-bottom:4.5px; }
        .mini-value{ font-size:12px; font-weight:700; color:#241A12; }
        .mini-box i{ color:#C1631C; font-size:11.5px; }

        .status-box{ background:#FAF1E4; border-radius:11.5px; padding:13px 14.5px; display:flex; justify-content:space-between; align-items:center; margin-bottom:14.5px; }
        .status-dot{ width:6px; height:6px; border-radius:50%; background:#E8792E; display:inline-block; margin-right:6px; }
        .status-title{ font-weight:700; color:#241A12; font-size:11px; margin-bottom:3px; }
        .status-sub{ color:#9A8C7D; font-size:9.5px; }

        .section-label{ font-size:8.5px; font-weight:700; color:#9A8C7D; letter-spacing:.03em; margin-bottom:8.5px; }
        .sched-row{ display:flex; align-items:center; gap:8.5px; background:#FAF1E4; border-radius:10px; padding:10px 11.5px; margin-bottom:8.5px; }
        .sched-row i{ color:#E8792E; }
        .sched-day{ font-weight:600; color:#241A12; font-size:10.5px; flex:1; }
        .sched-time{ background:#fff; border-radius:7px; padding:6px 10px; font-size:9.5px; font-weight:600; color:#3A2E22; display:flex; align-items:center; gap:4.5px; }
        .sched-time input{ border:none; outline:none; background:transparent; font:inherit; color:inherit; width:auto; }
        .sched-live-dot{ width:6px; height:6px; border-radius:50%; background:#E8792E; margin-left:7px; }

        .libur-box{ display:flex; justify-content:space-between; align-items:center; gap:11.5px; background:#FAF1E4; border-radius:11.5px; padding:11.5px 13px; margin-top:4.5px; flex-wrap:wrap; }

        .printer-box{ background:#FAF1E4; border-radius:11.5px; padding:13px 14.5px; margin-bottom:14.5px; }
        .printer-top{ display:flex; align-items:flex-start; gap:10px; margin-bottom:10px; }
        .printer-icon{ width:29px; height:29px; min-width:29px; background:#fff; border-radius:7px; display:flex; align-items:center; justify-content:center; color:#E8792E; font-size:12px; }
        .printer-name{ font-weight:700; color:#241A12; font-size:11px; }
        .printer-sub{ color:#9A8C7D; font-size:9.5px; margin-top:2px; }
        .badge-online{ background:#DFF3E3; color:#2E9E4F; }
        .printer-bottom{ display:flex; justify-content:space-between; align-items:center; gap:10px; flex-wrap:wrap; border-top:0.5px solid #F0E4D3; padding-top:10px; }
        .btn-orange-sm{ background:#EE7C33; color:#fff; border:none; padding:6.5px 11.5px; border-radius:7px; font-weight:600; font-size:9.5px; cursor:pointer; white-space:nowrap; }

        .toggle-row{ display:flex; justify-content:space-between; align-items:center; gap:10px; margin-bottom:13px; }
        .toggle-row-title{ font-weight:600; color:#241A12; font-size:10.5px; margin-bottom:3px; }
        .toggle-row-desc{ color:#9A8C7D; font-size:9.5px; line-height:1.4; }

        .paper-row{ display:flex; justify-content:space-between; align-items:center; gap:10px; flex-wrap:wrap; }
        .paper-label{ font-weight:600; color:#241A12; font-size:10.5px; }
        .paper-btns{ display:flex; gap:6px; }
        .btn-paper{ background:#fff; border:0.5px solid #EFE3D3; color:#4B3B2A; font-weight:600; font-size:9.5px; padding:6.5px 10px; border-radius:7px; cursor:pointer; display:inline-block; }
        .btn-paper.active{ background:#3A2E22; color:#fff; border-color:#3A2E22; }
        .btn-paper input{ display:none; }
    </style>

    <div class="ps-wrap">
        @php
            // $pengaturan dikirim dari route /admin/pengaturan (Pengaturan::first()).
            // Bisa null kalau baris settings belum pernah dibuat sama sekali,
            // makanya semua akses di bawah pakai fallback default.
            $isi = fn (string $k, $default = null) => $pengaturan?->{$k} ?? $default;
            $cek = fn (string $k, bool $default = false) => (bool) ($pengaturan?->{$k} ?? $default);
            $jam = fn (string $k, string $default) => substr((string) $isi($k, $default), 0, 5);

            $qrisAktif     = $cek('qris_aktif', true);
            $tunaiAktif    = $cek('tunai_aktif', true);
            $transferAktif = $cek('transfer_aktif', false);
            $jmlBayarAktif = collect([$qrisAktif, $tunaiAktif, $transferAktif])->filter()->count();

            $kertas = $isi('ukuran_kertas', '80');

            $liburMulaiVal   = $pengaturan?->libur_mulai?->format('Y-m-d');
            $liburSelesaiVal = $pengaturan?->libur_selesai?->format('Y-m-d');
        @endphp

        <div id="psToast" style="display:none; position:fixed; top:18px; right:18px; z-index:999; padding:12px 18px; border-radius:10px; font-size:12px; font-weight:600; color:#fff; box-shadow:0 6px 16px rgba(0,0,0,0.15);"></div>

        <form id="formPengaturan" action="{{ url('/admin/pengaturan') }}" method="POST">
            @csrf

            <div class="ps-headrow">
                <div>
                    <h1 class="ps-title">Pengaturan Toko</h1>
                    <p class="ps-subtitle">Kelola profil gerai jajanan, jam operasional buka/tutup, metode pembayaran QRIS &amp; Tunai, serta integrasi cetak struk dapur secara terpusat.</p>
                </div>
                <div class="ps-headbtns">
                    <button type="button" id="btnBatal" class="btn-batal">Batal</button>
                    <button type="submit" id="btnSimpan" class="btn-simpan">Simpan Perubahan</button>
                </div>
            </div>


            <div class="ps-grid">

                <!-- KOLOM KIRI -->
                <div>
                    <!-- Profil & Identitas Gerai -->
                    <div class="ps-card">
                        <div class="ps-card-head">
                            <div class="ps-card-icon"><i class="fa-solid fa-store"></i></div>
                            <div>
                                <p class="ps-card-title">Profil &amp; Identitas Gerai</p>
                                <p class="ps-card-desc">Informasi publik yang terlihat oleh pembeli di katalog &amp; struk</p>
                            </div>
                        </div>

                        <div class="ps-box">
                            <div class="ps-box-flex">
                                <div class="logo-box">
                                    <img id="logoPreview" src="{{ $isi('logo_path') ? asset('storage/'.$isi('logo_path')) : asset('images/logo.jpg') }}" alt="Logo 2DA Store">
                                </div>
                                <div class="logo-info">
                                    <div class="logo-info-title">Badge Logo &amp; Ikon Gerai</div>
                                    <input type="file" id="inputLogo" name="logo" accept="image/png,image/jpeg,image/webp" style="display:none;">
                                    <button type="button" id="btnUbahLogo" class="btn-white"><i class="fa-regular fa-pen-to-square"></i> Ubah Logo</button>
                                    <button type="button" id="btnPratinjau" class="btn-white"><i class="fa-regular fa-square"></i> Pratinjau</button>
                                </div>
                            </div>
                        </div>

                        <div class="ps-field-row">
                            <div class="ps-field">
                                <label>Nama Toko <span class="req">*</span></label>
                                <div class="ps-input"><input type="text" name="nama_toko" value="{{ $isi('nama_toko', '2DA Store') }}" required></div>
                            </div>
                            <div class="ps-field">
                                <label>Nomor WhatsApp Toko <span class="req">*</span></label>
                                <div class="ps-input"><i class="fa-solid fa-mobile-screen"></i><input type="text" name="whatsapp" value="{{ $isi('whatsapp') }}" required></div>
                            </div>
                        </div>

                        <div class="ps-field-row">
                            <div class="ps-field">
                                <label>Tagline / Slogan Gerai</label>
                                <div class="ps-input"><input type="text" name="tagline" value="{{ $isi('tagline') }}"></div>
                            </div>
                        </div>

                        <div class="ps-field-row">
                            <div class="ps-field">
                                <label>Alamat Lengkap Gerai <span class="req">*</span></label>
                                <div class="ps-input"><textarea name="alamat" rows="2" required>{{ $isi('alamat') }}</textarea></div>
                            </div>
                        </div>

                        <div class="ps-field-row">
                            <div class="ps-field">
                                <label>Titik Koordinat / Catatan Patokan</label>
                                <div class="ps-input"><i class="fa-solid fa-location-dot"></i><input type="text" name="catatan_patokan" value="{{ $isi('catatan_patokan') }}"></div>
                            </div>
                        </div>

                        <div class="ps-box" style="margin-bottom:0;">
                            <div class="ps-box-between">
                                <div>
                                    <div class="coord-title">Kordinat GPS Terpasang</div>
                                    <div class="coord-sub" id="coordDisplay">{{ $isi('latitude', '-') }}, {{ $isi('longitude', '-') }} (Radius Pick-up 10 km)</div>
                                    <input type="hidden" id="inputLat" name="latitude" value="{{ $isi('latitude') }}">
                                    <input type="hidden" id="inputLng" name="longitude" value="{{ $isi('longitude') }}">
                                </div>
                                <button type="button" id="btnSesuaikanPin" class="btn-outline">Sesuaikan Pin</button>
                            </div>
                        </div>
                    </div>

                    <!-- Metode Pembayaran -->
                    <div class="ps-card">
                        <div class="ps-card-head" style="margin-bottom:17px;">
                            <div class="ps-card-icon"><i class="fa-regular fa-credit-card"></i></div>
                            <div class="ps-card-head-flex">
                                <div>
                                    <p class="ps-card-title">Metode Pembayaran</p>
                                    <p class="ps-card-desc">Konfigurasi kanal transaksi.</p>
                                </div>
                                <span class="badge badge-orange">{{ $jmlBayarAktif }} Aktif</span>
                            </div>
                        </div>

                        <div class="pay-row">
                            <div class="pay-icon"><i class="fa-solid fa-qrcode"></i></div>
                            <div>
                                <span class="pay-title">QRIS Real-time Settlement</span>
                                <span class="badge badge-orange">Terverifikasi</span>
                                <div class="pay-desc">GoPay, OVO, Dana, ShopeePay &amp; BCA Mobile (MDPA 0.7%)</div>
                            </div>
                            <div class="pay-right">
                                <input type="hidden" name="qris_aktif" value="0">
                                <label class="toggle"><input type="checkbox" name="qris_aktif" value="1" {{ $qrisAktif ? 'checked' : '' }}><span class="slider"></span></label>
                            </div>
                        </div>

                        <div class="pay-row">
                            <div class="pay-icon"><i class="fa-solid fa-money-bill-wave"></i></div>
                            <div>
                                <span class="pay-title">Tunai / Bayar di Kasir</span>
                                <span class="badge badge-orange">Pick-up</span>
                                <div class="pay-desc">Pembeli mengambil pesanan langsung di gerai dan membayar fisik</div>
                            </div>
                            <div class="pay-right">
                                <input type="hidden" name="tunai_aktif" value="0">
                                <label class="toggle"><input type="checkbox" name="tunai_aktif" value="1" {{ $tunaiAktif ? 'checked' : '' }}><span class="slider"></span></label>
                            </div>
                        </div>

                        <div class="pay-row" style="margin-bottom:16px;">
                            <div class="pay-icon"><i class="fa-solid fa-building-columns"></i></div>
                            <div>
                                <span class="pay-title">Transfer Bank Manual</span>
                                <span class="badge" style="{{ $transferAktif ? 'background:#FBE1C8;color:#C1631C;' : 'background:#EFE3D3;color:#8A7C6E;' }}">{{ $transferAktif ? 'Aktif' : 'Nonaktif' }}</span>
                                <div class="pay-desc">Memerlukan verifikasi mutasi manual oleh kasir (Antrean lambat)</div>
                            </div>
                            <div class="pay-right">
                                <input type="hidden" name="transfer_aktif" value="0">
                                <label class="toggle"><input type="checkbox" name="transfer_aktif" value="1" {{ $transferAktif ? 'checked' : '' }}><span class="slider"></span></label>
                            </div>
                        </div>

                        <div class="bottom-two">
                            <div class="mini-box">
                                <div>
                                    <div class="mini-label">PAJAK RESTO (PB1)</div>
                                    <div class="mini-value">0% (Nol Rupiah)</div>
                                </div>
                                <i class="fa-regular fa-circle-check"></i>
                            </div>
                            <div class="mini-box">
                                <div>
                                    <div class="mini-label">BIAYA KEMASAN &amp; LAYANAN</div>
                                    <div class="mini-value">Rp 0 (Gratis)</div>
                                </div>
                                <i class="fa-regular fa-trash-can"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KOLOM KANAN -->
                <div>
                    <!-- Jam Buka & Operasional -->
                    <div class="ps-card">
                        <div class="ps-card-head">
                            <div class="ps-card-icon"><i class="fa-regular fa-clock"></i></div>
                            <div>
                                <p class="ps-card-title">Jam Buka &amp; Operasional</p>
                                <p class="ps-card-desc">Status langsung dan jadwal penerimaan pesanan</p>
                            </div>
                        </div>

                        <div class="status-box">
                            <div>
                                <div class="status-title"><span class="status-dot"></span>Status Toko: {{ $cek('status_buka', true) ? 'BUKA' : 'TUTUP' }}</div>
                                <div class="status-sub">{{ $cek('status_buka', true) ? 'Gerai sedang menerima pesanan aktif' : 'Gerai sedang tutup, tidak menerima pesanan' }}</div>
                            </div>
                            <input type="hidden" name="status_buka" value="0">
                            <label class="toggle"><input type="checkbox" name="status_buka" value="1" {{ $cek('status_buka', true) ? 'checked' : '' }}><span class="slider"></span></label>
                        </div>

                        <div class="section-label">JADWAL OPERASIONAL HARIAN</div>

                        <div class="sched-row">
                            <i class="fa-regular fa-calendar"></i>
                            <div class="sched-day">Senin - Jumat</div>
                            <div class="sched-time"><input type="time" name="jam_buka_weekday" value="{{ $jam('jam_buka_weekday', '11:00') }}"> - <input type="time" name="jam_tutup_weekday" value="{{ $jam('jam_tutup_weekday', '21:00') }}"> WIB</div>
                            <span class="sched-live-dot"></span>
                        </div>
                        <div class="sched-row" style="margin-bottom:0;">
                            <i class="fa-regular fa-calendar"></i>
                            <div class="sched-day">Sabtu - Minggu</div>
                            <div class="sched-time"><input type="time" name="jam_buka_weekend" value="{{ $jam('jam_buka_weekend', '12:00') }}"> - <input type="time" name="jam_tutup_weekend" value="{{ $jam('jam_tutup_weekend', '21:00') }}"> WIB</div>
                            <span class="sched-live-dot"></span>
                        </div>

                        <div class="libur-box">
                            <div>
                                <div class="coord-title">Mode Libur / Tutup Khusus</div>
                                <div class="coord-sub" id="liburRingkasan">{{ $liburMulaiVal && $liburSelesaiVal ? 'Tutup: '.$liburMulaiVal.' s/d '.$liburSelesaiVal : 'Tutup gerai sementara tanpa ubah jadwal tetap' }}</div>
                            </div>
                            <button type="button" id="btnAturTanggal" class="btn-outline">Atur Tanggal</button>
                        </div>

                        <div id="liburPanel" style="display:{{ $liburMulaiVal && $liburSelesaiVal ? 'block' : 'none' }}; background:#FAF1E4; border-radius:11.5px; padding:11.5px 13px; margin-top:8px;">
                            <div class="ps-field-row" style="margin-bottom:8px;">
                                <div class="ps-field">
                                    <label>Mulai Tutup</label>
                                    <div class="ps-input"><input type="date" id="liburMulai" name="libur_mulai" value="{{ $liburMulaiVal }}"></div>
                                </div>
                                <div class="ps-field">
                                    <label>Sampai</label>
                                    <div class="ps-input"><input type="date" id="liburSelesai" name="libur_selesai" value="{{ $liburSelesaiVal }}"></div>
                                </div>
                            </div>
                            <button type="button" id="btnSimpanLibur" class="btn-outline">Terapkan Tanggal</button>
                        </div>
                    </div>

                    <!-- Printer Thermal & Dapur -->
                    <div class="ps-card">
                        <div class="ps-card-head">
                            <div class="ps-card-icon"><i class="fa-solid fa-print"></i></div>
                            <div>
                                <p class="ps-card-title">Printer Thermal &amp; Dapur</p>
                                <p class="ps-card-desc">Cetak otomatis tiket pesanan &amp; notifikasi audio</p>
                            </div>
                        </div>

                        <div class="printer-box">
                            <div class="printer-top">
                                <div class="printer-icon"><i class="fa-solid fa-receipt"></i></div>
                                <div>
                                    <div class="printer-name">EPSON TM-T82 (Thermal 80mm)</div>
                                    <div class="printer-sub">Printer Kasir &amp; Dapur &bull; USB/LAN</div>
                                </div>
                                <span class="badge badge-online" style="margin-left:auto;">Terkoneksi</span>
                            </div>
                            <div class="printer-bottom">
                                <div class="printer-sub" style="margin-top:0;">Auto-Cetak 2 Lembar (Dapur &amp; Pelanggan)</div>
                                <button type="button" id="btnTesCetak" class="btn-orange-sm"><i class="fa-solid fa-print"></i> Tes Cetak Struk</button>
                            </div>
                        </div>

                        <div class="toggle-row">
                            <div>
                                <div class="toggle-row-title">Auto-Accept Pesanan Masuk</div>
                                <div class="toggle-row-desc">Pesanan langsung masuk ke antrean dapur tanpa konfirmasi kasir</div>
                            </div>
                            <input type="hidden" name="auto_accept" value="0">
                            <label class="toggle"><input type="checkbox" name="auto_accept" value="1" {{ $cek('auto_accept', true) ? 'checked' : '' }}><span class="slider"></span></label>
                        </div>

                        <div class="toggle-row">
                            <div>
                                <div class="toggle-row-title">Audio Notifikasi Suara</div>
                                <div class="toggle-row-desc">Lonceng Nyaring (Volume 80%) saat tiket baru masuk</div>
                            </div>
                            <input type="hidden" name="notif_suara" value="0">
                            <label class="toggle"><input type="checkbox" name="notif_suara" value="1" {{ $cek('notif_suara', true) ? 'checked' : '' }}><span class="slider"></span></label>
                        </div>

                        <div class="paper-row">
                            <div class="paper-label">Ukuran Kertas Thermal</div>
                            <div class="paper-btns">
                                <label class="btn-paper {{ $kertas === '58' ? 'active' : '' }}"><input type="radio" name="ukuran_kertas" value="58" {{ $kertas === '58' ? 'checked' : '' }}>58 mm{{ $kertas === '58' ? ' (Aktif)' : '' }}</label>
                                <label class="btn-paper {{ $kertas === '80' ? 'active' : '' }}"><input type="radio" name="ukuran_kertas" value="80" {{ $kertas === '80' ? 'checked' : '' }}>80 mm{{ $kertas === '80' ? ' (Aktif)' : '' }}</label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
    </div>
</div>

<script>
(function () {
    'use strict';

    function $(id) { return document.getElementById(id); }

    /* ================== TOAST NOTIFIKASI ================== */
    var toastEl = $('psToast');
    var toastTimer = null;
    function toast(message, type) {
        if (!toastEl) return;
        toastEl.textContent = message;
        toastEl.style.background = type === 'error' ? '#D9534F' : (type === 'info' ? '#3A2E22' : '#2E9E4F');
        toastEl.style.display = 'block';
        clearTimeout(toastTimer);
        toastTimer = setTimeout(function () { toastEl.style.display = 'none'; }, 3000);
    }

    /* ================== UKURAN KERTAS THERMAL ================== */
    document.querySelectorAll('.paper-btns .btn-paper').forEach(function (label) {
        label.addEventListener('click', function () {
            document.querySelectorAll('.paper-btns .btn-paper').forEach(function (l) {
                l.classList.remove('active');
            });
            label.classList.add('active');
        });
    });

    /* ================== UBAH LOGO & PRATINJAU ================== */
    var inputLogo = $('inputLogo');
    var logoPreview = $('logoPreview');
    var btnUbahLogo = $('btnUbahLogo');
    var btnPratinjau = $('btnPratinjau');

    if (btnUbahLogo && inputLogo) {
        btnUbahLogo.addEventListener('click', function () { inputLogo.click(); });
    }
    if (inputLogo && logoPreview) {
        inputLogo.addEventListener('change', function () {
            var file = inputLogo.files && inputLogo.files[0];
            if (!file) return;
            if (!file.type.startsWith('image/')) {
                toast('File harus berupa gambar (PNG/JPG/WEBP).', 'error');
                inputLogo.value = '';
                return;
            }
            var reader = new FileReader();
            reader.onload = function (e) { logoPreview.src = e.target.result; };
            reader.readAsDataURL(file);
            toast('Logo baru siap disimpan. Klik "Simpan Perubahan" untuk menerapkannya.', 'info');
        });
    }
    if (btnPratinjau && logoPreview) {
        btnPratinjau.addEventListener('click', function () {
            var w = window.open('', '_blank');
            if (w) {
                w.document.write('<title>Pratinjau Logo</title><body style="margin:0;display:flex;align-items:center;justify-content:center;min-height:100vh;background:#111;"><img src="' + logoPreview.src + '" style="max-width:90%;max-height:90%;"></body>');
            }
        });
    }

    /* ================== SESUAIKAN PIN (GPS) ================== */
    var btnSesuaikanPin = $('btnSesuaikanPin');
    var inputLat = $('inputLat');
    var inputLng = $('inputLng');
    var coordDisplay = $('coordDisplay');
    if (btnSesuaikanPin && inputLat && inputLng && coordDisplay) {
        btnSesuaikanPin.addEventListener('click', function () {
            var lat = prompt('Masukkan Latitude:', inputLat.value);
            if (lat === null) return;
            var lng = prompt('Masukkan Longitude:', inputLng.value);
            if (lng === null) return;
            lat = parseFloat(lat);
            lng = parseFloat(lng);
            if (isNaN(lat) || isNaN(lng)) {
                toast('Koordinat tidak valid, gunakan format angka desimal.', 'error');
                return;
            }
            inputLat.value = lat;
            inputLng.value = lng;
            var radiusMatch = coordDisplay.textContent.match(/\(([^)]+)\)/);
            var radiusText = radiusMatch ? radiusMatch[0] : '';
            coordDisplay.textContent = lat + ', ' + lng + ' ' + radiusText;
            toast('Titik koordinat diperbarui.', 'info');
        });
    }

    /* ================== MODE LIBUR / TUTUP KHUSUS ================== */
    var btnAturTanggal = $('btnAturTanggal');
    var liburPanel = $('liburPanel');
    var btnSimpanLibur = $('btnSimpanLibur');
    var liburMulai = $('liburMulai');
    var liburSelesai = $('liburSelesai');
    var liburRingkasan = $('liburRingkasan');

    if (btnAturTanggal && liburPanel) {
        btnAturTanggal.addEventListener('click', function () {
            liburPanel.style.display = (liburPanel.style.display === 'none') ? 'block' : 'none';
        });
    }
    if (btnSimpanLibur && liburMulai && liburSelesai && liburRingkasan) {
        btnSimpanLibur.addEventListener('click', function () {
            if (!liburMulai.value || !liburSelesai.value) {
                toast('Pilih tanggal mulai dan tanggal selesai terlebih dahulu.', 'error');
                return;
            }
            if (liburMulai.value > liburSelesai.value) {
                toast('Tanggal mulai tidak boleh setelah tanggal selesai.', 'error');
                return;
            }
            liburRingkasan.textContent = 'Tutup: ' + liburMulai.value + ' s/d ' + liburSelesai.value;
            liburPanel.style.display = 'none';
            toast('Jadwal libur diset, jangan lupa Simpan Perubahan.', 'info');
        });
    }

    /* ================== TES CETAK STRUK ================== */
    var btnTesCetak = $('btnTesCetak');
    if (btnTesCetak) {
        btnTesCetak.addEventListener('click', function () {
            var original = btnTesCetak.innerHTML;
            btnTesCetak.disabled = true;
            btnTesCetak.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mencetak...';

            var token = document.querySelector('meta[name="csrf-token"]');
            fetch("{{ url('/admin/pengaturan/tes-cetak') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token ? token.content : '',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then(function (res) {
                if (!res.ok) throw new Error('Gagal');
                toast('Struk uji coba terkirim ke printer.', 'success');
            }).catch(function () {
                toast('Printer tidak merespons. Cek koneksi USB/LAN.', 'error');
            }).finally(function () {
                btnTesCetak.disabled = false;
                btnTesCetak.innerHTML = original;
            });
        });
    }

    /* ================== BATAL ================== */
    var btnBatal = $('btnBatal');
    if (btnBatal) {
        btnBatal.addEventListener('click', function () {
            if (confirm('Batalkan perubahan dan muat ulang halaman?')) {
                window.location.reload();
            }
        });
    }

    /* ================== SIMPAN (SUBMIT FORM VIA AJAX) ================== */
    var form = $('formPengaturan');
    var btnSimpan = $('btnSimpan');
    if (form && btnSimpan) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            var originalLabel = btnSimpan.textContent;
            btnSimpan.disabled = true;
            btnSimpan.textContent = 'Menyimpan...';

            var formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(function (res) {
                    if (!res.ok) throw new Error('Gagal menyimpan (' + res.status + ')');
                    return res;
                })
                .then(function () {
                    toast('Pengaturan toko berhasil disimpan.', 'success');
                })
                .catch(function (err) {
                    toast(err.message || 'Terjadi kesalahan saat menyimpan.', 'error');
                })
                .finally(function () {
                    btnSimpan.disabled = false;
                    btnSimpan.textContent = originalLabel;
                });
        });
    }
})();
</script>
</body>
</html>