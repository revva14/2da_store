{{--
  CART SCRIPT  ->  simpan di: resources/views/partials/cart-script.blade.php

  Dipakai di 2 tempat (aman di-include berkali-kali, hanya dimuat sekali):
    - pop-up tambah-keranjang (halaman menu)
    - halaman keranjang

  Menyediakan:
    PRODUCTS    : data produk dari config/menu.php, key = slug
    TwodaCart   : keranjang yang disimpan di localStorage browser
--}}
@once
@php
  $twodaProducts = collect(config('menu'))->map(function ($p) {
      return [
          'name'  => $p['name'],
          'price' => (int) $p['price'],
          'image' => asset('images/' . $p['img']),
          'short' => $p['short'] ?? ($p['desc'] ?? ($p['description'] ?? '')),
      ];
  })->all();
@endphp
<script>
  window.PRODUCTS = @json($twodaProducts);

  window.TwodaCart = (function () {
    var KEY = 'twoda_cart';
    var KEY_CHECKOUT = 'twoda_checkout';

    function read(key, fallback) {
      try {
        var v = JSON.parse(localStorage.getItem(key));
        return (v === null || v === undefined) ? fallback : v;
      } catch (e) { return fallback; }
    }
    function write(key, value) {
      try { localStorage.setItem(key, JSON.stringify(value)); } catch (e) {}
    }
    function all() {
      var v = read(KEY, []);
      return Array.isArray(v) ? v : [];
    }
    // Produk yang sama tapi pilihan saus/topping beda = baris terpisah di keranjang
    function lineKey(id, opts) {
      var names = (opts || []).map(function (o) { return o.name; }).sort();
      return id + '|' + names.join('+');
    }

    return {
      // [{ key, id, qty, opts:[{name, extra}], extra }]
      items: all,

      // opts = pilihan saus/topping dari pop-up: [{ name, extra }]
      add: function (id, qty, opts) {
        qty  = Math.max(1, parseInt(qty, 10) || 1);
        opts = opts || [];
        var key  = lineKey(id, opts);
        var list = all();
        var line = list.find(function (i) { return i.key === key; });

        if (line) {
          line.qty += qty;
        } else {
          list.push({
            key: key,
            id: id,
            qty: qty,
            opts: opts,
            extra: opts.reduce(function (s, o) { return s + (parseInt(o.extra, 10) || 0); }, 0)
          });
        }
        write(KEY, list);
      },

      setQty: function (key, qty) {
        qty = Math.max(1, parseInt(qty, 10) || 1);
        var list = all();
        list.forEach(function (i) { if (i.key === key) i.qty = qty; });
        write(KEY, list);
      },

      remove: function (key) {
        write(KEY, all().filter(function (i) { return i.key !== key; }));
        write(KEY_CHECKOUT, read(KEY_CHECKOUT, []).filter(function (k) { return k !== key; }));
      },

      count: function () {
        return all().reduce(function (s, i) { return s + i.qty; }, 0);
      },

      clear: function () {
        write(KEY, []);
        write(KEY_CHECKOUT, []);
      },

      // item yang dicentang untuk lanjut ke pembayaran (dipanggil halaman keranjang)
      setCheckout: function (keys) { write(KEY_CHECKOUT, keys || []); },
      checkout: function () { return read(KEY_CHECKOUT, []); },
      checkoutItems: function () {
        var keys = read(KEY_CHECKOUT, []);
        return all().filter(function (i) { return keys.indexOf(i.key) !== -1; });
      }
    };
  })();
</script>
@endonce