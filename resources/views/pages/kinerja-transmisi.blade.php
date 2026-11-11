<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<script>
  (function(){
    var saved = localStorage.getItem('theme') || '{{ $settings['default_theme'] ?? 'light' }}';
    document.documentElement.setAttribute('data-theme', saved);
  })();
</script>
<title>KINERJA TRANSMISI — UPT MANADO</title>
<link rel="icon" type="image/png" href="{{ asset('Logo_UPT_Manado.png') }}?v=upt1">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=upt1">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v=upt1">
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=upt1">
<link rel="apple-touch-icon" href="{{ asset('Logo_UPT_Manado.png') }}?v=upt1">
<link rel="stylesheet" href="{{ asset('css/reactbits-animations.css') }}">
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
    --card-shadow:0 4px 6px rgba(0,0,0,0.04);
    --btn-toggle-bg:rgba(255,255,255,0.2);
    --btn-toggle-text:#FFFFFF;
    --input-bg:#FFFFFF;
    --green:#27AE60; --green-bg:rgba(39,174,96,0.12);
    --red:#E74C3C; --red-bg:rgba(231,76,60,0.12);
    --yellow:#D9A400; --yellow-bg:rgba(217,164,0,0.14);
    --purple:#8E44AD; --purple-bg:rgba(142,68,173,0.12);
    --gray:#9AA5B1; --gray-bg:rgba(154,165,177,0.12);
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
    --table-header-bg:#263449;
    --card-shadow:0 4px 6px rgba(0,0,0,0.3);
    --btn-toggle-bg:#334155;
    --btn-toggle-text:#FFC72C;
    --input-bg:#1E293B;
    --green:#2ECC71; --green-bg:rgba(46,204,113,0.18);
    --red:#FF6B6B; --red-bg:rgba(255,107,107,0.16);
    --yellow:#FFD23F; --yellow-bg:rgba(255,210,63,0.16);
    --purple:#C98BFF; --purple-bg:rgba(201,139,255,0.16);
    --gray:#94A3B8; --gray-bg:rgba(148,163,184,0.16);
  }

  *{box-sizing:border-box;margin:0;padding:0;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;transition:background-color .25s ease,color .25s ease,border-color .25s ease;}
  html,body{background:var(--bg-body);color:var(--text-main);min-height:100vh;line-height:1.5;overflow-anchor:none;}

  .theme-toggle-btn{
    background:var(--btn-toggle-bg); color:var(--btn-toggle-text);
    border:1px solid rgba(255,255,255,0.25);
    padding:6px 14px; border-radius:20px; cursor:pointer;
    font-size:12px; font-weight:600;
    display:flex; align-items:center; gap:6px;
  }

  .eyebrow{font-size:12px; letter-spacing:2px; color:var(--pln-blue); font-weight:700; margin-bottom:6px; text-transform:uppercase;}
  [data-theme="dark"] .eyebrow{color:var(--pln-yellow);}
  h1{font-size:clamp(20px,4vw,28px); letter-spacing:0.5px; margin-bottom:6px; color:var(--text-main);}
  .sub{font-size:13px; color:var(--text-muted); margin-bottom:22px;}

  .toolbar{display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:14px; margin-bottom:18px; font-size:12px; color:var(--text-muted);}
  .toolbar button{
    background:var(--bg-card); border:1px solid var(--border-color); color:var(--text-main);
    padding:7px 14px; font-family:inherit; font-size:12px; font-weight:600; border-radius:6px; cursor:pointer;
    box-shadow:var(--card-shadow);
  }
  .toolbar button:hover{border-color:var(--pln-blue); color:var(--pln-blue);}
  [data-theme="dark"] .toolbar button:hover{border-color:var(--pln-yellow); color:var(--pln-yellow);}

  .detail-toggle-btn{
    background:var(--bg-card); border:1px solid var(--border-color); color:var(--pln-blue);
    padding:5px 12px; font-size:11.5px; font-weight:600; border-radius:6px; cursor:pointer;
    box-shadow:var(--card-shadow);
  }
  [data-theme="dark"] .detail-toggle-btn{color:var(--pln-yellow);}
  .detail-toggle-btn:hover{border-color:var(--pln-blue);}
  [data-theme="dark"] .detail-toggle-btn:hover{border-color:var(--pln-yellow);}
  .period-select{display:flex; align-items:center; gap:8px;}
  .period-select select{
    background:var(--input-bg); color:var(--text-main); border:1px solid var(--border-color);
    font-family:inherit; font-size:12px; font-weight:600; padding:7px 12px; border-radius:6px; cursor:pointer;
    box-shadow:var(--card-shadow);
  }
  .period-note{font-size:11px; color:var(--text-muted); max-width:300px; line-height:1.4;}

  .legend{display:flex; flex-wrap:wrap; gap:14px; margin-bottom:18px; font-size:12px; color:var(--text-muted);}
  .legend span{display:flex; align-items:center; gap:5px;}
  .dot{width:9px; height:9px; border-radius:50%; display:inline-block;}

  .summary-title{font-size:13px; letter-spacing:1.5px; color:var(--pln-blue); font-weight:700; text-transform:uppercase; margin:26px 0 12px;}
  [data-theme="dark"] .summary-title{color:var(--pln-yellow);}
  .summary-grid{display:grid; grid-template-columns:repeat(5,1fr); gap:10px; margin-bottom:10px;}
  .summary-card{background:var(--bg-card); border:1px solid var(--border-color); border-radius:8px; padding:11px 12px; box-shadow:var(--card-shadow); position:relative; min-height:120px;}
  @media (max-width:900px){ .summary-grid{grid-template-columns:repeat(auto-fit,minmax(120px,1fr));} }
  .summary-card .unit-name{font-size:15px; letter-spacing:0.3px; color:var(--pln-blue); text-transform:uppercase; font-weight:800; margin-bottom:2px; padding-right:44px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;}
  [data-theme="dark"] .summary-card .unit-name{color:var(--pln-yellow);}
  .fois-val{font-size:20px; font-weight:800; color:var(--pln-blue);}
  [data-theme="dark"] .fois-val{color:var(--pln-yellow);}
  .fois-unit{font-size:11px; font-weight:600; color:var(--text-muted); margin-left:2px;}
  .fois-total-grid{grid-template-columns:repeat(5,1fr);}
  @media (max-width:900px){ .fois-total-grid{grid-template-columns:repeat(auto-fit,minmax(110px,1fr));} }
  .fois-total-card{display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; padding:14px 8px;}
  .fois-total-card .unit-name{font-size:clamp(10px,2.6vw,13px); white-space:normal; margin-bottom:8px; padding-right:0;}
  .fois-total-card .fois-val{font-size:clamp(16px,3.6vw,20px);}

  .nko-label{font-size:9.5px; letter-spacing:0.5px; color:var(--text-muted); text-transform:uppercase; text-align:center; margin-top:8px;}
  .nko-row{display:flex; align-items:baseline; justify-content:center; gap:8px; margin-top:2px;}
  .nko-val{font-size:32px; font-weight:800; color:var(--pln-blue); text-align:center; line-height:1.1;}
  [data-theme="dark"] .nko-val{color:var(--pln-yellow);}
  .nko110-wrap{display:flex; flex-direction:column; align-items:center; line-height:1.1;}
  .nko110-label{font-size:8px; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.3px;}
  .nko110-val{font-size:20px; font-weight:700; color:var(--text-muted);}

  .tl-indicator{position:absolute; top:10px; right:10px; display:flex; flex-direction:column; gap:5px;}
  .tl-dot{
    width:30px; height:30px; border-radius:50%; display:flex; align-items:center; justify-content:center;
    font-size:12px; font-weight:800; color:#fff; box-shadow:inset 0 -2px 4px rgba(0,0,0,0.15);
  }
  [data-theme="dark"] .tl-dot{color:#0A2540;}
  .tl-dot.green{background:#27AE60;}
  .tl-dot.yellow{background:#D9A400;}
  .tl-dot.red{background:#E74C3C;}
  .tl-dot.clickable{cursor:pointer;}
  .tl-dot.clickable:hover{box-shadow:inset 0 -2px 4px rgba(0,0,0,0.15), 0 0 0 2px rgba(0,0,0,0.18);}
  .summary-card .rowline{display:flex; justify-content:space-between; font-size:12px; margin-bottom:4px; color:var(--text-muted);}
  .summary-card .rowline b{color:var(--text-main);}
  .badges{display:flex; gap:4px; margin-top:4px; flex-wrap:wrap;}
  .badge{font-size:10px; padding:2px 6px; border-radius:5px; border:1px solid var(--border-color); display:flex; align-items:center; gap:3px; font-weight:600; color:var(--text-main);}

  .cat-title{font-size:13px; letter-spacing:1.5px; color:var(--text-main); font-weight:700; text-transform:uppercase; border-bottom:2px solid var(--border-color); padding:10px 0 8px; margin:24px 0 14px;}
  .module-title{
    font-size:15px; font-weight:700; letter-spacing:0.5px; color:#fff; margin:40px 0 6px;
    background:var(--pln-blue); padding:10px 16px; border-radius:8px 8px 0 0; border-left:4px solid var(--pln-yellow);
  }
  .table-wrap{background:var(--bg-card); border:1px solid var(--border-color); border-radius:0 0 8px 8px; box-shadow:var(--card-shadow); overflow-x:auto;}
  table{width:100%; border-collapse:collapse; font-size:13px;}
  th{text-align:left; color:var(--text-main); font-weight:700; letter-spacing:0.3px; padding:10px 12px; background:var(--table-header-bg); font-size:11px; text-transform:uppercase; white-space:nowrap;}
  td{padding:9px 12px; border-top:1px solid var(--border-color); vertical-align:middle;}
  tr:hover td{background:var(--table-header-bg);}
  .name{color:var(--text-main); font-weight:500;}
  .name .src{color:var(--pln-blue); font-size:9px; margin-left:5px;}
  [data-theme="dark"] .name .src{color:var(--pln-yellow);}
  .unit{color:var(--text-muted); font-size:12px; white-space:nowrap;}
  .score-cell{display:flex; align-items:center; gap:7px; white-space:nowrap; font-weight:600;}
  .flag{width:8px; height:8px; border-radius:50%; flex-shrink:0;}
  .flag.green{background:var(--green); box-shadow:0 0 5px var(--green);}
  .flag.red{background:var(--red); box-shadow:0 0 5px var(--red);}
  .flag.yellow{background:var(--yellow); box-shadow:0 0 5px var(--yellow);}
  .flag.purple{background:var(--purple); box-shadow:0 0 5px var(--purple);}
  .flag.gray{background:var(--gray);}

  .loading,.err{padding:40px 0; text-align:center; color:var(--text-muted); font-size:13px; letter-spacing:0.5px;}
  .err{color:var(--red);}

  .bar-row{display:flex; align-items:center; gap:10px; margin-bottom:9px;}
  .bar-label{width:130px; font-size:12px; color:var(--text-muted); flex-shrink:0;}
  .bar-track{flex:1; background:var(--table-header-bg); border-radius:4px; height:16px; overflow:hidden;}
  .bar-fill{height:100%; background:var(--pln-blue); border-radius:4px;}
  [data-theme="dark"] .bar-fill{background:var(--pln-yellow);}
  .bar-value{width:34px; text-align:right; font-size:12px; font-weight:700; color:var(--text-main);}

  .fois-2col{display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:20px; align-items:start;}
  @media (max-width:760px){.fois-2col{grid-template-columns:1fr;}}
  .fois-3col{display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px; margin-bottom:20px; align-items:start;}
  @media (max-width:980px){.fois-3col{grid-template-columns:1fr 1fr;}}
  @media (max-width:600px){.fois-3col{grid-template-columns:1fr;}}
  .fois-2col:has(.status-card), .fois-3col:has(.status-card){align-items:stretch;}
  .fois-8col{display:grid; grid-template-columns:repeat(8,1fr); gap:10px; margin-bottom:20px; align-items:stretch;}
  @media (max-width:1200px){.fois-8col{grid-template-columns:repeat(4,1fr);}}
  @media (max-width:700px){.fois-8col{grid-template-columns:repeat(2,1fr);}}
  .fois-4col{display:grid; grid-template-columns:1fr 1fr 1fr 1fr; gap:16px; margin-bottom:20px; align-items:start;}
  @media (max-width:1100px){.fois-4col{grid-template-columns:1fr 1fr;}}
  @media (max-width:600px){.fois-4col{grid-template-columns:1fr;}}
  .fois-col-title{font-size:11px; font-weight:700; letter-spacing:0.5px; color:var(--text-muted); text-transform:uppercase; margin-bottom:10px;}

  .kpi-chart-card{
    background:var(--bg-card); border:1px solid var(--border-color); border-radius:8px;
    padding:16px; box-shadow:var(--card-shadow);
  }

  .kk-toolbar{display:flex; align-items:center; gap:10px; flex-wrap:wrap; margin-bottom:16px;}
  .kk-toolbar select, .kk-toolbar button{
    background:var(--bg-card); border:1px solid var(--border-color); color:var(--text-main);
    padding:7px 14px; font-size:12.5px; border-radius:6px; cursor:pointer; font-weight:600;
  }
  .kk-toolbar button{color:var(--pln-blue);}
  [data-theme="dark"] .kk-toolbar button{color:var(--pln-yellow);}

  .kk-paper{
    background:#fff; color:#111; border:1px solid var(--border-color); box-shadow:0 4px 16px rgba(0,0,0,0.15);
    padding:10mm 12mm; width:210mm; min-height:297mm; box-sizing:border-box; margin:0 auto; overflow-x:auto;
    font-family:Arial,Helvetica,sans-serif;
  }
  .kk-paper-scroll{overflow-x:auto; padding:6px 0 16px;}
  .kk-lh-inner{width:100%; border-collapse:collapse;}
  .kk-lh-inner td{border:none !important; padding:0 !important;}
  .kk-lh-inner .kk-logo-cell{width:50px;}
  .kk-lh-inner img{height:46px; width:auto; display:block;}
  .kk-lh-text{font-size:10px; line-height:1.35; color:#0A2540; padding-left:12px !important;}
  .kk-lh-text b{font-size:11px;}
  .kk-lh-inner, .kk-lh-inner td{border:none !important;}
  .kk-paper thead tr.kk-lh-row td, .kk-paper thead tr.kk-title-row td{
    border:none !important; border-top:none !important; border-bottom:none !important; padding:0 0 4px !important;
  }
  .kk-paper h3{text-align:center; font-size:14px; font-weight:800; margin:4px 0 1px; color:#0A2540;}
  .kk-paper .kk-sub{text-align:center; font-size:11px; margin-bottom:6px; color:#333;}
  .kk-paper table{width:100%; border-collapse:collapse; font-size:7px; table-layout:fixed;}
  .kk-paper th, .kk-paper td{border:1px solid #7C8BA0; padding:1.5px 3px; vertical-align:middle; overflow:hidden;}
  .kk-paper th{background:#0A2540; color:#fff; text-align:center; font-weight:700; font-size:7px; padding:3px 2px; white-space:normal; word-wrap:break-word; overflow:visible;}
  .kk-paper td.kk-num{text-align:center; font-variant-numeric:tabular-nums;}
  .kk-paper td.kk-center{text-align:center;}
  .kk-paper td.kk-uraian{text-align:left; white-space:normal; word-wrap:break-word; overflow:visible; line-height:1.35; padding-top:3px; padding-bottom:3px;}
  .kk-paper td.kk-formula{font-size:6px; line-height:1.35; white-space:normal; word-wrap:break-word; overflow:visible; padding-top:3px; padding-bottom:3px;}
  .kk-paper tr.kk-section td{background:#FFF3B0; font-weight:800; color:#5C4A00; text-align:left; padding:2px 4px;}
  .kk-paper tr.kk-category td{background:#DCE9F7; font-weight:700; color:#0A2540;}
  .kk-paper tr.kk-total td{background:#0A2540; color:#fff; font-weight:800;}
  .kk-paper tr.kk-total-spacer td{border:none !important; padding:4px 0 !important; background:transparent;}
  .kk-paper .kk-flag-dot{display:inline-block; width:7px; height:7px; border-radius:50%;}
  .kk-paper .kk-flag-dot.green{background:#27AE60;}
  .kk-paper .kk-flag-dot.yellow{background:#D9A400;}
  .kk-paper .kk-flag-dot.red{background:#E74C3C;}
  .kk-paper .kk-flag-dot.purple{background:#8E44AD;}
  .kk-paper .kk-sign{margin-top:8px; display:flex; justify-content:flex-end;}
  .kk-paper .kk-sign-box{text-align:center; font-size:8.5px; width:190px;}
  .kk-paper .kk-sign-box .kk-sign-space{height:26px;}
  .kk-warn{background:#FFF7E6; border:1px solid #F0C36D; color:#7A5A00; padding:14px 16px; border-radius:6px; font-size:12.5px; max-width:1050px; margin:0 auto;}

  @media print{
    @page{ size:A4 portrait; margin:6mm; }
    html, body{ background:#fff !important; }
    *{ -webkit-print-color-adjust:exact !important; print-color-adjust:exact !important; color-adjust:exact !important; }
    header, .hero, .sidebar, footer, #topbar, .toolbar{ display:none !important; }
    #content > *{ display:none !important; }
    #content > .kk-print-root{ display:block !important; }
    .module-title, .cat-title, .kk-toolbar{ display:none !important; }
    main{ margin-left:0 !important; padding:0 !important; }
    .kk-paper-scroll{ overflow:visible !important; padding:0 !important; }
    .kk-paper{
      box-shadow:none !important; border:none !important; width:100% !important; min-height:0 !important;
      padding:0 !important; margin:0 !important;
    }
    .kk-paper table{ font-size:6px; }
    .kk-paper th, .kk-paper td{ padding:1px 2px; }
    .kk-paper td.kk-formula{ font-size:5.3px; }
    .kk-lh-inner img{ height:36px; }
    .kk-paper h3{ font-size:12px; }
    .kk-paper .kk-sub{ font-size:9px; margin-bottom:4px; }
  }

  .status-card{
    background:var(--bg-card); border:1px solid var(--border-color); border-radius:8px;
    padding:14px 12px; box-shadow:var(--card-shadow); display:flex; flex-direction:column; gap:6px;
    height:100%; text-align:center; align-items:center; justify-content:center;
  }
  .status-card .st-label{font-size:11px; font-weight:700; color:var(--text-main); line-height:1.25;}
  .status-card .st-row{display:flex; align-items:center; justify-content:center; gap:8px;}
  .status-card .st-dot{width:44px; height:44px; border-radius:50%; flex-shrink:0; display:flex; align-items:center; justify-content:center;}
  .status-card .st-dot-pengurang{color:#fff; font-size:10px; font-weight:800; line-height:1;}
  .status-card .st-dot.green{background:#27AE60; box-shadow:0 0 14px rgba(39,174,96,0.6);}
  .status-card .st-dot.yellow{background:#D9A400; box-shadow:0 0 14px rgba(217,164,0,0.6);}
  .status-card .st-dot.red{background:#E74C3C; box-shadow:0 0 14px rgba(231,76,60,0.6);}
  .status-card .st-dot.gray{background:var(--text-muted);}
  .status-card .st-val{font-size:16px; font-weight:800; color:var(--pln-blue); white-space:nowrap;}
  [data-theme="dark"] .status-card .st-val{color:var(--pln-yellow);}
  .status-card .st-pct{font-size:10.5px; color:var(--text-muted);}
  .kpi-chart-title{
    font-size:16px; font-weight:800; letter-spacing:0.2px; color:var(--pln-blue);
    margin-bottom:12px; min-height:40px; line-height:1.25; display:flex; align-items:center;
  }
  [data-theme="dark"] .kpi-chart-title{color:var(--pln-yellow);}

  .vbar-chart{display:flex; align-items:flex-end; gap:8px; height:240px; overflow-x:auto; padding:4px 2px 0;}
  .vbar-col{display:flex; flex-direction:column; align-items:center; justify-content:flex-end; height:100%; min-width:38px; flex:1 0 auto;}
  .vbar-value{font-size:11px; font-weight:700; margin-bottom:4px; color:var(--text-main);}
  .vbar-track{width:22px; background:var(--table-header-bg); border-radius:4px 4px 0 0; flex:1; display:flex; align-items:flex-end; overflow:hidden;}
  .vbar-fill{width:100%; background:var(--pln-blue); border-radius:4px 4px 0 0;}
  [data-theme="dark"] .vbar-fill{background:var(--pln-yellow);}
  .vbar-label{font-size:10px; color:var(--text-muted); margin-top:6px; text-align:center; max-width:60px; line-height:1.25;}

  .year-select{background:var(--bg-card); border:1px solid var(--border-color); color:var(--text-main); font-size:12px; padding:5px 10px; border-radius:6px;}

  .donut-row{display:flex; gap:16px; margin-top:18px; flex-wrap:wrap;}
  .donut-box{flex:1; min-width:150px; text-align:center;}
  .donut-box .fois-col-title{text-align:left;}
  .donut-canvas-wrap{position:relative; width:120px; height:120px; margin:0 auto;}
  .donut-center-label{position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; pointer-events:none;}
  .donut-center-label .pct{font-size:20px; font-weight:800; color:var(--pln-blue);}
  [data-theme="dark"] .donut-center-label .pct{color:var(--pln-yellow);}
  .donut-center-label .cap{font-size:9px; color:var(--text-muted); margin-top:2px; max-width:100px; line-height:1.2;}
  .donut-legend{font-size:11px; color:var(--text-muted); margin-top:10px; text-align:left;}
  .donut-legend div{display:flex; align-items:center; gap:6px; margin-bottom:3px;}
  .donut-legend .sw{width:9px; height:9px; border-radius:2px; flex-shrink:0;}
  .donut-legend-h{display:flex; flex-wrap:wrap; gap:8px 12px; justify-content:center; margin-top:12px; font-size:10.5px; color:var(--text-muted);}
  .donut-legend-h span{display:inline-flex; align-items:center; gap:5px;}
  .donut-legend-h .sw{width:9px; height:9px; border-radius:2px; flex-shrink:0;}

  .modal-overlay{display:none; position:fixed; inset:0; background:rgba(0,0,0,0.55); z-index:2000; align-items:center; justify-content:center; padding:20px;}
  .modal-box{background:var(--bg-card); border-radius:10px; max-width:520px; width:100%; max-height:80vh; display:flex; flex-direction:column; box-shadow:0 10px 40px rgba(0,0,0,0.3);}
  .modal-header{display:flex; justify-content:space-between; align-items:center; padding:16px 20px; border-bottom:1px solid var(--border-color); font-weight:700; font-size:15px; color:var(--pln-blue);}
  .modal-close{background:none; border:none; font-size:16px; cursor:pointer; color:var(--text-muted);}
  .modal-close:hover{color:var(--red);}
  .modal-body{padding:8px 20px 20px; overflow-y:auto;}
  .modal-body table{width:100%; border-collapse:collapse; font-size:13px;}
  .modal-body th{text-align:left; padding:8px 6px; font-size:10px; text-transform:uppercase; color:var(--text-muted); border-bottom:1px solid var(--border-color);}
  .modal-body td{padding:7px 6px; border-bottom:1px solid var(--border-color);}

  @media (max-width:700px){
    table{font-size:12px;}
    th,td{padding:8px 6px;}
  }
  .filter-row th{padding:5px 6px; background:var(--bg-card); border-bottom:2px solid var(--border-color);}
  .col-filter{width:100%; box-sizing:border-box; font-size:11px; padding:5px 6px; border:1px solid var(--border-color); border-radius:5px; background:var(--input-bg,var(--bg-card)); color:var(--text-main);}
  .col-filter:focus{outline:none; border-color:var(--pln-blue);}

  /* ===== HEADER (disamakan dengan index.html) ===== */
  header{
    background:var(--pln-blue); color:#fff; padding:10px 24px;
    display:flex; justify-content:space-between; align-items:center;
    box-shadow:0 2px 10px rgba(0,0,0,0.2);
    flex-wrap:wrap; gap:10px;
  }
  .header-brand{display:flex; align-items:center;}
  .logo-pln{height:32px; width:auto; object-fit:contain;}
  .header-right{display:flex; align-items:center; gap:18px; flex-wrap:wrap;}
  .header-nav{display:flex; gap:4px; flex-wrap:wrap;}
  .header-nav a{color:rgba(255,255,255,0.85); text-decoration:none; font-size:12.5px; font-weight:600; padding:7px 10px; border-radius:5px; white-space:nowrap;}
  .header-nav a:hover{color:var(--pln-yellow); background:rgba(255,255,255,0.08);}
  .header-nav a.active{color:var(--pln-yellow); background:rgba(255,255,255,0.12);}

  /* ===== HERO — UNIFORM MOVING BANNER ===== */
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
    0%{background-position:0% 50%;} 50%{background-position:100% 50%;} 100%{background-position:0% 50%;}
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
  footer{background:var(--pln-blue-dark); color:#94A3B8; text-align:center; padding:20px; font-size:12px; border-top:3px solid var(--pln-yellow); position:relative; z-index:950;}

  /* ===== PAGE TRANSITION ===== */
  body{animation: pageFadeIn .35s ease;}
  body.page-fade-out{opacity:0; transition:opacity .18s ease;}
  @keyframes pageFadeIn{ from{opacity:0; transform:translateY(6px);} to{opacity:1; transform:translateY(0);} }

  /* ===== SIDEBAR ===== */
  .page-layout{display:flex; align-items:flex-start;}
  .sidebar-hover-trigger{position:fixed; top:var(--topbar-h,0px); left:0; width:16px; height:calc(100vh - var(--topbar-h,0px)); z-index:940;}
  .sidebar{
    width:220px; flex-shrink:0; padding:16px 0;
    position:fixed; top:var(--topbar-h, 0px); left:0; z-index:950;
    height:calc(100vh - var(--topbar-h, 0px)); overflow-y:auto;
    background:rgba(255,255,255,0.72); backdrop-filter:blur(12px); -webkit-backdrop-filter:blur(12px);
    border-right:1px solid var(--border-color);
    transform:translateX(-100%); transition:transform 0.25s ease, box-shadow 0.25s ease;
  }
  [data-theme="dark"] .sidebar{background:rgba(15,23,42,0.72);}
  .sidebar.sidebar-visible{transform:translateX(0); box-shadow:4px 0 24px rgba(0,0,0,0.2);}
  .sidebar a{
    display:flex; align-items:center; gap:10px; padding:11px 20px; font-size:13px; font-weight:600;
    color:var(--text-main); text-decoration:none; border-left:3px solid transparent;
  }
  .sidebar a .num{font-size:11px; color:var(--text-muted); width:16px;}
  .sidebar a.active{background:var(--table-header-bg); border-left-color:var(--pln-blue); color:var(--pln-blue);}
  [data-theme="dark"] .sidebar a.active{color:var(--pln-yellow); border-left-color:var(--pln-yellow);}
  .sidebar a.disabled{color:var(--text-muted); cursor:default; opacity:0.55;}
  .sidebar a.disabled:hover{background:none;}
  .sidebar a:not(.disabled):not(.active):hover{background:var(--table-header-bg);}
  main{flex:1; min-width:0; max-width:none; padding:24px 24px 60px; width:100%;}
  @media (max-width:820px){
    .page-layout{flex-direction:column;}
    .sidebar{width:100%; height:auto; position:static; transform:none; backdrop-filter:none; background:var(--bg-card); display:flex; overflow-x:auto; border-right:none; border-bottom:1px solid var(--border-color);}
    .sidebar-hover-trigger{display:none;}
    .sidebar a{border-left:none; border-bottom:3px solid transparent; white-space:nowrap;}
    main{margin-left:0;}
    .sidebar a.active{border-left:none; border-bottom-color:var(--pln-blue);}
  }
</style>
</head>
<body>

<div id="topbar" class="{{ (($isRestricted ?? false) && !($isUnlocked ?? false)) ? 'topbar-locked' : '' }}">
<header>
  <div class="header-brand">
    <a href="{{ route('home') }}"><img src="{{ asset($settings['pln_logo'] ?? 'PLN_White.png') }}" alt="Logo PLN" class="logo-pln"></a>
  </div>
  <nav class="header-nav">
    @if(isset($navItems) && count($navItems) > 0)
      @foreach($navItems as $nav)
        <a href="{{ $nav->url }}" class="{{ request()->is(ltrim($nav->url, '/')) || (request()->path() == '/' && $nav->url == '/') ? 'active' : '' }}">
          {{ $nav->label }}
        </a>
      @endforeach
    @else
      <a href="{{ route('home') }}">Home</a>
      <a href="{{ route('kinerja-transmisi') }}" class="active">Kinerja Unit</a>
      <a href="{{ route('anggaran') }}">Anggaran Unit</a>
      <a href="{{ route('aset') }}">Aset</a>
      <a href="{{ route('ahi') }}">AHI</a>
      <a href="{{ route('common-enemy') }}">Common Enemy</a>
      <a href="{{ route('abo') }}">Program Anti Blackout</a>
      <a href="{{ route('konstruksi-penyaluran') }}">Konstruksi &amp; Penyaluran</a>
      <a href="{{ route('kku') }}">KKU</a>
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
    <a href="#kinerja-transmisi-top"><span class="num">1.</span> Kinerja Transmisi</a>
    <a href="#penyelesaian-slo"><span class="num">2.</span> Penyelesaian SLO</a>
    <a href="#pengendalian-ai-attb"><span class="num">3.</span> Pengendalian AI dan ATTB</a>
    <a href="#tata-kelola-aset"><span class="num">4.</span> Tata Kelola Aset</a>
    <a href="#kinerja-kku"><span class="num">5.</span> Kinerja KKU</a>
    <a href="#kepatuhan-proker-transmisi"><span class="num">6.</span> Kepatuhan Proker Transmisi</a>
    <a href="#kepatuhan"><span class="num">7.</span> Kepatuhan</a>
    <a href="#nko-unit"><span class="num">8.</span> NKO Unit</a>
  </aside>

<main>
  <div class="toolbar">
    <div class="period-select">
      <select id="periodSelect"><option>Memuat...</option></select>
    </div>
    <button id="refreshBtn">↻ REFRESH SEKARANG</button>
  </div>

  <div id="content"><div class="loading">MENGHUBUNGKAN KE SUMBER DATA...</div></div>
</main>
</div>

<footer class="{{ (($isRestricted ?? false) && !($isUnlocked ?? false)) ? 'page-restricted-blurred' : '' }}">{{ $settings['footer_text'] ?? '
  &copy; 2026 PT PLN (Persero) UPT Manado — Dashboard Kinerja Transmisi. All Rights Reserved.
' }}</footer>

<div id="modalOverlay" class="modal-overlay" onclick="if(event.target===this) closeUnitModal()">
  <div class="modal-box">
    <div class="modal-header">
      <span id="modalTitle">Detail</span>
      <button class="modal-close" onclick="closeUnitModal()">✕</button>
    </div>
    <div id="modalBody" class="modal-body"></div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.4.1/papaparse.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js"></script>
<script>
window.APP_DATA_SOURCES = @json($dataSources ?? []);

// Jam live untuk badge hero — berjalan realtime setiap detik
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

const MAIN_CSV_URL = (window.APP_DATA_SOURCES && window.APP_DATA_SOURCES.kinerja_transmisi_csv !== undefined)
  ? window.APP_DATA_SOURCES.kinerja_transmisi_csv
  : "https://docs.google.com/spreadsheets/d/e/2PACX-1vQ7Ovm3gLoamwHFdoj8FI_bDn4peGyKvtPDJzHUIjAXMj_bzO_QVybM7I3nzVTpAxhVoz-yOi8OOumV/pub?output=csv";

// Referensi Satuan resmi (kolom G) — Kinerja UPT dan Kinerja ULTG
const UNIT_REF_URLS = [
  (window.APP_DATA_SOURCES && window.APP_DATA_SOURCES.nko_csv) ? window.APP_DATA_SOURCES.nko_csv : "https://docs.google.com/spreadsheets/d/e/2PACX-1vSsiPTUoc4DRY6O_NLcn44tskrhiaIo6HQ0NPkl9N26ZnJYuZBSLX0zW8wawz_QyfypipvzPslRCyDV/pub?gid=1211605670&single=true&output=csv",
  "https://docs.google.com/spreadsheets/d/e/2PACX-1vSsiPTUoc4DRY6O_NLcn44tskrhiaIo6HQ0NPkl9N26ZnJYuZBSLX0zW8wawz_QyfypipvzPslRCyDV/pub?gid=2000263418&single=true&output=csv"
];

// Tab-tab historis per indikator (menampung realisasi bulanan asli Jan-Des)
const HIST_URLS = [
  "https://docs.google.com/spreadsheets/d/e/2PACX-1vQ7Ovm3gLoamwHFdoj8FI_bDn4peGyKvtPDJzHUIjAXMj_bzO_QVybM7I3nzVTpAxhVoz-yOi8OOumV/pub?gid=808654687&single=true&output=csv", // TROF/TROD
  "https://docs.google.com/spreadsheets/d/e/2PACX-1vQ7Ovm3gLoamwHFdoj8FI_bDn4peGyKvtPDJzHUIjAXMj_bzO_QVybM7I3nzVTpAxhVoz-yOi8OOumV/pub?gid=550404947&single=true&output=csv", // TLOF/TLOD
  "https://docs.google.com/spreadsheets/d/e/2PACX-1vQ7Ovm3gLoamwHFdoj8FI_bDn4peGyKvtPDJzHUIjAXMj_bzO_QVybM7I3nzVTpAxhVoz-yOi8OOumV/pub?gid=178748558&single=true&output=csv", // ABOF/ABAF
  "https://docs.google.com/spreadsheets/d/e/2PACX-1vQ7Ovm3gLoamwHFdoj8FI_bDn4peGyKvtPDJzHUIjAXMj_bzO_QVybM7I3nzVTpAxhVoz-yOi8OOumV/pub?gid=719833920&single=true&output=csv", // CCAF/TRAF
  "https://docs.google.com/spreadsheets/d/e/2PACX-1vQ7Ovm3gLoamwHFdoj8FI_bDn4peGyKvtPDJzHUIjAXMj_bzO_QVybM7I3nzVTpAxhVoz-yOi8OOumV/pub?gid=1146892612&single=true&output=csv", // SI/DI/ARI
  "https://docs.google.com/spreadsheets/d/e/2PACX-1vQ7Ovm3gLoamwHFdoj8FI_bDn4peGyKvtPDJzHUIjAXMj_bzO_QVybM7I3nzVTpAxhVoz-yOi8OOumV/pub?gid=180153965&single=true&output=csv", // MTTR-TR
  "https://docs.google.com/spreadsheets/d/e/2PACX-1vQ7Ovm3gLoamwHFdoj8FI_bDn4peGyKvtPDJzHUIjAXMj_bzO_QVybM7I3nzVTpAxhVoz-yOi8OOumV/pub?gid=1849186604&single=true&output=csv" // MTTR-TL
];

// Log gangguan mentah (FOIS)
const FOIS_CSV_URL = "https://docs.google.com/spreadsheets/d/e/2PACX-1vQ7Ovm3gLoamwHFdoj8FI_bDn4peGyKvtPDJzHUIjAXMj_bzO_QVybM7I3nzVTpAxhVoz-yOi8OOumV/pub?gid=390457643&single=true&output=csv";
// Sheet "Progress Kinerja UPT" — dipakai untuk breakdown Target/Realisasi bulanan per indikator (mis. TRAF, CCAF)
const KPI_DETAIL_CSV_URL = (window.APP_DATA_SOURCES && window.APP_DATA_SOURCES.nko_csv) 
  ? window.APP_DATA_SOURCES.nko_csv 
  : "https://docs.google.com/spreadsheets/d/e/2PACX-1vSsiPTUoc4DRY6O_NLcn44tskrhiaIo6HQ0NPkl9N26ZnJYuZBSLX0zW8wawz_QyfypipvzPslRCyDV/pub?gid=1211605670&single=true&output=csv";
// Data pembanding tahun sebelumnya (diisi setelah link tab spesifik tersedia)
const FOIS_PREV_YEAR_URLS = {
  2025: "https://docs.google.com/spreadsheets/d/e/2PACX-1vQSvKUNINb4cr0c9-308rzTpYNTkmML1SmkqSz1FmJhL7QAc1hW4Eo7OgOeLzzUNg/pub?gid=1699203047&single=true&output=csv",
  2024: "https://docs.google.com/spreadsheets/d/e/2PACX-1vRmG4ZW4bnd2iwVmKnL-7swQ0OiIENTx3ArvsBqq87Uhg4qi4_PvWxIFyYJqZW6UA/pub?gid=1206449922&single=true&output=csv"
};

const UPT_COL = [21,22];
const ULTG_UNITS = [
  {label:"ULTG Sawangan", cols:[9,10]},
  {label:"ULTG Lopana", cols:[12,13]},
  {label:"ULTG Kotamobagu", cols:[15,16]},
  {label:"ULTG Gorontalo", cols:[18,19]}
];
const MONTHS_ORDER = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
const MONTH_MAP = {Jan:"Januari",Feb:"Februari",Mar:"Maret",Apr:"April",May:"Mei",Jun:"Juni",Jul:"Juli",Aug:"Agustus",Sep:"September",Oct:"Oktober",Nov:"November",Dec:"Desember"};

let STATE = { categories: [], histMap: {}, unitMap: {}, foisRows: [], foisError: null, foisLoaded: false, currentMonthIdx: 0, selectedMonthIdx: 0 };

function flagClass(f){
  if(!f) return 'gray';
  if(f.includes('🟢')) return 'green';
  if(f.includes('🔴')) return 'red';
  if(f.includes('🟡')) return 'yellow';
  if(f.includes('🟣')) return 'purple';
  return 'gray';
}
function isCategoryRow(row){
  return row[0] === '0' && row[1] && row[1].trim() !== '' && (!row[2] || row[2].trim()==='');
}
function isDataRow(row){
  return row[2] && row[2].trim() !== '' && row[6] && row[6].trim() !== '' && row[2].trim() !== 'Unit Section';
}
function abbrevOf(name){
  const m = name.match(/\(([^)]+)\)/);
  if(!m) return null;
  return m[1].replace(/[^A-Za-z0-9]/g,'').toUpperCase();
}
// Normalisasi nama indikator supaya bisa dicocokkan lintas-sumber (hapus bintang/emoji, spasi ganda, lower-case)
function normName(name){
  return (name||'')
    .replace(/⭐+/g,'')
    .replace(/[⬆️⬇️↔️]/g,'')
    .replace(/\s+/g,' ')
    .trim()
    .toLowerCase();
}

function buildIndicatorList(rows){
  const categories = [];
  let current = null;
  for(const row of rows){
    if(isCategoryRow(row)){
      current = { name: row[1].trim(), items: [] };
      categories.push(current);
      continue;
    }
    if(isDataRow(row) && current){
      const rawName = row[2].replace(/⭐+/g,'').trim();
      let unit = row[6] ? row[6].trim() : '';
      const refUnit = STATE.unitMap[normName(rawName)];
      if(refUnit) unit = refUnit; // pakai referensi satuan resmi bila tersedia
      const upt = { score: (row[UPT_COL[0]]||'').trim(), flag: (row[UPT_COL[1]]||'').trim() };
      const ultg = ULTG_UNITS.map(u => ({ label: u.label, score: (row[u.cols[0]]||'').trim(), flag: (row[u.cols[1]]||'').trim() }));
      current.items.push({ name: rawName, unit, upt, ultg, abbrev: abbrevOf(rawName) });
    }
  }
  return categories;
}

// Parse sumber referensi Satuan (kolom C = URAIAN, kolom G = SATUAN)
function parseUnitReference(rows){
  const map = {};
  for(const row of rows){
    const name = row[2] ? row[2].trim() : '';
    const unit = row[6] ? row[6].trim() : '';
    if(!name || !unit) continue;
    if(name === 'URAIAN' || /^[0-9]+$/.test(name)) continue;
    map[normName(name)] = unit;
  }
  return map;
}

function parseHistoricalBlocks(rows){
  const blocks = [];
  let current = null;
  for(const row of rows){
    if(row.includes && row.includes('Month to be reported')){
      current = { title: (row[2]||'').trim(), units: {} };
      blocks.push(current);
      continue;
    }
    if(current && row[1] && row[2]==='UPT Manado' && row[4]){
      const unit = row[4].trim();
      const monthly = row.slice(6,18).map(v=>{
        const n = parseFloat((v||'').toString().replace(/,/g,''));
        return isNaN(n) ? null : n;
      });
      current.units[unit] = monthly;
    }
  }
  return blocks.filter(b => b.title.includes('📜'));
}

function countFlags(items, pick){
  const counts = {green:0, yellow:0, red:0, purple:0, gray:0};
  items.forEach(it=>{ counts[flagClass(pick(it))]++; });
  return counts;
}

// Mengisi nilai NKO pada card ringkasan: UPT Manado dari TOTAL (kolom O/BOBOT NILAI) sheet Progress Kinerja UPT,
// ULTG dari sheet Progress Kinerja ULTG — hanya ULTG yang sedang aktif di filter "ULTG:" sheet tersebut yang terisi.
// Menghitung NKO (dan NKO 110%) dengan menjumlahkan kolom "Bobot Nilai Bulanan" (BQ:CB, index 68-79)
// dan "Bobot Nilai 110 Bulanan" (CD:CQ, index 83-94) untuk BULAN YANG DIPILIH di dropdown Periode,
// di seluruh baris indikator asli (bertanda FLAG)
function computeNkoFromMonthlyBreakdown(rows, monthIdx){
  const activeIdx = (monthIdx !== undefined && monthIdx !== null) ? monthIdx : (STATE.selectedMonthIdx || 0);
  let sum = 0, sum110 = 0, found = false;
  rows.forEach(row=>{
    if(!(row[16]||'').trim() || !/[🟢🔴🟡🟣]/.test(row[16])) return; // hanya baris indikator asli (ada FLAG)
    const v = parseIDNum(row[68 + activeIdx]);   // BQ..CB: Bobot Nilai Bulanan, JAN..DES
    const v110 = parseIDNum(row[83 + activeIdx]); // CD..CQ: Bobot Nilai 110 Bulanan, JAN..DES
    if(v !== null){ sum += v; found = true; }
    if(v110 !== null) sum110 += v110;
  });
  return found ? { nko: sum, nko110: sum110 } : null;
}

async function loadNkoForSummaryCards(){
  try{
    if(STATE.kpiDetailRows){
      const result = computeNkoFromMonthlyBreakdown(STATE.kpiDetailRows);
      const el = document.getElementById('nkoVal-UPT_Manado');
      const el110 = document.getElementById('nko110Val-UPT_Manado');
      if(el) el.textContent = result ? result.nko.toFixed(2) : '-';
      if(el110) el110.textContent = result ? result.nko110.toFixed(2) : '-';
    }
  }catch(e){ /* gagal ambil NKO UPT, biarkan tampil "-" */ }

  // NKO per ULTG — diambil dari baris & kolom SPESIFIK di sheet "Realisasi ULTG" (bukan lagi via filter "ULTG:" aktif)
  // Kolom BU:CF (index 72-83) = Bobot Nilai Bulanan (JAN..DES) untuk NKO
  // Kolom CJ:CU (index 87-98) = Bobot Nilai 110 Bulanan (JAN..DES) untuk NKO 110%
  const ULTG_ROW_MAP = {
    'ULTG Sawangan': 61,
    'ULTG Lopana': 120,
    'ULTG Kotamobagu': 179,
    'ULTG Gorontalo': 238
  };
  try{
    if(!STATE.ultgKerjaRows) STATE.ultgKerjaRows = await fetchCsv(ULTG_KERJA_CSV_URL, 15000);
    const rows = STATE.ultgKerjaRows;
    const monthIdx = (STATE.selectedMonthIdx != null) ? STATE.selectedMonthIdx : 0;
    Object.keys(ULTG_ROW_MAP).forEach(label=>{
      const rowIdx = ULTG_ROW_MAP[label] - 1; // baris sheet (1-based) -> index array (0-based)
      const row = rows[rowIdx];
      const el = document.getElementById('nkoVal-' + label.replace(/\s+/g,'_'));
      const el110 = document.getElementById('nko110Val-' + label.replace(/\s+/g,'_'));
      if(!row){ if(el) el.textContent='-'; if(el110) el110.textContent='-'; return; }
      const nko = parseIDNum(row[72 + monthIdx]);   // BU..CF
      const nko110 = parseIDNum(row[87 + monthIdx]); // CJ..CU
      if(el) el.textContent = nko !== null ? nko.toFixed(2) : '-';
      if(el110) el110.textContent = nko110 !== null ? nko110.toFixed(2) : '-';
    });
  }catch(e){ /* gagal ambil NKO ULTG, biarkan tampil "-" */ }
}

function renderSummary(categories){
  const el = document.getElementById('content');
  const summaryTitle = document.createElement('div');
  summaryTitle.className = 'summary-title';
  summaryTitle.textContent = 'Kinerja UPT Manado';
  el.appendChild(summaryTitle);

  const kpiItems = (categories.find(c=>c.name.includes('(KPI)')) || {items:[]}).items;
  const piItems = (categories.find(c=>c.name.includes('(PI)')) || {items:[]}).items;
  const allMain = kpiItems.concat(piItems);
  STATE.allMainItems = allMain; // dipakai modal popup

  const grid = document.createElement('div');
  grid.className = 'summary-grid';

  function cardFor(label, items, pickFlag, unitKey){
    const nonPurple = items.filter(it => flagClass(pickFlag(it)) !== 'purple');
    const c = countFlags(nonPurple, pickFlag);
    const card = document.createElement('div');
    card.className = 'summary-card';
    card.style.cursor = 'pointer';
    card.onclick = ()=>openUnitModal(unitKey, label);

    const greenClickable = c.green > 0 ? 'clickable' : '';
    const yellowClickable = c.yellow > 0 ? 'clickable' : '';
    const redClickable = c.red > 0 ? 'clickable' : '';

    card.innerHTML = `
      <div class="unit-name">${label}</div>
      <div class="tl-indicator">
        <div class="tl-dot green ${greenClickable}" data-color="green">${c.green}</div>
        <div class="tl-dot yellow ${yellowClickable}" data-color="yellow">${c.yellow}</div>
        <div class="tl-dot red ${redClickable}" data-color="red">${c.red}</div>
      </div>
      <div class="nko-label">NKO</div>
      <div class="nko-row">
        <div class="nko-val" id="nkoVal-${unitKey.replace(/\s+/g,'_')}">-</div>
        <div class="nko110-wrap">
          <div class="nko110-label">110%</div>
          <div class="nko110-val" id="nko110Val-${unitKey.replace(/\s+/g,'_')}">-</div>
        </div>
      </div>`;

    const greenDot = card.querySelector('.tl-dot.green');
    const yellowDot = card.querySelector('.tl-dot.yellow');
    const redDot = card.querySelector('.tl-dot.red');
    greenDot.addEventListener('click', (e)=>{ e.stopPropagation(); if(c.green>0) openAlertModal(unitKey, label, allMain, pickFlag, 'green'); });
    yellowDot.addEventListener('click', (e)=>{ e.stopPropagation(); if(c.yellow>0) openAlertModal(unitKey, label, allMain, pickFlag, 'yellow'); });
    redDot.addEventListener('click', (e)=>{ e.stopPropagation(); if(c.red>0) openAlertModal(unitKey, label, allMain, pickFlag, 'red'); });
    return card;
  }

  grid.appendChild(cardFor('UPT MANADO', allMain, it => it.upt.flag, 'UPT Manado'));
  ULTG_UNITS.forEach((u,i)=>{
    grid.appendChild(cardFor(u.label.toUpperCase(), allMain, it => it.ultg[i].flag, u.label));
  });
  el.appendChild(grid);
  loadNkoForSummaryCards();
}

// Popup daftar indikator berstatus Kuning/Merah untuk satu unit
function openAlertModal(unitKey, unitLabel, items, pickFlag, colorClass){
  const overlay = document.getElementById('modalOverlay');
  const body = document.getElementById('modalBody');
  const colorTitle = colorClass === 'green' ? 'Tercapai (Hijau)' : colorClass === 'yellow' ? 'Waspada (Kuning)' : 'Tidak Tercapai (Merah)';
  document.getElementById('modalTitle').textContent = `${colorTitle} — ${unitLabel}`;

  const flagged = items.filter(it => flagClass(pickFlag(it)) === colorClass);
  if(!flagged.length){
    body.innerHTML = '<div style="padding:16px 0;color:var(--text-muted);font-size:13px;">Tidak ada indikator berstatus ini.</div>';
  } else {
    const rowsHtml = flagged.map(it=>`<tr><td>${it.name}${it.unit ? '<span class="unit-inline">'+it.unit+'</span>' : ''}</td></tr>`).join('');
    body.innerHTML = `<table><tbody>${rowsHtml}</tbody></table>`;
  }
  overlay.style.display = 'flex';
}

// Returns {value, flag, historical} for a given item + unit label at selected month
function resolveValue(item, unitLabel, liveScore, liveFlag){
  if(item.abbrev && STATE.histMap[item.abbrev] && STATE.histMap[item.abbrev][unitLabel]){
    const arr = STATE.histMap[item.abbrev][unitLabel];
    const v = arr[STATE.selectedMonthIdx];
    if(v !== null && v !== undefined){
      return { value: v.toString(), flag: liveFlag, historical: true };
    }
  }
  return { value: liveScore, flag: liveFlag, historical: false };
}

// Satuan TIDAK ditampilkan lagi di sini (hanya di kolom Satuan sebelah nama indikator)
function scoreCell(valObj){
  const val = valObj.value ? valObj.value : '—';
  const tag = valObj.historical ? '<span class="src" title="Punya riwayat bulanan">●H</span>' : '';
  return `<span class="score-cell"><span class="flag ${flagClass(valObj.flag)}"></span>${val}${tag}</span>`;
}

function openUnitModal(unitKey, unitLabel){
  const items = STATE.allMainItems || [];
  const overlay = document.getElementById('modalOverlay');
  const body = document.getElementById('modalBody');
  document.getElementById('modalTitle').textContent = 'Detail KPI/PI — ' + unitLabel;

  const rowsHtml = items.map(it=>{
    let score, flag;
    if(unitKey === 'UPT Manado'){ score = it.upt.score; flag = it.upt.flag; }
    else{
      const u = it.ultg.find(x=>x.label === unitKey);
      score = u ? u.score : ''; flag = u ? u.flag : '';
    }
    if(flagClass(flag) === 'purple') return ''; // data belum tersedia: tidak ditampilkan
    const v = resolveValue(it, unitKey, score, flag);
    return `<tr><td class="name">${it.name}${it.unit ? '<span class="unit-inline">'+it.unit+'</span>' : ''}</td><td>${scoreCell(v)}</td></tr>`;
  }).filter(Boolean).join('');

  body.innerHTML = `<table><thead><tr><th>Indikator</th><th>Nilai</th></tr></thead><tbody>${rowsHtml}</tbody></table>`;
  overlay.style.display = 'flex';
}
function closeUnitModal(){
  document.getElementById('modalOverlay').style.display = 'none';
}

const FOIS_MONTH_MAP = {Jan:"Jan",Feb:"Feb",Mar:"Mar",Apr:"Apr",May:"Mei",Jun:"Jun",Jul:"Jul",Aug:"Ags",Sep:"Sep",Oct:"Okt",Nov:"Nov",Dec:"Des"};

function isFaultRow(row){
  return row[1] && /^[0-9]+$/.test(row[1].trim()) && row[7] && row[7].trim() !== '';
}

// Gangguan "Incoming" adalah gangguan bergrup Transformer, tapi nama Bay Station-nya mengandung kata "Incoming"
function effectiveGroup(row){
  const group = (row[7]||'').trim();
  const bay = (row[6]||'').trim();
  if(group === 'Transformer' && /incoming/i.test(bay)) return 'Incoming';
  return group;
}

function barRow(label, value, max){
  const pct = max ? Math.round(value/max*100) : 0;
  return `<div class="bar-row"><div class="bar-label">${label}</div><div class="bar-track"><div class="bar-fill" style="width:${pct}%"></div></div><div class="bar-value">${value}</div></div>`;
}

function vBarChart(entries, max){
  return '<div class="vbar-chart">' + entries.map(([label,val])=>{
    const pct = max ? Math.round(val/max*100) : 0;
    return `<div class="vbar-col"><div class="vbar-value">${val}</div><div class="vbar-track"><div class="vbar-fill" style="height:${pct}%"></div></div><div class="vbar-label">${label}</div></div>`;
  }).join('') + '</div>';
}

// Mengambil bulan (Jan/Feb/dst) dari kolom Fault Date (kolom K, teks seperti "1 Jan 2026")
function monthFromFaultDate(dateStr){
  if(!dateStr) return null;
  const m = dateStr.trim().match(/\b(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\b/i);
  return m ? m[1].charAt(0).toUpperCase() + m[1].slice(1,3).toLowerCase() : null;
}

// Parser khusus sheet "(TB) Gangguan" tahun 2024: kolom BULAN sudah berupa kode 3-huruf (JAN/FEB/dst)
function parseFois2024(rows){
  const freqByMonth = {};
  MONTHS_ORDER.forEach(m => freqByMonth[m] = 0);
  rows.forEach(r=>{
    const ultg = (r[2]||'').trim();
    const gi = (r[4]||'').trim();
    if(!ultg || !gi) return; // baris kosong/template
    const bulan = (r[9]||'').trim().toUpperCase();
    const monthKey = MONTHS_ORDER.find(m => m.toUpperCase() === bulan);
    if(monthKey) freqByMonth[monthKey]++;
  });
  return { freq: MONTHS_ORDER.map(m => freqByMonth[m]) };
}

// Parser sheet "Faults" tahun 2025 — kolom J (index 9) = Fault Date, sesuai konfirmasi
function parseFois2025(rows){
  const freqByMonth = {};
  MONTHS_ORDER.forEach(m => freqByMonth[m] = 0);
  rows.forEach(r=>{
    const m = monthFromFaultDate(r[9]);
    if(m && freqByMonth.hasOwnProperty(m)) freqByMonth[m]++;
  });
  return { freq: MONTHS_ORDER.map(m => freqByMonth[m]) };
}

function computeMonthCounts(rows){
  const monthCounts = {};
  MONTHS_ORDER.forEach(m => monthCounts[m] = 0);
  rows.forEach(r=>{ const m = monthFromFaultDate(r[10]); if(m && monthCounts.hasOwnProperty(m)) monthCounts[m]++; });
  return monthCounts;
}

function populateYearDropdownAvailability(){
  const sel = document.getElementById('foisYearCompare');
  if(!sel) return;
  const opt2025 = sel.querySelector('option[value="1"]');
  const opt2024 = sel.querySelector('option[value="2"]');
  if(opt2025 && STATE.foisPrevData && STATE.foisPrevData[2025]){
    opt2025.disabled = false;
    opt2025.textContent = '+1 Tahun Sebelum (2025)';
  }
  if(opt2024 && STATE.foisPrevData && STATE.foisPrevData[2024]){
    opt2024.disabled = false;
    opt2024.textContent = '+2 Tahun Sebelum (2024)';
  }
}

STATE.foisCharts = {};
function destroyChart(key){
  if(STATE.foisCharts[key]){ STATE.foisCharts[key].destroy(); delete STATE.foisCharts[key]; }
}

function renderMonthCombo(monthCounts){
  const canvas = document.getElementById('foisMonthChart');
  if(!canvas) return;
  destroyChart('month');

  const labels = MONTHS_ORDER.map(m => FOIS_MONTH_MAP[m]);
  const freq = MONTHS_ORDER.map(m => monthCounts[m]);
  const cutoff = STATE.currentMonthIdx; // bulan aktif (0-based), mis. Agustus = 7

  function buildCumulative(arr, limitIdx){
    let cum = 0;
    return arr.map((v,i) => {
      if(limitIdx !== null && i > limitIdx) return null;
      cum += v;
      return cum;
    });
  }

  const compareOpt = document.getElementById('foisYearCompare') ? document.getElementById('foisYearCompare').value : '';
  const show2025 = compareOpt === '1' || compareOpt === '2';
  const show2024 = compareOpt === '2';

  const isDark = document.documentElement.getAttribute('data-theme') === 'dark';

  const datasets = [
    { type:'bar', label:'Frekuensi 2026', data: freq, backgroundColor: isDark ? '#FFC72C' : '#00529C', order:2, yAxisID:'y', _glow: isDark ? '#FFC72C' : '#00529C', pointStyle:'rect',
      datalabels:{ display:true, color: isDark ? '#FFF6DC' : '#0A2540', anchor:'end', align:'end', font:{size:9,weight:'700'} } },
    { type:'line', label:'Kumulatif 2026', data: buildCumulative(freq, cutoff), borderColor: isDark ? '#B8860B' : '#00386C', backgroundColor: isDark ? '#B8860B' : '#00386C', tension:0.3, order:1, yAxisID:'y', spanGaps:false, borderWidth:2, pointRadius:2, pointHoverRadius:4, _glow: isDark ? '#B8860B' : '#00386C', pointStyle:'line',
      datalabels:{ display:true, color: isDark ? '#FFE28A' : '#00386C', anchor:'end', align:'top', font:{size:9,weight:'700'} } }
  ];

  if(show2025 && STATE.foisPrevData && STATE.foisPrevData[2025]){
    datasets.push({ type:'bar', label:'Frekuensi 2025', data: STATE.foisPrevData[2025].freq, backgroundColor:'rgba(39,174,96,0.8)', order:3, yAxisID:'y', _glow:'#27AE60', pointStyle:'rect',
      datalabels:{ display:true, color: isDark ? '#C8F5D8' : '#1E5631', anchor:'end', align:'end', font:{size:9,weight:'700'} } });
    datasets.push({ type:'line', label:'Kumulatif 2025', data: buildCumulative(STATE.foisPrevData[2025].freq, null), borderColor:'rgba(20,90,50,0.8)', backgroundColor:'rgba(20,90,50,0.8)', tension:0.3, order:1, yAxisID:'y', borderWidth:2, pointRadius:2, pointHoverRadius:4, _glow:'#1E5631', pointStyle:'line',
      datalabels:{ display:true, color: isDark ? '#8CF0B0' : '#1E5631', anchor:'end', align:'top', font:{size:9,weight:'700'} } });
  }
  if(show2024 && STATE.foisPrevData && STATE.foisPrevData[2024]){
    datasets.push({ type:'bar', label:'Frekuensi 2024', data: STATE.foisPrevData[2024].freq, backgroundColor:'rgba(230,126,34,0.8)', order:4, yAxisID:'y', _glow:'#E67E22', pointStyle:'rect',
      datalabels:{ display:true, color: isDark ? '#FFE3C2' : '#B4620F', anchor:'end', align:'end', font:{size:9,weight:'700'} } });
    datasets.push({ type:'line', label:'Kumulatif 2024', data: buildCumulative(STATE.foisPrevData[2024].freq, null), borderColor:'rgba(180,90,20,0.8)', backgroundColor:'rgba(180,90,20,0.8)', tension:0.3, order:1, yAxisID:'y', borderWidth:2, pointRadius:2, pointHoverRadius:4, _glow:'#B4620F', pointStyle:'line',
      datalabels:{ display:true, color: isDark ? '#FFC98A' : '#B4620F', anchor:'end', align:'top', font:{size:9,weight:'700'} } });
  }

  const gridColor = isDark ? 'rgba(255,255,255,0.08)' : 'rgba(0,0,0,0.06)';
  const tickColor = isDark ? '#94A3B8' : '#6C7A89';

  // Plugin efek glow (hanya aktif di mode gelap) — memberi cahaya lembut pada bar & garis kumulatif 2026
  const glowPlugin = {
    id: 'glowPlugin',
    beforeDatasetDraw(chart, args){
      if(!isDark) return;
      const ds = chart.data.datasets[args.index];
      chart.ctx.save();
      chart.ctx.shadowColor = ds._glow || ds.borderColor || ds.backgroundColor;
      chart.ctx.shadowBlur = 9;
    },
    afterDatasetDraw(chart){
      if(!isDark) return;
      chart.ctx.restore();
    }
  };

  STATE.foisCharts.month = new Chart(canvas, {
    type: 'bar',
    data: { labels, datasets },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      interaction: { mode: 'index', intersect: false },
      layout: { padding: { top: 20 } },
      plugins: {
        legend: { display: true, position: 'bottom', labels:{ color: tickColor, font:{size:11}, usePointStyle:true, pointStyleWidth:22 } },
        tooltip: { usePointStyle:true, boxWidth:14, boxHeight:14 },
        datalabels: { display: false } // default mati, diaktifkan per-dataset di atas
      },
      scales: {
        x: { grid: { display:false }, ticks: { color: tickColor, font:{size:11} } },
        y: { position:'left', grid: { color: gridColor }, ticks: { color: tickColor }, title:{ display:true, text:'Frekuensi / Kumulatif', color: tickColor, font:{size:10} } }
      }
    },
    plugins: [glowPlugin, ...(window.ChartDataLabels ? [window.ChartDataLabels] : [])]
  });

  // Bersihkan legend manual dari versi sebelumnya (horizontal), jika masih ada di DOM
  const oldLineLegend = document.getElementById('foisLineLegend');
  if(oldLineLegend) oldLineLegend.remove();
}


function renderDonuts(ultgEntries, arCategories){
  const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
  const labelTextColor = '#FFFFFF';

  // Donut 1: Kontribusi ULTG (%) — persentase ditampilkan langsung di tiap potongan
  const ultgCanvas = document.getElementById('donutUltg');
  if(ultgCanvas){
    destroyChart('ultg');
    const total = ultgEntries.reduce((s,[,v])=>s+v,0) || 1;
    const colors = ['#00529C','#FFC72C','#27AE60','#8E44AD','#E67E22'];
    STATE.foisCharts.ultg = new Chart(ultgCanvas, {
      type: 'doughnut',
      data: { labels: ultgEntries.map(([l])=>l.replace('ULTG ','')), datasets:[{ data: ultgEntries.map(([,v])=>v), backgroundColor: colors, borderWidth: 2, borderColor: isDark ? '#1E293B' : '#FFFFFF' }] },
      options: {
        plugins:{
          legend:{ display:false },
          datalabels:{
            color: labelTextColor,
            font:{ size:10, weight:'700' },
            formatter: (v)=> Math.round(v/total*100) + '%'
          },
          tooltip:{
            callbacks:{ label: (ctx)=> ctx.label + ': ' + Math.round(ctx.raw/total*100) + '%' }
          }
        },
        cutout:'45%'
      },
      plugins: window.ChartDataLabels ? [window.ChartDataLabels] : []
    });
    document.getElementById('donutUltgPct').textContent = total;
    const legendEl = document.getElementById('donutUltgLegend');
    if(legendEl){
      legendEl.innerHTML = ultgEntries.map(([l],i)=>`<span><span class="sw" style="background:${colors[i%colors.length]}"></span>${l.replace('ULTG ','')}</span>`).join('');
    }
  }

  // Donut 2: Performa AR — 3 klasifikasi (Sukses/Gagal/Not Working), klik potongan untuk lihat detail kejadian
  const arCanvas = document.getElementById('donutAr');
  if(arCanvas){
    destroyChart('ar');
    const counts = [arCategories.sukses.length, arCategories.gagal.length, arCategories.notworking.length];
    const total = counts.reduce((a,b)=>a+b,0) || 0;
    const colors = ['#27AE60','#E74C3C','#94A3B8'];
    const keys = ['sukses','gagal','notworking'];
    const labels = ['Sukses','Gagal','Not Working'];
    STATE.foisCharts.ar = new Chart(arCanvas, {
      type: 'doughnut',
      data: { labels, datasets:[{ data:counts, backgroundColor:colors, borderWidth:2, borderColor:isDark?'#1E293B':'#FFFFFF' }] },
      options: {
        plugins:{
          legend:{ display:false },
          datalabels:{ color:labelTextColor, font:{size:10,weight:'700'}, formatter:(v)=> v>0 ? v : '' },
          tooltip:{ callbacks:{ label:(ctx)=> ctx.label + ': ' + ctx.raw + ' kejadian' } }
        },
        cutout:'62%',
        onClick:(evt, elements)=>{
          if(!elements.length) return;
          const idx = elements[0].index;
          openArEventModal(labels[idx], arCategories[keys[idx]]);
        },
        onHover:(evt, elements)=>{ evt.native.target.style.cursor = elements.length ? 'pointer' : 'default'; }
      },
      plugins: window.ChartDataLabels ? [window.ChartDataLabels] : []
    });
    document.getElementById('donutArPct').textContent = total;
    document.getElementById('donutArCap').textContent = 'Kejadian AR';
  }
}

// Popup detail kejadian AR — tanggal, substation, dan bay station per klasifikasi (Sukses/Gagal/Not Working)
function openArEventModal(label, events){
  const overlay = document.getElementById('modalOverlay');
  const body = document.getElementById('modalBody');
  document.getElementById('modalTitle').textContent = `AR ${label} — ${events.length} Kejadian`;
  if(!events.length){
    body.innerHTML = '<div style="padding:16px 0;color:var(--text-muted);font-size:13px;">Tidak ada kejadian pada klasifikasi ini.</div>';
  } else {
    const rowsHtml = events.map(e=>`<tr><td>${e.tanggal}</td><td>${e.substation}</td><td>${e.bay}</td></tr>`).join('');
    body.innerHTML = `<table><thead><tr><th>Tanggal</th><th>Substation</th><th>Bay Station</th></tr></thead><tbody>${rowsHtml}</tbody></table>`;
  }
  overlay.style.display = 'flex';
}

// ===================== MODUL "KINERJA TRANSMISI" (combo chart per indikator) =====================
// Sumber: sheet "Progress Kinerja UPT" — kolom V:AI (Breakdown Target Bulanan), AK:AX (Realisasi Bulanan)
const KPI_CHART_MONTHS = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];

function parseIDNum(str){
  if(str === null || str === undefined) return null;
  const s = str.toString().trim();
  if(s === '' || s === '-') return null;
  const n = parseFloat(s.replace(/\./g,'').replace(',', '.'));
  return isNaN(n) ? null : n;
}

// Cari baris indikator (mis. "TRAF") berdasarkan kolom URAIAN di blok Breakdown Target Bulanan (kolom W, index22)
function findKpiDetailRow(rows, code){
  const norm = s => (s||'').toString().replace(/[\r\n]+/g,' ').replace(/\s+/g,' ').trim().toLowerCase();
  const target = norm(code);
  const hasFlag = r => r[16] && /[🟢🔴🟡🟣]/.test(r[16]);
  // Baris judul kategori (mis. "13. Kepatuhan") sering punya nama SAMA PERSIS dengan salah satu
  // item datanya (mis. "b. Kepatuhan") — baris kategori tidak punya FLAG, jadi diprioritaskan
  // untuk MENGHINDARI baris itu dan mengambil baris data asli.
  // 1) Exact match di kolom breakdown (col22) DENGAN flag (baris data asli)
  let row = rows.find(row => norm(row[22]) === target && hasFlag(row));
  if(row) return row;
  // 2) Exact match di kolom breakdown TANPA syarat flag (fallback)
  row = rows.find(row => norm(row[22]) === target);
  if(row) return row;
  // 3) Partial match di kolom breakdown DENGAN flag
  row = rows.find(row => norm(row[22]).includes(target) && hasFlag(row));
  if(row) return row;
  // 4) Partial match di kolom breakdown TANPA flag
  row = rows.find(row => norm(row[22]).includes(target));
  if(row) return row;
  // 5) Fallback: cek kolom URAIAN utama (col2) — untuk indikator dengan nama panjang/deskriptif
  row = rows.find(row => norm(row[2]).includes(target) && hasFlag(row));
  if(row) return row;
  row = rows.find(row => norm(row[2]).includes(target));
  return row;
}
function extractKpiMonthly(rows, code, opts){
  opts = opts || {};
  const row = findKpiDetailRow(rows, code);
  if(!row) return null;
  const polarity = (row[3]||'').trim(); // Kolom D = POL (⬆️ / ⬇️ / ↔️)
  const target = [];
  const realisasi = [];
  for(let m=0; m<12; m++){
    target.push(parseIDNum(row[23+m]));   // kolom X..AI (V:AI block, JAN..DES)
    realisasi.push(parseIDNum(row[38+m])); // kolom AM..AX (AK:AX block, JAN..DES)
  }
  // Bulan aktif mengikuti filter bulan GLOBAL (sel "BULAN :" di sheet), bukan deteksi per-indikator
  // (deteksi per-indikator tidak andal karena beberapa sel bulan mendatang terisi "0,00", bukan kosong)
  const activeIdx = (STATE && STATE.currentMonthIdx != null) ? STATE.currentMonthIdx : 11;
  let prognosaLine;
  if(opts.cumulativePrognosa){
    // Garis Realisasi+Prognosa dihitung kumulatif bulanan (khusus MTTR-TR/MTTR-TL)
    let cum = 0;
    const cumulative = realisasi.map((v,i)=>{
      if(i > activeIdx || v === null) return null;
      cum += v;
      return cum;
    });
    const lastCum = activeIdx >= 0 ? cumulative[activeIdx] : null;
    prognosaLine = cumulative.map((v,i)=> i <= activeIdx ? v : lastCum);
  } else {
    // prognosa: bulan setelah aktif diisi rata datar dari nilai realisasi terakhir
    const lastVal = activeIdx >= 0 ? realisasi[activeIdx] : null;
    prognosaLine = realisasi.map((v,i)=> i <= activeIdx ? v : lastVal);
  }
  return { code, polarity, target, realisasi, prognosaLine, activeIdx };
}

function renderKpiComboChart(canvasId, data, yRange){
  const canvasElForMsg = document.getElementById(canvasId);
  if(!data){
    if(canvasElForMsg) canvasElForMsg.insertAdjacentHTML('afterend', '<div style="font-size:11px;color:var(--red);text-align:center;padding:8px;">Indikator tidak ditemukan di sheet (nama URAIAN tidak cocok).</div>');
    return;
  }
  const hasAnyTarget = data.target.some(v=>v!==null);
  const hasAnyRealisasi = data.realisasi.some(v=>v!==null);
  if(!hasAnyTarget && !hasAnyRealisasi){
    if(canvasElForMsg) canvasElForMsg.insertAdjacentHTML('afterend', '<div style="font-size:11px;color:var(--text-muted);text-align:center;padding:8px;">Indikator ditemukan, tapi kolom Target &amp; Realisasi bulanan masih kosong di sheet.</div>');
    return;
  }
  const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
  const tickColor = isDark ? '#94A3B8' : '#6C7A89';
  const gridColor = isDark ? 'rgba(255,255,255,0.08)' : 'rgba(0,0,0,0.06)';
  const barColor = isDark ? '#FFC72C' : '#00529C';
  const lineColor = isDark ? '#2DD4BF' : '#D9A400';

  // Warna Grafik Area mengikuti polaritas (kolom D / POL):
  // ⬆️ = merah (naik = baik), ⬇️ = hijau (turun = baik), ↔️ = hijau dengan pita batas bawah 95% target
  const isDown = /⬇️/.test(data.polarity || '');
  const isRange = /↔️/.test(data.polarity || '');
  const areaBorder = (isDown || isRange) ? 'rgba(39,174,96,0.5)' : 'rgba(231,76,60,0.5)';
  const areaLabelColor = (isDown || isRange) ? (isDark ? '#C8F5D8' : '#1E5631') : (isDark ? '#FFD9D6' : '#7A1F16');

  destroyChart(canvasId);
  const canvas = document.getElementById(canvasId);
  if(!canvas) return;

  // Bar realisasi: hanya tampilkan sampai bulan aktif, bulan setelahnya null (tidak digambar)
  const barData = data.realisasi.map((v,i)=> i <= data.activeIdx ? v : null);

  const glowPlugin = {
    id: 'glowPlugin-'+canvasId,
    beforeDatasetDraw(chart, args){
      if(!isDark) return;
      const ds = chart.data.datasets[args.index];
      chart.ctx.save();
      chart.ctx.shadowColor = ds._glow || ds.borderColor || ds.backgroundColor;
      chart.ctx.shadowBlur = 8;
    },
    afterDatasetDraw(chart){ if(isDark) chart.ctx.restore(); }
  };

  const datasets = [];
  let targetFill = true; // default: area terisi ke bawah (dasar sumbu / batas skala)

  if(isRange){
    // Mode "↔️": pita area antara batas bawah (95% target) s.d. garis target
    const lowerBound = data.target.map(v => v !== null ? v * 0.95 : null);
    datasets.push({
      type:'line', label:'_batasBawah', data:lowerBound, borderWidth:0, pointRadius:0,
      fill:false, tension:0, order:3, datalabels:{display:false}
    });
    targetFill = 0; // isi area relatif ke dataset index 0 (batas bawah) di atas
  }

  datasets.push({
    type:'line', label:'Target', data:data.target,
    borderColor:areaBorder, backgroundColor:areaBorder,
    fill:targetFill, tension:0, borderWidth:1, pointRadius:0, order:3, pointStyle:'rect',
    datalabels:{
      display:(ctx)=> ctx.dataIndex === 11, // label hanya di Desember (hindari tumpang tindih dengan bar)
      color:areaLabelColor, anchor:'end', align:'top', font:{size:9,weight:'700'}
    }
  });
  datasets.push({
    type:'bar', label:'Realisasi Bulanan', data:barData, backgroundColor:barColor, order:2, _glow:barColor, pointStyle:'rect',
    datalabels:{ display:true, color: isDark ? '#FFF6DC' : '#0A2540', anchor:'end', align:'end', font:{size:9,weight:'700'} }
  });
  datasets.push({
    type:'line', label:'Prognosa', data:data.prognosaLine,
    borderColor:lineColor, backgroundColor:lineColor, borderDash:[6,4],
    tension:0, borderWidth:2, pointRadius:2, order:1, _glow:lineColor, pointStyle:'line',
    datalabels:{
      display:(ctx)=> ctx.dataIndex === 11, // label hanya di Desember
      color: isDark ? '#B6FFF3' : '#7A5A00', anchor:'end', align:'top', font:{size:9,weight:'700'}
    }
  });

  STATE.foisCharts[canvasId] = new Chart(canvas, {
    type:'bar',
    data: { labels: KPI_CHART_MONTHS, datasets },
    options:{
      responsive:true, maintainAspectRatio:false,
      interaction:{ mode:'index', intersect:false },
      layout:{ padding:{ top:20 } },
      plugins:{
        legend:{
          display:true, position:'bottom',
          labels:{ color:tickColor, font:{size:10}, usePointStyle:true, pointStyleWidth:22, filter: (item)=> !item.text.startsWith('_') }
        },
        tooltip:{ usePointStyle:true, boxWidth:14, boxHeight:14 },
        datalabels:{ display:false }
      },
      scales:{
        x:{ grid:{display:false}, ticks:{color:tickColor, font:{size:10}} },
        y:{
          grid:{color:gridColor}, ticks:{color:tickColor, font:{size:10}},
          ...(yRange ? {min:yRange[0], ...(yRange[1] != null ? {max:yRange[1]} : {})} : {grace:'10%'})
        }
      }
    },
    plugins:[glowPlugin, ...(window.ChartDataLabels ? [window.ChartDataLabels] : [])]
  });
}

function renderKinerjaTransmisiChartsModule(rows, errMsg, loaded){
  const el = document.getElementById('content');
  const moduleTitle = document.createElement('div');
  moduleTitle.className = 'module-title';
  moduleTitle.id = 'kinerja-transmisi-top';
  moduleTitle.style.scrollMarginTop = 'calc(var(--topbar-h, 0px) + 12px)';
  moduleTitle.textContent = 'KINERJA TRANSMISI';
  el.appendChild(moduleTitle);
  const wrap = document.createElement('div');
  wrap.className = 'table-wrap';
  wrap.style.padding = '18px';
  wrap.style.borderRadius = '0 0 8px 8px';
  el.appendChild(wrap);

  if(!loaded){
    wrap.innerHTML = '<div class="loading">Memuat data kinerja per indikator...</div>';
    return;
  }
  if(errMsg){
    wrap.innerHTML = '<div class="err" style="padding:20px 0;">GAGAL MEMUAT DATA — ' + errMsg + '</div>';
    return;
  }

  const trafData = extractKpiMonthly(rows, 'TRAF');
  const ccafData = extractKpiMonthly(rows, 'CCAF');
  const tlofData = extractKpiMonthly(rows, 'TLOF');
  const trofData = extractKpiMonthly(rows, 'TROF');
  const abofData = extractKpiMonthly(rows, 'ABOF');
  const mttrTrData = extractKpiMonthly(rows, 'MTTR-TR');
  const mttrTlData = extractKpiMonthly(rows, 'MTTR-TL');
  const siData = extractKpiMonthly(rows, 'SI');
  const diData = extractKpiMonthly(rows, 'DI');
  const ariData = extractKpiMonthly(rows, 'ARI');
  const rpagData = extractKpiMonthly(rows, 'RPAG');
  const investigasiData = extractKpiMonthly(rows, 'Rata-rata Waktu Close Investigasi Gangguan');
  const tindakLanjutData = extractKpiMonthly(rows, 'Close Tindak Lanjut Gangguan');

  wrap.innerHTML = `
    <div class="fois-2col">
      <div class="kpi-chart-card">
        <div class="kpi-chart-title">TRAF — Transformer Availability Factor</div>
        <div style="position:relative; width:100%; height:280px;"><canvas id="chartTRAF"></canvas></div>
      </div>
      <div class="kpi-chart-card">
        <div class="kpi-chart-title">CCAF — Circuit Availability Factor</div>
        <div style="position:relative; width:100%; height:280px;"><canvas id="chartCCAF"></canvas></div>
      </div>
    </div>
    <div class="fois-2col">
      <div class="kpi-chart-card">
        <div class="kpi-chart-title">TLOF — Transmission Line Outage Frequency</div>
        <div style="position:relative; width:100%; height:280px;"><canvas id="chartTLOF"></canvas></div>
      </div>
      <div class="kpi-chart-card">
        <div class="kpi-chart-title">TROF — Transformer Outage Frequency</div>
        <div style="position:relative; width:100%; height:280px;"><canvas id="chartTROF"></canvas></div>
      </div>
    </div>
    <div class="fois-3col">
      <div class="kpi-chart-card">
        <div class="kpi-chart-title">ABOF — Another Bay Outage Frequency</div>
        <div style="position:relative; width:100%; height:260px;"><canvas id="chartABOF"></canvas></div>
      </div>
      <div class="kpi-chart-card">
        <div class="kpi-chart-title">MTTR-TR</div>
        <div style="position:relative; width:100%; height:260px;"><canvas id="chartMTTRTR"></canvas></div>
      </div>
      <div class="kpi-chart-card">
        <div class="kpi-chart-title">MTTR-TL</div>
        <div style="position:relative; width:100%; height:260px;"><canvas id="chartMTTRTL"></canvas></div>
      </div>
    </div>
    <div class="fois-4col">
      <div class="kpi-chart-card">
        <div class="kpi-chart-title">SI — Security Index</div>
        <div style="position:relative; width:100%; height:240px;"><canvas id="chartSI"></canvas></div>
      </div>
      <div class="kpi-chart-card">
        <div class="kpi-chart-title">DI — Dependability Index</div>
        <div style="position:relative; width:100%; height:240px;"><canvas id="chartDI"></canvas></div>
      </div>
      <div class="kpi-chart-card">
        <div class="kpi-chart-title">ARI — Auto Reclose Index</div>
        <div style="position:relative; width:100%; height:240px;"><canvas id="chartARI"></canvas></div>
      </div>
      <div class="kpi-chart-card">
        <div class="kpi-chart-title">RPAG</div>
        <div style="position:relative; width:100%; height:240px;"><canvas id="chartRPAG"></canvas></div>
      </div>
    </div>
    <div class="fois-2col">
      <div class="kpi-chart-card">
        <div class="kpi-chart-title">Rata-Rata Waktu Close Investigasi Gangguan</div>
        <div style="position:relative; width:100%; height:280px;"><canvas id="chartInvestigasi"></canvas></div>
      </div>
      <div class="kpi-chart-card">
        <div class="kpi-chart-title">Close Tindak Lanjut Gangguan</div>
        <div style="position:relative; width:100%; height:280px;"><canvas id="chartTindakLanjut"></canvas></div>
      </div>
    </div>`;

  renderKpiComboChart('chartTRAF', trafData, [99.5, 100.1]);
  renderKpiComboChart('chartCCAF', ccafData, [99.5, 100.1]);
  renderKpiComboChart('chartTLOF', tlofData, [0, null]);
  renderKpiComboChart('chartTROF', trofData, [0, null]);
  renderKpiComboChart('chartABOF', abofData, [0, null]);
  renderKpiComboChart('chartMTTRTR', mttrTrData, [0, null]);
  renderKpiComboChart('chartMTTRTL', mttrTlData, [0, null]);
  renderKpiComboChart('chartSI', siData, [80, 105]);
  renderKpiComboChart('chartDI', diData, [80, 105]);
  renderKpiComboChart('chartARI', ariData, [80, 105]);
  renderKpiComboChart('chartRPAG', rpagData, [0, null]);
  renderKpiComboChart('chartInvestigasi', investigasiData, [0, null]);
  renderKpiComboChart('chartTindakLanjut', tindakLanjutData, [0, null]);
}

function renderPengendalianAiAttbModule(rows, errMsg, loaded){
  const el = document.getElementById('content');
  const moduleTitle = document.createElement('div');
  moduleTitle.className = 'module-title';
  moduleTitle.id = 'pengendalian-ai-attb';
  moduleTitle.style.scrollMarginTop = 'calc(var(--topbar-h, 0px) + 12px)';
  moduleTitle.textContent = 'PENGENDALIAN AI DAN ATTB';
  el.appendChild(moduleTitle);
  const wrap = document.createElement('div');
  wrap.className = 'table-wrap';
  wrap.style.padding = '18px';
  wrap.style.borderRadius = '0 0 8px 8px';
  el.appendChild(wrap);

  if(!loaded){
    wrap.innerHTML = '<div class="loading">Memuat data kinerja per indikator...</div>';
    return;
  }
  if(errMsg){
    wrap.innerHTML = '<div class="err" style="padding:20px 0;">GAGAL MEMUAT DATA — ' + errMsg + '</div>';
    return;
  }

  const rkapData = extractKpiMonthly(rows, 'sesuai RKAP');
  const aiTerkontrakData = extractKpiMonthly(rows, 'Pengendalian AI Murni Terkontrak');
  const nacData = extractKpiMonthly(rows, 'Pengendalian NAC');

  wrap.innerHTML = `
    <div class="fois-3col">
      <div class="kpi-chart-card">
        <div class="kpi-chart-title">Pengendalian AI Sesuai RKAP</div>
        <div style="position:relative; width:100%; height:260px;"><canvas id="chartRKAP"></canvas></div>
      </div>
      <div class="kpi-chart-card">
        <div class="kpi-chart-title">Pengendalian AI Murni Terkontrak</div>
        <div style="position:relative; width:100%; height:260px;"><canvas id="chartAITerkontrak"></canvas></div>
      </div>
      <div class="kpi-chart-card">
        <div class="kpi-chart-title">Pengendalian NAC</div>
        <div style="position:relative; width:100%; height:260px;"><canvas id="chartNAC"></canvas></div>
      </div>
    </div>`;

  renderKpiComboChart('chartRKAP', rkapData, [90, 110]);
  renderKpiComboChart('chartAITerkontrak', aiTerkontrakData, [0, null]);
  renderKpiComboChart('chartNAC', nacData, [0, null]);
}

// ===== 2. PENYELESAIAN SLO =====
function renderPenyelesaianSloModule(rows, errMsg, loaded){
  const el = document.getElementById('content');
  const moduleTitle = document.createElement('div');
  moduleTitle.className = 'module-title';
  moduleTitle.id = 'penyelesaian-slo';
  moduleTitle.style.scrollMarginTop = 'calc(var(--topbar-h, 0px) + 12px)';
  moduleTitle.textContent = 'PENYELESAIAN SLO';
  el.appendChild(moduleTitle);
  const wrap = document.createElement('div');
  wrap.className = 'table-wrap';
  wrap.style.padding = '18px';
  wrap.style.borderRadius = '0 0 8px 8px';
  el.appendChild(wrap);

  if(!loaded){
    wrap.innerHTML = '<div class="loading">Memuat data kinerja per indikator...</div>';
    return;
  }
  if(errMsg){
    wrap.innerHTML = '<div class="err" style="padding:20px 0;">GAGAL MEMUAT DATA — ' + errMsg + '</div>';
    return;
  }

  const sloData = extractKpiMonthly(rows, 'Penyelesaian SLO');

  wrap.innerHTML = `
    <div class="fois-2col">
      <div class="kpi-chart-card">
        <div class="kpi-chart-title">Penyelesaian SLO</div>
        <div style="position:relative; width:100%; height:280px;"><canvas id="chartPenyelesaianSlo"></canvas></div>
      </div>
    </div>`;

  renderKpiComboChart('chartPenyelesaianSlo', sloData, [0, null]);
}

// ===== Kartu status indikator (hijau ≥100%, kuning 95-100%, merah <95%) =====
function buildStatusCard(rows, code, displayLabel){
  const row = findKpiDetailRow(rows, code);
  if(!row){
    return `<div class="status-card">
      <div class="st-label">${displayLabel}</div>
      <div class="st-row"><span class="st-dot gray"></span></div>
      <div class="st-val">-</div>
    </div>`;
  }
  const satuan = (row[6]||'').trim();
  const activeIdx = (STATE && STATE.currentMonthIdx != null) ? STATE.currentMonthIdx : 11;
  // Ambil dari blok bulanan (sama seperti dipakai grafik) untuk bulan aktif:
  // Realisasi Bulanan = kolom AK:AX (index 38+bulan), Pencapaian Bulanan % = kolom AZ:BM (index 53+bulan)
  const realisasiBulanan = parseIDNum(row[38 + activeIdx]);
  const pencapaianBulanan = parseIDNum(row[53 + activeIdx]);

  let realisasi = realisasiBulanan !== null ? realisasiBulanan.toString() : '';
  // Fallback berlapis kalau blok bulanan kosong: kolom REALISASI S/D BULAN, lalu Bobot Nilai
  if(!realisasi) realisasi = (row[11]||'').trim();
  if(!realisasi) realisasi = (row[14]||'').trim();
  if(!realisasi) realisasi = '-';

  // Warna diambil dari kolom FLAG sheet (🟢🟡🔴) — lebih andal daripada menghitung ambang % sendiri,
  // karena berlaku juga untuk indikator dengan struktur kolom berbeda (kategori Pengurang/Kepatuhan)
  const flag = (row[16]||'').trim();
  let cls = 'gray';
  if(/🟢/.test(flag)) cls = 'green';
  else if(/🟡/.test(flag)) cls = 'yellow';
  else if(/🔴/.test(flag)) cls = 'red';
  else{
    // fallback: hitung dari % Pencapaian bulanan (lalu % Pencapaian S/D Bulan) kalau FLAG tidak dikenali
    const pencapaian = pencapaianBulanan !== null ? pencapaianBulanan : parseIDNum(row[12]);
    if(pencapaian !== null){
      if(pencapaian >= 100) cls = 'green';
      else if(pencapaian > 95) cls = 'yellow';
      else cls = 'red';
    }
  }
  // Nilai Pengurang (khusus modul Kepatuhan Proker Transmisi & Kepatuhan): diambil dari kolom
  // "Bobot Nilai Bulanan" BQ:CB (index 68+bulan) untuk bulan aktif, ditampilkan DI DALAM lingkaran
  // dot dengan tanda "-" di depan angka kalau ada nilainya (mis. "-0,075").
  const bobotNilaiBulanan = parseIDNum(row[68 + activeIdx]);
  let pengurangLabel = '';
  if(bobotNilaiBulanan !== null && bobotNilaiBulanan !== 0){
    const absVal = Math.abs(bobotNilaiBulanan);
    const formatted = absVal.toFixed(3).replace(/0+$/,'').replace(/\.$/,'').replace('.', ',') || '0';
    pengurangLabel = `<span class="st-dot-pengurang">-${formatted}</span>`;
  }

  return `<div class="status-card">
    <div class="st-label">${displayLabel}</div>
    <div class="st-row"><span class="st-dot ${cls}">${pengurangLabel}</span></div>
    <div class="st-val">${realisasi} ${satuan}</div>
  </div>`;
}

// ===== 3. TATA KELOLA ASET =====
function renderTataKelolaAsetModule(rows, errMsg, loaded){
  const el = document.getElementById('content');
  const moduleTitle = document.createElement('div');
  moduleTitle.className = 'module-title';
  moduleTitle.id = 'tata-kelola-aset';
  moduleTitle.style.scrollMarginTop = 'calc(var(--topbar-h, 0px) + 12px)';
  moduleTitle.textContent = 'KINERJA TATA KELOLA ASET';
  el.appendChild(moduleTitle);
  const wrap = document.createElement('div');
  wrap.className = 'table-wrap';
  wrap.style.padding = '18px';
  wrap.style.borderRadius = '0 0 8px 8px';
  el.appendChild(wrap);

  if(!loaded){ wrap.innerHTML = '<div class="loading">Memuat data kinerja per indikator...</div>'; return; }
  if(errMsg){ wrap.innerHTML = '<div class="err" style="padding:20px 0;">GAGAL MEMUAT DATA — ' + errMsg + '</div>'; return; }

  const mastData = extractKpiMonthly(rows, 'Maturity Level MAST') || extractKpiMonthly(rows, 'Maturity Level Manajemen Aset Sistem Transmisi') || extractKpiMonthly(rows, 'MAST');
  const materialCadangData = extractKpiMonthly(rows, 'Material Cadang Transmisi') || extractKpiMonthly(rows, 'Kualitas Data Perhitungan Material Cadang Transmisi') || extractKpiMonthly(rows, 'Material Cadang');

  wrap.innerHTML = `
    <div class="fois-2col">
      <div class="kpi-chart-card">
        <div class="kpi-chart-title">Maturity Level MAST</div>
        <div style="position:relative; width:100%; height:280px;"><canvas id="chartMAST"></canvas></div>
      </div>
      <div class="kpi-chart-card">
        <div class="kpi-chart-title">Kualitas Data Perhitungan Material Cadang Transmisi</div>
        <div style="position:relative; width:100%; height:280px;"><canvas id="chartMaterialCadang"></canvas></div>
      </div>
    </div>`;

  renderKpiComboChart('chartMAST', mastData, [0, null]);
  renderKpiComboChart('chartMaterialCadang', materialCadangData, [0, null]);
}

// ===== 4. KINERJA KKU =====
function renderKinerjaKkuModule(rows, errMsg, loaded){
  const el = document.getElementById('content');
  const moduleTitle = document.createElement('div');
  moduleTitle.className = 'module-title';
  moduleTitle.id = 'kinerja-kku';
  moduleTitle.style.scrollMarginTop = 'calc(var(--topbar-h, 0px) + 12px)';
  moduleTitle.textContent = 'KEUANGAN, KOMUNIKASI, DAN UMUM';
  el.appendChild(moduleTitle);
  const wrap = document.createElement('div');
  wrap.className = 'table-wrap';
  wrap.style.padding = '18px';
  wrap.style.borderRadius = '0 0 8px 8px';
  el.appendChild(wrap);

  if(!loaded){ wrap.innerHTML = '<div class="loading">Memuat data kinerja per indikator...</div>'; return; }
  if(errMsg){ wrap.innerHTML = '<div class="err" style="padding:20px 0;">GAGAL MEMUAT DATA — ' + errMsg + '</div>'; return; }

  const legalAsetData = extractKpiMonthly(rows, 'Legal Aset Tanah');
  const stakeholderData = extractKpiMonthly(rows, 'Manajemen Stakeholder');
  const tjslData = extractKpiMonthly(rows, 'Komunikasi dan TJSL');

  wrap.innerHTML = `
    <div class="fois-3col">
      <div class="kpi-chart-card">
        <div class="kpi-chart-title">Dok Legal Aset Tanah</div>
        <div style="position:relative; width:100%; height:260px;"><canvas id="chartLegalAset"></canvas></div>
      </div>
      <div class="kpi-chart-card">
        <div class="kpi-chart-title">Manajemen Stakeholder</div>
        <div style="position:relative; width:100%; height:260px;"><canvas id="chartStakeholder"></canvas></div>
      </div>
      <div class="kpi-chart-card">
        <div class="kpi-chart-title">Komunikasi dan TJSL</div>
        <div style="position:relative; width:100%; height:260px;"><canvas id="chartTjsl"></canvas></div>
      </div>
    </div>`;

  renderKpiComboChart('chartLegalAset', legalAsetData, [0, null]);
  renderKpiComboChart('chartStakeholder', stakeholderData, [0, null]);
  renderKpiComboChart('chartTjsl', tjslData, [0, null]);
}

// ===== 5. KEPATUHAN PROKER TRANSMISI =====
function renderKepatuhanProkerModule(rows, errMsg, loaded){
  const el = document.getElementById('content');
  const moduleTitle = document.createElement('div');
  moduleTitle.className = 'module-title';
  moduleTitle.id = 'kepatuhan-proker-transmisi';
  moduleTitle.style.scrollMarginTop = 'calc(var(--topbar-h, 0px) + 12px)';
  moduleTitle.textContent = 'KEPATUHAN PROGRAM KERJA TRANSMISI DAN PDKB';
  el.appendChild(moduleTitle);
  const wrap = document.createElement('div');
  wrap.className = 'table-wrap';
  wrap.style.padding = '18px';
  wrap.style.borderRadius = '0 0 8px 8px';
  el.appendChild(wrap);

  if(!loaded){ wrap.innerHTML = '<div class="loading">Memuat data kinerja per indikator...</div>'; return; }
  if(errMsg){ wrap.innerHTML = '<div class="err" style="padding:20px 0;">GAGAL MEMUAT DATA — ' + errMsg + '</div>'; return; }

  wrap.innerHTML = `
    <div class="fois-8col">
      ${buildStatusCard(rows, 'CBM/Power Inspect', 'CBM/Power Inspect')}
      ${buildStatusCard(rows, 'New SRINTAMI', 'New SRINTAMI')}
      ${buildStatusCard(rows, 'Validasi Cek ROW', 'Validasi Cek ROW')}
      ${buildStatusCard(rows, 'Verifikasi Sistem Penyaluran', 'Tindak Lanjut VSP')}
      ${buildStatusCard(rows, 'Maturity Level GI Level 4', 'Maturity Level GI Level 4')}
      ${buildStatusCard(rows, 'Optimalisasi PDKB Jaringan', 'Optimalisasi PDKB Jaringan')}
      ${buildStatusCard(rows, 'Optimalisasi PDKB Gardu Induk', 'Optimalisasi PDKB Gardu Induk')}
      ${buildStatusCard(rows, 'Tata Kelola PDKB Level 4', 'Tata Kelola PDKB Level 4')}
    </div>`;
}

// ===== 6. KEPATUHAN =====
function renderKepatuhanModule(rows, errMsg, loaded){
  const el = document.getElementById('content');
  const moduleTitle = document.createElement('div');
  moduleTitle.className = 'module-title';
  moduleTitle.id = 'kepatuhan';
  moduleTitle.style.scrollMarginTop = 'calc(var(--topbar-h, 0px) + 12px)';
  moduleTitle.textContent = 'KEPATUHAN';
  el.appendChild(moduleTitle);
  const wrap = document.createElement('div');
  wrap.className = 'table-wrap';
  wrap.style.padding = '18px';
  wrap.style.borderRadius = '0 0 8px 8px';
  el.appendChild(wrap);

  if(!loaded){ wrap.innerHTML = '<div class="loading">Memuat data kinerja per indikator...</div>'; return; }
  if(errMsg){ wrap.innerHTML = '<div class="err" style="padding:20px 0;">GAGAL MEMUAT DATA — ' + errMsg + '</div>'; return; }

  wrap.innerHTML = `
    <div class="fois-8col">
      ${buildStatusCard(rows, 'Implementasi Maturity Level', 'Implementasi Maturity Level')}
      ${buildStatusCard(rows, 'Kepatuhan', 'Kepatuhan')}
      ${buildStatusCard(rows, 'Tata Kelola Perusahaan', 'Tata Kelola Perusahaan')}
    </div>`;
}

// ===== 7. NKO UNIT — Lembar Kertas Kerja =====
const ULTG_KERJA_CSV_URL = "https://docs.google.com/spreadsheets/d/e/2PACX-1vSsiPTUoc4DRY6O_NLcn44tskrhiaIo6HQ0NPkl9N26ZnJYuZBSLX0zW8wawz_QyfypipvzPslRCyDV/pub?gid=2000263418&single=true&output=csv";
const ULTG_LIST = ['SAWANGAN','LOPANA','KOTAMOBAGU','GORONTALO'];

function isKkSectionRow(row){
  return ['KEY PERFORMANCE INDICATORS','PERFORMANCE INDICATORS','PENGURANG'].includes((row[1]||'').trim());
}
function isKkColNumRow(row){
  // Baris legenda nomor kolom (1,2,3,4,5,6,7,8,...) tepat di bawah header — bukan data sungguhan
  return (row[1]||'').trim() === '1' && (row[2]||'').trim() === '2' && (row[3]||'').trim() === '3';
}
function isKkCategoryRow(row){
  const label = (row[2]||'').trim();
  return /^[0-9]+$/.test((row[1]||'').trim()) && label && !/^[0-9.,\s]+$/.test(label) && !(row[16]||'').trim();
}
function isKkItemRow(row){
  return (row[16]||'').trim() && /[🟢🔴🟡🟣]/.test(row[16]);
}
function flagDot(flagStr){
  const f = (flagStr||'').trim();
  if(/🟢/.test(f)) return '<span class="kk-flag-dot green"></span>';
  if(/🟡/.test(f)) return '<span class="kk-flag-dot yellow"></span>';
  if(/🔴/.test(f)) return '<span class="kk-flag-dot red"></span>';
  if(/🟣/.test(f)) return '<span class="kk-flag-dot purple"></span>';
  return '';
}

function buildKertasKerjaTable(rows, title, periodLabel, monthLabel, monthIdx){
  if(!rows || !rows.length){
    return '<div class="kk-warn">Data belum tersedia.</div>';
  }
  const bodyRows = [];
  let started = false;
  let totalRowData = null;
  for(const row of rows){
    if((row[1]||'').trim() === 'NO' && (row[2]||'').trim() === 'URAIAN'){ started = true; continue; }
    if(!started) continue;
    if(isKkColNumRow(row)) continue; // lewati baris legenda nomor kolom
    // Baris TOTAL: cek beberapa kolom sekaligus (posisi kadang bergeser antar sheet) — simpan datanya lalu berhenti,
    // tidak perlu lagi baris berikutnya (termasuk baris kosong yang sempat salah dianggap "akhir tabel")
    const isTotalRow = [row[1],row[2],row[3]].some(c => (c||'').trim() === 'TOTAL');
    if(isTotalRow){ totalRowData = row; break; }
    if((row[2]||'').trim().startsWith('TOTAL PROPORSIONAL')) continue; // baris lama, tidak dipakai lagi (diganti hasil hitung sendiri)
    // Catatan: baris kosong (spacer visual di sheet, mis. antara item terakhir dan TOTAL) SENGAJA tidak menghentikan
    // loop di sini — cukup dilewati saja, karena tidak cocok dengan tipe section/category/item manapun.
    if(isKkSectionRow(row)) bodyRows.push({type:'section', row});
    else if(isKkCategoryRow(row)) bodyRows.push({type:'category', row});
    else if(isKkItemRow(row)) bodyRows.push({type:'item', row});
  }

  // Jika bulan yang dipilih BUKAN kolom statis "S/D BULAN" bawaan sheet, hitung ulang nilai TARGET/REALISASI/
  // PENCAPAIAN/BOBOT NILAI/BOBOT NILAI 110% untuk tiap item dari blok data bulanan (V:AI, AK:AX, AZ:BM, BQ:CB, CD:CQ)
  // sesuai bulan yang dipilih di dropdown, supaya kertas kerja bisa menyesuaikan bulan sebelumnya.
  const monthly = (monthIdx != null);
  let totalBobotNilai = 0, totalBobotNilai110 = 0;
  if(monthly){
    bodyRows.forEach(({type, row})=>{
      if(type !== 'item') return;
      row.__target = parseIDNum(row[23 + monthIdx]);
      row.__realisasi = parseIDNum(row[38 + monthIdx]);
      row.__pencapaian = parseIDNum(row[53 + monthIdx]);
      row.__bobotNilai = parseIDNum(row[68 + monthIdx]);
      row.__bobotNilai110 = parseIDNum(row[83 + monthIdx]);
      if(row.__bobotNilai !== null) totalBobotNilai += row.__bobotNilai;
      if(row.__bobotNilai110 !== null) totalBobotNilai110 += row.__bobotNilai110;
    });
  }

  // Bangun 3 baris ringkasan sendiri dari data baris TOTAL (kolom H=BOBOT, O=BOBOT NILAI, P=BOBOT NILAI 110%, R=GAP POINT)
  // — kalau mode bulanan aktif, BOBOT NILAI/110% dipakai dari hasil hitung ulang (jumlah seluruh item bulan itu)
  if(totalRowData){
    if(monthly){
      totalRowData = totalRowData.slice();
      totalRowData[14] = totalBobotNilai.toFixed(3).replace('.', ',');
      totalRowData[15] = totalBobotNilai110.toFixed(3).replace('.', ',');
    }
    bodyRows.push({type:'total-main', row:totalRowData});
    bodyRows.push({type:'total-spacer'});
    bodyRows.push({type:'total-prop', row:totalRowData});
    bodyRows.push({type:'total-prop110', row:totalRowData});
  }

  const rowsHtml = bodyRows.map(({type, row})=>{
    if(type === 'section'){
      const isPengurang = (row[1]||'').trim() === 'PENGURANG';
      const pageBreakStyle = isPengurang ? ' style="break-before:page; page-break-before:always;"' : '';
      return `<tr class="kk-section"${pageBreakStyle}><td colspan="16">${row[1]}</td></tr>`;
    }
    if(type === 'category'){
      return `<tr class="kk-category"><td class="kk-center">${row[1]}</td><td class="kk-uraian" colspan="15">${row[2]}</td></tr>`;
    }
    if(type === 'total-spacer'){
      return `<tr class="kk-total-spacer"><td colspan="16">&nbsp;</td></tr>`;
    }
    if(type === 'total-main'){
      // BOBOT(kolom H / index7), BOBOT NILAI(kolom O / index14), BOBOT NILAI 110%(kolom P / index15), GAP POINT(kolom R / index17)
      return `<tr class="kk-total"><td class="kk-center" colspan="2">TOTAL</td><td colspan="3"></td>
        <td class="kk-num">${row[7]||''}</td><td colspan="6"></td>
        <td class="kk-num">${row[14]||''}</td><td class="kk-num">${row[15]||''}</td>
        <td class="kk-center">${flagDot(row[16])}</td><td class="kk-num">${row[17]||''}</td></tr>`;
    }
    if(type === 'total-prop'){
      // Total Proporsional: nilai dari kolom O (BOBOT NILAI / index14)
      return `<tr class="kk-total"><td class="kk-center" colspan="2">TOTAL PROPORSIONAL</td><td colspan="13"></td>
        <td class="kk-num">${row[14]||''}</td></tr>`;
    }
    if(type === 'total-prop110'){
      // Total Proporsional 110%: nilai dari kolom P (BOBOT NILAI 110% / index15)
      return `<tr class="kk-total"><td class="kk-center" colspan="2">TOTAL PROPORSIONAL 110%</td><td colspan="13"></td>
        <td class="kk-num">${row[15]||''}</td></tr>`;
    }
    // item row — pakai hasil hitung ulang bulanan (row.__xxx) kalau mode bulanan aktif, else pakai kolom statis sheet
    const targetVal = monthly ? row.__target : row[10];
    const realisasiVal = monthly ? row.__realisasi : row[11];
    const pencapaianVal = monthly ? row.__pencapaian : row[12];
    const bobotNilaiVal = monthly ? row.__bobotNilai : row[14];
    const bobotNilai110Val = monthly ? row.__bobotNilai110 : row[15];
    return `<tr>
      <td class="kk-center">${row[1]}</td><td class="kk-uraian">${row[2]}</td><td class="kk-center">${row[3]||''}</td>
      <td class="kk-formula">${row[5]||''}</td><td class="kk-center">${row[6]||''}</td><td class="kk-num">${row[7]||''}</td>
      <td class="kk-num">${row[8]||''}</td><td class="kk-num">${row[9]||''}</td><td class="kk-num">${targetVal ?? ''}</td>
      <td class="kk-num">${realisasiVal ?? ''}</td><td class="kk-num">${pencapaianVal ?? ''}</td><td class="kk-num">${row[13]||''}</td>
      <td class="kk-num">${bobotNilaiVal ?? ''}</td><td class="kk-num">${bobotNilai110Val ?? ''}</td><td class="kk-center">${flagDot(row[16])}</td><td class="kk-num">${row[17]||''}</td>
    </tr>`;
  }).join('');

  return `
    <div class="kk-paper-scroll">
    <div class="kk-paper">
      <table>
        <colgroup>
          <col style="width:3%"><col style="width:14%"><col style="width:3%"><col style="width:19%">
          <col style="width:6%"><col style="width:4%"><col style="width:5%"><col style="width:5%">
          <col style="width:5%"><col style="width:5%"><col style="width:6%"><col style="width:6%">
          <col style="width:5%"><col style="width:5%"><col style="width:3%"><col style="width:5%">
        </colgroup>
        <thead>
          <tr class="kk-lh-row"><td colspan="16">
            <table class="kk-lh-inner"><tr>
              <td class="kk-logo-cell"><img src="{{ asset($settings['pln_logo'] ?? 'Logo_PLN.png') }}" alt="Logo PLN"></td>
              <td class="kk-lh-text">
                <b>PT PLN (PERSERO) UNIT INDUK PUSAT PENYALURAN DAN PENGATUR BEBAN SULAWESI</b><br>
                UNIT PELAKSANA TRANSMISI MANADO<br>
                JL. TOMPAKWA NO.1, BUMI NYIUR, KEC. WANEA, KOTA MANADO, SULAWESI UTARA 95117
              </td>
            </tr></table>
          </td></tr>
          <tr class="kk-title-row"><td colspan="16">
            <h3>PROGRES KINERJA PT PLN (PERSERO) ${title}</h3>
            <div class="kk-sub">PERIODE ${periodLabel}</div>
          </td></tr>
          <tr>
            <th>NO</th><th>URAIAN</th><th>POL</th><th>FORMULA</th><th>SATUAN</th><th>BOBOT</th>
            <th>TARGET SEM I</th><th>TARGET SEM 2</th><th>TARGET S/D ${monthLabel}</th>
            <th>REALISASI S/D ${monthLabel}</th><th>PENCAPAIAN S/D ${monthLabel}</th><th>PENCAPAIAN KOMULATIF</th>
            <th>BOBOT NILAI</th><th>BOBOT NILAI 110%</th><th>FLAG</th><th>GAP POINT</th>
          </tr>
        </thead>
        <tbody>${rowsHtml}</tbody>
      </table>
      <div class="kk-sign">
        <div class="kk-sign-box">
          <div>Manado, ${new Date().toLocaleDateString('id-ID',{day:'numeric',month:'long',year:'numeric'})}</div>
          <div>Manager PT PLN (Persero) UPT Manado</div>
          <div class="kk-sign-space"></div>
          <div><b>Zivion Octavino Silalahi</b></div>
        </div>
      </div>
    </div>
    </div>`;
}

function renderNkoUnitModule(rows, errMsg, loaded){
  const el = document.getElementById('content');
  const moduleTitle = document.createElement('div');
  moduleTitle.className = 'module-title';
  moduleTitle.id = 'nko-unit';
  moduleTitle.style.scrollMarginTop = 'calc(var(--topbar-h, 0px) + 12px)';
  moduleTitle.textContent = 'NKO UNIT — LEMBAR KERTAS KERJA';
  el.appendChild(moduleTitle);
  const wrap = document.createElement('div');
  wrap.className = 'table-wrap kk-print-root';
  wrap.style.padding = '18px';
  wrap.style.borderRadius = '0 0 8px 8px';
  el.appendChild(wrap);

  if(!loaded){ wrap.innerHTML = '<div class="loading">Memuat data kinerja per indikator...</div>'; return; }
  if(errMsg){ wrap.innerHTML = '<div class="err" style="padding:20px 0;">GAGAL MEMUAT DATA — ' + errMsg + '</div>'; return; }

  wrap.innerHTML = `
    <div class="kk-toolbar">
      <label for="kkUnitSelect" style="font-size:12px; color:var(--text-muted); font-weight:600;">Pilih Kertas Kerja:</label>
      <select id="kkUnitSelect">
        <option value="UPT">UPT Manado</option>
        <option value="SAWANGAN">ULTG Sawangan</option>
        <option value="LOPANA">ULTG Lopana</option>
        <option value="KOTAMOBAGU">ULTG Kotamobagu</option>
        <option value="GORONTALO">ULTG Gorontalo</option>
      </select>
      <label for="kkMonthSelect" style="font-size:12px; color:var(--text-muted); font-weight:600; margin-left:10px;">Bulan:</label>
      <select id="kkMonthSelect"></select>
      <button onclick="window.print()">🖨️ Print / Simpan PDF</button>
    </div>
    <div id="kkPaperArea"><div class="loading">Memuat kertas kerja...</div></div>`;

  const monthSelectEl = document.getElementById('kkMonthSelect');
  const maxIdx = (STATE.currentMonthIdx != null) ? STATE.currentMonthIdx : 11;
  for(let i=0;i<=maxIdx;i++){
    const opt = document.createElement('option');
    opt.value = i;
    opt.textContent = KPI_CHART_MONTHS[i] + (i===maxIdx ? ' (terbaru)' : '');
    monthSelectEl.appendChild(opt);
  }
  monthSelectEl.value = maxIdx;

  const select = document.getElementById('kkUnitSelect');
  select.addEventListener('change', ()=> loadKertasKerja(select.value, parseInt(monthSelectEl.value,10)));
  monthSelectEl.addEventListener('change', ()=> loadKertasKerja(select.value, parseInt(monthSelectEl.value,10)));
  loadKertasKerja('UPT', maxIdx);
}

async function loadKertasKerja(unitKey, monthIdx){
  const area = document.getElementById('kkPaperArea');
  if(!area) return;
  area.innerHTML = '<div class="loading">Memuat kertas kerja...</div>';

  const MONTH_ID_MAP = {JAN:'JANUARI',FEB:'FEBRUARI',MAR:'MARET',APR:'APRIL',MAY:'MEI',JUN:'JUNI',JUL:'JULI',AUG:'AGUSTUS',SEP:'SEPTEMBER',OCT:'OKTOBER',NOV:'NOVEMBER',DEC:'DESEMBER'};
  const MONTHS_CODE = ['JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC'];
  const idx = (monthIdx != null) ? monthIdx : 7;
  const monthCode = MONTHS_CODE[idx];
  const monthLabel = MONTH_ID_MAP[monthCode] || monthCode;

  if(unitKey === 'UPT'){
    const rows = STATE.kpiDetailRows;
    area.innerHTML = buildKertasKerjaTable(rows, 'UPT MANADO', monthLabel + ' 2026', monthCode, idx);
    return;
  }

  try{
    if(!STATE.ultgKerjaRows) STATE.ultgKerjaRows = await fetchCsv(ULTG_KERJA_CSV_URL, 15000);
    const rows = STATE.ultgKerjaRows;
    let activeUltg = null;
    for(const row of rows){
      row.forEach((cell,i)=>{ if((cell||'').trim() === 'ULTG:') activeUltg = (row[i+1]||'').trim().toUpperCase(); });
    }
    if(activeUltg && activeUltg !== unitKey){
      area.innerHTML = `<div class="kk-warn">
        ⚠️ Sel <b>"ULTG :"</b> pada sheet sumber saat ini aktif menunjukkan <b>ULTG ${activeUltg}</b>, bukan ULTG ${unitKey}.
        Data B2:R70 pada sheet itu hanya menampilkan SATU ULTG yang sedang aktif dipilih di sana.<br><br>
        Untuk melihat kertas kerja ULTG ${unitKey}, mohon ubah dulu sel "ULTG :" di sheet sumber menjadi ${unitKey}, lalu klik ulang pilihan ini.
      </div>`;
      return;
    }
    area.innerHTML = buildKertasKerjaTable(rows, 'ULTG ' + unitKey, monthLabel + ' 2026', monthCode, idx);
  }catch(e){
    area.innerHTML = '<div class="err">Gagal memuat data — ' + e.message + '</div>';
  }
}

function renderFoisModule(rows, errMsg, loaded){
  const el = document.getElementById('content');
  const moduleTitle = document.createElement('div');
  moduleTitle.className = 'module-title';
  moduleTitle.textContent = 'REKAP KEJADIAN GANGGUAN';
  el.appendChild(moduleTitle);
  const wrap = document.createElement('div');
  wrap.className = 'table-wrap';
  wrap.style.padding = '18px';
  wrap.style.borderRadius = '0 0 8px 8px';
  el.appendChild(wrap);

  if(!loaded){
    wrap.innerHTML = '<div class="loading">Memuat data gangguan (giliran setelah data kinerja &amp; referensi satuan)...</div>';
    return;
  }
  if(errMsg){
    wrap.innerHTML = '<div class="err" style="padding:20px 0;">GAGAL MEMUAT DATA GANGGUAN — ' + errMsg
      + '<br><br><a href="' + FOIS_CSV_URL + '" target="_blank" rel="noopener" style="color:var(--pln-blue)">↗ Buka link data mentah untuk cek manual</a></div>';
    return;
  }
  if(!rows.length){
    wrap.innerHTML = '<div class="err" style="padding:20px 0;">Sumber data gangguan berhasil dihubungi, tapi tidak ada baris yang cocok dengan format yang diharapkan. Kemungkinan struktur sheet berubah.'
      + '<br><br><a href="' + FOIS_CSV_URL + '" target="_blank" rel="noopener" style="color:var(--pln-blue)">↗ Buka link data mentah untuk cek manual</a></div>';
    return;
  }

  // 1. Ringkasan total
  const groupCounts = {};
  rows.forEach(r=>{ const g = effectiveGroup(r); groupCounts[g] = (groupCounts[g]||0)+1; });
  const summaryTitle = document.createElement('div');
  summaryTitle.className = 'cat-title';
  summaryTitle.textContent = 'Ringkasan Total Kejadian';
  wrap.appendChild(summaryTitle);
  const grid = document.createElement('div');
  grid.className = 'summary-grid fois-total-grid';
  [
    {label:'Grand Total', val: rows.length, icon:'∑'},
    {label:'Transmission', val: groupCounts['Transmission Line']||0, icon:'🗼'},
    {label:'Transformer', val: groupCounts['Transformer']||0, icon:'⚡'},
    {label:'Incoming', val: groupCounts['Incoming']||0, icon:'📥'},
    {label:'Another Bay', val: groupCounts['Another Bay']||0, icon:'📦'}
  ].forEach(c=>{
    const card = document.createElement('div');
    card.className = 'summary-card fois-total-card';
    card.innerHTML = `<div class="unit-name">${c.icon} ${c.label}</div><div class="fois-val">${c.val} <span class="fois-unit">kali</span></div>`;
    grid.appendChild(card);
  });
  wrap.appendChild(grid);

  // 2 & 4. Kontribusi per ULTG (kiri, + 2 donut) berdampingan dengan Pareto Penyebab (kanan, bar vertikal)
  const twoCol = document.createElement('div');
  twoCol.className = 'fois-2col';
  wrap.appendChild(twoCol);

  // Kolom kiri: Kontribusi per ULTG + Donut Kontribusi ULTG + Donut AR Sukses
  const ultgCol = document.createElement('div');
  const ultgColTitle = document.createElement('div');
  ultgColTitle.className = 'fois-col-title';
  ultgColTitle.textContent = 'Kontribusi per ULTG';
  ultgCol.appendChild(ultgColTitle);
  const ultgCounts = {};
  rows.forEach(r=>{ const u = (r[4]||'').trim() || 'Tidak diketahui'; ultgCounts[u] = (ultgCounts[u]||0)+1; });
  const ultgEntries = Object.entries(ultgCounts).sort((a,b)=>b[1]-a[1]);
  const ultgMax = ultgEntries.length ? ultgEntries[0][1] : 1;
  const ultgBars = document.createElement('div');
  ultgBars.innerHTML = ultgEntries.map(([label,val])=>barRow(label.replace('ULTG ',''), val, ultgMax)).join('');
  ultgCol.appendChild(ultgBars);

  // Donut 1: kontribusi ULTG (%) + Donut 2: performa AR sukses
  const donutRow = document.createElement('div');
  donutRow.className = 'donut-row';
  const DONUT_COLORS = ['#00529C','#FFC72C','#27AE60','#8E44AD','#E67E22'];
  donutRow.innerHTML = `
    <div class="donut-box">
      <div class="fois-col-title">Kontribusi ULTG (%)</div>
      <div class="donut-canvas-wrap"><canvas id="donutUltg"></canvas>
        <div class="donut-center-label"><div class="pct" id="donutUltgPct">0</div><div class="cap">Gangguan</div></div>
      </div>
      <div class="donut-legend-h" id="donutUltgLegend"></div>
    </div>
    <div class="donut-box">
      <div class="fois-col-title">Performa Auto Reclose</div>
      <div class="donut-canvas-wrap"><canvas id="donutAr"></canvas>
        <div class="donut-center-label"><div class="pct" id="donutArPct">0</div><div class="cap" id="donutArCap">Kejadian AR</div></div>
      </div>
      <div style="text-align:center; font-size:10px; color:var(--text-muted); margin-top:8px;">Klik potongan donut untuk lihat detail kejadian</div>
    </div>`;
  ultgCol.appendChild(donutRow);
  twoCol.appendChild(ultgCol);

  // Kolom kanan: Pareto Penyebab (vertikal)
  const causeCol = document.createElement('div');
  const causeColTitle = document.createElement('div');
  causeColTitle.className = 'fois-col-title';
  causeColTitle.textContent = 'Penyebab Gangguan (Pareto)';
  causeCol.appendChild(causeColTitle);
  const causeCounts = {};
  rows.forEach(r=>{ const c = (r[21]||'').trim() || 'Tidak diketahui'; causeCounts[c] = (causeCounts[c]||0)+1; });
  const causeEntries = Object.entries(causeCounts).sort((a,b)=>b[1]-a[1]);
  const causeMax = causeEntries.length ? causeEntries[0][1] : 1;
  const causeChart = document.createElement('div');
  causeChart.innerHTML = vBarChart(causeEntries, causeMax);
  causeCol.appendChild(causeChart);
  twoCol.appendChild(causeCol);

  // AR: 3 klasifikasi (Sukses/Gagal/Not Working) dari kolom AM:AO, khusus gangguan Transmission Line
  const arCategories = { sukses: [], gagal: [], notworking: [] };
  rows.forEach(r=>{
    if(effectiveGroup(r) !== 'Transmission Line') return;
    const eventInfo = { tanggal: r[10]||'-', substation: r[5]||'-', bay: r[6]||'-' };
    if((parseFloat(r[38])||0) > 0) arCategories.sukses.push(eventInfo);   // AM = Sukses
    if((parseFloat(r[39])||0) > 0) arCategories.gagal.push(eventInfo);    // AN = Gagal
    if((parseFloat(r[40])||0) > 0) arCategories.notworking.push(eventInfo); // AO = Not Working
  });

  // 3. Frekuensi per bulan (combo bar + line horizontal), dengan dropdown pembanding tahun sebelumnya
  const monthHeaderRow = document.createElement('div');
  monthHeaderRow.style.cssText = 'display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;margin:28px 0 10px;';
  const monthTitle = document.createElement('div');
  monthTitle.className = 'cat-title';
  monthTitle.style.margin = '0';
  monthTitle.style.border = 'none';
  monthTitle.style.padding = '0';
  monthTitle.textContent = 'Frekuensi Gangguan per Bulan';
  monthHeaderRow.appendChild(monthTitle);
  const yearSelect = document.createElement('select');
  yearSelect.className = 'year-select';
  yearSelect.id = 'foisYearCompare';
  yearSelect.innerHTML = `
    <option value="">Hanya 2026</option>
    <option value="1"${FOIS_PREV_YEAR_URLS[2025] ? '' : ' disabled'}>+1 Tahun Sebelum (2026 vs 2025)${FOIS_PREV_YEAR_URLS[2025] ? '' : ' — segera hadir'}</option>
    <option value="2"${FOIS_PREV_YEAR_URLS[2024] ? '' : ' disabled'}>+2 Tahun Sebelum (2026 vs 2025 vs 2024)${FOIS_PREV_YEAR_URLS[2024] ? '' : ' — segera hadir'}</option>`;
  monthHeaderRow.appendChild(yearSelect);
  wrap.appendChild(monthHeaderRow);

  const monthCounts = computeMonthCounts(rows);

  const monthChartWrap = document.createElement('div');
  monthChartWrap.style.cssText = 'position:relative; width:100%; height:340px; margin-bottom:20px;';
  monthChartWrap.innerHTML = '<canvas id="foisMonthChart"></canvas>';
  wrap.appendChild(monthChartWrap);

  yearSelect.onchange = ()=> renderMonthCombo(monthCounts);
  renderMonthCombo(monthCounts);
  renderDonuts(ultgEntries, arCategories);

  // 6. Tabel detail — collapsible, tersembunyi secara default
  const detailHeaderRow = document.createElement('div');
  detailHeaderRow.style.cssText = 'display:flex; align-items:center; gap:10px; margin:18px 0 8px;';
  detailHeaderRow.innerHTML = `
    <div class="cat-title" style="margin:0;">Detail Kejadian</div>
    <button id="toggleDetailBtn" class="detail-toggle-btn">Tampilkan ▾</button>`;
  wrap.appendChild(detailHeaderRow);
  const detailContainer = document.createElement('div');
  detailContainer.id = 'detailContainer';
  detailContainer.style.display = 'none';
  wrap.appendChild(detailContainer);

  const table = document.createElement('table');
  table.id = 'detailTable';
  const rowsHtml = rows.map(r => `<tr>
      <td>${r[10]||''}</td><td>${(r[4]||'').replace('ULTG ','')}</td><td>${r[5]||''}</td>
      <td>${r[6]||''}</td><td>${effectiveGroup(r)}</td><td>${r[21]||''}</td><td>${r[17]||''} jam</td>
    </tr>`).join('');
  const filterCols = ['Tanggal','ULTG','Gardu Induk','Bay','Kelompok','Penyebab','Durasi'];
  const filterRowHtml = '<tr class="filter-row">' + filterCols.map((c,i)=>
    `<th><input type="text" class="col-filter" data-col="${i}" placeholder="Filter ${c}..."></th>`
  ).join('') + '</tr>';
  table.innerHTML = `<thead><tr><th>Tanggal</th><th>ULTG</th><th>Gardu Induk</th><th>Bay</th><th>Kelompok</th><th>Penyebab</th><th>Durasi</th></tr>${filterRowHtml}</thead><tbody>${rowsHtml}</tbody>`;
  table.style.marginTop = '4px';
  detailContainer.appendChild(table);

  document.getElementById('toggleDetailBtn').addEventListener('click', function(){
    const isHidden = detailContainer.style.display === 'none';
    detailContainer.style.display = isHidden ? 'block' : 'none';
    this.textContent = isHidden ? 'Sembunyikan ▴' : 'Tampilkan ▾';
  });

  // Fitur filter per kolom: sembunyikan baris yang tidak cocok dengan SEMUA filter aktif
  table.querySelectorAll('.col-filter').forEach(input=>{
    input.addEventListener('input', ()=>{
      const filters = Array.from(table.querySelectorAll('.col-filter')).map(i=>i.value.trim().toLowerCase());
      table.querySelectorAll('tbody tr').forEach(tr=>{
        const cells = tr.children;
        let visible = true;
        filters.forEach((f,i)=>{
          if(f && !(cells[i] && cells[i].textContent.toLowerCase().includes(f))) visible = false;
        });
        tr.style.display = visible ? '' : 'none';
      });
    });
  });
}

function renderAll(){
  const contentEl = document.getElementById('content');
  contentEl.innerHTML = '';
  if(!STATE.categories.length){
    contentEl.innerHTML = '<div class="err">Tidak ada data terbaca dari sumber.</div>';
    return;
  }
  renderSummary(STATE.categories);
  renderFoisModule(STATE.foisRows, STATE.foisError, STATE.foisLoaded);
  renderKinerjaTransmisiChartsModule(STATE.kpiDetailRows, STATE.kpiDetailError, STATE.kpiDetailLoaded);
  renderPengendalianAiAttbModule(STATE.kpiDetailRows, STATE.kpiDetailError, STATE.kpiDetailLoaded);
  renderPenyelesaianSloModule(STATE.kpiDetailRows, STATE.kpiDetailError, STATE.kpiDetailLoaded);
  renderTataKelolaAsetModule(STATE.kpiDetailRows, STATE.kpiDetailError, STATE.kpiDetailLoaded);
  renderKinerjaKkuModule(STATE.kpiDetailRows, STATE.kpiDetailError, STATE.kpiDetailLoaded);
  renderKepatuhanProkerModule(STATE.kpiDetailRows, STATE.kpiDetailError, STATE.kpiDetailLoaded);
  renderKepatuhanModule(STATE.kpiDetailRows, STATE.kpiDetailError, STATE.kpiDetailLoaded);
  renderNkoUnitModule(STATE.kpiDetailRows, STATE.kpiDetailError, STATE.kpiDetailLoaded);
}

function populatePeriodDropdown(monthCode){
  const idx = MONTHS_ORDER.indexOf((monthCode||'').trim());
  STATE.currentMonthIdx = idx >= 0 ? idx : 0;
  STATE.selectedMonthIdx = STATE.currentMonthIdx;

  const select = document.getElementById('periodSelect');
  select.innerHTML = '';
  const available = MONTHS_ORDER.slice(0, STATE.currentMonthIdx + 1);
  available.forEach((m, i)=>{
    const opt = document.createElement('option');
    opt.value = i;
    opt.textContent = MONTH_MAP[m] + ' 2026' + (i === STATE.currentMonthIdx ? ' (terbaru)' : '');
    select.appendChild(opt);
  });
  select.value = STATE.currentMonthIdx;
  select.onchange = ()=>{
    STATE.selectedMonthIdx = parseInt(select.value, 10);
    renderAll();
  };
}

// Ambil satu sumber CSV dengan retry ringan (1x ulang bila gagal), supaya tidak mudah gugur
// akibat rate-limit sesaat dari Google Sheets ketika banyak request bersamaan.
async function fetchCsv(url, timeoutMs){
  timeoutMs = timeoutMs || 3000;
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
    if(url.startsWith('http://') || url.startsWith('https://')){
      console.warn('Direct fetch failed, trying proxy...', errDirect.message);
      const proxyUrl = '/api/proxy-csv?url=' + encodeURIComponent(url);
      return await doFetch(proxyUrl);
    }
    throw errDirect;
  }
}

function diagnosticMessage(err){
  const isFetchTypeError = err instanceof TypeError && /fetch/i.test(err.message);
  if(location.protocol === 'file:'){
    return 'Halaman ini dibuka langsung dari file lokal (file://), sehingga browser memblokir permintaan data ke Google Sheets. '
      + 'Solusi: taruh file ini di web server (mis. hosting biasa, atau jalankan lewat "Live Server"/`python -m http.server`), lalu buka lewat http:// atau https://.';
  }
  if(isFetchTypeError){
    return 'Koneksi ke sumber data terblokir sebelum sempat mendapat respons (biasanya karena CORS, ekstensi pemblokir iklan/skrip, atau firewall jaringan). '
      + 'Coba: (1) nonaktifkan sementara ad-blocker/ekstensi privasi, (2) coba di jaringan/browser lain, atau (3) klik link di bawah untuk memastikan link CSV masih bisa dibuka langsung.';
  }
  return err.message;
}

async function loadData(){
  if(!MAIN_CSV_URL || !MAIN_CSV_URL.trim()){
    document.getElementById('content').innerHTML = `
      <div style="background:var(--bg-card); border:1px solid var(--border-color); border-radius:12px; padding:60px 24px; text-align:center; max-width:680px; margin:40px auto; box-shadow:var(--card-shadow);">
        <div style="font-size:48px; margin-bottom:14px; opacity:0.8;">📊</div>
        <h3 style="font-size:18px; font-weight:800; color:var(--text-main); margin-bottom:8px;">Sumber Data Kinerja Unit Belum Dikonfigurasi</h3>
        <p style="font-size:13.5px; color:var(--text-muted); line-height:1.6; margin-bottom:20px;">
          Sumber data CSV untuk modul Kinerja Unit (NKO) belum diatur atau dinonaktifkan di menu <b>Sumber Data</b> pada Panel Admin. Silakan pilih metode URL atau Upload File CSV untuk menampilkan data indikator kinerja.
        </p>
      </div>`;
    const sel = document.getElementById('periodSelect');
    if(sel) sel.innerHTML = '<option>Tidak ada data</option>';
    return;
  }
  document.getElementById('content').innerHTML = '<div class="loading">MENGHUBUNGKAN KE SUMBER DATA...</div>';
  try{
    // 1) Muat data utama TERLEBIH DAHULU (jalur kritis) — ini yang menentukan tampil/tidaknya dashboard.
    const mainRows = await fetchCsv(MAIN_CSV_URL);

    let monthCode = null, lastUpdateStr = null;
    for(const row of mainRows){
      if(row[1] && row[1].includes('Last Update')){
        lastUpdateStr = row[3] || '';
        monthCode = row[9] || '';
        break;
      }
    }
    if(lastUpdateStr){
      const badge = document.querySelector('.status-badge');
      if(badge) badge.title = 'Data Sheet Update: ' + lastUpdateStr;
    }
    populatePeriodDropdown(monthCode);

    let cutoff = mainRows.length;
    for(let i=0;i<mainRows.length;i++){
      if(mainRows[i].some(c => c && c.includes('Perhitungan Persentase Capaian Kinerja'))){ cutoff = i; break; }
    }
    STATE.categories = buildIndicatorList(mainRows.slice(0, cutoff));
    renderAll(); // tampilkan dashboard secepatnya, jangan tunggu sumber tambahan

    // 2) Sumber TAMBAHAN (referensi satuan & histori bulanan) dimuat SETELAHNYA, satu-per-satu
    //    dan sepenuhnya best-effort — kegagalan di sini TIDAK boleh menggagalkan dashboard.
    loadSupplementaryData(mainRows.slice(0, cutoff));

  }catch(err){
    document.getElementById('content').innerHTML = '<div class="err">GAGAL MEMUAT DATA — ' + diagnosticMessage(err)
      + '<br><br><a href="' + MAIN_CSV_URL + '" target="_blank" rel="noopener" style="color:var(--pln-blue)">↗ Buka link data mentah untuk cek manual</a>'
      + '<br><br>Setelah memeriksa, klik REFRESH SEKARANG di atas.</div>';
  }
}

async function loadSupplementaryData(mainRowsSlice){
  // Log gangguan FOIS: diprioritaskan agar modul ini tampil cepat, tidak menunggu sumber lain
  try{
    const foisRaw = await fetchCsv(FOIS_CSV_URL, 12000);
    STATE.foisRows = foisRaw.filter(isFaultRow);
    STATE.foisError = null;
  }catch(e){
    STATE.foisError = diagnosticMessage(e);
  }
  STATE.foisLoaded = true;
  renderAll();

  // Breakdown Target/Realisasi bulanan per indikator (TRAF, CCAF, dst) — best-effort, dimuat belakangan
  try{
    STATE.kpiDetailRows = await fetchCsv(KPI_DETAIL_CSV_URL, 15000);
    STATE.kpiDetailError = null;
  }catch(e){
    STATE.kpiDetailError = diagnosticMessage(e);
  }
  STATE.kpiDetailLoaded = true;
  renderAll();

  // Data pembanding tahun sebelumnya (2024/2025): dimuat belakangan, best-effort
  STATE.foisPrevData = STATE.foisPrevData || {};
  if(FOIS_PREV_YEAR_URLS[2024]){
    try{
      const rows2024 = await fetchCsv(FOIS_PREV_YEAR_URLS[2024], 12000);
      STATE.foisPrevData[2024] = parseFois2024(rows2024);
      renderMonthCombo(computeMonthCounts(STATE.foisRows));
      populateYearDropdownAvailability();
    }catch(e){ /* data 2024 gagal dimuat, dropdown tetap nonaktif */ }
  }
  if(FOIS_PREV_YEAR_URLS[2025]){
    try{
      const rows2025 = await fetchCsv(FOIS_PREV_YEAR_URLS[2025], 12000);
      STATE.foisPrevData[2025] = parseFois2025(rows2025);
      renderMonthCombo(computeMonthCounts(STATE.foisRows));
      populateYearDropdownAvailability();
    }catch(e){ /* data 2025 gagal dimuat, dropdown tetap nonaktif */ }
  }

  // Referensi Satuan (kolom G): dimuat satu-per-satu (bukan paralel) agar tidak memicu rate-limit
  for(const url of UNIT_REF_URLS){
    try{
      const rows = await fetchCsv(url, 12000);
      Object.assign(STATE.unitMap, parseUnitReference(rows));
    }catch(e){ /* satu sumber gagal, lanjut ke berikutnya — tidak fatal */ }
  }
  if(Object.keys(STATE.unitMap).length){
    STATE.categories = buildIndicatorList(mainRowsSlice); // rebuild dengan satuan resmi
    renderAll();
  }

  // Histori bulanan asli per indikator: juga satu-per-satu
  for(const url of HIST_URLS){
    try{
      const rows = await fetchCsv(url, 12000);
      const blocks = parseHistoricalBlocks(rows);
      blocks.forEach(b=>{
        const ab = abbrevOf(b.title);
        if(ab) STATE.histMap[ab] = b.units;
      });
    }catch(e){ /* satu sumber gagal, lanjut ke berikutnya — tidak fatal */ }
  }
  renderAll();
}

document.getElementById('refreshBtn').addEventListener('click', loadData);
loadData();
setInterval(loadData, 5*60*1000);

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
  if(STATE.categories && STATE.categories.length) renderAll();
}
(function initTheme(){
  const saved = localStorage.getItem('theme') || 'light';
  document.documentElement.setAttribute('data-theme', saved);
  applyThemeUI(saved);
})();

// Mengukur tinggi topbar (header+hero) supaya sidebar sticky berhenti tepat di bawahnya
function updateTopbarHeight(){
  const header = document.querySelector('header');
  if(header) document.documentElement.style.setProperty('--header-h', header.offsetHeight + 'px');
  const topbar = document.getElementById('topbar');
  if(topbar) document.documentElement.style.setProperty('--topbar-h', topbar.offsetHeight + 'px');
}
updateTopbarHeight();
window.addEventListener('resize', updateTopbarHeight);
window.addEventListener('load', updateTopbarHeight);

// Hero scroll shrink
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
// Transisi halus antar halaman (fade out sebelum pindah ke halaman lokal lain)
document.addEventListener('click', (e)=>{
  const a = e.target.closest('a');
  if(!a) return;
  const href = a.getAttribute('href') || '';
  if(a.classList.contains('disabled')) { e.preventDefault(); return; }
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
