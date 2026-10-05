<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex">
<title>Admin Login - UNSIA Story</title>
<link rel="shortcut icon" href="{{ asset('assets/images/logo-unsia-story.png') }}" type="image/png">
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family:'Lexend',sans-serif; min-height:100vh; background:linear-gradient(135deg,#0d1b2a,#1a2d4a); display:flex; align-items:center; justify-content:center; }
.login-box { background:#fff; border-radius:16px; padding:40px 35px; max-width:400px; width:90%; box-shadow:0 15px 50px rgba(0,0,0,0.3); }
.login-box img { display:block; margin:0 auto 20px; max-height:60px; }
.login-box h2 { text-align:center; font-size:22px; margin-bottom:5px; color:#0d1b2a; }
.login-box p.sub { text-align:center; color:#888; font-size:13px; margin-bottom:25px; }
.login-box label { display:block; font-size:13px; font-weight:600; color:#333; margin-bottom:6px; }
.login-box input { width:100%; padding:12px 16px; border:2px solid #e0e0e0; border-radius:10px; font-size:14px; font-family:'Lexend',sans-serif; outline:none; margin-bottom:15px; transition:border-color 0.3s; }
.login-box input:focus { border-color:#2c7aff; }
.login-box button { width:100%; padding:13px; background:#2c7aff; color:#fff; border:none; border-radius:10px; font-size:15px; font-weight:700; font-family:'Lexend',sans-serif; cursor:pointer; transition:opacity 0.3s; }
.login-box button:hover { opacity:0.9; }
.alert { background:#fce4ec; color:#c62828; padding:10px 15px; border-radius:8px; font-size:13px; font-weight:600; margin-bottom:15px; }
.remember { display:flex; align-items:center; gap:8px; margin-bottom:18px; font-size:13px; color:#555; }
.remember input { width:auto; margin:0; }
.back-link { display:block; text-align:center; margin-top:20px; color:#888; font-size:13px; text-decoration:none; }
.back-link:hover { color:#2c7aff; }
</style>
</head>
<body>

<div class="login-box">
    <img src="{{ asset('assets/images/logo-unsia-story.png') }}" alt="UNSIA Story">
    <h2>Admin Login</h2>
    <p class="sub">Masuk ke panel administrasi</p>

    @if ($errors->any())
        <div class="alert">
            @foreach ($errors->all() as $error)
                <div><i class="fa-solid fa-exclamation-circle"></i> {{ $error }}</div>
            @endforeach
        </div>
    @endif

    @if (session('error'))
        <div class="alert"><i class="fa-solid fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <label for="login">Email atau NIM</label>
        <input type="text" id="login" name="login" value="{{ old('login') }}" placeholder="admin@example.com / 2201234567" required autofocus autocomplete="username">

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Password" required autocomplete="current-password">

        <div class="remember">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember" style="margin:0;font-weight:500;">Ingat saya</label>
        </div>

        <button type="submit"><i class="fa-solid fa-right-to-bracket" style="margin-right:6px;"></i> Login</button>
    </form>

    <a href="{{ route('home') }}" class="back-link"><i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda</a>
</div>

</body>
</html>
