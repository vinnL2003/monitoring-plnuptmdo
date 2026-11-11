@extends('admin.layout')

@section('page_title', 'Kelola Kartu Statistik & Metrik (Sinkronisasi 2-Arah)')
@section('page_subtitle', 'Kelola seluruh metrik 7 section dashboard dengan live sync, fallback manual, dan pembaruan 2-arah ke CSV / Spreadsheet')

@section('content')
<!-- KARTU STATUS RINGKASAN INTEGRASI -->
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:16px; margin-bottom:24px;">
  <div class="card-box" style="margin-bottom:0; padding:18px; border-left:4px solid var(--pln-blue);">
    <div style="font-size:11.5px; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px;">Total Kartu Statistik</div>
    <div style="font-size:28px; font-weight:800; color:var(--pln-blue-dark); margin-top:4px;">{{ $totalCards }}</div>
    <div style="font-size:11px; color:var(--text-muted); margin-top:2px;">Terpasang pada 7 Section Dashboard</div>
  </div>

  <div class="card-box" style="margin-bottom:0; padding:18px; border-left:4px solid #10B981;">
    <div style="font-size:11.5px; font-weight:700; color:#047857; text-transform:uppercase; letter-spacing:0.5px;">🟢 Tersinkron dari CSV</div>
    <div style="font-size:28px; font-weight:800; color:#065F46; margin-top:4px;">{{ $syncedCards }}</div>
    <div style="font-size:11px; color:#047857; margin-top:2px;">Terbaca otomatis sesuai rumus CSV</div>
  </div>

  <div class="card-box" style="margin-bottom:0; padding:18px; border-left:4px solid #F59E0B;">
    <div style="font-size:11.5px; font-weight:700; color:#B45309; text-transform:uppercase; letter-spacing:0.5px;">🟡 Menggunakan Manual (Fallback)</div>
    <div style="font-size:28px; font-weight:800; color:#92400E; margin-top:4px;">{{ $manualFallbackCards }}</div>
    <div style="font-size:11px; color:#B45309; margin-top:2px;">Aktif jika CSV belum ada / mode manual</div>
  </div>

  <div class="card-box" style="margin-bottom:0; padding:18px; border-left:4px solid #8B5CF6;">
    <div style="font-size:11.5px; font-weight:700; color:#6D28D9; text-transform:uppercase; letter-spacing:0.5px;">🔄 Sinkronisasi 2-Arah</div>
    <div style="font-size:28px; font-weight:800; color:#5B21B6; margin-top:4px;">Aktif</div>
    <div style="font-size:11px; color:#6D28D9; margin-top:2px;">Ubah kartu &rarr; CSV server ikut terupdate</div>
  </div>
</div>

<div class="card-box">
  <div class="card-box-header" style="flex-wrap:wrap; gap:12px;">
    <div>
      <h2>Daftar Kartu Statistik per Section (7 Section Dashboard)</h2>
      <p>Sistem memprioritaskan pembacaan rumus file CSV / Spreadsheet. Saat nilai kartu diubah dengan fitur 2-arah, sumber data CSV server otomatis ikut berubah.</p>
    </div>
    <div style="display:flex; gap:8px; flex-wrap:wrap;">
      <a href="{{ route('admin.page-data.index') }}" class="btn btn-outline-primary" style="font-size:12px;" target="_blank">
        📊 Buka Editor Spreadsheet Studio
      </a>

      <form action="{{ route('admin.stat-cards.sync-all') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-warning" title="Pindai ulang semua file CSV dan perbarui nilai metrik">
          🔄 Sinkronkan Semua dari CSV
        </button>
      </form>

      <a href="{{ route('admin.stat-cards.create') }}" class="btn btn-primary">
        ➕ Tambah Kartu Baru
      </a>
    </div>
  </div>

  @foreach($sections as $sec)
    @if($sec->statCards->count() > 0)
      <div style="margin-bottom:32px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; border-bottom:2px solid #EDF2F7; padding-bottom:8px;">
          <h3 style="font-size:14px; font-weight:800; color:var(--pln-blue); border-left:3px solid var(--pln-yellow); padding-left:10px;">
            Section {{ $sec->order }}: {{ $sec->title }}
          </h3>
          <span style="font-size:11.5px; color:var(--text-muted);">
            {{ $sec->statCards->count() }} Kartu Metrik
          </span>
        </div>

        <div class="table-responsive">
          <table class="data-table">
            <thead>
              <tr>
                <th style="width:45px;">Urutan</th>
                <th style="width:40px;">Ikon</th>
                <th>Judul &amp; Identifier</th>
                <th>Nilai Efektif Website</th>
                <th>Nilai Manual (Cadangan)</th>
                <th>Sumber Data &amp; Rumus</th>
                <th>Status Sinkron</th>
                <th style="text-align:right; width:190px;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($sec->statCards as $card)
              <tr id="row-card-{{ $card->id }}">
                <td><b>#{{ $card->order }}</b></td>
                <td style="font-size:22px; text-align:center;">{{ $card->icon ?? '📊' }}</td>
                <td>
                  <strong style="color:var(--text-main); font-size:13.5px;">{{ $card->title }}</strong>
                  @if($card->css_class)
                    <div style="font-size:10.5px; color:var(--text-muted); font-family:monospace;">ID: #{{ $card->css_class }}</div>
                  @endif
                </td>
                <td>
                  <!-- Nilai Efektif yang tampil di website -->
                  <div style="display:flex; align-items:baseline; gap:5px;">
                    <span style="font-weight:800; font-size:16px; color:var(--pln-blue-dark);" id="disp-val-{{ $card->id }}">
                      {{ $card->effective_value }}
                    </span>
                    <span style="font-size:11.5px; font-weight:600; color:var(--text-muted);" id="disp-unit-{{ $card->id }}">
                      {{ $card->effective_unit }}
                    </span>
                  </div>
                  @if($card->is_synced)
                    <span class="badge" style="background:#DCFCE7; color:#15803D; font-size:10px; margin-top:2px;">
                      🟢 Dari CSV
                    </span>
                  @else
                    <span class="badge" style="background:#FEF3C7; color:#B45309; font-size:10px; margin-top:2px;">
                      🟡 Fallback Manual
                    </span>
                  @endif
                  @if($card->effective_footer)
                    <div style="font-size:10.5px; color:#64748B; margin-top:3px; max-width:220px; line-height:1.2;" id="disp-foot-{{ $card->id }}">
                      {{ $card->effective_footer }}
                    </div>
                  @endif
                </td>
                <td>
                  <!-- Nilai Manual yang tersimpan di DB sebagai fallback -->
                  <div style="font-size:12px; font-weight:600; color:#475569;">
                    {{ $card->value ?? '-' }} <span style="font-size:10.5px; color:var(--text-muted);">{{ $card->unit }}</span>
                  </div>
                  <div style="font-size:10.5px; color:var(--text-muted); line-height:1.2;">
                    Cadangan bila CSV tidak terbaca
                  </div>
                </td>
                <td>
                  @if($card->csv_key || $card->dataSource)
                    <div style="font-size:11.5px; font-weight:700; color:var(--pln-blue);">
                      {{ $card->dataSource?->source_type === 'file' ? '📁' : '🌐' }}
                      {{ $card->dataSource->name ?? $card->csv_key }}
                    </div>
                    <div style="font-size:10px; color:#0369A1; font-weight:600;">
                      Tipe: {{ $card->dataSource?->source_type === 'file' ? 'File CSV Lokal Server' : 'Live Google Sheet' }}
                    </div>
                    <div style="font-size:11px; color:#475569; margin-top:2px;">
                      Cari: <code style="background:#F1F5F9; padding:2px 5px; border-radius:3px;">{{ $card->csv_search_query ?: $card->title }}</code>
                    </div>
                    @if($card->dataSource)
                      <div style="margin-top:4px;">
                        <a href="{{ route('admin.page-data.edit', $card->dataSource->key) }}" style="font-size:10.5px; color:var(--pln-blue); font-weight:600; text-decoration:underline;" target="_blank">
                          Edit Grid Spreadsheet &rarr;
                        </a>
                      </div>
                    @endif
                  @else
                    <span style="font-size:11.5px; color:var(--text-muted); font-style:italic;">
                      Murni Manual (Tanpa CSV)
                    </span>
                  @endif
                </td>
                <td>
                  @if($card->sync_status === 'synced')
                    <span class="badge badge-success" title="{{ $card->sync_notes }}">
                      ● Tersinkron
                    </span>
                  @elseif($card->sync_status === 'fallback_manual')
                    <span class="badge" style="background:#FEF3C7; color:#B45309;" title="{{ $card->sync_notes }}">
                      ⚠ Manual Aktif
                    </span>
                  @else
                    <span class="badge badge-info">
                      Belum dicek
                    </span>
                  @endif
                  @if($card->last_synced_at)
                    <div style="font-size:9.5px; color:var(--text-muted); margin-top:2px;">
                      {{ $card->last_synced_at->format('d/m/Y H:i') }}
                    </div>
                  @endif
                </td>
                <td style="text-align:right;">
                  <div style="display:inline-flex; gap:4px; align-items:center; flex-wrap:wrap; justify-content:flex-end;">
                    <!-- Tombol Ubah Cepat 2-Arah -->
                    <button type="button" class="btn btn-sm btn-success" style="font-size:11px; padding:4px 8px;" onclick="openQuickEditModal({{ json_encode([
                        'id' => $card->id,
                        'title' => $card->title,
                        'value' => $card->effective_value !== '-' ? $card->effective_value : ($card->value ?? ''),
                        'unit' => $card->effective_unit ?: ($card->unit ?? ''),
                        'footer_text' => $card->effective_footer ?: ($card->footer_text ?? ''),
                        'has_ds' => (bool) ($card->dataSource || $card->csv_key),
                        'ds_name' => $card->dataSource?->name ?? 'None',
                        'ds_type' => $card->dataSource?->source_type ?? 'none',
                        'is_asset' => (bool) ($sec->slug === 'aset'),
                    ]) }})" title="Ubah nilai ini dan langsung tuliskan ke file CSV / Spreadsheet secara 2-arah">
                      ⚡ 2-Arah
                    </button>

                    <form action="{{ route('admin.stat-cards.sync', $card) }}" method="POST" style="display:inline;">
                      @csrf
                      <button type="submit" class="btn btn-sm btn-secondary" title="Pindai ulang rumus dari CSV untuk kartu ini">
                        🔄
                      </button>
                    </form>

                    <a href="{{ route('admin.stat-cards.edit', $card) }}" class="btn btn-sm btn-primary" title="Edit konfigurasi rumus & nilai manual lengkap">
                      ✏️
                    </a>

                    <form action="{{ route('admin.stat-cards.destroy', $card) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kartu statistik \'{{ $card->title }}\'?')" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger" title="Hapus kartu">
                        🗑️
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    @endif
  @endforeach
</div>

<!-- MODAL QUICK EDIT SINKRONISASI 2-ARAH -->
<div id="quickEditModal" style="display:none; position:fixed; inset:0; z-index:9999; background:rgba(15,23,42,0.6); backdrop-filter:blur(3px); align-items:center; justify-content:center; padding:16px;">
  <div style="background:#fff; border-radius:12px; max-width:520px; width:100%; box-shadow:0 20px 40px rgba(0,0,0,0.3); overflow:hidden; border:1px solid #E2E8F0; animation:modalFadeIn .2s ease;">
    <div style="background:linear-gradient(135deg, var(--pln-blue-dark), var(--pln-blue)); color:#fff; padding:16px 20px; display:flex; justify-content:space-between; align-items:center;">
      <div style="display:flex; align-items:center; gap:8px;">
        <span style="font-size:20px;">🔄</span>
        <div>
          <h3 style="font-size:15px; font-weight:800; color:#fff; margin:0;" id="modalCardTitle">Ubah Nilai &amp; Sinkronkan Sumber Data</h3>
          <div style="font-size:11px; color:rgba(255,255,255,0.85);" id="modalCardSubtitle">Pembaruan 2-Arah (Kartu &harr; CSV / Spreadsheet)</div>
        </div>
      </div>
      <button type="button" onclick="closeQuickEditModal()" style="background:none; border:none; color:#fff; font-size:20px; cursor:pointer; line-height:1;">&times;</button>
    </div>

    <form id="quickEditForm" onsubmit="submitQuickEdit(event)" style="padding:20px;">
      <input type="hidden" id="modalCardId" name="card_id">

      <div style="background:#ECFDF5; border:1px solid #A7F3D0; border-radius:8px; padding:12px; margin-bottom:16px;">
        <label style="display:flex; align-items:flex-start; gap:10px; cursor:pointer; margin:0;">
          <input type="checkbox" id="modalSyncTwoWay" name="sync_two_way" value="1" checked style="width:18px; height:18px; margin-top:2px;">
          <div>
            <span style="font-size:12.5px; font-weight:700; color:#065F46;">
              Tulis juga nilai baru ini ke File CSV / Spreadsheet Sumber Data
            </span>
            <div style="font-size:11px; color:#047857; margin-top:2px;" id="modalDsInfo">
              Nilai akan ditimpa langsung ke baris/kolom data sumber server.
            </div>
          </div>
        </label>
      </div>

      <div style="display:grid; grid-template-columns:2fr 1fr; gap:12px; margin-bottom:14px;">
        <div class="form-group" style="margin-bottom:0;">
          <label for="modalValue" style="font-size:12px; font-weight:700;">Nilai Baru</label>
          <input type="text" id="modalValue" name="value" class="form-control" required style="font-size:16px; font-weight:800; color:var(--pln-blue-dark);">
        </div>
        <div class="form-group" style="margin-bottom:0;">
          <label for="modalUnit" style="font-size:12px; font-weight:700;">Satuan (Unit)</label>
          <input type="text" id="modalUnit" name="unit" class="form-control" placeholder="Unit, %, kms">
        </div>
      </div>

      <div class="form-group" style="margin-bottom:16px;">
        <label for="modalFooter" style="font-size:12px; font-weight:700;">Keterangan / Footer Kartu</label>
        <input type="text" id="modalFooter" name="footer_text" class="form-control" placeholder="Contoh: Realisasi Bulan Berjalan">
      </div>

      <div id="modalAlert" style="display:none; padding:10px 12px; border-radius:6px; font-size:12px; margin-bottom:14px;"></div>

      <div style="display:flex; justify-content:flex-end; gap:8px;">
        <button type="button" class="btn btn-secondary" onclick="closeQuickEditModal()">Batal</button>
        <button type="submit" class="btn btn-success" id="btnModalSubmit" style="font-weight:700;">
          💾 Simpan &amp; Terapkan 2-Arah
        </button>
      </div>
    </form>
  </div>
</div>

<style>
@keyframes modalFadeIn {
  from { opacity: 0; transform: translateY(-10px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection

@section('scripts')
<script>
let currentEditingCard = null;

function openQuickEditModal(card) {
  currentEditingCard = card;
  document.getElementById('modalCardId').value = card.id;
  document.getElementById('modalCardTitle').textContent = card.title;
  document.getElementById('modalValue').value = card.value;
  document.getElementById('modalUnit').value = card.unit || '';
  document.getElementById('modalFooter').value = card.footer_text || '';
  document.getElementById('modalSyncTwoWay').checked = true;
  document.getElementById('modalAlert').style.display = 'none';

  const dsInfo = document.getElementById('modalDsInfo');
  if (card.has_ds) {
    dsInfo.innerHTML = `Sumber: <b>${card.ds_name}</b> (${card.ds_type === 'file' ? '📁 File CSV Lokal' : '🌐 Google Sheet'}). Perubahan akan langsung disimpan ke server!`;
  } else {
    dsInfo.innerHTML = 'Kartu belum terhubung ke CSV (akan dibuatkan file CSV lokal otomatis).';
  }

  const modal = document.getElementById('quickEditModal');
  modal.style.display = 'flex';
  document.getElementById('modalValue').focus();
}

function closeQuickEditModal() {
  document.getElementById('quickEditModal').style.display = 'none';
}

function submitQuickEdit(e) {
  e.preventDefault();
  if (!currentEditingCard) return;

  const cardId = currentEditingCard.id;
  const val = document.getElementById('modalValue').value.trim();
  const unit = document.getElementById('modalUnit').value.trim();
  const footer = document.getElementById('modalFooter').value.trim();
  const syncTwoWay = document.getElementById('modalSyncTwoWay').checked ? 1 : 0;
  const btn = document.getElementById('btnModalSubmit');
  const alertEl = document.getElementById('modalAlert');

  btn.disabled = true;
  btn.textContent = 'Menyimpan & Menulis ke CSV...';
  alertEl.style.display = 'none';

  const url = "{{ url('admin/stat-cards') }}/" + cardId + "/quick-update";

  fetch(url, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json'
    },
    body: JSON.stringify({
      value: val,
      unit: unit,
      footer_text: footer,
      sync_two_way: syncTwoWay
    })
  })
  .then(res => res.json())
  .then(data => {
    btn.disabled = false;
    btn.textContent = '💾 Simpan & Terapkan 2-Arah';

    if (data.success) {
      // Update DOM table directly
      const dispVal = document.getElementById('disp-val-' + cardId);
      const dispUnit = document.getElementById('disp-unit-' + cardId);
      const dispFoot = document.getElementById('disp-foot-' + cardId);
      if (dispVal) dispVal.textContent = data.card.effective_value;
      if (dispUnit) dispUnit.textContent = data.card.effective_unit;
      if (dispFoot) dispFoot.textContent = data.card.effective_footer;

      closeQuickEditModal();

      // Show toast / alert
      alert('✅ ' + data.message + '\nNilai efektif: ' + data.card.effective_value + ' ' + (data.card.effective_unit || ''));
    } else {
      alertEl.style.display = 'block';
      alertEl.style.background = '#FEF2F2';
      alertEl.style.color = '#991B1B';
      alertEl.textContent = data.message || 'Gagal menyimpan perubahan.';
    }
  })
  .catch(err => {
    btn.disabled = false;
    btn.textContent = '💾 Simpan & Terapkan 2-Arah';
    alertEl.style.display = 'block';
    alertEl.style.background = '#FEF2F2';
    alertEl.style.color = '#991B1B';
    alertEl.textContent = 'Error: ' + err.message;
  });
}
</script>
@endsection
