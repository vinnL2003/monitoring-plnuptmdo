@extends('admin.layout')

@section('title', 'Akses Terbatas Halaman')
@section('page_title', 'Akses Terbatas Halaman')
@section('page_subtitle', 'Atur mode proteksi halaman dan kelola akun personil berwenang untuk tiap halaman khusus')

@section('styles')
<style>
  .mode-switch-btn {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 11.5px;
    font-weight: 700;
    cursor: pointer;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all .2s;
  }
  .mode-active {
    background: #FEF2F2;
    color: #DC2626;
    border: 1px solid #FECACA;
  }
  .mode-active:hover {
    background: #DC2626;
    color: #fff;
  }
  .mode-inactive {
    background: #ECFDF5;
    color: #059669;
    border: 1px solid #A7F3D0;
  }
  .mode-inactive:hover {
    background: #059669;
    color: #fff;
  }
  .page-badge-item {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 600;
    background: #EFF6FF;
    color: #1D4ED8;
    margin: 2px;
    border: 1px solid #DBEAFE;
  }
  .page-badge-all {
    background: #ECFDF5;
    color: #047857;
    border: 1px solid #A7F3D0;
    font-weight: 700;
  }
  .tab-header {
    display: flex;
    gap: 12px;
    margin-bottom: 24px;
    border-bottom: 2px solid var(--border-color);
    padding-bottom: 2px;
  }
  .tab-link {
    padding: 10px 18px;
    font-size: 13.5px;
    font-weight: 700;
    color: var(--text-muted);
    text-decoration: none;
    border-bottom: 3px solid transparent;
    cursor: pointer;
    transition: all .2s;
  }
  .tab-link:hover {
    color: var(--pln-blue);
  }
  .tab-link.active {
    color: var(--pln-blue);
    border-bottom-color: var(--pln-blue);
  }
</style>
@endsection

