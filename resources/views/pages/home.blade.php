@extends('layouts.app')

@section('title', 'DASHBOARD KINERJA — UPT MANADO')

@section('content')
<div class="container">

  <!-- 1. RINGKASAN KINERJA UNIT (NKO) -->
  @if(isset($sections['kinerja-unit']) && $sections['kinerja-unit']->is_visible)
  <div class="section-header-flex">
    <div>
      <h3 class="section-title" id="kinerja-unit">{{ $sections['kinerja-unit']->title }}</h3>
      @if($sections['kinerja-unit']->description)
        <p style="font-size:12px; color:var(--text-muted); margin:4px 0 0 14px;">{{ $sections['kinerja-unit']->description }}</p>
      @endif
    </div>
    <div class="month-filter-container">
      <label for="monthSelect">Periode Bulan:</label>
      <select id="monthSelect" class="month-select" onchange="onMonthChange()">
        <option value="">Memuat...</option>
      </select>
    </div>
  </div>
  <div class="grid-3">
    @php
      $nkoCards = $sections['kinerja-unit']->statCards ?? collect();
      $cardNko = $nkoCards->firstWhere('css_class', 'valNko') ?? $nkoCards->values()->get(0);
      $cardNkoCap = $nkoCards->firstWhere('css_class', 'valNkoCap') ?? $nkoCards->values()->get(1);
      $cardGap = $nkoCards->firstWhere('css_class', 'valGap') ?? $nkoCards->values()->get(2);
    @endphp
    <div class="card" style="text-align:center;">
      <div class="card-header-sm" id="titleNko">{{ $cardNko->title ?? 'NKO Bulan Berjalan' }}</div>
      <div class="card-value" id="valNko" style="font-size:34px;">{{ ($cardNko && $cardNko->effective_value !== '-') ? $cardNko->effective_value : '-' }} <span style="font-size:14px;font-weight:normal;">{{ $cardNko?->effective_unit ?: 'Poin' }}</span></div>
      <div class="card-footer-sm">{{ $cardNko?->effective_footer ?: 'Realisasi NKO Bulan Berjalan' }}</div>
    </div>
    <div class="card" style="text-align:center;">
      <div class="card-header-sm">{{ $cardNkoCap->title ?? 'NKO Max 110%' }}</div>
      <div class="card-value" id="valNkoCap" style="font-size:34px;">{{ ($cardNkoCap && $cardNkoCap->effective_value !== '-') ? $cardNkoCap->effective_value : '-' }} <span style="font-size:14px;font-weight:normal;">{{ $cardNkoCap?->effective_unit ?: 'Poin' }}</span></div>
      <div class="card-footer-sm">{{ $cardNkoCap?->effective_footer ?: 'Batas maksimal bobot 110%' }}</div>
    </div>
    <div class="card" id="cardGap" style="text-align:center; cursor:pointer;" onmouseenter="showGapTooltip()" onmouseleave="hideGapTooltip()">
      <div class="card-header-sm">{{ $cardGap->title ?? 'Gap Point' }}</div>
      <div class="card-value" id="valGap" style="font-size:34px;">{{ ($cardGap && $cardGap->effective_value !== '-') ? $cardGap->effective_value : '-' }} <span style="font-size:14px;font-weight:normal;">{{ $cardGap?->effective_unit ?: 'Poin' }}</span></div>
      <div class="card-footer-sm">{{ $cardGap?->effective_footer ?: 'Selisih pencapaian terhadap target' }}</div>
    </div>
  </div>
  @endif

  <!-- 2. RINGKASAN ASET UPT MANADO -->
  @if(isset($sections['aset']) && $sections['aset']->is_visible)
  <div class="section-header-flex" style="margin-top:35px; margin-bottom:10px;">
    <div>
      <h3 class="section-title" id="aset">{{ $sections['aset']->title }}</h3>
      @if($sections['aset']->description)
        <p style="font-size:12px; color:var(--text-muted); margin:4px 0 0 14px;">{{ $sections['aset']->description }}</p>
      @endif
    </div>
    <a href="{{ route('aset') }}" class="btn-detail-link" title="Buka Halaman Detail Aset Transmisi Lengkap">
      <span>Lihat Detail Aset &amp; Peta Lengkap</span>
      <span>&rarr;</span>
    </a>
  </div>
  <div id="map-sulut-gorontalo"></div>
  <div class="asset-cards-row">
    @php
      $assetCards = $sections['aset']->statCards ?? collect();
      $giCard = $assetCards->firstWhere('css_class', 'cardGI');
      $trafoCard = $assetCards->firstWhere('css_class', 'cardTrafo');
      $panjangCard = $assetCards->firstWhere('css_class', 'cardPanjang');
      $towerCard = $assetCards->firstWhere('css_class', 'cardTower');
      $jalurCard = $assetCards->firstWhere('css_class', 'cardJalur');
    @endphp

    <div class="asset-stat-card" id="cardGI">
      <div class="asset-stat-info">
        <h4>{{ $giCard->title ?? 'Jumlah Gardu Induk' }}</h4>
        <div class="num" id="statGiCount">{{ ($giCard && $giCard->effective_value !== '-') ? ($giCard->effective_value . ($giCard->effective_unit ? ' ' . $giCard->effective_unit : '')) : '-' }}</div>
      </div>
      <div class="asset-icon">{{ $giCard->icon ?? '🏢' }}</div>
      <div class="asset-tooltip"><div class="ttl">Rincian per ULTG</div><div class="tt-body">{{ $giCard?->effective_footer ?: 'Menunggu sumber data...' }}</div></div>
    </div>

    <div class="asset-stat-card" id="cardTrafo">
      <div class="asset-stat-info">
        <h4>{{ $trafoCard->title ?? 'Jumlah Trafo Daya' }}</h4>
        <div class="num">{{ ($trafoCard && $trafoCard->effective_value !== '-') ? ($trafoCard->effective_value . ($trafoCard->effective_unit ? ' ' . $trafoCard->effective_unit : '')) : '-' }}</div>
      </div>
      <div class="asset-icon">{{ $trafoCard->icon ?? '⚡' }}</div>
      <div class="asset-tooltip"><div class="ttl">Rincian per ULTG</div><div class="tt-body">{{ $trafoCard?->effective_footer ?: 'Menunggu sumber data...' }}</div></div>
    </div>

    <div class="asset-stat-card" id="cardPanjang">
      <div class="asset-stat-info">
        <h4>{{ $panjangCard->title ?? 'Panjang Transmisi' }}</h4>
        <div class="num">{{ ($panjangCard && $panjangCard->effective_value !== '-') ? ($panjangCard->effective_value . ($panjangCard->effective_unit ? ' ' . $panjangCard->effective_unit : '')) : '-' }}</div>
      </div>
      <div class="asset-icon">{{ $panjangCard->icon ?? '🔌' }}</div>
      <div class="asset-tooltip"><div class="ttl">Rincian per ULTG</div><div class="tt-body">{{ $panjangCard?->effective_footer ?: 'Menunggu sumber data...' }}</div></div>
    </div>

    <div class="asset-stat-card" id="cardTower">
      <div class="asset-stat-info">
        <h4>{{ $towerCard->title ?? 'Titik Tower Transmisi' }}</h4>
        <div class="num" id="statTowerCount">{{ ($towerCard && $towerCard->effective_value !== '-') ? ($towerCard->effective_value . ($towerCard->effective_unit ? ' ' . $towerCard->effective_unit : '')) : '-' }}</div>
      </div>
      <div class="asset-icon">{{ $towerCard->icon ?? '🗼' }}</div>
      <div class="asset-tooltip"><div class="ttl">Rincian per Jalur</div><div class="tt-body">{{ $towerCard?->effective_footer ?: 'Menunggu sumber data...' }}</div></div>
    </div>

    <div class="asset-stat-card" id="cardJalur">
      <div class="asset-stat-info">
        <h4>{{ $jalurCard->title ?? 'Jumlah Sirkit Transmisi' }}</h4>
        <div class="num" id="statLineCount">{{ ($jalurCard && $jalurCard->effective_value !== '-') ? ($jalurCard->effective_value . ($jalurCard->effective_unit ? ' ' . $jalurCard->effective_unit : '')) : '-' }}</div>
      </div>
      <div class="asset-icon">{{ $jalurCard->icon ?? '📡' }}</div>
      <div class="asset-tooltip"><div class="ttl">Rincian per ULTG</div><div class="tt-body">{{ $jalurCard?->effective_footer ?: 'Menunggu sumber data...' }}</div></div>
    </div>
  </div>
  @endif

  <!-- 3. RINGKASAN HEALTH INDEX PERALATAN -->
  @if(isset($sections['ahi']) && $sections['ahi']->is_visible)
  @php
    $ahiCards = $sections['ahi']->statCards ?? collect();
    $cMtu = $ahiCards->firstWhere('css_class', 'cardMtu') ?? $ahiCards->values()->get(0);
    $cRelay = $ahiCards->firstWhere('css_class', 'cardRelay') ?? $ahiCards->values()->get(1);
    $cJar = $ahiCards->firstWhere('css_class', 'cardJaringan') ?? $ahiCards->values()->get(2);
    $cIL3 = $ahiCards->firstWhere('css_class', 'cardIL3') ?? $ahiCards->values()->get(3);
  @endphp
  <div class="section-header-flex" style="margin-top:35px;">
    <h3 class="section-title" id="ahi" style="margin:0;">{{ $sections['ahi']->title }}</h3>
    <div style="font-size:12px; color:var(--text-muted);" id="ahiSyncStatus">Menyinkronkan data...</div>
  </div>
  @if($sections['ahi']->description)
    <p style="font-size:12px; color:var(--text-muted); margin-bottom:15px; padding-left:14px;">{{ $sections['ahi']->description }}</p>
  @endif
  <div class="grid-3">
    <div class="card" id="cardMtu">
      <div class="card-header-sm">{{ $cMtu->title ?? 'Kondisi Peralatan Utama (MTU)' }}</div>
      <div class="card-value">{{ ($cMtu && $cMtu->effective_value !== '-') ? $cMtu->effective_value : '-' }} <span style="font-size:14px;font-weight:normal;">{{ $cMtu?->effective_unit ?: 'Unit Diperiksa' }}</span></div>
      <div class="card-footer-sm">{{ $cMtu?->effective_footer ?: 'Memuat data...' }}</div>
    </div>
    <div class="card" id="cardRelay">
      <div class="card-header-sm">{{ $cRelay->title ?? 'Kondisi Proteksi (Relay)' }}</div>
      <div class="card-value">{{ ($cRelay && $cRelay->effective_value !== '-') ? $cRelay->effective_value : '-' }} <span style="font-size:14px;font-weight:normal;">{{ $cRelay?->effective_unit ?: 'Unit Diperiksa' }}</span></div>
      <div class="card-footer-sm">{{ $cRelay?->effective_footer ?: 'Memuat data...' }}</div>
    </div>
    <div class="card" id="cardJaringan">
      <div class="card-header-sm">{{ $cJar->title ?? 'Kondisi Jaringan' }}</div>
      <div class="card-value">{{ ($cJar && $cJar->effective_value !== '-') ? $cJar->effective_value : '-' }} <span style="font-size:14px;font-weight:normal;">{{ $cJar?->effective_unit ?: 'Tower Dinilai' }}</span></div>
      <div class="card-footer-sm">{{ $cJar?->effective_footer ?: 'Memuat data...' }}</div>
    </div>
    <div class="card" id="cardIL3">
      <div class="card-header-sm">{{ $cIL3->title ?? 'IL3 Power Inspect' }}</div>
      <div class="il3-bar-wrap"><div class="il3-bar-fill" id="il3BarFill" style="width:{{ min(100, floatval(str_replace(['%',' '],'',$cIL3?->effective_value ?: '0'))) }}%">
        <span id="il3BarLabel">{{ $cIL3?->effective_value ?: '-' }}</span>
      </div></div>
      <div class="card-footer-sm">{{ $cIL3?->effective_footer ?: 'Memuat data...' }}</div>
    </div>
  </div>
  @endif

  <!-- 4. RINGKASAN COMMON ENEMY -->
  @if(isset($sections['common-enemy']) && $sections['common-enemy']->is_visible)
  <div class="section-title" id="common-enemy" style="margin-top:35px; margin-bottom:6px;">{{ $sections['common-enemy']->title }}</div>
  @if($sections['common-enemy']->description)
    <p style="font-size:12px; color:var(--text-muted); margin-bottom:14px; padding-left:14px;">{{ $sections['common-enemy']->description }}</p>
  @endif
  @if(isset($sections['common-enemy']->statCards) && count($sections['common-enemy']->statCards) > 0)
    <div class="grid-3" style="margin-bottom:15px;">
      @foreach($sections['common-enemy']->statCards as $ceCard)
        <div class="card">
          <div class="card-header-sm">{{ $ceCard->icon ?? '🌲' }} {{ $ceCard->title }}</div>
          <div class="card-value">{{ $ceCard->effective_value }} <span style="font-size:14px;font-weight:normal;">{{ $ceCard->effective_unit }}</span></div>
          <div class="card-footer-sm">{{ $ceCard->effective_footer ?: $ceCard->description }}</div>
        </div>
      @endforeach
    </div>
  @endif
  <div class="grid-3" id="commonEnemyGrid">
    <div class="loading">Memuat ringkasan Common Enemy...</div>
  </div>
  @endif

  <!-- 5. RINGKASAN PROGRAM ANTI BLACKOUT -->
  @if(isset($sections['anti-blackout']) && $sections['anti-blackout']->is_visible)
  <div class="section-title" id="anti-blackout" style="margin-top:35px; margin-bottom:6px;">{{ $sections['anti-blackout']->title }}</div>
  @if($sections['anti-blackout']->description)
    <p style="font-size:12px; color:var(--text-muted); margin-bottom:14px; padding-left:14px;">{{ $sections['anti-blackout']->description }}</p>
  @endif
  @if(isset($sections['anti-blackout']->statCards) && count($sections['anti-blackout']->statCards) > 0)
    <div class="grid-3" style="margin-bottom:15px;">
      @foreach($sections['anti-blackout']->statCards as $aboCard)
        <div class="card">
          <div class="card-header-sm">{{ $aboCard->icon ?? '🛡️' }} {{ $aboCard->title }}</div>
          <div class="card-value">{{ $aboCard->effective_value }} <span style="font-size:14px;font-weight:normal;">{{ $aboCard->effective_unit }}</span></div>
          <div class="card-footer-sm">{{ $aboCard->effective_footer ?: $aboCard->description }}</div>
        </div>
      @endforeach
    </div>
  @endif
  <div class="grid-3" id="antiBlackoutGrid">
    <div class="loading">Memuat ringkasan Program Anti Blackout...</div>
  </div>
  @endif

  <!-- 6. RINGKASAN KONSTRUKSI DAN PENYALURAN -->
  @if(isset($sections['konstruksi']) && $sections['konstruksi']->is_visible)
  <div class="section-header-flex" style="margin-top:35px; margin-bottom:10px;">
    <div>
      <h3 class="section-title" id="konstruksi">{{ $sections['konstruksi']->title }}</h3>
      @if($sections['konstruksi']->description)
        <p style="font-size:12px; color:var(--text-muted); margin:4px 0 0 14px;">{{ $sections['konstruksi']->description }}</p>
      @endif
    </div>
    <a href="{{ route('konstruksi-penyaluran') }}" class="btn-detail-link" title="Buka Halaman Detail Konstruksi & Penyaluran">
      <span>Lihat Detail Konstruksi &amp; Penyaluran</span>
      <span>&rarr;</span>
    </a>
  </div>
  <div class="grid-3">
    @if(isset($sections['konstruksi']->statCards) && count($sections['konstruksi']->statCards) > 0)
      @foreach($sections['konstruksi']->statCards as $prog)
        <div class="ultg-card">
          <div class="ultg-title">{{ $prog->icon ?? '🏗️' }} {{ $prog->title }}</div>
          <div class="ultg-desc">{{ $prog->effective_footer ?: ($prog->description ?: 'Progres program...') }}</div>
          <div class="progress-wrap"><div class="progress-bar" style="width:{{ min(100, floatval(str_replace(['%',' '],'', $prog->effective_value))) }}%"></div></div>
          <div class="progress-label"><span>Progres</span><span>{{ $prog->effective_value }} {{ $prog->effective_unit }}</span></div>
        </div>
      @endforeach
    @elseif(isset($sections['konstruksi']->progressItems) && count($sections['konstruksi']->progressItems) > 0)
      @foreach($sections['konstruksi']->progressItems as $prog)
        <div class="ultg-card">
          <div class="ultg-title">{{ $prog->icon }} {{ $prog->title }}</div>
          <div class="ultg-desc">{{ $prog->description }}</div>
          <div class="progress-wrap"><div class="progress-bar" style="width:{{ $prog->percentage }}%"></div></div>
          <div class="progress-label"><span>Progres</span><span>{{ round($prog->percentage) }}%</span></div>
        </div>
      @endforeach
    @else
      <div class="ultg-card">
        <div class="ultg-title">🏗️ Progres Konstruksi SUTT/GI</div>
        <div class="ultg-desc">Persentase penyelesaian proyek konstruksi jaringan transmisi &amp; gardu induk yang sedang berjalan.</div>
        <div class="progress-wrap"><div class="progress-bar" style="width:68%"></div></div>
        <div class="progress-label"><span>Progres</span><span>68%</span></div>
      </div>
      <div class="ultg-card">
        <div class="ultg-title">🔗 Kesiapan Penyaluran (COD)</div>
        <div class="ultg-desc">Kesiapan penyaluran tenaga listrik dari pembangkit baru menuju jaringan sistem transmisi Sulutgo.</div>
        <div class="progress-wrap"><div class="progress-bar" style="width:82%"></div></div>
        <div class="progress-label"><span>Progres</span><span>82%</span></div>
      </div>
      <div class="ultg-card">
        <div class="ultg-title">📋 Serah Terima Aset (STO)</div>
        <div class="ultg-desc">Progres administrasi dan teknis serah terima operasi aset baru dari unit konstruksi ke unit transmisi.</div>
        <div class="progress-wrap"><div class="progress-bar" style="width:45%"></div></div>
        <div class="progress-label"><span>Progres</span><span>45%</span></div>
      </div>
    @endif
  </div>
  @endif

  <!-- 7. RINGKASAN KKU -->
  @if(isset($sections['kku']) && $sections['kku']->is_visible)
  <div class="section-header-flex" style="margin-top:35px; margin-bottom:10px;">
    <div>
      <h3 class="section-title" id="kku">{{ $sections['kku']->title }}</h3>
      @if($sections['kku']->description)
        <p style="font-size:12px; color:var(--text-muted); margin:4px 0 0 14px;">{{ $sections['kku']->description }}</p>
      @endif
    </div>
    <a href="{{ route('kku') }}" class="btn-detail-link" title="Buka Halaman Detail Kinerja Keuangan & Umum">
      <span>Buka Rincian Detail KKU</span>
      <span>&rarr;</span>
    </a>
  </div>
  <div class="grid-3">
    @php
      $kkuCards = $sections['kku']->statCards ?? collect();
      $cReal = $kkuCards->values()->get(0);
      $cTindak = $kkuCards->values()->get(1);
      $cKumul = $kkuCards->values()->get(2);
    @endphp

    <div class="card" id="cardKkuRealisasi">
      <div class="card-header-sm">{{ $cReal->title ?? 'Realisasi KKU Bulan Berjalan' }}</div>
      <div class="card-value" id="valKkuRealisasi">{{ ($cReal && $cReal->effective_value !== '-') ? ($cReal->effective_value . ($cReal->effective_unit ? ' ' . $cReal->effective_unit : '')) : '-' }}</div>
      <div class="card-footer-sm" id="footKkuRealisasi">{{ $cReal ? $cReal->effective_footer : 'Menunggu sumber data KKU' }}</div>
    </div>
    <div class="card" id="cardKkuTindakLanjut">
      <div class="card-header-sm">{{ $cTindak->title ?? 'Status Tindak Lanjut' }}</div>
      <div class="card-value" id="valKkuTindakLanjut">{{ ($cTindak && $cTindak->effective_value !== '-') ? ($cTindak->effective_value . ($cTindak->effective_unit ? ' ' . $cTindak->effective_unit : '')) : '-' }}</div>
      <div class="card-footer-sm" id="footKkuTindakLanjut">{{ $cTindak ? $cTindak->effective_footer : 'Menunggu sumber data KKU' }}</div>
    </div>
    <div class="card" id="cardKkuKumulatif">
      <div class="card-header-sm">{{ $cKumul->title ?? 'Capaian Kumulatif' }}</div>
      <div class="card-value" id="valKkuKumulatif">{{ ($cKumul && $cKumul->effective_value !== '-') ? ($cKumul->effective_value . ($cKumul->effective_unit ? ' ' . $cKumul->effective_unit : '')) : '-' }}</div>
      <div class="card-footer-sm" id="footKkuKumulatif">{{ $cKumul ? $cKumul->effective_footer : 'Menunggu sumber data KKU' }}</div>
    </div>
  </div>
  @endif

