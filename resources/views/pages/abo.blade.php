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
<title>PROGRAM ANTI BLACKOUT — UPT MANADO</title>
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
    --green:#27AE60; --red:#E74C3C; --yellow:#D9A400; --blue:#00529C; --gray:#94A3B8;
  }
  [data-theme="dark"]{
    --pln-blue:#0A192F; --pln-blue-dark:#020C1B; --pln-yellow:#FFC72C;
    --bg-body:#0F172A; --bg-card:#1E293B; --bg-hero:linear-gradient(135deg,#020C1B,#1E293B);
    --text-main:#F8FAFC; --text-muted:#94A3B8; --border-color:#334155;
    --table-header-bg:#263449; --card-shadow:0 4px 6px rgba(0,0,0,0.3);
    --btn-toggle-bg:#334155; --btn-toggle-text:#FFC72C; --input-bg:#1E293B;
    --green:#2ECC71; --red:#FF6B6B; --yellow:#FFD23F; --blue:#3BA7FF; --gray:#64748B;
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
  .hero {
    background: var(--bg-hero);
    background-size: 200% 200%;
    color: #fff;
    padding: 22px 20px 24px;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    animation: heroGradientShift 12s ease infinite;
    position: relative;
    overflow: hidden;
    box-sizing: border-box;
    overflow-anchor: none;
    transition: padding .35s ease, box-shadow .35s ease;
  }

  .hero.hero-shrink,
  #topbar.hero-shrink .hero {
    padding: 13px 20px !important;
    justify-content: center !important;
    align-items: center !important;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.18);
  }

  @keyframes heroGradientShift {
    0% {
      background-position: 0% 50%;
    }

    50% {
      background-position: 100% 50%;
    }

    100% {
      background-position: 0% 50%;
    }
  }

  .hero::before {
    content: '';
    position: absolute;
    inset: 0;
    pointer-events: none;
    background-image: radial-gradient(rgba(255, 255, 255, 0.35) 1.5px, transparent 1.5px);
    background-size: 38px 38px;
    animation: heroParticleDrift 18s linear infinite;
    opacity: 0.35;
  }

  @keyframes heroParticleDrift {
    from {
      background-position: 0 0;
    }

    to {
      background-position: 190px 190px;
    }
  }

  .logo-upt {
    height: 120px;
    max-width: 90%;
    width: auto;
    object-fit: contain;
    filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
    position: relative;
    z-index: 1;
    display: block;
    margin: 0 auto;
    animation: logoFloat 4.5s ease-in-out infinite;
    transition: height .35s ease;
  }

  .hero.hero-shrink .logo-upt,
  #topbar.hero-shrink .logo-upt {
    height: 68px !important;
    margin: 0 auto !important;
  }

  @keyframes logoFloat {
    0%,
    100% {
      transform: translateY(0px);
    }

    50% {
      transform: translateY(-5px);
    }
  }

  .status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    justify-content: center;
    margin-top: 12px;
    background: rgba(46, 204, 113, 0.18);
    border: 1px solid #2ECC71;
    color: #2ECC71;
    padding: 4px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    line-height: 1.4;
    position: relative;
    z-index: 1;
    max-height: 40px;
    overflow: hidden;
    transition: opacity .3s ease, transform .3s ease, margin .35s ease, max-height .35s ease, padding .35s ease;
  }

  .hero.hero-shrink .status-badge,
  #topbar.hero-shrink .status-badge {
    opacity: 0 !important;
    transform: translateY(-8px) scale(0.9) !important;
    margin-top: 0 !important;
    margin-bottom: 0 !important;
    max-height: 0 !important;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    border-width: 0 !important;
    pointer-events: none !important;
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
  .sidebar .sb-group-title{padding:12px 20px 6px; font-size:11px; font-weight:800; letter-spacing:0.5px; color:var(--text-muted); text-transform:uppercase;}
  .sidebar a{display:flex; align-items:center; gap:8px; padding:9px 20px; font-size:13px; font-weight:600; color:var(--text-main); text-decoration:none; border-left:3px solid transparent; cursor:pointer;}
  .sidebar a.active{background:var(--table-header-bg); border-left-color:var(--pln-blue); color:var(--pln-blue);}
  [data-theme="dark"] .sidebar a.active{color:var(--pln-yellow); border-left-color:var(--pln-yellow);}
  .sidebar a:not(.active):hover{background:var(--table-header-bg);}
  main{flex:1; min-width:0; padding:24px 24px 60px; width:100%;}
  @media (max-width:820px){
    .page-layout{flex-direction:column;}
    .sidebar{width:100%; height:auto; position:static; transform:none; backdrop-filter:none; background:var(--bg-card); display:flex; overflow-x:auto; border-right:none; border-bottom:1px solid var(--border-color);}
    .sidebar-hover-trigger{display:none;}
    .sidebar a{border-left:none; border-bottom:3px solid transparent; white-space:nowrap;}
    .sidebar a.active{border-left:none; border-bottom-color:var(--pln-blue);}
  }

  .section-block{scroll-margin-top:calc(var(--topbar-h, 0px) + 12px); margin-bottom:36px;}
  .module-title{font-size:16px; font-weight:800; color:var(--text-main); margin:0 0 4px; padding-bottom:10px; border-bottom:2px solid var(--pln-blue);}
  [data-theme="dark"] .module-title{border-bottom-color:var(--pln-yellow);}
  .ce-toolbar{display:flex; align-items:center; gap:10px; margin:14px 0 20px;}
  .ce-toolbar select{padding:7px 14px; border:1px solid var(--border-color); border-radius:6px; background:var(--input-bg); color:var(--text-main); font-size:12.5px; font-weight:600;}
  .stream-title{font-size:14px; font-weight:800; color:var(--pln-blue); margin:26px 0 12px; display:flex; align-items:center; gap:8px;}
  [data-theme="dark"] .stream-title{color:var(--pln-yellow);}
  .stream-summary{font-size:11px; font-weight:600; color:var(--text-muted); background:var(--table-header-bg); padding:3px 10px; border-radius:10px;}

  .prog-grid{display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:8px;}
  .prog-card{
    background:var(--bg-card); border:1px solid var(--border-color); border-radius:6px;
    padding:9px 11px; box-shadow:var(--card-shadow); cursor:pointer; border-left-width:3px; border-left-style:solid;
    transition:box-shadow 0.15s ease;
  }
  .prog-card:hover{box-shadow:0 4px 12px rgba(0,0,0,0.15);}
  .prog-card.accent-green{border-left-color:var(--green);}
  .prog-card.accent-red{border-left-color:var(--red);}
  .prog-card.accent-blue{border-left-color:var(--blue);}
  .prog-card.accent-gray{border-left-color:var(--gray);}
  .prog-card.accent-yellow{border-left-color:var(--yellow);}
  .prog-card .pc-name{font-size:11px; font-weight:700; color:var(--text-main); margin-bottom:4px; line-height:1.3; min-height:28px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;}
  .prog-card .pc-sasaran{font-size:9.5px; color:var(--text-muted); margin-bottom:6px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;}
  .prog-card .pc-row{display:flex; justify-content:space-between; align-items:center;}
  .status-chip{display:inline-block; padding:2px 8px; border-radius:10px; font-size:9px; font-weight:700; color:#fff;}
  .status-chip.green{background:var(--green);}
  .status-chip.red{background:var(--red);}
  .status-chip.blue{background:var(--blue);}
  .status-chip.gray{background:var(--gray);}
  .status-chip.yellow{background:var(--yellow); color:#1a1a1a;}
  .pc-pct{font-size:12.5px; font-weight:800; color:var(--pln-blue);}
  [data-theme="dark"] .pc-pct{color:var(--pln-yellow);}

  .cal-title{font-size:11px; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.3px; margin:16px 0 8px;}
  .cal-tr-legend{font-weight:600; text-transform:none; letter-spacing:0; margin-left:10px; font-size:10.5px; color:var(--text-muted); opacity:0.85;}
  .scurve-wrap{background:var(--bg-card); border:1px solid var(--border-color); border-radius:8px; padding:14px; box-shadow:var(--card-shadow); margin-bottom:14px; position:relative; height:220px;}
  .scurve-summary-wrap{height:240px; margin-bottom:0;}
  .scurve-summary-row{display:flex; gap:16px; margin-bottom:24px; align-items:stretch;}
  .scurve-summary-chart-col{flex:0 0 50%; max-width:50%;}
  .scurve-summary-cards-col{flex:0 0 20%; max-width:20%; display:flex; flex-direction:column; gap:10px;}
  .ce-stat-card{flex:1; display:flex; flex-direction:column; justify-content:center;}
  .ce-stat-card{background:var(--bg-card); border:1px solid var(--border-color); border-left:4px solid var(--pln-blue); border-radius:6px; padding:8px 8px; box-shadow:var(--card-shadow);}
  .ce-stat-card.clickable{cursor:pointer; transition:box-shadow 0.15s ease;}
  .ce-stat-card.clickable:hover{box-shadow:0 4px 14px rgba(0,0,0,0.18);}
  [data-theme="dark"] .ce-stat-card{border-left-color:#5EC4FF; box-shadow:var(--card-shadow), 0 0 10px rgba(94,196,255,0.15);}
  .ce-stat-card.accent-red{border-left-color:var(--red);}
  [data-theme="dark"] .ce-stat-card.accent-red{box-shadow:var(--card-shadow), 0 0 10px rgba(255,107,107,0.15);}
  .ce-stat-card.accent-green{border-left-color:var(--green);}
  [data-theme="dark"] .ce-stat-card.accent-green{box-shadow:var(--card-shadow), 0 0 10px rgba(46,204,113,0.15);}
  .ce-stat-label{font-size:12.5px; font-weight:800; color:var(--pln-blue); text-transform:uppercase; letter-spacing:0.3px; margin-bottom:3px;}
  [data-theme="dark"] .ce-stat-label{color:#5EC4FF;}
  .ce-stat-card.accent-red .ce-stat-label{color:var(--red);}
  .ce-stat-card.accent-green .ce-stat-label{color:var(--green);}
  .ce-stat-val{font-size:25px; font-weight:800; color:var(--pln-blue);}
  [data-theme="dark"] .ce-stat-val{color:var(--pln-yellow);}
  .ce-stat-sub{font-size:9.5px; color:var(--text-muted); font-weight:600; margin-top:2px;}

  .ce-custom-tooltip{
    position:fixed; pointer-events:none; z-index:4000; transform:translate(-50%,-115%);
    background:rgba(20,24,34,0.96); color:#F1F5F9; padding:8px 11px; border-radius:7px;
    font-size:11px; line-height:1.5; white-space:nowrap; opacity:0; transition:opacity 0.1s ease;
    box-shadow:0 4px 14px rgba(0,0,0,0.3);
  }
  .ctt-title{font-weight:800; margin-bottom:3px; color:#fff;}
  .ctt-row{display:flex; align-items:center; gap:6px;}
  .ctt-dot{width:8px; height:8px; border-radius:50%; display:inline-block; flex-shrink:0;}
  .ctt-gap{margin-top:5px; padding-top:5px; border-top:1px solid rgba(255,255,255,0.2); font-weight:800;}
  .ctt-gap-neg{color:#FF6B6B;}
  .ctt-gap-pos{color:#3DDC84;}

  .scurve-pctbar-track{width:100%; height:22px; background:var(--table-header-bg); border-radius:5px; overflow:hidden; margin-bottom:8px;}
  .scurve-pctbar-fill{height:100%; display:flex; align-items:center; justify-content:flex-end; padding-right:8px; color:#fff; font-size:11px; font-weight:700; transition:width 0.3s ease;}

  .cal-overlay-wrap{position:relative;}
  .cal-overlay-canvas-box{position:absolute; pointer-events:auto; overflow:hidden; z-index:100;}
  .section-block{isolation:isolate;}
  .cal-overlay-canvas-box canvas{width:100% !important; height:100% !important; display:block;}
  .scurve-inline-legend{display:inline-flex; gap:14px; margin-left:14px; font-size:10.5px; font-weight:600; color:var(--text-muted);}
  .sil-item{display:inline-flex; align-items:center; gap:5px;}
  .sil-swatch{width:16px; height:0; border-top:2px solid; display:inline-block;}
  .sil-swatch.target{border-top-style:dashed; border-top-color:#00529C;}
  [data-theme="dark"] .sil-swatch.target{border-top-color:#5EC4FF;}
  .sil-swatch.realisasi{border-top-style:solid; border-top-color:#1E8449;}
  [data-theme="dark"] .sil-swatch.realisasi{border-top-color:#3DDC84;}
  .cal-table-scroll{overflow-x:auto; background:var(--bg-card); border:1px solid var(--border-color); border-radius:8px; box-shadow:var(--card-shadow); padding:10px;}
  .cal-scurve{width:100%; border-collapse:collapse; font-size:9px; table-layout:fixed;}
  .cal-scurve th, .cal-scurve td{border:1px solid var(--border-color); text-align:center; padding:3px 1px; overflow:hidden;}
  .cal-scurve th{background:var(--table-header-bg); color:var(--text-muted); font-weight:700; font-size:9px;}
  .cal-corner{background:var(--table-header-bg); min-width:220px; width:220px;}
  .cal-item-name{background:var(--bg-card); text-align:left !important; padding-left:8px !important; font-size:10px; font-weight:600; color:var(--text-main); min-width:220px; width:220px; vertical-align:middle;}
  .cal-row-type{font-size:8px; color:var(--text-muted); font-weight:700; min-width:26px; width:26px; white-space:nowrap;}
  .cal-row-type-target{background:rgba(0,82,156,0.08);}
  .cal-row-type-real{background:rgba(39,174,96,0.08);}
  .cal-scurve td.cal-cell-target, .cal-scurve td.cal-cell-real{width:16px; min-width:16px;}
  .cal-cell-target{background:rgba(0,82,156,0.12); font-weight:700; color:var(--pln-blue); opacity:0.35; min-width:16px; width:16px;}
  [data-theme="dark"] .cal-cell-target{color:#66B2FF; background:rgba(59,167,255,0.18);}
  .cal-cell-realisasi{background:rgba(39,174,96,0.15); font-weight:700; color:var(--green); opacity:0.35; min-width:16px; width:16px;}
  /* Kalender bulanan (ABO) — 12 kolom langsung, dibuat lebih lebar dari versi mingguan (48 kolom) */
  .cal-scurve-monthly th, .cal-scurve-monthly td.cal-cell-target, .cal-scurve-monthly td.cal-cell-realisasi{min-width:52px; width:52px; font-size:10px;}

  .loading,.err{padding:30px 0; text-align:center; color:var(--text-muted); font-size:13px;}
  .err{color:var(--red);}

  .modal-overlay{display:none; position:fixed; inset:0; background:rgba(0,0,0,0.55); z-index:3000; align-items:center; justify-content:center; padding:20px;}
  .modal-box{background:var(--bg-card); border-radius:10px; max-width:560px; width:100%; max-height:82vh; display:flex; flex-direction:column; box-shadow:0 10px 40px rgba(0,0,0,0.3);}
  .modal-header{display:flex; justify-content:space-between; align-items:center; padding:16px 20px; border-bottom:1px solid var(--border-color); font-weight:700; font-size:14px; color:var(--pln-blue);}
  [data-theme="dark"] .modal-header{color:var(--pln-yellow);}
  .modal-close{background:none; border:none; font-size:16px; cursor:pointer; color:var(--text-muted);}
  .modal-close:hover{color:var(--red);}
  .modal-body{padding:8px 20px 20px; overflow-y:auto;}
  .modal-body .mrow{display:flex; justify-content:space-between; gap:12px; padding:9px 0; border-bottom:1px dashed var(--border-color); font-size:13px;}
  .modal-body .mrow:last-child{border-bottom:none;}
  .modal-body .mrow .mlabel{color:var(--text-muted); flex-shrink:0;}
  .modal-body .mrow .mval{font-weight:700; text-align:right;}
  .modal-body .just-box{margin-top:10px; padding:12px; background:var(--table-header-bg); border-radius:6px; font-size:12.5px; line-height:1.5;}
  .just-item{display:flex; align-items:flex-start; gap:8px; padding:7px 0; border-bottom:1px dashed var(--border-color); font-size:12px;}
  .just-item:last-child{border-bottom:none;}
  .just-item .ji-icon{flex-shrink:0; font-size:14px; margin-top:1px;}
  .just-item .ji-nama{flex:1; color:var(--text-main);}
  .just-item .ji-date{flex-shrink:0; font-size:10.5px; color:var(--text-muted); text-align:right; white-space:nowrap;}
  .just-raw-toggle{font-size:10.5px; color:var(--pln-blue); cursor:pointer; margin-top:8px; display:inline-block;}
  [data-theme="dark"] .just-raw-toggle{color:var(--pln-yellow);}
  .just-raw{display:none; margin-top:6px; padding:8px; background:var(--bg-card); border:1px dashed var(--border-color); border-radius:6px; font-size:11px; white-space:pre-wrap; color:var(--text-muted);}
</style>
</head>
<body>

<div id="topbar" class="{{ (($isRestricted ?? false) && !($isUnlocked ?? false)) ? 'topbar-locked' : '' }}">
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
      <a href="{{ route('anggaran') }}">Anggaran Unit</a>
      <a href="{{ route('aset') }}">Aset</a>
      <a href="{{ route('ahi') }}">AHI</a>
      <a href="{{ route('common-enemy') }}">Common Enemy</a>
      <a href="{{ route('abo') }}" class="active">Program Anti Blackout</a>
      <a href="{{ route('konstruksi-penyaluran') }}">Konstruksi &amp; Penyaluran</a>
      <a href="{{ route('kku') }}">KKU</a>
    @endif
  </nav>
  <div class="header-right">
    <button class="theme-toggle-btn" id="themeToggle" onclick="toggleTheme()"><span id="themeIcon">🌙</span> <span id="themeText">Dark Mode</span></button>
  
    @if(($isRestricted ?? false) && ($isUnlocked ?? false))
      <button id="btnLockUnivPage" onclick="lockCurrentPage('manual')" style="display:inline-flex; align-items:center; gap:5px; background:rgba(231,76,60,0.18); color:#E74C3C; border:1px solid #E74C3C; padding:6px 12px; border-radius:20px; font-size:11.5px; font-weight:700; cursor:pointer;" title="Kunci kembali akses halaman ini">
        🔒 Kunci Akses
      </button>
    @endif

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

<div class="page-layout {{ (($isRestricted ?? false) && !($isUnlocked ?? false)) ? 'page-restricted-blurred' : '' }}">
  <div class="sidebar-hover-trigger" id="sidebarTrigger"></div>
  <aside class="sidebar" id="sidebarStreamList">
    <div class="sb-group-title">Stream</div>
    <div class="loading" style="padding:16px 20px; text-align:left;">Memuat...</div>
  </aside>

<main>
  <div class="module-title" style="display: flex; align-items: center; gap: 10px;">
    <img src="{{ asset('Logo_UPT_Manado.png') }}" alt="PLN UPT Manado" style="height: 28px; width: auto; object-fit: contain; vertical-align: middle;">
    <span>PROGRAM ANTI BLACKOUT</span>
  </div>
  <div class="ce-toolbar">
    <label for="statusFilter" style="font-size:12px; color:var(--text-muted); font-weight:600;">Filter Status:</label>
    <select id="statusFilter" onchange="onFilterChange()">
      <option value="all">Semua</option>
      <option value="all-except-out" selected>Semua Tanpa Tidak ada Target</option>
      <option value="tercapai">Tercapai</option>
      <option value="hati-hati">Hati-Hati</option>
      <option value="tidak tercapai">Tidak Tercapai</option>
    </select>
  </div>
  <div id="content"><div class="loading">MENGHUBUNGKAN KE SUMBER DATA...</div></div>
</main>
</div>

<footer class="{{ (($isRestricted ?? false) && !($isUnlocked ?? false)) ? 'page-restricted-blurred' : '' }}">{{ $settings['footer_text'] ?? '&copy; 2026 PT PLN (Persero) UPT Manado — Dashboard Program Anti Blackout. All Rights Reserved.' }}</footer>

<div id="detailModalOverlay" class="modal-overlay" onclick="if(event.target===this) closeDetailModal()">
  <div class="modal-box">
    <div class="modal-header"><span id="detailModalTitle">Detail Program Kerja</span><button class="modal-close" onclick="closeDetailModal()">✕</button></div>
    <div id="detailModalBody" class="modal-body"></div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.4.1/papaparse.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js"></script>
<script>
window.APP_DATA_SOURCES = @json($dataSources ?? []);
const CE_CSV_URL = (window.APP_DATA_SOURCES && window.APP_DATA_SOURCES.anti_blackout_csv) ? window.APP_DATA_SOURCES.anti_blackout_csv : "";
const STREAM_ICON = {}; // nama "Bagian" pada sheet ABO belum diketahui persis, pakai ikon fallback default (⚙️)

let STATE = { items: [] };

function parsePct(str){
  if(!str) return null;
  const s = str.toString().trim();
  if(s === '--' || s === '') return null;
  const n = parseFloat(s.replace('%','').replace(',', '.'));
  return isNaN(n) ? null : n;
}
function parseIDR(str){
  if(!str) return 0;
  const s = str.toString().replace(/Rp/gi,'').replace(/\s/g,'').replace(/\./g,'').replace(',', '.').trim();
  const n = parseFloat(s);
  return isNaN(n) ? 0 : n;
}
function fmtRp(n){ return 'Rp ' + Math.round(n).toLocaleString('id-ID'); }

function statusAccent(status){
  const s = (status||'').trim().toLowerCase();
  if(s === 'tidak tercapai') return 'red';
  if(s === 'tidak ada target') return 'gray';
  if(s === 'hati-hati' || s === 'hati hati') return 'yellow';
  if(s === 'tercapai') return 'green';
  return 'gray';
}

async function fetchCsvRows(url, timeoutMs){
  timeoutMs = timeoutMs || 15000;
  async function doFetch(targetUrl){
    const controller = new AbortController();
    const timer = setTimeout(()=>controller.abort(), timeoutMs);
    try{
      const res = await fetch(targetUrl, {cache:'no-store', signal: controller.signal});
      clearTimeout(timer);
      if(!res.ok) throw new Error('HTTP ' + res.status);
      const text = await res.text();
      return Papa.parse(text, {skipEmptyLines:false}).data;
    }catch(e){
      clearTimeout(timer);
      throw e;
    }
  }

  try{
    return await doFetch(url);
  }catch(errDirect){
    console.warn('Direct fetch failed, trying proxy...', errDirect.message);
    const proxyUrl = '/api/proxy-csv?url=' + encodeURIComponent(url);
    return await doFetch(proxyUrl);
  }
}

function slug(s){ return s.toLowerCase().replace(/[^a-z0-9]+/g,'-').replace(/(^-|-$)/g,''); }

const MONTH_ABBR_ID = {jan:0,feb:1,mar:2,apr:3,mei:4,jun:5,jul:6,ags:7,agu:7,agt:7,sep:8,okt:9,nov:10,des:11};
const MONTH_NAME_ID = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

// Cari tanggal hari Jumat pada minggu ke-N (N=1..5) di suatu bulan/tahun.
// "Minggu ke-N" dihitung dari urutan hari Jumat yang jatuh di bulan itu (Jumat pertama = minggu 1, dst).
function getNthFridayOfMonth(year, monthIdx, n){
  const fridays = [];
  const d = new Date(year, monthIdx, 1);
  while(d.getMonth() === monthIdx){
    if(d.getDay() === 5) fridays.push(new Date(d));
    d.setDate(d.getDate()+1);
  }
  return fridays[n-1] || null;
}
function formatDateID(d){
  if(!d) return null;
  return d.getDate() + ' ' + MONTH_NAME_ID[d.getMonth()] + ' ' + d.getFullYear();
}

// Menerjemahkan teks Justifikasi mentah menjadi daftar item pekerjaan terstruktur, sesuai pola:
// - "Target Pekerjaan :" menandai awal daftar item detail
// - ⏳ = belum dilaksanakan, ✅ / "Finished" = sudah selesai
// - "(DD-DD Bulan YYYY)" = target 2 hari (atau sesuai selisih tanggal)
// - "(M{n} {BulanSingkat})" = ambil tanggal hari Jumat pada minggu ke-n di bulan itu (tahun 2026)
function parseJustifikasi(text){
  if(!text || !text.trim()) return null;
  const idx = text.search(/target pekerjaan/i);
  const intro = idx > 0 ? text.slice(0, idx).trim() : (idx === -1 ? text.trim() : '');
  const listText = idx >= 0 ? text.slice(idx) : '';
  if(!listText) return { intro, items: [] };

  // Pisahkan per baris: dukung newline literal, atau penanda ⏳/✅ sebagai awal item baru kalau teks 1 baris panjang
  let lines = listText.split(/\r?\n/).map(l=>l.trim()).filter(Boolean);
  if(lines.length <= 1){
    lines = listText.split(/(?=[⏳✅])/).map(l=>l.trim()).filter(Boolean);
  }

  const items = [];
  lines.forEach(line=>{
    if(/^target pekerjaan\s*:?\s*$/i.test(line)) return; // baris judul itu sendiri, lewati
    const isDone = line.includes('✅') || /finished/i.test(line);
    const isPending = line.includes('⏳');

    const dateMatch = line.match(/\(([^)]+)\)/);
    let dateLabel = null;
    if(dateMatch){
      const inner = dateMatch[1].trim();
      const rangeMatch = inner.match(/^(\d{1,2})\s*-\s*(\d{1,2})\s+([A-Za-z]+)\s+(\d{4})$/);
      const weekMatch = inner.match(/^M(\d)\s+([A-Za-z]+)$/i);
      if(rangeMatch){
        const days = parseInt(rangeMatch[2],10) - parseInt(rangeMatch[1],10) + 1;
        dateLabel = inner + ` (${days} hari)`;
      } else if(weekMatch){
        const wk = parseInt(weekMatch[1],10);
        const monIdx = MONTH_ABBR_ID[weekMatch[2].toLowerCase().slice(0,3)];
        if(monIdx !== undefined){
          const friday = getNthFridayOfMonth(2026, monIdx, wk);
          dateLabel = friday ? `${formatDateID(friday)} (Jumat, ${inner})` : inner;
        } else {
          dateLabel = inner;
        }
      } else {
        dateLabel = inner;
      }
    }
    const nama = line.replace(/\([^)]*\)/g,'').replace(/[⏳✅]/g,'').replace(/finished/gi,'').trim();
    if(!nama && !dateLabel) return;
    items.push({ nama: nama || '(tanpa nama item)', dateLabel, status: isDone ? 'done' : (isPending ? 'pending' : 'unknown') });
  });
  return { intro, items };
}

function renderJustifikasiHtml(rawText){
  const parsed = parseJustifikasi(rawText);
  if(!parsed) return '<i>Tidak ada catatan justifikasi.</i>';
  let html = '';
  if(parsed.intro) html += `<div style="margin-bottom:8px;">${parsed.intro}</div>`;
  if(parsed.items.length){
    html += parsed.items.map(it=>{
      const icon = it.status === 'done' ? '✅' : (it.status === 'pending' ? '⏳' : '•');
      return `<div class="just-item">
        <span class="ji-icon">${icon}</span>
        <span class="ji-nama">${it.nama}</span>
        <span class="ji-date">${it.dateLabel || ''}</span>
      </div>`;
    }).join('');
  } else if(!parsed.intro){
    html = '<i>Tidak ada catatan justifikasi.</i>';
  }
  const rawId = 'raw-' + Math.random().toString(36).slice(2,8);
  html += `<span class="just-raw-toggle" onclick="document.getElementById('${rawId}').style.display = document.getElementById('${rawId}').style.display==='block' ? 'none' : 'block';">Lihat teks asli ▾</span>
    <div class="just-raw" id="${rawId}">${(rawText||'').replace(/</g,'&lt;')}</div>`;
  return html;
}

const MONTH_SHORT_ID = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];

function lerpColor(pct){
  // 0% merah -> 50% oranye -> 100% hijau (sama seperti scale bar di Anggaran.html)
  const lerp = (a,b,t)=> Math.round(a + (b-a)*t);
  const stops = pct <= 50
    ? { r:lerp(231,230,pct/50), g:lerp(76,126,pct/50), b:lerp(60,34,pct/50) }
    : { r:lerp(230,39,(pct-50)/50), g:lerp(126,174,(pct-50)/50), b:lerp(34,96,(pct-50)/50) };
  return `rgb(${stops.r},${stops.g},${stops.b})`;
}

// Kalender heatmap (12 bulan x M1-M4) + bar ringkasan bulanan dengan scale warna, untuk satu kelompok Stream
function buildStreamCalendar(streamItems){
  // Hanya tampilkan item yang punya setidaknya 1 angka target/realisasi di kalender
  const validItems = streamItems.filter(it =>
    it.targetCal.some(v=>v>0) || it.realisasiCal.some(v=>v>0)
  );
  if(!validItems.length) return '';

  // Header 1 tingkat saja: 12 kolom bulan langsung (data ABO bulanan, bukan mingguan — tidak ada sub M1-M4)
  const monthHeaderHtml = MONTH_SHORT_ID.map(m => `<th>${m}</th>`).join('');

  const rowsHtml = validItems.map(it=>{
    const targetCells = it.targetCal.map(v => `<td class="cal-cell-target">${v>0 ? v : ''}</td>`).join('');
    const realisasiCells = it.realisasiCal.map(v => `<td class="cal-cell-realisasi">${v>0 ? v : ''}</td>`).join('');
    return `
      <tr>
        <td class="cal-item-name" rowspan="2">${it.programKerja}</td>
        <td class="cal-row-type cal-row-type-target">T</td>
        ${targetCells}
      </tr>
      <tr>
        <td class="cal-row-type cal-row-type-real">R</td>
        ${realisasiCells}
      </tr>`;
  }).join('');

  return `
    <div class="cal-table-scroll"><table class="cal-table cal-scurve cal-scurve-monthly">
      <thead>
        <tr><th class="cal-corner">Program Kerja</th><th></th>${monthHeaderHtml}</tr>
      </thead>
      <tbody>${rowsHtml}</tbody>
    </table></div>`;
}

function escapeHtml(str) {
  if (str === null || str === undefined) return '';
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');
}

function openDetailModal(idx){
  const it = STATE.items[idx];
  if(!it) return;
  document.getElementById('detailModalTitle').textContent = it.programKerja;

  let extraRowsHtml = '';
  if (it.lokasiProject) {
    extraRowsHtml += `<div class="mrow"><span class="mlabel">Lokasi Project</span><span class="mval" style="font-weight:600; color:var(--pln-blue);">${escapeHtml(it.lokasiProject)}</span></div>`;
  }
  if (it.customFields) {
    Object.keys(it.customFields).forEach(colName => {
      const lower = colName.toLowerCase();
      if (!lower.includes('lokasi') && !lower.includes('kendala')) {
        const val = it.customFields[colName];
        if (val && String(val).trim()) {
          extraRowsHtml += `<div class="mrow"><span class="mlabel">${escapeHtml(colName)}</span><span class="mval">${escapeHtml(val)}</span></div>`;
        }
      }
    });
  }

  document.getElementById('detailModalBody').innerHTML = `
    <div class="mrow"><span class="mlabel">Target Total (1 Tahun)</span><span class="mval">${it.targetTotal} ${it.satuan}</span></div>
    <div class="mrow"><span class="mlabel">Target Kumulatif</span><span class="mval">${it.targetKumulatif} ${it.satuan}</span></div>
    <div class="mrow"><span class="mlabel">Realisasi Kumulatif</span><span class="mval">${it.realisasi} ${it.satuan}</span></div>
    <div class="mrow"><span class="mlabel">% Capaian</span><span class="mval">${it.pct === null ? '-' : it.pct.toFixed(1)+'%'}</span></div>
    <div class="mrow"><span class="mlabel">Status</span><span class="mval"><span class="status-chip ${statusAccent(it.status)}">${it.status || '-'}</span></span></div>
    ${extraRowsHtml}
    <div class="just-box"><b>Kendala:</b><br>${it.kendala || '<i>Tidak ada catatan kendala.</i>'}</div>
    <div class="just-box"><b>Justifikasi:</b><br>${renderJustifikasiHtml(it.justifikasi)}</div>`;
  document.getElementById('detailModalOverlay').style.display = 'flex';
}
function closeDetailModal(){ document.getElementById('detailModalOverlay').style.display = 'none'; }

// Popup daftar CE "Belum Selesai" / "Selesai", diklik dari card statistik ringkasan
function openCompletionModal(kind){
  const items = STATE.filteredItems || STATE.items;
  const list = items.filter(it => kind === 'selesai' ? (it.pct !== null && it.pct >= 100) : !(it.pct !== null && it.pct >= 100));
  document.getElementById('detailModalTitle').textContent = (kind === 'selesai' ? 'Selesai' : 'Belum Selesai') + ` (${list.length})`;
  if(!list.length){
    document.getElementById('detailModalBody').innerHTML = '<div style="padding:16px 0;color:var(--text-muted);font-size:13px;">Tidak ada item.</div>';
  } else {
    const rowsHtml = list.map(it=>{
      const globalIdx = STATE.items.indexOf(it);
      const accent = statusAccent(it.status);
      return `<div class="mrow" style="cursor:pointer;" onclick="closeDetailModal(); setTimeout(()=>openDetailModal(${globalIdx}),150);">
        <span class="mlabel">${it.programKerja} <span class="status-chip ${accent}" style="margin-left:6px;">${it.status||'-'}</span></span>
        <span class="mval">${it.pct===null?'-':it.pct.toFixed(0)+'%'}</span>
      </div>`;
    }).join('');
    document.getElementById('detailModalBody').innerHTML = rowsHtml;
  }
  document.getElementById('detailModalOverlay').style.display = 'flex';
}

function scrollToStream(el, id){
  document.querySelectorAll('.sidebar a').forEach(a=>a.classList.remove('active'));
  el.classList.add('active');
  const target = document.getElementById(id);
  if(target) target.scrollIntoView({behavior:'smooth'});
}

function getCurrentMonthIdx(){
  return new Date().getMonth(); // 0=Jan..11=Des, mengikuti tanggal live saat halaman dibuka
}

function computeMonthlyCumulative(items){
  const targetMonth = new Array(12).fill(0);
  const realisasiMonth = new Array(12).fill(0);
  items.forEach(it=>{
    for(let m=0;m<12;m++){
      targetMonth[m] += it.targetCal[m]||0;
      realisasiMonth[m] += it.realisasiCal[m]||0;
    }
  });
  const curMonth = getCurrentMonthIdx();
  let cumT=0, cumR=0;
  const cumTarget=[], cumRealisasi=[];
  for(let m=0;m<12;m++){
    cumT += targetMonth[m];
    cumTarget.push(cumT);
    if(m <= curMonth){ cumR += realisasiMonth[m]; cumRealisasi.push(cumR); }
    else cumRealisasi.push(null); // realisasi tidak ditampilkan melewati bulan berjalan (Live Update)
  }
  return { cumTarget, cumRealisasi, curMonth };
}

STATE.charts = {};
function destroyChart(id){ if(STATE.charts[id]){ STATE.charts[id].destroy(); delete STATE.charts[id]; } }

// Posisikan canvas overlay Kurva-S presisi HANYA di area kolom data kalender (12 kolom bulan),
// tidak menutupi kolom "Program Kerja"/"Target-Realisasi" maupun baris header bulan & minggu.
function positionOverlayCanvas(wrapId, boxId){
  const wrap = document.getElementById(wrapId);
  const box = document.getElementById(boxId);
  if(!wrap || !box) return;
  const table = wrap.querySelector('table.cal-scurve');
  if(!table) return;
  const headerRows = table.querySelectorAll('thead tr');
  let headerHeight = 0;
  headerRows.forEach(tr => headerHeight += tr.offsetHeight);
  const cornerCell = table.querySelector('.cal-corner');
  const firstRowType = table.querySelector('tbody .cal-row-type');
  let leftOffset = 0;
  if(cornerCell) leftOffset += cornerCell.offsetWidth;
  if(firstRowType) leftOffset += firstRowType.offsetWidth;
  box.style.left = leftOffset + 'px';
  box.style.top = headerHeight + 'px';
  box.style.width = Math.max(0, table.offsetWidth - leftOffset) + 'px';
  box.style.height = Math.max(0, table.offsetHeight - headerHeight) + 'px';
}

// Bar horizontal skala warna (merah->oranye->hijau) menyatakan % Total Realisasi, lebar mengikuti container-nya
function buildRealisasiPctBar(pct){
  const color = lerpColor(pct);
  return `<div class="scurve-pctbar-track"><div class="scurve-pctbar-fill" style="width:${pct}%; background:${color};">${pct}%</div></div>`;
}

// Tooltip kustom (Chart.js bawaan tidak bisa mewarnai per baris teks): menampilkan Target & Realisasi
// seperti biasa, plus baris "Gap" berwarna merah bold (kalau minus) / hijau bold (kalau plus).
// Gap dihitung terhadap TARGET DESEMBER (M4, akhir tahun) — bukan target di bulan yang sedang di-hover.
function externalTooltipHandler(context){
  const { chart, tooltip } = context;
  let tooltipEl = document.getElementById('ceChartTooltip');
  if(!tooltipEl){
    tooltipEl = document.createElement('div');
    tooltipEl.id = 'ceChartTooltip';
    tooltipEl.className = 'ce-custom-tooltip';
    document.body.appendChild(tooltipEl);
  }
  if(tooltip.opacity === 0){ tooltipEl.style.opacity = 0; return; }

  const dp = tooltip.dataPoints || [];
  const tItem = dp.find(d => d.dataset.label === 'Target Kumulatif');
  const rItem = dp.find(d => d.dataset.label === 'Realisasi Kumulatif');

  let html = `<div class="ctt-title">${(tooltip.title||[])[0] || ''}</div>`;
  dp.forEach(d=>{
    html += `<div class="ctt-row"><span class="ctt-dot" style="background:${d.dataset.borderColor}"></span>${d.dataset.label}: <b>${d.raw}</b></div>`;
  });
  if(tItem && rItem && rItem.raw !== null && rItem.raw !== undefined){
    const targetDesember = tItem.dataset.data[11]; // target M4/Desember = target akhir tahun
    const gap = rItem.raw - targetDesember;
    const cls = gap < 0 ? 'ctt-gap-neg' : 'ctt-gap-pos';
    const sign = gap > 0 ? '+' : '';
    html += `<div class="ctt-gap ${cls}">Gap thd Target Des: ${sign}${gap}</div>`;
  }
  tooltipEl.innerHTML = html;

  const rect = chart.canvas.getBoundingClientRect();
  tooltipEl.style.left = (rect.left + tooltip.caretX) + 'px';
  tooltipEl.style.top = (rect.top + tooltip.caretY) + 'px';
  tooltipEl.style.opacity = 1;
}

function renderSCurveChart(canvasId, items, opts){
  opts = opts || {};
  const { cumTarget, cumRealisasi, curMonth } = computeMonthlyCumulative(items);
  if(cumTarget[11] === 0) return false; // tidak ada data target sama sekali, jangan render chart kosong
  const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
  const tickColor = isDark ? '#94A3B8' : '#6C7A89';
  const gridColor = isDark ? 'rgba(255,255,255,0.08)' : 'rgba(0,0,0,0.06)';
  const targetColor = isDark ? '#5EC4FF' : '#00529C';
  const realisasiColor = isDark ? '#3DDC84' : '#1E8449';
  destroyChart(canvasId);
  const canvas = document.getElementById(canvasId);
  if(!canvas) return false;

  const lastRealisasiIdx = curMonth;
  const targetAtCurMonth = cumTarget[curMonth] || 0;
  const realisasiAtCurMonth = cumRealisasi[curMonth] || 0;
  const minimal = !!opts.minimal;

  STATE.charts[canvasId] = new Chart(canvas, {
    type:'line',
    data:{ labels: MONTH_SHORT_ID, datasets:[
      { label:'Target Kumulatif', data:cumTarget, borderColor: targetColor, backgroundColor: targetColor, borderDash:[6,4], tension:0.35, borderWidth:2, pointRadius:0, pointStyle:'line',
        datalabels:{
          display:(ctx)=> ctx.dataIndex === 11, // hanya tampil di bulan Desember
          align:225, anchor:'end', offset:6, clamp:true, clip:false, color: targetColor, font:{size:10,weight:'700'},
          formatter:(v)=> v
        } },
      { label:'Realisasi Kumulatif', data:cumRealisasi, borderColor: realisasiColor, backgroundColor: realisasiColor, tension:0.35, borderWidth:2, pointRadius:0, pointStyle:'line', spanGaps:false,
        datalabels:{
          display:(ctx)=> ctx.dataIndex === lastRealisasiIdx,
          align:'top', anchor:'end', offset:2, clamp:true, clip:false, color: isDark?'#8CF0B0':'#1E5631', font:{size:10,weight:'700'},
          formatter:(v)=> v // nilai kumulatif realisasi (bukan lagi persentase)
        } }
    ]},
    options:{
      responsive:true, maintainAspectRatio:false,
      layout:{ padding: minimal ? {top:16,right:0,bottom:0,left:0} : {top:20} },
      interaction:{ mode:'index', intersect:false },
      plugins:{
        legend:{ display: !minimal, position:'bottom', labels:{ color:tickColor, font:{size:10}, usePointStyle:true, pointStyleWidth:20 } },
        tooltip:{
          enabled: false,
          external: externalTooltipHandler
        }
      },
      scales: minimal ? {
        x:{ display:false, offset:false, bounds:'data' },
        y:{ display:false, beginAtZero:true }
      } : {
        x:{ grid:{display:false}, ticks:{color:tickColor, font:{size:10}} },
        y:{ grid:{color:gridColor}, ticks:{color:tickColor, font:{size:10}} }
      }
    },
    plugins: window.ChartDataLabels ? [window.ChartDataLabels] : []
  });
  return { pct: targetAtCurMonth>0 ? Math.min(100, Math.round(realisasiAtCurMonth/targetAtCurMonth*100)) : 0 };
}

function onFilterChange(){ renderContent(); }

function filterItemsByStatus(items){
  const val = document.getElementById('statusFilter').value;
  if(val === 'all') return items;
  if(val === 'all-except-out') return items.filter(it => (it.status||'').trim().toLowerCase() !== 'tidak ada target');
  return items.filter(it => (it.status||'').trim().toLowerCase() === val);
}

function renderContent(){
  const content = document.getElementById('content');
  const items = filterItemsByStatus(STATE.items);
  if(!items.length){ content.innerHTML = '<div class="loading">Tidak ada program kerja untuk filter status ini.</div>'; return; }

  const streams = [];
  STATE.items.forEach(it=>{ if(!streams.includes(it.stream)) streams.push(it.stream); });

  // Statistik ringkasan (kanan kurva-S ringkasan): Jumlah Program CE (status selain Out), Belum Selesai, Selesai
  const nonOutItems = STATE.items.filter(it => (it.status||'').trim().toLowerCase() !== 'tidak ada target');
  const totalTargetCe = nonOutItems.reduce((s,it)=> s + parseIDR(it.targetTotal), 0);
  const jumlahProgramCe = nonOutItems.length;
  const selesaiItems = items.filter(it => it.pct !== null && it.pct >= 100);
  const belumSelesaiItems = items.filter(it => !(it.pct !== null && it.pct >= 100));
  const selesaiCount = selesaiItems.length;
  const belumSelesaiCount = belumSelesaiItems.length;
  const curMonthIdx = getCurrentMonthIdx();
  const realisasiSlotsToDate = curMonthIdx + 1; // jumlah slot bulanan s/d akhir bulan berjalan (data ABO sudah bulanan)

  // Belum Selesai -> Sisa Target = (jumlah seluruh Target kalender setahun) - (jumlah Realisasi s/d bulan berjalan)
  function itemSisaTarget(it){
    const totalTarget = it.targetCal.reduce((a,b)=>a+b, 0);
    const realisasiToDate = it.realisasiCal.slice(0, realisasiSlotsToDate).reduce((a,b)=>a+b, 0);
    return totalTarget - realisasiToDate;
  }
  const belumSelesaiSisaTarget = belumSelesaiItems.reduce((s,it)=> s + itemSisaTarget(it), 0);

  // Selesai -> Surplus/Defisit bulan berjalan = Realisasi s/d bulan berjalan - Target s/d bulan berjalan
  function itemSurplusDefisit(it){
    const targetToDate = it.targetCal.slice(0, realisasiSlotsToDate).reduce((a,b)=>a+b, 0);
    const realisasiToDate = it.realisasiCal.slice(0, realisasiSlotsToDate).reduce((a,b)=>a+b, 0);
    return realisasiToDate - targetToDate;
  }
  const selesaiSurplusDefisit = selesaiItems.reduce((s,it)=> s + itemSurplusDefisit(it), 0);
  const selesaiLabel = selesaiSurplusDefisit >= 0 ? 'Surplus' : 'Defisit';
  const selesaiValAbs = Math.abs(selesaiSurplusDefisit).toLocaleString('id-ID');

  STATE.filteredItems = items; // dipakai openCompletionModal untuk cari index asli

  content.innerHTML = `
    <div class="cal-title">Rangkuman Realisasi Pencapaian Seluruh Program Anti Blackout</div>
    <div class="scurve-summary-row">
      <div class="scurve-summary-chart-col">
        <div id="scurveSummaryBar"></div>
        <div class="scurve-wrap scurve-summary-wrap"><canvas id="scurveSummary"></canvas></div>
      </div>
      <div class="scurve-summary-cards-col">
        <div class="ce-stat-card"><div class="ce-stat-label">Target Program ABO</div><div class="ce-stat-val">${jumlahProgramCe}</div><div class="ce-stat-sub">Jumlah Target: ${totalTargetCe.toLocaleString('id-ID')}</div></div>
        <div class="ce-stat-card accent-red clickable" onclick="openCompletionModal('belum')"><div class="ce-stat-label">Belum Selesai</div><div class="ce-stat-val">${belumSelesaiCount}</div><div class="ce-stat-sub">Sisa Target: ${belumSelesaiSisaTarget.toLocaleString('id-ID')}</div></div>
        <div class="ce-stat-card accent-green clickable" onclick="openCompletionModal('selesai')"><div class="ce-stat-label">Selesai</div><div class="ce-stat-val">${selesaiCount}</div><div class="ce-stat-sub">${selesaiLabel}: ${selesaiValAbs}</div></div>
      </div>
    </div>
  ` + streams.map(s=>{
    const streamItems = items.filter(it => it.stream === s);
    if(!streamItems.length) return '';
    const onTargetCount = streamItems.filter(it => statusAccent(it.status)==='green').length;
    const cardsHtml = streamItems.map((it)=>{
      const globalIdx = STATE.items.indexOf(it);
      const accent = statusAccent(it.status);
      return `<div class="prog-card accent-${accent}" onclick="openDetailModal(${globalIdx})">
        <div class="pc-name">${it.programKerja}</div>
        <div class="pc-sasaran">${it.sasaran}</div>
        ${it.lokasiProject ? `<div style="font-size:10.5px; color:var(--text-muted); margin: 3px 0 5px; display:flex; align-items:center; gap:4px;"><span style="font-size:12px;">📍</span><span style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${escapeHtml(it.lokasiProject)}</span></div>` : ''}
        <div class="pc-row">
          <span class="status-chip ${accent}">${it.status || '-'}</span>
          <span class="pc-pct">${it.pct===null?'-':it.pct.toFixed(0)+'%'}</span>
        </div>
      </div>`;
    }).join('');
    const calendarHtml = buildStreamCalendar(streamItems);
    return `
      <div class="section-block" id="${slug(s)}">
        <div class="stream-title">${STREAM_ICON[s]||'⚙️'} ${s} <span class="stream-summary">${onTargetCount}/${streamItems.length} On Target</span></div>
        <div class="prog-grid">${cardsHtml}</div>
        <div class="cal-title">Kalender &amp; Kurva S — Kumulatif Target &amp; Realisasi Stream Ini
          <span class="cal-tr-legend">T : Target &nbsp;•&nbsp; R : Realisasi</span>
          <span class="scurve-inline-legend">
            <span class="sil-item"><span class="sil-swatch target"></span>Target Kumulatif</span>
            <span class="sil-item"><span class="sil-swatch realisasi"></span>Realisasi Kumulatif</span>
          </span>
        </div>
        <div id="scurveBar-${slug(s)}"></div>
        <div class="cal-overlay-wrap" id="calWrap-${slug(s)}">
          ${calendarHtml}
          <div class="cal-overlay-canvas-box" id="calOverlayBox-${slug(s)}">
            <canvas id="scurve-${slug(s)}"></canvas>
          </div>
        </div>
      </div>`;
  }).join('');

  const summaryResult = renderSCurveChart('scurveSummary', items);
  if(summaryResult) document.getElementById('scurveSummaryBar').innerHTML = buildRealisasiPctBar(summaryResult.pct);

  // Samakan presisi tinggi kolom chart ringkasan dengan tinggi aktual kolom card (mengatasi variasi
  // tinggi konten card yang tidak selalu pas dengan asumsi CSS flex-stretch semata).
  setTimeout(()=>{
    const cardsCol = document.querySelector('.scurve-summary-cards-col');
    const barEl = document.getElementById('scurveSummaryBar');
    const chartWrap = document.querySelector('.scurve-summary-wrap');
    if(cardsCol && barEl && chartWrap){
      const targetTotalHeight = cardsCol.offsetHeight;
      const barHeight = barEl.offsetHeight + 8; // + margin bawah bar
      const newHeight = Math.max(180, targetTotalHeight - barHeight);
      chartWrap.style.height = newHeight + 'px';
      if(STATE.charts['scurveSummary']) STATE.charts['scurveSummary'].resize();
    }
  }, 50);

  streams.forEach(s=>{
    const streamItems = items.filter(it => it.stream === s);
    if(!streamItems.length) return;
    // requestAnimationFrame: pastikan layout tabel sudah benar-benar settle sebelum mengukur & membuat chart,
    // supaya tidak ada race-condition antar chart yang dibuat berurutan dalam loop yang sama (bug: hanya
    // stream pertama yang bisa di-hover, stream berikutnya tidak responsif terhadap tooltip).
    requestAnimationFrame(()=>{
      positionOverlayCanvas('calWrap-' + slug(s), 'calOverlayBox-' + slug(s));
      const result = renderSCurveChart('scurve-' + slug(s), streamItems, {minimal:true});
      const barEl = document.getElementById('scurveBar-' + slug(s));
      if(result && barEl) barEl.innerHTML = buildRealisasiPctBar(result.pct);

      // Amati perubahan ukuran tabel (mis. akibat font/zoom/reflow) dan reposisikan+resize overlay otomatis,
      // termasuk pemicu PERTAMA (penting: chart harus di-resize ulang setelah ukuran kotak overlay benar-benar
      // final, kalau tidak posisi tooltip meleset dan hover gagal total di beberapa stream).
      const tableEl = document.querySelector('#calWrap-' + slug(s) + ' table.cal-scurve');
      if(tableEl && window.ResizeObserver){
        const ro = new ResizeObserver(()=>{
          positionOverlayCanvas('calWrap-' + slug(s), 'calOverlayBox-' + slug(s));
          if(STATE.charts['scurve-'+slug(s)]) STATE.charts['scurve-'+slug(s)].resize();
        });
        ro.observe(tableEl);
      }
    });
  });

  STATE.currentStreams = streams; // dipakai oleh resize handler global

  // Pengaman tambahan: setelah semua chart & layout benar-benar settle, refresh ulang
  // posisi+ukuran semua overlay sekali lagi (menghindari sisa kasus dimana chart terlanjur
  // dibuat dengan ukuran yang belum final).
  setTimeout(()=>{
    streams.forEach(s=>{
      if(!items.some(it=>it.stream===s)) return;
      positionOverlayCanvas('calWrap-' + slug(s), 'calOverlayBox-' + slug(s));
      if(STATE.charts['scurve-'+slug(s)]) STATE.charts['scurve-'+slug(s)].resize();
    });
  }, 300);
}

// Reposisikan semua overlay Kurva-S saat window di-resize (didaftarkan sekali saja, bukan per renderContent)
window.addEventListener('resize', ()=>{
  (STATE.currentStreams||[]).forEach(s=>{
    positionOverlayCanvas('calWrap-' + slug(s), 'calOverlayBox-' + slug(s));
    if(STATE.charts['scurve-'+slug(s)]) STATE.charts['scurve-'+slug(s)].resize();
  });
});

async function loadCommonEnemy(){
  const content = document.getElementById('content');
  if(!CE_CSV_URL || !CE_CSV_URL.trim()){
    content.innerHTML = `
      <div style="background:var(--bg-card); border:1px solid var(--border-color); border-radius:12px; padding:60px 24px; text-align:center; max-width:680px; margin:40px auto; box-shadow:var(--card-shadow);">
        <div style="font-size:48px; margin-bottom:14px; opacity:0.8;">⚡</div>
        <h3 style="font-size:18px; font-weight:800; color:var(--text-main); margin-bottom:8px;">Sumber Data Program Anti Blackout Belum Dikonfigurasi</h3>
        <p style="font-size:13.5px; color:var(--text-muted); line-height:1.6; margin-bottom:20px;">
          Sumber data CSV untuk modul Program Anti Blackout (ABO) belum diatur atau dinonaktifkan di menu <b>Sumber Data</b> pada Panel Admin. Data program kerja Sub Initiative tidak ditampilkan.
        </p>
      </div>`;
    const sb = document.getElementById('sidebarStreamList');
    if(sb) sb.innerHTML = '<div class="sb-group-title">Stream</div><div style="padding:16px 20px; font-size:12px; color:var(--text-muted);">Tidak ada data</div>';
    return;
  }
  try{
    const rows = await fetchCsvRows(CE_CSV_URL);

    // Live Update memakai jam berjalan (sama seperti index.html) — CSV publish Google Sheets
    // tidak menyertakan metadata "terakhir diedit", jadi menebak dari isi sel tidak bisa diandalkan.

    const headerRow = rows[3] || [];
    const customCols = [];
    const knownAboCols = new Set([
      'no', 'bagian', 'sub initiative', 'program kerja abo 2026', 'satuan', 'catt', 'target total',
      'target bulanan 2026', 'realisasi bulanan 2026', 'target kumulatif 2026', 'realisasi kumulatif 2026',
      'target 1 tahun', 'target kumulatif', 'realisasi kumulatif', '% capaian', 'status', 'kendala', 'lokasi project', 'justisikasi', 'justifikasi',
      'kolom_1', 'kolom_2'
    ]);

    for (let c = 0; c < headerRow.length; c++) {
      const h = (headerRow[c] || '').trim();
      const hl = h.toLowerCase();
      if (h && !knownAboCols.has(hl) && !/^(jan|feb|mar|apr|mei|jun|jul|agu|sep|okt|nov|des)$/i.test(hl)) {
        const matchBracket = h.match(/^\[(.*?)\]\s*(.*)$/);
        if (matchBracket) {
          customCols.push({ idx: c, section: matchBracket[1].trim(), name: matchBracket[2].trim(), rawName: h });
        } else {
          const matchParen = h.match(/^(.*?)\s*\((.*?)\)$/);
          if (matchParen && !/^\d+|^1\s*tahun|%|rp/i.test(matchParen[2].trim())) {
            customCols.push({ idx: c, section: matchParen[2].trim(), name: matchParen[1].trim(), rawName: h });
          } else {
            customCols.push({ idx: c, section: 'ALL', name: h, rawName: h });
          }
        }
      }
    }

    const items = [];
    rows.forEach(row=>{
      const stream = (row[1]||'').trim(); // Bagian = kolom B
      if(!stream || !/^[0-9]+$/.test((row[0]||'').trim())) return;
      const rawSatuan = (row[5]||'').trim();
      const isPersen = rawSatuan === '%' || rawSatuan.toLowerCase() === 'persen';
      // Kalender BULANAN (bukan mingguan): Target = H:S (index 7-18, 12 bulan), Realisasi = T:AE (index 19-30, 12 bulan)
      const targetCal = [], realisasiCal = [];
      for(let i=0;i<12;i++){
        let t = parseFloat((row[7+i]||'0').toString().replace(',','.')) || 0;
        let r = parseFloat((row[19+i]||'0').toString().replace(',','.')) || 0;
        if(isPersen){ t = t/100; r = r/100; }
        targetCal.push(t);
        realisasiCal.push(r);
      }

      const customFields = {};
      let customLokasi = (row[61]||'').trim();
      let customKendala = (row[60]||'').trim();

      customCols.forEach(cc => {
        // Only apply if column is scoped to this bagian or is global (ALL)
        if (cc.section === 'ALL' || cc.section.toLowerCase() === stream.toLowerCase()) {
          const val = (row[cc.idx] || '').trim();
          if (val) {
            customFields[cc.name] = val;
            const lowerName = cc.name.toLowerCase();
            if (lowerName.includes('lokasi')) {
              customLokasi = val;
            } else if (lowerName.includes('kendala')) {
              customKendala = val;
            }
          }
        }
      });

      items.push({
        sasaran: (row[2]||'').trim() || (row[1]||'').trim(),
        stream,
        programKerja: (row[3]||'').trim(), // Program Kerja ABO 2026 = kolom D
        satuan: /^[A-Za-z\s%.\/-]{1,15}$/.test(rawSatuan) ? rawSatuan : '',
        targetTotal: row[55]||'0',        // Target Total (1 Tahun) = kolom BD
        targetKumulatif: row[56]||'0',    // Target Kumulatif = kolom BE
        realisasi: row[57]||'0',          // Realisasi Kumulatif = kolom BF
        pct: parsePct(row[58]),           // % Capaian = kolom BG
        status: (row[59]||'').trim(),     // Status = kolom BH
        kendala: customKendala,           // Kendala = kolom BI
        lokasiProject: customLokasi,      // Lokasi Project = kolom BJ (col 61)
        justifikasi: (row[62]||'').trim(),// Justifikasi = kolom BK
        customFields,
        targetCal, realisasiCal
      });
    });
    STATE.items = items;

    if(!items.length){ content.innerHTML = '<div class="loading">Tidak ada data program kerja terbaca.</div>'; return; }

    // Kelompokkan per stream, urutan sesuai kemunculan pertama di data
    const streams = [];
    items.forEach(it=>{ if(!streams.includes(it.stream)) streams.push(it.stream); });

    // Sidebar
    const sidebarEl = document.getElementById('sidebarStreamList');
    sidebarEl.innerHTML = '<div class="sb-group-title">Stream</div>' + streams.map(s =>
      `<a onclick="scrollToStream(this,'${slug(s)}')">${STREAM_ICON[s]||'⚙️'} ${s}</a>`
    ).join('');

    renderContent();
  }catch(e){
    content.innerHTML = '<div class="err">Gagal memuat data Program Anti Blackout — ' + e.message + '</div>';
  }
}
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

// Hero mengecil saat scroll turun dengan HYSTERESIS (mencegah glitch/jitter saat scroll perlahan)
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
  if(typeof updateTopbarHeight === 'function') updateTopbarHeight();
}
function onScrollHero(){
  if(scrollTicking) return;
  scrollTicking = true;
  requestAnimationFrame(applyHeroScrollState);
}
window.addEventListener('scroll', onScrollHero, { passive: true });
applyHeroScrollState();

loadCommonEnemy();

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
  if(STATE.items && STATE.items.length) renderContent();
}
(function initTheme(){
  const saved = localStorage.getItem('theme') || 'light';
  document.documentElement.setAttribute('data-theme', saved);
  applyThemeUI(saved);
})();

function updateTopbarHeight(){
  const topbar = document.getElementById('topbar');
  if(topbar) document.documentElement.style.setProperty('--topbar-h', topbar.offsetHeight + 'px');
}
updateTopbarHeight();
window.addEventListener('resize', updateTopbarHeight);
window.addEventListener('load', updateTopbarHeight);

// Sidebar auto-hide: muncul saat mouse dekat tepi kiri layar, sembunyi saat mouse menjauh
(function(){
  const sidebar = document.getElementById('sidebarStreamList');
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
<script src="{{ asset('js/reactbits-animations.js') }}"></script>
@include('partials.page-access-overlay')
</body>
</html>
