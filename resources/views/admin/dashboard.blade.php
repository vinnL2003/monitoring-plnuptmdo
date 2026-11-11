@extends('admin.layout')

@section('page_title', 'Ringkasan & Dashboard')
@section('page_subtitle', 'Selamat datang di panel pengelolaan web PLN UPT Manado')

@section('content')
<style>
  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    margin-bottom: 28px;
  }
  .stat-widget {
    background: #fff;
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.02);
    display: flex;
    align-items: center;
    gap: 16px;
  }
  .stat-widget .icon-box {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
  }
  .stat-widget .stat-info h3 { font-size: 24px; font-weight: 800; color: var(--pln-blue-dark); line-height: 1.1; }
  .stat-widget .stat-info p { font-size: 12px; color: var(--text-muted); font-weight: 600; margin-top: 4px; }

  .quick-actions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 16px;
    margin-bottom: 28px;
  }
  .action-card {
    background: #fff;
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 20px;
    text-decoration: none;
    color: inherit;
    transition: all .2s;
    display: flex;
    align-items: flex-start;
    gap: 14px;
  }
  .action-card:hover {
    border-color: var(--pln-blue);
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(0,82,156,0.08);
  }
  .action-card .act-icon {
    font-size: 24px;
    background: #F1F5F9;
    padding: 10px;
    border-radius: 10px;
  }
  .action-card h3 { font-size: 14px; font-weight: 700; color: var(--text-main); margin-bottom: 4px; }
  .action-card p { font-size: 12px; color: var(--text-muted); line-height: 1.4; }
</style>

<!-- KPI WIDGETS -->
<div class="stats-grid">
  <div class="stat-widget">
    <div class="icon-box" style="background:#EBF8FF; color:var(--pln-blue);">📑</div>
    <div class="stat-info">
      <h3>{{ $stats['visible_sections_count'] }} / {{ $stats['sections_count'] }}</h3>
      <p>Section Tampil di Web</p>
    </div>
  </div>
  <div class="stat-widget">
    <div class="icon-box" style="background:#FEF3C7; color:#D97706;">📈</div>
    <div class="stat-info">
      <h3>{{ $stats['stat_cards_count'] }}</h3>
      <p>Kartu Metrik &amp; Aset</p>
    </div>
  </div>
  <div class="stat-widget">
    <div class="icon-box" style="background:#DCFCE7; color:#166534;">🏗️</div>
    <div class="stat-info">
      <h3>{{ $stats['progress_items_count'] }}</h3>
      <p>Item Progres Fisik</p>
    </div>
  </div>
  <div class="stat-widget">
    <div class="icon-box" style="background:#EDE9FE; color:#6D28D9;">🌐</div>
    <div class="stat-info">
      <h3>{{ $stats['data_sources_count'] }}</h3>
      <p>Sheet Google Terhubung</p>
    </div>
  </div>
</div>

<!-- QUICK ACTION LINKS -->
<div class="card-box-header" style="margin-top:10px; margin-bottom:16px;">
  <h2>Aksi Cepat Pengelolaan</h2>
  <p>Pilih modul yang ingin Anda perbarui di website PLN</p>
</div>
<div class="quick-actions">
  <a href="{{ route('admin.settings.index') }}" class="action-card">
    <div class="act-icon">⚙️</div>
    <div>
      <h3>Ubah Judul &amp; Logo</h3>
      <p>Ganti nama website, teks hero, logo PLN / UPT, dan copyright footer.</p>
    </div>
  </a>

  <a href="{{ route('admin.sections.index') }}" class="action-card">
    <div class="act-icon">📑</div>
    <div>
      <h3>Atur 7 Section Halaman</h3>
      <p>Sembunyikan/tampilkan bagian tertentu atau edit judul &amp; deskripsi.</p>
    </div>
  </a>

  <a href="{{ route('admin.progress.index') }}" class="action-card">
    <div class="act-icon">🏗️</div>
    <div>
      <h3>Update Progres Konstruksi</h3>
      <p>Sesuaikan persentase Progres SUTT/GI, COD, dan Serah Terima STO.</p>
    </div>
  </a>

  <a href="{{ route('admin.page-data.index') }}" class="action-card" style="border-left: 3px solid #16A34A;">
    <div class="act-icon" style="background: #DCFCE7; color: #166534;">📊</div>
    <div>
      <h3>Settingan Data Halaman (2-Arah)</h3>
      <p>Modifikasi isi CSV / Spreadsheet untuk seluruh halaman web secara langsung.</p>
    </div>
  </a>

  <a href="{{ route('admin.data-sources.index') }}" class="action-card">
    <div class="act-icon">🌐</div>
    <div>
      <h3>Master Sumber Data</h3>
      <p>Kelola link endpoint CSV Google Sheet dan upload file CSV master.</p>
    </div>
  </a>
