@extends('layouts.app')

@section('title', 'ASET TRANSMISI — UPT MANADO')

@section('styles')
<style>
  .aset-page-header{
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--border-color);
  }
  .breadcrumb{
    font-size: 12px;
    font-weight: 600;
    color: var(--text-muted);
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .breadcrumb a{
    color: var(--pln-blue);
    text-decoration: none;
  }
  [data-theme="dark"] .breadcrumb a{ color: var(--pln-yellow); }
  .page-title-row{
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
  }
  .page-title{
    font-size: 24px;
    font-weight: 800;
    color: var(--text-main);
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0;
  }
  .page-subtitle{
    font-size: 13px;
    color: var(--text-muted);
    margin-top: 4px;
  }

  /* Metric cards */
  .aset-metrics-grid{
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 14px;
    margin-bottom: 26px;
  }
  @media (max-width: 1024px){ .aset-metrics-grid{ grid-template-columns: repeat(3, 1fr); } }
  @media (max-width: 680px){ .aset-metrics-grid{ grid-template-columns: repeat(2, 1fr); } }
  @media (max-width: 480px){ .aset-metrics-grid{ grid-template-columns: 1fr; } }

  .aset-metric-card{
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 10px;
    padding: 16px 18px;
    box-shadow: var(--card-shadow);
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all .25s ease;
  }
  .aset-metric-card:hover{
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(0,0,0,0.08);
    border-color: var(--pln-blue);
  }
  [data-theme="dark"] .aset-metric-card:hover{ border-color: var(--pln-yellow); }
  .am-info h4{
    font-size: 11.5px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--text-muted);
    margin-bottom: 4px;
  }
  .am-info .val{
    font-size: 26px;
    font-weight: 800;
    color: var(--pln-blue);
    line-height: 1.1;
  }
  [data-theme="dark"] .am-info .val{ color: var(--pln-yellow); }
  .am-info .sub{
    font-size: 11px;
    color: var(--text-muted);
    margin-top: 5px;
  }
  .am-icon{
    font-size: 32px;
    opacity: 0.85;
  }

  /* Map Studio */
  .map-studio-card{
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 18px;
    box-shadow: var(--card-shadow);
    margin-bottom: 28px;
  }
  .map-toolbar{
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 14px;
  }
  .map-controls-group{
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
  }
  .map-filter-btn{
    background: var(--input-bg);
    border: 1px solid var(--border-color);
    color: var(--text-main);
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all .2s ease;
  }
  .map-filter-btn:hover, .map-filter-btn.active{
    background: var(--pln-blue);
    color: #fff;
    border-color: var(--pln-blue);
  }
  [data-theme="dark"] .map-filter-btn:hover, [data-theme="dark"] .map-filter-btn.active{
    background: var(--pln-yellow);
    color: var(--pln-blue-dark);
    border-color: var(--pln-yellow);
  }
  .map-search-input{
    padding: 6px 14px;
    border: 1px solid var(--border-color);
    border-radius: 20px;
    font-size: 12px;
    background: var(--input-bg);
    color: var(--text-main);
    min-width: 220px;
    outline: none;
  }
  #map-aset-full{
    width: 100%;
    height: 540px;
    min-height: 500px;
    border-radius: 8px;
    border: 1px solid var(--border-color);
    z-index: 1;
    position: relative;
    background: #e2e8f0;
    box-shadow: inset 0 0 10px rgba(0,0,0,0.04);
  }
  [data-theme="dark"] #map-aset-full{
    background: #0f172a;
    border-color: #334155;
  }
  .map-legend-bar{
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    margin-top: 12px;
    font-size: 11.5px;
    color: var(--text-muted);
  }
  .leg-item{
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .leg-color{
    width: 14px;
    height: 4px;
    border-radius: 2px;
  }
  .leg-point{
    width: 10px;
    height: 10px;
    border-radius: 50%;
  }

  /* Navigation Tabs */
  .aset-tabs-bar{
    display: flex;
    gap: 6px;
    border-bottom: 2px solid var(--border-color);
    margin-bottom: 22px;
    overflow-x: auto;
  }
  .aset-tab-btn{
    background: none;
    border: none;
    padding: 10px 18px;
    font-size: 13.5px;
    font-weight: 700;
    color: var(--text-muted);
    cursor: pointer;
    border-bottom: 3px solid transparent;
    margin-bottom: -2px;
    white-space: nowrap;
    transition: all .2s ease;
  }
  .aset-tab-btn:hover{ color: var(--pln-blue); }
  [data-theme="dark"] .aset-tab-btn:hover{ color: var(--pln-yellow); }
  .aset-tab-btn.active{
    color: var(--pln-blue);
    border-bottom-color: var(--pln-blue);
  }
  [data-theme="dark"] .aset-tab-btn.active{
    color: var(--pln-yellow);
    border-bottom-color: var(--pln-yellow);
  }

  /* Tab Panes */
  .tab-pane{ display: none; }
  .tab-pane.active{ display: block; animation: tabFade .25s ease; }
  @keyframes tabFade{ from{ opacity:0; transform: translateY(4px); } to{ opacity:1; transform: translateY(0); } }

  /* Tables */
  .aset-table-card{
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 10px;
    box-shadow: var(--card-shadow);
    overflow: hidden;
    margin-bottom: 24px;
  }
  .aset-table-header{
    padding: 14px 18px;
    background: var(--table-header-bg);
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
  }
  .aset-table-header h3{
    font-size: 14.5px;
    font-weight: 700;
    margin: 0;
    color: var(--text-main);
  }
  .table-responsive{
    width: 100%;
    overflow-x: auto;
  }
  .aset-table{
    width: 100%;
    border-collapse: collapse;
    font-size: 12.5px;
    text-align: left;
  }
  .aset-table th{
    background: var(--table-header-bg);
    color: var(--text-muted);
    font-weight: 700;
    padding: 10px 14px;
    border-bottom: 1px solid var(--border-color);
    white-space: nowrap;
  }
  .aset-table td{
    padding: 10px 14px;
    border-bottom: 1px solid var(--border-color);
    color: var(--text-main);
  }
  .aset-table tbody tr:hover{
    background: rgba(0, 82, 156, 0.03);
  }
  [data-theme="dark"] .aset-table tbody tr:hover{
    background: rgba(255, 255, 255, 0.03);
  }
  .badge-kv{
    display: inline-block;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 700;
  }
  .badge-150{ background: rgba(229, 62, 62, 0.15); color: #E53E3E; border: 1px solid rgba(229, 62, 62, 0.3); }
  .badge-70{ background: rgba(249, 115, 22, 0.15); color: #F97316; border: 1px solid rgba(249, 115, 22, 0.3); }

  /* Info cards grid */
  .info-boxes-grid{
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 16px;
    margin-top: 20px;
  }
  .info-box{
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 10px;
    padding: 16px;
    box-shadow: var(--card-shadow);
  }
  .info-box-title{
    font-size: 13.5px;
    font-weight: 700;
    color: var(--pln-blue);
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  [data-theme="dark"] .info-box-title{ color: var(--pln-yellow); }
  .info-box-desc{
    font-size: 12px;
    color: var(--text-muted);
    line-height: 1.6;
  }
</style>
@endsection

@section('content')
<div class="container">

  <!-- PAGE HEADER -->
  <div class="aset-page-header">
    <div class="breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span>/</span>
      <span>Aset Transmisi</span>
    </div>
    <div class="page-title-row">
      <div>
        <h1 class="page-title">
          <img src="{{ asset('Logo_UPT_Manado.png') }}" alt="PLN UPT Manado" style="height: 32px; width: auto; object-fit: contain; vertical-align: middle;">
          Manajemen &amp; Pemetaan Aset Transmisi UPT Manado
        </h1>
        <p class="page-subtitle">
          Data komprehensif aset Gardu Induk, Saluran Udara Tegangan Tinggi (SUTT), Trafo Daya, dan Jaringan Transmisi di Sulawesi Utara &amp; Gorontalo.
        </p>
      </div>
      <div>
        <a href="{{ route('home') }}" class="btn-detail-link">
          <span>&larr; Kembali ke Ringkasan Home</span>
        </a>
      </div>
    </div>
  </div>

  @php
    $assetCards = $sections['aset']->statCards ?? collect();
    $giCard = $assetCards->firstWhere('css_class', 'cardGI');
    $trafoCard = $assetCards->firstWhere('css_class', 'cardTrafo');
    $panjangCard = $assetCards->firstWhere('css_class', 'cardPanjang');
    $towerCard = $assetCards->firstWhere('css_class', 'cardTower');
    $jalurCard = $assetCards->firstWhere('css_class', 'cardJalur');
  @endphp

  <!-- 1. TOP METRIC STATS -->
  <div class="aset-metrics-grid">
    <div class="aset-metric-card" id="cardGI">
      <div class="am-info">
        <h4>{{ $giCard->title ?? 'Jumlah Gardu Induk' }}</h4>
        <div class="val" id="statGiCount">{{ ($giCard && $giCard->effective_value !== '-') ? ($giCard->effective_value . ' ' . ($giCard->effective_unit ?? 'Unit')) : '-' }}</div>
        <div class="sub" id="subGiCount">{{ $giCard?->effective_footer ?: 'Menunggu sumber data...' }}</div>
      </div>
      <div class="am-icon">{{ $giCard->icon ?? '🏢' }}</div>
    </div>

    <div class="aset-metric-card" id="cardTrafo">
      <div class="am-info">
        <h4>{{ $trafoCard->title ?? 'Jumlah Trafo Daya' }}</h4>
        <div class="val" id="statTrafoCount">{{ ($trafoCard && $trafoCard->effective_value !== '-') ? ($trafoCard->effective_value . ' ' . ($trafoCard->effective_unit ?? 'Unit')) : '-' }}</div>
        <div class="sub" id="subTrafoCount">{{ $trafoCard?->effective_footer ?: 'Menunggu sumber data...' }}</div>
      </div>
      <div class="am-icon">{{ $trafoCard->icon ?? '⚡' }}</div>
    </div>

    <div class="aset-metric-card" id="cardPanjang">
      <div class="am-info">
        <h4>{{ $panjangCard->title ?? 'Panjang Transmisi' }}</h4>
        <div class="val" id="statPanjangCount">{{ ($panjangCard && $panjangCard->effective_value !== '-') ? ($panjangCard->effective_value . ' ' . ($panjangCard->effective_unit ?? 'kms')) : '-' }}</div>
        <div class="sub" id="subPanjangCount">{{ $panjangCard?->effective_footer ?: 'Menunggu sumber data...' }}</div>
      </div>
      <div class="am-icon">{{ $panjangCard->icon ?? '🔌' }}</div>
    </div>

    <div class="aset-metric-card" id="cardTower">
      <div class="am-info">
        <h4>{{ $towerCard->title ?? 'Titik Tower Transmisi' }}</h4>
        <div class="val" id="statTowerCount">{{ ($towerCard && $towerCard->effective_value !== '-') ? ($towerCard->effective_value . ' ' . ($towerCard->effective_unit ?? 'Tower')) : '-' }}</div>
        <div class="sub" id="subTowerCount">{{ $towerCard?->effective_footer ?: 'Menunggu sumber data...' }}</div>
      </div>
      <div class="am-icon">{{ $towerCard->icon ?? '🗼' }}</div>
    </div>

    <div class="aset-metric-card" id="cardJalur">
      <div class="am-info">
        <h4>{{ $jalurCard->title ?? 'Sirkit Transmisi' }}</h4>
        <div class="val" id="statLineCount">{{ ($jalurCard && $jalurCard->effective_value !== '-') ? ($jalurCard->effective_value . ' ' . ($jalurCard->effective_unit ?? 'Sirkit')) : '-' }}</div>
        <div class="sub" id="subLineCount">{{ $jalurCard?->effective_footer ?: 'Menunggu sumber data...' }}</div>
      </div>
      <div class="am-icon">{{ $jalurCard->icon ?? '📡' }}</div>
    </div>
  </div>

  <!-- 2. INTERACTIVE GIS MAP STUDIO -->
  <div class="map-studio-card">
    <div class="map-toolbar">
      <div class="map-controls-group">
        <span style="font-size:12.5px; font-weight:700; color:var(--text-main);">Filter Sistem:</span>
        <button class="map-filter-btn active" id="btnVoltAll" onclick="filterVoltage('all', this)">Semua Sistem</button>
        <button class="map-filter-btn" id="btnVolt150" onclick="filterVoltage(150, this)">Sistem 150 kV</button>
        <button class="map-filter-btn" id="btnVolt70" onclick="filterVoltage(70, this)">Sistem 70 kV</button>
      </div>
      <div class="map-controls-group">
        <span style="font-size:12.5px; font-weight:700; color:var(--text-main);">Tampilan:</span>
        <button class="map-filter-btn active" id="btnLayerVoyager" onclick="setMapBaseLayer('voyager', this)">🗺️ Jalan</button>
        <button class="map-filter-btn" id="btnLayerSat" onclick="setMapBaseLayer('satellite', this)">🛰️ Satelit</button>
        <button class="map-filter-btn" id="btnLayerDark" onclick="setMapBaseLayer('dark', this)">🌙 Gelap</button>
      </div>
      <div class="map-controls-group" style="margin-left:auto;">
        <input type="text" id="mapSearchInput" class="map-search-input" placeholder="🔍 Cari Gardu Induk / Jalur..." onkeyup="searchMapItems(this.value)">
        <button class="map-filter-btn" onclick="resetMapView()" title="Reset Fokus Peta">↺ Reset Peta</button>
      </div>
    </div>

    <div id="map-aset-full"></div>

    <div class="map-legend-bar">
      <div class="leg-item">
        <span class="leg-color" style="background:#E53E3E;"></span>
        <span>SUTT 150 kV (Sulutgo Ring)</span>
      </div>
      <div class="leg-item">
        <span class="leg-color" style="background:#F97316;"></span>
        <span>SUTT 70 kV (Minahasa Ring)</span>
      </div>
      <div class="leg-item">
        <span class="leg-point" style="background:#E53E3E;"></span>
        <span>Gardu Induk 150 kV</span>
      </div>
      <div class="leg-item">
        <span class="leg-point" style="background:#F97316;"></span>
        <span>Gardu Induk 70 kV</span>
      </div>
      <div class="leg-item">
        <span style="display:inline-block; width:7px; height:7px; border-radius:50%; background:#E53E3E; border:1.2px solid #fff; box-shadow:0 0 2px rgba(0,0,0,0.4);"></span>
        <span>Titik Tower Transmisi</span>
      </div>
      <div class="leg-item" style="margin-left:auto;">
        <span id="mapAssetCountInfo">Menghitung objek peta...</span>
      </div>
    </div>
  </div>

  <!-- 3. TAB NAVIGATION -->
  <div class="aset-tabs-bar">
    <button class="aset-tab-btn active" onclick="switchAsetTab('tab-ultg', this)">1. Rincian Aset per ULTG</button>
    <button class="aset-tab-btn" onclick="switchAsetTab('tab-gi', this)">2. Daftar Gardu Induk (37+ Unit)</button>
    <button class="aset-tab-btn" onclick="switchAsetTab('tab-jalur', this)">3. Koridor Jalur Transmisi (SUTT)</button>
    <button class="aset-tab-btn" onclick="switchAsetTab('tab-standar', this)">4. Manajemen Keandalan &amp; Pemeliharaan</button>
  </div>

  <!-- TAB 1: RINCIAN PER ULTG -->
  <div id="tab-ultg" class="tab-pane active">
    <div class="aset-table-card">
      <div class="aset-table-header">
        <h3>Matriks Ringkasan Sebaran Aset per Unit Layanan Transmisi &amp; Gardu Induk (ULTG)</h3>
        <span style="font-size:12px; color:var(--text-muted);">Sistem Interkoneksi Sulut-Gorontalo</span>
      </div>
      <div class="table-responsive">
        <table class="aset-table" id="tableAsetUltg">
          <thead>
            <tr>
              <th>Wilayah ULTG</th>
              <th style="text-align:right;">Gardu Induk (Unit)</th>
              <th style="text-align:right;">Trafo Daya (Unit)</th>
              <th style="text-align:right;">Panjang SUTT (kms)</th>
              <th style="text-align:right;">Titik Tower</th>
              <th style="text-align:right;">Jumlah Sirkit</th>
              <th>Cakupan Wilayah Operasi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><b>ULTG Sawangan</b></td>
              <td style="text-align:right;" id="uSwgGi">11</td>
              <td style="text-align:right;" id="uSwgTrafo">18</td>
              <td style="text-align:right;" id="uSwgKms">568,40</td>
              <td style="text-align:right;" id="uSwgTower">942</td>
              <td style="text-align:right;" id="uSwgLine">24</td>
              <td>Kota Manado, Minahasa Utara, Kota Bitung</td>
            </tr>
            <tr>
              <td><b>ULTG Lopana</b></td>
              <td style="text-align:right;" id="uLpnGi">9</td>
              <td style="text-align:right;" id="uLpnTrafo">14</td>
              <td style="text-align:right;" id="uLpnKms">486,12</td>
              <td style="text-align:right;" id="uLpnTower">786</td>
              <td style="text-align:right;" id="uLpnLine">19</td>
              <td>Kota Tomohon, Minahasa, Minahasa Selatan, Minahasa Tenggara</td>
            </tr>
            <tr>
              <td><b>ULTG Kotamobagu</b></td>
              <td style="text-align:right;" id="uKtgGi">7</td>
              <td style="text-align:right;" id="uKtgTrafo">11</td>
              <td style="text-align:right;" id="uKtgKms">542,85</td>
              <td style="text-align:right;" id="uKtgTower">812</td>
              <td style="text-align:right;" id="uKtgLine">18</td>
              <td>Kota Kotamobagu, Bolaang Mongondow Raya (Bolmong, Bolmut, Bolsel, Boltim)</td>
            </tr>
            <tr>
              <td><b>ULTG Gorontalo</b></td>
              <td style="text-align:right;" id="uGtoGi">10</td>
              <td style="text-align:right;" id="uGtoTrafo">14</td>
              <td style="text-align:right;" id="uGtoKms">636,12</td>
              <td style="text-align:right;" id="uGtoTower">883</td>
              <td style="text-align:right;" id="uGtoLine">20</td>
              <td>Provinsi Gorontalo (Kota Gorontalo, Bone Bolango, Isimu, Boalemo, Marisa)</td>
            </tr>
          </tbody>
          <tfoot>
            <tr style="font-weight:800; background:var(--table-header-bg);">
              <td>UPT MANADO (TOTAL)</td>
              <td style="text-align:right;" id="uTotGi">37 Unit</td>
              <td style="text-align:right;" id="uTotTrafo">57 Unit</td>
              <td style="text-align:right;" id="uTotKms">2.233,49 kms</td>
              <td style="text-align:right;" id="uTotTower">3.423 Tower</td>
              <td style="text-align:right;" id="uTotLine">81 Sirkit</td>
              <td>Wilayah Kerja UPT Manado</td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>

  <!-- TAB 2: DAFTAR GARDU INDUK -->
  <div id="tab-gi" class="tab-pane">
    <div class="aset-table-card">
      <div class="aset-table-header">
        <h3>Daftar Lengkap Gardu Induk (GI) Transmisi UPT Manado</h3>
        <div style="display:flex; gap:8px;">
          <input type="text" id="giTableFilter" class="map-search-input" placeholder="🔍 Saring nama GI atau ULTG..." onkeyup="filterGiTable(this.value)">
        </div>
      </div>
      <div class="table-responsive">
        <table class="aset-table" id="tableGiList">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Gardu Induk</th>
              <th>Tegangan</th>
              <th>ULTG Pembina</th>
              <th>Klasifikasi GI</th>
              <th>Koordinat (Lat, Lng)</th>
              <th style="text-align:center;">Aksi</th>
            </tr>
          </thead>
          <tbody id="giTableBody">
            <tr>
              <td colspan="7" style="text-align:center; color:var(--text-muted); padding:20px;">
                Memuat data gardu induk dari sumber data...
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- TAB 3: KORIDOR JALUR TRANSMISI -->
  <div id="tab-jalur" class="tab-pane">
    <div class="aset-table-card">
      <div class="aset-table-header">
        <h3>Daftar Koridor Jalur Transmisi SUTT 150 kV &amp; 70 kV</h3>
        <span style="font-size:12px; color:var(--text-muted);">Berdasarkan data titik tower pemetaan GIS</span>
      </div>
      <div class="table-responsive">
        <table class="aset-table" id="tableJalurList">
          <thead>
            <tr>
              <th>Kode Penghantar / Jalur</th>
              <th>Sistem Tegangan</th>
              <th style="text-align:right;">Jumlah Titik Tower</th>
              <th>Wilayah Operasi</th>
              <th>Status Interkoneksi</th>
              <th style="text-align:center;">Aksi</th>
            </tr>
          </thead>
          <tbody id="jalurTableBody">
            <tr>
              <td colspan="6" style="text-align:center; color:var(--text-muted); padding:20px;">
                Memuat data jalur transmisi...
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- TAB 4: MANAJEMEN KEANDALAN & STANDAR PEMELIHARAAN -->
  <div id="tab-standar" class="tab-pane">
    <div class="info-boxes-grid">
      <div class="info-box">
        <div class="info-box-title">🗼 Manajemen Koridor &amp; Ruang Bebas (RoW)</div>
        <div class="info-box-desc">
          Pengawasan berkala jarak bebas minimum vertikal dan horizontal konduktor terhadap pohon, bangunan, dan jalan raya sesuai Peraturan Menteri ESDM No. 13 Tahun 2021. Tim Ground Patrol dan Climb Up Patrol secara rutin melakukan perintisan dan pemangkasan vegetasi untuk mencegah flashover gangguan eksternal.
        </div>
      </div>
      <div class="info-box">
        <div class="info-box-title">🛡️ Pemeliharaan Berbasis Kondisi (CBM)</div>
        <div class="info-box-desc">
          Penerapan pengujian berkala terhadap Transformator Daya, PMT (Circuit Breaker), PMS (Disconnecting Switch), CT/PT, dan Lightning Arrester menggunakan Thermovisi Infra-Red, pengujian Dissolved Gas Analysis (DGA), pengujian minyak isolasi trafo, serta pengukuran nilai tahanan isolasi.
        </div>
      </div>
      <div class="info-box">
        <div class="info-box-title">⚡ Standardisasi Nilai Pentanahan Tower</div>
        <div class="info-box-desc">
          Pengukuran dan perbaikan sistem grounding tower (tahanan pentanahan kaki tower &lt; 10 Ohm) untuk memastikan keandalan saluran terhadap sambaran petir tidak langsung (Back Flashover) dan meningkatkan efektifitas kerja kawat tanah (Groundwire / OPGW).
        </div>
      </div>
      <div class="info-box">
        <div class="info-box-title">📡 Sistem Telekomunikasi &amp; Proteksi Modern</div>
        <div class="info-box-desc">
          Pemanfaatan jalur serat optik OPGW pada sirkit transmisi untuk transmisi data proteksi kecepatan tinggi (Line Current Differential &amp; Teleprotection) serta integrasi sinyal SCADA ke Dispatcher Area Control Center (ACC) guna menjamin pemutusan arus gangguan secepat mungkin (&lt; 100 ms).
        </div>
      </div>
    </div>
  </div>

</div>
@endsection

@section('scripts')
<script src="{{ asset('tower-data.js?v=20261022') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.4.1/papaparse.min.js"></script>

<script>
  const ASSET_CSV_URL = (window.APP_DATA_SOURCES && window.APP_DATA_SOURCES.asset_csv) ? window.APP_DATA_SOURCES.asset_csv : '';
  const GI_CSV_URL = (window.APP_DATA_SOURCES && window.APP_DATA_SOURCES.gi_csv) ? window.APP_DATA_SOURCES.gi_csv : '';
  const ULTG_LABELS = ["ULTG Sawangan","ULTG Lopana","ULTG Kotamobagu","ULTG Gorontalo"];

  // Default 44 Gardu Induk (PLN UPT Manado & Interkoneksi Sulutgo)
  const DEFAULT_GI_LIST = [
    { nama: 'GIS 150KV TELING', induk: 'UPT MANADO', ultg: 'ULTG SAWANGAN', tegStr: '150 kV', lat: 1.455693, lng: 124.85464 },
    { nama: 'GIS 150KV SARIO', induk: 'UPT MANADO', ultg: 'ULTG SAWANGAN', tegStr: '150 kV', lat: 1.472222, lng: 124.83444 },
    { nama: 'GI 70KV TELING', induk: 'UPT MANADO', ultg: 'ULTG SAWANGAN', tegStr: '70 kV', lat: 1.457056, lng: 124.85506 },
    { nama: 'GI 70KV RANOMUUT', induk: 'UPT MANADO', ultg: 'ULTG SAWANGAN', tegStr: '70 kV', lat: 1.48526, lng: 124.86502 },
    { nama: 'GI 70KV MSM', induk: 'UPT MANADO', ultg: 'ULTG SAWANGAN', tegStr: '70 kV', lat: 1.603386, lng: 125.125404 },
    { nama: 'GI 70KV LIKUPANG', induk: 'UPT MANADO', ultg: 'ULTG SAWANGAN', tegStr: '70 kV', lat: 1.657194, lng: 125.09378 },
    { nama: 'GI 70KV BITUNG', induk: 'UPT MANADO', ultg: 'ULTG SAWANGAN', tegStr: '70 kV', lat: 1.446244, lng: 125.18915 },
    { nama: 'GI 150KV TANJUNG MERAH', induk: 'UPT MANADO', ultg: 'ULTG SAWANGAN', tegStr: '150 kV', lat: 1.408775, lng: 125.11149 },
    { nama: 'GI 150KV PANIKI', induk: 'UPT MANADO', ultg: 'ULTG SAWANGAN', tegStr: '150 kV', lat: 1.493772, lng: 124.926056 },
    { nama: 'GI 150KV PANDU', induk: 'UPT MANADO', ultg: 'ULTG SAWANGAN', tegStr: '150 kV', lat: 1.579288, lng: 124.876465 },
    { nama: 'GI 150KV LIKUPANG NEW', induk: 'UPT MANADO', ultg: 'ULTG SAWANGAN', tegStr: '150 kV', lat: 1.657976, lng: 125.09373 },
    { nama: 'GI 150KV KEMA', induk: 'UPT MANADO', ultg: 'ULTG SAWANGAN', tegStr: '150 kV', lat: 1.374264, lng: 125.08546 },
    { nama: 'GI 70KV TONSEALAMA', induk: 'UPT MANADO', ultg: 'ULTG LOPANA', tegStr: '70 kV', lat: 1.326917, lng: 124.923836 },
    { nama: 'GI 70KV TOMOHON', induk: 'UPT MANADO', ultg: 'ULTG LOPANA', tegStr: '70 kV', lat: 1.313444, lng: 124.85211 },
    { nama: 'GI 70KV TASIKRIA', induk: 'UPT MANADO', ultg: 'ULTG LOPANA', tegStr: '70 kV', lat: 1.415519, lng: 124.71465 },
    { nama: 'GI 70KV SAWANGAN', induk: 'UPT MANADO', ultg: 'ULTG LOPANA', tegStr: '70 kV', lat: 1.387389, lng: 124.95978 },
    { nama: 'GI 150KV TOMOHON', induk: 'UPT MANADO', ultg: 'ULTG LOPANA', tegStr: '150 kV', lat: 1.313444, lng: 124.85211 },
    { nama: 'GI 150KV PLTP LAHENDONG 34', induk: 'UPT MANADO', ultg: 'ULTG LOPANA', tegStr: '150 kV', lat: 1.271393, lng: 124.83549 },
    { nama: 'GI 150KV PLTP LAHENDONG 12', induk: 'UPT MANADO', ultg: 'ULTG LOPANA', tegStr: '150 kV', lat: 1.254855, lng: 124.82254 },
    { nama: 'GI 150KV LOPANA', induk: 'UPT MANADO', ultg: 'ULTG LOPANA', tegStr: '150 kV', lat: 1.218806, lng: 124.603836 },
    { nama: 'GI 150KV KAWANGKOAN', induk: 'UPT MANADO', ultg: 'ULTG LOPANA', tegStr: '150 kV', lat: 1.178417, lng: 124.7955 },
    { nama: 'GI 150KV AMURANG', induk: 'UPT MANADO', ultg: 'ULTG LOPANA', tegStr: '150 kV', lat: 1.180783, lng: 124.480934 },
    { nama: 'GI 150KV TUTUYAN', induk: 'UPT MANADO', ultg: 'ULTG KOTAMOBAGU', tegStr: '150 kV', lat: 0.767072, lng: 124.601 },
    { nama: 'GI 150KV SULUT 1', induk: 'UPT MANADO', ultg: 'ULTG KOTAMOBAGU', tegStr: '150 kV', lat: 0.880484, lng: 123.468 },
    { nama: 'GI 150KV OTAM', induk: 'UPT MANADO', ultg: 'ULTG KOTAMOBAGU', tegStr: '150 kV', lat: 0.780556, lng: 124.29338 },
    { nama: 'GI 150KV MOLIBAGU', induk: 'UPT MANADO', ultg: 'ULTG KOTAMOBAGU', tegStr: '150 kV', lat: 0.384505, lng: 124.051 },
    { nama: 'GI 150KV LOLAK', induk: 'UPT MANADO', ultg: 'ULTG KOTAMOBAGU', tegStr: '150 kV', lat: 0.8575, lng: 123.99553 },
    { nama: 'GI 150KV TILAMUTA', induk: 'UPT MANADO', ultg: 'ULTG GORONTALO', tegStr: '150 kV', lat: 0.607144, lng: 122.48182 },
    { nama: 'GI 150KV PLTMG MALEO', induk: 'UP GORONTALO', ultg: 'GI KIT', tegStr: '150 kV', lat: 0.467324, lng: 122.00614 },
    { nama: 'GI 150KV MARISA', induk: 'UPT MANADO', ultg: 'ULTG GORONTALO', tegStr: '150 kV', lat: 0.47725, lng: 122.013 },
    { nama: 'GI 150KV ISIMU', induk: 'UPT MANADO', ultg: 'ULTG GORONTALO', tegStr: '150 kV', lat: 0.657306, lng: 122.88553 },
    { nama: 'GI 150KV GORONTALO BARU', induk: 'UPT MANADO', ultg: 'ULTG GORONTALO', tegStr: '150 kV', lat: 0.5514, lng: 123.02515 },
    { nama: 'GI 150KV BOTUPINGGE', induk: 'UPT MANADO', ultg: 'ULTG GORONTALO', tegStr: '150 kV', lat: 0.520139, lng: 123.12625 },
    { nama: 'GI 150KV BOROKO', induk: 'UPT MANADO', ultg: 'ULTG GORONTALO', tegStr: '150 kV', lat: 0.903997, lng: 123.255806 },
    { nama: 'GI 150KV BJA', induk: 'PT. BJA', ultg: 'GI KTT', tegStr: '150 kV', lat: 0.685715, lng: 121.4892 },
    { nama: 'GI 150KV ANGGREK', induk: 'UPT MANADO', ultg: 'ULTG GORONTALO', tegStr: '150 kV', lat: 0.849489, lng: 122.797264 },
    { nama: 'GIS 150KV PLTU TANJUNG KARANG', induk: 'PT. GLP', ultg: 'GI KIT', tegStr: '150 kV', lat: 0.952525, lng: 122.997635 },
    { nama: 'GI 70KV PLTA TANGGARI 2', induk: 'UPT MANADO', ultg: 'ULTG LOPANA', tegStr: '70 kV', lat: 1.3645, lng: 124.938 },
    { nama: 'GI 70KV PLTA TANGGARI 1', induk: 'UPT MANADO', ultg: 'ULTG LOPANA', tegStr: '70 kV', lat: 1.3489, lng: 124.923 },
    { nama: 'GI 30KV PLTA TONSEALAMA', induk: 'UP MINAHASA', ultg: 'GI KIT', tegStr: '30 kV', lat: 1.330028, lng: 124.92287 },
    { nama: 'GI 150KV TOLINGGULA', induk: 'UPT MANADO', ultg: 'ULTG GORONTALO', tegStr: '150 kV', lat: 1.01954, lng: 122.152 },
    { nama: 'GI 150KV PLTP LAHENDONG 56', induk: 'PGE', ultg: 'GI KIT', tegStr: '150 kV', lat: 1.175385, lng: 124.79519 },
    { nama: 'GI 150KV MOUTONG', induk: 'UPT MANADO', ultg: '-', tegStr: '150 kV', lat: 0.457288, lng: 120.93974 },
    { nama: 'GI 150KV GSM', induk: 'PT. GSM', ultg: 'GI KTT', tegStr: '150 kV', lat: 0.529708, lng: 122.001526 }
  ];

  // Tab switching
  function switchAsetTab(tabId, btn){
    document.querySelectorAll('.aset-tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    const target = document.getElementById(tabId);
    if(target) target.classList.add('active');
    setTimeout(() => { if(map) map.invalidateSize(); }, 120);
  }

  // GIS MAP SETUP
  let map, towerLayer, giLayer, towerMarkerLayer;
  let tileVoyager, tileSatellite, tileDark, currentBaseLayer;
  let allPolylineBounds = [];
  let giMarkersList = [];
  let linePolylines = {};
  let lineTowerMarkers = {};
  let currentVoltFilter = 'all';
  const TOWER_ZOOM_THRESHOLD = 11;

  const VOLTAGE_COLOR = { 150: '#E53E3E', 70: '#F97316', 30: '#ECC94B' };
  const LINE_70KV = new Set([
    'TGR1-SWG','TGR2-SWG','SWG-RMT','TNSLM-SWG','TNSLM-TMH','TNSLM-PLTA',
    'TMH-TLG','TMH-TSK','RMT-TLG','SWG-BTG','BTG-LKP'
  ]);
  function getVoltage(name){ return LINE_70KV.has(name) ? 70 : 150; }

  // Base Layer Switcher (Voyager, Satellite, Dark)
  function setMapBaseLayer(layerKey, btn){
    if(!map) return;
    document.querySelectorAll('#btnLayerVoyager, #btnLayerSat, #btnLayerDark').forEach(b => b.classList.remove('active'));
    if(btn) btn.classList.add('active');

    if(currentBaseLayer && map.hasLayer(currentBaseLayer)){
      map.removeLayer(currentBaseLayer);
    }

    if(layerKey === 'satellite'){
      userSelectedSat = true;
      currentBaseLayer = tileSatellite;
    } else if(layerKey === 'dark'){
      userSelectedSat = false;
      currentBaseLayer = tileDark;
    } else {
      userSelectedSat = false;
      currentBaseLayer = tileVoyager;
    }

    currentBaseLayer.addTo(map);
    currentBaseLayer.bringToBack();
  }

  function renderTowerLines(){
    const linesData = (typeof TOWER_LINES !== 'undefined' && TOWER_LINES) ? TOWER_LINES : (window.TOWER_LINES || null);
    if(!linesData || !map || !towerLayer) return;

    towerLayer.clearLayers();
    if(towerMarkerLayer) towerMarkerLayer.clearLayers();
    linePolylines = {};
    lineTowerMarkers = {};
    allPolylineBounds = [];

    const jalurTableBody = document.getElementById('jalurTableBody');
    if(jalurTableBody) jalurTableBody.innerHTML = '';

    Object.keys(linesData).forEach(lineName => {
      const pts = linesData[lineName];
      const latlngs = pts.map(p => [p[0], p[1]]);
      const volt = getVoltage(lineName);
      const color = VOLTAGE_COLOR[volt] || '#E53E3E';

      const poly = L.polyline(latlngs, {
        color: color,
        weight: 3.5,
        opacity: 0.9,
        lineJoin: 'round'
      });

      poly.bindPopup(`
        <div style="font-family:sans-serif; min-width:210px; padding:2px;">
          <div style="font-size:13.5px; font-weight:800; color:${color}; margin-bottom:4px;">
            ⚡ ${lineName}
          </div>
          <div style="font-size:12px; line-height:1.6; color:#2C3E50;">
            Sistem Tegangan: <b style="color:${color};">${volt} kV</b><br>
            Jumlah Titik Tower: <b>${pts.length} Titik</b><br>
            Wilayah: <b>${volt === 70 ? 'Minahasa Loop' : 'Sulutgo Interkoneksi'}</b>
          </div>
        </div>
      `);

      poly.addTo(towerLayer);

      // Titik-titik tower di sepanjang garis transmisi (persis seperti di Dashboard)
      const markers = [];
      pts.forEach(p => {
        const marker = L.circleMarker([p[0], p[1]], {
          radius: 3,
          fillColor: color,
          color: '#ffffff',
          weight: 0.7,
          opacity: 1,
          fillOpacity: 0.92
        });

        marker.bindPopup(`
          <div style="font-family:sans-serif; min-width:180px; padding:2px;">
            <div style="font-size:13px; font-weight:800; color:${color}; margin-bottom:4px;">
              🗼 ${p[2] || 'Tower Transmisi'}
            </div>
            <div style="font-size:12px; line-height:1.6; color:#2C3E50;">
              Jalur: <b>${lineName}</b><br>
              Sistem: <b style="color:${color};">${volt} kV</b><br>
              Koordinat: <code style="font-size:11px; color:#555;">${p[0].toFixed(5)}, ${p[1].toFixed(5)}</code>
            </div>
          </div>
        `);

        markers.push(marker);
        if(towerMarkerLayer) marker.addTo(towerMarkerLayer);
      });

      linePolylines[lineName] = { poly, latlngs, volt };
      lineTowerMarkers[lineName] = { markers, volt };
      allPolylineBounds.push(...latlngs);

      // Add to Jalur Table
      if(jalurTableBody){
        const tr = document.createElement('tr');
        const voltBadge = volt === 150 ? '<span class="badge-kv badge-150">150 kV</span>' : '<span class="badge-kv badge-70">70 kV</span>';
        tr.innerHTML = `
          <td><b>${lineName}</b></td>
          <td>${voltBadge}</td>
          <td style="text-align:right;">${pts.length} Tower</td>
          <td>${volt === 70 ? 'Minahasa System' : 'Sulutgo Interkoneksi'}</td>
          <td><span style="color:#27AE60; font-weight:700;">● Beroperasi</span></td>
          <td style="text-align:center;">
            <button class="map-filter-btn" style="padding:3px 10px; font-size:11px;" onclick="focusJalur('${lineName}')">Pusatkan</button>
          </td>
        `;
        jalurTableBody.appendChild(tr);
      }
    });

    refreshTowerVisibility();
  }

  function refreshTowerVisibility(){
    if(!map || !towerMarkerLayer) return;
    const currentZoom = map.getZoom();

    if(currentZoom >= TOWER_ZOOM_THRESHOLD){
      if(!map.hasLayer(towerMarkerLayer)) towerMarkerLayer.addTo(map);

      Object.keys(lineTowerMarkers).forEach(lineName => {
        const item = lineTowerMarkers[lineName];
        const shouldShow = (currentVoltFilter === 'all' || item.volt === currentVoltFilter);
        item.markers.forEach(m => {
          if(shouldShow){
            if(!towerMarkerLayer.hasLayer(m)) towerMarkerLayer.addLayer(m);
          } else {
            if(towerMarkerLayer.hasLayer(m)) towerMarkerLayer.removeLayer(m);
          }
        });
      });
    } else {
      if(map.hasLayer(towerMarkerLayer)) map.removeLayer(towerMarkerLayer);
    }
  }

  function renderGiMarkers(giList){
    if(!map || !giLayer || !giList || !giList.length) return;

    giLayer.clearLayers();
    giMarkersList = [];

    const tb = document.getElementById('giTableBody');
    if(tb) tb.innerHTML = '';

    giList.forEach((gi, idx) => {
      const volt = parseInt(gi.tegStr) || 150;
      const color = VOLTAGE_COLOR[volt] || '#E53E3E';

      const icon = L.divIcon({
        className: 'gi-triangle-pin',
        html: `<div style="position:relative; width:18px; height:18px; display:flex; align-items:center; justify-content:center; cursor:pointer;" title="${gi.nama}">
                <svg width="18" height="18" viewBox="0 0 22 20" style="filter:drop-shadow(0 2px 5px rgba(0,0,0,0.45));">
                  <polygon points="11,1 21,19 1,19" fill="${color}" stroke="#FFFFFF" stroke-width="2.2" stroke-linejoin="round"/>
                </svg>
               </div>`,
        iconSize: [18, 18],
        iconAnchor: [9, 14]
      });

      const marker = L.marker([gi.lat, gi.lng], { icon: icon }).addTo(giLayer);
      marker.bindPopup(`
        <div style="font-family:sans-serif; min-width:210px; padding:2px;">
          <div style="font-size:13.5px; font-weight:800; color:${color}; margin-bottom:4px;">
            🏢 ${gi.nama}
          </div>
          <div style="font-size:12px; line-height:1.6; color:#2C3E50;">
            Sistem Tegangan: <b style="color:${color};">${gi.tegStr || (volt + ' kV')}</b><br>
            Wilayah Kerja: <b>${gi.ultg || gi.induk || 'UPT Manado'}</b><br>
            Koordinat: <code style="font-size:11px; color:#555;">${gi.lat.toFixed(5)}, ${gi.lng.toFixed(5)}</code>
          </div>
        </div>
      `);

      giMarkersList.push({ name: gi.nama, lat: gi.lat, lng: gi.lng, voltage: volt, marker: marker });
      allPolylineBounds.push([gi.lat, gi.lng]);

      if(tb){
        const tr = document.createElement('tr');
        const voltBadge = volt === 150
          ? '<span class="badge-kv badge-150">150 kV</span>'
          : (volt === 70 ? '<span class="badge-kv badge-70">70 kV</span>' : '<span class="badge-kv" style="background:#FEFCBF;color:#975A16;">30 kV</span>');
        const isKit = (gi.ultg||'').toLowerCase().includes('kit');
        const isKtt = (gi.ultg||'').toLowerCase().includes('ktt');
        const tipe = isKit ? 'GI Pembangkit' : (isKtt ? 'GI Konsumen TT' : 'GI Distribusi');

        tr.innerHTML = `
          <td>${idx + 1}</td>
          <td><b>${gi.nama}</b></td>
          <td>${voltBadge}</td>
          <td>${gi.ultg || gi.induk || '-'}</td>
          <td>${tipe}</td>
          <td style="font-family:monospace; font-size:11.5px;">${gi.lat.toFixed(4)}, ${gi.lng.toFixed(4)}</td>
          <td style="text-align:center;">
            <button class="map-filter-btn" style="padding:3px 10px; font-size:11px;" onclick="focusGI(${gi.lat}, ${gi.lng}, '${gi.nama.replace(/'/g, "\\'")}')">Pusatkan</button>
          </td>
        `;
        tb.appendChild(tr);
      }
    });

    const countInfo = document.getElementById('mapAssetCountInfo');
    if(countInfo){
      const jalurCount = Object.keys(linePolylines).length || 41;
      let totalTower = 0;
      Object.keys(lineTowerMarkers).forEach(k => { totalTower += (lineTowerMarkers[k].markers || []).length; });
      countInfo.innerHTML = `Terpetakan: <b>${giList.length} Gardu Induk</b>, <b>${jalurCount} Koridor SUTT</b> &amp; <b>${totalTower.toLocaleString('id-ID')} Titik Tower</b>`;
    }
  }

  function initMap(){
    const mapEl = document.getElementById('map-aset-full');
    if(!mapEl) return;

    if(typeof L === 'undefined'){
      console.warn('Leaflet library loading... retrying initMap in 100ms');
      setTimeout(initMap, 100);
      return;
    }
    if(map) return;

    // Inisialisasi peta Leaflet dengan center di Sulut & Gorontalo
    map = L.map('map-aset-full', {
      preferCanvas: true,
      zoomControl: true,
      attributionControl: true,
      maxZoom: 20
    }).setView([1.1, 123.9], 8);
    window.__asetMap = map;

    // Siapkan tile layer Esri (Bebas API Key & Tanpa Watermark) dengan maxNativeZoom agar tidak hilang saat di-zoom dalam
    tileVoyager = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
      maxNativeZoom: 17,
      maxZoom: 20,
      attribution: '&copy; Esri, HERE, Garmin, &copy; OpenStreetMap contributors | PT PLN (Persero) UPT Manado'
    });

    tileSatellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
      maxNativeZoom: 18,
      maxZoom: 20,
      attribution: '&copy; Esri, Maxar, Earthstar Geographics | PT PLN (Persero) UPT Manado'
    });

    tileDark = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Dark_Gray_Base/MapServer/tile/{z}/{y}/{x}', {
      maxNativeZoom: 16,
      maxZoom: 20,
      attribution: '&copy; Esri, HERE, Garmin, &copy; OpenStreetMap contributors | PT PLN (Persero) UPT Manado'
    });

    // Sesuaikan tile layer dengan tema halaman saat ini
    let userSelectedSat = false;
    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    if(isDark){
      currentBaseLayer = tileDark;
      const bDark = document.getElementById('btnLayerDark');
      if(bDark){
        document.querySelectorAll('#btnLayerVoyager, #btnLayerSat, #btnLayerDark').forEach(b => b.classList.remove('active'));
        bDark.classList.add('active');
      }
    } else {
      currentBaseLayer = tileVoyager;
    }
    currentBaseLayer.addTo(map);

    // Otomatis update basemap jika theme toggle ditekan
    const themeObserver = new MutationObserver(()=>{
      if(!map || userSelectedSat) return;
      const dark = document.documentElement.getAttribute('data-theme') === 'dark';
      setMapBaseLayer(dark ? 'dark' : 'voyager', document.getElementById(dark ? 'btnLayerDark' : 'btnLayerVoyager'));
    });
    themeObserver.observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });

    towerLayer = L.layerGroup().addTo(map);
    towerMarkerLayer = L.layerGroup();
    giLayer = L.layerGroup().addTo(map);

    // 1. Gambar Koridor SUTT Transmisi (41 Jalur) + Titik-Titik Tower
    renderTowerLines();

    // 2. Gambar Titik Gardu Induk (44 Unit)
    renderGiMarkers(DEFAULT_GI_LIST);

    // Listener zoom untuk menampilkan titik tower saat zoom in (persis Dashboard)
    map.on('zoomend', refreshTowerVisibility);
    refreshTowerVisibility();

    // 3. Pusatkan dan auto-fit batas peta
    if(allPolylineBounds.length){
      try{
        const bounds = L.latLngBounds(allPolylineBounds);
        if(bounds.isValid()) map.fitBounds(bounds, { padding: [35, 35] });
      }catch(e){}
    }

    // Refresh ukuran container
    [50, 200, 500, 1000].forEach(ms => {
      setTimeout(() => { if(map) map.invalidateSize(); }, ms);
    });
  }

  function focusJalur(lineName){
    if(linePolylines[lineName]){
      const item = linePolylines[lineName];
      map.fitBounds(item.poly.getBounds(), { padding: [45, 45] });
      item.poly.openPopup();
      window.scrollTo({ top: document.getElementById('map-aset-full').offsetTop - 90, behavior: 'smooth' });
    }
  }

  function focusGI(lat, lng, name){
    if(!map) return;
    map.setView([lat, lng], 13);
    const m = giMarkersList.find(x => x.name === name);
    if(m) m.marker.openPopup();
    window.scrollTo({ top: document.getElementById('map-aset-full').offsetTop - 90, behavior: 'smooth' });
  }

  function filterVoltage(volt, btn){
    currentVoltFilter = volt;
    document.querySelectorAll('#btnVoltAll, #btnVolt150, #btnVolt70').forEach(b => b.classList.remove('active'));
    if(btn) btn.classList.add('active');

    Object.keys(linePolylines).forEach(lineName => {
      const item = linePolylines[lineName];
      if(volt === 'all' || item.volt === volt){
        if(!towerLayer.hasLayer(item.poly)) towerLayer.addLayer(item.poly);
      } else {
        if(towerLayer.hasLayer(item.poly)) towerLayer.removeLayer(item.poly);
      }
    });

    giMarkersList.forEach(m => {
      if(volt === 'all' || m.voltage === volt){
        if(!giLayer.hasLayer(m.marker)) giLayer.addLayer(m.marker);
      } else {
        if(giLayer.hasLayer(m.marker)) giLayer.removeLayer(m.marker);
      }
    });

    refreshTowerVisibility();
  }

  function searchMapItems(query){
    const q = (query||'').trim().toLowerCase();
    if(!q){ resetMapView(); return; }

    const matchGI = giMarkersList.find(m => m.name.toLowerCase().includes(q));
    if(matchGI){
      map.setView([matchGI.lat, matchGI.lng], 13);
      matchGI.marker.openPopup();
      return;
    }

    const matchLineKey = Object.keys(linePolylines).find(k => k.toLowerCase().includes(q));
    if(matchLineKey){
      focusJalur(matchLineKey);
    }
  }

  function resetMapView(){
    const input = document.getElementById('mapSearchInput');
    if(input) input.value = '';
    filterVoltage('all', document.getElementById('btnVoltAll'));
    if(allPolylineBounds.length && map){
      try{
        const bounds = L.latLngBounds(allPolylineBounds);
        if(bounds.isValid()) map.fitBounds(bounds, { padding: [35, 35] });
      }catch(e){}
    }
  }

  function filterGiTable(val){
    const q = (val||'').toLowerCase().trim();
    document.querySelectorAll('#giTableBody tr').forEach(row => {
      const text = row.textContent.toLowerCase();
      row.style.display = text.includes(q) ? '' : 'none';
    });
  }

  // Load GI detail live update
  async function loadGiDetail(){
    let freshCsvText = null;
    try{
      const localRes = await fetch("{{ asset('gi-markers.csv') }}");
      if(localRes.ok) freshCsvText = await localRes.text();
    }catch(e){}

    if(!freshCsvText && GI_CSV_URL && GI_CSV_URL.trim()){
      try{
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 4000);
        let res = null;
        try{
          res = await fetch(GI_CSV_URL, { signal: controller.signal });
        }catch(err){
          res = await fetch('/api/proxy-csv?url=' + encodeURIComponent(GI_CSV_URL), { signal: controller.signal });
        }
        clearTimeout(timeoutId);
        if(res && res.ok) freshCsvText = await res.text();
      }catch(err){
        console.warn('GI live fetch timeout / unreached, using embedded GI dataset.');
      }
    }

    if(freshCsvText && typeof Papa !== 'undefined'){
      try{
        const rows = Papa.parse(freshCsvText, { skipEmptyLines: true }).data;
        const freshList = [];
        rows.forEach(row => {
          if((row[1]||'').trim() !== 'GARDU INDUK') return;
          const induk = (row[2]||'').trim();
          const ultg = (row[3]||'').trim();
          const nama = (row[4]||'').trim();
          const tegStr = (row[5]||'').trim();
          const lat = parseFloat(row[6]);
          const lng = parseFloat(row[7]);
          if(!nama || isNaN(lat) || isNaN(lng)) return;
          freshList.push({ nama, ultg, induk, tegStr, lat, lng });
        });
        if(freshList.length > 0){
          renderGiMarkers(freshList);
        }
      }catch(err){}
    }
  }

  // Load Asset Summary per ULTG
  async function loadAssetSummary(){
    const setStandardDefaults = () => {
      const sGi = document.getElementById('statGiCount');
      if(sGi && sGi.textContent.trim() === '-') sGi.textContent = '37 Unit';
      const sTrafo = document.getElementById('statTrafoCount');
      if(sTrafo && sTrafo.textContent.trim() === '-') sTrafo.textContent = '57 Unit';
      const sPanjang = document.getElementById('statPanjangCount');
      if(sPanjang && sPanjang.textContent.trim() === '-') sPanjang.textContent = '2.238,66 kms';
      const sTower = document.getElementById('statTowerCount');
      if(sTower && sTower.textContent.trim() === '-') sTower.textContent = '3.423 Tower';
      const sLine = document.getElementById('statLineCount');
      if(sLine && sLine.textContent.trim() === '-') sLine.textContent = '81 Sirkit';

      const subGi = document.getElementById('subGiCount');
      if(subGi && subGi.textContent.includes('Menunggu')) subGi.textContent = '37 GI Operasi UPT Manado';
      const subTrafo = document.getElementById('subTrafoCount');
      if(subTrafo && subTrafo.textContent.includes('Menunggu')) subTrafo.textContent = '57 Trafo Daya Transmisi';
      const subPanjang = document.getElementById('subPanjangCount');
      if(subPanjang && subPanjang.textContent.includes('Menunggu')) subPanjang.textContent = 'Sulut & Gorontalo Interkoneksi';
      const subTower = document.getElementById('subTowerCount');
      if(subTower && subTower.textContent.includes('Menunggu')) subTower.textContent = 'Titik Tower Terpetakan GIS';
      const subLine = document.getElementById('subLineCount');
      if(subLine && subLine.textContent.includes('Menunggu')) subLine.textContent = 'Sirkit SUTT 150kV & 70kV';
    };

    setStandardDefaults();

    if(!ASSET_CSV_URL || !ASSET_CSV_URL.trim()) return;

    try{
      const controller = new AbortController();
      const timeoutId = setTimeout(() => controller.abort(), 4000);
      let res = null;
      try{
        res = await fetch(ASSET_CSV_URL, { signal: controller.signal });
      }catch(err){
        res = await fetch('/api/proxy-csv?url=' + encodeURIComponent(ASSET_CSV_URL), { signal: controller.signal });
      }
      clearTimeout(timeoutId);

      if(!res || !res.ok) return;
      const text = await res.text();
      if(!text || typeof Papa === 'undefined') return;

      const rows = Papa.parse(text, { skipEmptyLines: true }).data;
      const cleanNum = v => {
        if(!v) return 0;
        const n = parseFloat(v.toString().replace(/,/g, '').trim());
        return isNaN(n) ? 0 : n;
      };
      const findRow = target => {
        return rows.find(r => r.some(c => c && c.toString().toLowerCase().includes(target.toLowerCase())));
      };

      const giRow = findRow('Num of Sustation') || findRow('Sustation');
      if(giRow){
        const swg = cleanNum(giRow[4]), lpn = cleanNum(giRow[5]), ktg = cleanNum(giRow[6]), gto = cleanNum(giRow[7]), tot = cleanNum(giRow[8] || giRow[giRow.length-1]);
        if(tot > 0){
          document.getElementById('uSwgGi').textContent = swg;
          document.getElementById('uLpnGi').textContent = lpn;
          document.getElementById('uKtgGi').textContent = ktg;
          document.getElementById('uGtoGi').textContent = gto;
          document.getElementById('uTotGi').textContent = tot + ' Unit';
          document.getElementById('statGiCount').textContent = tot + ' Unit';
        }
      }

      const trafoRow = findRow('Total of Transformer');
      if(trafoRow){
        const swg = cleanNum(trafoRow[4]), lpn = cleanNum(trafoRow[5]), ktg = cleanNum(trafoRow[6]), gto = cleanNum(trafoRow[7]), tot = cleanNum(trafoRow[8] || trafoRow[trafoRow.length-1]);
        if(tot > 0){
          document.getElementById('uSwgTrafo').textContent = swg;
          document.getElementById('uLpnTrafo').textContent = lpn;
          document.getElementById('uKtgTrafo').textContent = ktg;
          document.getElementById('uGtoTrafo').textContent = gto;
          document.getElementById('uTotTrafo').textContent = tot + ' Unit';
          document.getElementById('statTrafoCount').textContent = tot + ' Unit';
        }
      }

      const kmsRow = findRow('Length of Circuit');
      if(kmsRow){
        const swg = cleanNum(kmsRow[4]), lpn = cleanNum(kmsRow[5]), ktg = cleanNum(kmsRow[6]), gto = cleanNum(kmsRow[7]), tot = cleanNum(kmsRow[8] || kmsRow[kmsRow.length-1]);
        if(tot > 0){
          document.getElementById('uSwgKms').textContent = swg.toLocaleString('id-ID', {minimumFractionDigits:2});
          document.getElementById('uLpnKms').textContent = lpn.toLocaleString('id-ID', {minimumFractionDigits:2});
          document.getElementById('uKtgKms').textContent = ktg.toLocaleString('id-ID', {minimumFractionDigits:2});
          document.getElementById('uGtoKms').textContent = gto.toLocaleString('id-ID', {minimumFractionDigits:2});
          document.getElementById('uTotKms').textContent = tot.toLocaleString('id-ID', {minimumFractionDigits:2}) + ' kms';
          document.getElementById('statPanjangCount').textContent = tot.toLocaleString('id-ID', {minimumFractionDigits:2}) + ' kms';
        }
      }

      const towerRow = findRow('Num of Tower');
      if(towerRow){
        const swg = cleanNum(towerRow[4]), lpn = cleanNum(towerRow[5]), ktg = cleanNum(towerRow[6]), gto = cleanNum(towerRow[7]), tot = cleanNum(towerRow[8] || towerRow[towerRow.length-1]);
        if(tot > 0){
          document.getElementById('uSwgTower').textContent = swg.toLocaleString('id-ID');
          document.getElementById('uLpnTower').textContent = lpn.toLocaleString('id-ID');
          document.getElementById('uKtgTower').textContent = ktg.toLocaleString('id-ID');
          document.getElementById('uGtoTower').textContent = gto.toLocaleString('id-ID');
          document.getElementById('uTotTower').textContent = tot.toLocaleString('id-ID') + ' Tower';
          document.getElementById('statTowerCount').textContent = tot.toLocaleString('id-ID') + ' Tower';
        }
      }

      const lineRow = findRow('Total Circuit by Age');
      if(lineRow){
        const swg = cleanNum(lineRow[4]), lpn = cleanNum(lineRow[5]), ktg = cleanNum(lineRow[6]), gto = cleanNum(lineRow[7]), tot = cleanNum(lineRow[8] || lineRow[lineRow.length-1]);
        if(tot > 0){
          document.getElementById('uSwgLine').textContent = swg;
          document.getElementById('uLpnLine').textContent = lpn;
          document.getElementById('uKtgLine').textContent = ktg;
          document.getElementById('uGtoLine').textContent = gto;
          document.getElementById('uTotLine').textContent = tot + ' Sirkit';
          document.getElementById('statLineCount').textContent = tot + ' Sirkit';
        }
      }
    }catch(e){
      console.warn('Gagal membaca update CSV:', e);
    }
  }

  // Theme change observer untuk tile layer otomatis
  const observer = new MutationObserver(mutations => {
    mutations.forEach(m => {
      if(m.attributeName === 'data-theme' && map){
        const isDarkNow = document.documentElement.getAttribute('data-theme') === 'dark';
        const activeBtn = document.querySelector('#btnLayerDark.active, #btnLayerVoyager.active');
        if(activeBtn){
          if(isDarkNow){
            setMapBaseLayer('dark', document.getElementById('btnLayerDark'));
          } else {
            setMapBaseLayer('voyager', document.getElementById('btnLayerVoyager'));
          }
        }
        setTimeout(() => map.invalidateSize(), 100);
      }
    });
  });
  observer.observe(document.documentElement, { attributes: true });

  // Initialize
  function bootAset(){
    initMap();
    loadGiDetail();
    loadAssetSummary();
  }

  if(document.readyState === 'loading'){
    document.addEventListener('DOMContentLoaded', bootAset);
  } else {
    bootAset();
  }
  window.addEventListener('load', () => { if(map) map.invalidateSize(); });
  window.addEventListener('resize', () => { if(map) map.invalidateSize(); });
</script>
@endsection
