@extends('admin.layout')

@section('title', 'Settingan Keseluruhan Halaman & Sinkronisasi Data 2-Arah')

@section('styles')
<style>
  .sync-hero-card {
    background: linear-gradient(135deg, #0A3A60 0%, #00529C 60%, #0284C7 100%);
    border-radius: 14px;
    padding: 24px 28px;
    color: #fff;
    margin-bottom: 24px;
    box-shadow: 0 10px 25px -5px rgba(0, 82, 156, 0.25);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
    position: relative;
    overflow: hidden;
  }
  .sync-hero-card::after {
    content: '';
    position: absolute;
    right: -30px;
    top: -30px;
    width: 220px;
    height: 220px;
    background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, rgba(255,255,255,0) 70%);
    border-radius: 50%;
    pointer-events: none;
  }
  .sync-hero-content h2 {
    font-size: 22px;
    font-weight: 800;
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .sync-hero-content p {
    font-size: 13.5px;
    color: rgba(255, 255, 255, 0.88);
    max-width: 650px;
    line-height: 1.5;
    margin: 0;
  }
  .sync-stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 26px;
  }
  @media (max-width: 992px) {
    .sync-stats-row { grid-template-columns: repeat(2, 1fr); }
  }
  @media (max-width: 576px) {
    .sync-stats-row { grid-template-columns: 1fr; }
  }

  .sync-stat-box {
    background: #fff;
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.02);
  }
  .sync-stat-icon {
    width: 46px;
    height: 46px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
  }
  .sync-stat-info .num {
    font-size: 22px;
    font-weight: 800;
    color: var(--pln-blue-dark);
    line-height: 1.1;
  }
  .sync-stat-info .label {
    font-size: 11.5px;
    font-weight: 600;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 3px;
  }

  .flow-explainer {
    background: #F0FDF4;
    border: 1px solid #BBF7D0;
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 24px;
    display: flex;
    align-items: flex-start;
    gap: 16px;
  }
  .flow-explainer-icon {
    font-size: 26px;
    line-height: 1;
  }
  .flow-explainer h4 {
    font-size: 14px;
    font-weight: 800;
    color: #166534;
    margin-bottom: 6px;
  }
  .flow-explainer ul {
    margin: 0;
    padding-left: 18px;
    font-size: 12.5px;
    color: #15803D;
    line-height: 1.6;
  }
  .flow-explainer ul strong {
    color: #14532D;
  }

  /* PAGE CARDS */
  .pages-grid {
    display: flex;
    flex-direction: column;
    gap: 20px;
  }
  .page-card {
    background: #fff;
    border: 1px solid var(--border-color);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    transition: transform .2s ease, box-shadow .2s ease;
  }
  .page-card:hover {
    box-shadow: 0 6px 18px rgba(0,0,0,0.06);
  }
  .page-card-header {
    padding: 16px 22px;
    background: #FAFBFD;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
  }
  .page-card-identity {
    display: flex;
    align-items: center;
    gap: 14px;
  }
  .page-card-icon {
    font-size: 28px;
    width: 44px;
    height: 44px;
    background: #fff;
    border: 1px solid var(--border-color);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 5px rgba(0,0,0,0.03);
  }
  .page-card-title h3 {
    font-size: 16px;
    font-weight: 800;
    color: var(--pln-blue-dark);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .page-card-title p {
    font-size: 12.5px;
    color: var(--text-muted);
    margin: 3px 0 0;
  }
  .page-card-badge {
    font-size: 11px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 20px;
    background: #E0F2FE;
    color: #0369A1;
  }
  .page-card-link {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    font-weight: 700;
    color: var(--pln-blue);
    text-decoration: none;
    padding: 5px 12px;
    background: #fff;
    border: 1px solid #BAE6FD;
    border-radius: 6px;
    transition: all .2s ease;
  }
  .page-card-link:hover {
    background: #0284C7;
    color: #fff;
  }

  .page-card-body {
    padding: 20px 22px;
  }
  .source-item {
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    padding: 16px 18px;
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 14px;
    transition: border-color .2s ease;
  }
  .source-item:last-child {
    margin-bottom: 0;
  }
  .source-item:hover {
    border-color: #CBD5E1;
  }
  .source-main {
    flex: 1;
    min-width: 260px;
  }
  .source-title-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 4px;
  }
  .source-title {
    font-size: 14px;
    font-weight: 800;
    color: #1E293B;
  }
  .source-key-badge {
    font-family: monospace;
    font-size: 11px;
    background: #E2E8F0;
    color: #475569;
    padding: 2px 7px;
    border-radius: 4px;
    font-weight: 600;
  }
  .source-meta-row {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 14px;
    font-size: 11.5px;
    color: #64748B;
    margin-top: 5px;
  }
  .source-meta-item {
    display: flex;
    align-items: center;
    gap: 4px;
  }

  .status-tag {
    font-size: 11px;
    font-weight: 700;
    padding: 3px 9px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
  }
  .status-tag.file-active {
    background: #DCFCE7;
    color: #15803D;
    border: 1px solid #86EFAC;
  }
  .status-tag.url-active {
    background: #EFF6FF;
    color: #1D4ED8;
    border: 1px solid #BFDBFE;
  }
  .status-tag.none-active {
    background: #F1F5F9;
    color: #64748B;
    border: 1px solid #E2E8F0;
  }

  .source-actions {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
  }
  .btn-action-edit {
    background: #00529C;
    color: #fff;
    padding: 8px 14px;
    border-radius: 7px;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 2px 6px rgba(0,82,156,0.25);
    transition: all .2s ease;
  }
  .btn-action-edit:hover {
    background: #003E75;
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(0,82,156,0.3);
  }
  .btn-action-pull {
    background: #F0FDF4;
    border: 1px solid #86EFAC;
    color: #15803D;
    padding: 8px 12px;
    border-radius: 7px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: all .2s ease;
  }
  .btn-action-pull:hover {
    background: #DCFCE7;
    color: #14532D;
  }
  .btn-action-download {
    background: #fff;
    border: 1px solid #CBD5E1;
    color: #475569;
    padding: 8px 12px;
    border-radius: 7px;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: all .2s ease;
  }
  .btn-action-download:hover {
    background: #F8FAFC;
    color: #0F172A;
    border-color: #94A3B8;
  }
  .btn-action-gear {
    background: #fff;
    border: 1px solid #E2E8F0;
    color: #64748B;
    padding: 8px 10px;
    border-radius: 7px;
    font-size: 12px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }
  .btn-action-gear:hover {
    background: #F1F5F9;
    color: #1E293B;
  }

  .empty-source-notice {
    text-align: center;
    padding: 24px;
    color: #94A3B8;
    font-size: 13px;
  }
