<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'id_downline', 'kode_downline', 'status'])]
class Downline extends Model
{
    public const STATUS = ['aktif', 'tidak_aktif'];

    /** Awalan kode yang dibagikan downline ke calon pendaftar. */
    public const AWALAN_KODE = 'DL';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function socialMedia(): HasMany
    {
        return $this->hasMany(DownlineSocialMedia::class, 'downline_id');
    }

    public function aktif(): bool
    {
        return $this->status === 'aktif';
    }

    public function statusLabel(): string
    {
        return $this->status === 'aktif' ? 'Aktif' : 'Tidak Aktif';
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * ID downline: 8 angka unik.
     *
     * Rentangnya mulai dari 10000000, bukan 0, supaya hasilnya selalu delapan
     * angka tanpa perlu ditambah nol di depan — nol di depan mudah hilang saat
     * nilainya tersalin ke spreadsheet atau dibaca sebagai bilangan.
     *
     * Pengulangan di sini hanya mengurangi kemungkinan tabrakan. Yang benar-
     * benar menjamin keunikan adalah indeks unique di tabelnya, dan tabrakan
     * yang lolos ditangani oleh perulangan di buatUntuk().
     */
    public static function idBaru(): string
    {
        do {
            $id = (string) random_int(10000000, 99999999);
        } while (static::where('id_downline', $id)->exists());

        return $id;
    }

    /**
     * Membuat baris downline untuk sebuah akun.
     *
     * Dicoba beberapa kali karena dua admin yang menyimpan di saat yang sama
     * bisa memperoleh angka yang sama: pemeriksaan di idBaru() dan penulisan
     * di sini tidak berlangsung sebagai satu kesatuan. Indeks unique akan
     * menolak yang kedua, dan percobaan berikutnya memakai angka baru.
     */
    public static function buatUntuk(User $user, string $status = 'aktif'): self
    {
        for ($percobaan = 1; ; $percobaan++) {
            $id = static::idBaru();

            try {
                return static::create([
                    'user_id' => $user->id,
                    'id_downline' => $id,
                    'kode_downline' => static::AWALAN_KODE . $id,
                    'status' => $status,
                ]);
            } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
                // Baris untuk user ini sudah ada — bukan tabrakan angka, dan
                // mencoba lagi tidak akan menolong.
                if (static::where('user_id', $user->id)->exists()) {
                    throw $e;
                }

                if ($percobaan >= 5) {
                    throw $e;
                }
            }
        }
    }
}
