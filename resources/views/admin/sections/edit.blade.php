@extends('admin.layout')

@section('page_title', 'Edit Section: ' . $section->title)
@section('page_subtitle', 'Perbarui judul, deskripsi, urutan tampilan, dan status visibilitas')

@section('content')
<div class="card-box" style="max-width:700px;">
  <form action="{{ route('admin.sections.update', $section) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
      <label for="title">Judul Section</label>
      <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $section->title) }}" required>
      <div class="hint">Contoh: 1. Ringkasan Kinerja Unit (NKO)</div>
    </div>

    <div class="form-group">
      <label for="description">Deskripsi Singkat (Opsional)</label>
      <textarea id="description" name="description" class="form-control" rows="3">{{ old('description', $section->description) }}</textarea>
      <div class="hint">Teks penjelasan di bawah judul section.</div>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
      <div class="form-group">
        <label for="order">Nomor Urutan</label>
        <input type="number" id="order" name="order" class="form-control" value="{{ old('order', $section->order) }}" min="1" required>
        <div class="hint">Urutan section dari atas ke bawah.</div>
      </div>

      <div class="form-group">
        <label>Slug / ID Anchor</label>
        <input type="text" class="form-control" value="{{ $section->slug }}" disabled>
        <div class="hint">ID navigasi scroll (#{{ $section->slug }}).</div>
      </div>
    </div>

    <div class="form-group" style="margin-top:10px; margin-bottom:24px;">
      <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
        <input type="checkbox" name="is_visible" value="1" {{ old('is_visible', $section->is_visible) ? 'checked' : '' }} style="width:18px; height:18px;">
        <span style="font-size:13px; font-weight:700;">Tampilkan section ini di halaman website publik</span>
      </label>
    </div>

    <div style="display:flex; gap:10px;">
      <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      <a href="{{ route('admin.sections.index') }}" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection
