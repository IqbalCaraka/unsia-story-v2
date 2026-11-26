{{-- Halaman pembuatan password awal mahasiswa.

     Berdiri sendiri seperti halaman login, tidak memakai layout situs, supaya
     halaman ini tidak membawa navigasi dan promo yang tidak relevan. --}}
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex">
<title>Buat Akun - UNSIA Story</title>
<link rel="shortcut icon" href="{{ asset('assets/images/logo-unsia-story.png') }}" type="image/png">
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family:'Lexend',sans-serif; min-height:100vh; background:linear-gradient(135deg,#0d1b2a,#1a2d4a); display:flex; align-items:center; justify-content:center; padding:20px 0; }
.kotak { background:#fff; border-radius:16px; padding:40px 35px; max-width:430px; width:90%; box-shadow:0 15px 50px rgba(0,0,0,0.3); }
.kotak img { display:block; margin:0 auto 20px; max-height:60px; }
.kotak h2 { text-align:center; font-size:22px; margin-bottom:5px; color:#0d1b2a; }
.kotak p.sub { text-align:center; color:#888; font-size:13px; margin-bottom:22px; line-height:1.7; }
.kotak label { display:block; font-size:13px; font-weight:600; color:#333; margin-bottom:6px; }
.kotak input { width:100%; padding:12px 16px; border:2px solid #e0e0e0; border-radius:10px; font-size:14px; font-family:'Lexend',sans-serif; outline:none; margin-bottom:8px; transition:border-color 0.3s; }
.kotak input:focus { border-color:#2c7aff; }
.kotak button { width:100%; padding:13px; background:#2c7aff; color:#fff; border:none; border-radius:10px; font-size:15px; font-weight:700; font-family:'Lexend',sans-serif; cursor:pointer; transition:opacity 0.3s; margin-top:10px; }
.kotak button:hover { opacity:0.9; }
.galat { background:#fce4ec; color:#c62828; padding:10px 15px; border-radius:8px; font-size:13px; font-weight:600; margin-bottom:15px; line-height:1.6; }
.berhasil { background:#e8f5e9; color:#1b5e20; padding:13px 16px; border-radius:8px; font-size:13px; font-weight:600; margin-bottom:18px; line-height:1.7; }
.petunjuk { background:#f4f5f7; border-radius:8px; padding:13px 16px; font-size:12.5px; color:#666; line-height:1.8; margin-bottom:20px; }
.tautan { display:block; text-align:center; margin-top:18px; color:#888; font-size:13px; text-decoration:none; }
.tautan:hover { color:#2c7aff; }
</style>
</head>
<body>
<div class="kotak">
    <img src="{{ asset('assets/images/logo-unsia-story.png') }}" alt="UNSIA Story">

    <h2>Buat Akun</h2>
    <p class="sub">Untuk mahasiswa yang mendaftar memakai kode referal <strong>unsia.my.id</strong></p>

    @if (session('status'))
        <div class="berhasil">
            <i class="fa-solid fa-circle-check"></i> {{ session('status') }}
        </div>
    @endif

    @error('email')
        <div class="galat">{{ $message }}</div>
    @enderror

    <div class="petunjuk">
        Masukkan <strong>email yang sudah kamu berikan ke admin</strong> saat pendaftaran.
        Sistem akan membuatkan password dan mengirimkannya ke email tersebut.
    </div>

    <form method="POST" action="{{ route('buat-akun.kirim') }}">
        @csrf

        <label for="email">Email Terdaftar</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}"
               placeholder="nama@email.com" required autofocus autocomplete="email">

        <button type="submit">
            <i class="fa-solid fa-paper-plane"></i> Kirim Password ke Email
        </button>
    </form>

    <a href="{{ route('login') }}" class="tautan">Sudah punya password? Masuk di sini</a>
    <a href="{{ route('home') }}" class="tautan">Kembali ke beranda</a>
</div>
</body>
</html>
