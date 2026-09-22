@extends('layouts.app')

@section('title', 'Testimoni - 2DA Store')

@section('content')
@php
    // Gambar diambil dari public/images/
    $reviews = [
        [
            'type'     => 'photo',
            'img'      => asset('images/corndog.jpg'),
            'cat'      => 'Corndog',
            'group'    => 'corndog',
            'rating'   => 5,
            'icon'     => 'fork',
            'time'     => '1 jam lalu',
            'initials' => 'DP',
            'green'    => false,
            'name'     => 'Dimas Prasetyo',
            'role'     => 'Pecinta Corndog',
            'text'     => 'Corndognya besar dan lapisan tepungnya garing keemasan. Saus sambal dan mayonesnya banyak, jadi rasa gurih, manis, dan pedasnya nyatu. Sosisnya juicy, satu tusuk saja sudah bikin kenyang. Nagih parah!',
            'helpful'  => 38,
            'order'    => '3 Tusuk',
        ],
        [
            'type'     => 'photo',
            'img'      => asset('images/cireng.jpg'),
            'cat'      => 'Cireng Isi',
            'group'    => 'cireng',
            'rating'   => 5,
            'icon'     => 'fork',
            'time'     => '3 jam lalu',
            'initials' => 'RS',
            'green'    => true,
            'name'     => 'Rina Setyowati',
            'role'     => 'Pelanggan Setia Surabaya',
            'text'     => 'Cirengnya digoreng garing, kulitnya renyah tapi bagian dalamnya tetap empuk. Isiannya melimpah dan bumbunya terasa. Paling enak dimakan selagi hangat. Selalu repeat order tiap Jumat.',
            'helpful'  => 52,
            'order'    => '2 Porsi',
        ],
        [
            'type'     => 'photo',
            'img'      => asset('images/mojito.jpg'),
            'cat'      => 'Mojito',
            'group'    => 'minuman',
            'rating'   => 5,
            'icon'     => 'cup',
            'time'     => '5 jam lalu',
            'initials' => 'NP',
            'green'    => false,
            'name'     => 'Nabila Putri',
            'role'     => 'Pecinta Minuman Segar',
            'text'     => 'Mojitonya segar banget! Ada pilihan rasa kuning, merah, biru, sampai oranye, warnanya cantik buat difoto. Manisnya pas dan dingin banget diminum siang hari. Cocok dipasangkan sama gorengan.',
            'helpful'  => 44,
            'order'    => '4 Gelas',
        ],
        [
            'type'     => 'photo',
            'img'      => asset('images/corndog2.jpg'),
            'cat'      => 'Corndog Crispy',
            'group'    => 'corndog',
            'rating'   => 5,
            'icon'     => 'fork',
            'time'     => 'Kemarin',
            'initials' => 'KK',
            'green'    => false,
            'name'     => 'Kak Kevin',
            'role'     => 'Foodie Jakarta',
            'text'     => 'Tepung panirnya tebal dan garing, isian sosisnya padat dan gurih. Disajikan bareng saus cocolan dan irisan kol segar jadi tidak enek. Cocok buat camilan sore bareng teman.',
            'helpful'  => 19,
            'order'    => '5 Tusuk',
        ],
        [
            'type'     => 'text',
            'cat'      => 'Es Coklat',
            'group'    => 'minuman',
            'rating'   => 4,
            'icon'     => 'cup',
            'time'     => '2 hari lalu',
            'initials' => 'FN',
            'green'    => false,
            'name'     => 'Fajar Nugroho',
            'badge'    => '3 Gelas',
            'text'     => 'Es coklat blendernya kental, rasa coklatnya kuat dan dinginnya pas. Ukuran gelasnya lumayan besar jadi puas. Semoga ke depannya ada pilihan level manis biar bisa disesuaikan.',
        ],
        [
            'type'     => 'photo',
            'img'      => asset('images/maryam.jpg'),
            'cat'      => 'Roti Maryam',
            'group'    => 'roti',
            'rating'   => 5,
            'icon'     => 'cake',
            'time'     => '3 hari lalu',
            'initials' => 'RR',
            'green'    => false,
            'name'     => 'Rizky Ramadhan',
            'role'     => 'Sweet Tooth Hunter',
            'text'     => 'Roti maryamnya berlapis-lapis, empuk tapi tetap garing di pinggirnya. Taburan keju dan coklatnya banyak, manis dan gurihnya seimbang. Fix wajib repeat order!',
            'helpful'  => 31,
            'order'    => '2 Porsi',
        ],
        [
            'type'     => 'photo',
            'img'      => asset('images/tahu.jpg'),
            'cat'      => 'Tahu Crispy',
            'group'    => 'goreng',
            'rating'   => 4,
            'icon'     => 'chef',
            'time'     => '4 hari lalu',
            'initials' => 'SM',
            'green'    => false,
            'name'     => 'Sinta Maharani',
            'role'     => 'Pecinta Camilan Pedas',
            'text'     => 'Tahu crispy-nya potongannya kecil-kecil dan garing, bumbunya melimpah dan gurih. Cuma pedasnya kurang buat aku, tapi tetap enak dan porsinya banyak. Pas buat teman nonton.',
            'helpful'  => 27,
            'order'    => '2 Porsi',
        ],
        [
            'type'     => 'photo',
            'img'      => asset('images/kentang.jpg'),
            'cat'      => 'Kentang Goreng',
            'group'    => 'goreng',
            'rating'   => 5,
            'icon'     => 'chef',
            'time'     => '5 hari lalu',
            'initials' => 'AR',
            'green'    => false,
            'name'     => 'Aulia Rahma',
            'role'     => 'Anak Kos Bandung',
            'text'     => 'Kentang gorengnya panjang-panjang, renyah di luar dan lembut di dalam. Saus tomatnya dipisah jadi tetap garing sampai rumah. Porsinya banyak dan harganya ramah buat anak kos.',
            'helpful'  => 22,
            'order'    => '3 Porsi',
        ],
        [
            'type'     => 'photo',
            'img'      => asset('images/jus.jpg'),
            'cat'      => 'Jus Buah',
            'group'    => 'minuman',
            'rating'   => 5,
            'icon'     => 'cup',
            'time'     => '6 hari lalu',
            'initials' => 'TL',
            'green'    => true,
            'name'     => 'Tania Lestari',
            'role'     => 'Pecinta Minuman Segar',
            'text'     => 'Jusnya segar, rasa buahnya asli dan tidak terlalu manis. Sudah coba jus jeruk, tomat, dan kiwi, semuanya enak. Diminum siang-siang pas panas rasanya pas banget.',
            'helpful'  => 35,
            'order'    => '3 Gelas',
        ],
        [
            'type'     => 'photo',
            'img'      => asset('images/tempura.jpg'),
            'cat'      => 'Tempura',
            'group'    => 'goreng',
            'rating'   => 5,
            'icon'     => 'chef',
            'time'     => '1 minggu lalu',
            'initials' => 'GP',
            'green'    => false,
            'name'     => 'Gilang Pratama',
            'role'     => 'Pemburu Gorengan',
            'text'     => 'Potongan tempuranya garing dan bumbunya meresap sampai dalam. Disajikan dalam box lengkap dengan tusuk, jadi praktis dimakan. Gurih dan agak pedas, pas buat ngemil.',
            'helpful'  => 18,
            'order'    => '1 Box',
        ],
        [
            'type'     => 'photo',
            'img'      => asset('images/pao.jpg'),
            'cat'      => 'Bakpao',
            'group'    => 'roti',
            'rating'   => 5,
            'icon'     => 'cake',
            'time'     => '1 minggu lalu',
            'initials' => 'DA',
            'green'    => true,
            'name'     => 'Dewi Anggraini',
            'role'     => 'Ibu Rumah Tangga',
            'text'     => 'Bakpaonya putih, empuk, dan masih hangat waktu sampai. Isian coklatnya manis dan legit. Anak-anak sampai rebutan. Enak buat sarapan atau camilan sore.',
            'helpful'  => 29,
            'order'    => '6 Pcs',
        ],
        [
            'type'     => 'photo',
            'img'      => asset('images/jamur.jpg'),
            'cat'      => 'Jamur Crispy',
            'group'    => 'goreng',
            'rating'   => 4,
            'icon'     => 'chef',
            'time'     => '2 minggu lalu',
            'initials' => 'YA',
            'green'    => false,
            'name'     => 'Yoga Aditya',
            'role'     => 'Foodie Malang',
            'text'     => 'Jamur crispy-nya renyah banget, tepungnya tipis dan bumbunya gurih. Sambalnya pas buat cocolan. Cuma porsinya terasa kurang kalau makan berdua.',
            'helpful'  => 14,
            'order'    => '2 Porsi',
        ],
        [
            'type'     => 'text',
            'cat'      => 'Es Chocolatos',
            'group'    => 'minuman',
            'rating'   => 3,
            'icon'     => 'cup',
            'time'     => '2 minggu lalu',
            'initials' => 'MB',
            'green'    => false,
            'name'     => 'Mas Bagas',
            'badge'    => '2 Gelas',
            'text'     => 'Rasanya enak, coklatnya pekat dan matchanya juga wangi. Tapi esnya cepat mencair jadi agak encer di akhir. Semoga ke depannya lebih dingin dan kental.',
        ],
    ];

    $totalAll   = count($reviews);
    $totalPhoto = count(array_filter($reviews, fn ($r) => $r['type'] === 'photo'));
    $totalText  = $totalAll - $totalPhoto;
    $perPage    = 6;

    $icons = [
        'burger' => '<path d="M4 11a8 6 0 0 1 16 0z"/><path d="M3 15h18"/><path d="M5 19h14a1 1 0 0 0 1-1v-1H4v1a1 1 0 0 0 1 1z"/>',
        'fork'   => '<path d="M6 3v7a2 2 0 0 0 2 2v9"/><path d="M10 3v7"/><path d="M6 3v7"/><path d="M17 3c-2 1.5-3 4-3 7h3v11"/>',
        'cup'    => '<path d="M6 8h11l-1 12H7z"/><path d="M5 8h13"/><path d="M12 8V3l3-1"/>',
        'chef'   => '<path d="M7 14a4 4 0 1 1 1-7.8A4 4 0 0 1 16 6a4 4 0 0 1 1 8z"/><path d="M7 14v6h10v-6"/>',
        'family' => '<circle cx="8" cy="6" r="2"/><circle cx="16" cy="6" r="2"/><path d="M5 20v-7a3 3 0 0 1 6 0v7"/><path d="M13 20v-7a3 3 0 0 1 6 0v7"/>',
        'cake'   => '<path d="M4 20h16"/><path d="M5 20v-6h14v6"/><path d="M12 14V9"/><path d="M12 5c1 1 1 2 0 3-1-1-1-2 0-3z"/>',
    ];
