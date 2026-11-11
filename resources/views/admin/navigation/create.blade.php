@extends('admin.layout')

@section('page_title', 'Tambah Menu Navigasi Baru')
@section('page_subtitle', 'Tambahkan menu baru ke header website PLN')

@section('content')
<div class="card-box" style="max-width:650px;">
  <form action="{{ route('admin.navigation.store') }}" method="POST">
    @csrf

    <div class="form-group">
      <label for="label">Label Menu</label>
      <input type="text" id="label" name="label" class="form-control" placeholder="Contoh: Galeri Operasi atau Laporan Tahunan" required>
    </div>

    <div class="form-group">
      <label for="url">Target URL / Link</label>
      <input type="text" id="url" name="url" class="form-control" placeholder="Contoh: /kinerja-transmisi atau https://... atau /aset" required>
      <div class="hint">Bisa berupa path internal (contoh: <code>/anggaran</code> atau <code>/konstruksi-penyaluran</code>) atau URL eksternal penuh.</div>
    </div>

    <div class="form-group">
      <label for="order">Nomor Urutan</label>
      <input type="number" id="order" name="order" class="form-control" value="10" min="1" required>
      <div class="hint">Urutan posisi menu dari kiri ke kanan.</div>
    </div>

    <div class="form-group" style="margin-top:14px; margin-bottom:24px;">
      <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
        <input type="checkbox" name="is_active" value="1" checked style="width:18px; height:18px;">
        <span style="font-size:13px; font-weight:700;">Aktifkan dan tampilkan menu ini di header</span>
      </label>
    </div>

    <div style="display:flex; gap:10px;">
      <button type="submit" class="btn btn-primary">Simpan Menu</button>
      <a href="{{ route('admin.navigation.index') }}" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection
