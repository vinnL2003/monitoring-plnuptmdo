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
<title>ANOMALI HEALTH INDEX — UPT MANADO</title>
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
  .prog-card .pc-name{font-size:11px; font-weight:700; color:var(--text-main); margin-bottom:4px; line-height:1.3; min-height:28px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;}
  .prog-card .pc-sasaran{font-size:9.5px; color:var(--text-muted); margin-bottom:6px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;}
  .prog-card .pc-row{display:flex; justify-content:space-between; align-items:center;}
  .status-chip{display:inline-block; padding:2px 8px; border-radius:10px; font-size:9px; font-weight:700; color:#fff;}
  .status-chip.green{background:var(--green);}
  .status-chip.red{background:var(--red);}
  .status-chip.blue{background:var(--blue);}
  .status-chip.gray{background:var(--gray);}
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
  .ce-stat-card.accent-blue{border-left-color:var(--blue);}
  [data-theme="dark"] .ce-stat-card.accent-blue{box-shadow:var(--card-shadow), 0 0 10px rgba(59,167,255,0.15);}
  .ce-stat-card.accent-blue .ce-stat-label{color:var(--blue);}
  .ahi-summary-row{display:flex; gap:14px; flex-wrap:wrap;}
  .ahi-summary-row .ce-stat-card{flex:0 1 240px; max-width:240px; padding:8px 12px;}
  .ahi-summary-row .ce-stat-val{font-size:18px;}
  .ahi-summary-row .ce-stat-label{font-size:10.5px;}
  .ahi-summary-row .ce-stat-sub{font-size:9px;}
  .ahi-top-row{display:flex; justify-content:space-between; align-items:flex-start; gap:20px; flex-wrap:wrap; margin-bottom:0;}
  .ahi-chart-row{display:flex; gap:16px; flex-wrap:wrap;}
  .ahi-chart-row .table-wrap{flex:1; min-width:320px;}
  .kpi-chart-title{font-size:13px; font-weight:700; color:var(--pln-blue); margin-bottom:12px;}
  [data-theme="dark"] .kpi-chart-title{color:var(--pln-yellow);}
  .ahi-filter-row{display:flex; gap:16px; flex-wrap:wrap; justify-content:flex-end;}
  .ahi-filter-row label{display:block; font-size:11.5px; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:5px;}
  .ahi-filter-row select{padding:7px 10px; border:1px solid var(--border-color); border-radius:7px; background:var(--input-bg); color:var(--text-main); font-size:12.5px; font-weight:600; min-width:170px;}
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
  .cal-corner{background:var(--table-header-bg); min-width:150px; width:150px;}
  .cal-item-name{background:var(--bg-card); text-align:left !important; padding-left:8px !important; font-size:10px; font-weight:600; color:var(--text-main); min-width:150px; width:150px; vertical-align:middle;}
  .cal-row-type{font-size:8px; color:var(--text-muted); font-weight:700; min-width:46px; width:46px; white-space:nowrap;}
  .cal-row-type-target{background:rgba(0,82,156,0.08);}
  .cal-row-type-real{background:rgba(39,174,96,0.08);}
  .cal-scurve td.cal-cell-target, .cal-scurve td.cal-cell-real{width:16px; min-width:16px;}
  .cal-cell-target{background:rgba(0,82,156,0.12); font-weight:700; color:var(--pln-blue); opacity:0.35; min-width:16px; width:16px;}
  [data-theme="dark"] .cal-cell-target{color:#66B2FF; background:rgba(59,167,255,0.18);}
  .cal-cell-realisasi{background:rgba(39,174,96,0.15); font-weight:700; color:var(--green); opacity:0.35; min-width:16px; width:16px;}

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
      <a href="{{ route('ahi') }}" class="active">AHI</a>
      <a href="{{ route('common-enemy') }}">Common Enemy</a>
      <a href="{{ route('abo') }}">Program Anti Blackout</a>
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
  <aside class="sidebar" id="mainSidebar">
    <a href="#ahi-mtu" class="active"><span class="num">1.</span> AHI MTU</a>
    <a href="#ahi-relay"><span class="num">2.</span> AHI Relay</a>
    <a href="#ahi-transmisi"><span class="num">3.</span> AHI Transmisi</a>
  </aside>

<main>
  <div id="content"><div class="loading">MENGHUBUNGKAN KE SUMBER DATA...</div></div>
</main>
</div>

<footer class="{{ (($isRestricted ?? false) && !($isUnlocked ?? false)) ? 'page-restricted-blurred' : '' }}">{{ $settings['footer_text'] ?? '&copy; 2026 PT PLN (Persero) UPT Manado — Dashboard Anomali Health Index. All Rights Reserved.' }}</footer>

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
const AHI_CSV_URL = (window.APP_DATA_SOURCES && window.APP_DATA_SOURCES.ahi_csv) ? window.APP_DATA_SOURCES.ahi_csv : "";
const AHI_COLORS = { vg:'#27AE60', g:'#82C91E', f:'#F1C40F', p:'#E67E22', c:'#E74C3C' };

let STATE = { data: null, charts: {} };

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
    console.warn('[AHI fetch] Direct fetch failed for', url, err.message, 'trying proxy fallback...');
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
      console.error('[AHI fetch] Proxy fetch failed too:', err);
    }
  }
  throw new Error('Gagal mengambil data dari Google Sheets / Sumber Data');
}

function parseNum(v){
  if(v===undefined || v===null) return 0;
  const s = v.toString().replace(/[^0-9.\-]/g,'');
  const n = parseFloat(s);
  return isNaN(n) ? 0 : n;
}

// Cari sel yang isinya PERSIS sama dengan `text`, kembalikan {row,col} kemunculan pertama.
function findCell(rows, text){
  for(let r=0;r<rows.length;r++){
    for(let c=0;c<rows[r].length;c++){
      if((rows[r][c]||'').trim() === text) return {row:r, col:c};
    }
  }
  return null;
}
// Cari sel yang MENGANDUNG teks tertentu (untuk judul tabel yang panjang).
function findCellContains(rows, text){
  const upper = text.toUpperCase();
  for(let r=0;r<rows.length;r++){
    for(let c=0;c<rows[r].length;c++){
      if((rows[r][c]||'').toUpperCase().includes(upper)) return {row:r, col:c};
    }
  }
  return null;
}

// Ambil satu blok tabel AHI (PERALATAN | REALISASI | VERY GOOD | GOOD | FAIR | POOR | CRITICAL) berdasarkan
// posisi kolom "PERALATAN" yang ditemukan lewat pencarian teks (bukan index kolom tetap), supaya tetap jalan
// walau tata letak sheet berubah sedikit. Baris tepat di bawah header adalah sub-header (VERY GOOD dst),
// data dimulai 2 baris setelah baris "PERALATAN".
function parseAhiTable(rows, headerRow, peralatanCol){
  const items = [];
  for(let r=headerRow+2; r<rows.length; r++){
    const nama = (rows[r][peralatanCol]||'').trim();
    if(!nama || nama.toUpperCase().includes('POOR & CRITICAL') || nama.toUpperCase()==='TOTAL') break;
    const realisasi = parseNum(rows[r][peralatanCol+1]);
    const vg = parseNum(rows[r][peralatanCol+2]);
    const g  = parseNum(rows[r][peralatanCol+3]);
    const f  = parseNum(rows[r][peralatanCol+4]);
    const p  = parseNum(rows[r][peralatanCol+5]);
    const c  = parseNum(rows[r][peralatanCol+6]);
    items.push({ nama, realisasi, vg, g, f, p, c, anomali: p + c });
  }
  return items;
}

