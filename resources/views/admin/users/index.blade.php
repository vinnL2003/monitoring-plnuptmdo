@extends('admin.layout')

@section('title', 'Kelola Akun Admin Web')
@section('page_title', 'Kelola Akun Admin Web')
@section('page_subtitle', 'Manajemen akun administrator yang memiliki akses ke Admin Panel CMS')

@section('content')
<div class="card-box">
  <div class="card-box-header">
    <div>
      <h2>Daftar Administrator Web</h2>
      <p>Pengguna yang terdaftar di sini dapat masuk ke panel admin untuk mengedit seluruh konten website</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
      ➕ Tambah Admin Baru
    </a>
  </div>

  <div class="table-responsive">
    <table class="data-table">
      <thead>
        <tr>
          <th style="width: 50px;">No</th>
          <th>Nama Lengkap</th>
          <th>Email Login</th>
          <th>Status</th>
          <th>Terdaftar Pada</th>
          <th style="width: 150px; text-align: right;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $index => $u)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>
              <strong style="color: var(--pln-blue); font-size: 13.5px;">{{ $u->name }}</strong>
              @if(auth()->id() === $u->id)
                <span class="badge badge-info" style="margin-left: 6px;">Akun Anda</span>
              @endif
            </td>
            <td>
              <code style="background: #F1F5F9; padding: 3px 8px; border-radius: 4px; font-size: 12.5px; color: #0F172A;">
                {{ $u->email }}
              </code>
            </td>
            <td>
              <span class="badge badge-success">● Aktif</span>
            </td>
            <td style="color: var(--text-muted); font-size: 12px;">
              {{ $u->created_at ? $u->created_at->format('d M Y, H:i') : '-' }}
            </td>
            <td style="text-align: right;">
              <div style="display: flex; gap: 6px; justify-content: flex-end;">
                <a href="{{ route('admin.users.edit', $u) }}" class="btn btn-secondary btn-sm" title="Edit Akun Admin">
                  ✏️ Edit
                </a>
                @if(auth()->id() !== $u->id && count($users) > 1)
                  <form action="{{ route('admin.users.destroy', $u) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun admin {{ $u->name }}? Tindakan ini tidak dapat dibatalkan.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus Akun Admin">
                      🗑️
                    </button>
                  </form>
                @endif
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" style="text-align: center; padding: 30px; color: var(--text-muted);">
              Belum ada akun admin terdaftar.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="card-box" style="background: #F8FAFC; border-left: 4px solid var(--pln-blue);">
  <h3 style="font-size: 14px; font-weight: 700; color: var(--pln-blue-dark); margin-bottom: 6px;">
    ℹ️ Informasi Keamanan Akun Admin
  </h3>
  <p style="font-size: 12.5px; color: var(--text-muted); line-height: 1.6;">
    - Seluruh password admin disimpan secara terenkripsi kuat menggunakan algoritma Bcrypt (Hash).<br>
    - Admin yang sedang login tidak dapat menghapus akunnya sendiri demi mencegah penguncian sistem secara tidak sengaja.<br>
    - Sistem akan selalu menjaga minimal 1 akun admin web tetap ada.
  </p>
</div>
@endsection
