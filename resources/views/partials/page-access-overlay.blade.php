{{-- 
  PARTIAL: Modal Akses Terbatas & Auto-Logout Watcher (Universal)
  Aturan Keamanan:
  1. Tiap 3 Menit AFK (Tanpa aktivitas mouse/keyboard/scroll/touch saat halaman terbuka) -> Otomatis logout/kunci
  2. Tiap 10 Menit Tidak Dibuka Halamannya (Tab hidden/minimized/background/unopened >= 10m) -> Otomatis logout/kunci
--}}
<style>
  .page-restricted-blurred {
    filter: blur(7px) !important;
    pointer-events: none !important;
    user-select: none !important;
  }
  /* Saat halaman terkunci: hero banner dibuat persis sama dengan ukuran hero-shrink yang tajam dan rapi */
  #topbar.topbar-locked .hero {
    padding: 13px 20px !important;
    justify-content: center !important;
    align-items: center !important;
    box-shadow: 0 4px 14px rgba(0,0,0,0.18);
    transition: padding .3s ease;
  }
  #topbar.topbar-locked .hero .logo-upt,
  #topbar.topbar-locked .logo-upt {
    height: 68px !important;
    max-height: 68px !important;
    margin: 0 auto !important;
    image-rendering: -webkit-optimize-contrast;
    image-rendering: crisp-edges;
    transition: height .3s ease;
  }
  #topbar.topbar-locked .hero .status-badge,
  #topbar.topbar-locked .status-badge {
    opacity: 0 !important;
    transform: translateY(-8px) scale(0.9) !important;
    margin-top: 0 !important;
    margin-bottom: 0 !important;
    max-height: 0 !important;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    border-width: 0 !important;
    pointer-events: none !important;
    display: none !important;
  }

  .page-login-overlay {
    position: fixed;
    top: var(--topbar-h, 0px);
    left: 0; right: 0; bottom: 0;
    z-index: 950;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    background: rgba(10, 20, 45, 0.45);
    overflow-y: auto;
    padding: 24px 14px;
    box-sizing: border-box;
  }
  .page-login-box {
    background: var(--bg-card, #FFFFFF);
    border: 1px solid var(--border-color, #E2E8F0);
    border-radius: 14px;
    padding: 26px 28px;
    width: 100%;
    max-width: 360px;
    margin: auto;
    box-shadow: 0 20px 60px rgba(0,0,0,0.4);
    text-align: center;
    animation: modalPopInAnim .25s cubic-bezier(0.16, 1, 0.3, 1);
  }
  @keyframes modalPopInAnim {
    from { opacity: 0; transform: scale(0.94) translateY(10px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
  }
  .page-login-box img.login-logo-dark { display: none; }
  .page-login-box img.login-logo-light { display: inline-block; height: 42px; width: auto; object-fit: contain; margin-bottom: 12px; }
  [data-theme="dark"] .page-login-box img.login-logo-light { display: none; }
  [data-theme="dark"] .page-login-box img.login-logo-dark { display: inline-block; height: 42px; width: auto; object-fit: contain; margin-bottom: 12px; }
  .page-login-box h2 { font-size: 16px; font-weight: 800; color: var(--pln-blue, #00529C); margin-bottom: 4px; }
  [data-theme="dark"] .page-login-box h2 { color: var(--pln-yellow, #FFC72C); }
  .page-login-box p.login-desc { font-size: 12px; color: var(--text-muted, #6C7A89); margin-bottom: 15px; line-height: 1.45; }
  .page-login-box input {
    width: 100%; padding: 10px 12px; margin-bottom: 10px; border: 1px solid var(--border-color, #E2E8F0);
    border-radius: 8px; background: var(--input-bg, #FFFFFF); color: var(--text-main, #2C3E50); font-size: 13.5px; outline: none;
    box-sizing: border-box; transition: border-color .2s, box-shadow .2s;
  }
  .page-login-box input:focus { border-color: var(--pln-blue, #00529C); box-shadow: 0 0 0 3px rgba(0,82,156,0.15); }
  [data-theme="dark"] .page-login-box input:focus { border-color: var(--pln-yellow, #FFC72C); box-shadow: 0 0 0 3px rgba(255,199,44,0.18); }
  .page-login-box button.btn-login-submit {
    width: 100%; padding: 10px; border: none; border-radius: 8px; background: var(--pln-blue, #00529C); color: #fff;
    font-size: 13.5px; font-weight: 700; cursor: pointer; margin-top: 4px; transition: opacity .2s, transform .1s;
  }
  .page-login-box button.btn-login-submit:hover { opacity: 0.9; }
  .page-login-box button.btn-login-submit:active { transform: scale(0.98); }
  [data-theme="dark"] .page-login-box button.btn-login-submit { background: var(--pln-yellow, #FFC72C); color: #0A2540; }
  
  .page-login-notice {
    display: none;
    text-align: left;
    margin-bottom: 16px;
    padding: 10px 12px;
    border-radius: 8px;
    font-size: 12px;
    line-height: 1.45;
  }
  .page-login-notice.notice-warning {
    background: rgba(243, 156, 18, 0.12);
    border: 1px solid rgba(243, 156, 18, 0.4);
    color: #D68910;
  }
  [data-theme="dark"] .page-login-notice.notice-warning {
    color: #F8C471;
  }
  .page-login-notice.notice-info {
    background: rgba(0, 82, 156, 0.1);
    border: 1px solid rgba(0, 82, 156, 0.3);
    color: var(--pln-blue, #00529C);
  }
  [data-theme="dark"] .page-login-notice.notice-info {
    color: #85C1E9;
  }
  .page-login-notice.notice-danger {
    background: rgba(231, 76, 60, 0.12);
    border: 1px solid rgba(231, 76, 60, 0.4);
    color: #E74C3C;
  }
  [data-theme="dark"] .page-login-notice.notice-danger {
    color: #F1948A;
  }
  .page-login-error {
    color: #E74C3C;
    background: rgba(231, 76, 60, 0.08);
    border: 1px solid rgba(231, 76, 60, 0.25);
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 12px;
    margin-top: 12px;
    display: none;
    text-align: left;
    line-height: 1.4;
  }
</style>

<!-- MODAL OVERLAY AKSES TERBATAS UNIVERSAL -->
<div id="universalPageLoginOverlay" class="page-login-overlay" style="{{ (($isRestricted ?? false) && !($isUnlocked ?? false)) ? 'display:flex;' : 'display:none;' }}">
  <div class="page-login-box">
    <img src="{{ asset('Logo_PLN.png') }}" alt="Logo PLN" class="login-logo-light">
    <img src="{{ asset('PLN_White.png') }}" alt="Logo PLN" class="login-logo-dark">
    <h2>Akses Terbatas: <span id="univPageTitle">{{ $pageTitle ?? 'Halaman Khusus' }}</span></h2>
    <p class="login-desc">Halaman ini dikonfigurasi dalam mode akses khusus personil berwenang. Masukkan kredensial Anda untuk melanjutkan.</p>

    <!-- Kotak Peringatan Sesi Berakhir Otomatis / AFK / 10 Menit -->
    <div id="univSessionNotice" class="page-login-notice"></div>

    <input type="text" id="univLoginUser" placeholder="Username / NIP" autocomplete="username">
    <input type="password" id="univLoginPass" placeholder="Password" autocomplete="current-password">
    <button class="btn-login-submit" id="univLoginBtn" onclick="attemptUnivLogin()">
      <span id="univLoginText">Masuk</span>
      <span id="univLoginSpin" style="display:none;">Memverifikasi...</span>
    </button>
    <div class="page-login-error" id="univLoginError"></div>
  </div>
</div>

<script>
(function() {
  const CURRENT_PAGE_SLUG = "{{ $pageSlug ?? '' }}";
  let isPageRestricted = {{ ($isRestricted ?? false) ? 'true' : 'false' }};
  let isPageUnlocked = {{ ($isUnlocked ?? false) ? 'true' : 'false' }};
  const PAGE_VERIFY_URL = "{{ route('page-access.verify') }}";
  const PAGE_LOCK_URL = "{{ route('page-access.lock') }}";
  const PAGE_PING_URL = "{{ route('page-access.ping') }}";
  const PAGE_CSRF_TOKEN = "{{ csrf_token() }}";
  const SERVER_LOCKED_REASON = "{{ $lockedReason ?? '' }}";

  // Waktu Timeout:
  // 1. Tiap 3 Menit AFK (180.000 ms)
  // 2. Tiap 10 Menit Tidak Dibuka Halamannya (600.000 ms)
  const urlParams = new URLSearchParams(window.location.search);
  const AFK_LIMIT_MS = parseInt(urlParams.get('test_afk_ms'), 10) || (3 * 60 * 1000);
  const UNOPENED_LIMIT_MS = parseInt(urlParams.get('test_unopened_ms'), 10) || (10 * 60 * 1000);
  const PING_INTERVAL_MS = 10 * 1000;

  // Ukur tinggi Topbar (Header + Hero) agar overlay mulai persis di bawahnya
  function syncTopbarHeight() {
    const topbar = document.getElementById('topbar');
    if (topbar) {
      document.documentElement.style.setProperty('--topbar-h', topbar.offsetHeight + 'px');
    } else {
      const header = document.querySelector('header');
      const hero = document.querySelector('.hero');
      const totalH = (header ? header.offsetHeight : 0) + (hero ? hero.offsetHeight : 0);
      document.documentElement.style.setProperty('--topbar-h', totalH + 'px');
    }
    const header = document.querySelector('header');
    if (header) {
      document.documentElement.style.setProperty('--header-h', header.offsetHeight + 'px');
    }
  }
  syncTopbarHeight();
  window.addEventListener('resize', syncTopbarHeight);
  window.addEventListener('load', syncTopbarHeight);
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', syncTopbarHeight);
  }

  // Render Pesan Alasan Kunci / Sesi Habis
  function renderLockNotice(reason) {
    const noticeEl = document.getElementById('univSessionNotice');
    if (!noticeEl) return;

    if (reason === 'afk_3m') {
      noticeEl.className = 'page-login-notice notice-warning';
      noticeEl.innerHTML = '🔒 <strong>Sesi Berakhir Otomatis (AFK):</strong><br>Tidak ada aktivitas selama 3 menit pada halaman ini. Akses telah dikunci otomatis demi keamanan.';
      noticeEl.style.display = 'block';
    } else if (reason === 'unopened_10m') {
      noticeEl.className = 'page-login-notice notice-warning';
      noticeEl.innerHTML = '🔒 <strong>Sesi Berakhir Otomatis:</strong><br>Halaman tidak dibuka selama lebih dari 10 menit. Akses telah dikunci otomatis demi keamanan.';
      noticeEl.style.display = 'block';
    } else if (reason === 'account_deactivated') {
      noticeEl.className = 'page-login-notice notice-danger';
      noticeEl.innerHTML = '🚫 <strong>Akun Telah Dinonaktifkan:</strong><br>Akun personil yang Anda gunakan sebelumnya telah dinonaktifkan atau hak aksesnya dicabut oleh administrator. Sesi akses halaman ini langsung diakhiri demi keamanan.';
      noticeEl.style.display = 'block';
    } else if (reason === 'manual') {
      noticeEl.className = 'page-login-notice notice-info';
      noticeEl.innerHTML = '🔒 <strong>Akses Dikunci:</strong><br>Akses halaman ini telah berhasil dikunci kembali. Silakan login untuk membuka.';
      noticeEl.style.display = 'block';
    } else {
      noticeEl.style.display = 'none';
    }
  }

  // Terapkan Tampilan Terkunci (Blur UI konten bawah + Munculkan Modal, header/topbar TETAP AKTIF)
  function applyUnivLockUI(reason) {
    isPageUnlocked = false;
    if (typeof window !== 'undefined') window.scrollTo(0, 0);
    document.body.style.overflow = 'hidden';

    // Rampingkan hero banner saat halaman terkunci agar box login tidak terpotong
    const topbar = document.getElementById('topbar');
    if (topbar) topbar.classList.add('topbar-locked');

    // Blur HANYA konten di bawah topbar (page-layout, main, pageAppWrapper, footer)
    // Header dan Topbar sengaja TIDAK diblur agar navbar tetap bisa diklik untuk pindah halaman
    document.querySelectorAll('#pageAppWrapper, .page-layout, main, footer').forEach(el => {
      el.classList.add('page-restricted-blurred');
    });
    document.querySelectorAll('#topbar, header, .hero').forEach(el => {
      el.classList.remove('page-restricted-blurred');
    });

    const overlay = document.getElementById('universalPageLoginOverlay');
    if (overlay) overlay.style.display = 'flex';
    const btnLock = document.getElementById('btnLockUnivPage');
    if (btnLock) btnLock.style.display = 'none';

    renderLockNotice(reason);
    syncTopbarHeight();
    setTimeout(syncTopbarHeight, 150);
    setTimeout(syncTopbarHeight, 350);
  }
  window.applyUnivLockUI = applyUnivLockUI;

  // Terapkan Tampilan Terbuka (Hilangkan Blur + Sembunyikan Modal)
  function applyUnivUnlockUI() {
    isPageUnlocked = true;
    sessionStorage.removeItem('upt_lock_reason_' + CURRENT_PAGE_SLUG);
    document.body.style.overflow = '';

    // Kembalikan ukuran normal hero banner saat login/terbuka
    const topbar = document.getElementById('topbar');
    if (topbar) topbar.classList.remove('topbar-locked');

    document.querySelectorAll('.page-restricted-blurred').forEach(el => {
      el.classList.remove('page-restricted-blurred');
    });
    const overlay = document.getElementById('universalPageLoginOverlay');
    if (overlay) overlay.style.display = 'none';
    const btnLock = document.getElementById('btnLockUnivPage');
    if (btnLock && isPageRestricted) btnLock.style.display = 'inline-flex';
    syncTopbarHeight();
    setTimeout(syncTopbarHeight, 150);
    setTimeout(syncTopbarHeight, 350);
  }
  window.applyUnivUnlockUI = applyUnivUnlockUI;

  // Login Handler
  window.attemptUnivLogin = async function() {
    const userEl = document.getElementById('univLoginUser');
    const passEl = document.getElementById('univLoginPass');
    if (!userEl || !passEl) return;

    const user = userEl.value.trim();
    const pass = passEl.value;
    const errEl = document.getElementById('univLoginError');
    const btn = document.getElementById('univLoginBtn');
    const txt = document.getElementById('univLoginText');
    const spin = document.getElementById('univLoginSpin');

    if (!user || !pass) {
      if (errEl) {
        errEl.textContent = 'Harap isi username dan password.';
        errEl.style.display = 'block';
      }
      return;
    }

    if (btn) btn.disabled = true;
    if (txt) txt.style.display = 'none';
    if (spin) spin.style.display = 'inline';
    if (errEl) errEl.style.display = 'none';

    try {
      const res = await fetch(PAGE_VERIFY_URL, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': PAGE_CSRF_TOKEN,
          'Accept': 'application/json'
        },
        body: JSON.stringify({ page_slug: CURRENT_PAGE_SLUG, username: user, password: pass })
      });

      const data = await res.json();
      if (res.ok && data.success) {
        sessionStorage.removeItem('upt_lock_reason_' + CURRENT_PAGE_SLUG);
        const now = Date.now();
        localStorage.setItem('upt_last_active_' + CURRENT_PAGE_SLUG, now.toString());
        localStorage.setItem('upt_last_opened_' + CURRENT_PAGE_SLUG, now.toString());
        window.location.reload();
      } else {
        if (errEl) {
          errEl.textContent = data.message || 'Username atau password salah.';
          errEl.style.display = 'block';
        }
      }
    } catch(err) {
      if (errEl) {
        errEl.textContent = 'Gagal terhubung ke server autentikasi.';
        errEl.style.display = 'block';
      }
    } finally {
      if (btn) btn.disabled = false;
      if (txt) txt.style.display = 'inline';
      if (spin) spin.style.display = 'none';
    }
  };

  // Lock Handler
  let isLockingInProgress = false;
  window.lockCurrentPage = async function(reason = 'manual') {
    if (isLockingInProgress) return;
    isLockingInProgress = true;

    sessionStorage.setItem('upt_lock_reason_' + CURRENT_PAGE_SLUG, reason);
    localStorage.removeItem('upt_last_active_' + CURRENT_PAGE_SLUG);
    localStorage.removeItem('upt_last_opened_' + CURRENT_PAGE_SLUG);

    applyUnivLockUI(reason);

    try {
      await fetch(PAGE_LOCK_URL, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': PAGE_CSRF_TOKEN,
          'Accept': 'application/json'
        },
        body: JSON.stringify({ page_slug: CURRENT_PAGE_SLUG, reason: reason })
      });
    } catch(e) {}

    isLockingInProgress = false;
  };

  document.getElementById('univLoginPass')?.addEventListener('keydown', (e) => { if (e.key === 'Enter') attemptUnivLogin(); });
  document.getElementById('univLoginUser')?.addEventListener('keydown', (e) => { if (e.key === 'Enter') attemptUnivLogin(); });

  // Inisialisasi Tampilan Saat Load
  const storedReason = sessionStorage.getItem('upt_lock_reason_' + CURRENT_PAGE_SLUG) || SERVER_LOCKED_REASON;
  if (isPageRestricted && !isPageUnlocked) {
    applyUnivLockUI(storedReason);
  }

  // Server Access Verification (Mendeteksi aktivasi proteksi dan validitas sesi)
  let lastServerPing = 0;
  async function checkServerAccess(force = false) {
    const t = Date.now();
    if (!force && (t - lastServerPing < 3000)) return; // throttle min 3 detik kecuali dipaksa (force)
    lastServerPing = t;

    try {
      const res = await fetch(PAGE_PING_URL, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': PAGE_CSRF_TOKEN,
          'Accept': 'application/json'
        },
        body: JSON.stringify({ page_slug: CURRENT_PAGE_SLUG })
      });
      const data = await res.json();
      if (data.restricted !== undefined) {
        isPageRestricted = !!data.restricted;
      }
      if (!res.ok || data.locked || (data.restricted && !data.unlocked)) {
        window.lockCurrentPage(data.reason || 'account_deactivated');
      }
    } catch(e) {}
  }

  // Throttled Activity Listener (Mouse, Keyboard, Touch, Scroll)
  let throttleTimer = null;
  function recordActivity() {
    if (!isPageUnlocked) return;
    const t = Date.now();
    localStorage.setItem('upt_last_active_' + CURRENT_PAGE_SLUG, t.toString());
    localStorage.setItem('upt_last_opened_' + CURRENT_PAGE_SLUG, t.toString());
  }

  function onActivityEvent() {
    if (throttleTimer) return;
    throttleTimer = setTimeout(() => {
      throttleTimer = null;
      recordActivity();
    }, 1000);
  }

  const activityEvents = ['mousemove', 'mousedown', 'keydown', 'keypress', 'scroll', 'touchstart', 'click', 'wheel'];
  activityEvents.forEach(evt => window.addEventListener(evt, onActivityEvent, { passive: true }));

  // Visibility & Focus Listener (Mendeteksi Halaman Tidak Dibuka & Real-time Protection / Deactivation Toggle)
  function onVisibilityOrFocusChange() {
    const t = Date.now();
    if (document.visibilityState === 'visible') {
      if (isPageRestricted && isPageUnlocked) {
        const prevOpened = parseInt(localStorage.getItem('upt_last_opened_' + CURRENT_PAGE_SLUG) || t.toString(), 10);
        if (t - prevOpened >= UNOPENED_LIMIT_MS) {
          window.lockCurrentPage('unopened_10m');
          return;
        }
        recordActivity();
      }
      checkServerAccess(true);
    } else {
      localStorage.setItem('upt_last_opened_' + CURRENT_PAGE_SLUG, t.toString());
      // Saat berpindah ke tab lain, langsung verifikasi status akun ke server
      if (isPageRestricted && isPageUnlocked) {
        checkServerAccess(true);
      }
    }
  }

  document.addEventListener('visibilitychange', onVisibilityOrFocusChange);
  window.addEventListener('focus', onVisibilityOrFocusChange);
  window.addEventListener('blur', onVisibilityOrFocusChange);

  // Interval Timer Tiap 1 Detik untuk AFK & Unopened
  const checkInterval = setInterval(() => {
    if (!isPageRestricted || !isPageUnlocked) {
      return;
    }

    const t = Date.now();

    // Rule 2: 10 Menit Tidak Dibuka Halamannya
    const currentOpened = parseInt(localStorage.getItem('upt_last_opened_' + CURRENT_PAGE_SLUG) || t.toString(), 10);
    if (t - currentOpened >= UNOPENED_LIMIT_MS) {
      window.lockCurrentPage('unopened_10m');
      return;
    }

    // Rule 1: 3 Menit AFK (hanya saat tab visible)
    if (document.visibilityState === 'visible') {
      const currentActive = parseInt(localStorage.getItem('upt_last_active_' + CURRENT_PAGE_SLUG) || t.toString(), 10);
      if (t - currentActive >= AFK_LIMIT_MS) {
        window.lockCurrentPage('afk_3m');
        return;
      }
    }
  }, 1000);

  // Periodic Heartbeat Server Ping tiap 30 detik
  setInterval(() => {
    if (document.visibilityState === 'visible') {
      checkServerAccess();
    }
  }, PING_INTERVAL_MS);
})();
</script>
