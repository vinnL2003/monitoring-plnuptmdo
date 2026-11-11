@extends('layouts.app')

@section('title', 'KKU — UPT MANADO')

@section('styles')
<style>
  .kku-page-header{
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
  .kku-metrics-grid{
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
    margin-bottom: 26px;
  }
  @media (max-width: 900px){ .kku-metrics-grid{ grid-template-columns: repeat(2, 1fr); } }
  @media (max-width: 480px){ .kku-metrics-grid{ grid-template-columns: 1fr; } }

  .kku-metric-card{
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
  .kku-metric-card:hover{
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    border-color: var(--pln-blue);
  }
  [data-theme="dark"] .kku-metric-card:hover{ border-color: var(--pln-yellow); }
  .kku-info h4{
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--text-muted);
    margin-bottom: 5px;
  }
  .kku-info .val{
    font-size: 28px;
    font-weight: 800;
    color: var(--pln-blue);
    line-height: 1.1;
  }
  [data-theme="dark"] .kku-info .val{ color: var(--pln-yellow); }
  .kku-info .sub{
    font-size: 11.5px;
    color: var(--text-muted);
    margin-top: 6px;
  }
  .kku-icon{
    font-size: 34px;
    opacity: 0.85;
  }

  /* Navigation Tabs */
  .kku-tabs-bar{
    display: flex;
    gap: 6px;
    border-bottom: 2px solid var(--border-color);
    margin-bottom: 22px;
    overflow-x: auto;
  }
  .kku-tab-btn{
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
  .kku-tab-btn:hover{ color: var(--pln-blue); }
  [data-theme="dark"] .kku-tab-btn:hover{ color: var(--pln-yellow); }
  .kku-tab-btn.active{
    color: var(--pln-blue);
    border-bottom-color: var(--pln-blue);
  }
  [data-theme="dark"] .kku-tab-btn.active{
    color: var(--pln-yellow);
    border-bottom-color: var(--pln-yellow);
  }

  .tab-pane{ display: none; }
  .tab-pane.active{ display: block; animation: tabFade .25s ease; }
  @keyframes tabFade{ from{ opacity:0; transform: translateY(4px); } to{ opacity:1; transform: translateY(0); } }

  /* Tables */
  .kku-table-card{
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 10px;
    box-shadow: var(--card-shadow);
    overflow: hidden;
    margin-bottom: 24px;
  }
  .kku-table-header{
    padding: 14px 18px;
    background: var(--table-header-bg);
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
  }
  .kku-table-header h3{
    font-size: 14.5px;
    font-weight: 700;
    margin: 0;
    color: var(--text-main);
  }
  .table-responsive{ width: 100%; overflow-x: auto; }
  .kku-table{
    width: 100%;
    border-collapse: collapse;
    font-size: 12.5px;
    text-align: left;
  }
  .kku-table th{
    background: var(--table-header-bg);
    color: var(--text-muted);
    font-weight: 700;
    padding: 11px 14px;
    border-bottom: 1px solid var(--border-color);
    white-space: nowrap;
  }
  .kku-table td{
    padding: 11px 14px;
    border-bottom: 1px solid var(--border-color);
    color: var(--text-main);
  }
  .kku-table tbody tr:hover{
    background: rgba(0, 82, 156, 0.03);
  }
  [data-theme="dark"] .kku-table tbody tr:hover{
    background: rgba(255, 255, 255, 0.03);
  }

  .status-pill{
    display: inline-block;
    padding: 3px 10px;
    border-radius: 14px;
    font-size: 11px;
    font-weight: 700;
  }
  .status-closed{ background: rgba(39, 174, 96, 0.15); color: #27AE60; border: 1px solid rgba(39, 174, 96, 0.3); }
  .status-progress{ background: rgba(217, 164, 0, 0.15); color: #D9A400; border: 1px solid rgba(217, 164, 0, 0.3); }
  .status-open{ background: rgba(231, 76, 60, 0.15); color: #E74C3C; border: 1px solid rgba(231, 76, 60, 0.3); }

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
  <div class="kku-page-header">
    <div class="breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span>/</span>
      <span>Kinerja Keuangan &amp; Umum</span>
    </div>
    <div class="page-title-row">
      <div>
        <h1 class="page-title">
          <img src="{{ asset('Logo_UPT_Manado.png') }}" alt="PLN UPT Manado" style="height: 32px; width: auto; object-fit: contain; vertical-align: middle;">
          Dashboard Kinerja Keuangan &amp; Umum (KKU)
        </h1>
        <p class="page-subtitle">
          Monitoring realisasi anggaran operasi, kepatuhan tata kelola, tindak lanjut rekomendasi audit, capaian kumulatif, dan indikator pendukung keandalan transmisi UPT Manado.
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
    $kkuCards = $sections['kku']->statCards ?? collect();
    $cReal = $kkuCards->values()->get(0);
    $cTindak = $kkuCards->values()->get(1);
    $cKumul = $kkuCards->values()->get(2);
  @endphp

  <!-- TOP 4 KPI CARDS -->
  <div class="kku-metrics-grid">
    <div class="kku-metric-card" id="cardKkuRealisasiDetail">
      <div class="kku-info">
        <h4>{{ $cReal->title ?? 'Realisasi KKU Bulan Berjalan' }}</h4>
        <div class="val" id="valKkuReal">{{ ($cReal && $cReal->effective_value !== '-') ? ($cReal->effective_value . ($cReal->effective_unit ? ' ' . $cReal->effective_unit : '')) : '-' }}</div>
        <div class="sub" id="footKkuReal">{{ $cReal ? $cReal->effective_footer : 'Menunggu sumber data KKU' }}</div>
      </div>
      <div class="kku-icon">📈</div>
    </div>

    <div class="kku-metric-card" id="cardKkuTindakLanjutDetail">
      <div class="kku-info">
        <h4>{{ $cTindak->title ?? 'Status Tindak Lanjut' }}</h4>
        <div class="val" id="valKkuTindak">{{ ($cTindak && $cTindak->effective_value !== '-') ? ($cTindak->effective_value . ($cTindak->effective_unit ? ' ' . $cTindak->effective_unit : '')) : '-' }}</div>
        <div class="sub" id="footKkuTindak">{{ $cTindak ? $cTindak->effective_footer : 'Menunggu sumber data KKU' }}</div>
      </div>
      <div class="kku-icon">🎯</div>
    </div>

    <div class="kku-metric-card" id="cardKkuKumulatifDetail">
      <div class="kku-info">
        <h4>{{ $cKumul->title ?? 'Capaian Kumulatif' }}</h4>
        <div class="val" id="valKkuKumul">{{ ($cKumul && $cKumul->effective_value !== '-') ? ($cKumul->effective_value . ($cKumul->effective_unit ? ' ' . $cKumul->effective_unit : '')) : '-' }}</div>
        <div class="sub" id="footKkuKumul">{{ $cKumul ? $cKumul->effective_footer : 'Menunggu sumber data KKU' }}</div>
      </div>
      <div class="kku-icon">🏆</div>
    </div>

    <div class="kku-metric-card">
      <div class="kku-info">
        <h4>Efisiensi Opex Pemeliharaan</h4>
        <div class="val" id="valKkuOpex">-</div>
        <div class="sub" id="footKkuOpex">Menunggu sumber data KKU</div>
      </div>
      <div class="kku-icon">💰</div>
    </div>
  </div>

  <!-- NAVIGATION TABS -->
  <div class="kku-tabs-bar">
    <button class="kku-tab-btn active" onclick="switchKkuTab('tab-matriks', this)">1. Matriks Capaian Indikator Kunci KKU</button>
    <button class="kku-tab-btn" onclick="switchKkuTab('tab-audit', this)">2. Tindak Lanjut Rekomendasi Audit (SPI/BPK)</button>
    <button class="kku-tab-btn" onclick="switchKkuTab('tab-historis', this)">3. Historis Realisasi Bulanan</button>
    <button class="kku-tab-btn" onclick="switchKkuTab('tab-strategi', this)">4. Kebijakan &amp; Rencana Aksi</button>
  </div>

  <!-- TAB 1: MATRIKS CAPAIAN INDIKATOR KUNCI KKU -->
  <div id="tab-matriks" class="tab-pane active">
    <div class="kku-table-card">
      <div class="kku-table-header">
        <h3>Matriks Rincian Penilaian Indikator Kinerja Keuangan &amp; Umum UPT Manado</h3>
        <span style="font-size:12px; color:var(--text-muted);">Periode Evaluasi Kinerja Korporat 2026</span>
      </div>
      <div class="table-responsive">
        <table class="kku-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Indikator Kinerja KKU</th>
              <th style="text-align:center;">Bobot</th>
              <th style="text-align:right;">Target</th>
              <th style="text-align:right;">Realisasi</th>
              <th style="text-align:center;">Polaritas</th>
              <th style="text-align:right;">Capaian (%)</th>
              <th>Status &amp; Analisis</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>
                <b>Realisasi Anggaran Operasi (AO) &amp; Pengendalian Biaya</b><br>
                <span style="font-size:11.5px; color:var(--text-muted);">Penyerapan biaya pemeliharaan jaringan, gardu induk, dan proteksi</span>
              </td>
              <td style="text-align:center;">25%</td>
              <td style="text-align:right;">100.0%</td>
              <td style="text-align:right; font-weight:700;">97.4%</td>
              <td style="text-align:center;">Positif</td>
              <td style="text-align:right; font-weight:700; color:#27AE60;">97.4%</td>
              <td><span class="status-pill status-closed">Optimal</span> Sesuai target pemeliharaan preventif</td>
            </tr>
            <tr>
              <td>2</td>
              <td>
                <b>Kecepatan &amp; Akuntabilitas Pertanggungjawaban SPJ</b><br>
                <span style="font-size:11.5px; color:var(--text-muted);">Kepatuhan batas waktu pelaporan cash out dan kelengkapan bukti transaksi</span>
              </td>
              <td style="text-align:center;">20%</td>
              <td style="text-align:right;">100.0%</td>
              <td style="text-align:right; font-weight:700;">100.0%</td>
              <td style="text-align:center;">Positif</td>
              <td style="text-align:right; font-weight:700; color:#27AE60;">100.0%</td>
              <td><span class="status-pill status-closed">Sempurna</span> Zero keterlambatan administrasi</td>
            </tr>
            <tr>
              <td>3</td>
              <td>
                <b>Kepatuhan Tingkat Komponen Dalam Negeri (TKDN)</b><br>
                <span style="font-size:11.5px; color:var(--text-muted);">Pemanfaatan material transmisi buatan pabrikan dalam negeri</span>
              </td>
              <td style="text-align:center;">15%</td>
              <td style="text-align:right;">45.0%</td>
              <td style="text-align:right; font-weight:700;">52.8%</td>
              <td style="text-align:center;">Positif</td>
              <td style="text-align:right; font-weight:700; color:#27AE60;">117.3%</td>
              <td><span class="status-pill status-closed">Melampaui</span> Konduktor, tower, isolator lokal</td>
            </tr>
            <tr>
              <td>4</td>
              <td>
                <b>Optimalisasi Logistik, Pergudangan &amp; Spare Parts</b><br>
                <span style="font-size:11.5px; color:var(--text-muted);">Akurasi stock opname gudang material transmisi &amp; kesiapan cadang fast moving</span>
              </td>
              <td style="text-align:center;">15%</td>
              <td style="text-align:right;">100.0%</td>
              <td style="text-align:right; font-weight:700;">96.2%</td>
              <td style="text-align:center;">Positif</td>
              <td style="text-align:right; font-weight:700; color:#27AE60;">96.2%</td>
              <td><span class="status-pill status-closed">Baik</span> Seluruh material cadang siap pakai</td>
            </tr>
            <tr>
              <td>5</td>
              <td>
                <b>Kepatuhan K3, Keamanan Gardu Induk &amp; Lingkungan Hidup</b><br>
                <span style="font-size:11.5px; color:var(--text-muted);">Pencapaian Zero Accident, sertifikasi SMK3, pengelolaan limbah B3 minyak trafo</span>
              </td>
              <td style="text-align:center;">15%</td>
              <td style="text-align:right;">100.0%</td>
              <td style="text-align:right; font-weight:700;">100.0%</td>
              <td style="text-align:center;">Positif</td>
              <td style="text-align:right; font-weight:700; color:#27AE60;">100.0%</td>
              <td><span class="status-pill status-closed">Nihil Kecelakaan</span> Zero accident kerja tercapai</td>
            </tr>
            <tr>
              <td>6</td>
              <td>
                <b>Legalitas Tanah Aset Gardu Induk &amp; Pelayanan Kantor</b><br>
                <span style="font-size:11.5px; color:var(--text-muted);">Sertifikasi tapak tower / GI bersama BPN dan pemenuhan sarana perkantoran</span>
              </td>
              <td style="text-align:center;">10%</td>
              <td style="text-align:right;">90.0%</td>
              <td style="text-align:right; font-weight:700;">91.5%</td>
              <td style="text-align:center;">Positif</td>
              <td style="text-align:right; font-weight:700; color:#27AE60;">101.6%</td>
              <td><span class="status-pill status-closed">On Track</span> Percepatan sertifikasi bersama BPN Sulutgo</td>
            </tr>
          </tbody>
          <tfoot>
            <tr style="font-weight:800; background:var(--table-header-bg);">
              <td colspan="2">TOTAL CAPAIAN KINERJA KEUANGAN &amp; UMUM (KKU)</td>
              <td style="text-align:center;">100%</td>
              <td colspan="3"></td>
              <td style="text-align:right; color:#27AE60;" id="kkuTotalScoreCell">98.4%</td>
              <td>Kategori Kinerja: <b>SANGAT BAIK</b></td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>

  <!-- TAB 2: TINDAK LANJUT AUDIT -->
  <div id="tab-audit" class="tab-pane">
    <div class="kku-table-card">
      <div class="kku-table-header">
        <h3>Matriks Penyelesaian Rekomendasi Hasil Audit &amp; Pengawasan</h3>
        <span style="font-size:12px; color:var(--text-muted);">Satuan Pengawasan Intern (SPI) &amp; Eksternal</span>
      </div>
      <div class="table-responsive">
        <table class="kku-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Lembaga Pengawas &amp; No. Laporan</th>
              <th>Uraian Temuan / Rekomendasi</th>
              <th>Unit Penanggung Jawab</th>
              <th>Target Selesai</th>
              <th>Status Tindak Lanjut</th>
              <th>Progres Verifikasi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>
                <b>SPI PLN Kantor Pusat</b><br>
                <span style="font-size:11px; color:var(--text-muted);">LHP No. 042/SPI/2025</span>
              </td>
              <td>Penyempurnaan tata cara pencatatan kartu persediaan material cadang OPGW di gudang transit Sawangan.</td>
              <td>Bagian Keuangan &amp; Logistik</td>
              <td>Januari 2026</td>
              <td><span class="status-pill status-closed">Closed (100%)</span></td>
              <td>Telah diverifikasi SPI, implementasi barcode scanning gudang aktif.</td>
            </tr>
            <tr>
              <td>2</td>
              <td>
                <b>KAP Eksternal</b><br>
                <span style="font-size:11px; color:var(--text-muted);">Audit Lap. Keuangan 2025</span>
              </td>
              <td>Rekonsiliasi berkala akun aktiva dalam pelaksanaan (ADP) terhadap proyek yang telah energize.</td>
              <td>Bagian Akuntansi &amp; Pajak</td>
              <td>Februari 2026</td>
              <td><span class="status-pill status-closed">Closed (100%)</span></td>
              <td>Seluruh Berita Acara STO telah dibukukan ke aktiva tetap SAP.</td>
            </tr>
            <tr>
              <td>3</td>
              <td>
                <b>Audit Lingkungan Hidup BPK</b><br>
                <span style="font-size:11px; color:var(--text-muted);">Inspeksi Fasilitas B3</span>
              </td>
              <td>Pemenuhan izin tempat penyimpanan sementara (TPS) limbah B3 trafo bekas di GI Kotamobagu.</td>
              <td>K3L &amp; Keamanan UPT</td>
              <td>Maret 2026</td>
              <td><span class="status-pill status-closed">Closed (100%)</span></td>
              <td>Izin TPS B3 dari Dinas Lingkungan Hidup telah terbit dan fasilitas terpasang.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- TAB 3: HISTORIS REALISASI BULANAN -->
  <div id="tab-historis" class="tab-pane">
    <div class="kku-table-card">
      <div class="kku-table-header">
        <h3>Tabel Historis Realisasi Bulanan KKU Tahun Berjalan</h3>
        <span style="font-size:12px; color:var(--text-muted);">Data realisasi bulanan vs target kumulatif tahunan</span>
      </div>
      <div class="table-responsive">
        <table class="kku-table">
          <thead>
            <tr>
              <th>Periode Bulan</th>
              <th style="text-align:right;">Target Bulanan</th>
              <th style="text-align:right;">Realisasi Bulanan</th>
              <th style="text-align:right;">Deviasi (%)</th>
              <th style="text-align:right;">Capaian Kumulatif</th>
              <th>Status Pencapaian</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><b>Januari</b></td>
              <td style="text-align:right;">90.0%</td>
              <td style="text-align:right; font-weight:700;">94.2%</td>
              <td style="text-align:right; color:#27AE60;">+4.2%</td>
              <td style="text-align:right; font-weight:700;">94.2%</td>
              <td><span class="status-pill status-closed">Tercapai</span></td>
            </tr>
            <tr>
              <td><b>Februari</b></td>
              <td style="text-align:right;">91.0%</td>
              <td style="text-align:right; font-weight:700;">95.8%</td>
              <td style="text-align:right; color:#27AE60;">+4.8%</td>
              <td style="text-align:right; font-weight:700;">95.0%</td>
              <td><span class="status-pill status-closed">Tercapai</span></td>
            </tr>
            <tr>
              <td><b>Maret</b></td>
              <td style="text-align:right;">92.0%</td>
              <td style="text-align:right; font-weight:700;">96.5%</td>
              <td style="text-align:right; color:#27AE60;">+4.5%</td>
              <td style="text-align:right; font-weight:700;">95.5%</td>
              <td><span class="status-pill status-closed">Tercapai</span></td>
            </tr>
            <tr>
              <td><b>April</b></td>
              <td style="text-align:right;">92.5%</td>
              <td style="text-align:right; font-weight:700;">97.1%</td>
              <td style="text-align:right; color:#27AE60;">+4.6%</td>
              <td style="text-align:right; font-weight:700;">95.9%</td>
              <td><span class="status-pill status-closed">Tercapai</span></td>
            </tr>
            <tr>
              <td><b>Mei</b></td>
              <td style="text-align:right;">93.0%</td>
              <td style="text-align:right; font-weight:700;">97.8%</td>
              <td style="text-align:right; color:#27AE60;">+4.8%</td>
              <td style="text-align:right; font-weight:700;">96.3%</td>
              <td><span class="status-pill status-closed">Tercapai</span></td>
            </tr>
            <tr>
              <td><b>Juni</b></td>
              <td style="text-align:right;">94.0%</td>
              <td style="text-align:right; font-weight:700;">98.4%</td>
              <td style="text-align:right; color:#27AE60;">+4.4%</td>
              <td style="text-align:right; font-weight:700;">96.8%</td>
              <td><span class="status-pill status-closed">Tercapai</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- TAB 4: STRATEGI & RENCANA KERJA -->
  <div id="tab-strategi" class="tab-pane">
    <div class="info-boxes-grid">
      <div class="info-box">
        <div class="info-box-title">💼 Tata Kelola Anggaran Berkelanjutan</div>
        <div class="info-box-desc">
          Melakukan monitoring penyerapan anggaran operasi (AO) secara mingguan bersama seluruh Manajer ULTG guna menghindari penumpukan tagihan di akhir tahun anggaran dan memastikan cash flow pemeliharaan aset transmisi tetap prima.
        </div>
      </div>
      <div class="info-box">
        <div class="info-box-title">⚖️ Zero Audit Finding &amp; Good Corporate Governance</div>
        <div class="info-box-desc">
          Menerapkan prinsip GCG secara konsisten pada setiap pengadaan barang dan jasa, mempercepat tindak lanjut audit SPI dan BPK hingga tuntas 100%, serta melakukan digitalisasi pengarsipan berkasa kontrak dan pembayaran.
        </div>
      </div>
      <div class="info-box">
        <div class="info-box-title">🛡️ Budaya K3 &amp; Keselamatan Kerja Terpadu</div>
        <div class="info-box-desc">
          Menjaga komitmen Zero Accident melalui pengawasan ketat implementasi Working at Height (WAH), inspeksi berkala APD, pelaksanaan safety briefing sebelum setiap pekerjaan pemeliharaan, dan kepatuhan Standar Operasional Prosedur (SOP).
        </div>
      </div>
      <div class="info-box">
        <div class="info-box-title">🏛️ Percepatan Legalitas Tanah Aset Gardu Induk</div>
        <div class="info-box-desc">
          Mengintensifkan koordinasi strategis dengan Kantor Pertanahan BPN di wilayah Sulawesi Utara dan Gorontalo untuk percepatan penerbitan sertifikat kepemilikan tanah Gardu Induk dan kompensasi tapak tower demi kepastian hukum aset negara.
        </div>
      </div>
    </div>
  </div>

</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.4.1/papaparse.min.js"></script>

<script>
  const KKU_CSV_URL = (window.APP_DATA_SOURCES && window.APP_DATA_SOURCES.kku_csv) ? window.APP_DATA_SOURCES.kku_csv : null;

  function switchKkuTab(tabId, btn){
    document.querySelectorAll('.kku-tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    const target = document.getElementById(tabId);
    if(target) target.classList.add('active');
  }

  async function loadKkuDetailData(){
    const valReal = document.getElementById('valKkuReal');
    const valTindak = document.getElementById('valKkuTindak');
    const valKumul = document.getElementById('valKkuKumul');
    const valOpex = document.getElementById('valKkuOpex');
    const footReal = document.getElementById('footKkuReal');
    const footTindak = document.getElementById('footKkuTindak');
    const footKumul = document.getElementById('footKkuKumul');
    const footOpex = document.getElementById('footKkuOpex');

    if(!KKU_CSV_URL || !KKU_CSV_URL.trim()){
      if(valReal) valReal.textContent = '-';
      if(valTindak) valTindak.textContent = '-';
      if(valKumul) valKumul.textContent = '-';
      if(valOpex) valOpex.textContent = '-';
      if(footReal) footReal.textContent = 'Sumber data dinonaktifkan';
      if(footTindak) footTindak.textContent = 'Sumber data dinonaktifkan';
      if(footKumul) footKumul.textContent = 'Sumber data dinonaktifkan';
      if(footOpex) footOpex.textContent = 'Sumber data dinonaktifkan';

      const tbMatriks = document.querySelector('#tab-matriks tbody');
      if(tbMatriks){
        tbMatriks.innerHTML = '<tr><td colspan="8" style="text-align:center; padding:35px 20px; color:var(--text-muted);"><div style="font-size:28px; margin-bottom:8px;">📋</div>Sumber data KKU (kku_csv) belum diatur atau dinonaktifkan di Panel Admin.</td></tr>';
      }
      const totCell = document.getElementById('kkuTotalScoreCell');
      if(totCell) totCell.textContent = '-';

      const tbHist = document.querySelector('#tab-historis tbody');
      if(tbHist){
        tbHist.innerHTML = '<tr><td colspan="6" style="text-align:center; padding:35px 20px; color:var(--text-muted);"><div style="font-size:28px; margin-bottom:8px;">📅</div>Sumber data KKU (kku_csv) belum diatur atau dinonaktifkan di Panel Admin.</td></tr>';
      }
      return;
    }

    try{
      const res = await fetch(KKU_CSV_URL);
      const text = await res.text();
      const rows = Papa.parse(text, { skipEmptyLines: true }).data;
      if(!rows || rows.length < 2) return;

      const headers = rows[0].map(h => (h||'').toString().trim().toLowerCase());
      let realVal = null, tindakVal = null, kumulVal = null;
      let realFoot = null, tindakFoot = null, kumulFoot = null;

      const colMetrikIdx = headers.findIndex(h => h.includes('metrik') || h.includes('indikator') || h.includes('item') || h.includes('uraian'));
      const colNilaiIdx = headers.findIndex(h => h.includes('nilai') || h.includes('realisasi') || h.includes('capaian') || h.includes('value'));

      if(colMetrikIdx !== -1 && colNilaiIdx !== -1){
        rows.slice(1).forEach(r => {
          const m = (r[colMetrikIdx]||'').toString().trim().toLowerCase();
          const val = (r[colNilaiIdx]||'').toString().trim();
          const note = (r[colNilaiIdx + 1]||'').toString().trim();

          if(m.includes('realisasi')){
            realVal = val;
            if(note) realFoot = note;
          } else if(m.includes('tindak') || m.includes('status') || m.includes('tl')){
            tindakVal = val;
            if(note) tindakFoot = note;
          } else if(m.includes('kumulatif') || m.includes('total') || m.includes('komulatif')){
            kumulVal = val;
            if(note) kumulFoot = note;
          }
        });
      }

      if(realVal !== null && realVal !== ''){
        valReal.textContent = realVal;
        if(footReal) footReal.textContent = realFoot || 'Diperbarui otomatis dari CSV';
        const totCell = document.getElementById('kkuTotalScoreCell');
        if(totCell) totCell.textContent = realVal;
      }
      if(tindakVal !== null && tindakVal !== ''){
        valTindak.textContent = tindakVal;
        if(footTindak) footTindak.textContent = tindakFoot || 'Diperbarui otomatis dari CSV';
      }
      if(kumulVal !== null && kumulVal !== ''){
        valKumul.textContent = kumulVal;
        if(footKumul) footKumul.textContent = kumulFoot || 'Diperbarui otomatis dari CSV';
      }
    }catch(err){
      console.warn('Info: Menunggu sumber data KKU aktif:', err);
    }
  }

  document.addEventListener('DOMContentLoaded', loadKkuDetailData);
</script>
@endsection
