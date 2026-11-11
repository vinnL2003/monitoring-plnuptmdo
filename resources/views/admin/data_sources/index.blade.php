@extends('admin.layout')

@section('page_title', 'Kelola Sumber Data')
@section('page_subtitle', 'Integrasikan Google Sheets atau upload file CSV lokal untuk menyuplai data ke dashboard, atau kosongkan metode untuk pengisian manual')

@section('content')
<!-- PROMO BANNER KE SETTINGAN DATA HALAMAN -->
<div style="background: linear-gradient(135deg, #0A3A60 0%, #00529C 100%); color: #fff; padding: 14px 20px; border-radius: 10px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; box-shadow: 0 4px 12px rgba(0,82,156,0.18);">
  <div>
    <h3 style="font-size: 14.5px; font-weight: 800; margin: 0 0 3px; display: flex; align-items: center; gap: 8px;">
      <span>📊</span> Settingan Keseluruhan Halaman &amp; Sinkronisasi Data (2-Arah)
    </h3>
    <p style="font-size: 12.5px; margin: 0; color: rgba(255,255,255,0.88);">
      Kelola dan ubah data spreadsheet tiap halaman secara langsung dari admin panel dengan update dua arah.
    </p>
  </div>
  <a href="{{ route('admin.page-data.index') }}" class="btn" style="background: var(--pln-yellow); color: var(--pln-blue-dark); font-weight: 800; font-size: 12px; border: none;">
    Buka Settingan Data Halaman →
  </a>
</div>