@section('content')
<!-- SECTION A: PENGATURAN MODE AKSES PER HALAMAN -->
<div class="card-box" id="section-pages">
  <div class="card-box-header">
    <div>
      <h2>1. Mode Proteksi Halaman (On / Off)</h2>
      <p>Tentukan halaman mana saja di luar Dashboard yang membutuhkan login khusus personil</p>
    </div>
  </div>

  <div class="table-responsive">
    <table class="data-table">
      <thead>
        <tr>
          <th style="width: 50px;">No</th>
          <th>Nama Halaman</th>
          <th>URL Halaman</th>
          <th>Deskripsi &amp; Fungsi</th>
          <th style="width: 140px; text-align: center;">Mode Akses</th>
          <th style="width: 160px; text-align: right;">Aksi Toggle</th>
        </tr>
      </thead>
      <tbody>
        @foreach($settings as $idx => $s)
          <tr>
            <td>{{ $idx + 1 }}</td>
            <td>
              <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 20px;">{{ $s->icon ?? '📄' }}</span>
                <div>
                  <strong style="font-size: 13.5px; color: var(--pln-blue-dark);">{{ $s->page_name }}</strong>
                  <div style="font-size: 11px; color: var(--text-muted);">Slug: <code>{{ $s->page_slug }}</code></div>
                </div>
              </div>
            </td>
            <td>
              <a href="{{ url($s->page_url) }}" target="_blank" style="color: var(--pln-blue); text-decoration: none; font-size: 12px; font-weight: 600;" title="Buka Halaman Live">
                {{ $s->page_url }} ↗
              </a>
            </td>
            <td style="font-size: 12px; color: var(--text-muted); max-width: 280px;">
              {{ $s->description ?? '-' }}
            </td>
            <td style="text-align: center;">
              @if($s->is_restricted)
                <span class="badge badge-danger" title="Hanya personil terdaftar atau admin web yang dapat mengakses">
                  🔒 Akses Terbatas (Wajib Login)
                </span>
              @else
                <span class="badge badge-success" title="Dapat diakses oleh siapa saja tanpa perlu login">
                  🌐 Publik (Bebas Akses)
                </span>
              @endif
            </td>
            <td style="text-align: right;">
              <form action="{{ route('admin.page-access.settings.toggle', $s->page_slug) }}" method="POST">
                @csrf
                @if($s->is_restricted)
                  <button type="submit" class="mode-switch-btn mode-inactive" title="Nonaktifkan proteksi agar halaman bisa diakses publik tanpa login">
                    🔓 Ubah Jadi Publik
                  </button>
                @else
                  <button type="submit" class="mode-switch-btn mode-active" title="Aktifkan proteksi agar halaman mewajibkan login personil">
                    🔒 Aktifkan Proteksi
                  </button>
                @endif
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<!-- SECTION B: AKUN PERSONIL AKSES TERBATAS -->
<div class="card-box" id="section-accounts">
  <div class="card-box-header">
    <div>
      <h2>2. Akun Personil Berwenang</h2>
      <p>Akun login terenkripsi untuk personil atau unit yang berhak mengakses halaman dengan mode proteksi aktif</p>
    </div>
    <a href="{{ route('admin.page-access.accounts.create') }}" class="btn btn-primary">
      ➕ Tambah Akun Personil
    </a>
  </div>

  <div class="table-responsive">
    <table class="data-table">
      <thead>
        <tr>
          <th style="width: 50px;">No</th>
          <th>Nama Personil / Unit</th>
          <th>Username / NIP</th>
          <th>Hak Akses Halaman</th>
          <th>Status</th>
          <th>Catatan</th>
          <th style="width: 170px; text-align: right;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($accounts as $idx => $acc)
          <tr>
            <td>{{ $idx + 1 }}</td>
            <td>
              <strong style="color: var(--pln-blue); font-size: 13.5px;">{{ $acc->name }}</strong>
            </td>
            <td>
              <code style="background: #F1F5F9; padding: 4px 9px; border-radius: 4px; font-size: 13px; font-weight: 700; color: #0F172A;">
                {{ $acc->username }}
              </code>
            </td>
            <td>
              @php
                $pages = $acc->allowed_pages ?? [];
                $isAll = in_array('*', $pages, true);
              @endphp

              @if($isAll)
                <span class="page-badge-item page-badge-all">
                  🌟 Semua Halaman Terbatas (*)
                </span>
              @else
                @foreach($pages as $slug)
                  @php
                    $matchSetting = $settings->firstWhere('page_slug', $slug);
                    $label = $matchSetting ? $matchSetting->page_name : $slug;
                  @endphp
                  <span class="page-badge-item">
                    {{ $label }}
                  </span>
                @endforeach
              @endif
            </td>
            <td>
              @if($acc->is_active)
                <span class="badge badge-success">● Aktif</span>
              @else
                <span class="badge badge-danger">○ Nonaktif</span>
              @endif
            </td>
            <td style="font-size: 12px; color: var(--text-muted); max-width: 200px;">
              {{ $acc->notes ?? '-' }}
            </td>
            <td style="text-align: right;">
              <div style="display: flex; gap: 6px; justify-content: flex-end; align-items: center;">
                <form action="{{ route('admin.page-access.accounts.toggle', $acc) }}" method="POST">
                  @csrf
                  @if($acc->is_active)
                    <button type="submit" class="btn btn-secondary btn-sm" title="Nonaktifkan akun">
                      ⏸️
                    </button>
                  @else
                    <button type="submit" class="btn btn-warning btn-sm" title="Aktifkan akun">
                      ▶️
                    </button>
                  @endif
                </form>

                <a href="{{ route('admin.page-access.accounts.edit', $acc) }}" class="btn btn-secondary btn-sm" title="Edit Akun Personil">
                  ✏️ Edit
                </a>

                <form action="{{ route('admin.page-access.accounts.destroy', $acc) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $acc->name }}? Tindakan ini tidak dapat dibatalkan.');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm" title="Hapus Akun">
                    🗑️
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" style="text-align: center; padding: 30px; color: var(--text-muted);">
              Belum ada akun personil yang didaftarkan.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- INFORMASI TEKNIS & KEAMANAN -->
<div class="card-box" style="background: #F8FAFC; border-left: 4px solid var(--pln-yellow-dark);">
  <h3 style="font-size: 14px; font-weight: 700; color: var(--pln-blue-dark); margin-bottom: 8px;">
    💡 Petunjuk &amp; Cara Kerja Akses Terbatas Halaman
  </h3>
  <div style="font-size: 12.5px; color: var(--text-muted); line-height: 1.6;">
    <ul style="padding-left: 18px;">
      <li><strong>Mode Akses Terbatas Aktif:</strong> Saat diaktifkan, halaman akan menampilkan layar login (overlay) dengan logo PLN yang adaptif (Light/Dark mode) dan mengunci konten halaman hingga personil memasukkan username &amp; password yang sah.</li>
      <li><strong>Mode Publik (Nonaktif):</strong> Jika dinonaktifkan, halaman dapat langsung dibuka oleh siapa saja tanpa perlu memasukkan password login.</li>
      <li><strong>Bypass Otomatis Admin Web:</strong> Jika Anda sedang login sebagai Admin Web di browser ini, semua halaman terbatas akan terbuka otomatis tanpa perlu memasukkan kredensial personil lagi.</li>
      <li><strong>Keamanan Bcrypt:</strong> Seluruh password akun personil tersimpan dalam bentuk enkripsi hash satu arah Bcrypt di basis data, sehingga aman dan tidak terbaca dalam bentuk teks mentah.</li>
    </ul>
  </div>
</div>
@endsection