</style>
@endsection

@section('content')
<div class="content-wrapper">

  <!-- HERO CARD -->
  <div class="sync-hero-card">
    <div class="sync-hero-content">
      <h2><span>📊</span> Settingan Keseluruhan Halaman &amp; Sinkronisasi Data</h2>
      <p>
        Kelola dan modifikasi data spreadsheet/CSV yang terhubung ke setiap halaman website UPT Manado secara langsung. 
        Mendukung sinkronisasi 2-arah: perbarui spreadsheet dari web (Web ➔ CSV) atau tarik data terbaru dari Google Sheets (Sheet ➔ Web).
      </p>
    </div>
    <div>
      <a href="{{ route('admin.data-sources.index') }}" class="btn" style="background: rgba(255,255,255,0.18); border: 1px solid rgba(255,255,255,0.35); color: #fff; font-weight: 700; font-size: 12.5px;">
        ⚙️ Master Sumber Data
      </a>
    </div>
  </div>

  <!-- STATS ROW -->
  <div class="sync-stats-row">
    <div class="sync-stat-box">
      <div class="sync-stat-icon" style="background: #E0F2FE; color: #0284C7;">📄</div>
      <div class="sync-stat-info">
        <div class="num">{{ count($pages) }}</div>
        <div class="label">Total Halaman Terkelola</div>
      </div>
    </div>
    <div class="sync-stat-box">
      <div class="sync-stat-icon" style="background: #FEF3C7; color: #D97706;">🌐</div>
      <div class="sync-stat-info">
        <div class="num">{{ $totalSources }}</div>
        <div class="label">Sumber Data Terdaftar</div>
      </div>
    </div>
    <div class="sync-stat-box">
      <div class="sync-stat-icon" style="background: #DCFCE7; color: #16A34A;">✏️</div>
      <div class="sync-stat-info">
        <div class="num">{{ $fileModifiedSources }}</div>
        <div class="label">Mode Web Modified (Lokal CSV)</div>
      </div>
    </div>
    <div class="sync-stat-box">
      <div class="sync-stat-icon" style="background: #F3E8FF; color: #9333EA;">🔄</div>
      <div class="sync-stat-info">
        <div class="num">{{ $urlSources }}</div>
        <div class="label">Mode Live Google Sheet</div>
      </div>
    </div>
  </div>

  <!-- EXPLAINER CALLOUT -->
  <div class="flow-explainer">
    <div class="flow-explainer-icon">💡</div>
    <div>
      <h4>Mekanisme Sinkronisasi 2-Arah (Web ⇄ CSV / Spreadsheet):</h4>
      <ul>
        <li><strong>Arah 1 (Web ➔ CSV):</strong> Buka <em>Editor Spreadsheet</em> pada data source manapun, ubah angka atau tambah baris di web, lalu klik <strong>Simpan Perubahan ke CSV</strong>. Data langsung tersimpan di server dan seluruh halaman website seketika ter-update!</li>
        <li><strong>Arah 2 (Google Sheet ➔ Web):</strong> Jika tim Anda melakukan update data di Google Spreadsheet eksternal, cukup klik <strong>Tarik dari Sheet</strong> untuk menyalin data terbaru ke server website.</li>
        <li><strong>Ekspor Balik ke Google Sheet:</strong> Anda dapat mengklik <strong>Download CSV</strong> kapan saja untuk mendapatkan file hasil modifikasi web dan mengimpornya kembali ke Google Spreadsheet Anda.</li>
      </ul>
    </div>
  </div>

  <!-- LIST OF PAGES -->
  <div class="pages-grid">
    @foreach($pages as $page)
      <div class="page-card">
        <div class="page-card-header">
          <div class="page-card-identity">
            <div class="page-card-icon">{{ $page['icon'] }}</div>
            <div class="page-card-title">
              <h3>
                {{ $page['title'] }}
                <span class="page-card-badge">{{ $page['badge'] }}</span>
              </h3>
              <p>{{ $page['description'] }}</p>
            </div>
          </div>
          <div>
            <a href="{{ $page['url'] }}" target="_blank" class="page-card-link" title="Buka halaman publik di tab baru">
              Buka Halaman Live ↗
            </a>
          </div>
        </div>

        <div class="page-card-body">
          @if(empty($page['sources']))
            @if($page['slug'] === 'konstruksi-penyaluran')
              <div class="source-item" style="background: #F8FAFC;">
                <div class="source-main">
                  <div class="source-title-row">
                    <span class="source-title">Kelola Progres Konstruksi &amp; COD Transmisi</span>
                    <span class="status-tag file-active">Database Proyek Aktif</span>
                  </div>
                  <div class="source-meta-row">
                    <span>Halaman Konstruksi &amp; Penyaluran mengelola daftar proyek transmisi baru, target COD, dan status STO melalui modul Progres Proyek.</span>
                  </div>
                </div>
                <div class="source-actions">
                  <a href="{{ route('admin.progress.index') }}" class="btn-action-edit">
                    🏗️ Kelola Progres Proyek
                  </a>
                </div>
              </div>
            @else
              <div class="empty-source-notice">
                Belum ada sumber data CSV yang dihubungkan ke halaman ini.
              </div>
            @endif
          @else
            @foreach($page['sources'] as $src)
              @php
                $ds = $src['model'];
                $fileInfo = $src['file_info'];
              @endphp
              <div class="source-item">
                <div class="source-main">
                  <div class="source-title-row">
                    <span class="source-title">{{ $ds->name }}</span>
                    <span class="source-key-badge">{{ $ds->key }}</span>

                    @if($ds->source_type === 'file')
                      <span class="status-tag file-active" title="Website membaca file CSV lokal di server hasil sinkronisasi/modifikasi admin">
                        🟢 File Lokal Aktif (Web Modifiable)
                      </span>
                    @elseif($ds->source_type === 'url')
                      <span class="status-tag url-active" title="Website membaca langsung link live Google Spreadsheet">
                        🔵 Google Sheet Live URL
                      </span>
                    @else
                      <span class="status-tag none-active">
                        ⚪ Manual / Belum Terhubung
                      </span>
                    @endif
                  </div>

                  <div class="source-meta-row">
                    <div class="source-meta-item">
                      <span>📁 <strong>File:</strong> {{ $ds->file_path ?: 'Belum ada file fisik' }}</span>
                    </div>
                    @if($fileInfo['has_file'])
                      <div class="source-meta-item">
                        <span>📦 <strong>Ukuran:</strong> {{ $fileInfo['file_size'] }}</span>
                      </div>
                    @endif
                    <div class="source-meta-item">
                      <span>🕒 <strong>Diperbarui:</strong> {{ $fileInfo['updated_at'] }}</span>
                    </div>
                    @if(!empty($ds->url))
                      <div class="source-meta-item">
                        <span>🔗 <strong>Google Sheet Terhubung</strong></span>
                      </div>
                    @endif
                  </div>
                </div>

                <div class="source-actions">
                  <!-- TOMBOL BUKA EDITOR SPREADSHEET (WEB -> CSV DI HALAMAN BARU) -->
                  <a href="{{ route('admin.page-data.edit', $ds->key) }}" target="_blank" rel="noopener noreferrer" class="btn-action-edit" title="Buka editor visual spreadsheet di halaman baru (tampilan leluasa & kolom resizable)">
                    ✏️ Edit Spreadsheet ↗
                  </a>

                  <!-- TOMBOL TARIK DARI GOOGLE SHEET (SHEET -> WEB) -->
                  @if(!empty($ds->url))
                    <form action="{{ route('admin.page-data.pull', $ds->key) }}" method="POST" onsubmit="return confirm('Tarik data terbaru dari Google Spreadsheet? Perubahan lokal yang belum di-backup akan diperbarui.');" style="display: inline;">
                      @csrf
                      <button type="submit" class="btn-action-pull" title="Tarik data terbaru dari Google Spreadsheet">
                        🔄 Tarik dari Sheet
                      </button>
                    </form>
                  @endif

                  <!-- TOMBOL DOWNLOAD CSV (WEB -> GOOGLE SHEET/EXCEL) -->
                  <a href="{{ route('admin.page-data.download', $ds->key) }}" class="btn-action-download" title="Unduh CSV terkini untuk diimpor ke Google Spreadsheet / Excel">
                    ⬇️ Unduh CSV
                  </a>

                  <!-- TOMBOL GEAR SETTINGS -->
                  <a href="{{ route('admin.data-sources.edit', $ds->id) }}" class="btn-action-gear" title="Pengaturan URL Google Sheet &amp; Opsi Master">
                    ⚙️
                  </a>
                </div>
              </div>
            @endforeach
          @endif
        </div>
      </div>
    @endforeach
  </div>

</div>
@endsection
