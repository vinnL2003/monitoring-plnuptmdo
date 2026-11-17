@extends('layouts.app')

@section('title', 'KONSTRUKSI & PENYALURAN — UPT MANADO')

@section('styles')
<style>
  .kp-page-header{
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
  .kp-metrics-grid{
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
    margin-bottom: 26px;
  }
  @media (max-width: 900px){ .kp-metrics-grid{ grid-template-columns: repeat(2, 1fr); } }
  @media (max-width: 480px){ .kp-metrics-grid{ grid-template-columns: 1fr; } }

  .kp-metric-card{
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 10px;
    padding: 18px 20px;
    box-shadow: var(--card-shadow);
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all .25s ease;
  }
  .kp-metric-card:hover{
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    border-color: var(--pln-blue);
  }
  [data-theme="dark"] .kp-metric-card:hover{ border-color: var(--pln-yellow); }
  .km-info h4{
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--text-muted);
    margin-bottom: 5px;
  }
  .km-info .val{
    font-size: 28px;
    font-weight: 800;
    color: var(--pln-blue);
    line-height: 1.1;
  }
  [data-theme="dark"] .km-info .val{ color: var(--pln-yellow); }
  .km-info .sub{
    font-size: 11.5px;
    color: var(--text-muted);
    margin-top: 6px;
  }
  .km-icon{
    font-size: 34px;
    opacity: 0.85;
  }

  /* Core summary progress items */
  .summary-progress-box{
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 22px;
    box-shadow: var(--card-shadow);
    margin-bottom: 28px;
  }
  .spb-header{
    margin-bottom: 16px;
  }
  .spb-header h3{
    font-size: 16px;
    font-weight: 800;
    color: var(--text-main);
  }
  .spb-header p{
    font-size: 12.5px;
    color: var(--text-muted);
    margin-top: 3px;
  }

  /* Navigation Tabs */
  .kp-tabs-bar{
    display: flex;
    gap: 6px;
    border-bottom: 2px solid var(--border-color);
    margin-bottom: 22px;
    overflow-x: auto;
  }
  .kp-tab-btn{
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
  .kp-tab-btn:hover{ color: var(--pln-blue); }
  [data-theme="dark"] .kp-tab-btn:hover{ color: var(--pln-yellow); }
  .kp-tab-btn.active{
    color: var(--pln-blue);
    border-bottom-color: var(--pln-blue);
  }
  [data-theme="dark"] .kp-tab-btn.active{
    color: var(--pln-yellow);
    border-bottom-color: var(--pln-yellow);
  }

  .tab-pane{ display: none; }
  .tab-pane.active{ display: block; animation: tabFade .25s ease; }
  @keyframes tabFade{ from{ opacity:0; transform: translateY(4px); } to{ opacity:1; transform: translateY(0); } }

  /* Project tables */
  .kp-table-card{
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 10px;
    box-shadow: var(--card-shadow);
    overflow: hidden;
    margin-bottom: 24px;
  }
  .kp-table-header{
    padding: 14px 18px;
    background: var(--table-header-bg);
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
  }
  .kp-table-header h3{
    font-size: 14.5px;
    font-weight: 700;
    margin: 0;
    color: var(--text-main);
  }
  .table-responsive{ width: 100%; overflow-x: auto; }
  .kp-table{
    width: 100%;
    border-collapse: collapse;
    font-size: 12.5px;
    text-align: left;
  }
  .kp-table th{
    background: var(--table-header-bg);
    color: var(--text-muted);
    font-weight: 700;
    padding: 11px 14px;
    border-bottom: 1px solid var(--border-color);
    white-space: nowrap;
  }
  .kp-table td{
    padding: 11px 14px;
    border-bottom: 1px solid var(--border-color);
    color: var(--text-main);
  }
  .kp-table tbody tr:hover{
    background: rgba(0, 82, 156, 0.03);
  }
  [data-theme="dark"] .kp-table tbody tr:hover{
    background: rgba(255, 255, 255, 0.03);
  }

  .status-pill{
    display: inline-block;
    padding: 3px 10px;
    border-radius: 14px;
    font-size: 11px;
    font-weight: 700;
  }
  .status-ontrack{ background: rgba(39, 174, 96, 0.15); color: #27AE60; border: 1px solid rgba(39, 174, 96, 0.3); }
  .status-caution{ background: rgba(217, 164, 0, 0.15); color: #D9A400; border: 1px solid rgba(217, 164, 0, 0.3); }
  .status-critical{ background: rgba(231, 76, 60, 0.15); color: #E74C3C; border: 1px solid rgba(231, 76, 60, 0.3); }

  /* Flow Diagram Cards */
  .flow-steps-grid{
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 14px;
    margin-top: 16px;
  }
  .flow-step-card{
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 10px;
    padding: 16px;
    box-shadow: var(--card-shadow);
    position: relative;
    border-top: 4px solid var(--pln-blue);
  }
  [data-theme="dark"] .flow-step-card{ border-top-color: var(--pln-yellow); }
  .flow-step-num{
    font-size: 11px;
    font-weight: 800;
    color: var(--pln-blue);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 6px;
  }
  [data-theme="dark"] .flow-step-num{ color: var(--pln-yellow); }
  .flow-step-title{
    font-size: 13.5px;
    font-weight: 700;
    color: var(--text-main);
    margin-bottom: 8px;
  }
  .flow-step-desc{
    font-size: 12px;
    color: var(--text-muted);
    line-height: 1.5;
  }

  /* Checklist items */
  .checklist-grid{
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 14px;
    margin-top: 16px;
  }
  .checklist-card{
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 10px;
    padding: 16px;
    box-shadow: var(--card-shadow);
  }
  .checklist-item{
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 8px 0;
    border-bottom: 1px dashed var(--border-color);
    font-size: 12.5px;
  }
  .checklist-item:last-child{ border-bottom: none; }
  .chk-badge{
    font-size: 14px;
    line-height: 1;
  }
</style>
@endsection

@section('content')
<div class="container">

  <!-- PAGE HEADER -->
  <div class="kp-page-header">
    <div class="breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span>/</span>
      <span>Konstruksi &amp; Penyaluran</span>
    </div>
    <div class="page-title-row">
      <div>
        <h1 class="page-title">
          <img src="{{ asset('Logo_UPT_Manado.png') }}" alt="PLN UPT Manado" style="height: 32px; width: auto; object-fit: contain; vertical-align: middle;">
          Manajemen Konstruksi, Kesiapan Operasi &amp; Penyaluran
        </h1>
        <p class="page-subtitle">
          Monitoring progres proyek pembangunan Saluran Udara Tegangan Tinggi (SUTT), Gardu Induk (GI), kesiapan Commercial Operation Date (COD), dan Serah Terima Operasi (STO) UPT Manado.
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
    $secKonstr = $sections['konstruksi'] ?? null;
    $pItems = $secKonstr?->progressItems ?? collect();
    $sCards = $secKonstr?->statCards ?? collect();

    // 1. Progres Konstruksi SUTT/GI (sinkron dengan Home)
    $itemSutt = $pItems->firstWhere('title', 'Progres Konstruksi SUTT/GI') ?? $sCards->firstWhere('title', 'Progres Konstruksi SUTT/GI');
    $valSutt = $itemSutt ? ($itemSutt->percentage !== null ? round($itemSutt->percentage) . '%' : ($itemSutt->effective_value ?? '68%')) : '68%';
    $descSutt = $itemSutt->description ?? ($itemSutt->effective_footer ?? 'Penyelesaian proyek konstruksi jaringan transmisi & GI');

    // 2. Kesiapan Penyaluran (COD) (sinkron dengan Home)
    $itemCod = $pItems->firstWhere('title', 'Kesiapan Penyaluran (COD)') ?? $sCards->firstWhere('title', 'Kesiapan Penyaluran (COD)');
    $valCod = $itemCod ? ($itemCod->percentage !== null ? round($itemCod->percentage) . '%' : ($itemCod->effective_value ?? '82%')) : '82%';
    $descCod = $itemCod->description ?? ($itemCod->effective_footer ?? 'Kesiapan penyaluran tenaga listrik pembangkit baru');

    // 3. Serah Terima Aset (STO) (sinkron dengan Home)
    $itemSto = $pItems->firstWhere('title', 'Serah Terima Aset (STO)') ?? $sCards->firstWhere('title', 'Serah Terima Aset (STO)');
    $valSto = $itemSto ? ($itemSto->percentage !== null ? round($itemSto->percentage) . '%' : ($itemSto->effective_value ?? '45%')) : '45%';
    $descSto = $itemSto->description ?? ($itemSto->effective_footer ?? 'Progres administrasi dan teknis STO');

    $numSutt = floatval(str_replace(['%',' '], '', $valSutt)) ?: 68;
    $numCod = floatval(str_replace(['%',' '], '', $valCod)) ?: 82;
    $numSto = floatval(str_replace(['%',' '], '', $valSto)) ?: 45;
    $avgProgress = round(($numSutt + $numCod + $numSto) / 3, 1) . '%';
  @endphp

  <!-- TOP KPI METRIC CARDS (SINKRON DENGAN DATA HALAMAN HOME) -->
  <div class="kp-metrics-grid">
    <div class="kp-metric-card">
      <div class="km-info">
        <h4>Progres Konstruksi SUTT/GI</h4>
        <div class="val">{{ $valSutt }}</div>
        <div class="sub">{{ $descSutt }}</div>
      </div>
      <div class="km-icon">🏗️</div>
    </div>

    <div class="kp-metric-card">
      <div class="km-info">
        <h4>Kesiapan Penyaluran (COD)</h4>
        <div class="val">{{ $valCod }}</div>
        <div class="sub">{{ $descCod }}</div>
      </div>
      <div class="km-icon">🔗</div>
    </div>

    <div class="kp-metric-card">
      <div class="km-info">
        <h4>Serah Terima Aset (STO)</h4>
        <div class="val">{{ $valSto }}</div>
        <div class="sub">{{ $descSto }}</div>
      </div>
      <div class="km-icon">📋</div>
    </div>

    <div class="kp-metric-card">
      <div class="km-info">
        <h4>Rata-rata Akumulasi</h4>
        <div class="val">{{ $avgProgress }}</div>
        <div class="sub">Rata-rata 3 Pilar Utama Home</div>
      </div>
      <div class="km-icon">📊</div>
    </div>
  </div>

  <!-- SUMMARY PROGRESS BARS SECTION (FROM CMS / DATABASE SINKRON HOME) -->
  <div class="summary-progress-box">
    <div class="spb-header">
      <h3>Ringkasan Pilar Konstruksi &amp; Kesiapan Penyaluran UPT Manado</h3>
      <p>Data integrasi sinkronisasi progres utama ketenagalistrikan wilayah Sulawesi Utara dan Gorontalo (sesuai halaman Home).</p>
    </div>
    <div class="grid-3">
      @if(isset($sections['konstruksi']->progressItems) && count($sections['konstruksi']->progressItems) > 0)
        @foreach($sections['konstruksi']->progressItems as $prog)
          <div class="ultg-card">
            <div class="ultg-title">{{ $prog->icon }} {{ $prog->title }}</div>
            <div class="ultg-desc">{{ $prog->description }}</div>
            <div class="progress-wrap"><div class="progress-bar" style="width:{{ $prog->percentage }}%"></div></div>
            <div class="progress-label"><span>Progres Realisasi</span><span style="font-weight:700;">{{ round($prog->percentage) }}%</span></div>
          </div>
        @endforeach
      @else
        <div class="ultg-card">
          <div class="ultg-title">🏗️ Progres Konstruksi SUTT/GI</div>
          <div class="ultg-desc">Persentase penyelesaian proyek konstruksi jaringan transmisi &amp; gardu induk yang sedang berjalan.</div>
          <div class="progress-wrap"><div class="progress-bar" style="width:68%"></div></div>
          <div class="progress-label"><span>Progres Realisasi</span><span style="font-weight:700;">68%</span></div>
        </div>
        <div class="ultg-card">
          <div class="ultg-title">🔗 Kesiapan Penyaluran (COD)</div>
          <div class="ultg-desc">Kesiapan penyaluran tenaga listrik dari pembangkit baru menuju jaringan sistem transmisi Sulutgo.</div>
          <div class="progress-wrap"><div class="progress-bar" style="width:82%"></div></div>
          <div class="progress-label"><span>Progres Realisasi</span><span style="font-weight:700;">82%</span></div>
        </div>
        <div class="ultg-card">
          <div class="ultg-title">📋 Serah Terima Aset (STO)</div>
          <div class="ultg-desc">Progres administrasi dan teknis serah terima operasi aset baru dari unit konstruksi ke unit transmisi.</div>
          <div class="progress-wrap"><div class="progress-bar" style="width:45%"></div></div>
          <div class="progress-label"><span>Progres Realisasi</span><span style="font-weight:700;">45%</span></div>
        </div>
      @endif
    </div>
  </div>

  <!-- NAVIGATION TABS -->
  <div class="kp-tabs-bar">
    <button class="kp-tab-btn active" onclick="switchKpTab('tab-proyek', this)">1. Daftar Proyek &amp; Capaian Pilar</button>
    <button class="kp-tab-btn" onclick="switchKpTab('tab-cod', this)">2. Kesiapan Penyaluran &amp; Uji COD</button>
    <button class="kp-tab-btn" onclick="switchKpTab('tab-sto', this)">3. Tata Kelola &amp; Prosedur STO</button>
    <button class="kp-tab-btn" onclick="switchKpTab('tab-wilayah', this)">4. Distribusi Pilar per Wilayah ULTG</button>
  </div>

  <!-- TAB 1: DAFTAR PROYEK KONSTRUKSI -->
  <div id="tab-proyek" class="tab-pane active">
    <!-- INFO STATUS SUMBER DATA TERKUNCI -->
    <div style="background:var(--bg-card); border:1px solid var(--border-color); border-radius:10px; padding:18px 22px; margin-bottom:20px; display:flex; align-items:flex-start; gap:14px; box-shadow:var(--card-shadow);">
      <div style="font-size:30px; line-height:1;">🔒</div>
      <div>
        <h4 style="font-size:14px; font-weight:700; color:var(--text-main); margin:0 0 4px;">Integrasi Rincian Spreadsheet Proyek Sedang Disiapkan</h4>
        <p style="font-size:12.5px; color:var(--text-muted); margin:0 0 8px; line-height:1.6;">
          Format file spreadsheet rincian proyek konstruksi saat ini dikunci sementara sambil menunggu file spreadsheet contoh resmi dari unit terkait. Data di bawah ini mengacu langsung pada <b>3 Pilar Utama Konstruksi &amp; Penyaluran</b> yang aktif di halaman Home.
        </p>
        <span style="display:inline-block; font-size:11.5px; background:rgba(0,82,156,0.08); color:var(--pln-blue); font-weight:700; padding:3px 10px; border-radius:12px;">
          Kode Sumber Data Admin: <code>konstruksi_penyaluran_csv</code>
        </span>
      </div>
    </div>

    <div class="kp-table-card">
      <div class="kp-table-header">
        <h3>Tabel Monitoring Progres Pilar Utama Konstruksi, COD &amp; STO</h3>
        <span style="font-size:12px; color:var(--text-muted);">Disinkronkan dari data Halaman Home &amp; Panel Admin</span>
      </div>
      <div class="table-responsive">
        <table class="kp-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Pilar Kunci Pekerjaan</th>
              <th>Ruang Lingkup &amp; Wilayah Kerja</th>
              <th>Target</th>
              <th style="text-align:right;">Realisasi Progres</th>
              <th>Status</th>
              <th>Keterangan Operasional</th>
            </tr>
          </thead>
          <tbody id="proyek-tbody">
            <tr>
              <td>1</td>
              <td>
                <b>Progres Konstruksi SUTT/GI</b><br>
                <span style="font-size:11.5px; color:var(--text-muted);">Pembangunan fisik jaringan Saluran Udara Tegangan Tinggi &amp; Gardu Induk</span>
              </td>
              <td>Wilayah Kerja PLN UPT Manado</td>
              <td>100%</td>
              <td style="text-align:right; font-weight:700; color:#27AE60;">{{ $valSutt }}</td>
              <td><span class="status-pill status-ontrack">On Track</span></td>
              <td>{{ $descSutt }}</td>
            </tr>
            <tr>
              <td>2</td>
              <td>
                <b>Kesiapan Penyaluran (COD)</b><br>
                <span style="font-size:11.5px; color:var(--text-muted);">Commercial Operation Date &amp; evakuasi daya pembangkit ke transmisi</span>
              </td>
              <td>Sistem Interkoneksi Sulutgo</td>
              <td>100%</td>
              <td style="text-align:right; font-weight:700; color:#27AE60;">{{ $valCod }}</td>
              <td><span class="status-pill status-ontrack">On Track</span></td>
              <td>{{ $descCod }}</td>
            </tr>
            <tr>
              <td>3</td>
              <td>
                <b>Serah Terima Aset (STO)</b><br>
                <span style="font-size:11.5px; color:var(--text-muted);">Administrasi dan verifikasi teknis serah terima aset dari UIP ke UPT</span>
              </td>
              <td>Aset Baru UPT Manado</td>
              <td>100%</td>
              <td style="text-align:right; font-weight:700; color:#D9A400;">{{ $valSto }}</td>
              <td><span class="status-pill status-caution">Tahap Verifikasi</span></td>
              <td>{{ $descSto }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- TAB 2: KESIAPAN PENYALURAN & COD -->
  <div id="tab-cod" class="tab-pane">
    <div class="summary-progress-box">
      <div class="spb-header">
        <h3>Tahapan Standar Kesiapan Penyaluran &amp; Uji Komisioning Energize (COD)</h3>
        <p>Prosedur ketat sebelum aset baru diberi tegangan dan dialirkan daya listrik ke konsumen sistem Sulutgo.</p>
      </div>

      <div class="flow-steps-grid">
        <div class="flow-step-card">
          <div class="flow-step-num">Tahap 01</div>
          <div class="flow-step-title">Uji Individual MTU</div>
          <div class="flow-step-desc">
            Pemeriksaan menyeluruh tahanan isolasi, rasio belitan, DGA minyak, tahanan kontak PMT/PMS, dan pengujian tegangan tembus pada seluruh peralatan utama.
          </div>
        </div>

        <div class="flow-step-card">
          <div class="flow-step-num">Tahap 02</div>
          <div class="flow-step-title">Skema &amp; Uji Proteksi</div>
          <div class="flow-step-desc">
            Uji injeksi sekunder relay proteksi, line differential, distance relay, dan verifikasi interlocking sistem tripping CB untuk mencegah trip meluas.
          </div>
        </div>

        <div class="flow-step-card">
          <div class="flow-step-num">Tahap 03</div>
          <div class="flow-step-title">Integrasi SCADA &amp; Telecom</div>
          <div class="flow-step-desc">
            Uji komunikasi OPGW/Radio ke Dispatcher Area Control Center (ACC) Manado, memastikan seluruh sinyal telemetry, telesignal, dan telecommand aktif sempurna.
          </div>
        </div>

        <div class="flow-step-card">
          <div class="flow-step-num">Tahap 04</div>
          <div class="flow-step-title">Sertifikat Laik Operasi (SLO)</div>
          <div class="flow-step-desc">
            Inspeksi kepatuhan keteknikan dan keselamatan ketenagalistrikan oleh Lembaga Inspeksi Teknis (LIT) independen untuk penerbitan izin laik operasi resmi.
          </div>
        </div>

        <div class="flow-step-card">
          <div class="flow-step-num">Tahap 05</div>
          <div class="flow-step-title">First Energize 24 Jam</div>
          <div class="flow-step-desc">
            Pemberian tegangan percobaan pertama tanpa beban selama 24 jam non-stop untuk memverifikasi kestabilan termal, dielektrik, dan keseimbangan fase.
          </div>
        </div>
      </div>

      <div class="checklist-grid" style="margin-top:24px;">
        <div class="checklist-card">
          <h4 style="font-size:13.5px; font-weight:700; color:var(--pln-blue); margin-bottom:10px;">⚡ Checklist Kesiapan Evakuasi Daya Pembangkit Baru</h4>
          <div class="checklist-item">
            <span class="chk-badge">✅</span>
            <span>Uji sinkronisasi frekuensi generator pembangkit terhadap sistem 150 kV Sulutgo.</span>
          </div>
          <div class="checklist-item">
            <span class="chk-badge">✅</span>
            <span>Ketersediaan Special Protection Scheme (SPS) / Island Scheme jika terjadi lepasnya interkoneksi.</span>
          </div>
          <div class="checklist-item">
            <span class="chk-badge">✅</span>
            <span>Pengujian Automatic Generation Control (AGC) dan Governor Response pembangkit.</span>
          </div>
        </div>

        <div class="checklist-card">
          <h4 style="font-size:13.5px; font-weight:700; color:var(--pln-blue); margin-bottom:10px;">📋 Checklist Personil &amp; SOP Pengoperasian</h4>
          <div class="checklist-item">
            <span class="chk-badge">✅</span>
            <span>Penetapan Single Line Diagram (SLD) final yang ditandatangani Manajer UPT Manado &amp; UIP.</span>
          </div>
          <div class="checklist-item">
            <span class="chk-badge">✅</span>
            <span>Pelatihan personil operator gardu induk dan teknisi ULTG terkait spesifikasi peralatan baru.</span>
          </div>
          <div class="checklist-item">
            <span class="chk-badge">✅</span>
            <span>Penyediaan Alat Pelindung Diri (APD) dan grounding stick cadangan di lokasi gardu induk.</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- TAB 3: TATA KELOLA STO -->
  <div id="tab-sto" class="tab-pane">
    <div class="summary-progress-box">
      <div class="spb-header">
        <h3>Tata Kelola Serah Terima Operasi (STO) Aset Ketenagalistrikan</h3>
        <p>Prosedur pengalihan tanggung jawab pemeliharaan dan pengoperasian dari Unit Pembangunan ke Unit Pengusahaan.</p>
      </div>

      <div class="flow-steps-grid">
        <div class="flow-step-card">
          <div class="flow-step-num">Fase 1</div>
          <div class="flow-step-title">Joint Inspection Pra-STO</div>
          <div class="flow-step-desc">
            Tim bersama UPT Manado dan UIP melakukan audit fisik lapangan untuk menginventarisir punch list (catatan kekurangan minor yang harus diselesaikan vendor).
          </div>
        </div>

        <div class="flow-step-card">
          <div class="flow-step-num">Fase 2</div>
          <div class="flow-step-title">BA STO 1 (Handover Operasi)</div>
          <div class="flow-step-desc">
            Penerbitan Berita Acara Serah Terima Operasi Tahap 1. Sejak tanggal ini, operasional aset resmi ditangani oleh UPT Manado, sementara masa garansi vendor berjalan.
          </div>
        </div>

        <div class="flow-step-card">
          <div class="flow-step-num">Fase 3</div>
          <div class="flow-step-title">Defect Liability Period (1 Thn)</div>
          <div class="flow-step-desc">
            Masa pengawasan garansi selama 12 bulan. Segala kerusakan akibat kegagalan material atau instalasi wajib diperbaiki oleh kontraktor pelaksana.
          </div>
        </div>

        <div class="flow-step-card">
          <div class="flow-step-num">Fase 4</div>
          <div class="flow-step-title">BA STO 2 (Final Handover)</div>
          <div class="flow-step-desc">
            Penerbitan Berita Acara Final setelah seluruh garansi selesai dan seluruh punch list terpenuhi 100%, disertai penyerahan aset di pembukuan aktiva tetap (SAP).
          </div>
        </div>
      </div>

      <div class="kp-table-card" style="margin-top:24px;">
        <div class="kp-table-header">
          <h3>Kelengkapan Berkas Administrasi &amp; Dokumen Wajib STO</h3>
        </div>
        <div class="table-responsive">
          <table class="kp-table">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Dokumen Wajib</th>
                <th>Instansi Penyedia</th>
                <th>Fungsi bagi UPT Manado</th>
                <th>Status Ketersediaan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td><b>As-Built Drawing (Desain Akhir Terbangun)</b></td>
                <td>Kontraktor / UIP</td>
                <td>Panduan tracing pengkabelan, layout pondasi, dan diagram skematik proteksi.</td>
                <td><span class="status-pill status-ontrack">Wajib 100%</span></td>
              </tr>
              <tr>
                <td>2</td>
                <td><b>Laporan Hasil Komisioning Bersama</b></td>
                <td>Tim Komisioning LIT</td>
                <td>Data baseline awal parameter kesehatan peralatan (AHI awal) sebelum operasi.</td>
                <td><span class="status-pill status-ontrack">Wajib 100%</span></td>
              </tr>
              <tr>
                <td>3</td>
                <td><b>Buku Manual O&amp;M &amp; Sertifikat Uji Pabrik</b></td>
                <td>Pabrikan / Vendor</td>
                <td>Petunjuk standar pemeliharaan berkala dan batas toleransi operasional alat.</td>
                <td><span class="status-pill status-ontrack">Wajib 100%</span></td>
              </tr>
              <tr>
                <td>4</td>
                <td><b>Daftar Suku Cadang Wajib (Mandatory Spares)</b></td>
                <td>Kontraktor UIP</td>
                <td>Ketersediaan cadangan bushing, gasket, trip coil, dan arrester untuk fast recovery.</td>
                <td><span class="status-pill status-ontrack">Wajib 100%</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- TAB 4: SEBARAN WILAYAH ULTG -->
  <div id="tab-wilayah" class="tab-pane">
    <div class="grid-3">
      <div class="ultg-card">
        <div class="ultg-title">🏢 ULTG Sawangan</div>
        <div class="ultg-desc">
          Fokus wilayah keandalan transmisi ring Kota Manado &amp; KEK Likupang:
        </div>
        <ul style="font-size:12px; color:var(--text-muted); margin-left:18px; line-height:1.7;">
          <li>Pembangunan jalur transmisi SUTT 150 kV Likupang - Paniki.</li>
          <li>Pembangunan GIS 150 kV Malalayang Manado.</li>
          <li>Uprating konduktor jalur evakuasi daya sistem Manado.</li>
        </ul>
      </div>

      <div class="ultg-card">
        <div class="ultg-title">🏢 ULTG Lopana</div>
        <div class="ultg-desc">
          Fokus wilayah Minahasa Selatan &amp; Minahasa Tenggara:
        </div>
        <ul style="font-size:12px; color:var(--text-muted); margin-left:18px; line-height:1.7;">
          <li>Pembangunan GI 150 kV Belang (30 MVA) &amp; incomer.</li>
          <li>Penambahan kapasitas trafo daya GI 150 kV Lopana.</li>
          <li>Penguatan keandalan bay line penghubung antar gardu.</li>
        </ul>
      </div>

      <div class="ultg-card">
        <div class="ultg-title">🏢 ULTG Kotamobagu &amp; Gorontalo</div>
        <div class="ultg-desc">
          Fokus interkoneksi antar provinsi Sulut - Gorontalo:
        </div>
        <ul style="font-size:12px; color:var(--text-muted); margin-left:18px; line-height:1.7;">
          <li>Pembangunan jalur transmisi SUTT 150 kV Isimu - Marisa.</li>
          <li>Perkuatan keandalan gardu hubung interkoneksi regional.</li>
          <li>Kesiapan evakuasi daya pembangkit EBT daerah.</li>
        </ul>
      </div>
    </div>
  </div>

</div>
@endsection

@section('scripts')
<script>
  function switchKpTab(tabId, btn){
    document.querySelectorAll('.kp-tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    const target = document.getElementById(tabId);
    if(target) target.classList.add('active');
  }
</script>
@endsection
