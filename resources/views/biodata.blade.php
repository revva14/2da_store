@extends('layouts.applogin')

@section('title', __('biodata.page_title'))

@push('styles')
<style>
  /* ---------- ACCOUNT PAGE ---------- */
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

  .order-card, .info-card{
    background: var(--white);
    border-radius: 10px;
    padding: 30px 32px;
    box-shadow: 0 14px 30px -18px rgba(60,30,10,.22);
  }

  .order-head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    flex-wrap:wrap;
    gap:12px;
    padding-bottom:20px;
    border-bottom:1px solid rgba(122,59,18,.08);
    margin-bottom:26px;
  }
  .order-head h2{
    display:flex;
    align-items:center;
    gap:10px;
    font-family: var(--font-display);
    font-weight:800;
    font-size:17px;
    color: var(--ink);
  }
  .order-head h2::before{
    content:"";
    width:9px; height:9px;
    border-radius:50%;
    background:#5f9a3b;
    flex:none;
  }
  .order-status-badge{
    background: var(--cream-soft);
    color: var(--brown-dark);
    font-size:11.5px;
    font-weight:600;
    padding:8px 16px;
    border-radius: var(--radius-pill);
    white-space:nowrap;
  }

  .order-summary-row{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:20px;
    flex-wrap:wrap;
    background: var(--cream-soft);
    border-radius: 10px;
    padding:20px 24px;
    margin-bottom:34px;
  }
  .order-summary-row .label{
    display:block;
    font-size:10px;
    letter-spacing:.05em;
    text-transform:uppercase;
    color: var(--ink-soft);
    margin-bottom:6px;
  }
  .order-summary-row .value{
    font-family: var(--font-display);
    font-weight:700;
    font-size:15px;
    color: var(--ink);
  }
  .order-summary-row .total{ text-align:right; }
  .order-summary-row .total .value{ font-size:19px; color: var(--orange-dark); }
  .order-summary-row .verified{
    display:block;
    font-size:11px;
    font-weight:600;
    color:#4f7a35;
    margin-top:4px;
  }

  /* ---------- STEPPER ---------- */
  .order-stepper{
    display:flex;
    justify-content:space-between;
    margin-bottom:30px;
    padding:0 6px;
  }
  .order-stepper .step{
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:8px;
    position:relative;
    flex:1;
  }
  .order-stepper .connector{
    position:absolute;
    top:20px; left:50%;
    width:100%; height:2px;
    background:#e6d6c8;
    z-index:0;
  }
  .order-stepper .connector.done{ background: var(--orange); }
  .order-stepper .step:last-child .connector{ display:none; }

  .order-stepper .step-icon{
    width:40px; height:40px;
    border-radius:50%;
    display:flex; align-items:center; justify-content:center;
    background: var(--orange);
    color:#fff;
    position:relative;
    z-index:1;
  }
  .order-stepper .step-icon img{
    width:18px; height:18px;
    object-fit:contain;
    filter: brightness(0) invert(1);
  }
  .order-stepper .step.current .step-icon{ background: var(--brown-dark); }
  .order-stepper .step.upcoming .step-icon{
    background:#fff;
    border:2px solid #e6d6c8;
    color:#c9b6a4;
  }
  /* Ikon step "upcoming": jangan putih (background putih) - pakai warna #c9b6a4 seperti border/teks */
  .order-stepper .step.upcoming .step-icon img{
    filter: brightness(0) invert(91%) sepia(100%) saturate(254%) hue-rotate(-57deg) brightness(79%);
  }

  .order-stepper .step-label{ font-size:12px; font-weight:700; color: var(--ink); }
  .order-stepper .step-time{ font-size:10.5px; color: var(--ink-soft); }
  .order-stepper .step.current .step-label,
  .order-stepper .step.current .step-time{ color: var(--orange-dark); }
  .order-stepper .step.upcoming .step-label,
  .order-stepper .step.upcoming .step-time{ color:#b7a596; }

  .order-driver{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:16px;
    flex-wrap:wrap;
  }
  .order-driver p{ font-size:12.5px; color: var(--ink-soft); }
  .order-driver p strong{ color: var(--ink); }

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
    transition: border-color .2s ease, background .2s ease;
  }
  .btn-outline-sm:hover{ border-color: var(--brown); background: var(--cream-soft); }

  /* ---------- INFO CARD ---------- */
  .info-head{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:16px;
    margin-bottom:28px;
  }
  .info-head h2{
    font-family: var(--font-display);
    font-weight:800;
    font-size:17px;
    color: var(--ink);
    margin-bottom:6px;
  }
  .info-head p{
    font-size:12.5px;
    color: var(--ink-soft);
    max-width:520px;
  }

  .info-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:16px;
  }
  .info-field{
    background: var(--cream-soft);
    border-radius: 10px;
    padding:16px 18px;
    position:relative;
    --field-weight:700; /* ketebalan teks field: dipakai bareng oleh teks biasa & input edit */
  }
  .info-field .field-label{
    display:block;
    font-size:9.5px;
    letter-spacing:.05em;
    text-transform:uppercase;
    color: var(--ink-soft);
    margin-bottom:6px;
  }
  .info-field .field-value{
    font-family: var(--font-display);
    font-weight: var(--field-weight);
    font-size:13.5px;
    color: var(--ink);
    line-height:1.4;
  }
  .field-verified{
    position:absolute;
    top:14px; right:16px;
    background:#e8f3de;
    color:#4f7a35;
    font-size:9.5px;
    font-weight:700;
    padding:4px 10px;
    border-radius: var(--radius-pill);
  }

  /* ---------- MODE EDIT BIODATA ---------- */
  .info-actions{ display:flex; align-items:center; gap:8px; flex-wrap:wrap; justify-content:flex-end; }
  .info-actions [hidden]{ display:none !important; }
  .btn-outline-sm.btn-primary-sm{ background: var(--orange); border-color: var(--orange); color:#fff; }
  .btn-outline-sm.btn-primary-sm:hover{ background: var(--orange-dark); border-color: var(--orange-dark); }
  .info-field .field-input{
    width:100%;
    font-family: var(--font-display);
    font-weight: var(--field-weight);
    font-size:13.5px;
    line-height:1.4;
    color: var(--ink);
    background: var(--white);
    border:1.5px solid #e6d6c8;
    border-radius:8px;
    padding:8px 10px;
    outline:none;
    resize:vertical;
    transition: border-color .2s ease;
  }
  .info-field .field-input:focus{ border-color: var(--orange); }
  .info-field .field-input.invalid{ border-color:#c0392b; }

  /* ---------- RESPONSIVE ---------- */
  @media (max-width: 980px){
    .account-grid{ grid-template-columns:1fr; }
    .info-grid{ grid-template-columns:1fr; }
  }
  @media (max-width: 560px){
    .order-card, .info-card{ padding:24px 20px; }
    .order-stepper{ flex-wrap:wrap; row-gap:24px; }
    .order-stepper .step{ flex:0 0 50%; }
    .order-stepper .connector{ display:none; }
    .order-summary-row .total{ text-align:left; }
  }
</style>
@endpush

@section('content')

  <section class="account-page reveal">
    <div class="container">
      <div class="account-grid">

        <!-- SIDEBAR -->
        @include('partials.sidebarakun', ['active' => 'biodata'])

        <!-- MAIN -->
        <div class="account-main">

          <!-- PESANAN SEDANG BERLANGSUNG -->
          <div class="order-card">
            <div class="order-head">
              <h2>{{ __('biodata.ongoing_title') }}</h2>
              <span class="order-status-badge">{{ __('biodata.ongoing_badge') }}</span>
            </div>

            <div class="order-summary-row">
              <div>
                <span class="label">{{ __('biodata.order_id') }}</span>
                <span class="value">#2DA-89211</span>
              </div>
              <div class="total">
                <span class="label">{{ __('biodata.total_transaction') }}</span>
                <span class="value">Rp 25.000</span>
                <span class="verified">{{ __('biodata.qris_verified') }}</span>
              </div>
            </div>

            <div class="order-stepper">
              <div class="step done">
                <div class="connector done"></div>
                <div class="step-icon">
                  <img src="{{ asset('images/check.png') }}" alt="{{ __('biodata.step_received') }}">
                </div>
                <span class="step-label">{{ __('biodata.step_received') }}</span>
                <span class="step-time">11:20 WIB</span>
              </div>
              <div class="step done">
                <div class="connector done"></div>
                <div class="step-icon">
                  <img src="{{ asset('images/frying-pan.png') }}" alt="{{ __('biodata.step_cooking') }}">
                </div>
                <span class="step-label">{{ __('biodata.step_cooking') }}</span>
                <span class="step-time">11:28 WIB</span>
              </div>
              <div class="step current">
                <div class="connector"></div>
                <div class="step-icon">
                  <img src="{{ asset('images/motorbike.png') }}" alt="{{ __('biodata.step_delivering') }}">
                </div>
                <span class="step-label">{{ __('biodata.step_delivering') }}</span>
                <span class="step-time">{{ __('biodata.step_arrive_in') }}</span>
              </div>
              <div class="step upcoming">
                <div class="step-icon">
                  <img src="{{ asset('images/location.png') }}" alt="{{ __('biodata.step_arrived') }}">
                </div>
                <span class="step-label">{{ __('biodata.step_arrived') }}</span>
                <span class="step-time">{{ __('biodata.step_estimate', ['time' => '11:45']) }}</span>
              </div>
            </div>

            <div class="order-driver">
              <p><strong>{{ __('biodata.driver') }}</strong> Kang Rahmat (Honda Vario)<br>{{ __('biodata.heading_to', ['place' => 'Tebet Barat Dalam VI']) }}</p>
              <a href="/akun/riwayat" class="btn-outline-sm">{{ __('biodata.order_detail') }}</a>
            </div>
          </div>

          <!-- INFORMASI PRIBADI & KONTAK -->
          <div class="info-card">
            <div class="info-head">
              <div>
                <h2>{{ __('biodata.info_title') }}</h2>
                <p>{{ __('biodata.info_lead') }}</p>
              </div>
              @php
                $bt = fn($key, $default) => \Illuminate\Support\Facades\Lang::has('biodata.'.$key) ? __('biodata.'.$key) : $default;
              @endphp
              <div class="info-actions">
                <button type="button" class="btn-outline-sm" id="cancelBiodataBtn" hidden>{{ $bt('cancel', 'Batal') }}</button>
                <button type="button" class="btn-outline-sm" id="editBiodataBtn" data-label-edit="{{ __('biodata.edit') }}" data-label-save="{{ $bt('save', 'Simpan') }}">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4z"/></svg>
                  <span id="editBiodataLabel">{{ __('biodata.edit') }}</span>
                </button>
              </div>
            </div>

            <div class="info-grid">
              <div class="info-field">
                <span class="field-label">{{ __('biodata.full_name') }}</span>
                <span class="field-value" data-key="name" data-type="text">Reva Aulia A.</span>
              </div>
              <div class="info-field">
                <span class="field-label">{{ __('biodata.phone') }}</span>
                <span class="field-value" data-key="phone" data-type="tel">+62 831-2965-6565</span>
                <span class="field-verified">{{ __('biodata.verified') }}</span>
              </div>
              <div class="info-field">
                <span class="field-label">{{ __('biodata.email') }}</span>
                <span class="field-value" data-key="email" data-type="email">revanjai@email.com</span>
                <span class="field-verified">{{ __('biodata.verified') }}</span>
              </div>
              <div class="info-field">
                <span class="field-label">{{ __('biodata.birthdate') }}</span>
                <span class="field-value" data-key="birthdate" data-type="text">{{ __('biodata.birthdate_value') }}</span>
              </div>
              <div class="info-field">
                <span class="field-label">{{ __('biodata.gender') }}</span>
                <span class="field-value" data-key="gender" data-type="select" data-options="{{ json_encode([__('biodata.gender_female'), $bt('gender_male', 'Laki-laki')]) }}">{{ __('biodata.gender_female') }}</span>
              </div>
              <div class="info-field">
                <span class="field-label">{{ __('biodata.delivery_pref') }}</span>
                <span class="field-value" data-key="delivery" data-type="textarea">Taruh di meja resepsionis / depan pagar jika tak ada orang</span>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

<script>
  // Tombol "Edit" biodata: ubah tiap field jadi input, lalu "Simpan" / "Batal"
  (function(){
    var editBtn   = document.getElementById('editBiodataBtn');
    var cancelBtn = document.getElementById('cancelBiodataBtn');
    var labelEl   = document.getElementById('editBiodataLabel');
    if (!editBtn) return;

    var editing = false;
    var values  = document.querySelectorAll('.info-grid .field-value[data-key]');

    function startEdit(){
      editing = true;
      values.forEach(function(el){
        var current = el.textContent.trim();
        var input;
        if (el.dataset.type === 'textarea') {
          input = document.createElement('textarea');
          input.rows = 2;
        } else if (el.dataset.type === 'select') {
          input = document.createElement('select');
          var opts = [];
          try { opts = JSON.parse(el.dataset.options || '[]'); } catch(e) {}
          if (opts.indexOf(current) === -1) opts.unshift(current);
          opts.forEach(function(text){
            var o = document.createElement('option');
            o.value = text;
            o.textContent = text;
            input.appendChild(o);
          });
        } else {
          input = document.createElement('input');
          input.type = el.dataset.type || 'text';
        }
        input.className = 'field-input';
        input.value = current;
        input.dataset.key = el.dataset.key;
        input.dataset.original = current;
        el.style.display = 'none';
        el.parentNode.insertBefore(input, el.nextSibling);
      });
      labelEl.textContent = editBtn.dataset.labelSave;
      editBtn.classList.add('btn-primary-sm');
      cancelBtn.hidden = false;
      var first = document.querySelector('.info-grid .field-input');
      if (first) first.focus();
    }

    function stopEdit(save){
      var inputs = document.querySelectorAll('.info-grid .field-input');
      if (save) {
        var ok = true;
        inputs.forEach(function(inp){
          var empty = inp.value.trim() === '';
          inp.classList.toggle('invalid', empty);
          if (empty) ok = false;
        });
        if (!ok) return; // ada field kosong -> tetap di mode edit
      }
      inputs.forEach(function(inp){
        var span = inp.previousElementSibling;
        if (save) span.textContent = inp.value.trim();
        span.style.display = '';
        inp.remove();
      });
      editing = false;
      labelEl.textContent = editBtn.dataset.labelEdit;
      editBtn.classList.remove('btn-primary-sm');
      cancelBtn.hidden = true;

      // TODO: kirim ke backend saat route simpan biodata sudah ada, mis.:
      // fetch('/akun/biodata', { method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Content-Type':'application/json'}, body: JSON.stringify(data) });
    }

    editBtn.addEventListener('click', function(){
      if (editing) { stopEdit(true); } else { startEdit(); }
    });
    cancelBtn.addEventListener('click', function(){ stopEdit(false); });
  })();
</script>

@endsection