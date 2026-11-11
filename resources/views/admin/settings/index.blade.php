@extends('admin.layout')

@section('page_title', 'Pengaturan Website & Branding')
@section('page_subtitle', 'Modifikasi identitas situs, logo, teks hero, dan copyright footer')

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
  @csrf

  <div class="card-box">
    <div class="card-box-header">
      <div>
        <h2>Identitas &amp; Judul Website</h2>
        <p>Pengaturan judul halaman dan teks utama</p>
      </div>
    </div>

    <div class="form-group">
      <label for="site_title">Judul Website (Title Tag / Tab Browser)</label>
      <input type="text" id="site_title" name="site_title" class="form-control"
             value="{{ $settings->flatten()->firstWhere('key', 'site_title')->value ?? 'DASHBOARD KINERJA — UPT MANADO' }}" required>
      <div class="hint">Tampil di judul tab browser dan meta SEO.</div>
    </div>

    <div class="form-group">
      <label for="site_subtitle">Sub Judul Unit</label>
      <input type="text" id="site_subtitle" name="site_subtitle" class="form-control"
             value="{{ $settings->flatten()->firstWhere('key', 'site_subtitle')->value ?? 'PT PLN (Persero) UPT Manado' }}">
      <div class="hint">Nama resmi unit kerja.</div>
    </div>
  </div>

  <div class="card-box">
    <div class="card-box-header">
      <div>
        <h2>Logo &amp; Branding Visual</h2>
        <p>Ganti logo header PLN atau logo animasi hero UPT</p>
      </div>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
      <div class="form-group">
        <label>Logo PLN (Header)</label>
        <div style="background:#00386C; padding:15px; border-radius:8px; margin-bottom:10px; display:inline-block;">
          <img src="{{ asset($settings->flatten()->firstWhere('key', 'pln_logo')->value ?? 'PLN_White.png') }}"
               alt="Logo PLN" style="height:36px; object-fit:contain;">
        </div>
        <input type="file" name="pln_logo_file" class="form-control" accept="image/*">
        <div class="hint">Upload gambar baru (PNG/SVG disarankan dengan latar transparan).</div>
      </div>

      <div class="form-group">
        <label>Logo Hero UPT Manado</label>
        <div style="background:#00386C; padding:15px; border-radius:8px; margin-bottom:10px; display:inline-block;">
          <img src="{{ asset($settings->flatten()->firstWhere('key', 'hero_logo')->value ?? 'Logo_UPT_Manado.png') }}"
               alt="Logo UPT" style="height:60px; object-fit:contain;">
        </div>
        <input type="file" name="hero_logo_file" class="form-control" accept="image/*">
        <div class="hint">Logo lambang UPT Manado yang tampil mengambang di hero banner.</div>
      </div>
    </div>
  </div>

  <div class="card-box">
    <div class="card-box-header">
      <div>
        <h2>Badge Status &amp; Jam Realtime</h2>
        <p>Atur indikator live update pada hero banner</p>
      </div>
    </div>

    <div class="form-group">
      <label for="hero_badge_text">Teks Awalan Badge</label>
      <input type="text" id="hero_badge_text" name="hero_badge_text" class="form-control"
             value="{{ $settings->flatten()->firstWhere('key', 'hero_badge_text')->value ?? '● LIVE — Update:' }}">
    </div>

    <div class="form-group" style="display:flex; align-items:center; gap:10px; margin-top:14px;">
      <input type="checkbox" id="enable_live_clock" name="enable_live_clock" value="1"
             {{ ($settings->flatten()->firstWhere('key', 'enable_live_clock')->value ?? '1') === '1' ? 'checked' : '' }}
             style="width:18px; height:18px;">
      <label for="enable_live_clock" style="margin:0; font-weight:600; cursor:pointer;">
        Tampilkan Jam &amp; Tanggal Live Realtime (Berjalan setiap detik)
      </label>
    </div>
  </div>

  <div class="card-box">
    <div class="card-box-header">
      <div>
        <h2>Footer Website</h2>
        <p>Teks hak cipta dan informasi bagian bawah website</p>
      </div>
    </div>

    <div class="form-group">
      <label for="footer_text">Teks Hak Cipta (Copyright)</label>
      <textarea id="footer_text" name="footer_text" class="form-control" rows="2">{{ $settings->flatten()->firstWhere('key', 'footer_text')->value ?? '© 2026 PT PLN (Persero) UPT Manado — Dashboard Kinerja Transmisi. All Rights Reserved.' }}</textarea>
    </div>
  </div>

  <div style="display:flex; gap:12px; margin-bottom:40px;">
    <button type="submit" class="btn btn-primary" style="padding:12px 24px; font-size:14px;">
      💾 Simpan Semua Perubahan
    </button>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary" style="padding:12px 24px;">Batal</a>
  </div>
</form>
@endsection
