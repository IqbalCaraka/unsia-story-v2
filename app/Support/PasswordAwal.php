<?php

namespace App\Support;

/**
 * Pembuat password awal yang dikirim ke mahasiswa lewat email.
 */
class PasswordAwal
{
    public const PANJANG = 16;

    /**
     * Huruf dan angka yang tidak mudah tertukar saat dibaca dari email lalu
     * diketik ulang. Sengaja TIDAK memuat:
     *
     *   0 O o   angka nol dan huruf O
     *   1 l I   angka satu, huruf L kecil, huruf I besar
     *
     * Tanda baca juga tidak dipakai: ia menyulitkan pengetikan di papan ketik
     * ponsel, dan sebagian aplikasi email memotongnya saat menyalin.
     */
    private const HURUF = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789';

    /**
     * Password acak sepanjang PANJANG karakter.
     *
     * Memakai random_int(), bukan rand() atau mt_rand(), karena hanya yang
     * pertama layak dipakai untuk hal yang menyangkut keamanan.
     */
    public static function buat(): string
    {
        $batas = strlen(self::HURUF) - 1;
        $hasil = '';

        for ($i = 0; $i < self::PANJANG; $i++) {
            $hasil .= self::HURUF[random_int(0, $batas)];
        }

        return $hasil;
    }
}