</div>
@endsection

@section('scripts')
<script src="{{ asset('tower-data.js?v=20261022') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.4.1/papaparse.min.js"></script>

<script>
  // 1. NKO — live fetch dari sheet "Progress Kinerja UPT"
  const STATE = {};
  const NKO_CSV_URL = window.APP_DATA_SOURCES.nko_csv;
  const MONTHS_ID = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
  const monthSelect = document.getElementById('monthSelect');
  let NKO_ACTIVE_IDX = 0;

  function parseID(numStr){
    if(!numStr) return null;
    const n = parseFloat(numStr.toString().replace(/\./g,'').replace(',', '.'));
    return isNaN(n) ? null : n;
  }

  function onMonthChange(){
    const idx = parseInt(monthSelect.value, 10);
    const data = (STATE.monthlyNko || {})[idx];
    if(data){
      renderNko(data, idx);
    } else {
      const vNko = document.getElementById('valNko');
      const vCap = document.getElementById('valNkoCap');
      const vGap = document.getElementById('valGap');
      const tNko = document.getElementById('titleNko');
      if(vNko) vNko.textContent = '-';
      if(vCap) vCap.textContent = '-';
      if(vGap) vGap.textContent = '-';
      if(tNko) tNko.textContent = 'NKO Bulan ' + MONTHS_ID[idx] + ' (belum tersedia)';
    }
  }

  function renderNko(data, idx){
    if(!data) return;
    const tNko = document.getElementById('titleNko');
    const vNko = document.getElementById('valNko');
    const vCap = document.getElementById('valNkoCap');
    const vGap = document.getElementById('valGap');
    if(tNko) tNko.textContent = 'NKO Bulan ' + MONTHS_ID[idx];
    if(vNko) vNko.innerHTML = `${data.total.toFixed(2)} <span style="font-size:14px;font-weight:normal;">Poin</span>`;
    if(vCap) vCap.innerHTML = `${data.total110.toFixed(2)} <span style="font-size:14px;font-weight:normal;">Poin</span>`;
    if(vGap) vGap.innerHTML = `${data.gap.toFixed(2)} <span style="font-size:14px;font-weight:normal;">Poin</span>`;
    window.__NKO_GAP_ITEMS__ = data.gapItems;
  }

  // Hover Tooltip Helper (Solid, Anti-Blink, Zero Dead-Zone)
  let hoverHideTimer = null;
  function cancelHoverHide(){
    if(hoverHideTimer){ clearTimeout(hoverHideTimer); hoverHideTimer = null; }
  }
  function scheduleHoverHide(hideFn){
    cancelHoverHide();
    hoverHideTimer = setTimeout(hideFn, 240);
  }
  function showFocusOn(el){
    const bd = document.getElementById('focusBackdrop');
    if(bd) bd.classList.add('active');
    document.querySelectorAll('.focus-highlight').forEach(other => {
      if(other !== el) other.classList.remove('focus-highlight');
    });
    if(el) el.classList.add('focus-highlight');
  }
  function hideFocusOn(el){
    const bd = document.getElementById('focusBackdrop');
    if(bd) bd.classList.remove('active');
    if(el) el.classList.remove('focus-highlight');
  }

  function positionTooltipNear(cardEl, tip){
    const rect = cardEl.getBoundingClientRect();
    const tipW = Math.max(rect.width, 280);
    tip.style.width = tipW + 'px';

    let left = rect.left;
    if(left + tipW > window.innerWidth - 16){
      left = window.innerWidth - tipW - 16;
    }
    if(left < 16) left = 16;
    tip.style.left = left + 'px';

    // Measure height accurately
    tip.style.visibility = 'hidden';
    tip.style.display = 'block';
    const tipH = tip.offsetHeight;
    tip.style.display = '';
    tip.style.visibility = '';

    const spaceBelow = window.innerHeight - rect.bottom;
    if(spaceBelow < tipH + 16 && rect.top > tipH + 16){
      tip.classList.remove('pos-below');
      tip.classList.add('pos-above');
      tip.style.top = Math.max(8, rect.top - tipH - 8) + 'px';
    }else{
      tip.classList.remove('pos-above');
      tip.classList.add('pos-below');
      tip.style.top = (rect.bottom + 8) + 'px';
    }

    tip.classList.add('active');
  }

  (function setupTooltipHoverGuard(){
    const tip = document.getElementById('cardHoverTooltip');
    if(!tip) return;
    tip.addEventListener('mouseenter', cancelHoverHide);
    tip.addEventListener('mouseleave', ()=>{
      scheduleHoverHide(()=>{
        tip.classList.remove('active');
        const bd = document.getElementById('focusBackdrop');
        if(bd) bd.classList.remove('active');
        document.querySelectorAll('.focus-highlight').forEach(el=>el.classList.remove('focus-highlight'));
      });
    });
  })();

  function showGapTooltip(){
    cancelHoverHide();
    const items = window.__NKO_GAP_ITEMS__ || [];
    const tip = document.getElementById('cardHoverTooltip');
    if(!tip) return;
    const rowsHtml = items.length
      ? items.map(it=>`<div class="cht-row"><span class="cht-name">${it.uraian}</span><span class="cht-vals under">-${it.gap.toFixed(3)} Poin</span></div>`).join('')
      : '<div style="font-size:12px;color:var(--text-muted);">Tidak ada item penyumbang gap poin.</div>';
    tip.innerHTML = `<div class="cht-title">Penyumbang Gap Point</div>${rowsHtml}`;
    const cardEl = document.getElementById('cardGap');
    if(!cardEl) return;
    positionTooltipNear(cardEl, tip);
    showFocusOn(cardEl);
  }
  function hideGapTooltip(){
    scheduleHoverHide(()=>{
      const tip = document.getElementById('cardHoverTooltip');
      if(tip) tip.classList.remove('active');
      hideFocusOn(document.getElementById('cardGap'));
    });
  }

  const BOBOT_BULANAN_START = 68;
  const BOBOT_110_BULANAN_START = 83;

  async function loadNko(){
    try{
      if(!monthSelect) return;
      if(!NKO_CSV_URL || !NKO_CSV_URL.trim()){
        const vNko = document.getElementById('valNko');
        const vCap = document.getElementById('valNkoCap');
        const vGap = document.getElementById('valGap');
        const tNko = document.getElementById('titleNko');
        if(vNko) vNko.innerHTML = `- <span style="font-size:14px;font-weight:normal;">Poin</span>`;
        if(vCap) vCap.innerHTML = `- <span style="font-size:14px;font-weight:normal;">Poin</span>`;
        if(vGap) vGap.innerHTML = `- <span style="font-size:14px;font-weight:normal;">Poin</span>`;
        if(tNko) tNko.textContent = 'NKO (Menunggu sumber data...)';
        monthSelect.innerHTML = '<option value="">-</option>';
        return;
      }
      const rows = await fetchCsvRows(NKO_CSV_URL);
      let monthCode = null, total = null, total110 = null, gap = null;
      let cutoffReached = false;

      const indicatorRows = [];
      rows.forEach(row=>{
        if(row.some(c => c && c.toString().includes('Perhitungan Persentase'))){ cutoffReached = true; }
        if(monthCode === null && row[19] === 'BULAN :') monthCode = row[20];
        if(row[2] === 'TOTAL'){ total = parseID(row[14]); total110 = parseID(row[15]); gap = parseID(row[17]); }
        else if(!cutoffReached && row[2] && row[2].trim() && row[16] && /[🟢🔴🟡🟣]/.test(row[16])){
          indicatorRows.push(row);
        }
      });

      const MONTHS_CODE = ['JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC'];
      let idx = MONTHS_CODE.indexOf((monthCode||'').trim().toUpperCase());
      NKO_ACTIVE_IDX = idx >= 0 ? idx : 0;

      STATE.monthlyNko = {};
      for(let m=0; m<=NKO_ACTIVE_IDX; m++){
        let sumBobotNilai = 0, sumBobotNilai110 = 0;
        const gapItems = [];
        const seenUraian = new Set();
        indicatorRows.forEach(row=>{
          const uraian = row[2].trim();
          if(seenUraian.has(uraian)) return;
          seenUraian.add(uraian);

          const bobotNilaiBulan = parseID(row[BOBOT_BULANAN_START + m]);
          const bobotNilai110Bulan = parseID(row[BOBOT_110_BULANAN_START + m]);
          if(bobotNilaiBulan !== null) sumBobotNilai += bobotNilaiBulan;
          if(bobotNilai110Bulan !== null) sumBobotNilai110 += bobotNilai110Bulan;

          const bobotTarget = parseFloat((row[7]||'').toString().replace(',', '.'));
          let itemGap = 0;
          if(!isNaN(bobotTarget)){
            if(bobotNilaiBulan !== null) itemGap = bobotTarget - bobotNilaiBulan;
          } else if(bobotNilaiBulan !== null && bobotNilaiBulan < 0){
            itemGap = -bobotNilaiBulan;
          }
          if(itemGap > 0.001){ gapItems.push({ uraian, gap: itemGap }); }
        });

        STATE.monthlyNko[m] = {
          total: (m === NKO_ACTIVE_IDX && total !== null) ? total : sumBobotNilai,
          total110: (m === NKO_ACTIVE_IDX && total110 !== null) ? total110 : sumBobotNilai110,
          gap: (m === NKO_ACTIVE_IDX && gap !== null) ? gap : Math.max(0, 100 - sumBobotNilai),
          gapItems: gapItems.sort((a,b)=>b.gap-a.gap)
        };
      }

      monthSelect.innerHTML = '';
      for(let i=0;i<=NKO_ACTIVE_IDX;i++){
        const opt = document.createElement('option');
        opt.value = i;
        opt.textContent = MONTHS_ID[i] + (i===NKO_ACTIVE_IDX ? ' (terbaru)' : '');
        monthSelect.appendChild(opt);
      }
      monthSelect.value = NKO_ACTIVE_IDX;

      renderNko(STATE.monthlyNko[NKO_ACTIVE_IDX], NKO_ACTIVE_IDX);

      const cardGap = document.getElementById('cardGap');
      if(cardGap){
        cardGap.addEventListener('mouseenter', showGapTooltip);
        cardGap.addEventListener('mouseleave', hideGapTooltip);
      }
    }catch(err){
      const t = document.getElementById('titleNko');
      if(t) t.textContent = 'NKO Bulan — Gagal memuat data';
    }
  }
  loadNko();

  // 3. RINGKASAN HEALTH INDEX PERALATAN (AHI)
  const AHI_CSV_URL = window.APP_DATA_SOURCES.ahi_csv;
  const MTU_LABELS = ["POWER TRANSFORMER","CIRCUIT BREAKER","CURRENT TRANSFORMER","POTENTIAL TRANSFORMER","LIGHTNING ARRESTER","DISCONNECTING SWITCH","CUBICLE 20 KV"];
  const RELAY_LABELS = ["DIFFERENTIAL TRAFO","DISTANCE / LINE DIFF","OCR / GFR HV","OCR / GFR LV","REF HV","REF LV","SBEF","BATERAI"];

  function num(v){ return parseFloat((v||'0').toString().replace(/,/g,'')) || 0; }

  function sumAhi(rows, labels, labelCol, ahiStartCol){
    let vg=0,g=0,f=0,p=0,c=0, total=0;
    labels.forEach(label=>{
      const row = rows.find(r => r[labelCol] && r[labelCol].trim() === label);
      if(!row) return;
      vg += num(row[ahiStartCol]); g += num(row[ahiStartCol+1]); f += num(row[ahiStartCol+2]);
      p += num(row[ahiStartCol+3]); c += num(row[ahiStartCol+4]);
    });
    total = vg+g+f+p+c;
    return { good: vg+g, fair: f, poor: p+c, total };
  }

  function renderAhiCard(cardId, stats){
    const card = document.getElementById(cardId);
    if(!card || !stats.total) return;
    const pct = n => stats.total ? Math.round(n/stats.total*100) : 0;
    card.querySelector('.card-value').innerHTML = `${stats.total.toLocaleString('id-ID')} <span style="font-size:14px;font-weight:normal;">Unit Diperiksa</span>`;
    card.querySelector('.card-footer-sm').innerHTML = `
      <div class="ahi-bar">
        <span style="width:${pct(stats.good)}%; background:#22C55E;"></span>
        <span style="width:${pct(stats.fair)}%; background:#EAB308;"></span>
        <span style="width:${pct(stats.poor)}%; background:#EF4444;"></span>
      </div>
      <div class="ahi-legend">
        <span>🟢 Good: <b>${stats.good} (${pct(stats.good)}%)</b></span>
        <span>🟡 Fair: <b>${stats.fair} (${pct(stats.fair)}%)</b></span>
        <span>🔴 Poor/Critical: <b>${stats.poor} (${pct(stats.poor)}%)</b></span>
      </div>`;
  }

  async function loadAhiData(){
    const syncEl = document.getElementById('ahiSyncStatus');
    if(!AHI_CSV_URL || !AHI_CSV_URL.trim()){
      if(syncEl) syncEl.textContent = 'Menunggu sumber data...';
      const mtuCard = document.getElementById('cardMtu');
      if(mtuCard){
        mtuCard.querySelector('.card-value').innerHTML = `- <span style="font-size:14px;font-weight:normal;">Unit Diperiksa</span>`;
        mtuCard.querySelector('.card-footer-sm').textContent = 'Menunggu sumber data...';
      }
      const relayCard = document.getElementById('cardRelay');
      if(relayCard){
        relayCard.querySelector('.card-value').innerHTML = `- <span style="font-size:14px;font-weight:normal;">Unit Diperiksa</span>`;
        relayCard.querySelector('.card-footer-sm').textContent = 'Menunggu sumber data...';
      }
      const cardIL3 = document.getElementById('cardIL3');
      if(cardIL3){
        const fill = document.getElementById('il3BarFill');
        const lbl = document.getElementById('il3BarLabel');
        if(fill) fill.style.width = '0%';
        if(lbl) lbl.textContent = '-';
        cardIL3.querySelector('.card-footer-sm').textContent = 'Menunggu sumber data...';
      }
      loadKondisiJaringan();
      return;
    }
    try{
      const rows = await fetchCsvRows(AHI_CSV_URL);
      const mtu = sumAhi(rows, MTU_LABELS, 2, 4);
      const relay = sumAhi(rows, RELAY_LABELS, 16, 18);
      renderAhiCard('cardMtu', mtu);
      renderAhiCard('cardRelay', relay);

      loadKondisiJaringan();

      const IL3_LABEL_COL = 81;
      const il3Row = rows.find(r => r[IL3_LABEL_COL] && r[IL3_LABEL_COL].trim() === 'UPT MANADO');
      const cardIL3 = document.getElementById('cardIL3');
      if(il3Row && cardIL3){
        const target = num(il3Row[IL3_LABEL_COL+1]), realisasi = num(il3Row[IL3_LABEL_COL+2]), pctStr = il3Row[IL3_LABEL_COL+3];
        const verif1 = num(il3Row[IL3_LABEL_COL+4]), verif2 = num(il3Row[IL3_LABEL_COL+6]), sudah = num(il3Row[IL3_LABEL_COL+8]);
        const pctNum = parseFloat(pctStr) || 0;
        document.getElementById('il3BarFill').style.width = Math.min(pctNum,100) + '%';
        document.getElementById('il3BarLabel').textContent = `${pctStr} (${realisasi}/${target} Input)`;
        cardIL3.querySelector('.card-footer-sm').innerHTML =
          `Verifikasi 1: <b>${verif1}</b> &nbsp;·&nbsp; Verifikasi 2: <b>${verif2}</b> &nbsp;·&nbsp; Terverifikasi: <b>${sudah}</b>`;
      }

      const tsRow = rows.find(r => r.some(c => c && /\d{1,2}\/\d{1,2}\/\d{4} \d{1,2}:\d{2}:\d{2}/.test(c)));
      let ts = null;
      if(tsRow) ts = tsRow.find(c => c && /\d{1,2}\/\d{1,2}\/\d{4} \d{1,2}:\d{2}:\d{2}/.test(c));
      if(syncEl) syncEl.textContent = ts ? ('Sinkron terakhir: ' + ts) : 'Data tersambung';
    }catch(e){
      console.warn('Gagal memuat data AHI:', e.message);
      if(syncEl) syncEl.textContent = 'Gagal sinkron data';
    }
  }
  loadAhiData();

  const TOWER_KONDISI_CSV_URL = window.APP_DATA_SOURCES.tower_kondisi_csv;
  async function loadKondisiJaringan(){
    const cardJar = document.getElementById('cardJaringan');
    if(!TOWER_KONDISI_CSV_URL || !TOWER_KONDISI_CSV_URL.trim()){
      if(cardJar){
        cardJar.querySelector('.card-value').innerHTML = `- <span style="font-size:14px;font-weight:normal;">Tower Dinilai</span>`;
        cardJar.querySelector('.card-footer-sm').textContent = 'Menunggu sumber data...';
      }
      return;
    }
    try{
      const rows = await fetchCsvRows(TOWER_KONDISI_CSV_URL, 30000);
      let normal=0, waspada=0, kritis=0;
      rows.forEach(r=>{
        const kondisi = (r[8]||'').trim().toUpperCase();
        if(kondisi === 'NORMAL') normal++;
        else if(kondisi === 'WASPADA') waspada++;
        else if(kondisi === 'KRITIS') kritis++;
      });
      const total = normal+waspada+kritis;
      if(cardJar && total){
        const pct = n => Math.round(n/total*100);
        cardJar.querySelector('.card-value').innerHTML = `${total.toLocaleString('id-ID')} <span style="font-size:14px;font-weight:normal;">Tower Dinilai</span>`;
        cardJar.querySelector('.card-footer-sm').innerHTML = `
          <div class="ahi-bar">
            <span style="width:${pct(normal)}%; background:#22C55E;"></span>
            <span style="width:${pct(waspada)}%; background:#EAB308;"></span>
            <span style="width:${pct(kritis)}%; background:#EF4444;"></span>
          </div>
          <div class="ahi-legend">
            <span>🟢 Normal: <b>${normal} (${pct(normal)}%)</b></span>
            <span>🟡 Waspada: <b>${waspada} (${pct(waspada)}%)</b></span>
            <span>🔴 Kritis: <b>${kritis} (${pct(kritis)}%)</b></span>
          </div>`;
      }
    }catch(e){
      if(cardJar) cardJar.querySelector('.card-footer-sm').textContent = 'Gagal memuat data';
    }
  }

  const ASSET_CSV_URL = window.APP_DATA_SOURCES.asset_csv;
  const ULTG_LABELS = ["ULTG Sawangan","ULTG Lopana","ULTG Kotamobagu","ULTG Gorontalo"];

  async function fetchCsvRows(url, timeoutMs){
    timeoutMs = timeoutMs || 20000;
    if(!url || !url.trim()) return [];
    // 1. Direct fetch
    try{
      const controller = new AbortController();
      const timer = setTimeout(()=>controller.abort(), timeoutMs);
      const res = await fetch(url, {cache:'no-store', signal: controller.signal});
      clearTimeout(timer);
      if(res.ok){
        const text = await res.text();
        return Papa.parse(text, {skipEmptyLines:false}).data;
      }
    }catch(err){
      console.warn('[Home fetch] Direct fetch failed for', url, err.message, 'trying proxy fallback...');
    }

    // 2. Proxy fallback for external URLs
    if(url.startsWith('http://') || url.startsWith('https://')){
      try{
        const proxyUrl = '/api/proxy-csv?url=' + encodeURIComponent(url);
        const res = await fetch(proxyUrl);
        if(res.ok){
          const text = await res.text();
          return Papa.parse(text, {skipEmptyLines:false}).data;
        }
      }catch(err){
        console.error('[Home fetch] Proxy fetch failed too:', err);
      }
    }
    throw new Error('Gagal mengambil data dari sumber');
  }

  function findAssetRow(rows, paramLabel){
    if(!rows || !rows.length) return null;
    const target = paramLabel.toLowerCase().trim();

    // 1. Deteksi dinamis letak kolom ULTG dan UPT Manado dari baris header jika tersedia
    let colSwg = 4, colLpn = 5, colKtg = 6, colGto = 7, colTotal = 8, colParam = 2;
    for(const r of rows){
      if(!r) continue;
      const rLower = r.map(c => (c||'').toString().toLowerCase());
      if(rLower.some(c => c.includes('sawangan')) && rLower.some(c => c.includes('upt manado') || c.includes('total'))){
        rLower.forEach((c, idx) => {
          if(c.includes('sawangan')) colSwg = idx;
          if(c.includes('lopana')) colLpn = idx;
          if(c.includes('kotamobagu')) colKtg = idx;
          if(c.includes('gorontalo')) colGto = idx;
          if(c.includes('upt manado') || c.includes('total')) colTotal = idx;
          if(c.includes('parameter')) colParam = idx;
        });
        break;
      }
    }

    const cleanNum = v => {
      if(v === null || v === undefined) return NaN;
      const s = v.toString().replace(/,/g, '').trim();
      if(s === '' || s === '-' || s === '#NAME?') return NaN;
      const n = parseFloat(s);
      return isNaN(n) ? NaN : n;
    };

    const ignoredKeywords = ['parameter', 'num', 'general information', 'filter 🔽', 'last update', ''];

    // 2. Cari baris data yang cocok dengan paramLabel
    for(const row of rows){
      if(!row) continue;

      let paramText = (row[colParam] || row[2] || row[1] || '').toString().trim().toLowerCase();
      if(ignoredKeywords.includes(paramText)) continue;

      let matched = false;
      if(paramText === target || paramText.includes(target) || (target.length >= 6 && target.includes(paramText) && paramText.length >= 4)){
        matched = true;
      } else {
        for(let i=1; i<=3; i++){
          const cell = (row[i]||'').toString().trim().toLowerCase();
          if(ignoredKeywords.includes(cell)) continue;
          if(cell === target || cell.includes(target) || (target.length >= 6 && target.includes(cell) && cell.length >= 4)){
            matched = true;
            break;
          }
        }
      }

      if(!matched) continue;

      // Pastikan baris ini memiliki nilai total yang valid (angka numerik, bukan label kolom)
      const rawTotal = (row[colTotal] !== undefined && row[colTotal] !== '') ? row[colTotal] : row[8];
      const totalNum = cleanNum(rawTotal);
      if(isNaN(totalNum)) continue;

      const toVal = v => {
        const n = cleanNum(v);
        return isNaN(n) ? 0 : n;
      };

      return {
        values: [toVal(row[colSwg]), toVal(row[colLpn]), toVal(row[colKtg]), toVal(row[colGto])],
        total: totalNum
      };
    }
    return null;
  }

  function fillAssetCard(cardId, data, unitLabel, isDecimal){
    const card = document.getElementById(cardId);
    if(!card || !data || data.total === null || isNaN(data.total) || data.total <= 0) return;
    const fmt = n => isDecimal ? n.toLocaleString('id-ID',{minimumFractionDigits:2,maximumFractionDigits:2}) : n.toLocaleString('id-ID');
    const numEl = card.querySelector('.num');
    if(numEl) numEl.textContent = fmt(data.total) + ' ' + unitLabel;
    const rowsHtml = ULTG_LABELS.map((label,i)=>
      `<tr><td>${label.replace('ULTG ','')}</td><td style="text-align:right;">${fmt(data.values[i])}</td></tr>`
    ).join('');
    const tt = card.querySelector('.asset-tooltip .tt-body');
    if(tt){
      tt.innerHTML = `
        <table><thead><tr><th>ULTG</th><th style="text-align:right;">${unitLabel}</th></tr></thead>
        <tbody>${rowsHtml}<tr style="font-weight:700;"><td>UPT Manado</td><td style="text-align:right;">${fmt(data.total)}</td></tr></tbody></table>`;
    }
  }

  async function loadAssetData(){
    if(!ASSET_CSV_URL || !ASSET_CSV_URL.trim()){
      ['cardGI', 'cardTrafo', 'cardPanjang', 'cardTower', 'cardJalur'].forEach(id=>{
        const c = document.getElementById(id);
        if(c){
          const num = c.querySelector('.num');
          if(num) num.textContent = '-';
          const tt = c.querySelector('.asset-tooltip .tt-body');
          if(tt) tt.textContent = 'Menunggu sumber data...';
        }
      });
      return;
    }
    try{
      const rows = await fetchCsvRows(ASSET_CSV_URL);
      const gi = findAssetRow(rows, 'Num of Sustation (unit)') || findAssetRow(rows, 'Sustation') || findAssetRow(rows, 'Substation');
      if(gi && gi.total > 0){
        window.__GI_POPULATED_FROM_ASSET_CSV__ = true;
        fillAssetCard('cardGI', gi, 'Unit', false);
      }
      const trafo = findAssetRow(rows, 'Total of Transformer (unit)');
      if(trafo && trafo.total > 0) fillAssetCard('cardTrafo', trafo, 'Unit', false);

      const panjang = findAssetRow(rows, 'Length of Circuit (kms)');
      if(panjang && panjang.total > 0) fillAssetCard('cardPanjang', panjang, 'kms', true);

      const tower = findAssetRow(rows, 'Num of Tower (tower)');
      if(tower && tower.total > 0){
        window.__TOWER_POPULATED_FROM_ASSET_CSV__ = true;
        fillAssetCard('cardTower', tower, 'Tower', false);
      }

      const sirkit = findAssetRow(rows, 'Total Circuit by Age (circuit)');
      if(sirkit && sirkit.total > 0) fillAssetCard('cardJalur', sirkit, 'Sirkit', false);

      const jalurHeader = document.querySelector('#cardJalur h4');
      if(jalurHeader) jalurHeader.textContent = 'Jumlah Sirkit Transmisi';
    }catch(e){
      console.warn('Gagal memuat data aset dari sheet:', e.message);
    }
  }
  loadAssetData();

  // GIS Leaflet Map
  let mapEl = document.getElementById('map-sulut-gorontalo');
  let map, towerMarkerLayer, giLayer;
  let homeTileLight, homeTileDark, currentHomeTile;
  const darkHomeTileUrl = 'https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Dark_Gray_Base/MapServer/tile/{z}/{y}/{x}';
  const lightHomeTileUrl = 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}';

  if(mapEl){
    map = L.map('map-sulut-gorontalo', {preferCanvas:true, maxZoom:20}).setView([1.1, 123.9], 8);
    window.__homeMap = map;

    homeTileLight = L.tileLayer(lightHomeTileUrl, {
      maxNativeZoom: 17,
      maxZoom: 20,
      attribution: '&copy; Esri, HERE, Garmin, &copy; OpenStreetMap contributors | PT PLN (Persero) UPT Manado'
    });

    homeTileDark = L.tileLayer(darkHomeTileUrl, {
      maxNativeZoom: 16,
      maxZoom: 20,
      attribution: '&copy; Esri, HERE, Garmin, &copy; OpenStreetMap contributors | PT PLN (Persero) UPT Manado'
    });

    const isDarkHome = document.documentElement.getAttribute('data-theme') === 'dark';
    currentHomeTile = isDarkHome ? homeTileDark : homeTileLight;
    currentHomeTile.addTo(map);

    // Otomatis ganti basemap peta saat dark/light mode diubah
    const themeObserver = new MutationObserver(()=>{
      if(!map) return;
      const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
      const targetTile = isDark ? homeTileDark : homeTileLight;
      if(currentHomeTile !== targetTile){
        if(currentHomeTile && map.hasLayer(currentHomeTile)){
          map.removeLayer(currentHomeTile);
        }
        currentHomeTile = targetTile;
        currentHomeTile.addTo(map);
        currentHomeTile.bringToBack();
      }
    });
    themeObserver.observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });

    const VOLTAGE_COLOR = { 150:'#E53E3E', 70:'#F97316' };
    const LINE_70KV = new Set([
      'TGR1-SWG','TGR2-SWG','SWG-RMT','TNSLM-SWG','TNSLM-TMH','TNSLM-PLTA',
      'TMH-TLG','TMH-TSK','RMT-TLG','SWG-BTG','BTG-LKP'
    ]);
    function voltageOf(lineName){ return LINE_70KV.has(lineName) ? 70 : 150; }

    const allBounds = [];
    const TOWER_ZOOM_THRESHOLD = 12;
    towerMarkerLayer = L.layerGroup();
    giLayer = L.layerGroup().addTo(map);

    function triangleIcon(color){
      return L.divIcon({
        className:'',
        html:`<svg width="10" height="9" viewBox="0 0 20 18" style="filter:drop-shadow(0 1px 2px rgba(0,0,0,0.5));">
                <polygon points="10,0 20,18 0,18" fill="${color}" stroke="#fff" stroke-width="1.5"/>
              </svg>`,
        iconSize:[10,9], iconAnchor:[5,8]
      });
    }

    if(typeof TOWER_LINES !== 'undefined'){
      Object.keys(TOWER_LINES).forEach(lineName=>{
        const pts = TOWER_LINES[lineName];
        const latlngs = pts.map(p=>[p[0], p[1]]);
        const voltage = voltageOf(lineName);
        const color = VOLTAGE_COLOR[voltage];

        L.polyline(latlngs, {color, weight:2.5, opacity:0.85}).addTo(map)
          .bindPopup(`<b>${lineName}</b><br>Sistem: ${voltage} kV<br>${pts.length} titik tower`);

        pts.forEach(p=>{
          L.circleMarker([p[0], p[1]], {radius:3, fillColor:color, color:'#fff', weight:0.6, opacity:1, fillOpacity:0.9})
            .bindPopup(`<b>${p[2]}</b><br>Jalur: ${lineName} (${voltage} kV)<br>${p[0]}, ${p[1]}`)
            .addTo(towerMarkerLayer);
        });

        allBounds.push(...latlngs);
      });

      if(allBounds.length) map.fitBounds(allBounds, {padding:[20,20]});

      if(!window.__TOWER_POPULATED_FROM_ASSET_CSV__ && ASSET_CSV_URL && ASSET_CSV_URL.trim()){
        const sTower = document.getElementById('statTowerCount');
        if(sTower && (!sTower.textContent || sTower.textContent.includes('0 Tower') || sTower.textContent.trim() === '-')){
          sTower.textContent =
            Object.values(TOWER_LINES).reduce((sum,pts)=>sum+pts.length,0).toLocaleString('id-ID') + ' Tower';
        }
      }
      if(ASSET_CSV_URL && ASSET_CSV_URL.trim()){
        const sLine = document.getElementById('statLineCount');
        if(sLine && (!sLine.textContent || sLine.textContent.includes('0') || sLine.textContent.trim() === '-')){
          sLine.textContent = Object.keys(TOWER_LINES).length + ' Jalur';
        }
      }
    }

    function refreshTowerVisibility(){
      if(map.getZoom() >= TOWER_ZOOM_THRESHOLD){
        if(!map.hasLayer(towerMarkerLayer)) towerMarkerLayer.addTo(map);
      }else{
        if(map.hasLayer(towerMarkerLayer)) map.removeLayer(towerMarkerLayer);
      }
    }
    map.on('zoomend', refreshTowerVisibility);
    refreshTowerVisibility();
  }

  // Gardu Induk
  const GI_CSV_URL = window.APP_DATA_SOURCES.gi_csv;
  async function loadGiMarkers(){
    if(!giLayer) return;
    if(!GI_CSV_URL || !GI_CSV_URL.trim()) return;
    try{
      const rows = await fetchCsvRows(GI_CSV_URL, 20000);
      const giList = [];
      rows.forEach(row=>{
        if((row[1]||'').trim() !== 'GARDU INDUK') return;
        const induk = (row[2]||'').trim();
        const ultg = (row[3]||'').trim();
        const nama = (row[4]||'').trim();
        const tegStr = (row[5]||'').trim();
        const lat = parseFloat(row[6]);
        const lng = parseFloat(row[7]);
        if(!nama || isNaN(lat) || isNaN(lng)) return;
        giList.push({nama, ultg, induk, tegStr, lat, lng});
      });

      const coordGroups = {};
      giList.forEach(gi=>{
        const key = gi.lat.toFixed(5) + ',' + gi.lng.toFixed(5);
        (coordGroups[key] = coordGroups[key] || []).push(gi);
      });

      let count = 0;
      Object.values(coordGroups).forEach(group=>{
        const isDuplicateGroup = group.length > 1;
        group.forEach((gi, i)=>{
          let lat = gi.lat, lng = gi.lng;
          if(isDuplicateGroup){
            const angle = (2*Math.PI*i)/group.length;
            const r = 0.012;
            lat += r * Math.cos(angle);
            lng += r * Math.sin(angle);
          }
          const voltage = parseInt(gi.tegStr) || 150;
          const color = { 150:'#E53E3E', 70:'#F97316' }[voltage] || '#E53E3E';
          const warn = isDuplicateGroup ? '<br><span style="color:#E53E3E;font-size:11px;">⚠ Koordinat sementara</span>' : '';
          
          function triangleIcon2(col){
            return L.divIcon({
              className:'',
              html:`<svg width="10" height="9" viewBox="0 0 20 18" style="filter:drop-shadow(0 1px 2px rgba(0,0,0,0.5));">
                      <polygon points="10,0 20,18 0,18" fill="${col}" stroke="#fff" stroke-width="1.5"/>
                    </svg>`,
              iconSize:[10,9], iconAnchor:[5,8]
            });
          }

          L.marker([lat, lng], {icon:triangleIcon2(color)})
            .addTo(giLayer)
            .bindPopup(`<b>${gi.nama}</b><br>Sistem: ${gi.tegStr}${gi.ultg ? '<br>'+gi.ultg : ''}${warn}`);

          const ultgLower = (gi.ultg||'').toLowerCase();
          const isUptManado = ULTG_LABELS.some(label => ultgLower.includes(label.replace('ULTG ','').toLowerCase()));
          if(isUptManado) count++;
        });
      });

      if(!window.__GI_POPULATED_FROM_ASSET_CSV__ && ASSET_CSV_URL && ASSET_CSV_URL.trim()){
        const sGi = document.getElementById('statGiCount');
        if(sGi) sGi.textContent = count + ' Unit';

        const ultgCounts = ULTG_LABELS.map(label=>{
          const key = label.replace('ULTG ','').toLowerCase();
          return giList.filter(gi => (gi.ultg||'').toLowerCase().includes(key)).length;
        });
        const kitCount = giList.filter(gi => (gi.ultg||'').toLowerCase().includes('kit')).length;
        const kttCount = giList.filter(gi => (gi.ultg||'').toLowerCase().includes('ktt')).length;
        const giCard = document.getElementById('cardGI');
        if(giCard){
          const rowsHtml = ULTG_LABELS.map((label,i)=>
            `<tr><td>${label.replace('ULTG ','')}</td><td style="text-align:right;">${ultgCounts[i]}</td></tr>`
          ).join('');
          const tt = giCard.querySelector('.asset-tooltip .tt-body');
          if(tt) tt.innerHTML = `
            <table><thead><tr><th>ULTG</th><th style="text-align:right;">Unit</th></tr></thead>
            <tbody>${rowsHtml}<tr style="font-weight:700;"><td>UPT Manado</td><td style="text-align:right;">${count}</td></tr>
            <tr><td>GI Pembangkit (KIT)</td><td style="text-align:right;">${kitCount}</td></tr>
            <tr><td>GI Pelanggan (KTT)</td><td style="text-align:right;">${kttCount}</td></tr>
            </tbody></table>`;
        }
      }
    }catch(e){ }
  }
  loadGiMarkers();

  // 4 & 5. Common Enemy & Program Anti Blackout
  const COMMON_ENEMY_URL = window.APP_DATA_SOURCES.common_enemy_csv;
  const ANTI_BLACKOUT_URL = window.APP_DATA_SOURCES.anti_blackout_csv;

  function parsePct(str){
    if(!str) return null;
    const s = str.toString().trim();
    if(s === '--' || s === '') return null;
    const n = parseFloat(s.replace('%','').replace(',','.'));
    return isNaN(n) ? null : n;
  }

  function showCardTooltip(cardEl, groupName, allItems){
    cancelHoverHide();
    const tip = document.getElementById('cardHoverTooltip');
    if(!tip) return;
    const rowsHtml = allItems.map(it=>{
      const cls = (it.pct !== null && it.pct < 100) ? 'under' : '';
      return `<div class="cht-row"><span class="cht-name">${it.name}</span><span class="cht-vals ${cls}">${it.realisasi}/${it.target} ${it.satuan}</span></div>`;
    }).join('');
    tip.innerHTML = `<div class="cht-title">${groupName} — Seluruh Program Kerja</div>${rowsHtml || '<div style="font-size:12px;color:var(--text-muted);">Tidak ada item.</div>'}`;
    positionTooltipNear(cardEl, tip);
    showFocusOn(cardEl);
  }

  function hideCardTooltip(){
    scheduleHoverHide(()=>{
      const tip = document.getElementById('cardHoverTooltip');
      if(tip) tip.classList.remove('active');
      const bd = document.getElementById('focusBackdrop');
      if(bd) bd.classList.remove('active');
      document.querySelectorAll('.ultg-card.focus-highlight').forEach(el=>el.classList.remove('focus-highlight'));
    });
  }

  function attachCardHover(cardEl, groupName, allItems){
    cardEl.addEventListener('mouseenter', ()=>showCardTooltip(cardEl, groupName, allItems));
    cardEl.addEventListener('mouseleave', hideCardTooltip);
  }

  function renderUnderachievedList(items){
    if(!items.length) return '<div style="font-size:12px; color:var(--text-muted); margin-top:8px;">Semua item sudah tercapai (≥100%).</div>';
    const rowsHtml = items.map(it=>`<div class="underach-item">
        <span class="underach-name">${it.name}</span>
        <span class="underach-vals">${it.realisasi}/${it.target} ${it.satuan} <b>${it.pct===null?'-':it.pct.toFixed(0)+'%'}</b></span>
      </div>`).join('');
    return `<div class="underach-list">${rowsHtml}</div>`;
  }

  const STREAM_ICON = {
    'SUTT/SUTET':'🗼','Trafo':'⚡','Switchyard':'🔌','GIS':'🏭','Medium Voltage (MV)':'🔋',
    'Proteksi':'🛡️','Catu Daya':'🔋','Common Facility':'🏢'
  };

  function buildConclusion(avg, statusCounts, total){
    const late = (statusCounts['Late']||0) + (statusCounts['Tidak Tercapai']||0);
    const caution = (statusCounts['Hati-hati']||0);
    if(avg === null) return `${total} program kerja, capaian belum dapat dihitung.`;
    if(avg >= 100) return `Baik — capaian rata-rata ${avg.toFixed(0)}% dari ${total} program, mayoritas sudah tercapai/on target.`;
    if(avg >= 85) return `Cukup baik — capaian rata-rata ${avg.toFixed(0)}%${late ? `, ${late} program masih perlu dikejar` : ''}.`;
    return `Perlu perhatian — capaian rata-rata ${avg.toFixed(0)}%, ${late} program berstatus Late/Tidak Tercapai${caution ? ` dan ${caution} Hati-hati` : ''}.`;
  }

  async function loadCommonEnemy(){
    const grid = document.getElementById('commonEnemyGrid');
    if(!grid) return;
    if(!COMMON_ENEMY_URL || !COMMON_ENEMY_URL.trim()){
      grid.innerHTML = '<div class="loading" style="color:var(--text-muted);">Menunggu sumber data Common Enemy...</div>';
      return;
    }
    try{
      const rows = await fetchCsvRows(COMMON_ENEMY_URL, 20000);
      const streams = {};
      rows.forEach(row=>{
        const stream = (row[3]||'').trim();
        if(!stream || !/^[0-9]+$/.test((row[0]||'').trim())) return;
        if(!streams[stream]) streams[stream] = { pcts:[], status:{}, total:0, items:[] };
        const pct = parsePct(row[12]);
        if(pct !== null) streams[stream].pcts.push(pct);
        const status = (row[13]||'').trim();
        if(status) streams[stream].status[status] = (streams[stream].status[status]||0) + 1;
        streams[stream].total++;
        streams[stream].items.push({
          name: (row[4]||'').trim(), satuan: (row[5]||'').trim(),
          target: row[9]||'0', realisasi: row[11]||'0', pct, status
        });
      });

      grid.innerHTML = '';
      Object.keys(streams).forEach((stream)=>{
        const s = streams[stream];
        const avg = s.pcts.length ? s.pcts.reduce((a,b)=>a+b,0)/s.pcts.length : null;
        const barPct = avg === null ? 0 : Math.min(100, avg);
        const conclusion = buildConclusion(avg, s.status, s.total);
        const underachieved = s.items.filter(it => it.pct !== null && it.pct < 100);
        const card = document.createElement('div');
        card.className = 'ultg-card';
        card.innerHTML = `
          <div class="ultg-title">${STREAM_ICON[stream]||'⚙️'} ${stream}</div>
          <div class="ultg-desc">${conclusion}</div>
          <div class="progress-wrap"><div class="progress-bar" style="width:${barPct}%"></div></div>
          <div class="progress-label"><span>Capaian rata-rata</span><span>${avg===null?'-':avg.toFixed(0)+'%'}</span></div>
          ${renderUnderachievedList(underachieved)}`;
        grid.appendChild(card);
        attachCardHover(card, stream, s.items);
      });
      if(!grid.children.length) grid.innerHTML = '<div class="loading">Tidak ada data Stream terbaca.</div>';
    }catch(e){
      grid.innerHTML = '<div class="loading">Gagal memuat data Common Enemy.</div>';
    }
  }
  loadCommonEnemy();

  const SUBINIT_ICON = {
    'Jaringan - Anti Blackout':'🗼','Gardu Induk - Anti Blackout':'🏭','Proteksi - Anti Blackout':'🛡️'
  };
  const SUBINIT_LABEL = {
    'Jaringan - Anti Blackout':'Transmisi','Gardu Induk - Anti Blackout':'Gardu Induk','Proteksi - Anti Blackout':'Proteksi'
  };

  async function loadAntiBlackout(){
    const grid = document.getElementById('antiBlackoutGrid');
    if(!grid) return;
    if(!ANTI_BLACKOUT_URL || !ANTI_BLACKOUT_URL.trim()){
      grid.innerHTML = '<div class="loading" style="color:var(--text-muted);">Menunggu sumber data Program Anti Blackout...</div>';
      return;
    }
    try{
      const rows = await fetchCsvRows(ANTI_BLACKOUT_URL, 20000);
      const subs = {};
      rows.forEach(row=>{
        const sub = (row[2]||'').trim();
        if(!sub || !/^[0-9]+$/.test((row[0]||'').trim())) return;
        if(!subs[sub]) subs[sub] = { pcts:[], status:{}, total:0, items:[] };
        const pct = parsePct(row[58]);
        if(pct !== null) subs[sub].pcts.push(pct);
        const status = (row[59]||'').trim();
        if(status) subs[sub].status[status] = (subs[sub].status[status]||0) + 1;
        subs[sub].total++;
        subs[sub].items.push({
          name: (row[3]||'').trim(), satuan: (row[4]||'').trim(),
          target: row[55]||'0', realisasi: row[57]||'0', pct, status
        });
      });

      grid.innerHTML = '';
      Object.keys(subs).forEach((sub)=>{
        const s = subs[sub];
        const avg = s.pcts.length ? s.pcts.reduce((a,b)=>a+b,0)/s.pcts.length : null;
        const barPct = avg === null ? 0 : Math.min(100, avg);
        const conclusion = buildConclusion(avg, s.status, s.total);
        const underachieved = s.items.filter(it => it.pct !== null && it.pct < 100);
        const card = document.createElement('div');
        card.className = 'ultg-card';
        card.innerHTML = `
          <div class="ultg-title">${SUBINIT_ICON[sub]||'⚙️'} ${SUBINIT_LABEL[sub]||sub}</div>
          <div class="ultg-desc">${conclusion}</div>
          <div class="progress-wrap"><div class="progress-bar" style="width:${barPct}%"></div></div>
          <div class="progress-label"><span>Capaian rata-rata</span><span>${avg===null?'-':avg.toFixed(0)+'%'}</span></div>
          ${renderUnderachievedList(underachieved)}`;
        grid.appendChild(card);
        attachCardHover(card, SUBINIT_LABEL[sub]||sub, s.items);
      });
      if(!grid.children.length) grid.innerHTML = '<div class="loading">Tidak ada data Sub Initiative terbaca.</div>';
    }catch(e){
      grid.innerHTML = '<div class="loading">Gagal memuat data Program Anti Blackout.</div>';
    }
  }
  loadAntiBlackout();

  // 7. RINGKASAN KKU (Kinerja Keuangan & Umum)
  const KKU_CSV_URL = (window.APP_DATA_SOURCES && window.APP_DATA_SOURCES.kku_csv) ? window.APP_DATA_SOURCES.kku_csv : null;

  async function loadKkuData(){
    const valReal = document.getElementById('valKkuRealisasi');
    const valTindak = document.getElementById('valKkuTindakLanjut');
    const valKumul = document.getElementById('valKkuKumulatif');
    const footReal = document.getElementById('footKkuRealisasi');
    const footTindak = document.getElementById('footKkuTindakLanjut');
    const footKumul = document.getElementById('footKkuKumulatif');
    if(!valReal) return;

    if(!KKU_CSV_URL || !KKU_CSV_URL.trim()){
      valReal.textContent = '-';
      if(valTindak) valTindak.textContent = '-';
      if(valKumul) valKumul.textContent = '-';
      if(footReal) footReal.textContent = 'Menunggu sumber data KKU';
      if(footTindak) footTindak.textContent = 'Menunggu sumber data KKU';
      if(footKumul) footKumul.textContent = 'Menunggu sumber data KKU';
      return;
    }

    try{
      const rows = await fetchCsvRows(KKU_CSV_URL, 15000);
      if(!rows || rows.length < 2) return;

      const headers = rows[0].map(h => (h||'').toString().trim().toLowerCase());
      let realisasiVal = null, tindakLanjutVal = null, kumulatifVal = null;
      let realisasiFoot = null, tindakLanjutFoot = null, kumulatifFoot = null;

      // Skenario 1: Format Baris Vertikal (Kolom: Metrik / Indikator / Uraian, Nilai, Keterangan)
      const colMetrikIdx = headers.findIndex(h => h.includes('metrik') || h.includes('indikator') || h.includes('item') || h.includes('uraian') || h.includes('nama'));
      const colNilaiIdx = headers.findIndex(h => h.includes('nilai') || h.includes('realisasi') || h.includes('capaian') || h.includes('value') || h.includes('persen') || h.includes('status'));

      if(colMetrikIdx !== -1 && colNilaiIdx !== -1){
        rows.slice(1).forEach(r => {
          const m = (r[colMetrikIdx]||'').toString().trim().toLowerCase();
          const val = (r[colNilaiIdx]||'').toString().trim();
          const note = (r[colNilaiIdx + 1]||'').toString().trim();

          if(m.includes('realisasi')){
            realisasiVal = val;
            if(note) realisasiFoot = note;
          } else if(m.includes('tindak') || m.includes('status') || m.includes('tl')){
            tindakLanjutVal = val;
            if(note) tindakLanjutFoot = note;
          } else if(m.includes('kumulatif') || m.includes('total') || m.includes('komulatif') || m.includes('tahunan')){
            kumulatifVal = val;
            if(note) kumulatifFoot = note;
          }
        });
      }

      // Skenario 2: Format Tabel Horizontal (Baris = Periode/Bulan, Kolom = Realisasi, Status Tindak Lanjut, Capaian Kumulatif)
      if(realisasiVal === null && tindakLanjutVal === null && kumulatifVal === null){
        const idxReal = headers.findIndex(h => h.includes('realisasi'));
        const idxTindak = headers.findIndex(h => h.includes('tindak') || h.includes('status'));
        const idxKumul = headers.findIndex(h => h.includes('kumulatif') || h.includes('komulatif') || h.includes('capaian'));
        const idxKet = headers.findIndex(h => h.includes('ket') || h.includes('periode') || h.includes('bulan'));

        const validRows = rows.slice(1).filter(r => r.some(cell => cell && cell.toString().trim() !== ''));
        if(validRows.length > 0){
          const lastRow = validRows[validRows.length - 1];
          if(idxReal !== -1 && lastRow[idxReal]) realisasiVal = lastRow[idxReal].toString().trim();
          if(idxTindak !== -1 && lastRow[idxTindak]) tindakLanjutVal = lastRow[idxTindak].toString().trim();
          if(idxKumul !== -1 && lastRow[idxKumul]) kumulatifVal = lastRow[idxKumul].toString().trim();
          const ket = (idxKet !== -1 && lastRow[idxKet]) ? lastRow[idxKet].toString().trim() : 'Diperbarui otomatis dari CSV';
          realisasiFoot = ket;
          tindakLanjutFoot = ket;
          kumulatifFoot = ket;
        }
      }

      // Render hasil pemindaian ke kartu KKU (hanya jika terbaca dari CSV)
      // Apabila bagian tidak ditemukan di file CSV, nilai manual dari database tetap tampil
      if(realisasiVal !== null && realisasiVal !== ''){
        if(valReal) valReal.textContent = realisasiVal;
        if(footReal) footReal.textContent = realisasiFoot || 'Diperbarui otomatis dari CSV';
      }
      if(tindakLanjutVal !== null && tindakLanjutVal !== ''){
        if(valTindak) valTindak.textContent = tindakLanjutVal;
        if(footTindak) footTindak.textContent = tindakLanjutFoot || 'Diperbarui otomatis dari CSV';
      }
      if(kumulatifVal !== null && kumulatifVal !== ''){
        if(valKumul) valKumul.textContent = kumulatifVal;
        if(footKumul) footKumul.textContent = kumulatifFoot || 'Diperbarui otomatis dari CSV';
      }
    }catch(e){
      console.warn('Info: Menunggu sumber data KKU aktif:', e.message);
    }
  }
  loadKkuData();
</script>
@endsection
