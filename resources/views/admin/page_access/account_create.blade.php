@extends('admin.layout')

@section('title', 'Tambah Akun Personil Akses Terbatas')
@section('page_title', 'Tambah Akun Personil')
@section('page_subtitle', 'Buat kredensial login terenkripsi untuk personil yang berhak mengakses halaman khusus')

@section('content')
<div style="max-width: 720px;">
  <div class="card-box">
    <div class="card-box-header">
      <h2>Form Akun Personil Baru</h2>
      <a href="{{ route('admin.page-access.index') }}" class="btn btn-secondary btn-sm">
        ← Kembali ke Akses Halaman
      </a>
    </div>

    @if($errors->any())
      <div class="alert alert-error">
        <div>
          <strong style="display:block; margin-bottom: 4px;">Terdapat kesalahan pada input:</strong>
          <ul style="padding-left: 20px; font-size: 12.5px;">
            @foreach($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    @endif

    <form action="{{ route('admin.page-access.accounts.store') }}" method="POST">
      @csrf

      <div class="form-group">
        <label for="name">Nama Personil / Unit Kerja <span style="color:red;">*</span></label>
        <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" placeholder="Contoh: Tim Anggaran UPT / John Doe (NIP 92141105ZY)" required autofocus>
        <div class="hint">Nama pemilik atau pemegang kredensial akses</div>
      </div>

      <div class="form-group">
        <label for="username">Username / NIP Login <span style="color:red;">*</span></label>
        <input type="text" id="username" name="username" class="form-control" value="{{ old('username') }}" placeholder="Contoh: 92141105ZY atau anggaran_upt" required>
        <div class="hint">Kombinasi huruf/angka yang akan diketikkan personil saat membuka halaman</div>
      </div>

      <div class="form-group">
        <label for="password">Password Akses <span style="color:red;">*</span></label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Minimal 4 karakter" required>
        <div class="hint">Password akan langsung dienkripsi menggunakan Bcrypt hash sebelum disimpan ke database</div>
      </div>

      <div class="form-group" style="margin-top: 24px; padding: 18px; background: #F8FAFC; border: 1px solid var(--border-color); border-radius: 8px;">
        <label style="font-size: 13.5px; font-weight: 800; color: var(--pln-blue-dark); margin-bottom: 6px; display: block;">
          🛡️ Pilihan Halaman yang Diizinkan <span style="color:red;">*</span>
        </label>
        <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 14px;">
          Pilih satu atau lebih halaman yang boleh dibuka oleh akun ini saat mode proteksi aktif:
        </p>

        <div style="margin-bottom: 12px; padding-bottom: 10px; border-bottom: 1px solid var(--border-color);">
          <label style="display: inline-flex; align-items: center; gap: 8px; font-weight: 700; color: var(--pln-blue); cursor: pointer;">
            <input type="checkbox" id="checkAllPages" name="allowed_pages[]" value="*" {{ is_array(old('allowed_pages')) && in_array('*', old('allowed_pages')) ? 'checked' : '' }} onchange="toggleAllCheckboxes(this)">
            🌟 Akses Penuh ke Semua Halaman Terbatas (*)
          </label>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;" id="specificPagesList">
          @foreach($pages as $p)
            <label style="display: flex; align-items: center; gap: 8px; font-size: 12.5px; cursor: pointer; padding: 6px 10px; border-radius: 6px; background: #fff; border: 1px solid var(--border-color);">
              <input type="checkbox" class="page-checkbox" name="allowed_pages[]" value="{{ $p->page_slug }}" {{ is_array(old('allowed_pages')) && in_array($p->page_slug, old('allowed_pages')) ? 'checked' : '' }}>
              <span>{{ $p->icon ?? '📄' }} <strong>{{ $p->page_name }}</strong></span>
            </label>
          @endforeach
        </div>
      </div>

      <div class="form-group">
        <label for="notes">Catatan / Keterangan (Opsional)</label>
        <textarea id="notes" name="notes" class="form-control" placeholder="Contoh: Akun khusus tim bagian keuangan dan anggaran semester 1">{{ old('notes') }}</textarea>
      </div>

      <div class="form-group" style="margin-bottom: 24px;">
        <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer; font-weight: 600;">
          <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
          <span>Aktifkan akun ini sekarang</span>
        </label>
      </div>

      <div style="display: flex; gap: 10px; padding-top: 18px; border-top: 1px solid var(--border-color);">
        <button type="submit" class="btn btn-primary">
          💾 Simpan Akun Personil
        </button>
        <a href="{{ route('admin.page-access.index') }}" class="btn btn-secondary">
          Batal
        </a>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
  function toggleAllCheckboxes(masterCheckbox) {
    const checkboxes = document.querySelectorAll('.page-checkbox');
    checkboxes.forEach(cb => {
      if (masterCheckbox.checked) {
        cb.checked = false;
        cb.disabled = true;
      } else {
        cb.disabled = false;
      }
    });
  }

  // Init state jika old value terisi
  document.addEventListener('DOMContentLoaded', () => {
    const master = document.getElementById('checkAllPages');
    if (master && master.checked) {
      toggleAllCheckboxes(master);
    }
  });
</script>
@endsection