// Kategori Transmisi (Pentanahan/Thermovisi/CUI) memakai format realisasi/kepatuhan (%), berbeda dari
// skor AHI 1-5 milik MTU/Relay — dicari dari baris "UPT MANADO" tabel realisasi kumulatif masing-masing.
function findUltgTotalMax(rows, sectionTitleContains){
  const t = findCellContains(rows, sectionTitleContains);
  if(!t) return null;
  for(let r=t.row; r<Math.min(t.row+45, rows.length); r++){
    if((rows[r][t.col]||'').trim().toUpperCase() === 'UPT MANADO'){
      let maxVal = 0;
      for(let c=t.col+2; c<rows[r].length; c++){
        const v = parseNum(rows[r][c]);
        if(v > maxVal && v < 100000) maxVal = v;
      }
      return maxVal;
    }
  }
  return null;
}

// Klasifikasi nama peralatan ke kategori MTU / Relay (MPU, BPU, DC Sistem) sesuai definisi yang diberikan.
function classifyEquipment(nama){
  const n = (nama||'').toUpperCase().trim();
  if(n.includes('DIFFERENTIAL') || n.includes('DISTANCE') || n.includes('LINE CURRENT DIFFERENTIAL') || n.includes('LINE DIFF') || n.includes('MPU')) return {kategori:'Relay', sub:'MPU'};
  if(n.includes('OCR') || n.includes('GFR') || n.includes('REF HV') || n.includes('REF LV') || n.includes('SBEF') || n.includes('BPU') || n.includes('RELAY')) return {kategori:'Relay', sub:'BPU'};
  if(n.includes('BATERAI') || n.includes('BATTERY') || n.includes('RECTIFIER')) return {kategori:'Relay', sub:'DC Sistem'};
  
  // MTU mapping (both English and Indonesian)
  if(n === 'PMS' || n.includes('DISCONNECTING SWITCH')) return {kategori:'MTU', sub:null};
  if(n === 'PMT' || n.includes('CIRCUIT BREAKER') || n === 'PMT 20 KV') return {kategori:'MTU', sub:null};
  if(n === 'LA' || n.includes('LIGHTNING ARRESTER')) return {kategori:'MTU', sub:null};
  if(n.includes('CVT') || n.includes('POTENTIAL TRANSFORMER') || n.includes('PT 20 KV')) return {kategori:'MTU', sub:null};
  if(n === 'CT' || n.includes('CURRENT TRANSFORMER') || n.includes('CT 20 KV')) return {kategori:'MTU', sub:null};
  if(n.includes('POWER TRANSFORMER') || n.includes('TRAFO')) return {kategori:'MTU', sub:null};
  if(n.includes('CUBICLE')) return {kategori:'MTU', sub:null};
  if(n.includes('RESISTOR') || n.includes('NGR')) return {kategori:'MTU', sub:null};
  return {kategori:'MTU', sub:null};
}

// Hitung total vg/g/f/p/c satu item peralatan sesuai filter ULTG yang dipilih ('UPT MANADO' = jumlah 4 ULTG).
function sumByFilter(item, ultgFilter){
  const levels = {vg:0,g:0,f:0,p:0,c:0};
  const ultgs = ultgFilter === 'UPT MANADO' ? Object.keys(item.ultg) : [ultgFilter];
  ultgs.forEach(u=>{
    const d = item.ultg[u];
    if(!d) return;
    levels.vg+=d.vg; levels.g+=d.g; levels.f+=d.f; levels.p+=d.p; levels.c+=d.c;
  });
  const realisasi = levels.vg+levels.g+levels.f+levels.p+levels.c;
  return { nama:item.nama, ...levels, realisasi, anomali: levels.p+levels.c };
}

