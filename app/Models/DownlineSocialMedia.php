<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['downline_id', 'platform', 'akun'])]
class DownlineSocialMedia extends Model
{
    /**
     * Laravel akan menebak "downline_social_medias" dari nama kelas, padahal
     * "media" sudah bentuk jamak.
     */
    protected $table = 'downline_social_media';

    /**
     * Satu-satunya daftar platform yang sah. Kolom `platform` di database
     * sengaja varchar biasa, jadi menambah platform cukup di sini.
     *
     *   label  : untuk ditampilkan
     *   ikon   : kelas Font Awesome
     *   awalan : bagian depan tautan; null berarti `akun` sudah berisi URL utuh
     */
    public const PLATFORM = [
        'instagram' => ['label' => 'Instagram', 'ikon' => 'fa-brands fa-instagram', 'awalan' => 'https://instagram.com/'],
        'facebook' => ['label' => 'Facebook', 'ikon' => 'fa-brands fa-facebook', 'awalan' => 'https://facebook.com/'],
        'tiktok' => ['label' => 'TikTok', 'ikon' => 'fa-brands fa-tiktok', 'awalan' => 'https://tiktok.com/@'],
        'x' => ['label' => 'X', 'ikon' => 'fa-brands fa-x-twitter', 'awalan' => 'https://x.com/'],
        'threads' => ['label' => 'Threads', 'ikon' => 'fa-brands fa-threads', 'awalan' => 'https://threads.net/@'],
        'blog' => ['label' => 'Blog', 'ikon' => 'fa-solid fa-globe', 'awalan' => null],
    ];

    /** @return list<string> */
    public static function platformYangSah(): array
    {
        return array_keys(self::PLATFORM);
    }

    public function downline(): BelongsTo
    {
        return $this->belongsTo(Downline::class);
    }

    public function label(): string
    {
        return self::PLATFORM[$this->platform]['label'] ?? $this->platform;
    }

    public function ikon(): string
    {
        return self::PLATFORM[$this->platform]['ikon'] ?? 'fa-solid fa-link';
    }

    /**
     * Blog menyimpan URL utuh; platform lain menyimpan username saja, jadi
     * tautannya dibentuk dari awalan platform.
     */
    public function url(): string
    {
        $awalan = self::PLATFORM[$this->platform]['awalan'] ?? null;

        return $awalan === null ? $this->akun : $awalan . $this->akun;
    }

    /**
     * Merapikan isian admin menjadi bentuk yang konsisten.
     *
     * Orang biasanya menempel tautan utuh ("https://instagram.com/unsia.my.id")
     * atau menulis pakai "@", padahal yang disimpan hanya usernamenya. Tanpa
     * perapian ini, satu akun yang sama bisa tercatat dalam beberapa bentuk
     * dan indeks unique tidak menangkapnya sebagai duplikat.
     */
    public static function rapikanAkun(string $platform, string $akun): string
    {
        $akun = trim($akun);

        // Blog memang berisi URL; hanya garis miring penutup yang dibuang.
        if ((self::PLATFORM[$platform]['awalan'] ?? null) === null) {
            return rtrim($akun, '/');
        }

        // Buang skema dan host kalau yang ditempel adalah tautan utuh.
        if (preg_match('#^(?:https?://)?(?:www\.)?[a-z0-9.-]+\.[a-z]{2,}/(.+)$#i', $akun, $cocok)) {
            $akun = $cocok[1];
        }

        return ltrim(rtrim($akun, '/'), '@');
    }
}
