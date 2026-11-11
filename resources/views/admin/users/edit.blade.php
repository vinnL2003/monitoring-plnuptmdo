@extends('admin.layout')

@section('title', 'Edit Administrator Web')
@section('page_title', 'Edit Administrator Web')
@section('page_subtitle', 'Perbarui data akun atau ganti password administrator')

@section('content')
<div style="max-width: 680px;">
  <div class="card-box">
    <div class="card-box-header">
      <div>
        <h2>Edit Akun: {{ $user->name }}</h2>
        @if(auth()->id() === $user->id)
          <span class="badge badge-info">Sedang Anda Gunakan</span>
        @endif
      </div>
      <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
        ← Kembali ke Daftar Admin
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

    <form action="{{ route('admin.users.update', $user) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label for="name">Nama Lengkap Administrator <span style="color:red;">*</span></label>
        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
      </div>

      <div class="form-group">
        <label for="email">Email Login <span style="color:red;">*</span></label>
        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
      </div>

      <div style="margin: 24px 0 16px; padding: 14px; background: #F8FAFC; border: 1px solid var(--border-color); border-radius: 8px;">
        <h3 style="font-size: 13px; font-weight: 700; color: var(--pln-blue); margin-bottom: 4px;">
          🔑 Ubah Password (Opsional)
        </h3>
        <p style="font-size: 11.5px; color: var(--text-muted); margin-bottom: 12px;">
          Kosongkan kolom password di bawah jika Anda tidak ingin mengubah password akun ini.
        </p>

        <div class="form-group" style="margin-bottom: 12px;">
          <label for="password">Password Baru</label>
          <input type="password" id="password" name="password" class="form-control" placeholder="Biarkan kosong jika tidak diganti">
        </div>

        <div class="form-group" style="margin-bottom: 0;">
          <label for="password_confirmation">Konfirmasi Password Baru</label>
          <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Ketik ulang password baru">
        </div>
      </div>

      <div style="display: flex; gap: 10px; margin-top: 24px; padding-top: 18px; border-top: 1px solid var(--border-color);">
        <button type="submit" class="btn btn-primary">
          💾 Simpan Perubahan
        </button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
          Batal
        </a>
      </div>
    </form>
  </div>
</div>
@endsection