async function loadAhiData(){
  const content = document.getElementById('content');
  if(!AHI_CSV_URL || !AHI_CSV_URL.trim()){
    content.innerHTML = `
      <div style="background:var(--bg-card); border:1px solid var(--border-color); border-radius:12px; padding:60px 24px; text-align:center; max-width:680px; margin:40px auto; box-shadow:var(--card-shadow);">
        <div style="font-size:48px; margin-bottom:14px; opacity:0.8;">🛡️</div>
        <h3 style="font-size:18px; font-weight:800; color:var(--text-main); margin-bottom:8px;">Sumber Data AHI Belum Dikonfigurasi</h3>
        <p style="font-size:13.5px; color:var(--text-muted); line-height:1.6; margin-bottom:20px;">
          Sumber data CSV untuk modul Anomali Health Index (AHI) belum diatur atau dinonaktifkan di menu <b>Sumber Data</b> pada Panel Admin. Data kesehatan aset transmisi tidak ditampilkan.
        </p>
      </div>`;
    return;
  }
  try{
    const rows = await fetchCsvRows(AHI_CSV_URL, 3500);
    if(!rows || rows.length < 5) throw new Error('Data yang diterima terlalu sedikit (' + (rows?rows.length:0) + ' baris)');
    console.log('[AHI debug] Total baris diterima:', rows.length);

    const ULTG_NAMES = ['SAWANGAN', 'LOPANA', 'KOTAMOBAGU', 'GORONTALO'];
    const equipmentMap = {};

    const ensureItem = (name) => {
      const clean = name.replace(/\*/g,'').trim();
      const key = clean.toUpperCase();
      if(!equipmentMap[key]){
        equipmentMap[key] = {
          nama: clean,
          ultg: {
            SAWANGAN: {vg:0,g:0,f:0,p:0,c:0},
            LOPANA: {vg:0,g:0,f:0,p:0,c:0},
            KOTAMOBAGU: {vg:0,g:0,f:0,p:0,c:0},
            GORONTALO: {vg:0,g:0,f:0,p:0,c:0}
          }
        };
      }
      return equipmentMap[key];
    };

    // 1. Scan Section 2: KONDISI PERALATAN PER ULTG (per-ULTG breakdown)
    const scoreKeys = ['vg','g','f','p','c'];
    for(let r=0; r<rows.length; r++){
      // Left side equipment block (col 2)
      const leftName = (rows[r][2]||'').trim();
      if(leftName && !['AHI','TOTAL','PERALATAN','MAIN TRANSMISSION UNIT','SUMMARY KONDISI PERALATAN','KONDISI PERALATAN PER ULTG'].includes(leftName) && !leftName.includes(' - ')){
        if(rows[r+1] && (rows[r+1][2]||'').includes('AHI')){
          const item = ensureItem(leftName);
          for(let k=0; k<5; k++){
            const rowIdx = r + 3 + k;
            if(rows[rowIdx]){
              for(let u=0; u<4; u++){
                const val = parseNum(rows[rowIdx][3+u]);
                item.ultg[ULTG_NAMES[u]][scoreKeys[k]] = val;
              }
            }
          }
        }
      }

      // Right side equipment block (col 16)
      const rightName = (rows[r][16]||'').trim();
      if(rightName && !['AHI','TOTAL','PERALATAN','PROTECTION RELAY'].includes(rightName) && !rightName.includes(' - ')){
        if(rows[r+1] && (rows[r+1][16]||'').includes('AHI')){
          const item = ensureItem(rightName);
          for(let k=0; k<5; k++){
            const rowIdx = r + 3 + k;
            if(rows[rowIdx]){
              for(let u=0; u<4; u++){
                const val = parseNum(rows[rowIdx][17+u]);
                item.ultg[ULTG_NAMES[u]][scoreKeys[k]] = val;
              }
            }
          }
        }
      }
    }

    // 2. Scan Section 1: SUMMARY KONDISI PERALATAN (for summary totals if ULTG blocks were missing or 0)
    for(let r=0; r<Math.min(30, rows.length); r++){
      const leftEq = (rows[r][2]||'').trim();
      if(leftEq && !['AHI','TOTAL','PERALATAN','MAIN TRANSMISSION UNIT','SUMMARY KONDISI PERALATAN','KONDISI PERALATAN PER ULTG','VERY GOOD'].includes(leftEq)){
        const cls = classifyEquipment(leftEq);
        if(cls.kategori){
          const item = ensureItem(leftEq);
          let curSum = 0;
          ULTG_NAMES.forEach(u=>{ curSum += item.ultg[u].vg + item.ultg[u].g + item.ultg[u].f + item.ultg[u].p + item.ultg[u].c; });
          if(curSum === 0){
            const vg = parseNum(rows[r][4]), g = parseNum(rows[r][5]), f = parseNum(rows[r][6]), p = parseNum(rows[r][7]), c = parseNum(rows[r][8]);
            item.ultg.SAWANGAN.vg = vg; item.ultg.SAWANGAN.g = g; item.ultg.SAWANGAN.f = f; item.ultg.SAWANGAN.p = p; item.ultg.SAWANGAN.c = c;
          }
        }
      }
      const rightEq = (rows[r][16]||'').trim();
      if(rightEq && !['AHI','TOTAL','PERALATAN','PROTECTION RELAY','VERY GOOD'].includes(rightEq)){
        const cls = classifyEquipment(rightEq);
        if(cls.kategori){
          const item = ensureItem(rightEq);
          let curSum = 0;
          ULTG_NAMES.forEach(u=>{ curSum += item.ultg[u].vg + item.ultg[u].g + item.ultg[u].f + item.ultg[u].p + item.ultg[u].c; });
          if(curSum === 0){
            const vg = parseNum(rows[r][18]), g = parseNum(rows[r][19]), f = parseNum(rows[r][20]), p = parseNum(rows[r][21]), c = parseNum(rows[r][22]);
            item.ultg.SAWANGAN.vg = vg; item.ultg.SAWANGAN.g = g; item.ultg.SAWANGAN.f = f; item.ultg.SAWANGAN.p = p; item.ultg.SAWANGAN.c = c;
          }
        }
      }
    }

    const allItems = Object.values(equipmentMap);
    console.log('[AHI debug] Total allItems siap render:', allItems.length);

    // Transmisi
    const transmisi = { pentanahan:null, thermovisi:null, cui:null };
    for(let r=0; r<rows.length; r++){
      for(let c=0; c<rows[r].length; c++){
        const cell = (rows[r][c]||'').trim().toUpperCase();
        if(cell.includes('TOTAL JUMLAH TOWER')){
          transmisi.pentanahan = {
            totalTower: parseNum(rows[r][c+2]),
            dg: parseNum(rows[r][c+3]), igrass: parseNum(rows[r][c+4]), tla: parseNum(rows[r][c+5]),
            unblnc: parseNum(rows[r][c+6]), resetArc: parseNum(rows[r][c+7]),
            pctDg: (rows[r+1] && rows[r+1][c+3]) ? rows[r+1][c+3].trim() : '38.13%'
          };
          break;
        }
      }
      if(transmisi.pentanahan) break;
    }
    transmisi.thermovisi = findUltgTotalMax(rows, 'THERMOVISI TITIK SAMBUNGAN');
    transmisi.cui = findUltgTotalMax(rows, 'REALISASI PELAKSANAAN CUI');

    STATE.data = { allItems, transmisi };
    renderAll();
  }catch(e){
    content.innerHTML = '<div class="err" style="padding:20px;">Gagal memuat data AHI — ' + e.message + '</div>';
  }
}


