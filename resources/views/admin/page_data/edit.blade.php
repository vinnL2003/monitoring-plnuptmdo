<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Digitalisasi &amp; Studio Data: {{ $dataSource->name }} — PLN UPT Manado</title>
  <link rel="icon" type="image/png" href="{{ asset('Logo_UPT_Manado.png') }}?v=upt1">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=upt1">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v=upt1">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=upt1">
  <link rel="apple-touch-icon" href="{{ asset('Logo_UPT_Manado.png') }}?v=upt1">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">

  <style>
    :root {
      --pln-blue: #00529C;
      --pln-blue-dark: #00386C;
      --pln-blue-deep: #061E33;
      --pln-blue-light: #0284C7;
      --pln-yellow: #F59E0B;
      --pln-green: #16A34A;
      --pln-green-dark: #15803D;
      --border-color: #E2E8F0;
      --text-main: #0F172A;
      --text-muted: #64748B;
      --bg-app: #F8FAFC;
    }

    * { box-sizing: border-box; }

    html, body {
      margin: 0;
      padding: 0;
      width: 100%;
      height: 100%;
      overflow: hidden;
      font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, sans-serif;
      background: var(--bg-app);
      color: var(--text-main);
      display: flex;
      flex-direction: column;
    }

    /* TOP STUDIO BAR */
    .studio-topbar {
      background: linear-gradient(135deg, #061E33 0%, #003A6E 50%, #00529C 100%);
      color: #fff;
      padding: 10px 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 12px;
      border-bottom: 1px solid rgba(255,255,255,0.15);
      flex-shrink: 0;
      z-index: 50;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .studio-brand-identity {
      display: flex;
      align-items: center;
      gap: 14px;
    }
    .studio-logo { height: 34px; width: auto; }
    .studio-title-wrap h1 {
      font-size: 15px;
      font-weight: 800;
      margin: 0;
      color: #fff;
      display: flex;
      align-items: center;
      gap: 8px;
      line-height: 1.2;
    }
    .studio-title-wrap .sub {
      font-size: 11px;
      color: rgba(255,255,255,0.75);
      margin-top: 2px;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .key-badge {
      font-family: 'JetBrains Mono', monospace;
      font-size: 11px;
      background: rgba(255,255,255,0.18);
      color: #FEF08A;
      padding: 2px 7px;
      border-radius: 4px;
      font-weight: 600;
    }
    .status-badge-top {
      font-size: 11px;
      font-weight: 700;
      padding: 3px 8px;
      border-radius: 12px;
      display: inline-flex;
      align-items: center;
      gap: 4px;
    }
    .status-badge-top.file-mode { background: #DCFCE7; color: #14532D; }
    .status-badge-top.url-mode { background: #E0F2FE; color: #0369A1; }

    .studio-topbar-actions {
      display: flex;
      align-items: center;
      gap: 8px;
      flex-wrap: wrap;
    }
    .btn-topbar-secondary {
      background: rgba(255,255,255,0.12);
      border: 1px solid rgba(255,255,255,0.25);
      color: #fff;
      padding: 6px 12px;
      border-radius: 6px;
      font-size: 11.5px;
      font-weight: 600;
      text-decoration: none;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 5px;
      transition: all .2s;
    }
    .btn-topbar-secondary:hover {
      background: rgba(255,255,255,0.22);
      color: #fff;
    }

    /* ACTION TOOLBAR */
    .studio-toolbar {
      background: #fff;
      border-bottom: 1px solid var(--border-color);
      padding: 8px 18px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 8px;
      flex-shrink: 0;
      z-index: 40;
      box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .toolbar-group {
      display: flex;
      align-items: center;
      gap: 6px;
      flex-wrap: wrap;
    }

    .btn-primary-save {
      background: linear-gradient(135deg, #16A34A 0%, #15803D 100%);
      color: #fff;
      border: none;
      padding: 8px 18px;
      border-radius: 6px;
      font-size: 12.5px;
      font-weight: 800;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      box-shadow: 0 2px 8px rgba(22, 163, 74, 0.35);
      transition: all .15s ease;
    }
    .btn-primary-save:hover {
      background: #14532D;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(22, 163, 74, 0.45);
    }
    .btn-primary-save:disabled {
      opacity: 0.6;
      cursor: not-allowed;
      transform: none;
    }

    .btn-tool {
      background: #F8FAFC;
      border: 1px solid #CBD5E1;
      color: #334155;
      padding: 6px 11px;
      border-radius: 6px;
      font-size: 11.5px;
      font-weight: 600;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 5px;
      text-decoration: none;
      transition: all .15s;
    }
    .btn-tool:hover {
      background: #F1F5F9;
      border-color: #94A3B8;
      color: #0F172A;
    }
    .btn-tool.active {
      background: #00529C;
      color: #fff;
      border-color: #003E75;
    }

    .toolbar-divider {
      width: 1px;
      height: 24px;
      background: #E2E8F0;
      margin: 0 4px;
    }

    /* MODE SELECTOR PILLS */
    .view-mode-selector {
      display: inline-flex;
      background: #E2E8F0;
      padding: 3px;
      border-radius: 8px;
      gap: 2px;
    }
    .view-mode-btn {
      border: none;
      background: transparent;
      padding: 6px 12px;
      border-radius: 6px;
      font-size: 12px;
      font-weight: 700;
      color: #475569;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: all .15s;
    }
    .view-mode-btn.active {
      background: #fff;
      color: var(--pln-blue);
      box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }

    /* DIGITAL FORM WORKSPACE */
    .digital-form-workspace {
      flex: 1;
      width: 100%;
      height: 100%;
      overflow-y: auto;
      padding: 20px 24px 80px;
      background: #F1F5F9;
    }

    /* SECTION TABS FOR ABO / COMMON ENEMY */
    .section-nav-card {
      background: #fff;
      border: 1px solid var(--border-color);
      border-radius: 10px;
      padding: 12px 18px;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 12px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.02);
    }
    .section-pills {
      display: flex;
      align-items: center;
      gap: 8px;
      flex-wrap: wrap;
    }
    .section-pill-btn {
      background: #F8FAFC;
      border: 1px solid #CBD5E1;
      color: #334155;
      padding: 7px 14px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 700;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: all .15s;
    }
    .section-pill-btn:hover {
      background: #F1F5F9;
      border-color: #94A3B8;
    }
    .section-pill-btn.active {
      background: var(--pln-blue);
      color: #fff;
      border-color: var(--pln-blue-dark);
      box-shadow: 0 3px 10px rgba(0,82,156,0.3);
    }
    .section-pill-count {
      font-size: 10px;
      padding: 2px 6px;
      border-radius: 10px;
      background: rgba(0,0,0,0.12);
      font-weight: 800;
    }
    .section-pill-btn.active .section-pill-count {
      background: rgba(255,255,255,0.25);
      color: #fff;
    }

    .digital-search-box {
      width: 280px;
      max-width: 100%;
      position: relative;
    }
    .digital-search-box input {
      width: 100%;
      padding: 6px 12px 6px 30px;
      border: 1px solid #CBD5E1;
      border-radius: 6px;
      font-size: 12px;
      outline: none;
    }
    .digital-search-box .icon {
      position: absolute;
      left: 10px;
      top: 50%;
      transform: translateY(-50%);
      color: #94A3B8;
      font-size: 12px;
    }

    /* DIGITAL CARDS LIST */
    .digital-cards-list {
      display: flex;
      flex-direction: column;
      gap: 16px;
      max-width: 1300px;
      margin: 0 auto;
    }
    .program-card {
      background: #fff;
      border: 1px solid var(--border-color);
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,0.03);
      transition: border-color .2s, box-shadow .2s;
    }
    .program-card:hover {
      border-color: #CBD5E1;
      box-shadow: 0 4px 14px rgba(0,0,0,0.06);
    }
    .program-card.modified {
      border-left: 5px solid #F59E0B;
    }

    .card-head {
      background: #FAFBFD;
      border-bottom: 1px solid var(--border-color);
      padding: 12px 18px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 10px;
    }
    .card-identity {
      display: flex;
      align-items: center;
      gap: 10px;
      flex: 1;
      min-width: 280px;
    }
    .card-num-badge {
      width: 28px;
      height: 28px;
      border-radius: 6px;
      background: #E2E8F0;
      color: #334155;
      font-size: 12px;
      font-weight: 800;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }
    .card-section-tag {
      font-size: 11px;
      font-weight: 700;
      padding: 3px 8px;
      border-radius: 4px;
      background: #E0F2FE;
      color: #0369A1;
      text-transform: uppercase;
      letter-spacing: 0.3px;
    }
    .card-subinitiative-text {
      font-size: 12.5px;
      font-weight: 700;
      color: var(--pln-blue-dark);
    }
    .card-status-badge {
      font-size: 11px;
      font-weight: 700;
      padding: 3px 9px;
      border-radius: 12px;
      display: inline-flex;
      align-items: center;
      gap: 4px;
    }
    .card-status-badge.tercapai { background: #DCFCE7; color: #15803D; border: 1px solid #86EFAC; }
    .card-status-badge.hati-hati { background: #FEF3C7; color: #D97706; border: 1px solid #FCD34D; }
    .card-status-badge.tidak-tercapai { background: #FEE2E2; color: #DC2626; border: 1px solid #FCA5A5; }
    .card-status-badge.other { background: #F1F5F9; color: #64748B; border: 1px solid #E2E8F0; }

    .card-actions {
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .card-form-grid {
      padding: 18px 20px;
      display: grid;
      grid-template-columns: repeat(12, 1fr);
      gap: 14px;
    }
    .form-group {
      display: flex;
      flex-direction: column;
      gap: 5px;
    }
    .form-group label {
      font-size: 11px;
      font-weight: 700;
      color: var(--text-muted);
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .form-control-input, .form-control-select, .form-control-textarea {
      width: 100%;
      padding: 7px 10px;
      border: 1px solid #CBD5E1;
      border-radius: 6px;
      font-size: 12px;
      color: #0F172A;
      background: #fff;
      font-family: inherit;
      outline: none;
      transition: border-color .15s, box-shadow .15s;
    }
    .form-control-input:focus, .form-control-select:focus, .form-control-textarea:focus {
      border-color: var(--pln-blue);
      box-shadow: 0 0 0 2px rgba(0,82,156,0.15);
    }
    .form-control-textarea {
      resize: vertical;
      min-height: 52px;
      line-height: 1.4;
    }

    /* COLLAPSIBLE MONTHLY TABLE */
    .monthly-collapse-box {
      grid-column: span 12;
      background: #F8FAFC;
      border: 1px dashed #CBD5E1;
      border-radius: 8px;
      padding: 12px 14px;
      margin-top: 4px;
    }
    .monthly-head-toggle {
      display: flex;
      justify-content: space-between;
      align-items: center;
      cursor: pointer;
      font-size: 12px;
      font-weight: 700;
      color: var(--pln-blue);
      user-select: none;
    }
    .monthly-grid-12 {
      display: grid;
      grid-template-columns: repeat(12, 1fr);
      gap: 6px;
      margin-top: 10px;
    }
    @media (max-width: 900px) {
      .monthly-grid-12 { grid-template-columns: repeat(6, 1fr); }
    }
    .month-col-box {
      background: #fff;
      border: 1px solid #E2E8F0;
      border-radius: 5px;
      padding: 4px 6px;
      text-align: center;
    }
    .month-col-name {
      font-size: 10.5px;
      font-weight: 800;
      color: #475569;
      border-bottom: 1px solid #F1F5F9;
      padding-bottom: 2px;
      margin-bottom: 4px;
    }
    .month-sub-input {
      width: 100%;
      border: 1px solid #E2E8F0;
      border-radius: 3px;
      font-size: 11px;
      padding: 2px 4px;
      text-align: center;
      margin-bottom: 3px;
    }

    /* SPREADSHEET TABLE WORKSPACE */
    .spreadsheet-workspace {
      display: none;
      flex: 1;
      width: 100%;
      height: 100%;
      overflow: auto;
      position: relative;
      background: #fff;
    }
    .studio-table {
      border-collapse: separate;
      border-spacing: 0;
      table-layout: fixed;
      font-size: 12px;
      color: #1E293B;
      min-width: 100%;
    }
    .studio-table thead {
      position: sticky;
      top: 0;
      z-index: 25;
    }
    .studio-table th {
      background: #00529C;
      color: #fff;
      font-weight: 700;
      font-size: 11.5px;
      text-align: left;
      padding: 0;
      border-right: 1px solid rgba(255,255,255,0.18);
      border-bottom: 2px solid #003E75;
      position: relative;
      user-select: none;
      height: 38px;
    }
    .studio-table th.col-index-th {
      position: sticky;
      left: 0;
      top: 0;
      z-index: 30;
      width: 52px;
      min-width: 52px;
      max-width: 52px;
      text-align: center;
      background: #003E75;
    }
    .studio-table th.col-action-th {
      width: 80px;
      min-width: 80px;
      max-width: 80px;
      text-align: center;
      border-right: none;
      background: #003E75;
    }
    .th-inner {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 8px 12px;
      height: 100%;
      overflow: hidden;
      box-sizing: border-box;
    }
    .th-name {
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      flex: 1;
      cursor: pointer;
    }
    .col-resizer {
      position: absolute;
      top: 0;
      right: 0;
      width: 8px;
      height: 100%;
      cursor: col-resize;
      user-select: none;
      z-index: 35;
      background: transparent;
      transition: background .15s;
    }
    .col-resizer:hover, .col-resizer.resizing {
      background: var(--pln-yellow);
      box-shadow: 0 0 8px rgba(245, 158, 11, 0.8);
    }
    .studio-table td {
      padding: 0;
      border-bottom: 1px solid #E2E8F0;
      border-right: 1px solid #E2E8F0;
      vertical-align: top;
      background: #fff;
    }
    .studio-table td.cell-row-num {
      position: sticky;
      left: 0;
      z-index: 15;
      background: #F1F5F9;
      color: #64748B;
      font-weight: 700;
      font-size: 11px;
      text-align: center;
      padding: 8px 4px;
      user-select: none;
      border-right: 2px solid #CBD5E1;
      vertical-align: middle;
    }
    .grid-cell-input {
      width: 100%;
      height: 100%;
      border: 1px solid transparent;
      padding: 7px 10px;
      font-size: 12px;
      color: #0F172A;
      background: transparent;
      outline: none;
      font-family: inherit;
      box-sizing: border-box;
    }
    .grid-cell-input:focus {
      background: #fff;
      border-color: #0284C7;
      box-shadow: inset 0 0 0 2px rgba(2, 132, 199, 0.25);
    }
    .grid-cell-input.modified {
      background: #FEF9C3;
    }

    /* FORMULA & ACTIVE CELL BAR */
    .formula-bar {
      display: none;
      background: #F8FAFC;
      border-bottom: 1px solid var(--border-color);
      padding: 6px 18px;
      align-items: center;
      gap: 10px;
      flex-shrink: 0;
    }
    .cell-coordinate-box {
      background: #fff;
      border: 1px solid #CBD5E1;
      border-radius: 5px;
      padding: 5px 10px;
      font-family: 'JetBrains Mono', monospace;
      font-size: 11.5px;
      font-weight: 700;
      color: var(--pln-blue);
      min-width: 120px;
      text-align: center;
      user-select: none;
    }
    .formula-input {
      flex: 1;
      background: #fff;
      border: 1px solid #CBD5E1;
      border-radius: 5px;
      padding: 5px 12px;
      font-size: 12px;
      outline: none;
    }

    /* RAW CSV EDITOR */
    .raw-view-container {
      display: none;
      flex: 1;
      width: 100%;
      height: 100%;
      overflow: hidden;
      padding: 16px 20px;
      background: #fff;
    }
    .raw-textarea-full {
      width: 100%;
      height: 100%;
      font-family: 'JetBrains Mono', monospace;
      font-size: 12px;
      line-height: 1.5;
      padding: 16px;
      border: 1px solid #CBD5E1;
      border-radius: 8px;
      background: #F8FAFC;
      box-sizing: border-box;
      outline: none;
      white-space: pre;
      overflow: auto;
    }

    /* TOAST */
    .studio-toast {
      position: fixed;
      bottom: 24px;
      right: 24px;
      background: #0F172A;
      color: #fff;
      padding: 12px 18px;
      border-radius: 8px;
      font-size: 12.5px;
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: 10px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.3);
      z-index: 9999;
      transform: translateY(100px);
      opacity: 0;
      transition: all .25s ease;
    }
    .studio-toast.show { transform: translateY(0); opacity: 1; }
    .studio-toast.success { border-left: 5px solid #22C55E; }
    .studio-toast.error { border-left: 5px solid #EF4444; }

    /* MODAL */
    .modal-overlay {
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0,0,0,0.5);
      z-index: 1000;
      display: none;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }
    .modal-box {
      background: #fff;
      border-radius: 12px;
      max-width: 480px;
      width: 100%;
      padding: 20px 24px;
      box-shadow: 0 20px 40px rgba(0,0,0,0.25);
    }
    .modal-head {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 14px;
    }
    .modal-head h3 { font-size: 16px; font-weight: 800; color: var(--pln-blue-dark); margin: 0; }
    .modal-close { background: none; border: none; font-size: 18px; cursor: pointer; color: #94A3B8; }
  </style>
</head>
<body>

  <!-- TOP STUDIO NAVIGATION BAR -->
  <header class="studio-topbar">
    <div class="studio-brand-identity">
      <img src="{{ asset('Logo_UPT_Manado.png') }}" alt="PLN UPT Manado" class="studio-logo" style="height: 34px; width: auto; object-fit: contain;">
      <div class="studio-title-wrap">
        <h1>
          <span>📋</span> Editor Digitalisasi Halaman: {{ $dataSource->name }}
          <span class="key-badge">{{ $dataSource->key }}</span>
        </h1>
        <div class="sub">
          @if($dataSource->source_type === 'file')
            <span class="status-badge-top file-mode">🟢 File Lokal Server (Web Modifiable)</span>
          @elseif($dataSource->source_type === 'url')
            <span class="status-badge-top url-mode">🔵 Google Sheet Live URL</span>
          @else
            <span class="status-badge-top" style="background:#F1F5F9; color:#475569;">⚪ Manual</span>
          @endif
          <span>•</span>
          <span>Terkoneksi ke: 
            @forelse($pagesUsingThis as $p)
              <a href="{{ $p['url'] }}" target="_blank" style="color: #BAE6FD; text-decoration: underline;">{{ $p['title'] }} ↗</a>{{ !$loop->last ? ', ' : '' }}
            @empty
              <em>Umum</em>
            @endforelse
          </span>
          <span>•</span>
          <span id="metaStats">Total <strong id="topItemCount">0</strong> Program Kerja Terkelola</span>
        </div>
      </div>
    </div>

    <div class="studio-topbar-actions">
      <button type="button" class="btn-topbar-secondary" onclick="toggleFullScreen()" title="Layar penuh">
        ⛶ Layar Penuh
      </button>

      <a href="{{ route('admin.page-data.index') }}" class="btn-topbar-secondary" title="Kembali ke panel admin">
        ← Kembali ke Admin Panel
      </a>
    </div>
  </header>

  <!-- ACTION TOOLBAR -->
  <section class="studio-toolbar">
    <!-- LEFT: PRIMARY ACTIONS -->
    <div class="toolbar-group">
      <button type="button" class="btn-primary-save" id="btnSavePrimary" onclick="saveData()">
        💾 Simpan Perubahan ke CSV (Terapkan ke Web)
      </button>

      <span id="saveHint" style="font-size: 11.5px; color: var(--text-muted); font-weight: 600; margin-left: 2px;">
        (Ctrl+S)
      </span>

      <div class="toolbar-divider"></div>

      <!-- VIEW MODE SWITCHER -->
      <div class="view-mode-selector">
        <button type="button" class="view-mode-btn active" id="btnModeDigital" onclick="switchMainMode('digital')">
          📋 Formulir Digitalisasi (Mudah)
        </button>
        <button type="button" class="view-mode-btn" id="btnModeGrid" onclick="switchMainMode('grid')">
          📊 Visual Spreadsheet Grid
        </button>
        <button type="button" class="view-mode-btn" id="btnModeRaw" onclick="switchMainMode('raw')">
          📝 Raw CSV Text
        </button>
      </div>

      <div class="toolbar-divider"></div>

      <button type="button" class="btn-tool" onclick="addNewProgramItem()" title="Tambah Program Kerja Baru">
        ➕ Tambah Program Kerja
      </button>

      <button type="button" class="btn-tool" style="background:#EFF6FF; color:#0369A1; border-color:#BAE6FD; font-weight:700;" onclick="openAddColumnModal()" title="Tambahkan kolom baru ke data ini">
        ➕ Tambah Kolom Baru
      </button>
    </div>

    <!-- RIGHT: DATA SOURCE SYNC & DOWNLOAD -->
    <div class="toolbar-group">
      @if(!empty($dataSource->url))
        <form action="{{ route('admin.page-data.pull', $dataSource->key) }}" method="POST" onsubmit="return confirm('Tarik data segar dari Google Spreadsheet? Perubahan lokal yang belum disimpan akan tertimpa.');" style="display:inline;">
          @csrf
          <button type="submit" class="btn-tool" style="color: #15803D; border-color: #86EFAC; background: #F0FDF4;" title="Tarik data terbaru dari link Google Sheets">
            🔄 Tarik dari Google Sheet
          </button>
        </form>

        @if($dataSource->source_type === 'file')
          <form action="{{ route('admin.page-data.reset-live', $dataSource->key) }}" method="POST" onsubmit="return confirm('Alihkan kembali web untuk langsung membaca live Google Sheet URL?');" style="display:inline;">
            @csrf
            <button type="submit" class="btn-tool" style="color: #0369A1;" title="Kembali ke mode link Google Sheet">
              🔗 Reset ke Live Sheet
            </button>
          </form>
        @endif
      @endif

      <a href="{{ route('admin.page-data.download', $dataSource->key) }}" class="btn-tool" title="Unduh CSV untuk diekspor kembali ke Google Sheet / Excel">
        ⬇️ Unduh CSV
      </a>

      <button type="button" class="btn-tool" onclick="openUploadModal()" title="Unggah file CSV baru">
        📤 Unggah CSV
      </button>
    </div>
  </section>

  <!-- FORMULA BAR (FOR GRID MODE) -->
  <div class="formula-bar" id="formulaBar">
    <div class="cell-coordinate-box" id="cellCoordIndicator">Sel: [Pilih Sel]</div>
    <span style="font-family:'JetBrains Mono'; font-style:italic; font-weight:700; color:#94A3B8;">fx</span>
    <input type="text" class="formula-input" id="formulaInput" placeholder="Klik sel mana saja di tabel untuk melihat & mengedit isi..." oninput="onFormulaInput(this.value)">
  </div>

  <!-- WORKSPACE 1: FORMULIR DIGITALISASI (DEFAULT & USER-FRIENDLY) -->
  <main class="digital-form-workspace" id="digitalWorkspace">
    <!-- SECTION NAV PILLS (E.G. GARDU INDUK, JARINGAN, PROTEKSI / STREAM) -->
    <div class="section-nav-card" id="sectionNavCard">
      <div class="section-pills" id="sectionPillsContainer">
        <!-- Rendered by JS based on Bagian / Stream -->
      </div>

      <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
        <button type="button" class="btn-tool" style="background:#EFF6FF; color:#0369A1; border-color:#BAE6FD; font-weight:700; white-space:nowrap; padding:7px 12px; font-size:12px;" onclick="openAddColumnModal()">
          ➕ Tambah Kolom Baru pada Bagian Ini
        </button>

        <div class="digital-search-box">
          <span class="icon">🔍</span>
          <input type="text" id="digitalSearchInput" placeholder="Cari program kerja, sub initiative..." onkeyup="filterDigitalItems()">
        </div>
      </div>
    </div>

    <!-- DIGITAL CARDS LIST -->
    <div class="digital-cards-list" id="digitalCardsContainer">
      <!-- Program Kerja Cards rendered dynamically by JS -->
    </div>
  </main>

  <!-- WORKSPACE 2: VISUAL SPREADSHEET GRID (STANDALONE FULL SCREEN TABLE) -->
  <main class="spreadsheet-workspace" id="gridWorkspace">
    <table class="studio-table" id="spreadsheetTable">
      <thead id="spreadsheetHead">
        <!-- Rendered by JS with draggable column resizers -->
      </thead>
      <tbody id="spreadsheetBody">
        <!-- Rendered by JS -->
      </tbody>
    </table>
  </main>

  <!-- WORKSPACE 3: RAW CSV TEXT -->
  <main class="raw-view-container" id="rawWorkspace">
    <div style="margin-bottom: 8px; font-size: 12px; color: var(--text-muted); display: flex; justify-content: space-between; align-items: center;">
      <span>Teks CSV mentah. Klik tombol di kanan untuk menerapkan editan teks ke formulir digital &amp; grid.</span>
      <button type="button" class="btn-tool" style="background:#E0F2FE; color:var(--pln-blue); font-weight:700;" onclick="syncRawToAll()">
        🔄 Terapkan Teks CSV ke Formulir Digital &amp; Grid
      </button>
    </div>
    <textarea class="raw-textarea-full" id="rawCsvText" spellcheck="false">{{ $rawText }}</textarea>
  </main>

  <!-- ADD COLUMN MODAL -->
  <div class="modal-overlay" id="addColumnModal" style="display:none;">
    <div class="modal-box" style="max-width:520px;">
      <div class="modal-head">
        <h3>➕ Tambah Kolom Baru (Khusus Bagian)</h3>
        <button type="button" class="modal-close" onclick="closeAddColumnModal()">&times;</button>
      </div>
      <div style="padding: 18px 22px;">
        <p style="font-size: 12.5px; color: var(--text-muted); margin-bottom: 14px; line-height: 1.5;">
          Anda dapat menambahkan kolom kustom khusus untuk <strong>masing-masing bagian/stream</strong>. Kolom hanya akan muncul pada formulir kartu bagian terkait dan tidak akan mencemari bagian lainnya.
        </p>

        <!-- Target Bagian / Stream Selector -->
        <div style="margin-bottom: 14px;">
          <label style="font-size: 12px; font-weight: 700; color: #1E293B; display: block; margin-bottom: 5px;">
            Target Bagian / Stream *
          </label>
          <select id="newColumnSectionSelect" class="form-control-select" style="width: 100%; font-weight: 600;" onchange="updateModalSectionHelpText()">
            <!-- Populated dynamically: Proteksi, Trafo, SUTT/SUTET, Gardu Induk, dll -->
          </select>
          <div id="modalSectionHelp" style="font-size: 11.5px; color: #0369A1; background: #F0F9FF; border: 1px solid #BAE6FD; border-radius: 6px; padding: 6px 10px; margin-top: 6px; line-height: 1.4;">
            <!-- Dynamic help text -->
          </div>
        </div>

        <!-- Quick suggestion buttons -->
        <div style="margin-bottom: 14px;">
          <label style="font-size: 11px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 6px;">Pilihan Cepat Kolom:</label>
          <div style="display: flex; flex-wrap: wrap; gap: 6px;" id="quickColumnSuggestions">
            <!-- Rendered by JS according to dataset -->
          </div>
        </div>

        <div style="margin-bottom: 14px;">
          <label style="font-size: 12px; font-weight: 700; color: #334155; display: block; margin-bottom: 5px;">Nama Kolom Baru *</label>
          <input type="text" id="newColumnNameInput" class="form-control-input" placeholder="Contoh: Lokasi Project, Kendala, PIC Lapangan, Keterangan..." style="width: 100%; font-size: 13px;">
        </div>

        <div style="margin-bottom: 14px;">
          <label style="font-size: 12px; font-weight: 700; color: #334155; display: block; margin-bottom: 5px;">Tipe Input Formulir</label>
          <select id="newColumnTypeSelect" class="form-control-select" style="width: 100%;">
            <option value="text">Teks Singkat (Input Biasa)</option>
            <option value="textarea">Teks Panjang / Catatan Rincian (Textarea)</option>
            <option value="number">Angka / Nilai</option>
          </select>
        </div>

        <div style="margin-bottom: 18px;">
          <label style="font-size: 12px; font-weight: 700; color: #334155; display: block; margin-bottom: 5px;" id="newColumnDefaultLabel">Nilai Bawaan untuk Baris pada Bagian Tersebut (Opsional)</label>
          <input type="text" id="newColumnDefaultInput" class="form-control-input" placeholder="Kosongkan jika ingin diisi manual per item..." style="width: 100%;">
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 8px;">
          <button type="button" class="btn-tool" onclick="closeAddColumnModal()">Batal</button>
          <button type="button" class="btn-primary-save" id="btnSubmitAddCol" onclick="submitAddNewColumn()">Tambahkan Kolom ke Bagian Tersebut</button>
        </div>
      </div>
    </div>
  </div>

  <!-- UPLOAD MODAL -->
  <div class="modal-overlay" id="uploadModal">
    <div class="modal-box">
      <div class="modal-head">
        <h3>📤 Unggah File CSV Pengganti</h3>
        <button type="button" class="modal-close" onclick="closeUploadModal()">&times;</button>
      </div>
      <form action="{{ route('admin.page-data.upload', $dataSource->key) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 14px; line-height: 1.5;">
          Unggah file CSV baru dari komputer Anda untuk menimpa data <strong>{{ $dataSource->name }}</strong>. 
          Website akan langsung membaca file baru ini seketika.
        </p>

        <div style="margin-bottom: 18px;">
          <input type="file" name="csv_file" accept=".csv,text/csv" required style="width: 100%; padding: 12px; border: 1px dashed #CBD5E1; border-radius: 6px; background: #FAFBFD;">
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 8px;">
          <button type="button" class="btn-tool" onclick="closeUploadModal()">Batal</button>
          <button type="submit" class="btn-primary-save">Unggah &amp; Terapkan ke Web</button>
        </div>
      </form>
    </div>
  </div>

  <!-- TOAST NOTIFICATION -->
  <div class="studio-toast" id="studioToast">
    <span id="toastIcon">✅</span>
    <span id="toastMessage">Perubahan berhasil disimpan!</span>
  </div>

  <!-- SCRIPT ENGINE -->
  <script>
    // DATASET INITIALIZATION
    let RAW_ROWS = @json($rawRows ?? []);
    let HEADERS = @json($headers ?? []);
    const DATA_KEY = @json($dataSource->key);
    const SAVE_URL = @json(route('admin.page-data.save', $dataSource->key));

    // Active Section Filter for Digital Form
    let activeSectionFilter = 'ALL';
    let digitalItems = [];
    let isAboOrStream = false;
    let isDirty = false;
    let currentMainMode = 'digital'; // 'digital' | 'grid' | 'raw'

    // Column widths for Grid Mode
    let columnWidths = {};
    const DEFAULT_COL_WIDTH = 180;
    let activeCell = { row: null, col: null };

    // Month Names
    const MONTH_LABELS = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

    function initPage() {
      parseDigitalItems();
      renderSectionPills();
      renderDigitalCards();
      initGridHeaders();
      renderGridRows();
      updateTopStats();
    }

    function getHeaderRowIndex() {
      if (DATA_KEY === 'anti_blackout_csv') return 3;
      if (DATA_KEY === 'common_enemy_csv') return 1;
      return 0;
    }

    // Parse Header Section Tag: e.g. "[Proteksi] Lokasi Project" -> { section: 'Proteksi', name: 'Lokasi Project' }
    function parseHeaderSection(rawH) {
      const h = String(rawH || '').trim();
      const matchBracket = h.match(/^\[(.*?)\]\s*(.*)$/);
      if (matchBracket) {
        return { section: matchBracket[1].trim(), name: matchBracket[2].trim(), rawName: h };
      }
      const matchParen = h.match(/^(.*?)\s*\((.*?)\)$/);
      if (matchParen && !/^\d+|^1\s*tahun|%|rp/i.test(matchParen[2].trim())) {
        return { section: matchParen[2].trim(), name: matchParen[1].trim(), rawName: h };
      }
      return { section: 'ALL', name: h, rawName: h };
    }

    // Detect Custom / Added Columns in RAW_ROWS
    function detectCustomColumns() {
      const hRowIdx = getHeaderRowIndex();
      const headerRow = RAW_ROWS[hRowIdx] || [];
      const customCols = [];

      if (DATA_KEY === 'anti_blackout_csv') {
        const standardAboSet = new Set([
          'no', 'bagian', 'sub initiative', 'program kerja abo 2026', 'satuan', 'catt', 'target total',
          'target bulanan 2026', 'realisasi bulanan 2026', 'target kumulatif 2026', 'realisasi kumulatif 2026',
          'target 1 tahun', 'target kumulatif', 'realisasi kumulatif', '% capaian', 'status', 'kendala', 'lokasi project', 'justisikasi', 'justifikasi',
          'kolom_1', 'kolom_2'
        ]);
        for (let c = 0; c < headerRow.length; c++) {
          const h = String(headerRow[c] || '').trim();
          const hl = h.toLowerCase();
          if (h && !standardAboSet.has(hl) && !/^(jan|feb|mar|apr|mei|jun|jul|agu|sep|okt|nov|des)$/i.test(hl)) {
            const parsed = parseHeaderSection(h);
            customCols.push({ colIndex: c, rawName: h, name: parsed.name, section: parsed.section });
          }
        }
      } else if (DATA_KEY === 'common_enemy_csv') {
        const standardCeSet = new Set([
          'no', 'sasaran perbaikan', 'jumlah aset poor & critical', 'stream', 'program kerja', 'satuan',
          'ts/mi/ps/mcl', 'ai/ao', 'nilai rp.', 'target total (1 tahun)', 'target kumulatif',
          'relisasi kumulatif', 'realisasi kumulatif', '% capaian', 'status', 'justifikasi',
          'target', 'realisasi', 'januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'
        ]);
        for (let c = 0; c < headerRow.length; c++) {
          const h = String(headerRow[c] || '').trim();
          const hl = h.toLowerCase();
          if (h && !standardCeSet.has(hl) && !/^(jan|feb|mar|apr|mei|jun|jul|agu|sep|okt|nov|des)\s*m[1-4]$/i.test(hl) && !/^m[1-4]$/i.test(hl)) {
            const parsed = parseHeaderSection(h);
            customCols.push({ colIndex: c, rawName: h, name: parsed.name, section: parsed.section });
          }
        }
      } else {
        const initialCount = (HEADERS && HEADERS.length) ? HEADERS.length : (RAW_ROWS[0] ? RAW_ROWS[0].length : 0);
        for (let c = initialCount; c < headerRow.length; c++) {
          const h = String(headerRow[c] || '').trim();
          if (h) {
            const parsed = parseHeaderSection(h);
            customCols.push({ colIndex: c, rawName: h, name: parsed.name, section: parsed.section });
          }
        }
      }
      return customCols;
    }

    // 1. Parse Digital Items from RAW_ROWS
    function parseDigitalItems() {
      digitalItems = [];

      if (DATA_KEY === 'anti_blackout_csv') {
        isAboOrStream = true;
        RAW_ROWS.forEach((r, idx) => {
          const num = String(r[0] || '').trim();
          const bagian = String(r[1] || '').trim();
          if (/^[0-9]+$/.test(num) && bagian !== '') {
            digitalItems.push({
              rawIndex: idx,
              no: num,
              bagian: bagian, // e.g. Gardu Induk, Jaringan, Proteksi
              subInitiative: r[2] || '',
              programKerja: r[3] || '',
              satuan: r[4] || '',
              target1Tahun: r[55] || r[6] || '',
              targetKumulatif: r[56] || '',
              realisasiKumulatif: r[57] || '',
              pctCapaian: r[58] || '',
              status: r[59] || 'Tercapai',
              kendala: r[60] || '',
              lokasiProject: r[61] || '',
              justifikasi: r[62] || '',
              monthlyTarget: MONTH_LABELS.map((_, mIdx) => r[7 + mIdx] || ''),
              monthlyRealisasi: MONTH_LABELS.map((_, mIdx) => r[19 + mIdx] || '')
            });
          }
        });
      } else if (DATA_KEY === 'common_enemy_csv') {
        isAboOrStream = true;
        RAW_ROWS.forEach((r, idx) => {
          const num = String(r[0] || '').trim();
          const stream = String(r[3] || '').trim();
          if (/^[0-9]+$/.test(num) && stream !== '') {
            digitalItems.push({
              rawIndex: idx,
              no: num,
              bagian: stream, // Stream e.g. SUTT/SUTET, Pohon Rawan, Proteksi, dll
              subInitiative: r[1] || '', // Sasaran Perbaikan
              programKerja: r[4] || '', // Program Kerja
              satuan: r[5] || '',
              nilaiRp: r[8] || '',
              target1Tahun: r[9] || '',
              targetKumulatif: r[10] || '',
              realisasiKumulatif: r[11] || '',
              pctCapaian: r[12] || '',
              status: r[13] || 'On Target',
              justifikasi: r[14] || ''
            });
          }
        });
      } else {
        // Universal Smart Card Generator for all other CSVs (Asset, NKO, Anggaran, KKU, Kinerja Transmisi, dll)
        isAboOrStream = false;
        const hRowIdx = getHeaderRowIndex();
        const headerRow = RAW_ROWS[hRowIdx] || [];

        // 1. Detect Category / Bagian column
        let bgColIdx = -1;
        for (let c = 0; c < headerRow.length; c++) {
          const hl = String(headerRow[c] || '').toLowerCase().trim();
          if (/^(bagian|stream|kategori|bidang|pos|jenis|ultg|perspektif|kelompok)$/i.test(hl)) {
            bgColIdx = c;
            break;
          }
        }
        if (bgColIdx === -1) {
          for (let c = 0; c < headerRow.length; c++) {
            const hl = String(headerRow[c] || '').toLowerCase().trim();
            if (/bagian|stream|kategori|bidang|pos|jenis|ultg|perspektif/i.test(hl)) {
              bgColIdx = c;
              break;
            }
          }
        }

        // 2. Detect Program / Title column
        let titleColIdx = -1;
        for (let c = 0; c < headerRow.length; c++) {
          const hl = String(headerRow[c] || '').toLowerCase().trim();
          if (/program|kegiatan|uraian|indikator|nama|parameter|peralatan|pekerjaan/i.test(hl)) {
            titleColIdx = c;
            break;
          }
        }

        // 3. Detect Status column
        let statusColIdx = -1;
        for (let c = 0; c < headerRow.length; c++) {
          const hl = String(headerRow[c] || '').toLowerCase().trim();
          if (/^(status|kondisi|progress|tindak lanjut)$/i.test(hl)) {
            statusColIdx = c;
            break;
          }
        }

        // 4. Detect % Capaian column
        let pctColIdx = -1;
        for (let c = 0; c < headerRow.length; c++) {
          const hl = String(headerRow[c] || '').toLowerCase().trim();
          if (/%|capaian|persen/i.test(hl)) {
            pctColIdx = c;
            break;
          }
        }

        RAW_ROWS.slice(hRowIdx + 1).forEach((r, idx) => {
          const actualRowIndex = hRowIdx + 1 + idx;
          const noVal = String(r[0] || actualRowIndex).trim();

          // Compute meaningful section/bagian
          let sectionVal = 'Umum';
          if (bgColIdx !== -1 && r[bgColIdx] && String(r[bgColIdx]).trim()) {
            sectionVal = String(r[bgColIdx]).trim();
          } else if (r[1] && isNaN(r[1]) && !/^[0-9]+$/.test(r[1].trim()) && r[0] && /^[0-9]+$/.test(r[0].trim())) {
            if (titleColIdx > 1) {
              sectionVal = String(r[1]).trim();
            }
          }

          const programTitle = (titleColIdx !== -1 && r[titleColIdx] && String(r[titleColIdx]).trim())
            ? String(r[titleColIdx]).trim()
            : String(r[2] || r[1] || r[0] || `Item #${actualRowIndex}`).trim();

          const statusVal = (statusColIdx !== -1 && r[statusColIdx] && String(r[statusColIdx]).trim())
            ? String(r[statusColIdx]).trim()
            : 'Tercapai';

          const pctVal = (pctColIdx !== -1 && r[pctColIdx] && String(r[pctColIdx]).trim())
            ? String(r[pctColIdx]).trim()
            : '';

          if (programTitle !== '') {
            digitalItems.push({
              rawIndex: actualRowIndex,
              no: noVal || String(actualRowIndex),
              bagian: sectionVal,
              subInitiative: String(r[1] || programTitle),
              programKerja: programTitle,
              satuan: String(r[3] || ''),
              target1Tahun: String(r[4] || ''),
              realisasiKumulatif: String(r[5] || ''),
              pctCapaian: pctVal,
              status: statusVal,
              fields: r
            });
          }
        });
      }
    }

    // 2. Render Section Pills (e.g. Gardu Induk, Jaringan, Proteksi / Stream)
    function renderSectionPills() {
      const container = document.getElementById('sectionPillsContainer');
      container.innerHTML = '';

      const sectionsMap = {};
      digitalItems.forEach(it => {
        const bg = it.bagian || 'Umum';
        sectionsMap[bg] = (sectionsMap[bg] || 0) + 1;
      });

      const allBtn = document.createElement('button');
      allBtn.type = 'button';
      allBtn.className = 'section-pill-btn ' + (activeSectionFilter === 'ALL' ? 'active' : '');
      const allLabel = DATA_KEY === 'common_enemy_csv' ? 'Semua Stream' : (DATA_KEY === 'anti_blackout_csv' ? 'Semua Bagian' : 'Semua Data');
      allBtn.innerHTML = `🌐 ${allLabel} <span class="section-pill-count">${digitalItems.length}</span>`;
      allBtn.onclick = () => {
        activeSectionFilter = 'ALL';
        renderSectionPills();
        renderDigitalCards();
      };
      container.appendChild(allBtn);

      const icons = {
        'Gardu Induk': '🏢', 'Jaringan': '⚡', 'Proteksi': '🛡️',
        'SUTT/SUTET': '🗼', 'Trafo': '⚡', 'Catu Daya': '🔋', 'Pohon Rawan': '🌲',
        'Investasi': '💰', 'Operasi': '⚙️', 'Pemeliharaan': '🔧',
        'Keuangan': '💵', 'Komunikasi': '📢', 'Umum': '📁',
        'Sawangan': '⚡', 'Lopana': '⚡', 'Kotamobagu': '⚡', 'Gorontalo': '⚡',
        'SAIDI': '⏱️', 'SAIFI': '⚡', 'TLO': '📉', 'ENS': '💡', 'Trip': '⚠️'
      };

      Object.keys(sectionsMap).forEach(bg => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'section-pill-btn ' + (activeSectionFilter === bg ? 'active' : '');
        const icon = icons[bg] || '📁';
        btn.innerHTML = `${icon} ${bg} <span class="section-pill-count">${sectionsMap[bg]}</span>`;
        btn.onclick = () => {
          activeSectionFilter = bg;
          renderSectionPills();
          renderDigitalCards();
        };
        container.appendChild(btn);
      });
    }

    // Render Custom Fields HTML block for a card scoped strictly per Section/Stream
    function renderCustomFieldsHtml(rawIndex, itemBagian) {
      const allCustomCols = detectCustomColumns();
      // Filter columns that belong to this section or are global
      const sectionCols = allCustomCols.filter(col => {
        if (col.section === 'ALL') return true;
        return col.section.toLowerCase() === String(itemBagian || '').trim().toLowerCase();
      });

      const sectionLabel = itemBagian || (DATA_KEY === 'common_enemy_csv' ? 'Stream Ini' : 'Bagian Ini');

      if (!sectionCols || sectionCols.length === 0) {
        return `
          <div style="grid-column: span 12; margin-top: 6px; padding: 10px 14px; background: #F8FAFC; border: 1px dashed #CBD5E1; border-radius: 8px; display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-wrap: wrap;">
            <span style="font-size: 11.5px; color: var(--text-muted);">
              💡 Ingin menambahkan kolom khusus bagian <strong>${escapeHtml(sectionLabel)}</strong> (mis. Lokasi Project, Kendala, PIC)?
            </span>
            <button type="button" class="btn-tool" style="padding: 4px 10px; font-size: 11px; background: #EFF6FF; color: #0369A1; border-color: #BAE6FD; font-weight: 700;" onclick="openAddColumnModal('${escapeHtml(itemBagian || '')}')">
              ➕ Tambah Kolom Khusus ${escapeHtml(sectionLabel)}
            </button>
          </div>
        `;
      }

      return `
        <div style="grid-column: span 12; margin-top: 10px; padding: 12px 14px; background: #FAFBFD; border: 1px solid #E2E8F0; border-radius: 8px;">
          <div style="font-size: 11px; font-weight: 800; color: #0284C7; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 10px; display:flex; align-items:center; justify-content:space-between; flex-wrap: wrap; gap: 8px;">
            <span style="display:flex; align-items:center; gap:6px;">
              <span>📌 Kolom Khusus Bagian: <strong>${escapeHtml(sectionLabel)}</strong></span>
              <span style="background:#E0F2FE; color:#0369A1; padding:2px 7px; border-radius:10px; font-size:10.5px;">${sectionCols.length}</span>
            </span>
            <button type="button" class="btn-tool" style="padding:3px 8px; font-size:11px;" onclick="openAddColumnModal('${escapeHtml(itemBagian || '')}')">+ Tambah Kolom ${escapeHtml(sectionLabel)}</button>
          </div>
          <div style="display: grid; grid-template-columns: repeat(12, 1fr); gap: 10px;">
            ${sectionCols.map(col => {
              const val = (RAW_ROWS[rawIndex] && RAW_ROWS[rawIndex][col.colIndex] !== undefined) ? RAW_ROWS[rawIndex][col.colIndex] : '';
              const isLong = String(val).length > 50 || /kendala|catatan|keterangan|uraian|justifikasi/i.test(col.name);
              const span = isLong ? 6 : (sectionCols.length === 1 ? 6 : 4);
              return `
                <div class="form-group" style="grid-column: span ${span};">
                  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
                    <label style="margin:0; font-weight:700; color:#1E293B;">
                      ${escapeHtml(col.name)}
                      ${col.section === 'ALL' ? '<span style="font-size:9.5px; font-weight:normal; color:#64748B;"> (Global)</span>' : ''}
                    </label>
                    <button type="button" style="background:none; border:none; color:#DC2626; cursor:pointer; font-size:11px; padding:0 2px;" title="Hapus kolom '${escapeHtml(col.rawName)}' dari bagian ${escapeHtml(sectionLabel)}" onclick="deleteCustomColumn(${col.colIndex}, '${escapeHtml(col.rawName)}')">
                      🗑️ Hapus
                    </button>
                  </div>
                  ${isLong ? `
                    <textarea class="form-control-textarea" placeholder="Isi ${escapeHtml(col.name)}..." oninput="updateCustomField(${rawIndex}, ${col.colIndex}, this.value)">${escapeHtml(val)}</textarea>
                  ` : `
                    <input type="text" class="form-control-input" value="${escapeHtml(val)}" placeholder="Isi ${escapeHtml(col.name)}..." oninput="updateCustomField(${rawIndex}, ${col.colIndex}, this.value)">
                  `}
                </div>
              `;
            }).join('')}
          </div>
        </div>
      `;
    }

    // 3. Render Digital Cards (Tailored per dataset)
    function renderDigitalCards() {
      const container = document.getElementById('digitalCardsContainer');
      container.innerHTML = '';

      const searchQ = (document.getElementById('digitalSearchInput').value || '').trim().toLowerCase();

      const filtered = digitalItems.filter(it => {
        if (activeSectionFilter !== 'ALL' && it.bagian !== activeSectionFilter) return false;
        if (searchQ) {
          const haystack = (it.programKerja + ' ' + (it.subInitiative || '') + ' ' + it.bagian + ' ' + (it.lokasiProject || '') + ' ' + (it.kendala || '')).toLowerCase();
          if (!haystack.includes(searchQ)) return false;
        }
        return true;
      });

      if (filtered.length === 0) {
        container.innerHTML = `
          <div style="background:#fff; border:1px solid #CBD5E1; border-radius:12px; padding:48px 20px; text-align:center; color:#94A3B8;">
            <div style="font-size:36px; margin-bottom:8px;">🔍</div>
            <h4 style="font-size:16px; font-weight:700; color:#475569; margin:0 0 6px;">Tidak ada Program Kerja ditemukan</h4>
            <p style="font-size:12.5px; margin:0;">Coba ganti filter Bagian atau kata kunci pencarian Anda.</p>
          </div>
        `;
        return;
      }

      filtered.forEach(it => {
        const card = document.createElement('div');
        card.className = 'program-card';
        card.id = `card-item-${it.rawIndex}`;

        let statusClass = 'tercapai';
        const stLower = (it.status || '').toLowerCase();
        if (stLower.includes('hati') || stLower.includes('late')) statusClass = 'hati-hati';
        else if (stLower.includes('tidak') || stLower.includes('out') || stLower.includes('kritis') || stLower.includes('kurang')) statusClass = 'tidak-tercapai';

        // CARD HEAD
        const cardHeadHtml = `
          <div class="card-head">
            <div class="card-identity">
              <div class="card-num-badge">#${it.no}</div>
              <span class="card-section-tag">${escapeHtml(it.bagian)}</span>
              <div class="card-subinitiative-text">${escapeHtml(it.programKerja || it.subInitiative)}</div>
              <span class="card-status-badge ${statusClass}" id="statusBadge-${it.rawIndex}">${escapeHtml(it.status || 'Tercapai')}</span>
              ${it.pctCapaian ? `<span style="font-size:11px; font-weight:800; color:#0284C7; background:#E0F2FE; padding:2px 8px; border-radius:10px;">${escapeHtml(it.pctCapaian)}</span>` : ''}
            </div>

            <div class="card-actions">
              <button type="button" class="btn-tool" style="padding:4px 8px; font-size:11px;" title="Duplikat program kerja ini" onclick="duplicateProgramItem(${it.rawIndex})">
                📋 Duplikat
              </button>
              <button type="button" class="btn-tool" style="padding:4px 8px; font-size:11px; color:#DC2626;" title="Hapus program kerja ini" onclick="deleteProgramItem(${it.rawIndex})">
                🗑️ Hapus
              </button>
            </div>
          </div>
        `;

        if (DATA_KEY === 'common_enemy_csv') {
          // COMMON ENEMY SPECIFIC FORM (NO ABO LABELS, NO EMPTY LOKASI/KENDALA BY DEFAULT)
          card.innerHTML = `
            ${cardHeadHtml}
            <div class="card-form-grid">
              <!-- ROW 1: STREAM, SASARAN PERBAIKAN, PROGRAM KERJA -->
              <div class="form-group" style="grid-column: span 3;">
                <label>Stream / Kategori</label>
                <input type="text" class="form-control-input" value="${escapeHtml(it.bagian)}" oninput="updateItemField(${it.rawIndex}, 3, this.value, 'bagian')">
              </div>

              <div class="form-group" style="grid-column: span 4;">
                <label>Sasaran Perbaikan</label>
                <input type="text" class="form-control-input" value="${escapeHtml(it.subInitiative)}" oninput="updateItemField(${it.rawIndex}, 1, this.value, 'subInitiative')">
              </div>

              <div class="form-group" style="grid-column: span 5;">
                <label>Program Kerja</label>
                <input type="text" class="form-control-input" value="${escapeHtml(it.programKerja)}" style="font-weight:700;" oninput="updateItemField(${it.rawIndex}, 4, this.value, 'programKerja')">
              </div>

              <!-- ROW 2: SATUAN, TARGET 1 TAHUN, TARGET KUMULATIF, REALISASI, % CAPAIAN, STATUS -->
              <div class="form-group" style="grid-column: span 2;">
                <label>Satuan</label>
                <input type="text" class="form-control-input" value="${escapeHtml(it.satuan)}" placeholder="Bay, Span, Tower..." oninput="updateItemField(${it.rawIndex}, 5, this.value, 'satuan')">
              </div>

              <div class="form-group" style="grid-column: span 2;">
                <label>Target 1 Tahun</label>
                <input type="text" class="form-control-input" value="${escapeHtml(it.target1Tahun)}" oninput="updateItemField(${it.rawIndex}, 9, this.value, 'target1Tahun')">
              </div>

              <div class="form-group" style="grid-column: span 2;">
                <label>Target Kumulatif</label>
                <input type="text" class="form-control-input" value="${escapeHtml(it.targetKumulatif)}" oninput="updateItemField(${it.rawIndex}, 10, this.value, 'targetKumulatif')">
              </div>

              <div class="form-group" style="grid-column: span 2;">
                <label>Realisasi Kumulatif</label>
                <input type="text" class="form-control-input" value="${escapeHtml(it.realisasiKumulatif)}" style="font-weight:700; color:#15803D;" oninput="updateItemField(${it.rawIndex}, 11, this.value, 'realisasiKumulatif')">
              </div>

              <div class="form-group" style="grid-column: span 2;">
                <label>% Capaian</label>
                <input type="text" class="form-control-input" value="${escapeHtml(it.pctCapaian)}" placeholder="100.00%" oninput="updateItemField(${it.rawIndex}, 12, this.value, 'pctCapaian')">
              </div>

              <div class="form-group" style="grid-column: span 2;">
                <label>Status</label>
                <select class="form-control-select" onchange="updateItemStatusCE(${it.rawIndex}, this.value)">
                  <option value="On Target" ${it.status === 'On Target' ? 'selected' : ''}>🟢 On Target</option>
                  <option value="Late" ${it.status === 'Late' ? 'selected' : ''}>🟡 Late</option>
                  <option value="Out" ${it.status === 'Out' ? 'selected' : ''}>🔴 Out</option>
                  <option value="Tercapai" ${it.status === 'Tercapai' ? 'selected' : ''}>🟢 Tercapai</option>
                  <option value="Hati-hati" ${it.status === 'Hati-hati' ? 'selected' : ''}>🟡 Hati-hati</option>
                  <option value="Tidak Tercapai" ${it.status === 'Tidak Tercapai' ? 'selected' : ''}>🔴 Tidak Tercapai</option>
                </select>
              </div>

              <!-- ROW 3: NILAI RP. & JUSTIFIKASI -->
              <div class="form-group" style="grid-column: span 3;">
                <label>Nilai Rp.</label>
                <input type="text" class="form-control-input" value="${escapeHtml(it.nilaiRp || '')}" placeholder="Rp0.00" oninput="updateItemField(${it.rawIndex}, 8, this.value, 'nilaiRp')">
              </div>

              <div class="form-group" style="grid-column: span 9;">
                <label>Justifikasi / Rincian</label>
                <textarea class="form-control-textarea" placeholder="Keterangan justifikasi program..." oninput="updateItemField(${it.rawIndex}, 14, this.value, 'justifikasi')">${escapeHtml(it.justifikasi || '')}</textarea>
              </div>

              <!-- CUSTOM / ADDED COLUMNS -->
              ${renderCustomFieldsHtml(it.rawIndex, it.bagian)}
            </div>
          `;
        } else if (DATA_KEY === 'anti_blackout_csv') {
          // ABO SPECIFIC FORM (BAGIAN, SUB INITIATIVE, ABO 2026, LOKASI PROJECT, KENDALA)
          card.innerHTML = `
            ${cardHeadHtml}
            <div class="card-form-grid">
              <!-- ROW 1: BAGIAN & SUB INITIATIVE -->
              <div class="form-group" style="grid-column: span 3;">
                <label>Bagian / Kategori</label>
                <input type="text" class="form-control-input" value="${escapeHtml(it.bagian)}" oninput="updateItemField(${it.rawIndex}, 1, this.value, 'bagian')">
              </div>

              <div class="form-group" style="grid-column: span 4;">
                <label>Sub Initiative</label>
                <input type="text" class="form-control-input" value="${escapeHtml(it.subInitiative)}" oninput="updateItemField(${it.rawIndex}, 2, this.value, 'subInitiative')">
              </div>

              <div class="form-group" style="grid-column: span 5;">
                <label>Program Kerja ABO 2026</label>
                <input type="text" class="form-control-input" value="${escapeHtml(it.programKerja)}" style="font-weight:700;" oninput="updateItemField(${it.rawIndex}, 3, this.value, 'programKerja')">
              </div>

              <!-- ROW 2: TARGET, REALISASI, STATUS -->
              <div class="form-group" style="grid-column: span 2;">
                <label>Satuan</label>
                <input type="text" class="form-control-input" value="${escapeHtml(it.satuan)}" placeholder="GI, Span, %, Tower..." oninput="updateItemField(${it.rawIndex}, 4, this.value, 'satuan')">
              </div>

              <div class="form-group" style="grid-column: span 2;">
                <label>Target 1 Tahun</label>
                <input type="text" class="form-control-input" value="${escapeHtml(it.target1Tahun)}" oninput="updateItemField(${it.rawIndex}, 55, this.value, 'target1Tahun')">
              </div>

              <div class="form-group" style="grid-column: span 2;">
                <label>Target Kumulatif</label>
                <input type="text" class="form-control-input" value="${escapeHtml(it.targetKumulatif)}" oninput="updateItemField(${it.rawIndex}, 56, this.value, 'targetKumulatif')">
              </div>

              <div class="form-group" style="grid-column: span 2;">
                <label>Realisasi Kumulatif</label>
                <input type="text" class="form-control-input" value="${escapeHtml(it.realisasiKumulatif)}" style="font-weight:700; color:#15803D;" oninput="updateItemField(${it.rawIndex}, 57, this.value, 'realisasiKumulatif')">
              </div>

              <div class="form-group" style="grid-column: span 2;">
                <label>% Capaian</label>
                <input type="text" class="form-control-input" value="${escapeHtml(it.pctCapaian)}" placeholder="100.00%" oninput="updateItemField(${it.rawIndex}, 58, this.value, 'pctCapaian')">
              </div>

              <div class="form-group" style="grid-column: span 2;">
                <label>Status</label>
                <select class="form-control-select" onchange="updateItemStatus(${it.rawIndex}, this.value)">
                  <option value="Tercapai" ${it.status === 'Tercapai' ? 'selected' : ''}>🟢 Tercapai</option>
                  <option value="Hati-hati" ${it.status === 'Hati-hati' ? 'selected' : ''}>🟡 Hati-hati</option>
                  <option value="Tidak Tercapai" ${it.status === 'Tidak Tercapai' ? 'selected' : ''}>🔴 Tidak Tercapai</option>
                  <option value="Tidak Ada Target" ${it.status === 'Tidak Ada Target' ? 'selected' : ''}>⚪ Tidak Ada Target</option>
                </select>
              </div>

              <!-- ROW 3: LOKASI, KENDALA, JUSTIFIKASI -->
              <div class="form-group" style="grid-column: span 4;">
                <label>Lokasi Project</label>
                <input type="text" class="form-control-input" value="${escapeHtml(it.lokasiProject || '')}" placeholder="Lokasi GI / Tower / Jalur..." oninput="updateItemField(${it.rawIndex}, 61, this.value, 'lokasiProject')">
              </div>

              <div class="form-group" style="grid-column: span 4;">
                <label>Kendala</label>
                <textarea class="form-control-textarea" placeholder="Catatan kendala di lapangan..." oninput="updateItemField(${it.rawIndex}, 60, this.value, 'kendala')">${escapeHtml(it.kendala || '')}</textarea>
              </div>

              <div class="form-group" style="grid-column: span 4;">
                <label>Justifikasi / Rincian</label>
                <textarea class="form-control-textarea" placeholder="Keterangan justifikasi program..." oninput="updateItemField(${it.rawIndex}, 62, this.value, 'justifikasi')">${escapeHtml(it.justifikasi || '')}</textarea>
              </div>

              <!-- CUSTOM / ADDED COLUMNS -->
              ${renderCustomFieldsHtml(it.rawIndex, it.bagian)}

              <!-- COLLAPSIBLE MONTHLY BREAKDOWN (JAN - DES) -->
              ${it.monthlyTarget && it.monthlyTarget.length === 12 ? `
                <div class="monthly-collapse-box">
                  <div class="monthly-head-toggle" onclick="toggleMonthlyBox(${it.rawIndex})">
                    <span>📅 Rincian Target &amp; Realisasi Bulanan (Jan - Des)</span>
                    <span id="monthlyToggleIcon-${it.rawIndex}">▼ Buka Rincian Bulan</span>
                  </div>
                  <div class="monthly-grid-12" id="monthlyGrid-${it.rawIndex}" style="display:none;">
                    ${MONTH_LABELS.map((m, mIdx) => `
                      <div class="month-col-box">
                        <div class="month-col-name">${m}</div>
                        <input type="text" class="month-sub-input" placeholder="T" title="Target ${m}" value="${escapeHtml(it.monthlyTarget[mIdx] || '')}" oninput="updateMonthlyField(${it.rawIndex}, ${7 + mIdx}, this.value, ${mIdx}, 'target')">
                        <input type="text" class="month-sub-input" placeholder="R" title="Realisasi ${m}" style="color:#15803D; font-weight:700;" value="${escapeHtml(it.monthlyRealisasi[mIdx] || '')}" oninput="updateMonthlyField(${it.rawIndex}, ${19 + mIdx}, this.value, ${mIdx}, 'realisasi')">
                      </div>
                    `).join('')}
                  </div>
                </div>
              ` : ''}
            </div>
          `;
        } else {
          // UNIVERSAL SMART FORM GENERATOR FOR ALL OTHER DATASETS
          const hRowIdx = getHeaderRowIndex();
          const allCustomCols = detectCustomColumns();
          const customIndices = new Set(allCustomCols.map(c => c.colIndex));
          const curHeaders = (RAW_ROWS[hRowIdx] && RAW_ROWS[hRowIdx].length) ? RAW_ROWS[hRowIdx] : (HEADERS || []);
          
          card.innerHTML = `
            ${cardHeadHtml}
            <div class="card-form-grid">
              ${curHeaders.map((hdr, cIdx) => {
                if (customIndices.has(cIdx)) return '';
                const val = (RAW_ROWS[it.rawIndex] && RAW_ROWS[it.rawIndex][cIdx] !== undefined) ? RAW_ROWS[it.rawIndex][cIdx] : '';
                const hl = String(hdr || '').toLowerCase().trim();
                const isLong = String(val).length > 60 || /keterangan|catatan|deskripsi|uraian|justifikasi|kendala|tindak lanjut|rekomendasi/i.test(hl);
                const isStatus = /^(status|kondisi)$/i.test(hl);
                const isTitle = /program|uraian|indikator|nama|pekerjaan/i.test(hl);
                const isNumeric = /target|pagu|realisasi|satuan|%|capaian|bobot|nilai/i.test(hl);

                let span = 3;
                if (isLong) span = 6;
                else if (isTitle) span = 5;
                else if (isNumeric || isStatus) span = 2;
                else if (curHeaders.length <= 4) span = 6;

                return `
                  <div class="form-group" style="grid-column: span ${span};">
                    <label>${escapeHtml(hdr || `Kolom ${cIdx + 1}`)}</label>
                    ${isStatus ? `
                      <select class="form-control-select" onchange="updateCustomField(${it.rawIndex}, ${cIdx}, this.value); updateTopStats();">
                        <option value="Tercapai" ${val === 'Tercapai' ? 'selected' : ''}>🟢 Tercapai / On Target</option>
                        <option value="Hati-hati" ${val === 'Hati-hati' ? 'selected' : ''}>🟡 Hati-hati / Waspada</option>
                        <option value="Tidak Tercapai" ${val === 'Tidak Tercapai' ? 'selected' : ''}>🔴 Tidak Tercapai / Kritis</option>
                        ${val && !['Tercapai','Hati-hati','Tidak Tercapai'].includes(val) ? `<option value="${escapeHtml(val)}" selected>${escapeHtml(val)}</option>` : ''}
                      </select>
                    ` : (isLong ? `
                      <textarea class="form-control-textarea" placeholder="Isi ${escapeHtml(hdr)}..." oninput="updateCustomField(${it.rawIndex}, ${cIdx}, this.value)">${escapeHtml(val)}</textarea>
                    ` : `
                      <input type="text" class="form-control-input" value="${escapeHtml(val)}" ${isTitle ? 'style="font-weight:700;"' : ''} placeholder="Isi ${escapeHtml(hdr)}..." oninput="updateCustomField(${it.rawIndex}, ${cIdx}, this.value)">
                    `)}
                  </div>
                `;
              }).join('')}
              ${renderCustomFieldsHtml(it.rawIndex, it.bagian)}
            </div>
          `;
        }

        container.appendChild(card);
      });
    }

    // Update Digital Item Field in Memory & Mark Dirty
    function updateItemField(rawIndex, colIndex, value, propertyName) {
      if (!RAW_ROWS[rawIndex]) RAW_ROWS[rawIndex] = [];
      RAW_ROWS[rawIndex][colIndex] = value;

      const item = digitalItems.find(x => x.rawIndex === rawIndex);
      if (item && propertyName) {
        item[propertyName] = value;
      }

      const card = document.getElementById(`card-item-${rawIndex}`);
      if (card) card.classList.add('modified');
      markDirty();
    }

    // Update Custom Field
    function updateCustomField(rawIndex, colIndex, value) {
      if (!RAW_ROWS[rawIndex]) RAW_ROWS[rawIndex] = [];
      RAW_ROWS[rawIndex][colIndex] = value;
      const card = document.getElementById(`card-item-${rawIndex}`);
      if (card) card.classList.add('modified');
      markDirty();
    }

    // Update Status with immediate badge update
    function updateItemStatus(rawIndex, newStatus) {
      updateItemField(rawIndex, 59, newStatus, 'status');
      const badge = document.getElementById(`statusBadge-${rawIndex}`);
      if (badge) {
        badge.textContent = newStatus;
        badge.className = 'card-status-badge';
        const stLower = newStatus.toLowerCase();
        if (stLower.includes('hati')) badge.classList.add('hati-hati');
        else if (stLower.includes('tidak') || stLower.includes('kritis') || stLower.includes('kurang')) badge.classList.add('tidak-tercapai');
        else badge.classList.add('tercapai');
      }
    }

    // Update Status for Common Enemy
    function updateItemStatusCE(rawIndex, newStatus) {
      updateItemField(rawIndex, 13, newStatus, 'status');
      const badge = document.getElementById(`statusBadge-${rawIndex}`);
      if (badge) {
        badge.textContent = newStatus;
        badge.className = 'card-status-badge';
        const stLower = newStatus.toLowerCase();
        if (stLower.includes('late') || stLower.includes('hati')) badge.classList.add('hati-hati');
        else if (stLower.includes('out') || stLower.includes('tidak') || stLower.includes('kritis') || stLower.includes('kurang')) badge.classList.add('tidak-tercapai');
        else badge.classList.add('tercapai');
      }
    }

    // Modal Add Column Functions
    function updateModalSectionHelpText() {
      const select = document.getElementById('newColumnSectionSelect');
      const help = document.getElementById('modalSectionHelp');
      const submitBtn = document.getElementById('btnSubmitAddCol');
      const defaultLabel = document.getElementById('newColumnDefaultLabel');
      if (!select || !help) return;

      const val = select.value;
      if (val === 'ALL') {
        help.innerHTML = '🌐 Kolom akan diterapkan secara <strong>Global</strong> ke seluruh bagian dalam halaman ini.';
        if (submitBtn) submitBtn.textContent = 'Tambahkan Kolom ke Seluruh Data';
        if (defaultLabel) defaultLabel.textContent = 'Nilai Bawaan untuk Semua Baris yang Ada (Opsional)';
      } else {
        help.innerHTML = `🎯 Kolom akan diberi tag <strong>[${escapeHtml(val)}]</strong> dan <strong>hanya muncul pada bagian "${escapeHtml(val)}"</strong>. Bagian lainnya tidak akan terpengaruh.`;
        if (submitBtn) submitBtn.textContent = `Tambahkan Kolom Khusus ${val}`;
        if (defaultLabel) defaultLabel.textContent = `Nilai Bawaan untuk Baris pada Bagian "${val}" (Opsional)`;
      }
    }

    function updateQuickSuggestions() {
      const container = document.getElementById('quickColumnSuggestions');
      if (!container) return;
      container.innerHTML = '';

      let suggestions = [];
      if (DATA_KEY === 'common_enemy_csv') {
        suggestions = ['Lokasi Project', 'Kendala', 'PIC Lapangan', 'Keterangan Tambahan', 'Catatan Progres'];
      } else if (DATA_KEY === 'anti_blackout_csv') {
        suggestions = ['Lokasi Project', 'Kendala', 'PIC Pelaksana', 'Target Triwulan', 'Rekomendasi Tindak Lanjut', 'Keterangan Lapangan'];
      } else {
        suggestions = ['Keterangan Tambahan', 'Lokasi', 'PIC', 'Catatan Khusus', 'Status Verifikasi'];
      }

      suggestions.forEach(name => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'btn-tool';
        btn.style.cssText = 'padding: 4px 10px; font-size: 11.5px; background: #F1F5F9; border-color: #CBD5E1; color: #334155; font-weight:600;';
        btn.innerHTML = `+ ${name}`;
        btn.onclick = () => {
          document.getElementById('newColumnNameInput').value = name;
          if (/kendala|catatan|keterangan|rekomendasi/i.test(name)) {
            document.getElementById('newColumnTypeSelect').value = 'textarea';
          } else {
            document.getElementById('newColumnTypeSelect').value = 'text';
          }
        };
        container.appendChild(btn);
      });
    }

    function openAddColumnModal(targetSection) {
      const modal = document.getElementById('addColumnModal');
      if (!modal) return;

      // Extract all distinct sections
      const sectionsSet = new Set();
      digitalItems.forEach(it => {
        if (it.bagian) sectionsSet.add(it.bagian);
      });
      const sectionsList = Array.from(sectionsSet);

      const sectionSelect = document.getElementById('newColumnSectionSelect');
      if (sectionSelect) {
        sectionSelect.innerHTML = '';

        // First list specific sections
        sectionsList.forEach(sec => {
          const opt = document.createElement('option');
          opt.value = sec;
          opt.textContent = `🎯 Khusus Bagian: ${sec}`;
          sectionSelect.appendChild(opt);
        });

        // Also offer global option if user specifically wants it across all
        const allOpt = document.createElement('option');
        allOpt.value = 'ALL';
        allOpt.textContent = '🌐 Berlaku untuk Semua Bagian (Global)';
        sectionSelect.appendChild(allOpt);

        // Determine default selection
        let defaultSec = targetSection;
        if (!defaultSec && activeSectionFilter && activeSectionFilter !== 'ALL') {
          defaultSec = activeSectionFilter;
        }
        if (!defaultSec && sectionsList.length > 0) {
          defaultSec = sectionsList[0];
        }
        if (defaultSec) {
          sectionSelect.value = defaultSec;
        }
        updateModalSectionHelpText();
      }

      updateQuickSuggestions();

      document.getElementById('newColumnNameInput').value = '';
      document.getElementById('newColumnDefaultInput').value = '';
      modal.style.display = 'flex';
      setTimeout(() => document.getElementById('newColumnNameInput').focus(), 100);
    }

    function closeAddColumnModal() {
      const modal = document.getElementById('addColumnModal');
      if (modal) modal.style.display = 'none';
    }

    function submitAddNewColumn() {
      const nameInput = document.getElementById('newColumnNameInput');
      const baseColName = (nameInput.value || '').trim();
      const defaultVal = (document.getElementById('newColumnDefaultInput').value || '').trim();
      const selectedSection = document.getElementById('newColumnSectionSelect') ? document.getElementById('newColumnSectionSelect').value : 'ALL';

      if (!baseColName) {
        alert('Harap masukkan nama kolom baru!');
        nameInput.focus();
        return;
      }

      // Determine final header name and target section
      let finalHeaderName = baseColName;
      let targetSection = selectedSection;

      const existingBracket = baseColName.match(/^\[(.*?)\]\s*(.*)$/);
      if (existingBracket) {
        targetSection = existingBracket[1].trim();
        finalHeaderName = baseColName;
      } else if (targetSection && targetSection !== 'ALL') {
        finalHeaderName = `[${targetSection}] ${baseColName}`;
      }

      const hRowIdx = getHeaderRowIndex();
      if (!RAW_ROWS[hRowIdx]) RAW_ROWS[hRowIdx] = [];

      const existingIdx = RAW_ROWS[hRowIdx].findIndex(h => String(h || '').trim().toLowerCase() === finalHeaderName.toLowerCase());
      if (existingIdx !== -1) {
        alert(`Kolom "${finalHeaderName}" sudah ada di data ini (kolom ke-${existingIdx + 1}).`);
        return;
      }

      const newColIdx = RAW_ROWS[hRowIdx].length;
      RAW_ROWS[hRowIdx].push(finalHeaderName);

      // Pad all other rows with empty or default value
      for (let r = 0; r < RAW_ROWS.length; r++) {
        if (r === hRowIdx) continue;
        while (RAW_ROWS[r].length < newColIdx) {
          RAW_ROWS[r].push('');
        }

        let rowSection = '';
        if (DATA_KEY === 'common_enemy_csv') {
          rowSection = String(RAW_ROWS[r][3] || '').trim(); // col 3 is Stream
        } else if (DATA_KEY === 'anti_blackout_csv') {
          rowSection = String(RAW_ROWS[r][1] || '').trim(); // col 1 is Bagian
        } else {
          rowSection = String(RAW_ROWS[r][0] || '').trim();
        }

        const matchesSection = (targetSection === 'ALL') || (rowSection.toLowerCase() === targetSection.toLowerCase());
        const isDataRow = r > hRowIdx && (DATA_KEY !== 'common_enemy_csv' && DATA_KEY !== 'anti_blackout_csv' ? true : /^[0-9]+$/.test(String(RAW_ROWS[r][0] || '').trim()));

        // Only put default value in matching section's data rows
        RAW_ROWS[r].push((isDataRow && matchesSection) ? defaultVal : '');
      }

      closeAddColumnModal();
      parseDigitalItems();
      renderSectionPills();
      renderDigitalCards();
      initGridHeaders();
      renderGridRows();
      markDirty();
      updateTopStats();

      const secMsg = (targetSection && targetSection !== 'ALL') ? `khusus bagian "${targetSection}"` : 'untuk seluruh data';
      showToast(`✅ Kolom baru "${baseColName}" berhasil ditambahkan ${secMsg}!`);
    }

    function deleteCustomColumn(colIdx, rawName) {
      const parsed = parseHeaderSection(rawName);
      const targetLabel = parsed.section === 'ALL' ? 'seluruh data' : `bagian "${parsed.section}"`;
      if (confirm(`Yakin ingin menghapus kolom "${parsed.name}" dari ${targetLabel}? Semua data pada kolom ini akan dihapus.`)) {
        for (let r = 0; r < RAW_ROWS.length; r++) {
          if (RAW_ROWS[r] && RAW_ROWS[r].length > colIdx) {
            RAW_ROWS[r].splice(colIdx, 1);
          }
        }
        parseDigitalItems();
        renderSectionPills();
        renderDigitalCards();
        initGridHeaders();
        renderGridRows();
        markDirty();
        updateTopStats();
        showToast(`Kolom "${parsed.name}" (${targetLabel}) berhasil dihapus.`);
      }
    }

    // Update Monthly Sub-Fields
    function updateMonthlyField(rawIndex, colIndex, value, monthIndex, type) {
      if (!RAW_ROWS[rawIndex]) RAW_ROWS[rawIndex] = [];
      RAW_ROWS[rawIndex][colIndex] = value;

      const item = digitalItems.find(x => x.rawIndex === rawIndex);
      if (item) {
        if (type === 'target' && item.monthlyTarget) item.monthlyTarget[monthIndex] = value;
        if (type === 'realisasi' && item.monthlyRealisasi) item.monthlyRealisasi[monthIndex] = value;
      }
      const card = document.getElementById(`card-item-${rawIndex}`);
      if (card) card.classList.add('modified');
      markDirty();
    }

    function toggleMonthlyBox(rawIndex) {
      const grid = document.getElementById(`monthlyGrid-${rawIndex}`);
      const icon = document.getElementById(`monthlyToggleIcon-${rawIndex}`);
      if (!grid) return;
      if (grid.style.display === 'none') {
        grid.style.display = 'grid';
        if (icon) icon.textContent = '▲ Tutup Rincian Bulan';
      } else {
        grid.style.display = 'none';
        if (icon) icon.textContent = '▼ Buka Rincian Bulan';
      }
    }

    function filterDigitalItems() {
      renderDigitalCards();
    }

    // Add New Program Item
    function addNewProgramItem() {
      const hRowIdx = getHeaderRowIndex();
      const colCount = Math.max(
        (DATA_KEY === 'common_enemy_csv' ? 111 : (DATA_KEY === 'anti_blackout_csv' ? 63 : 10)),
        (RAW_ROWS[hRowIdx] ? RAW_ROWS[hRowIdx].length : 10)
      );

      const nextNo = digitalItems.length + 1;
      const newRow = new Array(colCount).fill('');

      if (DATA_KEY === 'common_enemy_csv') {
        const defaultStream = activeSectionFilter === 'ALL' ? 'Proteksi' : activeSectionFilter;
        newRow[0] = String(nextNo);
        newRow[1] = `${defaultStream} - Sasaran Baru`;
        newRow[3] = defaultStream;
        newRow[4] = 'Program Kerja Baru';
        newRow[5] = 'Bay';
        newRow[9] = '1';
        newRow[10] = '1';
        newRow[11] = '0';
        newRow[12] = '0.00%';
        newRow[13] = 'On Target';
        newRow[14] = 'Program baru ditambahkan';
        RAW_ROWS.push(newRow);
        parseDigitalItems();
        renderSectionPills();
        renderDigitalCards();
        markDirty();
        updateTopStats();
        const ws = document.getElementById('digitalWorkspace');
        ws.scrollTop = ws.scrollHeight;
        showToast(`Program Kerja baru berhasil ditambahkan pada Stream ${defaultStream}.`);
        return;
      }

      if (DATA_KEY === 'anti_blackout_csv') {
        const defaultBagian = activeSectionFilter === 'ALL' ? 'Gardu Induk' : activeSectionFilter;
        newRow[0] = String(nextNo);
        newRow[1] = defaultBagian;
        newRow[2] = `${defaultBagian} - Anti Blackout`;
        newRow[3] = 'Program Kerja Baru';
        newRow[4] = 'GI';
        newRow[55] = '1';
        newRow[56] = '1';
        newRow[57] = '0';
        newRow[58] = '0.00%';
        newRow[59] = 'Hati-hati';
        RAW_ROWS.push(newRow);
        parseDigitalItems();
        renderSectionPills();
        renderDigitalCards();
        markDirty();
        updateTopStats();
        const ws = document.getElementById('digitalWorkspace');
        ws.scrollTop = ws.scrollHeight;
        showToast(`Program Kerja baru berhasil ditambahkan di Bagian ${defaultBagian}.`);
        return;
      }

      // Universal dataset
      newRow[0] = String(nextNo);
      newRow[1] = 'Item Baru';
      RAW_ROWS.push(newRow);
      parseDigitalItems();
      renderSectionPills();
      renderDigitalCards();
      markDirty();
      updateTopStats();
      showToast(`Baris baru #${nextNo} berhasil ditambahkan.`);
    }

    // Delete Program Item
    function deleteProgramItem(rawIndex) {
      const item = digitalItems.find(x => x.rawIndex === rawIndex);
      const title = item ? (item.programKerja || item.subInitiative) : `Item #${rawIndex}`;
      if (confirm(`Yakin ingin menghapus item "${title}"?`)) {
        RAW_ROWS.splice(rawIndex, 1);
        parseDigitalItems();
        renderSectionPills();
        renderDigitalCards();
        markDirty();
        updateTopStats();
        showToast('Item berhasil dihapus.');
      }
    }

    // Duplicate Program Item
    function duplicateProgramItem(rawIndex) {
      const originalRow = RAW_ROWS[rawIndex] || [];
      const clonedRow = [...originalRow];
      clonedRow[0] = String(digitalItems.length + 1);
      if (DATA_KEY === 'common_enemy_csv') {
        clonedRow[4] = `${clonedRow[4] || 'Program'} (Salinan)`;
      } else if (DATA_KEY === 'anti_blackout_csv') {
        clonedRow[3] = `${clonedRow[3] || 'Program'} (Salinan)`;
      } else {
        clonedRow[1] = `${clonedRow[1] || 'Item'} (Salinan)`;
      }
      RAW_ROWS.splice(rawIndex + 1, 0, clonedRow);

      parseDigitalItems();
      renderSectionPills();
      renderDigitalCards();
      markDirty();
      updateTopStats();
      showToast('Item berhasil diduplikasi.');
    }

    // 4. GRID SPREADSHEET MODE ENGINE
    function initGridHeaders() {
      const thead = document.getElementById('spreadsheetHead');
      thead.innerHTML = '';

      const tr = document.createElement('tr');
      const thIndex = document.createElement('th');
      thIndex.className = 'col-index-th';
      thIndex.textContent = '#';
      tr.appendChild(thIndex);

      const hRowIdx = getHeaderRowIndex();
      const hRow = RAW_ROWS[hRowIdx] || [];
      const colCount = Math.max(
        (HEADERS ? HEADERS.length : 0),
        hRow.length,
        (RAW_ROWS[0] ? RAW_ROWS[0].length : 0)
      );

      const displayHeaders = [];
      for (let c = 0; c < colCount; c++) {
        displayHeaders.push(hRow[c] || (HEADERS && HEADERS[c]) || `Kolom_${c + 1}`);
      }

      displayHeaders.forEach((h, colIdx) => {
        const th = document.createElement('th');
        th.dataset.col = colIdx;
        const w = columnWidths[colIdx] || DEFAULT_COL_WIDTH;
        th.style.width = `${w}px`;
        th.style.minWidth = `${w}px`;

        const inner = document.createElement('div');
        inner.className = 'th-inner';
        const nameSpan = document.createElement('span');
        nameSpan.className = 'th-name';
        nameSpan.textContent = h || `Kolom_${colIdx + 1}`;
        inner.appendChild(nameSpan);
        th.appendChild(inner);

        const resizer = document.createElement('div');
        resizer.className = 'col-resizer';
        setupGridResizer(resizer, th, colIdx);
        th.appendChild(resizer);

        tr.appendChild(th);
      });

      thead.appendChild(tr);
    }

    function setupGridResizer(resizer, th, colIdx) {
      let startX = 0;
      let startWidth = 0;
      resizer.addEventListener('mousedown', (e) => {
        e.preventDefault();
        e.stopPropagation();
        startX = e.pageX;
        startWidth = th.offsetWidth;
        resizer.classList.add('resizing');
        document.body.style.cursor = 'col-resize';
        document.body.style.userSelect = 'none';

        const onMouseMove = (moveEvent) => {
          const delta = moveEvent.pageX - startX;
          const newWidth = Math.max(70, startWidth + delta);
          th.style.width = `${newWidth}px`;
          th.style.minWidth = `${newWidth}px`;
          columnWidths[colIdx] = newWidth;
        };

        const onMouseUp = () => {
          resizer.classList.remove('resizing');
          document.body.style.cursor = '';
          document.body.style.userSelect = '';
          window.removeEventListener('mousemove', onMouseMove);
          window.removeEventListener('mouseup', onMouseUp);
        };

        window.addEventListener('mousemove', onMouseMove);
        window.addEventListener('mouseup', onMouseUp);
      });
    }

    function renderGridRows() {
      const tbody = document.getElementById('spreadsheetBody');
      tbody.innerHTML = '';

      RAW_ROWS.forEach((row, rIdx) => {
        const tr = document.createElement('tr');
        const tdIdx = document.createElement('td');
        tdIdx.className = 'cell-row-num';
        tdIdx.textContent = rIdx + 1;
        tr.appendChild(tdIdx);

        row.forEach((cellVal, cIdx) => {
          const td = document.createElement('td');
          const input = document.createElement('input');
          input.type = 'text';
          input.className = 'grid-cell-input';
          input.value = cellVal !== undefined ? cellVal : '';
          input.dataset.row = rIdx;
          input.dataset.col = cIdx;

          input.addEventListener('focus', function() {
            activeCell = { row: rIdx, col: cIdx };
            document.getElementById('cellCoordIndicator').textContent = `Sel: [B${rIdx + 1}, K${cIdx + 1}]`;
            document.getElementById('formulaInput').value = this.value;
          });

          input.addEventListener('input', function() {
            RAW_ROWS[rIdx][cIdx] = this.value;
            this.classList.add('modified');
            markDirty();
          });

          td.appendChild(input);
          tr.appendChild(td);
        });

        tbody.appendChild(tr);
      });
    }

    function onFormulaInput(newVal) {
      if (activeCell.row === null || activeCell.col === null) return;
      RAW_ROWS[activeCell.row][activeCell.col] = newVal;
      const target = document.querySelector(`.grid-cell-input[data-row="${activeCell.row}"][data-col="${activeCell.col}"]`);
      if (target) {
        target.value = newVal;
        target.classList.add('modified');
      }
      markDirty();
    }

    // 5. VIEW MODE SWITCHER
    function switchMainMode(mode) {
      currentMainMode = mode;
      document.getElementById('btnModeDigital').classList.toggle('active', mode === 'digital');
      document.getElementById('btnModeGrid').classList.toggle('active', mode === 'grid');
      document.getElementById('btnModeRaw').classList.toggle('active', mode === 'raw');

      document.getElementById('digitalWorkspace').style.display = mode === 'digital' ? 'block' : 'none';
      document.getElementById('gridWorkspace').style.display = mode === 'grid' ? 'block' : 'none';
      document.getElementById('formulaBar').style.display = mode === 'grid' ? 'flex' : 'none';
      document.getElementById('rawWorkspace').style.display = mode === 'raw' ? 'flex' : 'none';

      if (mode === 'grid') {
        renderGridRows();
      } else if (mode === 'digital') {
        parseDigitalItems();
        renderDigitalCards();
      } else if (mode === 'raw') {
        document.getElementById('rawCsvText').value = generateCsvStringFromRaw();
      }
    }

    function generateCsvStringFromRaw() {
      return RAW_ROWS.map(row => {
        return (row || []).map(cell => {
          let val = String(cell !== undefined && cell !== null ? cell : '');
          if (val.includes(',') || val.includes('"') || val.includes('\n') || val.includes('\r')) {
            val = '"' + val.replace(/"/g, '""') + '"';
          }
          return val;
        }).join(',');
      }).join('\n');
    }

    function syncRawToAll() {
      const text = document.getElementById('rawCsvText').value;
      const lines = text.split(/\r\n|\r|\n/);
      const parsed = [];
      for (const line of lines) {
        if (line.trim() === '') continue;
        const row = [];
        let cur = '';
        let inQuotes = false;
        for (let i = 0; i < line.length; i++) {
          const ch = line[i];
          if (ch === '"') {
            if (inQuotes && line[i+1] === '"') {
              cur += '"';
              i++;
            } else {
              inQuotes = !inQuotes;
            }
          } else if ((ch === ',' || ch === ';') && !inQuotes) {
            row.push(cur.trim());
            cur = '';
          } else {
            cur += ch;
          }
        }
        row.push(cur.trim());
        parsed.push(row);
      }

      if (parsed.length > 0) {
        RAW_ROWS = parsed;
        parseDigitalItems();
        renderSectionPills();
        renderDigitalCards();
        renderGridRows();
        markDirty();
        updateTopStats();
        switchMainMode('digital');
        showToast('Data teks CSV berhasil diurai ke Formulir Digital & Grid!');
      }
    }

    // 6. SAVE TO CSV (WEB -> CSV -> WEB LIVE UPDATE)
    async function saveData() {
      const btn = document.getElementById('btnSavePrimary');
      btn.disabled = true;
      btn.textContent = '⏳ Menyimpan ke CSV...';

      let payload = {
        _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        raw_rows: RAW_ROWS
      };

      if (currentMainMode === 'raw') {
        payload = {
          _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          csv_content: document.getElementById('rawCsvText').value
        };
      }

      try {
        const res = await fetch(SAVE_URL, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify(payload)
        });

        const data = await res.json();
        if (data.success) {
          isDirty = false;
          document.getElementById('saveHint').textContent = '✅ Tersimpan ke file CSV server & aktif di web!';
          document.getElementById('saveHint').style.color = '#15803D';

          document.querySelectorAll('.program-card.modified').forEach(el => el.classList.remove('modified'));
          document.querySelectorAll('.grid-cell-input.modified').forEach(el => el.classList.remove('modified'));

          showToast(data.message, 'success');
        } else {
          showToast(data.message || 'Gagal menyimpan data.', 'error');
        }
      } catch (err) {
        showToast('Terjadi kesalahan jaringan: ' + err.message, 'error');
      } finally {
        btn.disabled = false;
        btn.textContent = '💾 Simpan Perubahan ke CSV (Terapkan ke Web)';
      }
    }

    function markDirty() {
      isDirty = true;
      document.getElementById('saveHint').textContent = '⚠️ Ada perubahan belum disimpan ke CSV!';
      document.getElementById('saveHint').style.color = '#F59E0B';
    }

    function updateTopStats() {
      document.getElementById('topItemCount').textContent = digitalItems.length;
    }

    function escapeHtml(text) {
      if (!text) return '';
      return String(text)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
    }

    function toggleFullScreen() {
      if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen().catch(() => {});
      } else {
        if (document.exitFullscreen) document.exitFullscreen();
      }
    }

    let toastTimer = null;
    function showToast(msg, type = 'success') {
      const toast = document.getElementById('studioToast');
      const icon = document.getElementById('toastIcon');
      const text = document.getElementById('toastMessage');

      toast.className = 'studio-toast show ' + type;
      icon.textContent = type === 'success' ? '✅' : '⚠️';
      text.textContent = msg;

      if (toastTimer) clearTimeout(toastTimer);
      toastTimer = setTimeout(() => {
        toast.className = 'studio-toast';
      }, 4000);
    }

    function openUploadModal() { document.getElementById('uploadModal').style.display = 'flex'; }
    function closeUploadModal() { document.getElementById('uploadModal').style.display = 'none'; }

    // Hotkey Ctrl+S / Cmd+S
    window.addEventListener('keydown', function(e) {
      if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        saveData();
      }
    });

    // Unsaved changes warning
    window.addEventListener('beforeunload', function(e) {
      if (isDirty) {
        e.preventDefault();
        e.returnValue = 'Perubahan data belum disimpan ke CSV. Yakin ingin keluar?';
      }
    });

    document.addEventListener('DOMContentLoaded', initPage);
  </script>
</body>
</html>
