@extends('admin.layout')

@section('page_title', 'Tambah Kartu Statistik Baru')
@section('page_subtitle', 'Tambahkan kartu ringkasan metrik baru dengan integrasi rumus CSV dan nilai manual cadangan')

@section('content')
<div class="card-box" style="max-width:820px;">
  <form action="{{ route('admin.stat-cards.store') }}" method="POST" id="statCardForm">
    @csrf

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
      <div class="form-group">
        <label for="section_id">Pilih Section Penempatan</label>
        <select id="section_id" name="section_id" class="form-control" required>
          @foreach($sections as $sec)
            <option value="{{ $sec->id }}" {{ old('section_id') == $sec->id ? 'selected' : '' }}>
              {{ $sec->title }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label for="order">Nomor Urutan Tampil</label>
        <input type="number" id="order" name="order" class="form-control" value="{{ old('order', 1) }}" min="1" required>
      </div>
    </div>

    <div style="display:grid; grid-template-columns:2fr 1fr; gap:16px;">
      <div class="form-group">
        <label for="title">Judul Kartu</label>
        <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" placeholder="Contoh: Realisasi KKU Bulan Berjalan" required>
      </div>

      <div class="form-group">
        <label for="icon">Ikon Emoji</label>
        <input type="text" id="icon" name="icon" class="form-control" value="{{ old('icon', '📊') }}" placeholder="Contoh: ⚡, 🏢, 🗼, 🔌">
      </div>
    </div>

    <div class="form-group">
      <label for="css_class">Kode Identifier / Target ID (Opsional)</label>
      <input type="text" id="css_class" name="css_class" class="form-control" value="{{ old('css_class') }}" placeholder="Contoh: cardGI, cardTrafo, cardPanjang, cardTower, cardJalur">
      <div class="hint">Digunakan oleh template jika kartu memiliki selector atau tooltip GIS khusus.</div>
    </div>

    <!-- BOX INTEGRASI SUMBER DATA CSV -->
    <div style="background:#F0F7FF; border:1px solid #BAE6FD; border-radius:10px; padding:20px; margin:24px 0;">
      <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
        <h3 style="font-size:14px; font-weight:800; color:var(--pln-blue-dark); display:flex; align-items:center; gap:8px;">
          🌐 Integrasi File CSV (Prioritas Utama)
        </h3>
        <span class="badge" style="background:#E0F2FE; color:#0369A1;">Otomatis Sinkron</span>
      </div>
      <p style="font-size:12px; color:#334155; margin-bottom:16px; line-height:1.5;">
        Sistem akan mencoba membaca nilai dari file CSV terlebih dahulu. Jika bagian yang dicari tidak ada di CSV, maka nilai manual di bawah yang otomatis digunakan.
      </p>

      <div class="form-group">
        <label for="data_source_id">Sumber Data CSV</label>
        <select id="data_source_id" name="data_source_id" class="form-control">
          <option value="">-- Tanpa CSV (Murni Manual Saja) --</option>
          @foreach($dataSources as $ds)
            <option value="{{ $ds->id }}" {{ old('data_source_id') == $ds->id ? 'selected' : '' }}>
              {{ $ds->name }} ({{ $ds->key }}) [{{ $ds->source_type === 'file' ? '📁 File Lokal' : ($ds->source_type === 'none' ? '🚫 Tanpa Metode' : '🌐 Google Sheets') }}]
            </option>
          @endforeach
        </select>
        <div class="hint">Pilih sumber data CSV (Google Sheets live atau File CSV lokal).</div>
      </div>

      <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
        <div class="form-group">
          <label for="csv_search_query">Kata Kunci / Nama Kolom yang Dicari di CSV</label>
          <input type="text" id="csv_search_query" name="csv_search_query" class="form-control" value="{{ old('csv_search_query') }}" placeholder="Contoh: Num of Sustation (unit) atau Realisasi KKU Bulan Berjalan">
          <div class="hint">Nama parameter atau kolom yang dicari di file CSV.</div>
        </div>

        <div class="form-group">
          <label for="csv_formula">Metode Pembacaan / Rumus CSV</label>
          <select id="csv_formula" name="csv_formula" class="form-control">
            <option value="auto" {{ old('csv_formula') === 'auto' ? 'selected' : '' }}>Deteksi Otomatis Sesuai Pola Data</option>
            <option value="asset_param" {{ old('csv_formula') === 'asset_param' ? 'selected' : '' }}>Baris Parameter Aset (Kolom UPT Manado &amp; ULTG)</option>
            <option value="metric_row" {{ old('csv_formula') === 'metric_row' ? 'selected' : '' }}>Baris Metrik KKU (Format: Metrik, Nilai, Keterangan)</option>
            <option value="column_header" {{ old('csv_formula') === 'column_header' ? 'selected' : '' }}>Header Kolom Tabel Horizontal (Baris Terakhir)</option>
            <option value="manual" {{ old('csv_formula') === 'manual' ? 'selected' : '' }}>Nonaktifkan Sinkronisasi (Hanya Manual)</option>
          </select>
        </div>
      </div>

      <!-- Tombol Uji Baca CSV Interaktif -->
      <div style="display:flex; align-items:center; gap:12px; margin-top:10px;">
        <button type="button" class="btn btn-secondary btn-sm" id="btnTestCsv" onclick="testCsvMapping()">
          🔍 Uji Pembacaan Rumus CSV
        </button>
        <span id="testCsvSpinner" style="display:none; font-size:12px; color:var(--pln-blue);">Memindai file CSV...</span>
      </div>

      <div id="testCsvResult" style="display:none; margin-top:14px; padding:12px 14px; border-radius:8px; font-size:12.5px;"></div>
    </div>

    <!-- BOX NILAI MANUAL (FALLBACK / CADANGAN) -->
    <div style="background:#FFFDF5; border:1px solid #FDE68A; border-radius:10px; padding:20px; margin-bottom:24px;">
      <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
        <h3 style="font-size:14px; font-weight:800; color:#92400E; display:flex; align-items:center; gap:8px;">
          📝 Nilai Manual (Cadangan / Fallback)
        </h3>
        <span class="badge" style="background:#FEF3C7; color:#92400E;">Wajib Diisi</span>
      </div>
      <p style="font-size:12px; color:#78350F; margin-bottom:16px; line-height:1.5;">
        <b>Fungsi Nilai Manual ini tetap aktif:</b> Jika file CSV belum diunggah, bagian rumus tidak ketemu, atau nilai dalam sel CSV kosong/rusak, maka nilai manual inilah yang otomatis ditampilkan di dashboard publik.
      </p>

      <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
        <div class="form-group">
          <label for="value">Nilai Manual (Angka / Persentase / Teks)</label>
          <input type="text" id="value" name="value" class="form-control" value="{{ old('value') }}" placeholder="Contoh: 37 atau 98.4%">
        </div>

        <div class="form-group">
          <label for="unit">Satuan Manual (Unit)</label>
          <input type="text" id="unit" name="unit" class="form-control" value="{{ old('unit') }}" placeholder="Contoh: Unit, kms, Tower, %, Sirkit">
        </div>
      </div>

      <div class="form-group">
        <label for="footer_text">Teks Keterangan Bawah Manual (Footer Text)</label>
        <input type="text" id="footer_text" name="footer_text" class="form-control" value="{{ old('footer_text') }}" placeholder="Contoh: Realisasi Bulan Berjalan atau Menunggu sumber data">
      </div>
    </div>

    <div style="display:flex; gap:10px; margin-top:28px;">
      <button type="submit" class="btn btn-primary">Simpan &amp; Uji Sinkronkan</button>
      <a href="{{ route('admin.stat-cards.index') }}" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection

@section('scripts')
<script>
function testCsvMapping() {
  const dsId = document.getElementById('data_source_id').value;
  const query = document.getElementById('csv_search_query').value.trim() || document.getElementById('title').value.trim();
  const formula = document.getElementById('csv_formula').value;
  const resDiv = document.getElementById('testCsvResult');
  const spinner = document.getElementById('testCsvSpinner');

  if (!dsId) {
    resDiv.style.display = 'block';
    resDiv.style.background = '#FEF2F2';
    resDiv.style.border = '1px solid #FECACA';
    resDiv.style.color = '#991B1B';
    resDiv.innerHTML = '⚠️ Harap pilih <b>Sumber Data CSV</b> terlebih dahulu untuk menguji rumus.';
    return;
  }

  if (!query) {
    resDiv.style.display = 'block';
    resDiv.style.background = '#FEF2F2';
    resDiv.style.border = '1px solid #FECACA';
    resDiv.style.color = '#991B1B';
    resDiv.innerHTML = '⚠️ Masukkan <b>Kata Kunci yang Dicari</b> atau <b>Judul Kartu</b> untuk diuji.';
    return;
  }

  spinner.style.display = 'inline';
  resDiv.style.display = 'none';

  fetch("{{ route('admin.stat-cards.test-mapping') }}", {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({
      data_source_id: dsId,
      csv_search_query: query,
      csv_formula: formula
    })
  })
  .then(res => res.json())
  .then(data => {
    spinner.style.display = 'none';
    resDiv.style.display = 'block';

    if (data.success && data.found) {
      resDiv.style.background = '#ECFDF5';
      resDiv.style.border = '1px solid #A7F3D0';
      resDiv.style.color = '#065F46';
      resDiv.innerHTML = `
        <div style="font-weight:700; margin-bottom:4px;">✅ Bagian Berhasil Ditemukan di File CSV!</div>
        <div>Nilai Terbaca: <b style="font-size:15px; color:#047857;">${data.value} ${data.unit || ''}</b></div>
        ${data.footer ? `<div style="font-size:11.5px; margin-top:2px; color:#065F46;">Keterangan: ${data.footer}</div>` : ''}
        <div style="font-size:11px; color:#059669; margin-top:4px;">Cocok dengan label CSV: <i>"${data.matched_label}"</i> (Metode: ${data.mode})</div>
      `;
    } else {
      resDiv.style.background = '#FFFBEB';
      resDiv.style.border = '1px solid #FDE68A';
      resDiv.style.color = '#92400E';
      resDiv.innerHTML = `
        <div style="font-weight:700; margin-bottom:4px;">⚠️ Bagian Tidak Ditemukan di CSV:</div>
        <div>${data.message || 'Pencarian tidak menemukan baris atau kolom yang sesuai.'}</div>
        <div style="font-size:11px; margin-top:4px; font-weight:600;">Sistem akan otomatis menggunakan <u>Nilai Manual Cadangan</u> yang Anda isi di bawah saat ditampilkan di web.</div>
      `;
    }
  })
  .catch(err => {
    spinner.style.display = 'none';
    resDiv.style.display = 'block';
    resDiv.style.background = '#FEF2F2';
    resDiv.style.border = '1px solid #FECACA';
    resDiv.style.color = '#991B1B';
    resDiv.innerHTML = '❌ Gagal memindai file CSV: ' + err.message;
  });
}
</script>
@endsection
