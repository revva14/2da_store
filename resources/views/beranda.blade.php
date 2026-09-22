@extends('layouts.app')

@section('content')

  <!-- HERO -->
  <section class="hero" id="beranda">
    <div class="container hero-inner">
      <div class="hero-copy reveal">
        <h1>{{ __('home.hero_title') }}</h1>
        <p>{{ __('home.hero_text') }}</p>
        <div class="hero-actions">
          <button class="btn btn-primary" id="pesanBtn">{{ __('home.order_now') }}</button>
          <a href="/menu" class="btn btn-outline">{{ __('home.explore_menu') }}</a>
        </div>
      </div>
    </div>
  </section>

  <!-- PRODUCTS -->
  <section class="section" id="menu">
    <div class="container">
      <div class="section-head reveal">
        <h2 class="kicker"><span class="accent">{{ __('home.products_accent') }}</span> {{ __('home.products_rest') }}</h2>
        <p>{{ __('home.products_sub') }}</p>
      </div>

      <div class="products-grid">
        <article class="product-card reveal">
          <div class="product-media">
            <img src="{{ asset('images/cireng.jpg') }}" alt="Cireng isi mini">
          </div>
          <div class="product-row">
            <h3>{{ __('home.cireng_name') }}</h3>
            <span class="price">Rp 5.000</span>
          </div>
          <p class="desc">{{ __('home.cireng_desc') }}</p>
        </article>

        <article class="product-card reveal">
          <div class="product-media">
            <span class="tag">{{ __('home.best_seller') }}</span>
            <img src="{{ asset('images/corndog.jpg') }}" alt="Corndog Mini Mozzarella">
          </div>
          <div class="product-row">
            <h3>{{ __('home.corndog_name') }}</h3>
            <span class="price">Rp 5.000</span>
          </div>
          <p class="desc">{{ __('home.corndog_desc') }}</p>
        </article>

        <article class="product-card reveal">
          <div class="product-media">
            <img src="{{ asset('images/maryam.jpg') }}" alt="Roti maryam mini">
          </div>
          <div class="product-row">
            <h3>{{ __('home.maryam_name') }}</h3>
            <span class="price">Rp 5.000</span>
          </div>
          <p class="desc">{{ __('home.maryam_desc') }}</p>
        </article>
      </div>

      <div class="section-cta reveal">
        <a href="/menu" class="link-cta">{{ __('home.view_all') }}</a>
      </div>
    </div>
  </section>

  <!-- QUALITY -->
  <section class="quality" id="cara-pesan">
    <div class="container">
      <div class="quality-inner reveal">
        <h2><span class="accent">{{ __('home.quality_accent') }}</span> <span class="dark">{{ __('home.quality_rest') }}</span></h2>
        <p>{{ __('home.quality_p1') }}</p>
        <p>{{ __('home.quality_p2') }}</p>
        <a href="/tentang" class="cta-link">{{ __('home.quality_link') }}</a>
      </div>
    </div>
  </section>

  <!-- TESTIMONIALS -->
  <section class="testimonials" id="testimoni">
    <div class="container">
      <div class="section-head reveal">
        <h2 class="kicker">{{ __('home.testi_title') }}</h2>
        <p>{{ __('home.testi_sub') }}</p>
      </div>

      <div class="testi-grid">
        <div class="testi-card reveal">
          <blockquote>"{{ __('home.testi1_quote') }}"</blockquote>
          <div class="testi-author">
            <div class="avatar"></div>
            <div>
              <div class="name">Budi Santoso</div>
              <div class="role">{{ __('home.testi1_role') }}</div>
            </div>
          </div>
        </div>

        <div class="testi-card reveal">
          <blockquote>"{{ __('home.testi2_quote') }}"</blockquote>
          <div class="testi-author">
            <div class="avatar"></div>
            <div>
              <div class="name">Siti Rahma</div>
              <div class="role">{{ __('home.testi2_role') }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection

@push('scripts')
<script>

  // Simple CTA feedback
  document.getElementById('pesanBtn').addEventListener('click', () => {
    document.querySelector('#menu').scrollIntoView({ behavior: 'smooth' });
  });
</script>
@endpush