</div>

<!-- SECTIONS OVERVIEW TABLE -->
<div class="card-box">
  <div class="card-box-header">
    <div>
      <h2>Status 7 Section Halaman Utama</h2>
      <p>Klik tombol untuk mengaktifkan/menonaktifkan atau mengubah judul section</p>
    </div>
    <a href="{{ route('admin.sections.index') }}" class="btn btn-secondary btn-sm">Kelola Semua →</a>
  </div>

  <div class="table-responsive">
    <table class="data-table">
      <thead>
        <tr>
          <th style="width:50px;">Urutan</th>
          <th>Nama Section</th>
          <th>Slug Anchor</th>
          <th>Status Tampil</th>
          <th style="text-align:right;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($recentSections as $sec)
        <tr>
          <td><b style="color:var(--pln-blue);">#{{ $sec->order }}</b></td>
          <td>
            <strong>{{ $sec->title }}</strong>
            <div style="font-size:11.5px; color:var(--text-muted);">{{ Str::limit($sec->description, 60) }}</div>
          </td>
          <td><code>#{{ $sec->slug }}</code></td>
          <td>
            @if($sec->is_visible)
              <span class="badge badge-success">● Aktif Tampil</span>
            @else
              <span class="badge badge-danger">○ Disembunyikan</span>
            @endif
          </td>
          <td style="text-align:right;">
            <div style="display:inline-flex; gap:6px;">
              <form action="{{ route('admin.sections.toggle', $sec) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm {{ $sec->is_visible ? 'btn-secondary' : 'btn-primary' }}">
                  {{ $sec->is_visible ? 'Sembunyikan' : 'Tampilkan' }}
                </button>
              </form>
              <a href="{{ route('admin.sections.edit', $sec) }}" class="btn btn-secondary btn-sm">Edit</a>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<!-- DATA SOURCES OVERVIEW -->
<div class="card-box">
  <div class="card-box-header">
    <div>
      <h2>Sumber Data Terintegrasi</h2>
      <p>Semua sumber data (Google Sheets & File CSV lokal) yang menyuplai data ke dashboard</p>
    </div>
    <a href="{{ route('admin.data-sources.index') }}" class="btn btn-secondary btn-sm">Kelola Sumber Data →</a>
  </div>

  <div class="table-responsive">
    <table class="data-table">
      <thead>
        <tr>
          <th>Nama Sumber Data</th>
          <th>Status</th>
          <th>Metode / Target</th>
          <th style="text-align:right;">Test Koneksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($dataSources as $ds)
        <tr>
          <td>
            <strong>{{ $ds->name }}</strong>
            <div style="font-size:11px; color:var(--text-muted);">{{ $ds->description }}</div>
          </td>
          <td>
            @if($ds->is_active)
              <span class="badge badge-success">Aktif</span>
            @else
              <span class="badge badge-danger">Nonaktif</span>
            @endif
          </td>
          <td>
            @if($ds->source_type === 'file' && $ds->file_path)
              <a href="{{ asset('uploads/data_sources/' . $ds->file_path) }}" target="_blank" style="font-size:12px; color:#166534; text-decoration:none;" title="{{ $ds->file_path }}">
                📁 {{ Str::limit($ds->file_path, 35) }} ↗
              </a>
            @elseif($ds->source_type === 'url' && $ds->url)
              <a href="{{ $ds->url }}" target="_blank" style="font-size:12px; color:var(--pln-blue); text-decoration:none;" title="{{ $ds->url }}">
                🌐 {{ Str::limit($ds->url, 45) }} ↗
              </a>
            @else
              <span style="font-size:11.5px; color:var(--text-muted); font-style:italic;">- Dikosongkan (Manual) -</span>
            @endif
          </td>
          <td style="text-align:right;">
            <form action="{{ route('admin.data-sources.test', $ds) }}" method="POST" style="display:inline;">
              @csrf
              <button type="submit" class="btn btn-sm btn-secondary">⚡ Uji Live Data</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
