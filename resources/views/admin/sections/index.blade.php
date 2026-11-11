@extends('admin.layout')

@section('page_title', 'Kelola 7 Section Halaman Utama')
@section('page_subtitle', 'Atur urutan, ubah judul & deskripsi, atau aktifkan/nonaktifkan bagian halaman')

@section('content')
<div class="card-box">
  <div class="card-box-header">
    <div>
      <h2>Daftar Section Website</h2>
      <p>Anda dapat mengatur visibilitas dan teks setiap section di halaman utama</p>
    </div>
  </div>

  <div class="table-responsive">
    <table class="data-table">
      <thead>
        <tr>
          <th style="width:60px;">Urutan</th>
          <th>Judul Section</th>
          <th>Slug Anchor</th>
          <th>Deskripsi</th>
          <th>Status</th>
          <th style="text-align:right;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($sections as $sec)
        <tr>
          <td>
            <span style="font-weight:800; font-size:14px; color:var(--pln-blue);">#{{ $sec->order }}</span>
          </td>
          <td>
            <strong style="font-size:14px;">{{ $sec->title }}</strong>
            <div style="font-size:11px; color:var(--text-muted); margin-top:3px;">
              Memuat {{ $sec->stat_cards_count }} kartu stat &bull; {{ $sec->progress_items_count }} item progres
            </div>
          </td>
          <td>
            <code>#{{ $sec->slug }}</code>
          </td>
          <td style="max-width:300px; font-size:12px; color:#475569;">
            {{ $sec->description ?? '-' }}
          </td>
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
                <button type="submit" class="btn btn-sm {{ $sec->is_visible ? 'btn-secondary' : 'btn-primary' }}"
                        title="{{ $sec->is_visible ? 'Sembunyikan dari web' : 'Tampilkan di web' }}">
                  {{ $sec->is_visible ? 'Sembunyikan' : 'Tampilkan' }}
                </button>
              </form>
              <a href="{{ route('admin.sections.edit', $sec) }}" class="btn btn-sm btn-secondary">
                ✏️ Edit
              </a>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
