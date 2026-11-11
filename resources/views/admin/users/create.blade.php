@extends('admin.layout')

@section('title', 'Tambah Admin Web Baru')
@section('page_title', 'Tambah Administrator Baru')
@section('page_subtitle', 'Tambahkan akun admin baru untuk mengelola website PLN UPT Manado')

@section('content')
<div style="max-width: 680px;">
  <div class="card-box">
    <div class="card-box-header">
      <h2>Form Administrator Baru</h2>
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

    <form action="{{ route('admin.users.store') }}" method="POST">
      @csrf

      <div class="form-group">
        <label for="name">Nama Lengkap Administrator <span style="color:red;">*</span></label>
        <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso / Tim Komunikasi" required autofocus>
        <div class="hint">Nama tampilan administrator yang akan terlihat di pojok sidebar</div>
      </div>

      <div class="form-group">
        <label for="email">Email Login <span style="color:red;">*</span></label>
        <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="admin@pln.co.id" required>
        <div class="hint">Digunakan sebagai username saat login ke Admin Panel</div>
      </div>

      <div class="form-group">
        <label for="password">Password <span style="color:red;">*</span></label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
        <div class="hint">Password akan langsung dienkripsi dengan Bcrypt hash saat disimpan</div>
      </div>

      <div class="form-group">
        <label for="password_confirmation">Konfirmasi Password <span style="color:red;">*</span></label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Ketik ulang password" required>
      </div>

      <div style="display: flex; gap: 10px; margin-top: 24px; padding-top: 18px; border-top: 1px solid var(--border-color);">
        <button type="submit" class="btn btn-primary">
          💾 Simpan Administrator
        </button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
          Batal
        </a>
      </div>
    </form>
  </div>
</div>
@endsection
