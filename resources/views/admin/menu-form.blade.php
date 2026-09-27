<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product->exists ? 'Ubah Menu' : 'Tambah Menu' }} - 2da Store</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #fff6ee; --card: #ffffff; --ink: #1f1410; --muted: #6b5d55;
            --brown: #a34a0a; --orange: #ff8a3d; --cream: #fdf1e6; --red: #c0182b; --line: #f1e4d8;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background: var(--bg); color: var(--ink); font-family: 'Outfit', system-ui, sans-serif; }
        .wrap { max-width: 720px; margin: 40px auto; padding: 0 20px 60px; }
        .card { background: var(--card); border-radius: 19px; box-shadow: 0 5px 19px rgba(180,110,50,.07); padding: 28px 30px; }
        h1 { font-size: 22px; font-weight: 600; margin-bottom: 6px; }
        .sub { color: var(--muted); font-size: 12.5px; margin-bottom: 24px; }
        label { display: block; font-size: 11.5px; font-weight: 600; color: var(--muted); margin: 18px 0 6px; letter-spacing: .02em; }
        input[type=text], input[type=number], textarea, select {
            width: 100%; border: 1px solid var(--line); background: var(--cream); border-radius: 10px;
            padding: 11px 14px; font: inherit; font-size: 13px; color: var(--ink);
        }
        textarea { resize: vertical; min-height: 80px; }
        .row2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .check { display: flex; align-items: center; gap: 8px; margin-top: 16px; font-size: 12.5px; }
        .check input { width: auto; }
        .img-preview { width: 110px; height: 110px; border-radius: 12px; object-fit: cover; background: #f5ebe0; margin-top: 10px; display: block; }
        .err { color: var(--red); font-size: 11px; margin-top: 4px; }
        .actions { display: flex; gap: 12px; margin-top: 28px; }
        .btn { flex: 1; padding: 13px; border-radius: 11px; border: 0; font-size: 13px; font-weight: 600; cursor: pointer; text-align: center; }
        .btn-orange { background: var(--orange); color: #fff; }
        .btn-soft { background: #f3e6da; color: var(--muted); }
    </style>
</head>
<body>
<div class="wrap">
    <div class="card">
        <h1>{{ $product->exists ? 'Ubah Menu' : 'Tambah Menu Baru' }}</h1>
        <p class="sub">Field ini yang dipakai juga di halaman menu pelanggan: nama, deskripsi, gambar, harga &amp; kategori.</p>

        @if ($errors->any())
            <div class="err">
                <ul style="padding-left:16px">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ $product->exists ? url('/admin/menu/'.$product->id) : url('/admin/menu') }}"
              method="POST" enctype="multipart/form-data">
            @csrf
            @if ($product->exists) @method('PUT') @endif

            <label for="name">Nama Produk</label>
            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required>

            <label for="desc">Deskripsi</label>
            <textarea id="desc" name="desc">{{ old('desc', $product->desc) }}</textarea>

            <div class="row2">
                <div>
                    <label for="cats">Kategori</label>
                    <select id="cats" name="cats" required>
                        @foreach ($categories as $key => $meta)
                            <option value="{{ $key }}" {{ old('cats', $product->cats) === $key ? 'selected' : '' }}>
                                {{ $meta['icon'] }} {{ $meta['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="price">Harga Jual (Rp)</label>
                    <input type="number" id="price" name="price" min="0" value="{{ old('price', $product->price) }}" required>
                </div>
            </div>

            <div class="row2">
                <div>
                    <label for="sku">SKU (opsional)</label>
                    <input type="text" id="sku" name="sku" value="{{ old('sku', $product->sku) }}">
                </div>
                <div>
                    <label for="stock">Stok Awal</label>
                    <input type="number" id="stock" name="stock" min="0" value="{{ old('stock', $product->stock ?? 0) }}" required>
                </div>
            </div>

            <label for="img">Foto Produk</label>
            <input type="file" id="img" name="img" accept="image/*" onchange="previewImg(this)">
            <img id="imgPreview" class="img-preview"
                 src="{{ $product->exists && $product->img ? $product->img_url : '' }}"
                 style="{{ $product->exists && $product->img ? '' : 'display:none' }}">

            <div class="check">
                <input type="checkbox" id="is_hot" name="is_hot" value="1" {{ old('is_hot', $product->is_hot) ? 'checked' : '' }}>
                <label for="is_hot" style="margin:0">Tandai sebagai menu favorit / pedas (badge "Hot")</label>
            </div>
            <div class="check">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $product->exists ? $product->is_active : true) ? 'checked' : '' }}>
                <label for="is_active" style="margin:0">Tampilkan &amp; jual di halaman menu pelanggan</label>
            </div>

            <div class="actions">
                <a href="{{ url('/admin/menu') }}" class="btn btn-soft">Batal</a>
                <button type="submit" class="btn btn-orange">{{ $product->exists ? 'Simpan Perubahan' : 'Tambah Menu' }}</button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImg(input) {
        var preview = document.getElementById('imgPreview');
        if (input.files && input.files[0]) {
            preview.src = URL.createObjectURL(input.files[0]);
            preview.style.display = 'block';
        }
    }
</script>
</body>
</html>