@endphp

<style>
    .tm-page {
        --tm-brown: #A34A0B;
        --tm-dark: var(--ink, #3B1F14);
        --tm-orange: var(--orange, #fd8b3c);
        --tm-orange-soft: #ffe1cf;
        --tm-text: var(--ink-soft, #6b5648);
        --tm-muted: #8a7768;
        --tm-display: var(--font-display, inherit);
        --tm-green: #c9eaa8;
        --tm-green-text: #3f8a2c;
        --tm-star: #f2b544;
        font-family: var(--font-body, system-ui, sans-serif);
        color: var(--tm-text);
        background: var(--cream, #FFF2EA);
        padding: 0 0 72px;
    }
    .tm-page, .tm-page * { box-sizing: border-box; }
    .tm-page h1, .tm-page h2, .tm-page h3, .tm-tab, .tm-more button, .tm-score b, .tm-sold b, .tm-select select { font-family: var(--tm-display); }
    .tm-wrap { width: 100%; max-width: 1240px; margin: 0 auto; padding: 0 clamp(20px, 6vw, 80px); }

    /* Hero */
    .tm-hero { text-align: center; background: radial-gradient(circle at 50% 30%, #fbdcc4 0%, var(--cream, #FFF2EA) 70%); padding: 28px 0 44px; margin-bottom: 32px; }
    .tm-title { margin: 14px 0 12px; font-size: 36px; line-height: 1.15; font-weight: 700; letter-spacing: -0.5px; color: var(--tm-brown); }
    .tm-title span { color: var(--tm-orange); background: linear-gradient(transparent 82%, #ffd2b5 82%); }
    .tm-sub { max-width: 640px; margin: 0 auto; font-size: 15px; line-height: 1.6; color: var(--tm-text); }

    /* Summary */
    .tm-summary { margin-top: 26px; text-align: left; display: flex; align-items: center; gap: 28px; padding: 22px 26px; border: 1px solid #f4d6c5; border-radius: 24px; background: linear-gradient(90deg, #fff1e8, #ffeae0); }
    .tm-score { width: 60px; height: 60px; flex: none; display: flex; flex-direction: column; align-items: center; justify-content: center; background: #fff; border-radius: 18px; box-shadow: 0 4px 14px rgba(138,61,12,.08); }
    .tm-score b { font-size: 25px; line-height: 1; font-weight: 700; color: var(--tm-brown); }
    .tm-score small { margin-top: 3px; font-size: 10px; font-weight: 600; color: var(--tm-muted); }
    .tm-stars { display: flex; gap: 4px; }
    .tm-stars svg { width: 19px; height: 19px; }
    .tm-sum-info { flex: 0 0 240px; }
    .tm-sum-info strong { display: block; margin-top: 8px; font-family: var(--tm-display); font-weight: 600; font-size: 14px; color: var(--tm-dark); }
    .tm-sum-info span { display: block; margin-top: 3px; font-size: 12.5px; color: var(--tm-muted); }
    .tm-bars { flex: 1; padding-left: 28px; border-left: 1px solid #f0d3c2; display: grid; gap: 8px; max-width: 480px; }
    .tm-bar { display: grid; grid-template-columns: 40px 1fr 44px; align-items: center; gap: 12px; font-size: 12px; font-weight: 600; color: var(--tm-dark); }
    .tm-bar i { font-style: normal; display: inline-flex; align-items: center; gap: 4px; }
    .tm-bar i svg { width: 11px; height: 11px; }
    .tm-track { height: 8px; border-radius: 999px; background: #f6e4d9; overflow: hidden; }
    .tm-fill { height: 100%; border-radius: 999px; background: var(--tm-orange); width: 0; animation: tmGrow 1.1s ease-out .2s forwards; }
    .tm-fill.is-gold { background: var(--tm-star); }
    .tm-bar em { font-style: normal; text-align: right; }
    .tm-sold { display: flex; align-items: center; gap: 12px; margin-left: auto; padding: 12px 20px 12px 14px; background: #fff; border-radius: 18px; }
    .tm-sold-ico { width: 40px; height: 40px; display: grid; place-items: center; border-radius: 50%; background: var(--tm-green); color: var(--tm-green-text); }
    .tm-sold-ico svg { width: 19px; height: 19px; }
    .tm-sold b { display: block; font-weight: 700; font-size: 16px; color: var(--tm-dark); }
    .tm-sold span { font-size: 11px; color: var(--tm-muted); }

    /* Filters */
    .tm-filters { display: flex; align-items: center; gap: 12px; margin: 28px 0 24px; }
    .tm-tab { display: inline-flex; align-items: center; gap: 10px; padding: 11px 22px; border: 0; border-radius: 999px; background: #fff; font-weight: 600; font-size: 13.5px; color: var(--tm-dark); box-shadow: 0 6px 16px -12px rgba(59,31,20,.35); cursor: pointer; transition: background .2s ease, color .2s ease, transform .18s ease; }
    .tm-tab:hover { background: #FFE9DB; }
    .tm-tab:active { transform: scale(.97); }
    .tm-tab svg { width: 15px; height: 15px; }
    .tm-tab small { padding: 2px 8px; border-radius: 999px; background: rgba(0,0,0,.06); font-size: 11px; font-weight: 600; }
    .tm-tab.is-active { background: var(--tm-brown); color: #fff; box-shadow: 0 10px 18px -10px rgba(122,59,18,.7); }
    .tm-tab.is-active small { background: rgba(255,255,255,.28); }
    .tm-selects { display: flex; align-items: center; gap: 12px; margin-left: auto; font-size: 12.5px; font-weight: 600; color: var(--tm-dark); }
    .tm-select { position: relative; }
    .tm-select select { appearance: none; -webkit-appearance: none; padding: 9px 38px 9px 16px; border: 0; border-radius: 999px; background: #fff; font-weight: 500; font-size: 12.5px; color: var(--tm-dark); box-shadow: 0 6px 16px -12px rgba(59,31,20,.35); cursor: pointer; }
    .tm-select select.w-cat { min-width: 170px; }
    .tm-select select.w-rate { min-width: 170px; }
    .tm-select svg { position: absolute; right: 16px; top: 50%; width: 14px; height: 14px; transform: translateY(-50%); pointer-events: none; }

    /* Grid & cards */
    .tm-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 22px; align-items: start; }
    .tm-card { overflow: hidden; background: #fff; border-radius: var(--radius-lg, 24px); box-shadow: 0 14px 30px -18px rgba(59,31,20,.28); transition: transform .25s ease, box-shadow .25s ease; }
    .tm-card:hover { transform: translateY(-6px); box-shadow: 0 22px 36px -18px rgba(59,31,20,.38); }
    .tm-photo { position: relative; height: 240px; overflow: hidden; }
    .tm-photo img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .6s ease; }
    .tm-card:hover .tm-photo img { transform: scale(1.05); }
    .tm-photo::after { content: ''; position: absolute; inset: 0; background: linear-gradient(180deg, rgba(0,0,0,.18) 0%, transparent 25%, transparent 70%, rgba(0,0,0,.35) 100%); pointer-events: none; }
    .tm-cat { position: absolute; z-index: 2; top: 14px; left: 14px; display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 999px; background: rgba(255,255,255,.92); font-size: 11px; font-weight: 700; color: var(--tm-brown); }
    .tm-cat svg { width: 12px; height: 12px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
    .tm-time { position: absolute; z-index: 2; left: 14px; bottom: 14px; padding: 3px 9px; border-radius: 7px; background: rgba(50,35,28,.55); font-size: 11px; font-weight: 500; color: #fff; }
    .tm-body { padding: 16px 18px 18px; }
    .tm-user { display: flex; align-items: center; gap: 12px; }
    .tm-avatar { width: 42px; height: 42px; flex: none; display: grid; place-items: center; border-radius: 50%; border: 2px solid #fff; background: var(--tm-orange-soft); font-size: 16px; font-weight: 700; color: var(--tm-brown); box-shadow: 0 0 0 1px #f1d9cb; }
    .tm-avatar.is-green { background: var(--tm-green); color: var(--tm-green-text); box-shadow: 0 0 0 1px #d5ecc0; }
    .tm-user h3 { margin: 0; font-size: 14px; line-height: 1.3; font-weight: 600; color: var(--tm-dark); }
    .tm-user p { margin: 1px 0 0; font-size: 11px; color: var(--tm-muted); }
    .tm-user .tm-stars { margin-left: auto; gap: 4px; }
    .tm-user .tm-stars svg { width: 16px; height: 16px; }
    .tm-quote { margin: 12px 0 0; font-size: 13.5px; line-height: 1.55; color: var(--tm-text); }
    .tm-foot { display: flex; align-items: center; justify-content: space-between; margin-top: 14px; padding-top: 12px; border-top: 1px solid #f6e6dc; font-size: 12.5px; color: var(--tm-muted); }
    .tm-foot button { display: inline-flex; align-items: center; gap: 6px; padding: 0; border: 0; background: none; font: 500 12.5px var(--font-body, inherit); color: var(--tm-muted); cursor: pointer; transition: color .2s; }
    .tm-foot button:hover { color: var(--tm-orange); }
    .tm-foot button svg { width: 17px; height: 17px; fill: none; stroke: currentColor; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
    .tm-chip { padding: 4px 10px; border-radius: 7px; background: #fff0e8; font-size: 11.5px; font-weight: 500; color: var(--tm-text); }

    /* Kartu teks */
    .tm-card--text { padding: 16px 18px 20px; background: linear-gradient(180deg, #fff5ef, #fff); }
    .tm-text-head { display: flex; align-items: center; justify-content: space-between; }
    .tm-text-head .tm-cat { position: static; background: var(--tm-green); color: var(--tm-green-text); }
    .tm-text-head span { font-size: 12px; color: var(--tm-muted); }
    .tm-bubble { position: relative; margin-top: 8px; padding: 22px 24px; border: 1px solid #f6e6dc; border-radius: 18px; background: #fff; }
    .tm-bubble::before { content: '\201D'; position: absolute; top: -14px; left: 2px; font: 800 52px/1 Georgia, serif; color: #fbd9c3; }
    .tm-bubble p { margin: 0; font-size: 13.5px; line-height: 1.55; color: var(--tm-text); }
    .tm-rate-line { display: flex; align-items: center; gap: 12px; margin-top: 16px; padding-bottom: 14px; border-bottom: 1px solid #f6e6dc; }
    .tm-rate-line .tm-stars { gap: 4px; }
    .tm-rate-line .tm-stars svg { width: 17px; height: 17px; }
    .tm-rate-line b { font-size: 13px; color: var(--tm-dark); }
    .tm-text-user { display: flex; align-items: center; gap: 14px; margin-top: 18px; }
    .tm-text-user h3 { margin: 0; font-size: 14px; font-weight: 600; color: var(--tm-dark); }
    .tm-text-user .tm-chip { margin-left: auto; }

    /* Load more */
    .tm-more { display: flex; align-items: center; justify-content: space-between; margin: 56px 0 48px; font-size: 12.5px; color: var(--tm-text); }
    .tm-more b { color: var(--tm-dark); }
    .tm-more button[hidden], .tm-item[hidden], .tm-empty[hidden] { display: none; }
    .tm-empty { padding: 48px 0 8px; text-align: center; font-size: 14px; color: var(--tm-muted); }
    .tm-item.tm-in { animation: tmFade .4s ease; }
    @keyframes tmFade { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: none; } }
    .tm-more button { display: inline-flex; align-items: center; gap: 14px; justify-content: center; padding: 12px 28px; border: 1px solid #f4d6c5; border-radius: 999px; background: #fff1e8; font-weight: 600; font-size: 13.5px; line-height: 1.2; color: var(--tm-dark); cursor: pointer; transition: background .25s; }
    .tm-more button:hover { background: #ffe3d2; }
    .tm-more button svg { width: 17px; height: 17px; flex: none; }


    @keyframes tmGrow { to { width: var(--w); } }
    @media (prefers-reduced-motion: reduce) { .tm-fill { animation: none; width: var(--w); } .tm-card, .tm-photo img { transition: none; } }

    /* Responsive */
    @media (max-width: 1024px) {
        .tm-grid { grid-template-columns: repeat(2, 1fr); }
        .tm-summary { flex-wrap: wrap; }
        .tm-filters { flex-wrap: wrap; }
        .tm-selects { margin-left: 0; }
    }
    @media (max-width: 680px) {
        .tm-title { font-size: 30px; }
        .tm-grid { grid-template-columns: 1fr; }
        .tm-bars { padding-left: 0; border-left: 0; }
        .tm-more { flex-direction: column; gap: 16px; }
    }
</style>

<div class="tm-page">

    {{-- Hero --}}
    <header class="tm-hero">
        <div class="tm-wrap">
            <h1 class="tm-title">Testimoni</h1>
            <p class="tm-sub">Galeri potret dan ulasan autentik para pencinta renyahnya corndog lumer, cireng salju gurih, dan minuman segar racikan khas nusantara kami.</p>

            {{-- Ringkasan rating --}}
            <section class="tm-summary">
                <div class="tm-score"><b>4.9</b><small>SKOR</small></div>
                <div class="tm-sum-info">
                    <div class="tm-stars">
                        <svg viewBox="0 0 24 24" fill="#f2b544"><path id="tmStar" d="M12 2.5l2.9 6 6.6.9-4.8 4.6 1.2 6.5L12 17.4 6.1 20.5l1.2-6.5L2.5 9.4l6.6-.9z"/></svg>
                        <svg viewBox="0 0 24 24" fill="#f2b544"><use href="#tmStar"/></svg>
                        <svg viewBox="0 0 24 24" fill="#f2b544"><use href="#tmStar"/></svg>
                        <svg viewBox="0 0 24 24" fill="#f2b544"><use href="#tmStar"/></svg>
                        <svg viewBox="0 0 24 24">
                            <defs><linearGradient id="tmHalf"><stop offset="50%" stop-color="#f2b544"/><stop offset="50%" stop-color="#f6dcae"/></linearGradient></defs>
                            <use href="#tmStar" fill="url(#tmHalf)"/>
                        </svg>
                    </div>
                    <strong>Kepuasan Bintang Lima</strong>
                    <span>Total 1.248 ulasan</span>
                </div>
                <div class="tm-bars">
                    <div class="tm-bar"><i>5 <svg viewBox="0 0 24 24" fill="#f2b544"><use href="#tmStar"/></svg></i><div class="tm-track"><div class="tm-fill" style="--w:94%"></div></div><em>94%</em></div>
                    <div class="tm-bar"><i>4 <svg viewBox="0 0 24 24" fill="#f2b544"><use href="#tmStar"/></svg></i><div class="tm-track"><div class="tm-fill is-gold" style="--w:5%"></div></div><em>5%</em></div>
                    <div class="tm-bar"><i>&lt;3 <svg viewBox="0 0 24 24" fill="#f2b544"><use href="#tmStar"/></svg></i><div class="tm-track"><div class="tm-fill is-gold" style="--w:1%"></div></div><em>1%</em></div>
                </div>
                <div class="tm-sold">
                    <div class="tm-sold-ico">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8h12l1 12H5z"/><path d="M9 8V6a3 3 0 0 1 6 0v2"/></svg>
                    </div>
                    <div><b>1.200+ Pcs</b><span>Total Terjual Minggu Ini</span></div>
                </div>
            </section>
        </div>
    </header>

    <div class="tm-wrap">


        {{-- Filter --}}
        <div class="tm-filters">
            <button type="button" class="tm-tab is-active" data-tab="semua">Semua <small>{{ $totalAll }}</small></button>
            <button type="button" class="tm-tab" data-tab="foto">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 8h3l2-3h6l2 3h3v11H4z"/><circle cx="12" cy="13" r="3.5"/></svg>
                Dengan Foto <small>{{ $totalPhoto }}</small>
            </button>
            <button type="button" class="tm-tab" data-tab="teks">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7h16M4 12h16M4 17h10"/></svg>
                Hanya Teks <small>{{ $totalText }}</small>
            </button>

            <div class="tm-selects">
                <span>Kategori:</span>
                <div class="tm-select">
                    <select class="w-cat" id="tmCat" aria-label="Kategori">
                        <option value="semua">Semua Menu</option>
                        <option value="corndog">Corndog</option>
                        <option value="cireng">Cireng</option>
                        <option value="goreng">Camilan Goreng</option>
                        <option value="roti">Roti &amp; Bakpao</option>
                        <option value="minuman">Minuman</option>
                    </select>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                </div>
                <span>Rating:</span>
                <div class="tm-select">
                    <select class="w-rate" id="tmRate" aria-label="Rating">
                        <option value="semua">Semua Bintang</option>
                        <option value="5">5 Bintang</option>
                        <option value="4">4 Bintang</option>
                        <option value="3">3 Bintang ke bawah</option>
                    </select>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                </div>
            </div>
        </div>

        {{-- Grid ulasan --}}
        <section class="tm-grid">
            @foreach ($reviews as $r)
                @if ($r['type'] === 'photo')
                    <article class="tm-card tm-item" data-type="photo" data-group="{{ $r['group'] }}" data-rating="{{ $r['rating'] }}" @if ($loop->index >= $perPage) hidden @endif>
                        <div class="tm-photo">
                            <img src="{{ $r['img'] }}" alt="{{ $r['cat'] }}" loading="lazy">
                            <span class="tm-cat">
                                <svg viewBox="0 0 24 24">{!! $icons[$r['icon']] !!}</svg>
                                {{ $r['cat'] }}
                            </span>
                            <span class="tm-time">{{ $r['time'] }}</span>
                        </div>
                        <div class="tm-body">
                            <div class="tm-user">
                                <div class="tm-avatar {{ $r['green'] ? 'is-green' : '' }}">{{ $r['initials'] }}</div>
                                <div>
                                    <h3>{{ $r['name'] }}</h3>
                                    <p>{{ $r['role'] }}</p>
                                </div>
                                <div class="tm-stars">
                                    @for ($i = 0; $i < 5; $i++)
                                        <svg viewBox="0 0 24 24" fill="{{ $i < $r['rating'] ? '#f2b544' : '#f6dcae' }}"><use href="#tmStar"/></svg>
                                    @endfor
                                </div>
                            </div>
                            <p class="tm-quote">“{{ $r['text'] }}”</p>
                            <div class="tm-foot">
                                <button type="button">
                                    <svg viewBox="0 0 24 24"><path d="M7 11v9H4v-9z"/><path d="M7 11l4-7c1.5 0 2.5 1 2.5 2.5V10H19a2 2 0 0 1 2 2.3l-1 6A2 2 0 0 1 18 20H7"/></svg>
                                    Membantu ({{ $r['helpful'] }})
                                </button>
                                <span class="tm-chip">Order: {{ $r['order'] }}</span>
                            </div>
                        </div>
                    </article>
                @else
                    <article class="tm-card tm-card--text tm-item" data-type="text" data-group="{{ $r['group'] }}" data-rating="{{ $r['rating'] }}" @if ($loop->index >= $perPage) hidden @endif>
                        <div class="tm-text-head">
                            <span class="tm-cat" style="color:var(--tm-green-text)">
                                <svg viewBox="0 0 24 24">{!! $icons[$r['icon']] !!}</svg>
                                {{ $r['cat'] }}
                            </span>
                            <span>{{ $r['time'] }}</span>
                        </div>
                        <div class="tm-bubble">
                            <p>“{{ $r['text'] }}”</p>
                        </div>
                        <div class="tm-rate-line">
                            <div class="tm-stars">
                                @for ($i = 0; $i < 5; $i++)
                                    <svg viewBox="0 0 24 24" fill="{{ $i < $r['rating'] ? '#f2b544' : '#f6dcae' }}"><use href="#tmStar"/></svg>
                                @endfor
                            </div>
                            <b>{{ number_format($r['rating'], 1) }}</b>
                        </div>
                        <div class="tm-text-user">
                            <div class="tm-avatar {{ $r['green'] ? 'is-green' : '' }}">{{ $r['initials'] }}</div>
                            <div>
                                <h3>{{ $r['name'] }}</h3>
                            </div>
                            <span class="tm-chip">{{ $r['badge'] }}</span>
                        </div>
                    </article>
                @endif
            @endforeach
        </section>

        <p class="tm-empty" id="tmEmpty" hidden>Belum ada ulasan untuk filter yang dipilih.</p>

        {{-- Muat lebih banyak --}}
        <div class="tm-more">
            <p>Menampilkan <b id="tmShown">{{ min($perPage, $totalAll) }}</b> dari <b id="tmTotal">{{ $totalAll }}</b> ulasan</p>
            <button type="button" id="tmMore" @if ($totalAll <= $perPage) hidden @endif>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 0 1-15.5 6.2L3 16"/><path d="M3 21v-5h5"/><path d="M3 12A9 9 0 0 1 18.5 5.8L21 8"/><path d="M21 3v5h-5"/></svg>
                Muat Lebih Banyak Ulasan
            </button>
        </div>


    </div>
</div>

<script>
    (function () {
        var PAGE = {{ $perPage }};
        var limit = PAGE, tab = 'semua', cat = 'semua', rate = 'semua';

        var items   = [].slice.call(document.querySelectorAll('.tm-item'));
        var tabs    = [].slice.call(document.querySelectorAll('.tm-tab'));
        var catSel  = document.getElementById('tmCat');
        var rateSel = document.getElementById('tmRate');
        var shownEl = document.getElementById('tmShown');
        var totalEl = document.getElementById('tmTotal');
        var moreBtn = document.getElementById('tmMore');
        var emptyEl = document.getElementById('tmEmpty');

        function match(el) {
            var d = el.dataset, r = parseInt(d.rating, 10);
            if (tab === 'foto' && d.type !== 'photo') return false;
            if (tab === 'teks' && d.type !== 'text') return false;
            if (cat !== 'semua' && d.group !== cat) return false;
            if (rate === '5' && r !== 5) return false;
            if (rate === '4' && r !== 4) return false;
            if (rate === '3' && r > 3) return false;
            return true;
        }

        function render() {
            var total = 0, shown = 0;
            items.forEach(function (el) {
                var show = false;
                if (match(el)) {
                    total++;
                    show = total <= limit;
                }
                if (show) {
                    if (el.hidden) {
                        el.hidden = false;
                        el.classList.add('tm-in');
                        el.addEventListener('animationend', function h() {
                            el.classList.remove('tm-in');
                            el.removeEventListener('animationend', h);
                        });
                    }
                    shown++;
                } else {
                    el.hidden = true;
                }
            });
            shownEl.textContent = shown;
            totalEl.textContent = total;
            moreBtn.hidden = total <= limit;
            emptyEl.hidden = total > 0;
        }

        tabs.forEach(function (t) {
            t.addEventListener('click', function () {
                tabs.forEach(function (x) { x.classList.remove('is-active'); });
                t.classList.add('is-active');
                tab = t.dataset.tab;
                limit = PAGE;
                render();
            });
        });
        catSel.addEventListener('change', function () { cat = catSel.value; limit = PAGE; render(); });
        rateSel.addEventListener('change', function () { rate = rateSel.value; limit = PAGE; render(); });
        moreBtn.addEventListener('click', function () { limit += PAGE; render(); });

        render();
    })();
</script>
@endsection