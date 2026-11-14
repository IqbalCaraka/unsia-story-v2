<?php

namespace App\Support;

use Carbon\CarbonImmutable;

/**
 * Pembaca config/pendaftaran.php.
 *
 * Logika tanggal ditaruh di sini, bukan di Blade, supaya aturannya hanya ada
 * satu tempat dan bisa diuji — beranda maupun FAQ memanggil yang sama.
 */
class Pendaftaran
{
    /** Zona waktu acuan. config/app.php memakai UTC, yang menggeser batas hari. */
    public const ZONA = 'Asia/Jakarta';

    public static function mulai(): CarbonImmutable
    {
        return CarbonImmutable::parse(config('pendaftaran.mulai'), self::ZONA)->startOfDay();
    }

    public static function selesai(): CarbonImmutable
    {
        // Hari terakhir ikut terhitung buka sampai tengah malam.
        return CarbonImmutable::parse(config('pendaftaran.selesai'), self::ZONA)->endOfDay();
    }

    /** Misal "Gelombang 1 Jalur Reguler". */
    public static function nama(): string
    {
        return trim(config('pendaftaran.gelombang') . ' ' . config('pendaftaran.jalur'));
    }

    /**
     * Rentang tanggal yang tidak mengulang bulan dan tahun tanpa perlu, mis.
     * "13 - 26 November 2026", tetapi "28 November - 3 Desember 2026" kalau
     * periodenya melewati pergantian bulan.
     */
    public static function rentangTanggal(): string
    {
        $mulai = self::mulai()->locale('id');
        $selesai = self::selesai()->locale('id');

        if ($mulai->isSameMonth($selesai, true)) {
            return $mulai->isoFormat('D') . ' - ' . $selesai->isoFormat('D MMMM YYYY');
        }

        if ($mulai->year === $selesai->year) {
            return $mulai->isoFormat('D MMMM') . ' - ' . $selesai->isoFormat('D MMMM YYYY');
        }

        return $mulai->isoFormat('D MMMM YYYY') . ' - ' . $selesai->isoFormat('D MMMM YYYY');
    }

    public static function biayaRupiah(): string
    {
        return 'Rp' . number_format((float) config('pendaftaran.biaya'), 0, ',', '.');
    }

    public static function portal(): string
    {
        return config('pendaftaran.portal');
    }

    /** Nama host portal untuk ditampilkan, mis. "pmb.unsia.ac.id". */
    public static function portalLabel(): string
    {
        return preg_replace('#^https?://#', '', rtrim(self::portal(), '/'));
    }

    /**
     * Dihitung, bukan ditulis tangan, supaya banner tidak terus mengaku
     * "dibuka" setelah periodenya lewat.
     */
    public static function sedangDibuka(): bool
    {
        return CarbonImmutable::now(self::ZONA)->between(self::mulai(), self::selesai());
    }

    public static function belumDibuka(): bool
    {
        return CarbonImmutable::now(self::ZONA)->lt(self::mulai());
    }

    public static function statusLabel(): string
    {
        return match (true) {
            self::belumDibuka() => 'Segera Dibuka',
            self::sedangDibuka() => 'Pendaftaran Dibuka',
            default => 'Pendaftaran Ditutup',
        };
    }
}