STATE.ultgFilter = 'UPT MANADO';
STATE.viewMode = 'jumlah'; // 'jumlah' atau 'persen'
STATE.kondisiFilter = 'semua'; // 'semua','vg','g','f','p','c'

function onAhiFilterChange(){
  STATE.ultgFilter = document.getElementById('ultgFilterSelect').value;
  renderAll();
}
function onAhiViewModeChange(){
  STATE.viewMode = document.getElementById('viewModeSelect').value;
  renderAll();
}
function onAhiKondisiChange(){
  STATE.kondisiFilter = document.getElementById('kondisiFilterSelect').value;
  renderAll();
}

function renderAll(){
  const content = document.getElementById('content');
  const { allItems, transmisi } = STATE.data;

  // Terapkan filter ULTG ke semua item, lalu klasifikasikan ke MTU / Relay
  const computed = allItems.map(item=>{
    const v = sumByFilter(item, STATE.ultgFilter);
    const cls = classifyEquipment(item.nama);
    return { ...v, kategori: cls.kategori, sub: cls.sub };
  }).filter(it=>it.realisasi > 0);

  const mtuItems = computed.filter(it=>it.kategori==='MTU').sort((a,b)=>b.anomali-a.anomali);
  const relayItemsRaw = computed.filter(it=>it.kategori==='Relay');
  const RELAY_ORDER = ['MPU (HV)','MPU (LV)','BPU (HV)','BPU (LV)','MPU OUTGOING','BATTERY','RECTIFIER'];
  const relayOrderIdx = n => { const i = RELAY_ORDER.findIndex(x=>x.toUpperCase()===n.toUpperCase()); return i===-1?999:i; };
  const relayItems = relayItemsRaw.sort((a,b)=> relayOrderIdx(a.nama) - relayOrderIdx(b.nama));

  const totalAnomali = computed.reduce((s,i)=>s+i.anomali,0);
  const totalRealisasi = computed.reduce((s,i)=>s+i.realisasi,0);
  const anomaliPct = totalRealisasi > 0 ? (totalAnomali/totalRealisasi*100).toFixed(1) : '0';
  const pt = transmisi.pentanahan;

  content.innerHTML = `
    <div id="ringkasan-ahi" style="scroll-margin-top:calc(var(--topbar-h,0px) + 12px);"></div>
    <div class="table-wrap" style="padding:14px 18px; margin-bottom:24px;">
      <div class="ahi-top-row">
        <div class="ahi-summary-row">
          <div class="ce-stat-card accent-red"><div class="ce-stat-label">% Anomali (Poor + Critical)</div><div class="ce-stat-val">${anomaliPct}%</div><div class="ce-stat-sub">${totalAnomali} Aset dari ${totalRealisasi} Total Aset</div></div>
          <div class="ce-stat-card accent-blue"><div class="ce-stat-label">Tower Pentanahan di Atas Standar</div><div class="ce-stat-val">${pt ? pt.dg.toLocaleString('id-ID') : '-'}</div><div class="ce-stat-sub">${pt ? 'dari '+pt.totalTower.toLocaleString('id-ID')+' tower ('+(pt.pctDg||'-')+')' : 'data tidak ditemukan'}</div></div>
        </div>
        <div class="ahi-filter-row">
          <div>
            <label for="ultgFilterSelect">Filter AHI Peralatan</label>
            <select id="ultgFilterSelect" onchange="onAhiFilterChange()">
              <option value="UPT MANADO" ${STATE.ultgFilter==='UPT MANADO'?'selected':''}>UPT Manado (Jumlah 4 ULTG)</option>
              <option value="SAWANGAN" ${STATE.ultgFilter==='SAWANGAN'?'selected':''}>ULTG Sawangan</option>
              <option value="LOPANA" ${STATE.ultgFilter==='LOPANA'?'selected':''}>ULTG Lopana</option>
              <option value="KOTAMOBAGU" ${STATE.ultgFilter==='KOTAMOBAGU'?'selected':''}>ULTG Kotamobagu</option>
              <option value="GORONTALO" ${STATE.ultgFilter==='GORONTALO'?'selected':''}>ULTG Gorontalo</option>
            </select>
          </div>
          <div>
            <label for="kondisiFilterSelect">Filter Kondisi</label>
            <select id="kondisiFilterSelect" onchange="onAhiKondisiChange()">
              <option value="semua" ${STATE.kondisiFilter==='semua'?'selected':''}>Semua Kondisi</option>
              <option value="vg" ${STATE.kondisiFilter==='vg'?'selected':''}>Very Good</option>
              <option value="g" ${STATE.kondisiFilter==='g'?'selected':''}>Good</option>
              <option value="f" ${STATE.kondisiFilter==='f'?'selected':''}>Fair</option>
              <option value="p" ${STATE.kondisiFilter==='p'?'selected':''}>Poor</option>
              <option value="c" ${STATE.kondisiFilter==='c'?'selected':''}>Critical</option>
            </select>
          </div>
          <div>
            <label for="viewModeSelect">Tampilkan Dalam</label>
            <select id="viewModeSelect" onchange="onAhiViewModeChange()">
              <option value="jumlah" ${STATE.viewMode==='jumlah'?'selected':''}>Jumlah (Unit)</option>
              <option value="persen" ${STATE.viewMode==='persen'?'selected':''}>Persentase (%)</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <div id="ahi-mtu" style="scroll-margin-top:calc(var(--topbar-h,0px) + 12px);"></div>
    <div class="ahi-chart-row">
      <div class="table-wrap" style="padding:18px;">
        <div class="kpi-chart-title">AHI MTU (Main Transmission Unit)</div>
        <div style="position:relative; height:380px;"><canvas id="chartMtu"></canvas></div>
      </div>
      <div class="table-wrap" style="padding:18px;">
        <div id="ahi-relay" style="scroll-margin-top:calc(var(--topbar-h,0px) + 12px);"></div>
        <div class="kpi-chart-title">AHI Relay (MPU, BPU, DC Sistem)</div>
        <div style="position:relative; height:380px;"><canvas id="chartRelay"></canvas></div>
      </div>
    </div>

    <div class="module-title" id="ahi-transmisi" style="scroll-margin-top:calc(var(--topbar-h,0px) + 12px); margin-top:24px;">INDEX TRANSMISI (PENTANAHAN, THERMOVISI, CLIMB UP INSPECTION)</div>
    <div class="table-wrap" style="padding:18px;">
      <div style="margin-bottom:14px; font-size:12px; color:var(--text-muted);">
        Catatan: kategori Transmisi diukur dengan basis berbeda dari MTU/Relay — bukan skor AHI 1-5, melainkan persentase realisasi/kepatuhan terhadap standar pemeliharaan (belum mengikuti filter ULTG di atas).
      </div>
      <div class="ahi-summary-row">
        <div class="ce-stat-card accent-red">
          <div class="ce-stat-label">Pentanahan di Atas Standar</div>
          <div class="ce-stat-val">${pt ? pt.dg.toLocaleString('id-ID') : '-'}</div>
          <div class="ce-stat-sub">${pt ? 'Tower kategori DG dari '+pt.totalTower.toLocaleString('id-ID')+' tower ('+(pt.pctDg||'-')+')' : 'data tidak ditemukan di sheet ini'}</div>
        </div>
        <div class="ce-stat-card">
          <div class="ce-stat-label">Thermovisi Titik Sambungan</div>
          <div class="ce-stat-val">${transmisi.thermovisi!==null ? transmisi.thermovisi.toLocaleString('id-ID') : '-'}</div>
          <div class="ce-stat-sub">Titik sambungan diukur (kumulatif tahun berjalan)</div>
        </div>
        <div class="ce-stat-card">
          <div class="ce-stat-label">Climb Up Inspection (CUI)</div>
          <div class="ce-stat-val">${transmisi.cui!==null ? transmisi.cui.toLocaleString('id-ID') : '-'}</div>
          <div class="ce-stat-sub">Tower telah di-CUI (kumulatif tahun berjalan)</div>
        </div>
      </div>
    </div>
  `;

  renderAhiChart('chartMtu', mtuItems);
  renderAhiChart('chartRelay', relayItems);
}

