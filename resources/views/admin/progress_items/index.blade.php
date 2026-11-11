@extends('admin.layout')

@section('page_title', 'Kelola Progres Konstruksi & Penyaluran')
@section('page_subtitle', 'Update persentase progres fisik (SUTT/GI, COD, STO, dll.)')

@section('content')
<div class="card-box">
  <div class="card-box-header">
    <div>
      <h2>Daftar Item Progres Fisik &amp; Konstruksi</h2>
      <p>Persentase dan status penyelesaian proyek transmisi</p>
    </div>
    <a href="{{ route('admin.progress.create') }}" class="btn btn-primary btn-sm">+ Tambah Item Progres Baru</a>
  </div>

  <div class="table-responsive">
    <table class="data-table">
      <thead>
        <tr>
          <th style="width:60px;">Urutan</th>
          <th>Ikon</th>
          <th>Nama Inisiatif / Proyek</th>
          <th>Deskripsi Progres</th>
          <th style="width:220px;">Persentase Capaian</th>
          <th style="text-align:right;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($sections as $sec)
          @foreach($sec->progressItems as $item)
          <tr>
            <td><b>#{{ $item->order }}</b></td>
            <td style="font-size:22px;">{{ $item->icon ?? '🏗️' }}</td>
            <td>
              <strong>{{ $item->title }}</strong>
              <div style="font-size:11px; color:var(--text-muted);">Bagian dari {{ $sec->title }}</div>
            </td>
            <td style="font-size:12px; color:#475569; max-width:280px;">
              {{ $item->description ?? '-' }}
            </td>
            <td>
              <div style="display:flex; align-items:center; gap:10px;">
                <div style="flex:1; background:#E2E8F0; height:8px; border-radius:10px; overflow:hidden;">
                  <div style="background:var(--pln-blue); height:100%; width:{{ $item->percentage }}%;"></div>
                </div>
                <span style="font-weight:800; font-size:13px; color:var(--pln-blue);">{{ round($item->percentage) }}%</span>
              </div>
            </td>
            <td style="text-align:right;">
              <div style="display:inline-flex; gap:6px;">
                <a href="{{ route('admin.progress.edit', $item) }}" class="btn btn-sm btn-secondary">Edit</a>
                <form action="{{ route('admin.progress.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus item progres ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                </form>
              </div>
            </td>
          </tr>
          @endforeach
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
