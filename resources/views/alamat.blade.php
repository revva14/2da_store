@extends('layouts.applogin')

@section('title', __('alamat.page_title'))

@push('styles')
<style>
  /* ---------- ACCOUNT PAGE (sama persis dengan biodata) ---------- */
  .account-page{
    padding: 48px 0 90px;
    position:relative;
    overflow:hidden;
  }
  .account-page::before{
    content:"";
    position:absolute;
    top:-120px; left:-160px;
    width:520px; height:520px;
    background: radial-gradient(circle, var(--peach) 0%, transparent 70%);
    opacity:.6;
    pointer-events:none;
    z-index:0;
  }
  .account-page .container{ position:relative; z-index:1; }

  .account-grid{
    display:grid;
    grid-template-columns: 320px 1fr;
    gap:28px;
    align-items:start;
  }

  /* ---------- MAIN COLUMN ---------- */
  .account-main{
    display:flex;
    flex-direction:column;
    gap:24px;
  }

  /* ---------- ADDRESS CARD (panel utama, senada order-card / info-card) ---------- */
  .address-card{
    background: var(--white);
    border-radius: 10px;
    padding: 30px 32px;
    box-shadow: 0 14px 30px -18px rgba(60,30,10,.22);
  }

  .address-head{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:16px;
    flex-wrap:nowrap;
    padding-bottom:20px;
    border-bottom:1px solid rgba(122,59,18,.08);
    margin-bottom:24px;
  }
  .address-head > div{ flex:1 1 0; min-width:0; }
  .address-head h2{
    font-family: var(--font-display);
    font-weight:800;
    font-size:19px;
    color: var(--ink);
    margin-bottom:6px;
  }
  .address-head p{
    font-size:12.5px;
    color: var(--ink-soft);
    max-width:460px;
    line-height:1.55;
    margin:0;
  }
  .btn-add-address{
    display:inline-flex;
    align-items:center;
    gap:8px;
    background: var(--orange);
    color:#fff;
    font-size:13px;
    font-weight:700;
    padding:12px 20px;
    border-radius: var(--radius-pill);
    white-space:nowrap;
    text-decoration:none;
    flex:none;
    transition: background .2s ease;
  }
  .btn-add-address:hover{ background: var(--orange-dark); }

  /* tombol kecil (Pinpoint / Edit / Hapus) - sama dengan halaman biodata */
  .btn-outline-sm{
    display:inline-flex;
    align-items:center;
    gap:6px;
    background: var(--white);
    border:1.5px solid #e6d6c8;
    color: var(--ink);
    font-size:12px;
    font-weight:600;
    padding:10px 18px;
    border-radius: var(--radius-pill);
    white-space:nowrap;
    cursor:pointer;
    text-decoration:none;
    transition: border-color .2s ease, background .2s ease;
  }
  .btn-outline-sm:hover{ border-color: var(--brown); background: var(--cream-soft); }
  .btn-outline-sm svg{ width:14px; height:14px; flex:none; }

  /* ---------- TOOLBAR: search + filter ---------- */
  .address-toolbar{
    display:flex;
    flex-wrap:wrap;
    align-items:center;
    gap:12px;
    margin-bottom:26px;
  }
  .address-search{
    flex:1 1 260px;
    display:flex;
    align-items:center;
    gap:8px;
    background: var(--cream-soft);
    border-radius: 10px;
    padding:12px 16px;
  }
  .address-search svg{ width:16px; height:16px; color: var(--ink-soft); flex:none; }
  .address-search input{
    border:none;
    background:transparent;
    outline:none;
    width:100%;
    font-size:13px;
    color: var(--ink);
  }
  .address-search input::placeholder{ color: var(--ink-soft); }

  .address-filters{ display:flex; flex-wrap:wrap; gap:8px; }
  .filter-pill{
    border-radius: var(--radius-pill);
    font-size:12.5px;
    font-weight:600;
    padding:10px 16px;
    background: var(--cream-soft);
    color: var(--ink);
    border:none;
    cursor:pointer;
    white-space:nowrap;
    transition: background .2s ease, color .2s ease;
  }
  .filter-pill.active{ background: var(--orange); color:#fff; }
  .filter-pill:not(.active):hover{ background:#f3e5d3; }

  /* ---------- LIST ALAMAT ---------- */
  .address-list{
    display:flex;
    flex-direction:column;
    gap:20px;
  }

  .addr-item{
    border:1px solid rgba(122,59,18,.12);
    border-radius: 10px;
    padding:22px 24px;
    transition: box-shadow .2s ease, transform .2s ease;
  }
  .addr-item:hover{
    box-shadow: 0 14px 30px -18px rgba(60,30,10,.22);
    transform:translateY(-2px);
  }
  .addr-item[hidden]{ display:none; }
  .addr-item.primary{
    border:2px solid var(--orange);
    background: var(--cream-soft);
  }

  .addr-item-top{ display:flex; align-items:center; gap:12px; flex-wrap:wrap; }
  .addr-icon{
    width:40px; height:40px;
    border-radius:10px;
    display:flex; align-items:center; justify-content:center;
    flex:none;
  }
  .addr-icon svg{ width:20px; height:20px; }
  .addr-icon.house{ background:#fbe4c8; color: var(--orange-dark); }
  .addr-icon.office{ background:#e7e1fb; color:#6a4fd6; }
  .addr-icon.family{ background:#e2f1e6; color:#3f8452; }

  .addr-item-top h3{
    font-family: var(--font-display);
    font-weight:800;
    font-size:15px;
    color: var(--ink);
    margin:0;
  }
  .addr-badge-utama{
    font-size:10.5px;
    font-weight:700;
    background: var(--orange);
    color:#fff;
    padding:5px 10px;
    border-radius: var(--radius-pill);
  }

  .addr-person{ margin:14px 0 0; font-size:13.5px; color: var(--ink); }
  .addr-person b{ font-weight:700; }
  .addr-phone{ color: var(--ink-soft); font-weight:500; }
  .addr-text{ margin:4px 0 0; font-size:13px; color: var(--ink-soft); line-height:1.55; }

  .addr-note{
    margin-top:14px;
    background: var(--white);
    border:1px solid rgba(122,59,18,.08);
    border-radius: 10px;
    padding:12px 16px;
    font-size:12.5px;
    color: var(--ink);
    display:flex;
    gap:8px;
    align-items:flex-start;
  }
  .addr-item:not(.primary) .addr-note{ background: var(--cream-soft); border:none; }
  .addr-note svg{ width:15px; height:15px; margin-top:2px; color: var(--orange-dark); flex:none; }
  .addr-note b{ font-weight:700; }

  .addr-item-hr{ border:none; border-top:1px solid rgba(122,59,18,.08); margin:16px 0; }

  .addr-item-foot{
    display:flex;
    flex-wrap:wrap;
    align-items:center;
    justify-content:space-between;
    gap:12px;
  }
  .addr-eta, .addr-gps{
    display:flex;
    align-items:center;
    gap:6px;
    font-size:12.5px;
    font-weight:600;
    margin:0;
  }
  .addr-eta svg, .addr-gps svg{ width:15px; height:15px; flex:none; }
  .addr-eta{ color: var(--orange-dark); }
  .addr-gps{ color:#3f8452; }

  .addr-actions{ display:flex; flex-wrap:wrap; gap:8px; margin-left:auto; justify-content:flex-end; }
  .btn-outline-sm.btn-danger{
    color:#c0392b;
    border-color: rgba(192,57,43,.35);
  }
  .btn-outline-sm.btn-danger:hover{
    background:#fdecea;
    border-color:#c0392b;
  }
  .btn-outline-sm.btn-form{
    margin:0;
    border:none;
    padding:0;
    background:none;
    display:inline-flex;
  }
  form.btn-form-wrap{ margin:0; display:inline-flex; }

  .address-empty{
    text-align:center;
    padding:34px 16px;
    font-size:13px;
    color: var(--ink-soft);
    background: var(--cream-soft);
    border-radius:10px;
  }
  .address-empty[hidden]{ display:none; }

  /* ---------- RESPONSIVE ---------- */
  @media (max-width: 980px){
    .account-grid{ grid-template-columns:1fr; }
  }
  @media (max-width: 560px){
    .address-head{ flex-wrap:wrap; }
    .address-card{ padding:24px 20px; }
    .addr-item{ padding:18px 16px; }
  }
</style>
@endpush

@section('content')

  <section class="account-page reveal">
    <div class="container">
      <div class="account-grid">

        <!-- SIDEBAR -->
        @include('partials.sidebarakun', ['active' => 'alamat'])

        <!-- MAIN -->
        <div class="account-main">

          <div class="address-card">

            <div class="address-head">
              <div>
                <h2>{{ __('alamat.title') }}</h2>
                <p>{{ __('alamat.lead') }}</p>
              </div>
              <a href="/alamat/create" class="btn-add-address">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                {{ __('alamat.add_new') }}
              </a>
            </div>

            <div class="address-toolbar">
              <div class="address-search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
                <input type="text" id="addressSearch" name="q" autocomplete="off" placeholder="{{ __('alamat.search_ph') }}" aria-label="{{ __('alamat.search_ph') }}">
              </div>
              <div class="address-filters">
                <button type="button" class="filter-pill active" data-filter="all" aria-pressed="true">{{ __('alamat.filter_all', ['count' => 3]) }}</button>
                <button type="button" class="filter-pill" data-filter="primary" aria-pressed="false">{{ __('alamat.filter_primary', ['count' => 1]) }}</button>
                <button type="button" class="filter-pill" data-filter="home" aria-pressed="false">{{ __('alamat.filter_home', ['count' => 2]) }}</button>
                <button type="button" class="filter-pill" data-filter="office" aria-pressed="false">{{ __('alamat.filter_office', ['count' => 1]) }}</button>
              </div>
            </div>

            <div class="address-list">

              <!-- ALAMAT 1: Rumah Tinggal (Utama) -->
              <div class="addr-item primary" data-type="home" data-primary="1">
                <div class="addr-item-top">
                  <span class="addr-icon house">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 11.5 12 4l9 7.5"/><path d="M5 10v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-9"/><path d="M9 20v-6h6v6"/></svg>
                  </span>
                  <h3>Rumah Tinggal</h3>
                  <span class="addr-badge-utama">{{ __('alamat.primary_badge') }}</span>
                </div>

                <p class="addr-person"><b>Reva Aulia A.</b> <span class="addr-phone">(+62 831-2965-6565)</span></p>
                <p class="addr-text">Tebet Barat Dalam VI No. 12, RT.04/RW.02, Kel. Tebet Barat, Kec. Tebet, Kota Jakarta Selatan, DKI Jakarta 12810</p>

                <div class="addr-note">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 16v-4M12 8h.01"/></svg>
                  <span><b>{{ __('alamat.courier_note') }}</b> Rumah pagar hitam samping toko kelontong Bu Joko. Bunyikan bel 1 kali.</span>
                </div>

                <hr class="addr-item-hr">

                <div class="addr-item-foot">
                  <p class="addr-eta">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 11l18-8-8 18-2-8-8-2z"/></svg>
                    {!! __('alamat.eta') !!}
                  </p>
                  <div class="addr-actions">
                    <a href="/alamat/1/pinpoint" class="btn-outline-sm">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="8"/><path d="M12 8v8M8 12h8"/></svg>
                      {{ __('alamat.re_pinpoint') }}
                    </a>
                    <a href="/alamat/1/edit" class="btn-outline-sm">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4z"/></svg>
                      {{ __('alamat.edit') }}
                    </a>
                    <form action="/alamat/1" method="POST" class="btn-form-wrap" onsubmit="return confirm(@js(__('alamat.confirm_delete')));">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn-outline-sm btn-danger">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M8 6V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2"/><path d="M19 6l-1 14a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1L5 6"/></svg>
                        {{ __('alamat.delete') }}
                      </button>
                    </form>
                  </div>
                </div>
              </div>

              <!-- ALAMAT 2: Kantor / Studio Desain -->
              <div class="addr-item" data-type="office">
                <div class="addr-item-top">
                  <span class="addr-icon office">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="3" width="16" height="18" rx="1"/><path d="M8 7h2M14 7h2M8 11h2M14 11h2M8 15h2M14 15h2"/></svg>
                  </span>
                  <h3>Kantor / Studio Desain</h3>
                </div>

                <p class="addr-person"><b>Siti R. (Coworking Space)</b> <span class="addr-phone">(+62 813-8899-7721)</span></p>
                <p class="addr-text">Gedung Menara Karya Lantai 8, Jl. H.R. Rasuna Said Blok X-5, Kav. 1-2, Kuningan Timur, Setiabudi, Jakarta Selatan 12950</p>

                <div class="addr-note">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 16v-4M12 8h.01"/></svg>
                  <span><b>{{ __('alamat.courier_note') }}</b> Titipkan di meja resepsionis Lobby Utama atas nama Siti / PT Kreasi Digital.</span>
                </div>

                <hr class="addr-item-hr">

                <div class="addr-item-foot">
                  <p class="addr-gps">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    {{ __('alamat.gps', ['area' => 'Kuningan Timur']) }}
                  </p>
                  <div class="addr-actions">
                    <a href="/alamat/2/edit" class="btn-outline-sm">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4z"/></svg>
                      {{ __('alamat.edit') }}
                    </a>
                    <form action="/alamat/2" method="POST" class="btn-form-wrap" onsubmit="return confirm(@js(__('alamat.confirm_delete')));">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn-outline-sm btn-danger">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M8 6V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2"/><path d="M19 6l-1 14a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1L5 6"/></svg>
                        {{ __('alamat.delete') }}
                      </button>
                    </form>
                  </div>
                </div>
              </div>

              <!-- ALAMAT 3: Rumah Orang Tua (Keluarga) -->
              <div class="addr-item" data-type="home">
                <div class="addr-item-top">
                  <span class="addr-icon family">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="8" r="2.3"/><circle cx="16" cy="8" r="2.3"/><path d="M3 20c.6-3 2.6-4.6 5-4.6s4.4 1.6 5 4.6"/><path d="M11 20c.6-3 2.6-4.6 5-4.6s4.4 1.6 5 4.6"/></svg>
                  </span>
                  <h3>Rumah Orang Tua (Keluarga)</h3>
                </div>

                <p class="addr-person"><b>Ibu Aminah / Siti</b> <span class="addr-phone">(+62 812-7711-2345)</span></p>
                <p class="addr-text">Jl. Tebet Timur Dalam Raya No. 42B, RT.02/RW.06, Tebet Timur, Kec. Tebet, Kota Jakarta Selatan, DKI Jakarta 12820</p>

                <div class="addr-note">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 16v-4M12 8h.01"/></svg>
                  <span><b>{{ __('alamat.courier_note') }}</b> Rumah pagar putih, ada bel dekat pohon mangga di pekarangan depan.</span>
                </div>

                <hr class="addr-item-hr">

                <div class="addr-item-foot">
                  <p class="addr-gps">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    {{ __('alamat.gps', ['area' => 'Tebet Timur']) }}
                  </p>
                  <div class="addr-actions">
                    <a href="/alamat/3/edit" class="btn-outline-sm">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4z"/></svg>
                      {{ __('alamat.edit') }}
                    </a>
                    <form action="/alamat/3" method="POST" class="btn-form-wrap" onsubmit="return confirm(@js(__('alamat.confirm_delete')));">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn-outline-sm btn-danger">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M8 6V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2"/><path d="M19 6l-1 14a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1L5 6"/></svg>
                        {{ __('alamat.delete') }}
                      </button>
                    </form>
                  </div>
                </div>
              </div>

              @php
                $emptyText = \Illuminate\Support\Facades\Lang::has('alamat.empty') ? __('alamat.empty') : 'Alamat tidak ditemukan.';
              @endphp
              <p class="address-empty" id="addressEmpty" hidden>{{ $emptyText }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script>
    // Cari + filter daftar alamat (Semua / Utama / Rumah / Kantor)
    (function(){
      var items  = [].slice.call(document.querySelectorAll('.addr-item'));
      var pills  = [].slice.call(document.querySelectorAll('.filter-pill'));
      var search = document.getElementById('addressSearch');
      var empty  = document.getElementById('addressEmpty');
      var current = 'all';

      // teks yang dicari: judul, penerima, alamat, catatan kurir (bukan label tombol)
      items.forEach(function(item){
        var parts = [];
        ['h3', '.addr-person', '.addr-text', '.addr-note'].forEach(function(sel){
          var el = item.querySelector(sel);
          if (el) parts.push(el.textContent);
        });
        item.dataset.search = parts.join(' ').replace(/\s+/g, ' ').toLowerCase();
      });

      function matches(item, q){
        if (current === 'primary' && item.dataset.primary !== '1') return false;
        if ((current === 'home' || current === 'office') && item.dataset.type !== current) return false;
        return !q || item.dataset.search.indexOf(q) !== -1;
      }

      function apply(){
        var q = search.value.trim().toLowerCase();
        var shown = 0;
        items.forEach(function(item){
          var ok = matches(item, q);
          item.hidden = !ok;
          if (ok) shown++;
        });
        empty.hidden = shown !== 0;
      }

      pills.forEach(function(pill){
        pill.addEventListener('click', function(){
          current = pill.dataset.filter;
          pills.forEach(function(p){
            var on = p === pill;
            p.classList.toggle('active', on);
            p.setAttribute('aria-pressed', on ? 'true' : 'false');
          });
          apply();
        });
      });

      search.addEventListener('input', apply);
    })();
  </script>

@endsection