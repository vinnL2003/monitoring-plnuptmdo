@extends('admin.layout')

@section('page_title', 'Edit Kartu Statistik: ' . $statCard->title)
@section('page_subtitle', 'Konfigurasi rumus pencarian CSV, nilai manual, serta fitur sinkronisasi 2-arah ke sumber data')

@section('content')
<!-- BANNER STATUS INTEGRASI SAAT INI -->
<div class="card-box" style="max-width:860px; background:#F8FAFC; border-left:4px solid var(--pln-blue); padding:16px 20px; margin-bottom:20px;">
  <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
    <div>
      <div style="font-size:11px; font-weight:700; color:var(--text-muted); text-transform:uppercase;">Status Kartu Saat Ini</div>
      <div style="display:flex; align-items:baseline; gap:8px; margin-top:2px;">
        <span style="font-size:24px; font-weight:800; color:var(--pln-blue-dark);">{{ $statCard->effective_value }}</span>
        <span style="font-size:14px; font-weight:600; color:var(--text-muted);">{{ $statCard->effective_unit }}</span>
        @if($statCard->is_synced)
          <span class="badge" style="background:#DCFCE7; color:#15803D; font-size:11px;">🟢 Tersinkron dari CSV</span>
        @else
          <span class="badge" style="background:#FEF3C7; color:#B45309; font-size:11px;">🟡 Menggunakan Manual (Fallback)</span>
        @endif
      </div>
      @if($statCard->effective_footer)
        <div style="font-size:11.5px; color:#475569; margin-top:3px;">Keterangan: {{ $statCard->effective_footer }}</div>
      @endif
    </div>

    @if($statCard->dataSource)
      <div style="text-align:right;">
        <div style="font-size:11px; color:var(--text-muted);">Sumber Data Terhubung:</div>
        <div style="font-size:13px; font-weight:700; color:var(--pln-blue);">
          {{ $statCard->dataSource->source_type === 'file' ? '📁 File CSV Lokal Server' : '🌐 Live Google Spreadsheet' }}
        </div>
        <div style="margin-top:6px; display:flex; gap:6px; justify-content:flex-end;">
          <a href="{{ route('admin.page-data.edit', $statCard->dataSource->key) }}" class="btn btn-sm btn-outline-primary" style="font-size:11px; padding:3px 10px;" target="_blank">
            📊 Buka di Studio Editor
          </a>
          @if($statCard->dataSource->source_type === 'file' && !empty($statCard->dataSource->url))
            <form action="{{ route('admin.stat-cards.reset-remote', $statCard) }}" method="POST" onsubmit="return confirm('Kembalikan sumber data agar membaca langsung dari Google Spreadsheet live? Salinan lokal akan dinonaktifkan.');" style="display:inline;">
              @csrf
              <button type="submit" class="btn btn-sm btn-warning" style="font-size:11px; padding:3px 10px;" title="Tarik ulang data segar langsung dari Google Sheet">
                🌐 Tarik Ulang Spreadsheet
              </button>
            </form>
          @endif
        </div>
      </div>
    @endif
  </div>
</div>

