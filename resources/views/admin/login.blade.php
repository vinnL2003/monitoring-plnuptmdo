<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Administrator — PLN UPT Manado</title>
<link rel="icon" type="image/png" href="{{ asset('Logo_UPT_Manado.png') }}?v=upt1">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=upt1">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v=upt1">
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=upt1">
<link rel="apple-touch-icon" href="{{ asset('Logo_UPT_Manado.png') }}?v=upt1">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  :root {
    --pln-blue: #00529C;
    --pln-blue-dark: #00386C;
    --pln-yellow: #FFC72C;
  }
  * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', sans-serif; }
  body {
    background: linear-gradient(135deg, #002244 0%, #00386C 50%, #00529C 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
  }
  .login-card {
    background: #fff;
    border-radius: 16px;
    width: 100%;
    max-width: 440px;
    padding: 40px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    text-align: center;
    position: relative;
    overflow: hidden;
  }
  .login-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, var(--pln-yellow), #FFA500);
  }
  .login-logo {
    height: 55px;
    margin-bottom: 20px;
    object-fit: contain;
  }
  .login-title {
    font-size: 22px;
    font-weight: 800;
    color: var(--pln-blue-dark);
    margin-bottom: 6px;
  }
  .login-sub {
    font-size: 13px;
    color: #64748B;
    margin-bottom: 28px;
  }
  .form-group {
    text-align: left;
    margin-bottom: 20px;
  }
  .form-group label {
    display: block;
    font-size: 12.5px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 6px;
  }
  .form-control {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid #CBD5E1;
    border-radius: 8px;
    font-size: 14px;
    outline: none;
    transition: all .2s;
  }
  .form-control:focus {
    border-color: var(--pln-blue);
    box-shadow: 0 0 0 3px rgba(0,82,156,0.15);
  }
  .btn-submit {
    width: 100%;
    background: var(--pln-blue);
    color: #fff;
    padding: 13px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: background .2s;
    margin-top: 10px;
  }
  .btn-submit:hover {
    background: var(--pln-blue-dark);
  }
  .alert-error {
    background: #FEF2F2;
    border: 1px solid #FECACA;
    color: #991B1B;
    padding: 10px 14px;
    border-radius: 8px;
    font-size: 12.5px;
    margin-bottom: 20px;
    text-align: left;
  }
  .back-link {
    display: inline-block;
    margin-top: 24px;
    font-size: 12.5px;
    color: #64748B;
    text-decoration: none;
    font-weight: 600;
  }
  .back-link:hover { color: var(--pln-blue); }
  .credentials-hint {
    margin-top: 20px;
    padding: 12px;
    background: #F8FAFC;
    border: 1px dashed #CBD5E1;
    border-radius: 8px;
    font-size: 11.5px;
    color: #64748B;
    text-align: left;
  }
  .credentials-hint strong { color: var(--pln-blue); }
</style>
</head>
<body>

<div class="login-card">
  <img src="{{ asset('Logo_UPT_Manado.png') }}" alt="PLN UPT Manado" class="login-logo" style="height: 64px; width: auto; max-width: 90%; object-fit: contain;">
  <h1 class="login-title">Admin Dashboard</h1>
  <p class="login-sub">Masuk untuk mengelola konten web PLN UPT Manado</p>

  @if($errors->any())
    <div class="alert-error">
      {{ $errors->first() }}
    </div>
  @endif

  @if(session('info'))
    <div style="background:#EFF6FF;border:1px solid #BFDBFE;color:#1E40AF;padding:10px 14px;border-radius:8px;font-size:12.5px;margin-bottom:20px;text-align:left;">
      {{ session('info') }}
    </div>
  @endif

  <form action="{{ route('login.post') }}" method="POST">
    @csrf
    <div class="form-group">
      <label for="email">Alamat Email</label>
      <input type="email" id="email" name="email" class="form-control" placeholder="nama@email.com" value="{{ old('email') }}" required autofocus>
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
    </div>

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; font-size:12.5px;">
      <label style="display:flex; align-items:center; gap:6px; cursor:pointer; color:#475569;">
        <input type="checkbox" name="remember" value="1"> Ingat Saya
      </label>
    </div>

    <button type="submit" class="btn-submit">Masuk ke Panel Admin</button>
  </form>

  <div>
    <a href="{{ route('home') }}" class="back-link">← Kembali ke Halaman Utama</a>
  </div>
</div>

</body>
</html>
