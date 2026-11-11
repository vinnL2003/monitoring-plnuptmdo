@extends('admin.layout')

@section('title', 'Edit Akun Personil Akses Terbatas')
@section('page_title', 'Edit Akun Personil')
@section('page_subtitle', 'Perbarui hak akses halaman atau ubah password personil')

@section('content')
<div style="max-width: 720px;">
  <div class="card-box">
    <div class="card-box-header">
      <h2>Edit Akun: {{ $account->name }}</h2>
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

    <form action="{{ route('admin.page-access.accounts.update', $account) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label for="name">Nama Personil / Unit Kerja <span style="color:red;">*</span></label>
        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $account->name) }}" required>
      </div>

      <div class="form-group">
        <label for="username">Username / NIP Login <span style="color:red;">*</span></label>
        <input type="text" id="username" name="username" class="form-control" value="{{ old('username', $account->username) }}" required>
      </div>

      <div style="margin: 20px 0; padding: 14px; background: #F8FAFC; border: 1px solid var(--border-color); border-radius: 8px;">
        <label for="password" style="font-size: 13px; font-weight: 700; color: var(--pln-blue); margin-bottom: 4px; display: block;">
          🔑 Ganti Password Akses (Opsional)
        </label>
        <p style="font-size: 11.5px; color: var(--text-muted); margin-bottom: 8px;">
          Biarkan kolom ini kosong jika tidak ingin mengganti password akun ini.
        </p>
        <input type="password" id="password" name="password" class="form-control" placeholder="Ketik password baru jika ingin diganti">
      </div>

      <div class="form-group" style="margin-top: 24px; padding: 18px; background: #F8FAFC; border: 1px solid var(--border-color); border-radius: 8px;">
        <label style="font-size: 13.5px; font-weight: 800; color: var(--pln-blue-dark); margin-bottom: 6px; display: block;">
          🛡️ Pilihan Halaman yang Diizinkan <span style="color:red;">*</span>
        </label>
        <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 14px;">
          Pilih satu atau lebih halaman yang boleh dibuka oleh akun ini saat mode proteksi aktif:
        </p>

        @php
          $currentAllowed = old('allowed_pages', $account->allowed_pages ?? []);
          $isAllSelected = in_array('*', $currentAllowed, true);
        @endphp

        <div style="margin-bottom: 12px; padding-bottom: 10px; border-bottom: 1px solid var(--border-color);">
          <label style="display: inline-flex; align-items: center; gap: 8px; font-weight: 700; color: var(--pln-blue); cursor: pointer;">
            <input type="checkbox" id="checkAllPages" name="allowed_pages[]" value="*" {{ $isAllSelected ? 'checked' : '' }} onchange="toggleAllCheckboxes(this)">
            🌟 Akses Penuh ke Semua Halaman Terbatas (*)
          </label>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;" id="specificPagesList">
          @foreach($pages as $p)
            @php
              $checked = in_array($p->page_slug, $currentAllowed, true);
            @endphp
            <label style="display: flex; align-items: center; gap: 8px; font-size: 12.5px; cursor: pointer; padding: 6px 10px; border-radius: 6px; background: #fff; border: 1px solid var(--border-color);">
              <input type="checkbox" class="page-checkbox" name="allowed_pages[]" value="{{ $p->page_slug }}" {{ $checked ? 'checked' : '' }} {{ $isAllSelected ? 'disabled' : '' }}>
              <span>{{ $p->icon ?? '📄' }} <strong>{{ $p->page_name }}</strong></span>
            </label>
          @endforeach
        </div>
      </div>

      <div class="form-group">
        <label for="notes">Catatan / Keterangan (Opsional)</label>
        <textarea id="notes" name="notes" class="form-control">{{ old('notes', $account->notes) }}</textarea>
      </div>

      <div class="form-group" style="margin-bottom: 24px;">
        <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer; font-weight: 600;">
          <input type="checkbox" name="is_active" value="1" {{ old('is_active', $account->is_active) ? 'checked' : '' }}>
          <span>Akun ini dalam status aktif</span>
        </label>
      </div>

      <div style="display: flex; gap: 10px; padding-top: 18px; border-top: 1px solid var(--border-color);">
        <button type="submit" class="btn btn-primary">
          💾 Simpan Perubahan
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

  document.addEventListener('DOMContentLoaded', () => {
    const master = document.getElementById('checkAllPages');
    if (master && master.checked) {
      toggleAllCheckboxes(master);
    }
  });
</script>
@endsection
