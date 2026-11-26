{{-- Email password akun mahasiswa.

     Ditulis sebagai HTML sederhana dengan gaya inline, bukan memakai komponen
     markdown Laravel, karena klien email mengabaikan stylesheet dan sebagian
     memotong CSS di <head>. --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Akun UNSIA Story</title>
</head>
<body style="margin:0;padding:24px;background:#f4f5f7;font-family:Arial,Helvetica,sans-serif;color:#333;">
    <div style="max-width:560px;margin:0 auto;background:#fff;border-radius:12px;overflow:hidden;">

        <div style="background:#0d1b2a;padding:22px 28px;">
            <h1 style="margin:0;font-size:19px;color:#f0c040;">UNSIA Story</h1>
        </div>

        <div style="padding:28px;">
            <p style="margin:0 0 16px;font-size:15px;line-height:1.7;">
                Halo <strong>{{ $user->nama ?? $user->name }}</strong>,
            </p>

            <p style="margin:0 0 20px;font-size:15px;line-height:1.7;">
                Akun Anda sudah dibuat. Gunakan email dan password di bawah ini untuk masuk.
            </p>

            <table style="width:100%;border-collapse:collapse;margin-bottom:20px;">
                <tr>
                    <td style="padding:10px 0;font-size:14px;color:#666;width:34%;">Email</td>
                    <td style="padding:10px 0;font-size:15px;"><strong>{{ $user->email }}</strong></td>
                </tr>
                @if ($user->nim)
                    <tr>
                        <td style="padding:10px 0;font-size:14px;color:#666;">NIM</td>
                        <td style="padding:10px 0;font-size:15px;"><strong>{{ $user->nim }}</strong></td>
                    </tr>
                @endif
            </table>

            <p style="margin:0 0 8px;font-size:14px;color:#666;">Password</p>
            <div style="background:#f4f5f7;border:1px solid #e0e3e8;border-radius:8px;padding:16px;text-align:center;margin-bottom:20px;">
                {{-- Jarak antarhuruf dilebarkan dan hurufnya monospace supaya
                     huruf yang mirip tidak salah dibaca saat diketik ulang. --}}
                <code style="font-family:'Courier New',Courier,monospace;font-size:20px;letter-spacing:3px;font-weight:bold;color:#0d1b2a;">{{ $password }}</code>
            </div>

            <p style="margin:0 0 22px;font-size:14px;line-height:1.7;color:#555;">
                Password ini dibuat acak oleh sistem. Setelah berhasil masuk, segera ganti
                dengan password pilihan Anda sendiri lewat menu Profil.
            </p>

            <p style="margin:0 0 24px;text-align:center;">
                <a href="{{ route('login') }}"
                   style="display:inline-block;background:#f0c040;color:#0d1b2a;padding:13px 30px;border-radius:50px;text-decoration:none;font-weight:bold;font-size:15px;">
                    Masuk Sekarang
                </a>
            </p>

            <p style="margin:0;font-size:13px;line-height:1.7;color:#888;border-top:1px solid #eee;padding-top:18px;">
                Jika Anda tidak merasa meminta ini, abaikan saja email ini dan jangan
                berikan password di atas kepada siapa pun.
            </p>
        </div>

        <div style="background:#f4f5f7;padding:16px 28px;text-align:center;">
            <p style="margin:0;font-size:12px;color:#888;">
                &copy; {{ date('Y') }} UNSIA Story &mdash; Mitra Pemasaran Resmi Universitas Siber Asia
            </p>
        </div>
    </div>
</body>
</html>
