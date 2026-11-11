@extends('admin.layout')

@section('page_title', 'Edit Sumber Data: ' . $dataSource->name)
@section('page_subtitle', 'Perbarui link Google Sheets, ganti file CSV lokal, atau ubah pengaturannya')

@section('content')
<div class="card-box" style="max-width:750px;">
  @if($errors->any())
    <div class="alert alert-error" style="display:block; margin-bottom:20px;">
      <ul style="padding-left:18px; margin:0;">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.data-sources.update', $dataSource) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-group">
      <label for="name">Nama Sumber Data</label>
      <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $dataSource->name) }}" required>
    </div>

    <div class="form-group">
      <label for="key">Kode Identifier Sistem (Key)</label>
      <input type="text" id="key" name="key" class="form-control" value="{{ old('key', $dataSource->key) }}" required style="font-family:monospace; font-weight:bold;">
      <div class="hint">Kode unik untuk diakses JavaScript frontend via <code>window.APP_DATA_SOURCES.{{ $dataSource->key }}</code>.</div>
    </div>

    <div class="form-group">
      <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
        <label style="margin:0;">Pilih Metode / Tipe Sumber Data</label>
        <button type="button" class="btn btn-sm" onclick="setSourceType('none')" style="background:#F1F5F9; color:#475569; border:1px solid #CBD5E1; font-size:11.5px; padding:3px 9px; border-radius:6px; cursor:pointer;">
          ✕ Kosongkan Pilihan Metode
        </button>
      </div>
      <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:10px; margin-top:6px;">
        <label style="border:1.5px solid var(--border-color); border-radius:10px; padding:12px; cursor:pointer; display:flex; align-items:flex-start; gap:8px; background:#F8FAFC;" id="labelTypeUrl">
          <input type="radio" name="source_type" value="url" id="typeUrl" {{ old('source_type', $dataSource->source_type ?? 'url') === 'url' ? 'checked' : '' }} onchange="onSourceTypeChange()" style="margin-top:3px;">
          <div>
            <div style="font-weight:700; font-size:12.5px; color:var(--pln-blue);">🌐 Google Sheets</div>
            <div style="font-size:11px; color:var(--text-muted); margin-top:2px;">Live realtime dari link spreadsheet.</div>
          </div>
        </label>

        <label style="border:1.5px solid var(--border-color); border-radius:10px; padding:12px; cursor:pointer; display:flex; align-items:flex-start; gap:8px; background:#F8FAFC;" id="labelTypeFile">
          <input type="radio" name="source_type" value="file" id="typeFile" {{ old('source_type', $dataSource->source_type) === 'file' ? 'checked' : '' }} onchange="onSourceTypeChange()" style="margin-top:3px;">
          <div>
            <div style="font-weight:700; font-size:12.5px; color:#059669;">📁 Upload File CSV</div>
            <div style="font-size:11px; color:var(--text-muted); margin-top:2px;">Gunakan file .csv fisik di server.</div>
          </div>
        </label>

        <label style="border:1.5px solid var(--border-color); border-radius:10px; padding:12px; cursor:pointer; display:flex; align-items:flex-start; gap:8px; background:#F8FAFC;" id="labelTypeNone">
          <input type="radio" name="source_type" value="none" id="typeNone" {{ old('source_type', $dataSource->source_type) === 'none' ? 'checked' : '' }} onchange="onSourceTypeChange()" style="margin-top:3px;">
          <div>
            <div style="font-weight:700; font-size:12.5px; color:#64748B;">🚫 Kosongkan</div>
            <div style="font-size:11px; color:var(--text-muted); margin-top:2px;">Tanpa sumber eksternal (mode manual).</div>
          </div>
        </label>
      </div>
    </div>

    <!-- BOX INPUT URL GOOGLE SHEETS -->
    <div id="boxUrl" class="form-group" style="background:#F0F7FF; border:1px solid #BAE6FD; border-radius:10px; padding:16px;">
      <label for="url" style="color:var(--pln-blue-dark);">URL Google Spreadsheet Terpublikasi (CSV)</label>
      <textarea id="url" name="url" class="form-control" rows="3" placeholder="https://docs.google.com/spreadsheets/d/e/.../pub?output=csv">{{ old('url', $dataSource->url) }}</textarea>
      <div class="hint" style="color:#0369A1;">Pastikan URL berakhiran <code>&output=csv</code> atau <code>/pub?output=csv</code>.</div>
    </div>

    <!-- BOX INPUT UPLOAD FILE LOKAL -->
    <div id="boxFile" class="form-group" style="background:#F0FDF4; border:1px solid #BBF7D0; border-radius:10px; padding:16px; display:none;">
      @if($dataSource->file_path)
        <div style="background:#fff; border:1px solid #86EFAC; border-radius:8px; padding:10px 14px; margin-bottom:12px;">
          <div style="display:flex; align-items:center; justify-content:space-between;">
            <div>
              <span style="font-size:11px; text-transform:uppercase; font-weight:700; color:#166534;">File Aktif di Server:</span>
              <div style="font-weight:700; font-size:13px; color:#15803D;">📄 {{ $dataSource->file_path }}</div>
            </div>
            <a href="{{ asset('uploads/data_sources/' . $dataSource->file_path) }}" target="_blank" class="btn btn-sm btn-secondary" style="text-decoration:none;">
              👁️ Lihat File ↗
            </a>
          </div>
          <div style="margin-top:8px; padding-top:8px; border-top:1px dashed #BBF7D0;">
            <label style="display:inline-flex; align-items:center; gap:6px; font-size:12px; color:#DC2626; cursor:pointer;">
              <input type="checkbox" name="clear_file" value="1">
              <span>🗑️ Hapus file CSV fisik ini dari server</span>
            </label>
          </div>
        </div>
      @endif

      <label for="csv_file" style="color:#166534;">
        {{ $dataSource->file_path ? 'Ganti dengan File CSV Baru (Opsional):' : 'Pilih File CSV dari Komputer:' }}
      </label>
      <input type="file" id="csv_file" name="csv_file" class="form-control" accept=".csv,.txt" style="background:#fff;">
      <div class="hint" style="color:#15803D;">Biarkan kosong jika tidak ingin mengganti file yang sudah ada. Maksimal 15 MB.</div>
    </div>

    <!-- BOX KOSONGKAN METODE -->
    <div id="boxNone" class="form-group" style="background:#F8FAFC; border:1px dashed #CBD5E1; border-radius:10px; padding:16px; display:none;">
      <div style="font-weight:700; color:#475569; font-size:13px; margin-bottom:4px;">
        🚫 Metode Sumber Data Dikosongkan
      </div>
      <div style="font-size:12px; color:var(--text-muted); line-height:1.5;">
        Sumber data ini tidak akan menarik data dari Google Sheets maupun file CSV lokal. Nilai ringkasan kartu statistik di dashboard akan menggunakan <b>pengisian nilai manual</b> yang tersimpan di database.
      </div>
      @if($dataSource->file_path || $dataSource->url)
        <div style="margin-top:8px; padding-top:8px; border-top:1px dashed #CBD5E1; font-size:11.5px; color:#64748B;">
          ℹ️ Menyimpan opsi <b>Kosongkan</b> akan otomatis membersihkan URL Google Sheets dan file CSV lokal sebelumnya.
        </div>
      @endif
    </div>

    <div class="form-group">
      <label for="description">Keterangan / Fungsi Data</label>
      <input type="text" id="description" name="description" class="form-control" value="{{ old('description', $dataSource->description) }}">
    </div>

    <div class="form-group" style="margin-top:14px; margin-bottom:24px;">
      <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $dataSource->is_active) ? 'checked' : '' }} style="width:18px; height:18px;">
        <span style="font-size:13px; font-weight:700;">Aktifkan sumber data ini di website</span>
      </label>
    </div>

    <div style="display:flex; gap:10px; border-top:1px solid var(--border-color); padding-top:18px;">
      <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      <a href="{{ route('admin.data-sources.index') }}" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection

@section('scripts')
<script>
  function setSourceType(type){
    if(type === 'url') document.getElementById('typeUrl').checked = true;
    else if(type === 'file') document.getElementById('typeFile').checked = true;
    else document.getElementById('typeNone').checked = true;
    onSourceTypeChange();
  }

  function onSourceTypeChange(){
    const isFile = document.getElementById('typeFile').checked;
    const isNone = document.getElementById('typeNone').checked;
    const boxUrl = document.getElementById('boxUrl');
    const boxFile = document.getElementById('boxFile');
    const boxNone = document.getElementById('boxNone');
    const labelUrl = document.getElementById('labelTypeUrl');
    const labelFile = document.getElementById('labelTypeFile');
    const labelNone = document.getElementById('labelTypeNone');

    if(isNone){
      boxUrl.style.display = 'none';
      boxFile.style.display = 'none';
      boxNone.style.display = 'block';
      labelNone.style.borderColor = '#64748B';
      labelNone.style.background = '#F1F5F9';
      labelUrl.style.borderColor = 'var(--border-color)';
      labelUrl.style.background = '#F8FAFC';
      labelFile.style.borderColor = 'var(--border-color)';
      labelFile.style.background = '#F8FAFC';
    } else if(isFile){
      boxUrl.style.display = 'none';
      boxFile.style.display = 'block';
      boxNone.style.display = 'none';
      labelFile.style.borderColor = '#10B981';
      labelFile.style.background = '#F0FDF4';
      labelUrl.style.borderColor = 'var(--border-color)';
      labelUrl.style.background = '#F8FAFC';
      labelNone.style.borderColor = 'var(--border-color)';
      labelNone.style.background = '#F8FAFC';
    } else {
      boxUrl.style.display = 'block';
      boxFile.style.display = 'none';
      boxNone.style.display = 'none';
      labelUrl.style.borderColor = 'var(--pln-blue)';
      labelUrl.style.background = '#F0F7FF';
      labelFile.style.borderColor = 'var(--border-color)';
      labelFile.style.background = '#F8FAFC';
      labelNone.style.borderColor = 'var(--border-color)';
      labelNone.style.background = '#F8FAFC';
    }
  }
  onSourceTypeChange();
</script>
@endsection
