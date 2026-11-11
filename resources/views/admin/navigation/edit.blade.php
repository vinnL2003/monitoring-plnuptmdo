@extends('admin.layout')

@section('page_title', 'Edit Menu: ' . $navItem->label)
@section('page_subtitle', 'Perbarui label tautan atau urutan tampil di header')

@section('content')
<div class="card-box" style="max-width:650px;">
  <form action="{{ route('admin.navigation.update', $navItem) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
      <label for="label">Label Menu</label>
      <input type="text" id="label" name="label" class="form-control" value="{{ old('label', $navItem->label) }}" required>
    </div>

    <div class="form-group">
      <label for="url">Target URL / Link</label>
      <input type="text" id="url" name="url" class="form-control" value="{{ old('url', $navItem->url) }}" required>
      <div class="hint">Bisa berupa path internal (contoh: <code>/anggaran</code> atau <code>/konstruksi-penyaluran</code>) atau URL eksternal.</div>
    </div>

    <div class="form-group">
      <label for="order">Nomor Urutan</label>
      <input type="number" id="order" name="order" class="form-control" value="{{ old('order', $navItem->order) }}" min="1" required>
    </div>

    <div class="form-group" style="margin-top:14px; margin-bottom:24px;">
      <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $navItem->is_active) ? 'checked' : '' }} style="width:18px; height:18px;">
        <span style="font-size:13px; font-weight:700;">Aktifkan dan tampilkan menu ini di header</span>
      </label>
    </div>

    <div style="display:flex; gap:10px;">
      <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      <a href="{{ route('admin.navigation.index') }}" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection
