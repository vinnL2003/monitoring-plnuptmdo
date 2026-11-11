@extends('admin.layout')

@section('page_title', 'Edit Item Progres: ' . $progressItem->title)
@section('page_subtitle', 'Sesuaikan persentase capaian proyek atau deskripsi kegiatan')

@section('content')
<div class="card-box" style="max-width:650px;">
  <form action="{{ route('admin.progress.update', $progressItem) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
      <label for="section_id">Section Penempatan</label>
      <select id="section_id" name="section_id" class="form-control" required>
        @foreach($sections as $sec)
          <option value="{{ $sec->id }}" {{ $progressItem->section_id == $sec->id ? 'selected' : '' }}>
            {{ $sec->title }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="title">Nama Inisiatif / Progres</label>
      <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $progressItem->title) }}" required>
    </div>

    <div class="form-group">
      <label for="description">Deskripsi Ringkas</label>
      <textarea id="description" name="description" class="form-control" rows="2">{{ old('description', $progressItem->description) }}</textarea>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px;">
      <div class="form-group">
        <label for="percentage">Persentase (%)</label>
        <input type="number" id="percentage" name="percentage" class="form-control" min="0" max="100" step="0.1" value="{{ old('percentage', $progressItem->percentage) }}" required>
      </div>

      <div class="form-group">
        <label for="icon">Ikon Emoji</label>
        <input type="text" id="icon" name="icon" class="form-control" value="{{ old('icon', $progressItem->icon) }}">
      </div>

      <div class="form-group">
        <label for="order">Nomor Urutan</label>
        <input type="number" id="order" name="order" class="form-control" value="{{ old('order', $progressItem->order) }}" min="1" required>
      </div>
    </div>

    <div style="display:flex; gap:10px; margin-top:24px;">
      <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      <a href="{{ route('admin.progress.index') }}" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection
