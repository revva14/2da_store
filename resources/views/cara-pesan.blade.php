@extends('layouts.app')

@section('title', __('cara_pesan.page_title'))

@push('styles')
<style>
  /* ---------- PAGE HEAD (disamakan dengan hero halaman Menu) ---------- */
  .page-head{
    background: radial-gradient(circle at 50% 30%, #fbdcc4 0%, var(--cream) 70%);
    padding: 104px 0 74px;
  }
  .page-head .container{
    display:flex;
    flex-direction:column;
    align-items:center;
    text-align:center;
  }
  .page-head .breadcrumb{
    font-size:12px;
    font-weight:600;
    letter-spacing:.04em;
    text-transform:uppercase;
    color: #5a4335;
    margin-bottom:16px;
  }
  .page-head .breadcrumb a{ transition: color .2s ease; }
  .page-head .breadcrumb a:hover{ color: var(--brown-dark); }
  .page-head .breadcrumb .current{ color: #d9672c; }
  .page-head h1{
    font-family: var(--font-display);
    font-weight:800;
    font-size: clamp(32px, 4.2vw, 48px);
    color: #d9672c;
    margin-bottom:14px;
  }
  .page-head p{
    max-width:520px;
    margin:0 auto;
    color: #5a4335;
    font-size:14px;
  }

  /* ---------- STEPS ---------- */
  .section{ padding: 50px 0 100px; }

  .steps-grid{
    display:grid;
    grid-template-columns: 1fr 1fr;
    gap:24px;
  }

  .step-card{
    position:relative;
    background: var(--cream-soft);
    border-radius: var(--radius-md);
    padding: 34px 36px;
    overflow:hidden;
    box-shadow: 0 8px 22px -16px rgba(60,30,10,.2);
  }

  .step-number{
    position:absolute;
    top:-18px; right:14px;
    font-family: var(--font-display);
    font-weight:800;
    font-size:110px;
    line-height:1;
    color: rgba(122,59,18,.06);
    pointer-events:none;
    user-select:none;
  }

  .step-card h3{
    font-family: var(--font-display);
    font-weight:700;
    font-size:18px;
    color: var(--ink);
    margin-bottom:12px;
    position:relative;
  }

  .step-card p{
    font-size:14.5px;
    color: var(--ink-soft);
    line-height:1.7;
    max-width:90%;
    position:relative;
  }

  .step-card::before{
    content:"";
    position:absolute;
    background: var(--accent, var(--orange));
  }
  .step-card.accent-left::before{ left:0; top:0; bottom:0; width:4px; }
  .step-card.accent-bottom::before{ left:0; right:0; bottom:0; height:4px; }
  .step-card.accent-right::before{ right:0; top:0; bottom:0; width:4px; }

  .step-1{ --accent: var(--orange); }
  .step-2{ --accent: var(--orange); }
  .step-3{ --accent: #6E8F4C; }
  .step-4{ --accent: var(--brown); }

  .step-final{
    grid-column: 1 / -1;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:24px;
    flex-wrap:wrap;
  }
  .step-final .step-copy{ max-width:640px; }

  .btn-mulai{
    background: var(--orange);
    color:#fff;
    font-weight:700;
    font-size:14.5px;
    padding: 15px 32px;
    border-radius: var(--radius-pill);
    box-shadow: 0 12px 24px -10px rgba(217,123,41,.6);
    transition: background .2s ease, transform .1s ease;
    flex:none;
    position:relative;
    z-index:1;
  }
  .btn-mulai:hover{ background: var(--orange-dark); }
  .btn-mulai:active{ transform: scale(0.97); }

  /* ---------- RESPONSIVE (khusus halaman ini) ---------- */
  @media (max-width: 980px){
    .steps-grid{ grid-template-columns: 1fr; }
  }
  @media (max-width: 560px){
    .page-head{ padding: 68px 0 48px; }
    .page-head h1{ font-size:30px; }
    .step-card{ padding:28px 24px; }
    .step-final{ flex-direction:column; align-items:flex-start; }
    .btn-mulai{ width:100%; text-align:center; }
  }
</style>
@endpush

@section('content')

  <section class="page-head reveal">
    <div class="container">
      <h1>{{ __('cara_pesan.heading') }}</h1>
      <p>{{ __('cara_pesan.subtitle') }}</p>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="steps-grid">

        <div class="step-card step-1 accent-left reveal">
          <span class="step-number">1</span>
          <h3>{{ __('cara_pesan.step1_title') }}</h3>
          <p>{{ __('cara_pesan.step1_text') }}</p>
        </div>

        <div class="step-card step-2 accent-left reveal">
          <span class="step-number">2</span>
          <h3>{{ __('cara_pesan.step2_title') }}</h3>
          <p>{{ __('cara_pesan.step2_text') }}</p>
        </div>

        <div class="step-card step-3 accent-bottom reveal">
          <span class="step-number">3</span>
          <h3>{{ __('cara_pesan.step3_title') }}</h3>
          <p>{{ __('cara_pesan.step3_text') }}</p>
        </div>

        <div class="step-card step-4 accent-right reveal">
          <span class="step-number">4</span>
          <h3>{{ __('cara_pesan.step4_title') }}</h3>
          <p>{{ __('cara_pesan.step4_text') }}</p>
        </div>

        <div class="step-card step-final reveal">
          <span class="step-number">5</span>
          <div class="step-copy">
            <h3>{{ __('cara_pesan.step5_title') }}</h3>
            <p>{{ __('cara_pesan.step5_text') }}</p>
          </div>
          <a href="/menu" class="btn-mulai">{{ __('cara_pesan.start_shopping') }}</a>
        </div>

      </div>
    </div>
  </section>

@endsection