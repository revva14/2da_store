@php
  $current = app()->getLocale();
  $langs = ['id' => 'Indonesia', 'en' => 'English'];
@endphp

<div class="lang-dd" id="langDd">
  <button type="button" class="lang-dd-btn" id="langDdBtn"
          aria-haspopup="true" aria-expanded="false" aria-label="Bahasa / Language">
    {{ strtoupper($current) }}
    <span class="lang-dd-caret"></span>
  </button>

  <div class="lang-dd-menu" role="menu">
    @foreach ($langs as $code => $label)
      <a href="{{ route('lang.switch', $code) }}" role="menuitem" hreflang="{{ $code }}"
         class="{{ $current === $code ? 'active' : '' }}">
        <b>{{ strtoupper($code) }}</b> {{ $label }}
      </a>
    @endforeach
  </div>
</div>

<style>
  .lang-dd{ position: relative; }

  .lang-dd-btn{
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 4px;
    background: transparent;
    border: 0;
    cursor: pointer;
    font: inherit;
    font-size: 15px;
    font-weight: 700;
    color: var(--ink);
    transition: color .2s ease;
  }
  .lang-dd-btn:hover{ color: var(--orange); }

  /* panah kecil ▾ */
  .lang-dd-caret{
    width: 0; height: 0;
    border-left: 4px solid transparent;
    border-right: 4px solid transparent;
    border-top: 5px solid currentColor;
    transition: transform .2s ease;
  }
  .lang-dd.open .lang-dd-caret{ transform: rotate(180deg); }

  .lang-dd-menu{
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    min-width: 150px;
    padding: 6px;
    background: #fff;
    border: 1px solid var(--cream-soft);
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,.12);
    opacity: 0;
    visibility: hidden;
    transform: translateY(-4px);
    transition: opacity .15s ease, transform .15s ease, visibility .15s;
    z-index: 100;
  }
  .lang-dd.open .lang-dd-menu{
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
  }
  .lang-dd-menu a{
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 12px;
    border-radius: 8px;
    font-size: 14px;
    color: var(--ink);
    text-decoration: none;
  }
  .lang-dd-menu a b{ width: 22px; }
  .lang-dd-menu a:hover{ background: var(--cream-soft); }
  .lang-dd-menu a.active{ color: var(--orange); font-weight: 700; }
</style>

<script>
  (function () {
    const dd  = document.getElementById('langDd');
    const btn = document.getElementById('langDdBtn');
    if (!dd || !btn) return;

    const setOpen = (open) => {
      dd.classList.toggle('open', open);
      btn.setAttribute('aria-expanded', open);
    };

    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      setOpen(!dd.classList.contains('open'));
    });
    document.addEventListener('click', (e) => { if (!dd.contains(e.target)) setOpen(false); });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') setOpen(false); });
  })();
</script>