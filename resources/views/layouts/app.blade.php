<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script>
  (function(){
    var saved = localStorage.getItem('theme') || '{{ $settings['default_theme'] ?? 'light' }}';
    document.documentElement.setAttribute('data-theme', saved);
  })();
</script>
<title>@yield('title', $settings['site_title'] ?? 'DASHBOARD KINERJA — UPT MANADO')</title>
<link rel="icon" type="image/png" href="{{ asset('Logo_UPT_Manado.png') }}?v=upt1">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=upt1">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v=upt1">
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=upt1">
<link rel="apple-touch-icon" href="{{ asset('Logo_UPT_Manado.png') }}?v=upt1">
<link rel="stylesheet" href="{{ asset('vendor/leaflet/leaflet.css') }}" onerror="this.onerror=null;this.href='https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css';" />
<script src="{{ asset('vendor/leaflet/leaflet.js') }}" onerror="this.onerror=null;this.src='https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js';"></script>
<link rel="stylesheet" href="{{ asset('css/reactbits-animations.css') }}" />
<style>
  /* ===== LIGHT MODE (DEFAULT) ===== */
  :root{
    --pln-blue:#00529C;
    --pln-blue-dark:#00386C;
    --pln-yellow:#FFC72C;
    --bg-body:#F4F6F9;
    --bg-card:#FFFFFF;
    --bg-hero:linear-gradient(135deg,#00386C,#00529C);
    --text-main:#2C3E50;
    --text-muted:#6C7A89;
    --border-color:#E2E8F0;
    --table-header-bg:#EDF2F7;
    --tag-bg:#EBF8FF;
    --tag-text:#2B6CB0;
    --status-good-bg:rgba(46,204,113,0.15);
    --status-good-text:#27AE60;
    --card-shadow:0 4px 6px rgba(0,0,0,0.04);
    --btn-toggle-bg:rgba(255,255,255,0.2);
    --btn-toggle-text:#FFFFFF;
    --input-bg:#FFFFFF;
  }
  /* ===== DARK MODE ===== */
  [data-theme="dark"]{
    --pln-blue:#0A192F;
    --pln-blue-dark:#020C1B;
    --pln-yellow:#FFC72C;
    --bg-body:#0F172A;
    --bg-card:#1E293B;
    --bg-hero:linear-gradient(135deg,#020C1B,#1E293B);
    --text-main:#F8FAFC;
    --text-muted:#94A3B8;
    --border-color:#334155;
    --table-header-bg:#334155;
    --tag-bg:#1E3A8A;
    --tag-text:#93C5FD;
    --status-good-bg:rgba(46,204,113,0.25);
    --status-good-text:#2ECC71;
    --card-shadow:0 4px 6px rgba(0,0,0,0.3);
    --btn-toggle-bg:#334155;
    --btn-toggle-text:#FFC72C;
    --input-bg:#1E293B;
  }

  *{box-sizing:border-box;margin:0;padding:0;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;transition:background-color .25s ease,color .25s ease,border-color .25s ease;}
  html{scroll-behavior:smooth;}
  html,body{background:var(--bg-body);color:var(--text-main);min-height:100vh;line-height:1.5;overflow-anchor:none;}
  body{animation: pageFadeIn .35s ease;}
  body.page-fade-out{opacity:0; transition:opacity .18s ease;}
  @keyframes pageFadeIn{ from{opacity:0; transform:translateY(6px);} to{opacity:1; transform:translateY(0);} }

  /* HEADER + NAV */
  #topbar{position:sticky; top:0; z-index:1000;}
  header{
    background:var(--pln-blue); color:#fff;
    padding:10px 24px;
    display:flex; justify-content:space-between; align-items:center;
    box-shadow:0 2px 10px rgba(0,0,0,0.2);
    flex-wrap:wrap; gap:10px;
  }
  .header-brand{display:flex; align-items:center;}
  .logo-pln{height:32px; width:auto; object-fit:contain;}
  .header-right{display:flex; align-items:center; gap:14px; flex-wrap:wrap;}
  .header-nav{display:flex; gap:4px; flex-wrap:wrap;}
  .header-nav a{
    color:rgba(255,255,255,0.85); text-decoration:none; font-size:12.5px; font-weight:600;
    padding:7px 10px; border-radius:5px; white-space:nowrap;
  }
  .header-nav a:hover{color:var(--pln-yellow); background:rgba(255,255,255,0.08);}
  .header-nav a.active{color:var(--pln-yellow); background:rgba(255,255,255,0.12);}
  .theme-toggle-btn{
    background:var(--btn-toggle-bg); color:var(--btn-toggle-text);
    border:1px solid rgba(255,255,255,0.25);
    padding:6px 14px; border-radius:20px; cursor:pointer;
    font-size:12px; font-weight:600;
    display:flex; align-items:center; gap:6px;
  }
  .admin-badge-btn{
    background:rgba(255, 199, 44, 0.18);
    color:var(--pln-yellow);
    border:1px solid var(--pln-yellow);
    padding:6px 12px; border-radius:20px; text-decoration:none;
    font-size:11.5px; font-weight:700;
    display:flex; align-items:center; gap:5px;
    transition: all .2s ease;
  }
  .admin-badge-btn:hover{
    background:var(--pln-yellow);
    color:var(--pln-blue-dark);
  }

  /* HERO — LOGO ONLY */
  .hero{
    background:var(--bg-hero); background-size:200% 200%; color:#fff;
    padding:22px 20px 24px; text-align:center;
    display:flex; flex-direction:column; align-items:center; justify-content:center;
    animation:heroGradientShift 12s ease infinite;
    position:relative; overflow:hidden;
    box-sizing:border-box;
    overflow-anchor:none;
    transition:padding .35s ease, box-shadow .35s ease;
  }
  .hero.hero-shrink, #topbar.hero-shrink .hero{
    padding:13px 20px !important;
    justify-content:center !important;
    align-items:center !important;
    box-shadow:0 4px 14px rgba(0,0,0,0.18);
  }
  @keyframes heroGradientShift{
    0%{background-position:0% 50%;}
    50%{background-position:100% 50%;}
    100%{background-position:0% 50%;}
  }
  .hero::before{
    content:''; position:absolute; inset:0; pointer-events:none;
    background-image:radial-gradient(rgba(255,255,255,0.35) 1.5px, transparent 1.5px);
    background-size:38px 38px;
    animation:heroParticleDrift 18s linear infinite;
    opacity:0.35;
  }
  @keyframes heroParticleDrift{
    from{background-position:0 0;}
    to{background-position:190px 190px;}
  }
  .logo-upt{
    height:120px; max-width:90%; width:auto; object-fit:contain;
    filter:drop-shadow(0 4px 8px rgba(0,0,0,0.3));
    position:relative; z-index:1;
    display:block; margin:0 auto;
    animation:logoFloat 4.5s ease-in-out infinite;
    transition:height .35s ease;
  }
  .hero.hero-shrink .logo-upt, #topbar.hero-shrink .logo-upt{
    height:68px !important;
    margin:0 auto !important;
  }
  @keyframes logoFloat{
    0%,100%{ transform:translateY(0px); }
    50%{ transform:translateY(-5px); }
  }
  .status-badge{
    display:inline-flex; align-items:center; gap:6px; justify-content:center;
    margin-top:12px;
    background:var(--status-good-bg); border:1px solid var(--status-good-text); color:var(--status-good-text);
    padding:4px 14px; border-radius:20px; font-size:12px; font-weight:600;
    line-height:1.4; position:relative; z-index:1;
    max-height:40px; overflow:hidden;
    transition:opacity .3s ease, transform .3s ease, margin .35s ease, max-height .35s ease, padding .35s ease;
  }
  .hero.hero-shrink .status-badge, #topbar.hero-shrink .status-badge{
    opacity:0 !important;
    transform:translateY(-8px) scale(0.9) !important;
    margin-top:0 !important;
    margin-bottom:0 !important;
    max-height:0 !important;
    padding-top:0 !important;
    padding-bottom:0 !important;
    border-width:0 !important;
    pointer-events:none !important;
  }

  .container{max-width:1150px; margin:28px auto 40px; padding:0 16px; position:relative; z-index:auto;}

  .section-header-flex{display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin:0 0 15px;}
  .section-title{
    font-size:17px; font-weight:700; color:var(--text-main);
    border-left:4px solid var(--pln-yellow); padding-left:10px; margin:0;
    scroll-margin-top:70px;
  }
  .month-filter-container{display:flex; align-items:center; gap:8px; font-size:13px; font-weight:600; color:var(--text-muted);}
  .month-select{
    background:var(--input-bg); color:var(--text-main); border:1px solid var(--border-color);
    padding:6px 12px; border-radius:6px; font-size:13px; font-weight:600; outline:none; cursor:pointer; box-shadow:var(--card-shadow);
  }

  .grid-3{display:grid; grid-template-columns:repeat(auto-fit,minmax(300px,1fr)); gap:15px;}
  .card{background:var(--bg-card); border-radius:8px; padding:20px; border:1px solid var(--border-color); box-shadow:var(--card-shadow);}
  .card-header-sm{font-size:12px; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px; font-weight:600;}
  .card-value{font-size:28px; font-weight:700; color:var(--pln-blue);}
  [data-theme="dark"] .card-value{color:var(--pln-yellow);}
  [data-theme="dark"] .section-header-flex a{color:var(--pln-yellow) !important;}
  .card-footer-sm{font-size:12px; margin-top:10px; color:var(--text-muted);}
  .ahi-bar{display:flex; height:8px; border-radius:20px; overflow:hidden; margin-top:12px; background:var(--border-color);}
  .ahi-bar span{height:100%;}
  .ahi-legend{display:flex; gap:10px; font-size:11px; color:var(--text-muted); margin-top:8px; flex-wrap:wrap;}
  .ahi-legend b{color:var(--text-main);}
  .il3-bar-wrap{width:100%; height:34px; border-radius:8px; background:var(--border-color); overflow:hidden; margin-top:10px; position:relative;}
  .il3-bar-fill{height:100%; background:linear-gradient(90deg,var(--pln-blue),#00A3E0); display:flex; align-items:center; justify-content:center; min-width:48px; transition:width .6s ease; border-radius:8px 0 0 8px;}
  [data-theme="dark"] .il3-bar-fill{background:linear-gradient(90deg,var(--pln-yellow),#F97316);}
  .il3-bar-fill span{font-size:12px; font-weight:700; color:#fff; white-space:nowrap; padding:0 8px;}
  [data-theme="dark"] .il3-bar-fill span{color:#1E293B;}

  .asset-map-wrapper{display:grid; grid-template-columns:2fr 1fr; gap:15px;}
  @media (max-width:768px){.asset-map-wrapper{grid-template-columns:1fr;}}
  #map-sulut-gorontalo{width:100%; height:460px; border-radius:8px; border:1px solid var(--border-color); box-shadow:var(--card-shadow); z-index:1; margin-bottom:15px;}
  .asset-cards-row{display:grid; grid-template-columns:repeat(5,1fr); gap:12px;}
  @media (max-width:900px){.asset-cards-row{grid-template-columns:repeat(2,1fr);}}
  @media (max-width:520px){.asset-cards-row{grid-template-columns:1fr;}}
  .asset-stat-card{background:var(--bg-card); border:1px solid var(--border-color); border-radius:8px; padding:16px; display:flex; align-items:center; justify-content:space-between; box-shadow:var(--card-shadow); cursor:default; position:relative;}
  .asset-stat-card:hover{border-color:var(--pln-blue);}
  [data-theme="dark"] .asset-stat-card:hover{border-color:var(--pln-yellow);}
  .asset-tooltip{
    display:none; position:absolute; bottom:calc(100% + 8px); left:0; right:0; z-index:20;
    background:var(--bg-card); border:1px solid var(--border-color); border-radius:8px;
    box-shadow:0 8px 20px rgba(0,0,0,0.18); padding:10px 12px; font-size:12px; color:var(--text-main);
    max-height:220px; overflow-y:auto;
  }
  .asset-stat-card:hover .asset-tooltip{display:block;}
  .asset-tooltip table{width:100%; border-collapse:collapse; font-size:11.5px;}
  .asset-tooltip th{text-align:left; padding:3px 4px; color:var(--text-muted); border-bottom:1px solid var(--border-color); font-weight:700;}
  .asset-tooltip td{padding:3px 4px; border-bottom:1px solid var(--border-color);}
  .asset-tooltip .ttl{font-weight:700; margin-bottom:6px; color:var(--pln-blue);}
  [data-theme="dark"] .asset-tooltip .ttl{color:var(--pln-yellow);}
  .asset-stat-info h4{font-size:12px; color:var(--text-muted); text-transform:uppercase;}
  .asset-stat-info .num{font-size:22px; font-weight:700; color:var(--pln-blue);}
  [data-theme="dark"] .asset-stat-info .num{color:var(--pln-yellow);}
  .asset-icon{font-size:28px; opacity:0.85;}

  .ultg-card{background:var(--bg-card); border-radius:8px; border:1px solid var(--border-color); padding:18px; box-shadow:var(--card-shadow);}
  .loading,.err{padding:20px; text-align:center; color:var(--text-muted); font-size:13px; grid-column:1/-1;}
  .err{color:#E74C3C;}
  .ultg-title{font-size:15px; font-weight:700; color:var(--text-main); margin-bottom:5px;}
  .ultg-desc{font-size:13px; color:var(--text-muted); margin-bottom:12px;}

  .progress-wrap{background:var(--border-color); border-radius:20px; height:8px; overflow:hidden; margin-top:10px;}
  .progress-bar{height:100%; background:var(--pln-blue); border-radius:20px;}
  [data-theme="dark"] .progress-bar{background:var(--pln-yellow);}
  .progress-label{display:flex; justify-content:space-between; font-size:11px; color:var(--text-muted); margin-top:6px;}

  .underach-list{margin-top:12px; padding-top:10px; border-top:1px dashed var(--border-color); max-height:150px; overflow-y:auto;}
  .underach-item{display:flex; justify-content:space-between; align-items:center; gap:8px; padding:6px 4px; font-size:11.5px; border-radius:5px;}
  .underach-item:hover{background:var(--table-header-bg);}
  .underach-name{color:var(--text-main); flex:1; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;}
  .underach-vals{color:#E74C3C; font-weight:700; white-space:nowrap; font-size:11px;}

  .card-hover-tooltip{
    position:fixed; z-index:3000;
    background:var(--bg-card) !important;
    color:var(--text-main);
    border:1px solid var(--border-color); border-radius:10px;
    box-shadow:0 14px 34px rgba(0,0,0,0.22), 0 2px 8px rgba(0,0,0,0.08);
    padding:12px 16px; max-height:280px; overflow-y:auto; pointer-events:auto;
    opacity:0; visibility:hidden; transform:translateY(4px);
    transition:opacity .18s ease, transform .18s ease, visibility .18s;
  }
  .card-hover-tooltip.active{
    opacity:1; visibility:visible; transform:translateY(0);
  }
  /* Invisible hover bridge to eliminate gap between card and tooltip */
  .card-hover-tooltip::before{
    content:''; position:absolute; left:0; right:0; height:14px; pointer-events:auto;
  }
  .card-hover-tooltip.pos-below::before{ top:-12px; }
  .card-hover-tooltip.pos-above::before{ bottom:-12px; }

  #focusBackdrop{
    position:fixed; inset:0; z-index:2500;
    background:rgba(15, 23, 42, 0.45);
    backdrop-filter:blur(4px); -webkit-backdrop-filter:blur(4px);
    opacity:0; visibility:hidden; pointer-events:none !important;
    transition:opacity .22s cubic-bezier(0.4, 0, 0.2, 1), visibility .22s;
  }
  #focusBackdrop.active{
    opacity:1; visibility:visible;
  }
  .focus-highlight{
    position:relative; z-index:2600 !important;
    background:var(--bg-card) !important;
    border-color:var(--pln-blue) !important;
    box-shadow:0 0 0 3px var(--pln-blue), 0 16px 36px rgba(0,0,0,0.32) !important;
    transform:translateY(-2px);
    transition:transform .2s ease, box-shadow .2s ease, border-color .2s ease;
  }
  [data-theme="dark"] .focus-highlight{
    border-color:var(--pln-yellow) !important;
    box-shadow:0 0 0 3px var(--pln-yellow), 0 16px 36px rgba(0,0,0,0.55) !important;
  }
  .cht-title{font-size:11px; font-weight:700; color:var(--pln-blue); text-transform:uppercase; letter-spacing:0.3px; margin-bottom:8px; padding-bottom:6px; border-bottom:1px solid var(--border-color);}
  [data-theme="dark"] .cht-title{color:var(--pln-yellow);}
  .cht-row{display:flex; justify-content:space-between; gap:10px; padding:5px 0; font-size:11.5px; border-bottom:1px dashed var(--border-color);}
  .cht-row:last-child{border-bottom:none;}
  .cht-name{color:var(--text-main); flex:1;}
  .cht-vals{color:var(--text-muted); font-weight:700; white-space:nowrap;}
  .cht-vals.under{color:#E74C3C;}

  .btn-detail-link{
    display:inline-flex; align-items:center; gap:6px;
    background:rgba(0, 82, 156, 0.08); color:var(--pln-blue);
    border:1px solid rgba(0, 82, 156, 0.25);
    padding:6px 14px; border-radius:20px; text-decoration:none;
    font-size:12px; font-weight:700; transition:all .2s ease;
  }
  .btn-detail-link:hover{
    background:var(--pln-blue); color:#fff; transform:translateX(3px);
  }
  [data-theme="dark"] .btn-detail-link{
    background:rgba(255, 199, 44, 0.12); color:var(--pln-yellow);
    border-color:rgba(255, 199, 44, 0.3);
  }
  [data-theme="dark"] .btn-detail-link:hover{
    background:var(--pln-yellow); color:var(--pln-blue-dark);
  }

  footer{background:var(--pln-blue-dark); color:#94A3B8; text-align:center; padding:20px; font-size:12px; border-top:3px solid var(--pln-yellow);}

  .page-restricted-blurred {
    filter: blur(7px);
    pointer-events: none;
    user-select: none;
  }

  @media (max-width:900px){
    .header-nav{order:3; width:100%; justify-content:flex-start; overflow-x:auto; padding-bottom:2px;}
  }
</style>
@yield('styles')
</head>
<body>

<div id="topbar" class="{{ (($isRestricted ?? false) && !($isUnlocked ?? false)) ? 'topbar-locked' : '' }}">
<!-- HEADER + NAV -->
<header>
  <div class="header-brand">
    <a href="{{ route('home') }}">
      <img src="{{ asset($settings['pln_logo'] ?? 'PLN_White.png') }}" alt="Logo PLN" class="logo-pln">
    </a>
  </div>
  <nav class="header-nav">
    @if(isset($navItems) && count($navItems) > 0)
      @foreach($navItems as $nav)
        <a href="{{ $nav->url }}" class="{{ request()->is(ltrim($nav->url, '/')) || (request()->path() == '/' && $nav->url == '/') ? 'active' : '' }}">
          {{ $nav->label }}
        </a>
      @endforeach
    @else
      <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
      <a href="{{ route('kinerja-transmisi') }}" class="{{ request()->routeIs('kinerja-transmisi') ? 'active' : '' }}">Kinerja Unit</a>
      <a href="{{ route('anggaran') }}" class="{{ request()->routeIs('anggaran') ? 'active' : '' }}">Anggaran Unit</a>
      <a href="{{ route('aset') }}" class="{{ request()->routeIs('aset') ? 'active' : '' }}">Aset</a>
      <a href="{{ route('ahi') }}" class="{{ request()->routeIs('ahi') ? 'active' : '' }}">AHI</a>
      <a href="{{ route('common-enemy') }}" class="{{ request()->routeIs('common-enemy') ? 'active' : '' }}">Common Enemy</a>
      <a href="{{ route('abo') }}" class="{{ request()->routeIs('abo') ? 'active' : '' }}">Program Anti Blackout</a>
      <a href="{{ route('konstruksi-penyaluran') }}" class="{{ request()->routeIs('konstruksi-penyaluran') ? 'active' : '' }}">Konstruksi &amp; Penyaluran</a>
      <a href="{{ route('kku') }}" class="{{ request()->routeIs('kku') ? 'active' : '' }}">KKU</a>
    @endif
  </nav>
  <div class="header-right">
    <button class="theme-toggle-btn" id="themeToggle" onclick="toggleTheme()">
      <span id="themeIcon">🌙</span> <span id="themeText">Dark Mode</span>
    </button>

    @if(($isRestricted ?? false) && ($isUnlocked ?? false))
      <button id="btnLockUnivPage" onclick="lockCurrentPage('manual')" style="display:inline-flex; align-items:center; gap:5px; background:rgba(231,76,60,0.18); color:#E74C3C; border:1px solid #E74C3C; padding:6px 12px; border-radius:20px; font-size:11.5px; font-weight:700; cursor:pointer;" title="Kunci kembali akses halaman ini">
        🔒 Kunci Akses
      </button>
    @endif

    @auth
      <a href="{{ route('admin.dashboard') }}" class="admin-badge-btn" title="Panel Admin PLN">
        ⚙️ Admin Panel
      </a>
    @else
      <a href="{{ route('login') }}" class="admin-badge-btn" title="Login Admin untuk edit konten">
        🔒 Login Admin
      </a>
    @endauth
  </div>
</header>

<!-- HERO — LOGO ONLY -->
<section class="hero">
  <img src="{{ asset($settings['hero_logo'] ?? 'Logo_UPT_Manado.png') }}" alt="Logo UPT Manado" class="logo-upt">
  @if(($settings['enable_live_clock'] ?? '1') === '1')
    <span class="status-badge">{{ $settings['hero_badge_text'] ?? '● LIVE — Update:' }} <span id="heroLiveClock">Memuat...</span></span>
  @endif
</section>
</div>

<div id="pageAppWrapper" class="{{ (($isRestricted ?? false) && !($isUnlocked ?? false)) ? 'page-restricted-blurred' : '' }}">
  <!-- MAIN CONTENT -->
  @yield('content')

  <footer>
    {{ $settings['footer_text'] ?? '© 2026 PT PLN (Persero) UPT Manado — Dashboard Kinerja Transmisi. All Rights Reserved.' }}
  </footer>
</div>

@include('partials.page-access-overlay')

<div id="focusBackdrop"></div>
<div id="cardHoverTooltip" class="card-hover-tooltip"></div>

<!-- Data Sources Config for JS (Semua Sumber Data Dinamis Masuk Otomatis) -->
<script>
  window.APP_DATA_SOURCES = @json($dataSources ?? []);
</script>

<script>
  // Jam live untuk badge hero
  const DAY_NAMES_EN = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
  const MONTH_NAMES_EN = ['January','February','March','April','May','June','July','August','September','October','November','December'];
  function tickHeroClock(){
    const el = document.getElementById('heroLiveClock');
    if(!el) return;
    const now = new Date();
    const dd = now.getDate();
    const hh = String(now.getHours()).padStart(2,'0');
    const mi = String(now.getMinutes()).padStart(2,'0');
    const ss = String(now.getSeconds()).padStart(2,'0');
    el.textContent = `${DAY_NAMES_EN[now.getDay()]}, ${dd} ${MONTH_NAMES_EN[now.getMonth()]} ${now.getFullYear()}, ${hh}.${mi}.${ss}`;
  }
  tickHeroClock();
  setInterval(tickHeroClock, 1000);

  // Hero mengecil saat scroll turun (badge fade out)
  function updateTopbarHeight(){
    const header = document.querySelector('header');
    if(header) document.documentElement.style.setProperty('--header-h', header.offsetHeight + 'px');
    const topbar = document.getElementById('topbar');
    if(topbar) document.documentElement.style.setProperty('--topbar-h', topbar.offsetHeight + 'px');
  }
  updateTopbarHeight();
  window.addEventListener('resize', updateTopbarHeight);
  window.addEventListener('load', updateTopbarHeight);

  const heroEl = document.querySelector('.hero');
  const topbarEl = document.getElementById('topbar');
  let heroShrunk = false;
  let scrollTicking = false;
  const SHRINK_ON = 80;
  const SHRINK_OFF = 20;
  function applyHeroScrollState(){
    const y = window.scrollY || window.pageYOffset || 0;
    if(!heroShrunk && y > SHRINK_ON){
      heroShrunk = true;
      if(heroEl) heroEl.classList.add('hero-shrink');
      if(topbarEl) topbarEl.classList.add('hero-shrink');
    }else if(heroShrunk && y < SHRINK_OFF){
      heroShrunk = false;
      if(heroEl) heroEl.classList.remove('hero-shrink');
      if(topbarEl) topbarEl.classList.remove('hero-shrink');
    }
    scrollTicking = false;
    updateTopbarHeight();
  }
  function onScrollHero(){
    if(scrollTicking) return;
    scrollTicking = true;
    requestAnimationFrame(applyHeroScrollState);
  }
  window.addEventListener('scroll', onScrollHero, {passive:true});
  applyHeroScrollState();

  // Theme Toggle
  function applyThemeUI(theme){
    const icon = document.getElementById('themeIcon');
    const text = document.getElementById('themeText');
    if(icon) icon.textContent = theme === 'dark' ? '☀️' : '🌙';
    if(text) text.textContent = theme === 'dark' ? 'Light Mode' : 'Dark Mode';
  }
  function toggleTheme(){
    const html = document.documentElement;
    const current = html.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
    const next = current === 'dark' ? 'light' : 'dark';
    html.setAttribute('data-theme', next);
    localStorage.setItem('theme', next);
    applyThemeUI(next);
  }
  (function initTheme(){
    const saved = localStorage.getItem('theme') || '{{ $settings['default_theme'] ?? 'light' }}';
    document.documentElement.setAttribute('data-theme', saved);
    applyThemeUI(saved);
  })();
</script>

@yield('scripts')

<!-- ReactBits Animation Suite -->
<script src="{{ asset('js/reactbits-animations.js') }}"></script>

</body>
</html>
