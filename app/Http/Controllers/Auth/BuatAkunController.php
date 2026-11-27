<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordAkunMahasiswa;
use App\Models\User;
use App\Support\PasswordAwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

/**
 * Pembuatan password awal untuk mahasiswa yang datanya sudah didaftarkan admin.
 *
 * Mahasiswa memasukkan email yang sudah terdaftar, sistem membuat password acak
 * 16 karakter, lalu mengirimkannya ke email itu. Tidak ada data yang dibuat di
 * sini — akunnya sudah ada, yang belum hanya passwordnya.
 */
class BuatAkunController extends Controller
{
    /** Percobaan per email, dan per alamat IP, dalam satu jam. */
    private const BATAS_PER_EMAIL = 3;
    private const BATAS_PER_IP = 10;
    private const JENDELA_DETIK = 3600;

    /**
     * Jawaban yang sama dipakai untuk email terdaftar maupun tidak.
     *
     * Kalau jawabannya dibedakan, siapa pun bisa menguji alamat email satu per
     * satu untuk memetakan siapa saja yang terdaftar di sistem ini.
     */
    private const PESAN_SERAGAM = 'Jika email tersebut terdaftar, password akun sudah kami kirimkan ke sana. '
        . 'Silakan periksa kotak masuk — termasuk folder spam.';

    public function form()
    {
        return view('auth.buat-akun');
    }

    public function kirim(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ], [], ['email' => 'email']);

        $email = mb_strtolower(trim($validated['email']));

        if ($lambat = $this->tertahanPembatasLaju($request, $email)) {
            return $lambat;
        }

        $user = User::whereRaw('LOWER(email) = ?', [$email])->first();

        // Seluruh pemeriksaan di bawah berujung pada pesan yang sama. Yang
        // berbeda hanya apakah emailnya benar-benar dikirim.
        if ($user && $this->bolehDibuatkan($user)) {
            // Kegagalan kirim dilaporkan apa adanya, walau itu berarti
            // jawabannya tidak lagi seragam untuk email terdaftar dan tidak.
            // Gangguan layanan harus terlihat: membiarkan mahasiswa menunggu
            // email yang tidak pernah datang jauh lebih merugikan daripada
            // kebocoran kecil itu, dan keadaannya pun tidak berlangsung lama.
            if (! $this->buatkanPassword($user)) {
                return back()->withInput()->withErrors([
                    'email' => 'Layanan email kami sedang bermasalah sehingga password belum bisa dikirim. '
                        . 'Coba lagi beberapa saat lagi, atau hubungi admin.',
                ]);
            }
        } elseif ($user) {
            // Akun ada tapi sudah pernah dipakai masuk. Dicatat di log supaya
            // admin bisa melihatnya kalau ada mahasiswa yang mengeluh.
            Log::info('Permintaan buat akun ditolak, akun sudah aktif', [
                'user_id' => $user->id,
                'ip' => $request->ip(),
            ]);
        }

        return back()->with('status', self::PESAN_SERAGAM);
    }

    /**
     * Hanya untuk mahasiswa yang akunnya belum pernah dipakai masuk.
     *
     * Batasan "belum pernah masuk" itu yang mencegah orang lain menekan tombol
     * ini berulang kali: tiap penekanan mengganti password, dan tanpa batasan
     * tersebut mahasiswa yang sudah aktif bisa terkunci di luar akunnya sendiri.
     */
    private function bolehDibuatkan(User $user): bool
    {
        return $user->isMahasiswa()
            && $user->terakhir_login_pada === null
            && filled($user->email);
    }

    /**
     * Membuat password baru dan mengirimkannya. Mengembalikan false kalau
     * emailnya gagal dikirim.
     *
     * Emailnya dikirim LEBIH DULU, passwordnya disimpan setelah pengiriman
     * berhasil. Urutan sebaliknya pernah dipakai dan berbahaya: begitu
     * pengiriman gagal, password mahasiswa sudah terlanjur diganti menjadi
     * nilai acak yang tidak diketahui siapa pun, sehingga akunnya tidak bisa
     * dipakai masuk sama sekali.
     */
    private function buatkanPassword(User $user): bool
    {
        $password = PasswordAwal::buat();

        try {
            // Dikirim langsung, bukan lewat antrean: belum ada worker antrean
            // yang berjalan di server ini, dan email yang tertahan di antrean
            // tidak akan pernah sampai.
            Mail::to($user->email)->send(new PasswordAkunMahasiswa($user, $password));
        } catch (\Throwable $e) {
            // Password lama dibiarkan utuh, jadi mahasiswa bisa mencoba lagi
            // setelah gangguannya beres.
            Log::error('Gagal mengirim password akun mahasiswa', [
                'user_id' => $user->id,
                'galat' => $e->getMessage(),
            ]);

            return false;
        }

        $user->forceFill(['password' => Hash::make($password)])->save();

        return true;
    }

    /**
     * Dibatasi dua lapis: per email agar satu kotak masuk tidak dibanjiri, dan
     * per IP agar satu orang tidak bisa menyapu banyak alamat sekaligus.
     */
    private function tertahanPembatasLaju(Request $request, string $email)
    {
        $kunci = [
            'buat-akun:email:' . sha1($email) => self::BATAS_PER_EMAIL,
            'buat-akun:ip:' . $request->ip() => self::BATAS_PER_IP,
        ];

        foreach ($kunci as $k => $batas) {
            if (RateLimiter::tooManyAttempts($k, $batas)) {
                $menit = (int) ceil(RateLimiter::availableIn($k) / 60);

                return back()->withInput()->withErrors([
                    'email' => "Terlalu banyak percobaan. Coba lagi dalam {$menit} menit, "
                        . 'atau hubungi admin kalau emailnya tidak kunjung sampai.',
                ]);
            }
        }

        foreach (array_keys($kunci) as $k) {
            RateLimiter::hit($k, self::JENDELA_DETIK);
        }

        return null;
    }
}