<div class="card-box" style="max-width:860px;">
  <form action="{{ route('admin.stat-cards.update', $statCard) }}" method="POST" id="statCardForm">
    @csrf
    @method('PUT')

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
      <div class="form-group">
        <label for="section_id">Section Penempatan</label>
        <select id="section_id" name="section_id" class="form-control" required>
          @foreach($sections as $sec)
            <option value="{{ $sec->id }}" {{ $statCard->section_id == $sec->id ? 'selected' : '' }}>
              {{ $sec->title }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label for="order">Nomor Urutan Tampil</label>
        <input type="number" id="order" name="order" class="form-control" value="{{ old('order', $statCard->order) }}" min="1" required>
      </div>
    </div>

    <div style="display:grid; grid-template-columns:2fr 1fr; gap:16px;">
      <div class="form-group">
        <label for="title">Judul Kartu</label>
        <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $statCard->title) }}" required>
      </div>

      <div class="form-group">
        <label for="icon">Ikon Emoji</label>
        <input type="text" id="icon" name="icon" class="form-control" value="{{ old('icon', $statCard->icon) }}" placeholder="Contoh: 🏢, ⚡, 🗼">
      </div>
    </div>

    <div class="form-group">
      <label for="css_class">Kode Identifier / Target ID (Opsional)</label>
      <input type="text" id="css_class" name="css_class" class="form-control" value="{{ old('css_class', $statCard->css_class) }}" placeholder="Contoh: cardGI, cardTrafo, cardPanjang, cardTower, cardJalur, valNko">
      <div class="hint">Digunakan oleh script template jika kartu memiliki interaksi khusus (seperti tooltip GIS atau filter bulanan).</div>
    </div>

    <!-- BOX SINKRONISASI 2-ARAH (FITUR UTAMA) -->
    <div style="background:#ECFDF5; border:1.5px solid #10B981; border-radius:10px; padding:20px; margin:24px 0;">
      <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
        <h3 style="font-size:14px; font-weight:800; color:#065F46; display:flex; align-items:center; gap:8px;">
          🔄 Fitur Sinkronisasi 2-Arah (Kartu &harr; Sumber Data CSV / Spreadsheet)
        </h3>
        <span class="badge" style="background:#D1FAE5; color:#047857; font-weight:700;">2-Way Active</span>
      </div>
      <p style="font-size:12px; color:#065F46; margin-bottom:14px; line-height:1.5;">
        Saat Anda mengubah isi detail kartu di bawah ini dan mencentang opsi <b>Sinkronkan 2-Arah</b>, sistem akan langsung menuliskan angka baru tersebut ke dalam <b>file CSV sumber data server</b>. Seluruh halaman web serta grid tabel spreadsheet studio akan otomatis berubah mengikuti data terbaru Anda!
      </p>

      <div style="background:#fff; border:1px solid #A7F3D0; border-radius:8px; padding:14px; margin-bottom:14px;">
        <label style="display:flex; align-items:flex-start; gap:10px; cursor:pointer; margin:0;">
          <input type="checkbox" name="sync_two_way" id="sync_two_way" value="1" checked style="width:18px; height:18px; margin-top:2px;">
          <div>
            <span style="font-size:13px; font-weight:700; color:#065F46;">
              Tulis nilai baru ini langsung ke Sumber Data (File CSV / Spreadsheet)
            </span>
            <div style="font-size:11.5px; color:#047857; margin-top:2px;">
              Jika dicentang, tombol Simpan akan memperbarui kartu sekaligus menimpa sel/baris terkait di dalam sumber data server.
            </div>
          </div>
        </label>
      </div>

      <!-- Input Nilai Utama -->
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
        <div class="form-group" style="margin-bottom:12px;">
          <label for="value" style="color:#065F46; font-weight:700;">Nilai Baru (Angka / Teks / Persentase)</label>
          <input type="text" id="value" name="value" class="form-control" value="{{ old('value', $statCard->effective_value !== '-' ? $statCard->effective_value : $statCard->value) }}" placeholder="Contoh: 37 atau 98.4%" required style="border-color:#10B981; font-weight:700; font-size:15px; color:#065F46;">
          <div class="hint">Nilai ini yang akan ditulis ke sumber data dan ditampilkan di dashboard publik.</div>
        </div>

        <div class="form-group" style="margin-bottom:12px;">
          <label for="unit" style="color:#065F46; font-weight:700;">Satuan Besaran (Unit)</label>
          <input type="text" id="unit" name="unit" class="form-control" value="{{ old('unit', $statCard->effective_unit ?: $statCard->unit) }}" placeholder="Contoh: Unit, kms, Tower, %, Sirkit, Poin">
        </div>
      </div>

      <div class="form-group" style="margin-bottom:12px;">
        <label for="footer_text" style="color:#065F46; font-weight:700;">Keterangan / Footer Kartu</label>
        <input type="text" id="footer_text" name="footer_text" class="form-control" value="{{ old('footer_text', $statCard->effective_footer ?: $statCard->footer_text) }}" placeholder="Contoh: Realisasi Bulan Berjalan atau Rincian per ULTG">
        <div class="hint">Keterangan yang tampil di bagian bawah kartu statistik (akan ditulis ke kolom keterangan di CSV jika format mendukung).</div>
      </div>

      <!-- Jika Section Aset, tampilkan rincian ULTG -->
      @if($statCard->section && $statCard->section->slug === 'aset')
        <div style="background:#F0FDF4; border:1px dashed #86EFAC; border-radius:8px; padding:14px; margin-top:14px;">
          <div style="font-size:12px; font-weight:700; color:#166534; margin-bottom:8px;">
            🏢 Rincian Nilai per ULTG (Khusus Aset Transmisi)
          </div>
          <div style="display:grid; grid-template-columns:repeat(4, 1fr); gap:10px;">
            <div>
              <label style="font-size:11px; color:#166534; font-weight:600;">ULTG Sawangan (SWG)</label>
              <input type="text" name="ultg_sawangan" class="form-control" value="{{ old('ultg_sawangan', $ultgBreakdown['sawangan'] ?? '') }}" placeholder="Contoh: 12">
            </div>
            <div>
              <label style="font-size:11px; color:#166534; font-weight:600;">ULTG Lopana (LPN)</label>
              <input type="text" name="ultg_lopana" class="form-control" value="{{ old('ultg_lopana', $ultgBreakdown['lopana'] ?? '') }}" placeholder="Contoh: 12">
            </div>
            <div>
              <label style="font-size:11px; color:#166534; font-weight:600;">ULTG Kotamobagu (KTG)</label>
              <input type="text" name="ultg_kotamobagu" class="form-control" value="{{ old('ultg_kotamobagu', $ultgBreakdown['kotamobagu'] ?? '') }}" placeholder="Contoh: 5">
            </div>
            <div>
              <label style="font-size:11px; color:#166534; font-weight:600;">ULTG Gorontalo (GTO)</label>
              <input type="text" name="ultg_gorontalo" class="form-control" value="{{ old('ultg_gorontalo', $ultgBreakdown['gorontalo'] ?? '') }}" placeholder="Contoh: 8">
            </div>
          </div>
          <div style="font-size:10.5px; color:#15803D; margin-top:6px;">
            *Jika diisi, nilai rincian ULTG ini juga akan diupdate pada kolom masing-masing ULTG di file CSV server.
          </div>
        </div>
      @endif
    </div>

    <!-- BOX PENGATURAN TEKNIS SUMBER DATA & RUMUS CSV -->
    <div style="background:#F0F7FF; border:1px solid #BAE6FD; border-radius:10px; padding:20px; margin:24px 0;">
      <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
        <h3 style="font-size:14px; font-weight:800; color:var(--pln-blue-dark); display:flex; align-items:center; gap:8px;">
          🌐 Pemetaan Kolom / Rumus CSV
        </h3>
        <span class="badge" style="background:#E0F2FE; color:#0369A1;">Pengaturan Teknis</span>
      </div>

      <div class="form-group">
        <label for="data_source_id">Sumber Data Terhubung</label>
        <select id="data_source_id" name="data_source_id" class="form-control">
          <option value="">-- Tanpa Sumber Data (Murni Manual Saja) --</option>
          @foreach($dataSources as $ds)
            <option value="{{ $ds->id }}" {{ (old('data_source_id', $statCard->data_source_id) == $ds->id || old('csv_key', $statCard->csv_key) == $ds->key) ? 'selected' : '' }}>
              {{ $ds->name }} ({{ $ds->key }}) [{{ $ds->source_type === 'file' ? '📁 File Lokal' : ($ds->source_type === 'none' ? '🚫 Tanpa Metode' : '🌐 Google Sheets') }}]
            </option>
          @endforeach
        </select>
      </div>

      <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
        <div class="form-group">
          <label for="csv_search_query">Kata Kunci / Nama Kolom yang Dicari di CSV</label>
          <input type="text" id="csv_search_query" name="csv_search_query" class="form-control" value="{{ old('csv_search_query', $statCard->csv_search_query) }}" placeholder="Contoh: Num of Sustation (unit) atau Realisasi KKU Bulan Berjalan">
          <div class="hint">Teks persis atau bagian nama parameter di file CSV yang ingin dicari/diubah nilainya.</div>
        </div>

        <div class="form-group">
          <label for="csv_formula">Metode Pembacaan / Rumus CSV</label>
          <select id="csv_formula" name="csv_formula" class="form-control">
            <option value="auto" {{ old('csv_formula', $statCard->csv_formula) === 'auto' ? 'selected' : '' }}>Deteksi Otomatis Sesuai Pola Data</option>
            <option value="asset_param" {{ old('csv_formula', $statCard->csv_formula) === 'asset_param' ? 'selected' : '' }}>Baris Parameter Aset (Kolom UPT Manado &amp; ULTG)</option>
            <option value="metric_row" {{ old('csv_formula', $statCard->csv_formula) === 'metric_row' ? 'selected' : '' }}>Baris Metrik KKU (Format: Metrik, Nilai, Keterangan)</option>
            <option value="column_header" {{ old('csv_formula', $statCard->csv_formula) === 'column_header' ? 'selected' : '' }}>Header Kolom Tabel Horizontal (Baris Terakhir)</option>
            <option value="manual" {{ old('csv_formula', $statCard->csv_formula) === 'manual' ? 'selected' : '' }}>Nonaktifkan Sinkronisasi (Hanya Manual)</option>
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

    <!-- TOMBOL SIMPAN -->
    <div style="display:flex; gap:12px; margin-top:28px; flex-wrap:wrap;">
      <button type="submit" name="action_type" value="save_sync_two_way" class="btn btn-success" style="padding:10px 20px; font-weight:700;">
        💾 Simpan ke Kartu &amp; Perbarui Sumber Data (2-Arah)
      </button>

      <button type="submit" name="action_type" value="save_card_only" class="btn btn-primary" style="padding:10px 18px;">
        Simpan Pengaturan Kartu Saja
      </button>

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
    resDiv.innerHTML = '⚠️ Harap pilih <b>Sumber Data Terhubung</b> terlebih dahulu untuk menguji rumus.';
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
        <div style="font-size:11px; margin-top:4px; font-weight:600;">Sistem akan menggunakan nilai input yang Anda simpan sebagai nilai fallback atau menambahkan baris baru di file CSV server.</div>
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