<div class="card-box">
  <div class="card-box-header" style="flex-wrap:wrap; gap:12px;">
    <div>
      <h2>Daftar Sumber Data Master</h2>
      <p>Data dapat diambil secara live dari Google Spreadsheet, diunggah sebagai file CSV lokal, atau diedit langsung via Editor Spreadsheet Web</p>
    </div>
    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
      <a href="{{ route('admin.page-data.index') }}" class="btn btn-secondary" style="font-weight: 700;">
        📊 Buka Editor per Halaman
      </a>
      <a href="{{ route('admin.data-sources.create') }}" class="btn btn-primary">
        ➕ Tambah Sumber Data Baru
      </a>
    </div>
  </div>

  <div class="table-responsive">
    <table class="data-table">
      <thead>
        <tr>
          <th>Nama Sumber Data</th>
          <th>Kode Key (Identifier)</th>
          <th>Metode / Tipe</th>
          <th>Target URL / File</th>
          <th>Status</th>
          <th style="text-align:right;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($dataSources as $ds)
        <tr>
          <td>
            <strong>{{ $ds->name }}</strong>
            @if($ds->description)
              <div style="font-size:11.5px; color:var(--text-muted); margin-top:2px;">{{ $ds->description }}</div>
            @endif
          </td>
          <td>
            <code style="background:#F1F5F9; padding:3px 8px; border-radius:4px; font-size:12px; font-weight:700; color:var(--pln-blue-dark);">
              {{ $ds->key }}
            </code>
          </td>
          <td>
            @if($ds->source_type === 'file')
              <span class="badge" style="background:#DCFCE7; color:#15803D; font-weight:700; padding:4px 9px; border-radius:6px; font-size:11.5px;">
                📁 File Lokal
              </span>
            @elseif($ds->source_type === 'url')
              <span class="badge" style="background:#EBF8FF; color:var(--pln-blue); font-weight:700; padding:4px 9px; border-radius:6px; font-size:11.5px;">
                🌐 Google Sheets
              </span>
            @else
              <span class="badge" style="background:#F1F5F9; color:#64748B; font-weight:700; padding:4px 9px; border-radius:6px; font-size:11.5px;">
                🚫 Dikosongkan (Manual)
              </span>
            @endif
          </td>
          <td>
            @if($ds->source_type === 'file' && $ds->file_path)
              <a href="{{ asset('uploads/data_sources/' . $ds->file_path) }}" target="_blank" style="font-size:12px; color:#166534; font-weight:600; text-decoration:none;" title="{{ $ds->file_path }}">
                📄 {{ Str::limit($ds->file_path, 30) }} ↗
              </a>
            @elseif($ds->source_type === 'url' && $ds->url)
              <a href="{{ $ds->url }}" target="_blank" style="font-size:12px; color:var(--pln-blue); text-decoration:none;" title="{{ $ds->url }}">
                {{ Str::limit($ds->url, 35) }} ↗
              </a>
            @else
              <span style="font-size:11.5px; color:var(--text-muted); font-style:italic;">- Dikosongkan -</span>
            @endif
          </td>
          <td>
            @if($ds->is_active)
              <span class="badge badge-success">● Aktif</span>
            @else
              <span class="badge badge-danger">○ Nonaktif</span>
            @endif
          </td>
          <td style="text-align:right;">
            <div style="display:inline-flex; gap:6px; align-items:center;">
              @if($ds->source_type !== 'none' && !empty($ds->source_type))
              <form action="{{ route('admin.data-sources.test', $ds) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm btn-secondary" title="Uji apakah URL/file dapat diakses">
                  ⚡ Test
                </button>
              </form>
              @endif

              <a href="{{ route('admin.page-data.edit', $ds->key) }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm" style="background:#15803D; color:#fff; font-weight:700;" title="Buka editor visual spreadsheet di halaman baru (tampilan leluasa & resizable)">
                📊 Spreadsheet ↗
              </a>

              <a href="{{ route('admin.data-sources.edit', $ds) }}" class="btn btn-sm btn-primary" title="Pengaturan URL atau file master">
                ✏️ Edit
              </a>

              <form action="{{ route('admin.data-sources.destroy', $ds) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sumber data \'{{ $ds->name }}\'?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" title="Hapus sumber data">
                  🗑️
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" style="text-align:center; padding:30px; color:var(--text-muted);">
            Belum ada sumber data yang terdaftar. Klik <b>Tambah Sumber Data Baru</b> di atas untuk menambahkan.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
  <div class="card-box" style="background:#F8FAFC; border:1px dashed #CBD5E1; margin-bottom:0;">
    <h3 style="font-size:13px; font-weight:700; color:var(--pln-blue-dark); margin-bottom:6px;">
      🌐 Cara 1: Menggunakan Link Google Sheets (Live):
    </h3>
    <ol style="font-size:12px; color:#475569; padding-left:18px; line-height:1.6;">
      <li>Buka spreadsheet Google Anda.</li>
      <li>Klik menu <b>File</b> → <b>Share (Bagikan)</b> → <b>Publish to web</b>.</li>
      <li>Pilih tab sheet yang dituju, ganti format menjadi <b>Comma-separated values (.csv)</b>.</li>
      <li>Klik <b>Publish</b> dan tempelkan link yang dihasilkan pada form sumber data.</li>
    </ol>
  </div>

  <div class="card-box" style="background:#F0FDF4; border:1px dashed #86EFAC; margin-bottom:0;">
    <h3 style="font-size:13px; font-weight:700; color:#166534; margin-bottom:6px;">
      📁 Cara 2: Upload File CSV Lokal (Offline/Baku):
    </h3>
    <ol style="font-size:12px; color:#14532D; padding-left:18px; line-height:1.6;">
      <li>Siapkan data di Excel/Google Sheets Anda.</li>
      <li>Pilih <b>File</b> → <b>Download / Simpan Sebagai</b> → pilih format <b>CSV (.csv)</b>.</li>
      <li>Klik <b>Tambah Sumber Data Baru</b> di atas, pilih opsi <b>📁 Upload File CSV Lokal</b>.</li>
      <li>Website akan membaca data dari file yang Anda unggah tanpa bergantung pada koneksi Google.</li>
    </ol>
  </div>
</div>
@endsection
