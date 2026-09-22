@extends('layouts.applogin')

@section('title', 'Beri Ulasan & Penilaian')

@section('content')
<style>
    .fp-wrapper {
        max-width: 700px;
        margin: 40px auto;
        padding: 0 16px;
    }

    .fp-card {
        position: relative;
        background: #ffffff;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        padding: 32px 32px 28px;
    }

    .fp-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, #ffd54f 0%, #ff9800 50%, #ff5722 100%);
    }

    .fp-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fff3e0;
        color: #ff8a00;
        font-size: 13px;
        font-weight: 700;
        padding: 6px 14px;
        border-radius: 999px;
        margin-bottom: 16px;
    }

    .fp-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .fp-close {
        background: none;
        border: none;
        font-size: 22px;
        color: #9e9e9e;
        cursor: pointer;
        line-height: 1;
        padding: 4px;
    }

    .fp-close:hover {
        color: #616161;
    }

    .fp-title {
        font-size: 28px;
        font-weight: 800;
        color: #3e2723;
        margin: 0 0 8px;
    }

    .fp-subtitle {
        font-size: 14px;
        color: #9e9e9e;
        margin: 0 0 24px;
    }

    .fp-subtitle b {
        color: #616161;
        font-weight: 700;
    }

    .fp-order-box {
        display: flex;
        align-items: center;
        gap: 16px;
        background: #fff8f2;
        border: 1px solid #ffe6cc;
        border-radius: 16px;
        padding: 18px 20px;
        margin-bottom: 28px;
    }

    .fp-order-icon {
        flex-shrink: 0;
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #ffe0b2;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: #f57c00;
    }

    .fp-order-info {
        flex: 1;
    }

    .fp-order-info .item-name {
        font-weight: 700;
        color: #3e2723;
        font-size: 15px;
    }

    .fp-order-info .item-name span {
        font-weight: 500;
        color: #757575;
    }

    .fp-order-info .item-sub {
        font-size: 13px;
        color: #9e9e9e;
        margin-top: 2px;
    }

    .fp-order-price {
        text-align: right;
        flex-shrink: 0;
    }

    .fp-order-price .price {
        font-weight: 800;
        color: #ff7a00;
        font-size: 15px;
    }

    .fp-order-price .qty {
        font-size: 12px;
        color: #bdbdbd;
        margin-top: 2px;
    }

    .fp-section-title {
        text-align: center;
        font-weight: 700;
        color: #3e2723;
        font-size: 16px;
        margin-bottom: 16px;
    }

    .fp-stars {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 12px;
    }

    .fp-star {
        font-size: 40px;
        color: #e0e0e0;
        cursor: pointer;
        transition: transform 0.15s ease, color 0.15s ease;
        user-select: none;
    }

    .fp-star.active {
        color: #ffb300;
    }

    .fp-star:hover {
        transform: scale(1.15);
    }

    .fp-rating-result {
        text-align: center;
        font-size: 15px;
        color: #616161;
        margin-bottom: 28px;
    }

    .fp-rating-result .score {
        color: #ff7a00;
        font-weight: 800;
    }

    .fp-label {
        font-size: 13px;
        font-weight: 700;
        color: #3e2723;
        letter-spacing: 0.3px;
        margin-bottom: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .fp-label .fp-optional {
        font-weight: 500;
        color: #bdbdbd;
        text-transform: none;
        letter-spacing: 0;
    }

    .fp-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 24px;
    }

    .fp-chip {
        border: 1px solid #e0e0e0;
        background: #ffffff;
        color: #616161;
        font-size: 14px;
        font-weight: 600;
        padding: 10px 18px;
        border-radius: 999px;
        cursor: pointer;
        transition: all 0.15s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .fp-chip:hover {
        border-color: #ffb74d;
    }

    .fp-chip.selected {
        border-color: #ff9800;
        background: #fff3e0;
        color: #ff8a00;
    }

    .fp-textarea-wrap {
        position: relative;
        margin-bottom: 24px;
    }

    .fp-textarea {
        width: 100%;
        min-height: 100px;
        border: 1px solid #e0e0e0;
        border-radius: 16px;
        padding: 16px;
        font-size: 14px;
        color: #3e2723;
        resize: vertical;
        font-family: inherit;
        box-sizing: border-box;
    }

    .fp-textarea::placeholder {
        color: #bdbdbd;
    }

    .fp-textarea:focus {
        outline: none;
        border-color: #ff9800;
    }

    .fp-char-count {
        position: absolute;
        top: -26px;
        right: 0;
        font-size: 12px;
        color: #bdbdbd;
    }

    .fp-photo-upload {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 20px;
    }

    .fp-photo-box {
        flex-shrink: 0;
        width: 96px;
        height: 96px;
        border: 2px dashed #e0e0e0;
        border-radius: 16px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 4px;
        color: #9e9e9e;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        background: none;
    }

    .fp-photo-box:hover {
        border-color: #ffb74d;
        color: #ff8a00;
    }

    .fp-photo-box .fp-camera-icon {
        font-size: 22px;
    }

    .fp-photo-hint {
        font-size: 13px;
        color: #9e9e9e;
        line-height: 1.5;
    }

    .fp-divider {
        border: none;
        border-top: 1px solid #eeeeee;
        margin: 24px 0 20px;
    }

    .fp-anon-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 28px;
    }

    .fp-anon-text .fp-anon-title {
        font-weight: 700;
        color: #3e2723;
        font-size: 15px;
        margin-bottom: 2px;
    }

    .fp-anon-text .fp-anon-desc {
        font-size: 13px;
        color: #9e9e9e;
    }

    .fp-switch {
        position: relative;
        width: 46px;
        height: 26px;
        flex-shrink: 0;
    }

    .fp-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .fp-switch-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #e0e0e0;
        border-radius: 999px;
        transition: 0.2s;
    }

    .fp-switch-slider::before {
        content: "";
        position: absolute;
        height: 20px;
        width: 20px;
        left: 3px;
        bottom: 3px;
        background-color: #ffffff;
        border-radius: 50%;
        transition: 0.2s;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    }

    .fp-switch input:checked + .fp-switch-slider {
        background-color: #ff9800;
    }

    .fp-switch input:checked + .fp-switch-slider::before {
        transform: translateX(20px);
    }

    .fp-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding-top: 16px;
        border-top: 1px solid #eeeeee;
    }

    .fp-btn {
        padding: 13px 26px;
        border-radius: 14px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: transform 0.1s ease, box-shadow 0.15s ease;
    }

    .fp-btn:active {
        transform: scale(0.97);
    }

    .fp-btn-secondary {
        background: #ffffff;
        color: #616161;
        border: 1px solid #e0e0e0;
    }

    .fp-btn-secondary:hover {
        background: #fafafa;
    }

    .fp-btn-primary {
        background: linear-gradient(90deg, #ff9800, #ff7043);
        color: #ffffff;
        box-shadow: 0 6px 16px rgba(255, 152, 0, 0.35);
    }

    .fp-btn-primary:hover {
        box-shadow: 0 8px 20px rgba(255, 152, 0, 0.45);
    }

    @media (max-width: 480px) {
        .fp-card {
            padding: 24px 18px 22px;
            border-radius: 18px;
        }

        .fp-title {
            font-size: 22px;
        }

        .fp-star {
            font-size: 32px;
        }

        .fp-actions {
            flex-direction: column-reverse;
        }

        .fp-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="fp-wrapper">
    <div class="fp-card">
        <div class="fp-header">
            <span class="fp-badge">★ Form Ulasan</span>
            <button type="button" class="fp-close" onclick="history.back()">&times;</button>
        </div>

        <h1 class="fp-title">Beri Ulasan &amp; Penilaian</h1>
        {{-- TEKNIS 1: data pesanan diambil dari controller, contoh variable $pesanan --}}
        <p class="fp-subtitle">Pesanan <b>#{{ $pesanan->kode ?? '2DA-84920' }}</b> &bull; {{ $pesanan->tanggal ?? '12 Okt 2024, 19:30 WIB' }}</p>

        <div class="fp-order-box">
            <div class="fp-order-icon">🔒</div>
            <div class="fp-order-info">
                <div class="item-name">1&times; Corndog Mini Mozarella <span>(Saus Mayo)</span></div>
                <div class="item-sub">1&times; Ice Good Day Freeze (Extra Ice)</div>
            </div>
            <div class="fp-order-price">
                <div class="price">Rp 10.000</div>
                <div class="qty">2 ITEM</div>
            </div>
        </div>

        {{-- TEKNIS 2: action form disesuaikan dengan route project, contoh route('ulasan.store') --}}
        <form action="{{ route('ulasan.store', $pesanan->id ?? '') }}" method="POST" enctype="multipart/form-data" id="formUlasan">
            @csrf

            <p class="fp-section-title">Bagaimana pengalaman jajanmu kali ini?</p>

            <div class="fp-stars" id="fpStars">
                <span class="fp-star" data-value="1">★</span>
                <span class="fp-star" data-value="2">★</span>
                <span class="fp-star" data-value="3">★</span>
                <span class="fp-star" data-value="4">★</span>
                <span class="fp-star" data-value="5">★</span>
            </div>
            <input type="hidden" name="rating" id="fpRatingInput" value="5">

            <p class="fp-rating-result"><span class="score" id="fpScore">5.0</span> &bull; <span id="fpRatingText">Sangat Lezat &amp; Memuaskan!</span></p>

            <div class="fp-label">APA YANG PALING KAMU SUKAI? (BISA PILIH LEBIH DARI SATU)</div>
            <div class="fp-chips" id="fpChips">
                <button type="button" class="fp-chip selected" data-value="Rasa Juara">Rasa Juara <span class="fp-check">✓</span></button>
                <button type="button" class="fp-chip selected" data-value="Porsi Pas">Porsi Pas <span class="fp-check">✓</span></button>
                <button type="button" class="fp-chip" data-value="Masih Panas &amp; Renyah">Masih Panas &amp; Renyah</button>
                <button type="button" class="fp-chip" data-value="Pengantaran Cepat">Pengantaran Cepat</button>
                <button type="button" class="fp-chip" data-value="Kemasan Rapi">Kemasan Rapi</button>
                <button type="button" class="fp-chip" data-value="Harga Ramah di Kantong">Harga Ramah di Kantong</button>
            </div>
            <input type="hidden" name="highlights" id="fpHighlightsInput" value="Rasa Juara,Porsi Pas">

            <div class="fp-label">Tulis Ulasan atau Masukan <span class="fp-optional">(Opsional)</span></div>
            <div class="fp-textarea-wrap">
                <span class="fp-char-count"><span id="fpCharCount">0</span> / 300</span>
                <textarea class="fp-textarea" name="ulasan" id="fpUlasan" maxlength="300" placeholder="Ceritakan kelezatan corndog & kesegaran Good Day Freeze pesananmu..."></textarea>
            </div>

            <div class="fp-label" style="margin-bottom:14px;">Foto Makanan <span class="fp-optional">(Maksimal 3 foto)</span></div>
            <div class="fp-photo-upload">
                <label class="fp-photo-box">
                    <span class="fp-camera-icon">📷</span>
                    <span>+ Tambah</span>
                    <input type="file" name="foto[]" accept="image/jpeg,image/png" multiple hidden>
                </label>
                <div class="fp-photo-hint">
                    Format yang didukung: JPG, PNG.<br>
                    Bantu teman jajan melihat tampilan asli pesananmu!
                </div>
            </div>

            <hr class="fp-divider">

            <div class="fp-anon-row">
                <div class="fp-anon-text">
                    <div class="fp-anon-title">Kirim Secara Anonim</div>
                    <div class="fp-anon-desc">Nama akunmu akan disamarkan menjadi R***a pada ulasan publik</div>
                </div>
                <label class="fp-switch">
                    <input type="checkbox" name="anonim" id="fpAnonim" value="1">
                    <span class="fp-switch-slider"></span>
                </label>
            </div>

            <div class="fp-actions">
                <button type="button" class="fp-btn fp-btn-secondary" onclick="history.back()">Nanti Saja</button>
                <button type="submit" class="fp-btn fp-btn-primary">&#9888; Kirim Ulasan</button>
            </div>
        </form>
    </div>
</div>

<script>
    (function () {
        const stars = document.querySelectorAll('#fpStars .fp-star');
        const ratingInput = document.getElementById('fpRatingInput');
        const scoreEl = document.getElementById('fpScore');
        const ratingTextEl = document.getElementById('fpRatingText');

        const ratingLabels = {
            1: 'Kurang Memuaskan',
            2: 'Cukup Lumayan',
            3: 'Lumayan Enak',
            4: 'Enak & Memuaskan',
            5: 'Sangat Lezat & Memuaskan!'
        };

        function setStars(value) {
            stars.forEach(function (star) {
                star.classList.toggle('active', parseInt(star.dataset.value) <= value);
            });
            ratingInput.value = value;
            scoreEl.textContent = value.toFixed(1);
            ratingTextEl.textContent = ratingLabels[value] || '';
        }

        stars.forEach(function (star) {
            star.addEventListener('click', function () {
                setStars(parseInt(star.dataset.value));
            });
        });

        setStars(5);

        const chips = document.querySelectorAll('#fpChips .fp-chip');
        const highlightsInput = document.getElementById('fpHighlightsInput');

        function updateHighlights() {
            const selected = Array.from(chips)
                .filter(function (c) { return c.classList.contains('selected'); })
                .map(function (c) { return c.dataset.value; });
            highlightsInput.value = selected.join(',');
        }

        chips.forEach(function (chip) {
            chip.addEventListener('click', function () {
                chip.classList.toggle('selected');
                if (chip.classList.contains('selected')) {
                    if (!chip.querySelector('.fp-check')) {
                        const check = document.createElement('span');
                        check.className = 'fp-check';
                        check.textContent = ' ✓';
                        chip.appendChild(check);
                    }
                } else {
                    const check = chip.querySelector('.fp-check');
                    if (check) check.remove();
                }
                updateHighlights();
            });
        });

        const textarea = document.getElementById('fpUlasan');
        const charCount = document.getElementById('fpCharCount');
        textarea.addEventListener('input', function () {
            charCount.textContent = textarea.value.length;
        });
    })();
</script>
@endsection
