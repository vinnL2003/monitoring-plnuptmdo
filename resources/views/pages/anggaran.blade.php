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
<title>ANGGARAN UNIT — UPT MANADO</title>
<link rel="icon" type="image/png" href="{{ asset('Logo_UPT_Manado.png') }}?v=upt1">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=upt1">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v=upt1">
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=upt1">
<link rel="apple-touch-icon" href="{{ asset('Logo_UPT_Manado.png') }}?v=upt1">
<link rel="stylesheet" href="{{ asset('css/reactbits-animations.css') }}">
<style>
  :root{
    --pln-blue:#00529C; --pln-blue-dark:#00386C; --pln-yellow:#FFC72C;
    --bg-body:#F4F6F9; --bg-card:#FFFFFF; --bg-hero:linear-gradient(135deg,#00386C,#00529C);
    --text-main:#2C3E50; --text-muted:#6C7A89; --border-color:#E2E8F0;
    --table-header-bg:#EDF2F7; --card-shadow:0 4px 6px rgba(0,0,0,0.04);
    --btn-toggle-bg:rgba(255,255,255,0.2); --btn-toggle-text:#FFFFFF; --input-bg:#FFFFFF;
    --green:#27AE60; --red:#E74C3C; --yellow:#D9A400;
  }
  [data-theme="dark"]{
    --pln-blue:#0A192F; --pln-blue-dark:#020C1B; --pln-yellow:#FFC72C;
    --bg-body:#0F172A; --bg-card:#1E293B; --bg-hero:linear-gradient(135deg,#020C1B,#1E293B);
    --text-main:#F8FAFC; --text-muted:#94A3B8; --border-color:#334155;
    --table-header-bg:#263449; --card-shadow:0 4px 6px rgba(0,0,0,0.3);
    --btn-toggle-bg:#334155; --btn-toggle-text:#FFC72C; --input-bg:#1E293B;
    --green:#2ECC71; --red:#FF6B6B; --yellow:#FFD23F;
  }
  *{box-sizing:border-box;margin:0;padding:0;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;transition:background-color .25s ease,color .25s ease,border-color .25s ease;}
  html,body{background:var(--bg-body);color:var(--text-main);min-height:100vh;line-height:1.5;overflow-anchor:none;}

  .theme-toggle-btn{background:var(--btn-toggle-bg); color:var(--btn-toggle-text); border:1px solid rgba(255,255,255,0.25); padding:6px 14px; border-radius:20px; cursor:pointer; font-size:12px; font-weight:600; display:flex; align-items:center; gap:6px;}

  header{background:var(--pln-blue); color:#fff; padding:10px 24px; display:flex; justify-content:space-between; align-items:center; box-shadow:0 2px 10px rgba(0,0,0,0.2); flex-wrap:wrap; gap:10px;}
  .header-brand{display:flex; align-items:center;}
  .logo-pln{height:32px; width:auto; object-fit:contain;}
  .header-right{display:flex; align-items:center; gap:18px; flex-wrap:wrap;}
  .header-nav{display:flex; gap:4px; flex-wrap:wrap;}
  .header-nav a{color:rgba(255,255,255,0.85); text-decoration:none; font-size:12.5px; font-weight:600; padding:7px 10px; border-radius:5px; white-space:nowrap;}
  .header-nav a:hover{color:var(--pln-yellow); background:rgba(255,255,255,0.08);}
  .header-nav a.active{color:var(--pln-yellow); background:rgba(255,255,255,0.12);}

  /* HERO — UNIFORM MOVING BANNER */
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
    background:rgba(46,204,113,0.18); border:1px solid #2ECC71; color:#2ECC71;
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

  #topbar{position:sticky; top:0; z-index:1000;}
  footer{background:var(--pln-blue-dark); color:#94A3B8; text-align:center; padding:20px; font-size:12px; border-top:3px solid var(--pln-yellow);}

  body{animation: pageFadeIn .35s ease;}
  body.page-fade-out{opacity:0; transition:opacity .18s ease;}
  @keyframes pageFadeIn{ from{opacity:0; transform:translateY(6px);} to{opacity:1; transform:translateY(0);} }

  .page-layout{display:flex; align-items:flex-start;}
  .sidebar-hover-trigger{position:fixed; top:var(--topbar-h,0px); left:0; width:16px; height:calc(100vh - var(--topbar-h,0px)); z-index:940;}
  .sidebar{
    width:230px; flex-shrink:0; padding:16px 0;
    position:fixed; top:var(--topbar-h, 0px); left:0; z-index:950;
    height:calc(100vh - var(--topbar-h, 0px)); overflow-y:auto;
    background:rgba(255,255,255,0.72); backdrop-filter:blur(12px); -webkit-backdrop-filter:blur(12px);
    border-right:1px solid var(--border-color);
    transform:translateX(-100%); transition:transform 0.25s ease, box-shadow 0.25s ease;
  }
  [data-theme="dark"] .sidebar{background:rgba(15,23,42,0.72);}
  .sidebar.sidebar-visible{transform:translateX(0); box-shadow:4px 0 24px rgba(0,0,0,0.2);}
  main{flex:1; min-width:0; margin:0; max-width:none; padding:24px 24px 60px; width:100%;}
  @media (max-width:820px){ .page-layout{flex-direction:column;} .sidebar{width:100%; height:auto; position:static; transform:none; backdrop-filter:none; background:var(--bg-card);} .sidebar-hover-trigger{display:none;} }
  .sidebar .sb-group-title{padding:12px 20px 6px; font-size:11px; font-weight:800; letter-spacing:0.5px; color:var(--text-muted); text-transform:uppercase;}
  .sidebar a{display:flex; align-items:center; gap:8px; padding:9px 20px 9px 36px; font-size:12.5px; font-weight:600; color:var(--text-main); text-decoration:none; border-left:3px solid transparent; cursor:pointer;}
  .sidebar a.active{background:var(--table-header-bg); border-left-color:var(--pln-blue); color:var(--pln-blue);}
  [data-theme="dark"] .sidebar a.active{color:var(--pln-yellow); border-left-color:var(--pln-yellow);}
  .sidebar a:not(.active):hover{background:var(--table-header-bg);}

  .two-col{display:grid; grid-template-columns:1fr 1fr; gap:20px; align-items:start;}
  @media (max-width:980px){ .two-col{grid-template-columns:1fr;} }
  .section-block{scroll-margin-top:calc(var(--topbar-h, 0px) + 12px);}
  .module-title{font-size:15px; font-weight:800; color:var(--text-main); margin:0 0 4px; padding-bottom:9px; border-bottom:2px solid var(--pln-blue);}
  [data-theme="dark"] .module-title{border-bottom-color:var(--pln-yellow);}
  .cat-title{font-size:11.5px; font-weight:700; letter-spacing:0.3px; color:var(--text-muted); text-transform:uppercase; margin:18px 0 8px;}

  .summary-grid{display:grid; grid-template-columns:repeat(4,1fr); gap:10px; margin-bottom:6px;}
  @media (max-width:700px){ .summary-grid{grid-template-columns:repeat(2,1fr);} }
  .summary-card.clickable{cursor:pointer; transition:box-shadow 0.15s ease;}
  .summary-card.clickable:hover{box-shadow:0 4px 14px rgba(0,0,0,0.15);}
  .summary-card{background:var(--bg-card); border:1px solid var(--border-color); border-radius:8px; padding:12px 14px 12px 16px; box-shadow:var(--card-shadow); border-left-width:4px; border-left-style:solid;}
  .summary-card.accent-green{border-left-color:#27AE60;}
  .summary-card.accent-blue{border-left-color:#00529C;}
  .summary-card.accent-yellow{border-left-color:#D9A400;}
  .summary-card.accent-red{border-left-color:#E74C3C;}
  .summary-card .lbl{font-size:10px; font-weight:700; letter-spacing:0.2px; color:var(--text-muted); text-transform:uppercase; margin-bottom:5px;}
  .summary-card .val{font-size:14.5px; font-weight:800; color:var(--pln-blue);}
  [data-theme="dark"] .summary-card .val{color:var(--pln-yellow);}

  .chart-wrap{position:relative; width:100%; height:300px; margin:12px 0 16px; background:var(--bg-card); border:1px solid var(--border-color); border-radius:8px; padding:12px;}

  table{width:100%; border-collapse:collapse; font-size:12px; background:var(--bg-card); border:1px solid var(--border-color); border-radius:8px; overflow:hidden;}
  th{background:var(--table-header-bg); text-align:left; padding:8px 9px; font-size:10px; text-transform:uppercase; color:var(--text-muted); font-weight:700;}
  td{padding:7px 9px; border-top:1px solid var(--border-color);}
  .num-cell{text-align:right; font-variant-numeric:tabular-nums;}

  .loading,.err{padding:24px 0; text-align:center; color:var(--text-muted); font-size:13px;}
  .err{color:var(--red);}

  .detail-placeholder{font-size:12px; color:var(--text-muted); padding:16px; background:var(--bg-card); border:1px dashed var(--border-color); border-radius:8px; text-align:center;}

  .modal-overlay{display:none; position:fixed; inset:0; background:rgba(0,0,0,0.55); z-index:3000; align-items:center; justify-content:center; padding:20px;}
  .modal-box{background:var(--bg-card); border-radius:10px; max-width:720px; width:100%; max-height:82vh; display:flex; flex-direction:column; box-shadow:0 10px 40px rgba(0,0,0,0.3);}
  .modal-header{display:flex; justify-content:space-between; align-items:center; padding:16px 20px; border-bottom:1px solid var(--border-color); font-weight:700; font-size:14px; color:var(--pln-blue);}
  [data-theme="dark"] .modal-header{color:var(--pln-yellow);}
  .modal-close{background:none; border:none; font-size:16px; cursor:pointer; color:var(--text-muted);}
  .modal-close:hover{color:var(--red);}
  .modal-body{padding:8px 20px 20px; overflow-y:auto;}

  .prk-search-wrap{display:flex; gap:8px; margin-bottom:12px; position:sticky; top:0; background:var(--bg-card); padding-bottom:8px; z-index:1;}
  .prk-search-wrap input{flex:1; padding:8px 12px; border:1px solid var(--border-color); border-radius:6px; background:var(--input-bg); color:var(--text-main); font-size:13px;}
  .prk-search-wrap button{padding:8px 16px; border:1px solid var(--pln-blue); background:var(--pln-blue); color:#fff; border-radius:6px; cursor:pointer; font-size:13px; font-weight:600; white-space:nowrap;}
  [data-theme="dark"] .prk-search-wrap button{background:var(--pln-yellow); border-color:var(--pln-yellow); color:#0A2540;}

  .prk-row{cursor:pointer;}
  .prk-mode-wrap{display:flex; align-items:center; gap:8px; margin-bottom:12px; font-size:12px; color:var(--text-muted);}
  .prk-mode-wrap select{padding:6px 10px; border:1px solid var(--border-color); border-radius:6px; background:var(--input-bg); color:var(--text-main); font-size:12px; font-weight:600;}
  .prk-group-row td{background:var(--table-header-bg); font-weight:700; color:var(--pln-blue); padding:8px 10px;}
  [data-theme="dark"] .prk-group-row td{color:var(--pln-yellow);}
  .prk-row:hover{background:var(--table-header-bg);}
  .prk-row.prk-highlight{background:rgba(255,199,44,0.35); transition:background 0.3s ease;}
  .kk-uraian-cell{max-width:220px; white-space:normal; word-wrap:break-word;}

  .progress-badge{display:inline-block; padding:3px 10px; border-radius:12px; font-size:10.5px; font-weight:700; color:#fff;}
  .progress-badge.red{background:#E74C3C;}
  .progress-badge.yellow{background:#D9A400;}
  .progress-badge.blue{background:#00529C;}
  .progress-badge.green{background:#27AE60;}
  .progress-badge.gray{background:var(--text-muted);}

  .pct-bar-track{position:relative; width:100%; min-width:80px; height:18px; background:var(--table-header-bg); border-radius:4px; overflow:hidden;}
  .pct-bar-fill{height:100%; display:flex; align-items:center; justify-content:flex-end; padding-right:4px; color:#fff; font-size:10px; font-weight:700; white-space:nowrap; transition:width 0.3s ease;}
  .pct-bar-label-outside{position:absolute; top:0; left:4px; height:18px; display:flex; align-items:center; font-size:10px; font-weight:700; color:var(--text-main);}
  .page-blurred{filter:blur(7px); pointer-events:none; user-select:none;}

  /* Compact Hero Banner saat Halaman Terkunci (identik dengan hero-shrink) */
  #topbar.topbar-locked .hero {
    padding: 13px 20px !important;
    justify-content: center !important;
    align-items: center !important;
    box-shadow: 0 4px 14px rgba(0,0,0,0.18);
    transition: padding .3s ease;
  }
  #topbar.topbar-locked .hero .logo-upt,
  #topbar.topbar-locked .logo-upt {
    height: 68px !important;
    max-height: 68px !important;
    margin: 0 auto !important;
    image-rendering: -webkit-optimize-contrast;
    image-rendering: crisp-edges;
    transition: height .3s ease;
  }
  #topbar.topbar-locked .hero .status-badge,
  #topbar.topbar-locked .status-badge {
    opacity: 0 !important;
    transform: translateY(-8px) scale(0.9) !important;
    margin-top: 0 !important;
    margin-bottom: 0 !important;
    max-height: 0 !important;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    border-width: 0 !important;
    pointer-events: none !important;
    display: none !important;
  }

  .login-overlay{
    position:fixed; top:var(--topbar-h, 0px); left:0; right:0; bottom:0; z-index:99999; display:none;
    align-items:flex-start; justify-content:center;
    background:rgba(10,20,45,0.45);
    overflow-y:auto; padding:24px 14px; box-sizing:border-box;
  }
  .login-box{
    margin:auto;
    background:var(--bg-card); border:1px solid var(--border-color); border-radius:14px; padding:26px 28px; width:100%; max-width:360px;
    box-shadow:0 20px 60px rgba(0,0,0,0.4); text-align:center;
  }
  .login-box img.login-logo-dark{ display:none; }
  .login-box img.login-logo-light{ display:inline-block; height:42px; width:auto; object-fit:contain; margin-bottom:12px; }
  [data-theme="dark"] .login-box img.login-logo-light{ display:none; }
  [data-theme="dark"] .login-box img.login-logo-dark{ display:inline-block; height:42px; width:auto; object-fit:contain; margin-bottom:12px; }
  .login-box h2{font-size:16px; color:var(--pln-blue); margin-bottom:6px;}
  [data-theme="dark"] .login-box h2{color:var(--pln-yellow);}
  .login-box p{font-size:12px; color:var(--text-muted); margin-bottom:16px;}
  .login-box input{
    width:100%; padding:10px 12px; margin-bottom:10px; border:1px solid var(--border-color);
    border-radius:8px; background:var(--input-bg); color:var(--text-main); font-size:13px; box-sizing:border-box;
  }
  .login-box button{
    width:100%; padding:10px; border:none; border-radius:8px; background:var(--pln-blue); color:#fff;
    font-size:13px; font-weight:700; cursor:pointer; margin-top:4px;
  }
  [data-theme="dark"] .login-box button{background:var(--pln-yellow); color:#0A2540;}
  .login-box button:hover{opacity:0.9;}
  .login-error{color:#E74C3C; font-size:12px; margin-top:8px; display:none;}
</style>
</head>
<body>

<div id="topbar" class="{{ (($isRestricted ?? true) && !($isUnlocked ?? false)) ? 'topbar-locked' : '' }}">
<header>
  <div class="header-brand"><a href="{{ route('home') }}"><img src="{{ asset($settings['pln_logo'] ?? 'PLN_White.png') }}" alt="Logo PLN" class="logo-pln"></a></div>
  <nav class="header-nav">
    @if(isset($navItems) && count($navItems) > 0)
      @foreach($navItems as $nav)
        <a href="{{ $nav->url }}" class="{{ request()->is(ltrim($nav->url, '/')) || (request()->path() == '/' && $nav->url == '/') ? 'active' : '' }}">
          {{ $nav->label }}
        </a>
      @endforeach
    @else
      <a href="{{ route('home') }}">Home</a>
      <a href="{{ route('kinerja-transmisi') }}">Kinerja Unit</a>
      <a href="{{ route('anggaran') }}" class="active">Anggaran Unit</a>
      <a href="{{ route('aset') }}">Aset</a>
      <a href="{{ route('ahi') }}">AHI</a>
      <a href="{{ route('common-enemy') }}">Common Enemy</a>
      <a href="{{ route('abo') }}">Program Anti Blackout</a>
      <a href="{{ route('konstruksi-penyaluran') }}">Konstruksi &amp; Penyaluran</a>
      <a href="{{ route('kku') }}">KKU</a>
    @endif
  </nav>
  <div class="header-right">
    <button class="theme-toggle-btn" id="themeToggle" onclick="toggleTheme()"><span id="themeIcon">🌙</span> <span id="themeText">Dark Mode</span></button>
  
    <button id="btnLockAnggaran" onclick="lockAnggaran('manual')" style="display:{{ (($isRestricted ?? true) && ($isUnlocked ?? false)) ? 'inline-flex' : 'none' }}; align-items:center; gap:5px; background:rgba(231,76,60,0.18); color:#E74C3C; border:1px solid #E74C3C; padding:6px 12px; border-radius:20px; font-size:11.5px; font-weight:700; cursor:pointer;" title="Kunci kembali akses anggaran">
      🔒 Kunci Akses
    </button>

    @auth
      <a href="{{ route('admin.dashboard') }}" style="background:rgba(255,199,44,0.18);color:var(--pln-yellow);border:1px solid var(--pln-yellow);padding:5px 12px;border-radius:20px;text-decoration:none;font-size:11.5px;font-weight:700;">⚙️ Admin</a>
    @else
      <a href="{{ route('login') }}" style="background:rgba(255,199,44,0.18);color:var(--pln-yellow);border:1px solid var(--pln-yellow);padding:5px 12px;border-radius:20px;text-decoration:none;font-size:11.5px;font-weight:700;">🔒 Login</a>
    @endauth
  </div>
</header>
<section class="hero">
  <img src="{{ asset($settings['hero_logo'] ?? 'Logo_UPT_Manado.png') }}" alt="Logo UPT Manado" class="logo-upt">
  @if(($settings['enable_live_clock'] ?? '1') === '1')
    <span class="status-badge">{{ $settings['hero_badge_text'] ?? '● LIVE — Update:' }} <span id="heroLiveClock">Memuat...</span></span>
  @endif
</section>
</div>

<div class="page-layout {{ (($isRestricted ?? true) && !($isUnlocked ?? false)) ? 'page-blurred' : '' }}">
  <div class="sidebar-hover-trigger" id="sidebarTrigger"></div>
  <aside class="sidebar" id="mainSidebar">
    <div class="sb-group-title">Anggaran Investasi</div>
    <a onclick="openPrkPopup(this,'trans')">Transmisi</a>
    <a onclick="openPrkPopup(this,'k3')">K3</a>
    <a onclick="openPrkPopup(this,'sarana')">Sarana</a>
    <div class="sb-group-title">Anggaran Operasi</div>
    <a onclick="openOperasiPrkPopup(this,'trans')">Transmisi</a>
    <a onclick="openOperasiPrkPopup(this,'k3')">K3</a>
    <a onclick="openOperasiPrkPopup(this,'tu')">TU</a>
  </aside>

<main>
  <div id="content"><div class="loading">MENGHUBUNGKAN KE SUMBER DATA...</div></div>
</main>
</div>

<footer class="{{ (($isRestricted ?? true) && !($isUnlocked ?? false)) ? 'page-blurred' : '' }}">{{ $settings['footer_text'] ?? '&copy; 2026 PT PLN (Persero) UPT Manado — Dashboard Anggaran Unit. All Rights Reserved.' }}</footer>

<div id="prkModalOverlay" class="modal-overlay" onclick="if(event.target===this) closePrkModal()">
  <div class="modal-box" style="max-width:820px;">
    <div class="modal-header"><span id="prkModalTitle">Detail PRK</span><button class="modal-close" onclick="closePrkModal()">✕</button></div>
    <div id="prkModalBody" class="modal-body"><div class="loading">Memuat...</div></div>
  </div>
</div>

<div id="prkDetailOverlay" class="modal-overlay" style="z-index:3100;" onclick="if(event.target===this) closePrkItemDetail()">
  <div class="modal-box">
    <div class="modal-header"><span id="prkDetailTitle">Detail Pekerjaan</span><button class="modal-close" onclick="closePrkItemDetail()">✕</button></div>
    <div id="prkDetailBody" class="modal-body"></div>
  </div>
</div>

<div id="loginOverlay" class="login-overlay" style="{{ (!($isRestricted ?? true) || ($isUnlocked ?? false)) ? 'display:none;' : 'display:flex;' }}">
  <div class="login-box">
    <img src="{{ asset('Logo_PLN.png') }}" alt="Logo PLN" class="login-logo-light">
    <img src="{{ asset('PLN_White.png') }}" alt="Logo PLN" class="login-logo-dark">
    <h2>Akses Terbatas: Anggaran Unit</h2>
    <p>Halaman Anggaran Unit khusus untuk personil yang berwenang. Silakan masuk untuk melanjutkan.</p>
    <div id="anggaranSessionNotice" class="login-notice" style="display:none; text-align:left; margin-bottom:16px; padding:10px 12px; border-radius:8px; font-size:12px; line-height:1.45;"></div>
    <input type="text" id="loginUser" placeholder="Username / NIP" autocomplete="username">
    <input type="password" id="loginPass" placeholder="Password" autocomplete="current-password">
    <button id="loginSubmitBtn" onclick="attemptLogin()">
      <span id="loginBtnText">Masuk</span>
      <span id="loginBtnSpinner" style="display:none;">Memverifikasi...</span>
    </button>
    <div class="login-error" id="loginError">Username atau password salah.</div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.4.1/papaparse.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
<script>
window.APP_DATA_SOURCES = @json($dataSources ?? []);
const ANGGARAN_CSV_URL = (window.APP_DATA_SOURCES && window.APP_DATA_SOURCES.anggaran_csv) ? window.APP_DATA_SOURCES.anggaran_csv : "";
const PRK_DETAIL_URL = ANGGARAN_CSV_URL ? (ANGGARAN_CSV_URL.includes('gid=') ? ANGGARAN_CSV_URL : ANGGARAN_CSV_URL + '&gid=265760831&single=true') : "";
const K3_PRK_NUMBERS = ['2026.P3BL.16.003','2026.P3BL.16.004','2026.P3BL.16.005'];
const SARANA_PRK_NUMBERS = ['2026.P3BL.18.011'];
const MONTHS_ID = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];

function parseIDR(str){
  if(!str) return 0;
  const s = str.toString().replace(/Rp/gi,'').replace(/\s/g,'').replace(/\./g,'').replace(',', '.').trim();
  const n = parseFloat(s);
  return isNaN(n) ? 0 : n;
}
function parseMilyar(str){
  if(!str) return 0;
  let s = str.toString().replace(/\s/g,'');
  if(s === '-' || s === '') return 0;
  const n = parseFloat(s.replace(',', '.'));
  return isNaN(n) ? 0 : n;
}
function fmtRp(n){ return 'Rp ' + Math.round(n).toLocaleString('id-ID'); }

let STATE = { charts:{}, mainRows:null, prkRows:null };
function destroyChart(key){ if(STATE.charts[key]){ STATE.charts[key].destroy(); delete STATE.charts[key]; } }

async function fetchCsvRows(url, timeoutMs){
  timeoutMs = timeoutMs || 3000;
  if(!url || !url.trim()) return [];
  // 1. Direct fetch
  try{
    const controller = new AbortController();
    const timer = setTimeout(()=>controller.abort(), timeoutMs);
    const res = await fetch(url, {cache:'no-store', signal: controller.signal});
    clearTimeout(timer);
    if(res.ok){
      const text = await res.text();
      return Papa.parse(text, {skipEmptyLines:false}).data;
    }
  }catch(err){
    console.warn('[Anggaran fetch] Direct fetch failed for', url, err.message, 'trying proxy fallback...');
  }

  // 2. Proxy fallback for external URLs
  if(url.startsWith('http://') || url.startsWith('https://')){
    try{
      const proxyUrl = '/api/proxy-csv?url=' + encodeURIComponent(url);
      const res = await fetch(proxyUrl);
      if(res.ok){
        const text = await res.text();
        return Papa.parse(text, {skipEmptyLines:false}).data;
      }
    }catch(err){
      console.error('[Anggaran fetch] Proxy fetch failed too:', err);
    }
  }
  throw new Error('Gagal mengambil data anggaran dari sumber');
}
function findRowIndex(rows, matchFn){ return rows.findIndex(matchFn); }

function renderComboChart(canvasId, rows, monthColIdx, realisasiColIdx, paguColIdx, rencanaColIdx){
  const startIdx = findRowIndex(rows, r => (r[monthColIdx]||'').includes('JANUARI'));
  const labels = [], realisasi = [], pagu = [], rencana = [];
  for(let i=startIdx; i<startIdx+12 && i<rows.length; i++){
    const row = rows[i];
    labels.push(MONTHS_ID[i-startIdx] || (row[monthColIdx]||''));
    realisasi.push(parseMilyar(row[realisasiColIdx]));
    pagu.push(parseMilyar(row[paguColIdx]));
    rencana.push(parseMilyar(row[rencanaColIdx]));
  }
  const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
  const tickColor = isDark ? '#94A3B8' : '#6C7A89';
  const gridColor = isDark ? 'rgba(255,255,255,0.08)' : 'rgba(0,0,0,0.06)';
  destroyChart(canvasId);
  const canvas = document.getElementById(canvasId);
  if(!canvas) return;
  STATE.charts[canvasId] = new Chart(canvas, {
    data:{ labels, datasets:[
      { type:'line', label:'Pagu Anggaran 2026', data:pagu, borderColor:'rgba(39,174,96,0.6)', backgroundColor:'rgba(39,174,96,0.25)', fill:true, tension:0, borderWidth:1, pointRadius:0, order:3, pointStyle:'rect' },
      { type:'bar', label:'Realisasi Terkontrak', data:realisasi, backgroundColor:'#E74C3C', order:2, pointStyle:'rect' },
      { type:'line', label:'Rencana Terkontrak', data:rencana, borderColor:'#E67E22', backgroundColor:'#E67E22', tension:0, borderWidth:2, pointRadius:2, order:1, pointStyle:'line' }
    ]},
    options:{
      responsive:true, maintainAspectRatio:false,
      interaction:{ mode:'index', intersect:false },
      plugins:{
        legend:{ display:true, position:'bottom', labels:{ color:tickColor, font:{size:10}, usePointStyle:true, pointStyleWidth:22 } },
        tooltip:{ usePointStyle:true, boxWidth:14, boxHeight:14 }
      },
      scales:{
        x:{ grid:{display:false}, ticks:{color:tickColor, font:{size:10}} },
        y:{ grid:{color:gridColor}, ticks:{color:tickColor, font:{size:10}}, title:{display:true, text:'Milyar Rp', color:tickColor, font:{size:9}} }
      }
    }
  });
}

function renderSkkiTable(rows, sectionTitleMatch, columnsMeta){
  const startIdx = findRowIndex(rows, r => (r[1]||'').trim().toUpperCase().startsWith(sectionTitleMatch));
  if(startIdx === -1) return '<div class="loading">Data belum tersedia.</div>';
  const bodyRows = [];
  for(let i=startIdx+2; i<rows.length; i++){
    const row = rows[i];
    if(!(row[1]||'').trim()) break;
    bodyRows.push(row);
  }
  if(!bodyRows.length) return '<div class="loading">Belum ada data tercatat.</div>';
  const theadHtml = '<tr>' + columnsMeta.map(c=>`<th>${c.label}</th>`).join('') + '</tr>';
  const tbodyHtml = bodyRows.map(row=>'<tr>' + columnsMeta.map(c=>{
    const val = (row[c.idx]||'').trim();
    return `<td${c.numeric ? ' class="num-cell"' : ''}>${val || '-'}</td>`;
  }).join('') + '</tr>').join('');
  return `<table><thead>${theadHtml}</thead><tbody>${tbodyHtml}</tbody></table>`;
}

function showAllOperasiDetail(){
  const area = document.getElementById('operasiDetailArea');
  if(!area || !STATE.mainRows) return;
  const skkoCols = [
    {label:'Nomor SKKO', idx:1}, {label:'Nilai', idx:2, numeric:true}, {label:'Tanggal Terbit', idx:3}, {label:'Jumlah PRK', idx:4}
  ];
  const sections = [
    { title:'SKKO — Transmisi', match:'SKKO-TRANS' },
    { title:'SKKO — K3L', match:'SKKO-K3L' },
    { title:'SKKO — TU', match:'SKKO-TU' }
  ];
  area.innerHTML = sections.map(cfg =>
    `<div class="cat-title">${cfg.title}</div>${renderSkkiTable(STATE.mainRows, cfg.match, skkoCols)}`
  ).join('');
}

// Rincian Anggaran Investasi — format sama seperti SKKO Anggaran Operasi (SKKI Transmisi & SKKI K3)
function renderAiRincian(rows){
  const area = document.getElementById('aiRincianArea');
  if(!area) return;
  const skkiCols = [
    {label:'Nomor SKKI', idx:1}, {label:'Nilai', idx:2, numeric:true}, {label:'Tanggal Terbit', idx:3},
    {label:'Jumlah PRK', idx:4}, {label:'Jumlah PRK GI', idx:5}
  ];
  const sections = [
    { title:'SKKI — Transmisi 2026', match:'SKKI TRANS' },
    { title:'SKKI — K3', match:'SKKI K3' },
    { title:'SKKI — Sarana', match:'SKKI SARANA' }
  ];
  area.innerHTML = sections.map(cfg =>
    `<div class="cat-title">${cfg.title}</div>${renderSkkiTable(rows, cfg.match, skkiCols)}`
  ).join('');
}

// Parser Anggaran Investasi — Nomor=B(1), Uraian header=D(3), Kontrak=H(7), Pagu=I(8)
// Sub-rincian: baris berikutnya dengan kolom D terisi (tanpa prefix "UPT MND -") DAN kolom E (index4) berisi angka
function parsePrkList(rows){
  const list = [];
  let current = null;
  let blankStreak = 0;
  rows.forEach(row=>{
    const nomor = (row[1]||'').trim();
    if(/^2026\.P3BL\./.test(nomor)){
      current = {
        nomor, uraian: (row[3]||'').trim() || '-',
        rabHpe: parseIDR(row[6]), kontrak: parseIDR(row[7]), pagu: parseIDR(row[8]),
        sisaHpe: parseIDR(row[9]), sisaKontrak: parseIDR(row[10]),
        rincian: []
      };
      list.push(current);
      blankStreak = 0;
      return;
    }
    if(!current) return;
    const namaDetail = (row[3]||'').trim();
    const progressF = (row[5]||'').trim(); // kolom F = PROGRES (status: RAB/LAKSDA/TERKONTRAK)
    if(namaDetail && progressF){
      current.rincian.push({
        nama: namaDetail.replace(/^UPT MND\s*-\s*/i, ''), progress: progressF,
        rabHpe: parseIDR(row[6]), kontrak: parseIDR(row[7]),
        penyedia: (row[11]||'').trim() || '-',   // kolom L = Penyedia Jasa
        keterangan: (row[12]||'').trim() || '-'  // kolom M = Keterangan
      });
      blankStreak = 0;
    } else if(!namaDetail && !progressF){
      // 2 baris kosong berturut-turut = akhir blok rincian PRK ini — hentikan agar data
      // lain di bawahnya (mis. tabel ringkasan lain) tidak ikut nyasar menempel ke PRK terakhir
      blankStreak++;
      if(blankStreak >= 2) current = null;
    }
  });
  return list;
}

async function openPrkPopup(el, kind){
  document.querySelectorAll('.sidebar a').forEach(a=>a.classList.remove('active'));
  el.classList.add('active');
  const overlay = document.getElementById('prkModalOverlay');
  const body = document.getElementById('prkModalBody');
  const titleMap = { k3:'Anggaran Investasi — K3', sarana:'Anggaran Investasi — Sarana', trans:'Anggaran Investasi — Transmisi' };
  document.getElementById('prkModalTitle').textContent = titleMap[kind] || titleMap.trans;
  body.innerHTML = '<div class="loading">Memuat data PRK...</div>';
  overlay.style.display = 'flex';

  try{
    if(!STATE.prkRows) STATE.prkRows = await fetchCsvRows(PRK_DETAIL_URL);
    const allPrk = parsePrkList(STATE.prkRows);
    let filtered;
    if(kind === 'k3') filtered = allPrk.filter(p => K3_PRK_NUMBERS.includes(p.nomor));
    else if(kind === 'sarana') filtered = allPrk.filter(p => SARANA_PRK_NUMBERS.includes(p.nomor));
    else filtered = allPrk.filter(p => !K3_PRK_NUMBERS.includes(p.nomor) && !SARANA_PRK_NUMBERS.includes(p.nomor));

    if(!filtered.length){ body.innerHTML = '<div class="loading">Tidak ada data PRK untuk kategori ini.</div>'; return; }
    body.innerHTML = renderOperasiPrkTable(filtered);
  }catch(e){
    body.innerHTML = '<div class="err">Gagal memuat data PRK — ' + e.message + '</div>';
  }
}
function closePrkModal(){ document.getElementById('prkModalOverlay').style.display = 'none'; }

// ===== Popup progress untuk card ringkasan (Proses RAB & TOR / Proses Rendan & Laksda / Nilai Terkontrak) =====
const PROGRESS_MATCH = { rab:['RAB'], rendan:['LAKSDA','RENDAN'], terkontrak:['TERKONTRAK'] };
const PROGRESS_TITLE = { rab:'Proses RAB & TOR', rendan:'Proses Rendan & Laksda', terkontrak:'Nilai Terkontrak' };

function buildProgressList(rows, uraianIdx, progressIdx, valueIdx, matchList, nomorIdx, nomorPattern){
  const items = [];
  let started = !nomorPattern; // kalau tidak diberi pola nomor, anggap semua baris valid dari awal
  let currentPrk = null;
  rows.forEach(row=>{
    const nomorCell = (row[nomorIdx]||'').trim();
    if(nomorPattern && nomorPattern.test(nomorCell)){
      started = true;
      // Baris ini adalah HEADER PRK (bukan item pekerjaan) — simpan sebagai induk grup, lewati sebagai item.
      currentPrk = { nomor: nomorCell, uraian: (row[uraianIdx]||'').trim() || '-' };
      return;
    }
    if(!started) return; // lewati baris di atas tabel PRK asli (mis. label ringkasan yang kebetulan cocok kolom)
    const uraian = (row[uraianIdx]||'').trim();
    const progress = (row[progressIdx]||'').trim();
    if(!uraian || !progress) return;
    if(!matchList.some(m => progress.toUpperCase().includes(m))) return;
    items.push({
      uraian, progress, value: parseIDR(row[valueIdx]),
      prkNomor: currentPrk ? currentPrk.nomor : '-', prkUraian: currentPrk ? currentPrk.uraian : '-'
    });
  });
  return items;
}

function renderProgressModal(sectionLabel, cardType, items){
  document.getElementById('prkModalTitle').textContent = `${sectionLabel} — ${PROGRESS_TITLE[cardType]}`;
  const body = document.getElementById('prkModalBody');
  const valueLabel = cardType === 'terkontrak' ? 'Kontrak' : 'RAB / HPE';
  if(!items.length){
    body.innerHTML = '<div class="loading">Tidak ada pekerjaan dengan status ini.</div>';
  } else {
    // Kelompokkan item berdasarkan PRK induknya, supaya jelas masing-masing masuk Judul PRK yang mana.
    const groups = [];
    const groupMap = {};
    items.forEach(it=>{
      const key = it.prkNomor + '|' + it.prkUraian;
      if(!groupMap[key]){ groupMap[key] = { nomor: it.prkNomor, uraian: it.prkUraian, items: [] }; groups.push(groupMap[key]); }
      groupMap[key].items.push(it);
    });
    const bodyHtml = groups.map(g=>{
      const rowsHtml = g.items.map(it=>`<tr>
          <td class="kk-uraian-cell">${it.uraian}</td>
          <td class="kk-center">${progressBadge(it.progress)}</td>
          <td class="num-cell">${fmtRp(it.value)}</td>
        </tr>`).join('');
      return `<tr class="prk-group-row"><td colspan="3"><b>${g.nomor}</b> — ${g.uraian}</td></tr>${rowsHtml}`;
    }).join('');
    body.innerHTML = `<table><thead><tr><th>Uraian Pekerjaan</th><th>Progress</th><th>${valueLabel}</th></tr></thead><tbody>${bodyHtml}</tbody></table>`;
  }
  document.getElementById('prkModalOverlay').style.display = 'flex';
}

async function openProgressPopup(section, cardType){
  const overlay = document.getElementById('prkModalOverlay');
  const body = document.getElementById('prkModalBody');
  document.getElementById('prkModalTitle').textContent = (section==='ai' ? 'Anggaran Investasi' : 'Anggaran Operasi') + ' — ' + PROGRESS_TITLE[cardType];
  body.innerHTML = '<div class="loading">Memuat data...</div>';
  overlay.style.display = 'flex';

  try{
    if(section === 'ai'){
      // Sheet AI Murni (PRK Investasi): Uraian=D(3), Progress=F(5), RAB/HPE=G(6), Kontrak=H(7)
      if(!STATE.prkRows) STATE.prkRows = await fetchCsvRows(PRK_DETAIL_URL);
      const valueIdx = cardType === 'terkontrak' ? 7 : 6; // Kontrak vs RAB/HPE (belum ada nilai kontrak utk RAB/Rendan)
      const items = buildProgressList(STATE.prkRows, 3, 5, valueIdx, PROGRESS_MATCH[cardType], 1, /^2026\.P3BL\./);
      renderProgressModal('Anggaran Investasi', cardType, items);
    } else {
      // 3 sheet Operasi (Trans/K3/TU) — diproses TERPISAH (gate "started" direset per sheet), baru digabung hasilnya
      // Uraian=E(4), Progress=D(3), Nilai/HPE=F(5), Kontrak=J(9)
      const kinds = ['trans','k3','tu'];
      for(const k of kinds){ if(!STATE.operasiPrkRows[k]) STATE.operasiPrkRows[k] = await fetchCsvRows(OPERASI_PRK_URLS[k]); }
      const opNomorPattern = /^\d{3,4}\.\d{2}\.\d{2}\.\d{2}\.\d{2}\.\d{3}$/;
      const valueIdx = cardType === 'terkontrak' ? 9 : 5; // Kontrak vs Nilai/HPE (belum ada nilai kontrak utk RAB/Rendan)
      const items = kinds.flatMap(k => buildProgressList(STATE.operasiPrkRows[k], 4, 3, valueIdx, PROGRESS_MATCH[cardType], 1, opNomorPattern));
      renderProgressModal('Anggaran Operasi', cardType, items);
    }
  }catch(e){
    body.innerHTML = '<div class="err">Gagal memuat data — ' + e.message + '</div>';
  }
}

// ===== Popup PRK untuk Anggaran Operasi (Transmisi/K3/TU) — format sama dengan popup Investasi =====
const OPERASI_PRK_URLS = {
  trans: "https://docs.google.com/spreadsheets/d/e/2PACX-1vRx2dxv5UCa5R84BkO9cOzfUfXZ1Yr_fBTDfC_Bxn5fvXpsk6Gt2QrrAWdO_MrsIA/pub?gid=1900200209&single=true&output=csv",
  k3: "https://docs.google.com/spreadsheets/d/e/2PACX-1vRx2dxv5UCa5R84BkO9cOzfUfXZ1Yr_fBTDfC_Bxn5fvXpsk6Gt2QrrAWdO_MrsIA/pub?gid=50610195&single=true&output=csv",
  tu: "https://docs.google.com/spreadsheets/d/e/2PACX-1vRx2dxv5UCa5R84BkO9cOzfUfXZ1Yr_fBTDfC_Bxn5fvXpsk6Gt2QrrAWdO_MrsIA/pub?gid=1577461716&single=true&output=csv"
};
STATE.operasiPrkRows = STATE.operasiPrkRows || {};

// Parser Anggaran Operasi — Nomor=B(1), Uraian header=E(4), Kontrak=J(9), Pagu=M(12), Sisa Pagu=O(14)
// Setiap baris PRK bisa punya beberapa SUB-RINCIAN pekerjaan di baris-baris berikutnya (sebelum PRK berikutnya):
// baris rincian dikenali dari kolom E yang TIDAK diawali "UPT MND -" DAN kolom F (Nilai/HPE) berisi angka.
function parseOperasiPrkList(rows){
  const list = [];
  let current = null;
  let blankStreak = 0;
  rows.forEach(row=>{
    const nomor = (row[1]||'').trim();
    if(/^\d{3,4}\.\d{2}\.\d{2}\.\d{2}\.\d{2}\.\d{3}$/.test(nomor)){
      current = {
        nomor, uraian: (row[4]||'').trim() || '-',
        rabHpe: parseIDR(row[5]), kontrak: parseIDR(row[9]), pagu: parseIDR(row[12]), sisaKontrak: parseIDR(row[14]),
        rincian: []
      };
      list.push(current);
      blankStreak = 0;
      return;
    }
    if(!current) return;
    const namaDetail = (row[4]||'').trim();
    const nilaiF = parseIDR(row[5]);
    if(namaDetail && !/^UPT MND\s*-/i.test(namaDetail) && nilaiF !== null && nilaiF !== 0){
      current.rincian.push({
        nama: namaDetail, nilaiHpe: (row[5]||'').trim() || '-', rabHpe: nilaiF,
        progress: (row[3]||'').trim(),
        kontrak: parseIDR(row[9]), tglAwal: (row[10]||'').trim() || '-', tglAkhir: (row[11]||'').trim() || '-'
      });
      blankStreak = 0;
    } else if(!namaDetail){
      // 2 baris kosong berturut-turut = akhir blok rincian PRK ini — hentikan agar data
      // lain di bawahnya tidak ikut nyasar menempel ke PRK terakhir
      blankStreak++;
      if(blankStreak >= 2) current = null;
    }
  });
  return list;
}

// Scale bar warna: 0% merah -> 50% oranye -> 100% hijau, label persen di dalam bar
// Aksen warna kolom Progress: TERKONTRAK=merah, LAKSDA=kuning, RAB=biru, RENDAN=hijau
function progressBadge(progress){
  const p = (progress||'').toUpperCase();
  let cls = 'gray';
  if(p.includes('TERKONTRAK')) cls = 'red';
  else if(p.includes('LAKSDA')) cls = 'yellow';
  else if(p.includes('RAB')) cls = 'blue';
  else if(p.includes('RENDAN')) cls = 'green';
  return `<span class="progress-badge ${cls}">${progress}</span>`;
}

function buildPctBar(kontrak, pagu){
  const pct = pagu > 0 ? Math.min(100, Math.round(kontrak/pagu*100)) : 0;
  const lerp = (a,b,t)=> Math.round(a + (b-a)*t);
  const stops = pct <= 50
    ? { r:lerp(231,230,pct/50), g:lerp(76,126,pct/50), b:lerp(60,34,pct/50) }   // merah(#E74C3C) -> oranye(#E67E22)
    : { r:lerp(230,39,(pct-50)/50), g:lerp(126,174,(pct-50)/50), b:lerp(34,96,(pct-50)/50) }; // oranye -> hijau(#27AE60)
  const color = `rgb(${stops.r},${stops.g},${stops.b})`;
  return `<div class="pct-bar-track"><div class="pct-bar-fill" style="width:${pct}%; background:${color};">${pct > 12 ? pct+'%' : ''}</div>${pct <= 12 ? `<span class="pct-bar-label-outside">${pct}%</span>` : ''}</div>`;
}

STATE.currentPrkList = [];
STATE.paguMode = 'terkontrak'; // 'terkontrak' atau 'terkontrak_rab'

// Menghitung nilai "terpakai" per PRK sesuai mode yang dipilih:
// - 'terkontrak': hanya nilai Kontrak yang sudah pasti (RAB/Rendan/Laksda dianggap belum terpakai)
// - 'terkontrak_rab': Kontrak + RAB/HPE digabung (estimasi konservatif termasuk yang masih tahap RAB/HPE)
function computeTerpakai(p){
  if(STATE.paguMode !== 'terkontrak_rab') return p.kontrak || 0;
  // Mode gabungan: hitung PER RINCIAN PEKERJAAN (bukan cuma level PRK) — supaya PRK dengan
  // sub-pekerjaan CAMPURAN (sebagian sudah Terkontrak, sebagian masih RAB/Rendan/Laksda) tidak
  // salah hitung. Tiap rincian: kalau statusnya TERKONTRAK pakai nilai Kontrak-nya, kalau belum
  // pakai nilai RAB/HPE-nya — lalu dijumlahkan semua.
  if(p.rincian && p.rincian.length){
    return p.rincian.reduce((sum, r) => {
      const isTerkontrak = (r.progress||'').toUpperCase().includes('TERKONTRAK');
      const val = isTerkontrak ? (r.kontrak||0) : (r.rabHpe||0);
      return sum + (val||0);
    }, 0);
  }
  // Fallback kalau rincian tidak tersedia: pakai aturan sederhana level PRK.
  if(p.kontrak && p.kontrak > 0) return p.kontrak;
  return p.rabHpe || 0;
}

function renderPrkTableRows(){
  return STATE.currentPrkList.map((p,i)=>{
    const terpakai = computeTerpakai(p);
    const sisaPagu = (p.pagu || 0) - terpakai;
    return `<tr class="prk-row" data-idx="${i}" data-uraian="${p.uraian.toLowerCase()}" onclick="openPrkItemDetail(${i})">
      <td>${p.nomor}</td><td class="kk-uraian-cell">${p.uraian}</td>
      <td>${buildPctBar(terpakai, p.pagu)}</td>
      <td class="num-cell">${fmtRp(p.pagu)}</td>
      <td class="num-cell">${fmtRp(terpakai)}</td>
      <td class="num-cell">${fmtRp(sisaPagu)}</td>
    </tr>`;
  }).join('');
}

function updatePaguMode(sel){
  STATE.paguMode = sel.value;
  const tbody = document.querySelector('#prkDataTable tbody');
  if(tbody) tbody.innerHTML = renderPrkTableRows();
}

function renderOperasiPrkTable(list){
  STATE.currentPrkList = list;
  const hasRabHpe = list.some(p => p.rabHpe !== null && p.rabHpe !== undefined);
  return `
    <div class="prk-search-wrap">
      <input type="text" id="prkSearchInput" placeholder="Cari nama pekerjaan..." onkeydown="if(event.key==='Enter') cycleSearch('prkDataTable','prkSearchInput');">
      <button onclick="cycleSearch('prkDataTable','prkSearchInput')">🔍 Cari</button>
    </div>
    ${hasRabHpe ? `<div class="prk-mode-wrap">
      <label for="paguModeSelect">Hitung Pagu Terpakai Berdasarkan:</label>
      <select id="paguModeSelect" onchange="updatePaguMode(this)">
        <option value="terkontrak">Terkontrak</option>
        <option value="terkontrak_rab">Terkontrak + RAB/HPE</option>
      </select>
    </div>` : ''}
    <table id="prkDataTable"><thead><tr>
      <th>Nomor</th><th>Uraian</th><th>% Terpakai/Pagu</th><th>Pagu</th><th>Terpakai</th><th>Sisa Pagu</th>
    </tr></thead><tbody>${renderPrkTableRows()}</tbody></table>`;
}

// Pencarian generik: bisa dipakai untuk tabel manapun, siklus ke baris cocok berikutnya
// setiap kali Enter/tombol Cari ditekan ulang dengan kata kunci yang sama.
STATE.searchState = {};
function cycleSearch(tableId, inputId){
  const input = document.getElementById(inputId);
  if(!input) return;
  const term = (input.value || '').trim().toLowerCase();
  const rows = Array.from(document.querySelectorAll('#'+tableId+' tbody tr'));
  rows.forEach(tr=>tr.classList.remove('prk-highlight'));
  if(!term){ delete STATE.searchState[tableId]; return; }

  if(!STATE.searchState[tableId] || STATE.searchState[tableId].term !== term){
    STATE.searchState[tableId] = { term, lastIdx: -1 };
  }
  const st = STATE.searchState[tableId];
  const matches = rows.filter(tr => (tr.dataset.uraian||'').includes(term));
  if(!matches.length) return;
  st.lastIdx = (st.lastIdx + 1) % matches.length; // maju ke baris cocok berikutnya, berputar ke awal lagi kalau sudah habis
  const match = matches[st.lastIdx];
  match.classList.add('prk-highlight');
  match.scrollIntoView({behavior:'smooth', block:'center'});
}

// Popup detail per PRK: kolom yang ditampilkan menyesuaikan struktur data
// (Investasi: Progress/Penyedia Jasa/Keterangan — Operasi: Nilai HPE/Kontrak/Tgl Awal/Tgl Akhir)
function openPrkItemDetail(idx){
  const p = STATE.currentPrkList[idx];
  if(!p) return;
  const overlay = document.getElementById('prkDetailOverlay');
  document.getElementById('prkDetailTitle').textContent = p.nomor;
  if(!p.rincian || !p.rincian.length){
    document.getElementById('prkDetailBody').innerHTML = '<div class="loading">Tidak ada rincian pekerjaan untuk PRK ini.</div>';
  } else {
    const isInvestasiStyle = p.rincian[0].progress !== undefined;
    let theadHtml, rowsHtml;
    if(isInvestasiStyle){
      theadHtml = '<th>Nama Pekerjaan</th><th>Progress</th><th>Penyedia Jasa</th><th>Keterangan</th>';
      rowsHtml = p.rincian.map(r=>`<tr data-uraian="${r.nama.toLowerCase()}">
          <td class="kk-uraian-cell">${r.nama}</td>
          <td class="kk-center">${progressBadge(r.progress)}</td>
          <td>${r.penyedia}</td>
          <td>${r.keterangan}</td>
        </tr>`).join('');
    } else {
      theadHtml = '<th>Nama Pekerjaan</th><th>Nilai / HPE</th><th>Kontrak</th><th>Tgl Awal Kontrak</th><th>Tgl Akhir Kontrak</th>';
      rowsHtml = p.rincian.map(r=>`<tr data-uraian="${r.nama.toLowerCase()}">
          <td class="kk-uraian-cell">${r.nama}</td>
          <td class="num-cell">${r.nilaiHpe}</td>
          <td class="num-cell">${fmtRp(r.kontrak)}</td>
          <td class="kk-center">${r.tglAwal}</td>
          <td class="kk-center">${r.tglAkhir}</td>
        </tr>`).join('');
    }
    document.getElementById('prkDetailBody').innerHTML = `
      <div class="prk-search-wrap">
        <input type="text" id="prkDetailSearchInput" placeholder="Cari uraian pekerjaan..." onkeydown="if(event.key==='Enter') cycleSearch('prkDetailTable','prkDetailSearchInput');">
        <button onclick="cycleSearch('prkDetailTable','prkDetailSearchInput')">🔍 Cari</button>
      </div>
      <table id="prkDetailTable"><thead><tr>${theadHtml}</tr></thead><tbody>${rowsHtml}</tbody></table>`;
  }
  overlay.style.display = 'flex';
}
function closePrkItemDetail(){ document.getElementById('prkDetailOverlay').style.display = 'none'; }

async function openOperasiPrkPopup(el, kind){
  document.querySelectorAll('.sidebar a').forEach(a=>a.classList.remove('active'));
  el.classList.add('active');
  const overlay = document.getElementById('prkModalOverlay');
  const body = document.getElementById('prkModalBody');
  const titleMap = { trans:'Anggaran Operasi — Transmisi', k3:'Anggaran Operasi — K3', tu:'Anggaran Operasi — TU' };
  document.getElementById('prkModalTitle').textContent = titleMap[kind];
  body.innerHTML = '<div class="loading">Memuat data...</div>';
  overlay.style.display = 'flex';

  try{
    if(!STATE.operasiPrkRows[kind]) STATE.operasiPrkRows[kind] = await fetchCsvRows(OPERASI_PRK_URLS[kind]);
    const list = parseOperasiPrkList(STATE.operasiPrkRows[kind]);
    if(!list.length){ body.innerHTML = '<div class="loading">Tidak ada data untuk kategori ini.</div>'; return; }
    body.innerHTML = renderOperasiPrkTable(list);
  }catch(e){
    body.innerHTML = '<div class="err">Gagal memuat data — ' + e.message + '</div>';
  }
}

function getAiRincianHtml(rows){
  const skkiCols = [
    {label:'Nomor SKKI', idx:1}, {label:'Nilai', idx:2, numeric:true}, {label:'Tanggal Terbit', idx:3},
    {label:'Jumlah PRK', idx:4}, {label:'Jumlah PRK GI', idx:5}
  ];
  const sections = [
    { title:'SKKI — Transmisi 2026', match:'SKKI TRANS' },
    { title:'SKKI — K3', match:'SKKI K3' },
    { title:'SKKI — Sarana', match:'SKKI SARANA' }
  ];
  return sections.map(cfg =>
    `<div class="cat-title">${cfg.title}</div>${renderSkkiTable(rows, cfg.match, skkiCols)}`
  ).join('');
}
function getOperasiDetailHtml(rows){
  const skkoCols = [
    {label:'Nomor SKKO', idx:1}, {label:'Nilai', idx:2, numeric:true}, {label:'Tanggal Terbit', idx:3}, {label:'Jumlah PRK', idx:4}
  ];
  const sections = [
    { title:'SKKO — Transmisi', match:'SKKO-TRANS' },
    { title:'SKKO — K3L', match:'SKKO-K3L' },
    { title:'SKKO — TU', match:'SKKO-TU' }
  ];
  return sections.map(cfg =>
    `<div class="cat-title">${cfg.title}</div>${renderSkkiTable(rows, cfg.match, skkoCols)}`
  ).join('');
}

async function loadAnggaran(){
  const content = document.getElementById('content');
  if(!ANGGARAN_CSV_URL || !ANGGARAN_CSV_URL.trim()){
    content.innerHTML = `
      <div style="background:var(--bg-card); border:1px solid var(--border-color); border-radius:12px; padding:60px 24px; text-align:center; max-width:680px; margin:40px auto; box-shadow:var(--card-shadow);">
        <div style="font-size:48px; margin-bottom:14px; opacity:0.8;">💰</div>
        <h3 style="font-size:18px; font-weight:800; color:var(--text-main); margin-bottom:8px;">Sumber Data Anggaran Belum Dikonfigurasi</h3>
        <p style="font-size:13.5px; color:var(--text-muted); line-height:1.6; margin-bottom:20px;">
          Sumber data CSV untuk modul Anggaran Unit (Investasi &amp; Operasi) belum diatur atau dinonaktifkan di menu <b>Sumber Data</b> pada Panel Admin. Data penyerapan anggaran tidak ditampilkan.
        </p>
      </div>`;
    return;
  }
  try{
    const rows = await fetchCsvRows(ANGGARAN_CSV_URL);
    STATE.mainRows = rows;

    const sumRowIdx = findRowIndex(rows, r => (r[1]||'').trim() === 'PAGU ANGGARAN');
    const sumRow = (sumRowIdx !== -1 && rows[sumRowIdx+1]) ? rows[sumRowIdx+1] : [];
    const aoSummary = { pagu: parseIDR(sumRow[1]), rab: parseIDR(sumRow[3]), rendan: parseIDR(sumRow[5]), terkontrak: parseIDR(sumRow[7]) };
    const aiSummary = { pagu: parseIDR(sumRow[10]), rab: parseIDR(sumRow[12]), rendan: parseIDR(sumRow[14]), terkontrak: parseIDR(sumRow[16]) };

    const aiRincianHtml = getAiRincianHtml(rows);
    const operasiDetailHtml = getOperasiDetailHtml(rows);

    content.innerHTML = `
      <div class="two-col">
        <div class="section-block" id="ai-utama">
          <div class="module-title">Anggaran Investasi</div>
          <div class="cat-title">Ringkasan</div>
          <div class="summary-grid">
            <div class="summary-card accent-green"><div class="lbl">Pagu Anggaran</div><div class="val">${fmtRp(aiSummary.pagu)}</div></div>
            <div class="summary-card accent-blue clickable" onclick="openProgressPopup('ai','rab')"><div class="lbl">Proses RAB &amp; TOR</div><div class="val">${fmtRp(aiSummary.rab)}</div></div>
            <div class="summary-card accent-yellow clickable" onclick="openProgressPopup('ai','rendan')"><div class="lbl">Proses Rendan &amp; Laksda</div><div class="val">${fmtRp(aiSummary.rendan)}</div></div>
            <div class="summary-card accent-red clickable" onclick="openProgressPopup('ai','terkontrak')"><div class="lbl">Nilai Terkontrak</div><div class="val">${fmtRp(aiSummary.terkontrak)}</div></div>
          </div>
          <div class="cat-title">Rekap Grafik Bulanan</div>
          <div class="chart-wrap"><canvas id="chartAI"></canvas></div>
          <div id="aiRincianArea">${aiRincianHtml}</div>
          <div class="detail-placeholder">Klik <b>Transmisi</b> atau <b>K3</b> di menu kiri (Anggaran Investasi) untuk melihat rincian PRK.</div>
        </div>

        <div class="section-block" id="ao-utama">
          <div class="module-title">Anggaran Operasi</div>
          <div class="cat-title">Ringkasan</div>
          <div class="summary-grid">
            <div class="summary-card accent-green"><div class="lbl">Pagu Anggaran</div><div class="val">${fmtRp(aoSummary.pagu)}</div></div>
            <div class="summary-card accent-blue clickable" onclick="openProgressPopup('ao','rab')"><div class="lbl">Proses RAB &amp; TOR</div><div class="val">${fmtRp(aoSummary.rab)}</div></div>
            <div class="summary-card accent-yellow clickable" onclick="openProgressPopup('ao','rendan')"><div class="lbl">Proses Rendan &amp; Laksda</div><div class="val">${fmtRp(aoSummary.rendan)}</div></div>
            <div class="summary-card accent-red clickable" onclick="openProgressPopup('ao','terkontrak')"><div class="lbl">Nilai Terkontrak</div><div class="val">${fmtRp(aoSummary.terkontrak)}</div></div>
          </div>
          <div class="cat-title">Rekap Grafik Bulanan</div>
          <div class="chart-wrap"><canvas id="chartAO"></canvas></div>
          <div id="operasiDetailArea">${operasiDetailHtml}</div>
        </div>
      </div>`;

    renderComboChart('chartAI', rows, 10, 11, 12, 13);
    renderComboChart('chartAO', rows, 1, 2, 3, 4);
  }catch(e){
    content.innerHTML = '<div class="err">Gagal memuat data anggaran — ' + e.message + '</div>';
  }
}

// Hero scroll shrink
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

// Jam live untuk badge hero (Format seragam KKU)
const DAY_NAMES_EN = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
const MONTH_NAMES_EN = ['January','February','March','April','May','June','July','August','September','October','November','December'];
function tickHeroClock(){
  const el = document.getElementById('heroLiveClock') || document.getElementById('lastUpdate');
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

loadAnggaran();

function applyThemeUI(theme){
  document.getElementById('themeIcon').textContent = theme === 'dark' ? '☀️' : '🌙';
  document.getElementById('themeText').textContent = theme === 'dark' ? 'Light Mode' : 'Dark Mode';
}
function toggleTheme(){
  const html = document.documentElement;
  const current = html.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
  const next = current === 'dark' ? 'light' : 'dark';
  html.setAttribute('data-theme', next);
  localStorage.setItem('theme', next);
  applyThemeUI(next);
  if(STATE.mainRows){ renderComboChart('chartAI', STATE.mainRows, 10, 11, 12, 13); renderComboChart('chartAO', STATE.mainRows, 1, 2, 3, 4); }
}
(function initTheme(){
  const saved = localStorage.getItem('theme') || 'light';
  document.documentElement.setAttribute('data-theme', saved);
  applyThemeUI(saved);
})();



// Sidebar auto-hide: muncul saat mouse dekat tepi kiri layar, sembunyi saat mouse menjauh
(function(){
  const sidebar = document.getElementById('mainSidebar');
  const trigger = document.getElementById('sidebarTrigger');
  if(!sidebar || !trigger) return;
  let hideTimer = null;
  function show(){ clearTimeout(hideTimer); sidebar.classList.add('sidebar-visible'); }
  function scheduleHide(){ hideTimer = setTimeout(()=> sidebar.classList.remove('sidebar-visible'), 250); }
  trigger.addEventListener('mouseenter', show);
  sidebar.addEventListener('mouseenter', show);
  trigger.addEventListener('mouseleave', scheduleHide);
  sidebar.addEventListener('mouseleave', scheduleHide);
})();
</script>

<script>
document.addEventListener('click', (e)=>{
  const a = e.target.closest('a');
  if(!a) return;
  const href = a.getAttribute('href') || '';
  if(href.endsWith('.html') || href.includes('.html#')){
    e.preventDefault();
    document.body.classList.add('page-fade-out');
    setTimeout(()=>{ window.location.href = href; }, 170);
  }
});
</script>

<script>
// ===== Verifikasi Akses Terenkripsi & Auto-Logout Watcher =====
const PAGE_SLUG = 'anggaran';
const VERIFY_URL = "{{ route('page-access.verify') }}";
const LOCK_URL = "{{ route('page-access.lock') }}";
const PING_URL = "{{ route('page-access.ping') }}";
const CSRF_TOKEN = "{{ csrf_token() }}";
const isPageRestricted = {{ ($isRestricted ?? true) ? 'true' : 'false' }};
let isPageUnlocked = {{ ($isUnlocked ?? false) ? 'true' : 'false' }};
const SERVER_LOCKED_REASON = "{{ $lockedReason ?? '' }}";

// Waktu Timeout:
// 1. Tiap 3 Menit AFK (180.000 ms)
// 2. Tiap 10 Menit Tidak Dibuka Halamannya (600.000 ms)
const urlParams = new URLSearchParams(window.location.search);
const AFK_LIMIT_MS = parseInt(urlParams.get('test_afk_ms'), 10) || (3 * 60 * 1000);
const UNOPENED_LIMIT_MS = parseInt(urlParams.get('test_unopened_ms'), 10) || (10 * 60 * 1000);
const PING_INTERVAL_MS = 10 * 1000;

function renderAnggaranLockNotice(reason) {
  const noticeEl = document.getElementById('anggaranSessionNotice');
  if (!noticeEl) return;
  if (reason === 'afk_3m') {
    noticeEl.style.display = 'block';
    noticeEl.style.background = 'rgba(243, 156, 18, 0.12)';
    noticeEl.style.border = '1px solid rgba(243, 156, 18, 0.4)';
    noticeEl.style.color = '#D68910';
    noticeEl.innerHTML = '🔒 <strong>Sesi Berakhir Otomatis (AFK):</strong><br>Tidak ada aktivitas selama 3 menit pada halaman ini. Akses telah dikunci otomatis demi keamanan.';
  } else if (reason === 'unopened_10m') {
    noticeEl.style.display = 'block';
    noticeEl.style.background = 'rgba(243, 156, 18, 0.12)';
    noticeEl.style.border = '1px solid rgba(243, 156, 18, 0.4)';
    noticeEl.style.color = '#D68910';
    noticeEl.innerHTML = '🔒 <strong>Sesi Berakhir Otomatis:</strong><br>Halaman tidak dibuka selama lebih dari 10 menit. Akses telah dikunci otomatis demi keamanan.';
  } else if (reason === 'account_deactivated') {
    noticeEl.style.display = 'block';
    noticeEl.style.background = 'rgba(231, 76, 60, 0.12)';
    noticeEl.style.border = '1px solid rgba(231, 76, 60, 0.4)';
    noticeEl.style.color = '#E74C3C';
    noticeEl.innerHTML = '🚫 <strong>Akun Telah Dinonaktifkan:</strong><br>Akun personil yang Anda gunakan sebelumnya telah dinonaktifkan atau hak aksesnya dicabut oleh administrator. Sesi akses halaman ini langsung diakhiri demi keamanan.';
  } else if (reason === 'manual') {
    noticeEl.style.display = 'block';
    noticeEl.style.background = 'rgba(0, 82, 156, 0.1)';
    noticeEl.style.border = '1px solid rgba(0, 82, 156, 0.3)';
    noticeEl.style.color = 'var(--pln-blue, #00529C)';
    noticeEl.innerHTML = '🔒 <strong>Akses Dikunci:</strong><br>Akses halaman ini telah berhasil dikunci kembali. Silakan login untuk membuka.';
  } else {
    noticeEl.style.display = 'none';
  }
}

function lockPage(reason = 'manual'){
  if(!isPageRestricted) return;
  if(typeof window !== 'undefined') window.scrollTo(0, 0);
  document.body.style.overflow = 'hidden';
  const topbar = document.getElementById('topbar');
  if(topbar) topbar.classList.add('topbar-locked');
  document.querySelector('.page-layout')?.classList.add('page-blurred');
  document.querySelector('footer')?.classList.add('page-blurred');
  const overlay = document.getElementById('loginOverlay');
  if(overlay) overlay.style.display = 'flex';
  const lockBtn = document.getElementById('btnLockAnggaran');
  if(lockBtn) lockBtn.style.display = 'none';
  isPageUnlocked = false;
  sessionStorage.removeItem('anggaranLoggedIn');
  renderAnggaranLockNotice(reason);
  if(typeof updateTopbarHeight === 'function') {
    updateTopbarHeight();
    setTimeout(updateTopbarHeight, 150);
    setTimeout(updateTopbarHeight, 350);
  }
}

function unlockPage(){
  document.body.style.overflow = '';
  sessionStorage.removeItem('upt_lock_reason_anggaran');
  const topbar = document.getElementById('topbar');
  if(topbar) topbar.classList.remove('topbar-locked');
  document.querySelector('.page-layout')?.classList.remove('page-blurred');
  document.querySelector('footer')?.classList.remove('page-blurred');
  const overlay = document.getElementById('loginOverlay');
  if(overlay) overlay.style.display = 'none';
  const lockBtn = document.getElementById('btnLockAnggaran');
  if(lockBtn && isPageRestricted) lockBtn.style.display = 'inline-flex';
  isPageUnlocked = true;
  sessionStorage.setItem('anggaranLoggedIn', '1');
  const noticeEl = document.getElementById('anggaranSessionNotice');
  if(noticeEl) noticeEl.style.display = 'none';
  if(typeof updateTopbarHeight === 'function') {
    updateTopbarHeight();
    setTimeout(updateTopbarHeight, 150);
    setTimeout(updateTopbarHeight, 350);
  }
}

let isLockingAnggaran = false;
async function lockAnggaran(reason = 'manual'){
  if(isLockingAnggaran) return;
  isLockingAnggaran = true;

  sessionStorage.setItem('upt_lock_reason_anggaran', reason);
  sessionStorage.removeItem('anggaranLoggedIn');
  localStorage.removeItem('upt_last_active_anggaran');
  localStorage.removeItem('upt_last_opened_anggaran');

  lockPage(reason);

  try{
    await fetch(LOCK_URL, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': CSRF_TOKEN,
        'Accept': 'application/json'
      },
      body: JSON.stringify({ page_slug: PAGE_SLUG, reason: reason })
    });
  }catch(e){}

  isLockingAnggaran = false;
}

async function attemptLogin(){
  const user = document.getElementById('loginUser').value.trim();
  const pass = document.getElementById('loginPass').value;
  const errEl = document.getElementById('loginError');
  const btn = document.getElementById('loginSubmitBtn');
  const btnText = document.getElementById('loginBtnText');
  const btnSpin = document.getElementById('loginBtnSpinner');

  if(!user || !pass){
    errEl.textContent = 'Harap isi username dan password.';
    errEl.style.display = 'block';
    return;
  }

  btn.disabled = true;
  if(btnText) btnText.style.display = 'none';
  if(btnSpin) btnSpin.style.display = 'inline';
  errEl.style.display = 'none';

  try{
    const res = await fetch(VERIFY_URL, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': CSRF_TOKEN,
        'Accept': 'application/json'
      },
      body: JSON.stringify({ page_slug: PAGE_SLUG, username: user, password: pass })
    });

    const data = await res.json();
    if(res.ok && data.success){
      sessionStorage.removeItem('upt_lock_reason_anggaran');
      sessionStorage.setItem('anggaranLoggedIn', '1');
      const now = Date.now();
      localStorage.setItem('upt_last_active_anggaran', now.toString());
      localStorage.setItem('upt_last_opened_anggaran', now.toString());
      unlockPage();
      errEl.style.display = 'none';
      startAnggaranWatchers();
    } else {
      errEl.textContent = data.message || 'Username atau password salah.';
      errEl.style.display = 'block';
    }
  }catch(err){
    errEl.textContent = 'Gagal menghubungi server untuk autentikasi.';
    errEl.style.display = 'block';
  }finally{
    btn.disabled = false;
    if(btnText) btnText.style.display = 'inline';
    if(btnSpin) btnSpin.style.display = 'none';
  }
}

document.getElementById('loginPass')?.addEventListener('keydown', (e)=>{ if(e.key === 'Enter') attemptLogin(); });
document.getElementById('loginUser')?.addEventListener('keydown', (e)=>{ if(e.key === 'Enter') attemptLogin(); });

if('scrollRestoration' in history) history.scrollRestoration = 'manual';

// ===== WATCHER 3 MENIT AFK & 10 MENIT TIDAK DIBUKA =====
let anggaranWatcherStarted = false;
let lastServerPingAnggaran = 0;
async function checkServerAccessAnggaran(force = false) {
  const t = Date.now();
  if (!force && (t - lastServerPingAnggaran < 3000)) return;
  lastServerPingAnggaran = t;

  try {
    const res = await fetch(PING_URL, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': CSRF_TOKEN,
        'Accept': 'application/json'
      },
      body: JSON.stringify({ page_slug: PAGE_SLUG })
    });
    const data = await res.json();
    if (!res.ok || data.locked || (data.restricted && !data.unlocked)) {
      lockAnggaran(data.reason || 'account_deactivated');
    }
  } catch(e) {}
}

function startAnggaranWatchers() {
  if (anggaranWatcherStarted || !isPageRestricted || !isPageUnlocked) return;
  anggaranWatcherStarted = true;

  const now = Date.now();
  let lastUserActivity = parseInt(localStorage.getItem('upt_last_active_anggaran') || now.toString(), 10);
  let lastPageOpened = parseInt(localStorage.getItem('upt_last_opened_anggaran') || now.toString(), 10);

  // Jika halaman dibuka kembali setelah >= 10 menit
  if (now - lastPageOpened >= UNOPENED_LIMIT_MS) {
    lockAnggaran('unopened_10m');
    return;
  }

  // Refresh timestamp pembukaan halaman
  lastPageOpened = now;
  lastUserActivity = now;
  localStorage.setItem('upt_last_active_anggaran', now.toString());
  localStorage.setItem('upt_last_opened_anggaran', now.toString());

  // Throttled Activity Listener (Mouse, Keyboard, Touch, Scroll)
  let throttleTimer = null;
  function recordActivity() {
    if (!isPageUnlocked) return;
    const t = Date.now();
    lastUserActivity = t;
    lastPageOpened = t;
    localStorage.setItem('upt_last_active_anggaran', t.toString());
    localStorage.setItem('upt_last_opened_anggaran', t.toString());
  }

  function onActivityEvent() {
    if (throttleTimer) return;
    throttleTimer = setTimeout(() => {
      throttleTimer = null;
      recordActivity();
    }, 1000);
  }

  const activityEvents = ['mousemove', 'mousedown', 'keydown', 'keypress', 'scroll', 'touchstart', 'click', 'wheel'];
  activityEvents.forEach(evt => window.addEventListener(evt, onActivityEvent, { passive: true }));

  // Visibility & Focus Listener (Mendeteksi Halaman Tidak Dibuka & Cek Status Realtime / Deactivation)
  function onVisibilityOrFocusChange() {
    const t = Date.now();
    if (document.visibilityState === 'visible') {
      if (isPageUnlocked) {
        const prevOpened = parseInt(localStorage.getItem('upt_last_opened_anggaran') || t.toString(), 10);
        if (t - prevOpened >= UNOPENED_LIMIT_MS) {
          lockAnggaran('unopened_10m');
          return;
        }
        recordActivity();
      }
      checkServerAccessAnggaran(true);
    } else {
      localStorage.setItem('upt_last_opened_anggaran', t.toString());
      // Ketika berpindah ke tab lain, langsung periksa status validitas akun ke server
      if (isPageUnlocked) {
        checkServerAccessAnggaran(true);
      }
    }
  }

  document.addEventListener('visibilitychange', onVisibilityOrFocusChange);
  window.addEventListener('focus', onVisibilityOrFocusChange);
  window.addEventListener('blur', onVisibilityOrFocusChange);

  // Interval Tiap 1 Detik
  const checkInterval = setInterval(() => {
    if (!isPageUnlocked) {
      clearInterval(checkInterval);
      return;
    }

    const t = Date.now();

    // Rule 2: 10 Menit Tidak Dibuka Halamannya
    const currentOpened = parseInt(localStorage.getItem('upt_last_opened_anggaran') || t.toString(), 10);
    if (t - currentOpened >= UNOPENED_LIMIT_MS) {
      clearInterval(checkInterval);
      lockAnggaran('unopened_10m');
      return;
    }

    // Rule 1: 3 Menit AFK (hanya saat halaman visible)
    if (document.visibilityState === 'visible') {
      const currentActive = parseInt(localStorage.getItem('upt_last_active_anggaran') || t.toString(), 10);
      if (t - currentActive >= AFK_LIMIT_MS) {
        clearInterval(checkInterval);
        lockAnggaran('afk_3m');
        return;
      }
    }
  }, 1000);

  // Heartbeat Server Ping tiap 30 detik
  setInterval(() => {
    if (!isPageUnlocked) return;
    if (document.visibilityState === 'visible') {
      checkServerAccessAnggaran();
    }
  }, PING_INTERVAL_MS);
}

// Inisialisasi Status Halaman
const storedReason = sessionStorage.getItem('upt_lock_reason_anggaran') || SERVER_LOCKED_REASON;
if (!isPageRestricted) {
  unlockPage();
  const lockBtn = document.getElementById('btnLockAnggaran');
  if(lockBtn) lockBtn.style.display = 'none';
} else if (isPageUnlocked && storedReason !== 'manual' && storedReason !== 'account_deactivated') {
  unlockPage();
  startAnggaranWatchers();
} else {
  sessionStorage.removeItem('anggaranLoggedIn');
  lockPage(storedReason);
}
</script>
<!-- ReactBits Animation Suite -->
<script src="{{ asset('js/reactbits-animations.js') }}"></script>
</body>
</html>
