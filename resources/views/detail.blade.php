{{--
    detail.blade.php
    Pop-up "Detail Pesanan" — di-include di riwayat.blade.php dan dibuka lewat tombol "Detail & Invoice".
    Desain & teks dibuat 100% sama seperti mockup. 2 penyesuaian teknis supaya jalan di Laravel:
    1. File ini dibuat sebagai partial (bukan halaman @extends penuh) supaya bisa di-@include ke riwayat.blade.php.
    2. Link "Unduh Invoice (PDF)" mengarah ke /invoice/{nomor-pesanan} — route-nya dibuat nanti.
--}}
<style>
  /* ---------- MODAL DETAIL PESANAN ---------- */
  .modal-overlay{
    position:fixed;
    inset:0;
    background:rgba(43,33,24,.45);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    display:flex;
    align-items:center;
    justify-content:center;
    padding:24px;
    z-index:999;
    opacity:0;
    visibility:hidden;
    transition: opacity .25s ease, visibility .25s ease, backdrop-filter .25s ease;
  }
  .modal-overlay.open{
    opacity:1;
    visibility:visible;
  }

  .modal-card{
    background: var(--cream-soft);
    border-radius: 22px;
    width:100%;
    max-width:480px;
    max-height:90vh;
    overflow-y:auto;
    box-shadow: 0 30px 60px -20px rgba(43,33,24,.45);
    transform: translateY(24px) scale(.97);
    opacity:0;
    transition: transform .3s cubic-bezier(.2,.8,.2,1), opacity .3s ease;
  }
  .modal-overlay.open .modal-card{
    transform: translateY(0) scale(1);
    opacity:1;
  }

  .modal-head{
    background: var(--white);
    border-radius:22px 22px 0 0;
    padding:24px 26px 18px;
    position:relative;
  }
  .modal-head-top{
    display:flex;
    align-items:center;
    gap:10px;
    margin-bottom:8px;
  }
  .modal-head-top h2{
    font-family: var(--font-display);
    font-weight:800;
    font-size:19px;
    color: var(--ink);
  }
  .modal-status-pill{
    display:inline-flex;
    align-items:center;
    gap:6px;
    background:#e8f3de;
    color:#3f8a5a;
    font-size:11px;
    font-weight:700;
    padding:5px 12px;
    border-radius: var(--radius-pill);
    white-space:nowrap;
  }
  .modal-status-pill::before{
    content:"";
    width:6px; height:6px;
    border-radius:50%;
    background:#3f8a5a;
    flex:none;
  }
  .modal-head-sub{
    display:flex;
    align-items:center;
    gap:8px;
    font-size:12.5px;
    color: var(--ink-soft);
  }
  .modal-head-sub .order-id{
    font-weight:700;
    color: var(--orange-dark);
  }
  .modal-head-sub .dot{
    width:3px; height:3px;
    border-radius:50%;
    background:#c9b6a4;
    flex:none;
  }
  .modal-close{
    position:absolute;
    top:20px; right:22px;
    width:34px; height:34px;
    border-radius:50%;
    background: var(--cream-soft);
    border:none;
    display:flex;
    align-items:center;
    justify-content:center;
    color: var(--ink-soft);
    cursor:pointer;
    transition: background .2s ease;
  }
  .modal-close:hover{ background:#f0e4d6; }
  .modal-close svg{ width:16px; height:16px; }

  .modal-address-block{
    background: var(--peach);
    padding:18px 26px;
  }
  .modal-address-row{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:14px;
    flex-wrap:wrap;
  }
  .modal-address-row .who{
    display:flex;
    align-items:flex-start;
    gap:6px;
    font-size:13px;
    font-weight:700;
    color: var(--ink);
  }
  .modal-address-row .who svg{
    width:15px; height:15px;
    color:#c0392b;
    flex:none;
    margin-top:1px;
  }
  .modal-address-row .when{
    font-size:11.5px;
    color: var(--ink-soft);
    white-space:nowrap;
  }
  .modal-address-detail{
    font-size:12px;
    color: var(--ink-soft);
    margin:4px 0 0 21px;
  }
  .modal-address-divider{
    border:none;
    border-top:1px dashed rgba(122,59,18,.18);
    margin:14px 0;
  }
  .modal-courier-row{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    flex-wrap:wrap;
  }
  .modal-courier-row .courier{
    font-size:12.5px;
    color: var(--ink);
  }
  .modal-courier-row .courier strong{ font-weight:700; }
  .modal-eta-pill{
    background:#fdebd9;
    color: var(--orange-dark);
    font-size:11px;
    font-weight:700;
    padding:5px 12px;
    border-radius: var(--radius-pill);
    white-space:nowrap;
  }

  .modal-body{
    background: var(--white);
    padding:22px 26px 6px;
  }
  .modal-section-label{
    font-size:10.5px;
    letter-spacing:.06em;
    text-transform:uppercase;
    font-weight:700;
    color:#b7a596;
    margin-bottom:14px;
  }

  .modal-menu-item{
    display:flex;
    align-items:flex-start;
    gap:12px;
    padding-bottom:16px;
    margin-bottom:16px;
    border-bottom:1px solid rgba(122,59,18,.08);
  }
  .modal-menu-item:last-child{
    border-bottom:none;
    margin-bottom:0;
    padding-bottom:0;
  }
  .modal-menu-qty{
    background:#fdebd9;
    color: var(--orange-dark);
    font-size:12px;
    font-weight:700;
    width:30px; height:30px;
    border-radius:8px;
    display:flex;
    align-items:center;
    justify-content:center;
    flex:none;
  }
  .modal-menu-info{ flex:1; }
  .modal-menu-info .name{
    font-size:13.5px;
    font-weight:700;
    color: var(--ink);
    margin-bottom:2px;
  }
  .modal-menu-info .variant{
    font-size:11.5px;
    color: var(--ink-soft);
  }
  .modal-menu-price{
    font-size:13.5px;
    font-weight:700;
    color: var(--ink);
    white-space:nowrap;
  }

  .modal-summary{
    background: var(--white);
    padding:18px 26px 22px;
  }
  .modal-summary-row{
    display:flex;
    align-items:center;
    justify-content:space-between;
    font-size:12.5px;
    color: var(--ink-soft);
    margin-bottom:10px;
  }
  .modal-summary-row .amount{ color: var(--ink); font-weight:600; }
  .modal-summary-row .amount.positive{ color:#3f8a5a; font-weight:700; }
  .modal-summary-divider{
    border:none;
    border-top:1px dashed rgba(122,59,18,.18);
    margin:14px 0;
  }
  .modal-total-row{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:12px;
  }
  .modal-total-row .label{
    font-size:13.5px;
    font-weight:800;
    color: var(--ink);
    margin-bottom:3px;
  }
  .modal-total-row .sub{
    font-size:11px;
    color: var(--ink-soft);
  }
  .modal-total-row .value{
    font-family: var(--font-display);
    font-weight:800;
    font-size:22px;
    color: var(--orange-dark);
    white-space:nowrap;
  }

  .modal-footer{
    background: var(--cream-soft);
    border-radius:0 0 22px 22px;
    padding:18px 26px;
    display:flex;
    align-items:center;
    justify-content:flex-end;
    gap:10px;
  }
  .modal-btn-close{
    display:inline-flex;
    align-items:center;
    background: var(--white);
    border:1.5px solid #e6d6c8;
    color: var(--ink);
    font-size:13px;
    font-weight:600;
    padding:11px 20px;
    border-radius: var(--radius-pill);
    cursor:pointer;
    transition: border-color .2s ease, background .2s ease;
  }
  .modal-btn-close:hover{ border-color: var(--brown); background:#f0e4d6; }
  .modal-btn-download{
    display:inline-flex;
    align-items:center;
    gap:8px;
    background: var(--orange);
    color:#fff;
    font-size:13px;
    font-weight:700;
    padding:11px 22px;
    border-radius: var(--radius-pill);
    white-space:nowrap;
    transition: background .2s ease;
  }
  .modal-btn-download:hover{ background: var(--orange-dark); }

  @media (max-width:560px){
    .modal-head, .modal-address-block, .modal-body, .modal-summary, .modal-footer{ padding-left:20px; padding-right:20px; }
    .modal-footer{ flex-direction:column-reverse; align-items:stretch; }
    .modal-footer a, .modal-footer button{ justify-content:center; width:100%; }
  }
</style>

<div class="modal-overlay" id="modalDetailPesanan">
  <div class="modal-card">

    <div class="modal-head">
      <button type="button" class="modal-close" data-modal-close aria-label="{{ __('detail.close') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
      <div class="modal-head-top">
        <h2>{{ __('detail.title') }}</h2>
        <span class="modal-status-pill">{{ __('detail.status') }}</span>
      </div>
      <div class="modal-head-sub">
        <span class="order-id">#2DA-89211</span>
        <span class="dot"></span>
        <span>INV/20241018/2DA/89211</span>
      </div>
    </div>

    <div class="modal-address-block">
      <div class="modal-address-row">
        <span class="who">
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C7.58 2 4 5.58 4 10c0 5.25 7.02 11.34 7.32 11.6a1 1 0 0 0 1.36 0C13 21.34 20 15.25 20 10c0-4.42-3.58-8-8-8zm0 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/></svg>
          Reva Aulia A.
        </span>
        <span class="when">{{ __('detail.date') }} &bull; 11:20 WIB</span>
      </div>
      <p class="modal-address-detail">Tebet Barat Dalam VI (Rumah Tinggal), Tebet</p>

      <hr class="modal-address-divider">

      <div class="modal-courier-row">
        <span class="courier"><strong>{{ __('detail.courier', ['name' => 'Kang Rahmat']) }}</strong> (2DA Express)</span>
        <span class="modal-eta-pill">{{ __('detail.eta') }}</span>
      </div>
    </div>

    <div class="modal-body">
      <p class="modal-section-label">{{ __('detail.menu_details') }}</p>

      <div class="modal-menu-item">
        <span class="modal-menu-qty">2x</span>
        <div class="modal-menu-info">
          <p class="name">Corndog Mini Mozarella</p>
          <p class="variant">{{ __('detail.variant', ['name' => 'Saos Sambal & Mayo Gurih']) }}</p>
        </div>
        <span class="modal-menu-price">Rp 10.000</span>
      </div>

      <div class="modal-menu-item">
        <span class="modal-menu-qty">1x</span>
        <div class="modal-menu-info">
          <p class="name">Cireng Isi Mini</p>
          <p class="variant">{{ __('detail.variant', ['name' => 'Bumbu Tabur Pedas Gurih']) }}</p>
        </div>
        <span class="modal-menu-price">Rp 5.000</span>
      </div>
    </div>

    <div class="modal-summary">
      <div class="modal-summary-row">
        <span>{{ __('detail.subtotal', ['count' => 3]) }}</span>
        <span class="amount">Rp 15.000</span>
      </div>
      <div class="modal-summary-row" style="margin-bottom:0;">
        <span>{{ __('detail.shipping') }}</span>
        <span class="amount positive">Rp 10.000</span>
      </div>

      <hr class="modal-summary-divider">

      <div class="modal-total-row">
        <div>
          <p class="label">{{ __('detail.final_total') }}</p>
          <p class="sub">{{ __('detail.qris_verified') }}</p>
        </div>
        <span class="value">Rp 25.000</span>
      </div>
    </div>

    <div class="modal-footer">
      <a href="/invoice/2DA-89211" class="modal-btn-download">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        {{ __('detail.download_invoice') }}
      </a>
    </div>

  </div>
</div>

<script>
  (function(){
    var overlay = document.getElementById('modalDetailPesanan');
    if(!overlay) return;

    function openModal(){
      overlay.classList.add('open');
      document.body.style.overflow = 'hidden';
    }
    function closeModal(){
      overlay.classList.remove('open');
      document.body.style.overflow = '';
    }

    document.querySelectorAll('[data-modal-open="modalDetailPesanan"]').forEach(function(trigger){
      trigger.addEventListener('click', function(e){
        e.preventDefault();
        openModal();
      });
    });

    overlay.querySelectorAll('[data-modal-close]').forEach(function(btn){
      btn.addEventListener('click', closeModal);
    });

    overlay.addEventListener('click', function(e){
      if(e.target === overlay) closeModal();
    });

    document.addEventListener('keydown', function(e){
      if(e.key === 'Escape') closeModal();
    });
  })();
</script>