function renderAhiChart(canvasId, items){
  const canvas = document.getElementById(canvasId);
  if(!canvas) return;
  if(STATE.charts[canvasId]) STATE.charts[canvasId].destroy();
  const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
  const tickColor = isDark ? '#CBD5E1' : '#4A5568';
  const gridColor = isDark ? 'rgba(255,255,255,0.08)' : 'rgba(0,0,0,0.06)';
  const isPct = STATE.viewMode === 'persen';

  function val(it, field){
    if(!isPct) return it[field];
    return it.realisasi > 0 ? +(it[field]/it.realisasi*100).toFixed(1) : 0;
  }

  const ALL_DATASETS = [
    { key:'vg', label:'Very Good', color:AHI_COLORS.vg },
    { key:'g',  label:'Good',      color:AHI_COLORS.g },
    { key:'f',  label:'Fair',      color:AHI_COLORS.f },
    { key:'p',  label:'Poor',      color:AHI_COLORS.p },
    { key:'c',  label:'Critical',  color:AHI_COLORS.c }
  ];
  const activeDatasets = STATE.kondisiFilter === 'semua'
    ? ALL_DATASETS
    : ALL_DATASETS.filter(d=>d.key===STATE.kondisiFilter);

  STATE.charts[canvasId] = new Chart(canvas, {
    type: 'bar',
    data: {
      labels: items.map(i=>i.nama),
      datasets: activeDatasets.map(d=>(
        { label:d.label, data: items.map(i=>val(i,d.key)), backgroundColor: d.color, stack:'s' }
      ))
    },
    options: {
      indexAxis: 'x', // grafik bar VERTIKAL
      responsive: true, maintainAspectRatio:false,
      plugins:{
        legend:{ position:'top', labels:{ color:tickColor, font:{size:11}, usePointStyle:true } },
        datalabels:{
          display: (ctx)=> ctx.dataset.data[ctx.dataIndex] > 0,
          color:'#fff', font:{size:9,weight:'700'},
          formatter:(v)=> isPct ? v+'%' : v
        },
        tooltip:{
          callbacks:{
            afterBody:(ctxItems)=>{
              const idx = ctxItems[0].dataIndex;
              const it = items[idx];
              return isPct
                ? 'Anomali (Poor + Critical): ' + (val(it,'p')+val(it,'c')) + '% (' + it.anomali + ' unit)'
                : 'Anomali (Poor + Critical): ' + it.anomali;
            }
          }
        }
      },
      scales:{
        x:{ stacked:true, ticks:{color:tickColor, font:{size:10.5}, maxRotation:45, minRotation:0}, grid:{display:false} },
        y:{ stacked:true, ticks:{color:tickColor, callback:(v)=> isPct? v+'%':v}, grid:{color:gridColor}, beginAtZero:true, max: isPct?100:undefined }
      }
    },
    plugins: window.ChartDataLabels ? [window.ChartDataLabels] : []
  });
}

