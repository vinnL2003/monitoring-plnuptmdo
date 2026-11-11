@extends('admin.layout')

@section('page_title', 'Menu Navigasi Header')
@section('page_subtitle', 'Atur tautan menu pada bilah navigasi atas website')

@section('content')
<div class="card-box">
  <div class="card-box-header">
    <div>
      <h2>Daftar Menu Header</h2>
      <p>Menu yang tampil di samping logo PLN pada header situs</p>
    </div>
    <a href="{{ route('admin.navigation.create') }}" class="btn btn-primary btn-sm">+ Tambah Menu Baru</a>
  </div>

  <div class="table-responsive">
    <table class="data-table">
      <thead>
        <tr>
          <th style="width:60px;">Urutan</th>
          <th>Label Menu</th>
          <th>Target URL / Link</th>
          <th>Status</th>
          <th style="text-align:right;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($navItems as $item)
        <tr>
          <td><b>#{{ $item->order }}</b></td>
          <td><strong style="font-size:14px;">{{ $item->label }}</strong></td>
          <td><code>{{ $item->url }}</code></td>
          <td>
            @if($item->is_active)
              <span class="badge badge-success">● Aktif</span>
            @else
              <span class="badge badge-danger">○ Sembunyi</span>
            @endif
          </td>
          <td style="text-align:right;">
            <div style="display:inline-flex; gap:6px;">
              <a href="{{ route('admin.navigation.edit', $item) }}" class="btn btn-sm btn-secondary">Edit</a>
              <form action="{{ route('admin.navigation.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus menu ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
              </form>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
