<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Admin Panel') — PLN UPT Manado</title>
<link rel="icon" type="image/png" href="{{ asset('Logo_UPT_Manado.png') }}?v=upt1">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=upt1">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v=upt1">
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=upt1">
<link rel="apple-touch-icon" href="{{ asset('Logo_UPT_Manado.png') }}?v=upt1">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/reactbits-animations.css') }}">

<style>
  :root {
    --pln-blue: #00529C;
    --pln-blue-dark: #00386C;
    --pln-yellow: #FFC72C;
    --pln-yellow-dark: #D9A400;
    --bg-body: #F4F6F9;
    --bg-card: #FFFFFF;
    --border-color: #E2E8F0;
    --text-main: #1E293B;
    --text-muted: #64748B;
    --sidebar-w: 260px;
    --primary: #00529C;
    --success: #10B981;
    --warning: #F59E0B;
    --danger: #EF4444;
  }

  * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif; }
  body { background: var(--bg-body); color: var(--text-main); min-height: 100vh; display: flex; }

  /* SIDEBAR */
  .admin-sidebar {
    width: var(--sidebar-w);
    background: var(--pln-blue-dark);
    color: #fff;
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    box-shadow: 4px 0 15px rgba(0,0,0,0.07);
    position: sticky;
    top: 0;
  }
  .sidebar-brand {
    padding: 24px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
  }
  .sidebar-brand img { height: 38px; width: auto; }
  .sidebar-brand-text h2 { font-size: 15px; font-weight: 800; color: #fff; letter-spacing: 0.3px; line-height: 1.2; }
  .sidebar-brand-text span { font-size: 11px; color: var(--pln-yellow); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }

  .sidebar-nav { padding: 20px 12px; flex: 1; display: flex; flex-direction: column; gap: 4px; overflow-y: auto; }
  .nav-group-label {
    font-size: 10.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: rgba(255,255,255,0.4);
    padding: 12px 14px 6px;
  }
  .sidebar-nav a {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    color: rgba(255,255,255,0.78);
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    border-radius: 8px;
    transition: all .2s ease;
  }
  .sidebar-nav a:hover {
    background: rgba(255,255,255,0.09);
    color: #fff;
    transform: translateX(3px);
  }
  .sidebar-nav a.active {
    background: var(--pln-blue);
    color: #fff;
    box-shadow: 0 4px 12px rgba(0,82,156,0.4);
    border-left: 3px solid var(--pln-yellow);
  }
  .sidebar-nav a .icon { font-size: 16px; width: 20px; text-align: center; }

  .sidebar-footer {
    padding: 16px;
    border-top: 1px solid rgba(255,255,255,0.1);
    background: rgba(0,0,0,0.15);
  }
  .user-badge {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 12px;
  }
  .user-badge .info { overflow: hidden; }
  .user-badge .name { font-weight: 700; color: #fff; font-size: 12px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
  .user-badge .role { font-size: 10.5px; color: var(--pln-yellow); }
  .logout-btn {
    background: rgba(239, 68, 68, 0.2);
    border: 1px solid rgba(239, 68, 68, 0.4);
    color: #FCA5A5;
    padding: 5px 9px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 11px;
    font-weight: 700;
  }
  .logout-btn:hover { background: #EF4444; color: #fff; }

  /* MAIN CONTENT AREA */
  .admin-main { flex: 1; display: flex; flex-direction: column; min-width: 0; }

  .admin-topbar {
    background: #fff;
    border-bottom: 1px solid var(--border-color);
    padding: 14px 28px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: sticky;
    top: 0;
    z-index: 100;
  }
  .page-header h1 { font-size: 20px; font-weight: 800; color: var(--pln-blue-dark); }
  .page-header p { font-size: 12.5px; color: var(--text-muted); margin-top: 2px; }

  .topbar-actions { display: flex; align-items: center; gap: 12px; }
  .btn-web-preview {
    background: #EBF8FF;
    color: var(--pln-blue);
    border: 1px solid #BEE3F8;
    padding: 8px 16px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 12.5px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    transition: all .2s;
  }
  .btn-web-preview:hover { background: var(--pln-blue); color: #fff; }

  .content-body { padding: 28px; flex: 1; }

  /* ALERTS */
  .alert {
    padding: 14px 18px;
    border-radius: 8px;
    margin-bottom: 22px;
    font-size: 13px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-weight: 500;
    box-shadow: 0 2px 5px rgba(0,0,0,0.03);
  }
  .alert-success { background: #ECFDF5; border: 1px solid #A7F3D0; color: #065F46; }
  .alert-warning { background: #FFFBEB; border: 1px solid #FDE68A; color: #92400E; }
  .alert-error { background: #FEF2F2; border: 1px solid #FECACA; color: #991B1B; }

  /* CARDS */
  .card-box {
    background: #fff;
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.03);
    margin-bottom: 24px;
  }
  .card-box-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
    padding-bottom: 14px;
    border-bottom: 1px solid var(--border-color);
  }
  .card-box-header h2 { font-size: 16px; font-weight: 700; color: var(--text-main); }
  .card-box-header p { font-size: 12px; color: var(--text-muted); margin-top: 2px; }

  /* BUTTONS */
  .btn {
    padding: 9px 18px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    transition: all .2s;
  }
  .btn-primary { background: var(--pln-blue); color: #fff; }
  .btn-primary:hover { background: var(--pln-blue-dark); color: #fff; }
  .btn-secondary { background: #E2E8F0; color: var(--text-main); }
  .btn-secondary:hover { background: #CBD5E1; }
  .btn-warning { background: var(--pln-yellow); color: var(--pln-blue-dark); }
  .btn-warning:hover { background: var(--pln-yellow-dark); }
  .btn-danger { background: #EF4444; color: #fff; }
  .btn-danger:hover { background: #DC2626; }
  .btn-sm { padding: 5px 10px; font-size: 11.5px; border-radius: 6px; }

  /* FORM STYLES */
  .form-group { margin-bottom: 18px; }
  .form-group label { display: block; font-size: 12.5px; font-weight: 700; margin-bottom: 6px; color: var(--text-main); }
  .form-group .hint { font-size: 11.5px; color: var(--text-muted); margin-top: 4px; }
  .form-control {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    font-size: 13px;
    color: var(--text-main);
    background: #fff;
    outline: none;
    transition: border-color .2s;
  }
  .form-control:focus { border-color: var(--pln-blue); box-shadow: 0 0 0 3px rgba(0,82,156,0.1); }
  textarea.form-control { min-height: 90px; resize: vertical; }

  /* TABLES */
  .table-responsive { width: 100%; overflow-x: auto; }
  .data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
  }
  .data-table th {
    background: #F8FAFC;
    color: var(--text-muted);
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    text-align: left;
    padding: 12px 16px;
    border-bottom: 1px solid var(--border-color);
  }
  .data-table td {
    padding: 14px 16px;
    border-bottom: 1px solid var(--border-color);
    color: var(--text-main);
    vertical-align: middle;
  }
  .data-table tr:hover { background: #F8FAFC; }

  /* BADGES */
  .badge {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
  }
  .badge-success { background: #DCFCE7; color: #166534; }
  .badge-danger { background: #FEE2E2; color: #991B1B; }
  .badge-info { background: #E0F2FE; color: #075985; }

  @media (max-width: 900px) {
    body { flex-direction: column; }
    .admin-sidebar { width: 100%; min-height: auto; position: static; }
  }
</style>
@yield('styles')
</head>
<body>

<!-- SIDEBAR -->
<aside class="admin-sidebar">
  <div class="sidebar-brand">
    <img src="{{ asset('Logo_UPT_Manado.png') }}" alt="PLN UPT Manado" style="height: 38px; width: auto; object-fit: contain;">
    <div class="sidebar-brand-text">
      <h2>PLN UPT MANADO</h2>
      <span>Admin Dashboard</span>
    </div>
  </div>

  <nav class="sidebar-nav">
    <div class="nav-group-label">Menu Utama</div>
    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <span class="icon">📊</span> Ringkasan &amp; Dashboard
    </a>
    <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
      <span class="icon">⚙️</span> Pengaturan Website &amp; Logo
    </a>
    <a href="{{ route('admin.navigation.index') }}" class="{{ request()->routeIs('admin.navigation.*') ? 'active' : '' }}">
      <span class="icon">🧭</span> Menu Navigasi Header
    </a>

    <div class="nav-group-label">Konten Halaman Depan</div>
    <a href="{{ route('admin.sections.index') }}" class="{{ request()->routeIs('admin.sections.*') ? 'active' : '' }}">
      <span class="icon">📑</span> Kelola 7 Section
    </a>
    <a href="{{ route('admin.stat-cards.index') }}" class="{{ request()->routeIs('admin.stat-cards.*') ? 'active' : '' }}">
      <span class="icon">📈</span> Kartu Statistik &amp; Metrik
    </a>
    <a href="{{ route('admin.progress.index') }}" class="{{ request()->routeIs('admin.progress.*') ? 'active' : '' }}">
      <span class="icon">🏗️</span> Progres Konstruksi &amp; COD
    </a>

    <div class="nav-group-label">Settingan Data &amp; Spreadsheet</div>
    <a href="{{ route('admin.page-data.index') }}" class="{{ request()->routeIs('admin.page-data.*') ? 'active' : '' }}">
      <span class="icon">📊</span> Settingan Data Halaman (2-Arah)
    </a>

    <div class="nav-group-label">Integrasi Data Eksternal</div>
    <a href="{{ route('admin.data-sources.index') }}" class="{{ request()->routeIs('admin.data-sources.*') ? 'active' : '' }}">
      <span class="icon">🌐</span> Master Sumber Data
    </a>

    <div class="nav-group-label">Keamanan &amp; Akses</div>
    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
      <span class="icon">👤</span> Kelola Admin Web
    </a>
    <a href="{{ route('admin.page-access.index') }}" class="{{ request()->routeIs('admin.page-access.*') ? 'active' : '' }}">
      <span class="icon">🔒</span> Akses Terbatas Halaman
    </a>
  </nav>

  <div class="sidebar-footer">
    <div class="user-badge">
      <div class="info">
        <div class="name">{{ Auth::user()->name ?? 'Administrator' }}</div>
        <div class="role">{{ Auth::user()->email ?? 'admin@pln.co.id' }}</div>
      </div>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout-btn" title="Keluar dari Admin">Logout</button>
      </form>
    </div>
  </div>
</aside>

<!-- MAIN CONTENT -->
<div class="admin-main">
  <div class="admin-topbar">
    <div class="page-header" style="display: flex; align-items: center; gap: 14px;">
      <img src="{{ asset('Logo_UPT_Manado.png') }}" alt="PLN UPT Manado" style="height: 38px; width: auto; object-fit: contain;">
      <div>
        <h1>@yield('page_title', 'Dashboard')</h1>
        <p>@yield('page_subtitle', 'Kelola konten website PLN UPT Manado secara langsung')</p>
      </div>
    </div>
    <div class="topbar-actions">
      <a href="{{ route('home') }}" target="_blank" class="btn-web-preview">
        👁️ Buka Website Live ↗
      </a>
    </div>
  </div>

  <main class="content-body">
    @if(session('success'))
      <div class="alert alert-success">
        <span>✅ {{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" style="background:none;border:none;cursor:pointer;font-weight:bold;">&times;</button>
      </div>
    @endif

    @if(session('warning'))
      <div class="alert alert-warning">
        <span>⚠️ {{ session('warning') }}</span>
        <button onclick="this.parentElement.remove()" style="background:none;border:none;cursor:pointer;font-weight:bold;">&times;</button>
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-error">
        <span>⚠️ {{ session('error') }}</span>
        <button onclick="this.parentElement.remove()" style="background:none;border:none;cursor:pointer;font-weight:bold;">&times;</button>
      </div>
    @endif

    @yield('content')
  </main>
</div>

@yield('scripts')

<!-- ReactBits Animation Suite -->
<script src="{{ asset('js/reactbits-animations.js') }}"></script>

</body>
</html>