loadAhiData();

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
  if(STATE.data) renderAll();
}
(function initTheme(){
  const saved = localStorage.getItem('theme') || 'light';
  document.documentElement.setAttribute('data-theme', saved);
  applyThemeUI(saved);
})();

function updateTopbarHeight(){
  const header = document.querySelector('header');
  if(header) document.documentElement.style.setProperty('--header-h', header.offsetHeight + 'px');
  const topbar = document.getElementById('topbar');
  if(topbar) document.documentElement.style.setProperty('--topbar-h', topbar.offsetHeight + 'px');
}
updateTopbarHeight();
window.addEventListener('resize', updateTopbarHeight);
window.addEventListener('load', updateTopbarHeight);

// Hero scroll shrink dengan HYSTERESIS
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
window.addEventListener('scroll', onScrollHero, {passive:true});
applyHeroScrollState();

// Live clock (Format seragam KKU)
const DAY_NAMES_EN = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
const MONTH_NAMES_EN = ['January','February','March','April','May','June','July','August','September','October','November','December'];
function updateLiveClock(){
  const el = document.getElementById('heroLiveClock') || document.getElementById('lastUpdate');
  if(!el) return;
  const now = new Date();
  const dd = now.getDate();
  const hh = String(now.getHours()).padStart(2,'0');
  const mi = String(now.getMinutes()).padStart(2,'0');
  const ss = String(now.getSeconds()).padStart(2,'0');
  el.textContent = `${DAY_NAMES_EN[now.getDay()]}, ${dd} ${MONTH_NAMES_EN[now.getMonth()]} ${now.getFullYear()}, ${hh}.${mi}.${ss}`;
}
updateLiveClock();
setInterval(updateLiveClock, 1000);

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
<!-- ReactBits Animation Suite -->
<script src="{{ asset('js/reactbits-animations.js') }}"></script>
@include('partials.page-access-overlay')
</body>
</html>
