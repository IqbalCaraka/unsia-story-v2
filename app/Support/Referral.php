<?php

namespace App\Support;

/**
 * Perhitungan manfaat kode referal untuk simulasi biaya di beranda.
 *
 * Seluruh angka DIHITUNG dari config/referral.php, tidak ditulis ulang. Sisi
 * JavaScript hanya menyembunyikan dan menampilkan panel yang sudah dirender di
 * sini — ia tidak menghitung apa pun, supaya tidak ada kemungkinan angka di
 * layar berbeda dari angka di server.
 */
class Referral
{
    public static function kode(): string
    {
        return config('referral.kode');
    }

    public static function ukt(): int
    {
        return (int) config('referral.ukt');
    }

    public static function potongan(): int
    {
        return (int) config('referral.potongan');
    }

    public static function cashback(): int
    {
        return (int) config('referral.cashback');
    }

    /** Potongan + cashback. */
    public static function totalManfaat(): int
    {
        return self::potongan() + self::cashback();
    }

    /** Yang dibayar ke UNSIA setelah potongan, sebelum cashback diterima. */
    public static function setelahPotongan(): int
    {
        return self::ukt() - self::potongan();
    }

    /** Biaya yang benar-benar keluar dari kantong mahasiswa. */
    public static function biayaBersih(): int
    {
        return self::ukt() - self::totalManfaat();
    }

    public static function jumlahCicilan(): int
    {
        return (int) config('referral.cicilan.jumlah');
    }

    /** Cicilan ke berapa potongan dan cashback diproses. */
    public static function cicilanDiproses(): int
    {
        return (int) config('referral.cicilan.diproses_pada');
    }

    /**
     * Rincian tiap cicilan.
     *
     * Cicilan dibagi rata dari UKT, lalu potongan dan cashback dikurangkan
     * seluruhnya pada cicilan tempat keduanya diproses — bukan disebar rata.
     *
     * Sisa pembagian ditambahkan ke cicilan terakhir, supaya jumlah seluruh
     * cicilan selalu persis sama dengan UKT meski nilainya tidak terbagi rata.
     *
     * @return list<array{ke:int, tanpa_kode:int, sebelum_manfaat:int, potongan:int, cashback:int, dengan_kode:int}>
     */
    public static function rincianCicilan(): array
    {
        $jumlah = self::jumlahCicilan();
        $dasar = intdiv(self::ukt(), $jumlah);
        $sisa = self::ukt() - ($dasar * $jumlah);

        $rincian = [];

        for ($ke = 1; $ke <= $jumlah; $ke++) {
            $nilai = $dasar + ($ke === $jumlah ? $sisa : 0);
            $diproses = $ke === self::cicilanDiproses();

            $potongan = $diproses ? self::potongan() : 0;
            $cashback = $diproses ? self::cashback() : 0;

            $rincian[] = [
                'ke' => $ke,
                'tanpa_kode' => $nilai,
                'sebelum_manfaat' => $nilai,
                'potongan' => $potongan,
                'cashback' => $cashback,
                'dengan_kode' => $nilai - $potongan - $cashback,
            ];
        }

        return $rincian;
    }

    public static function rupiah(int $nilai): string
    {
        return 'Rp' . number_format($nilai, 0, ',', '.');
    }
}
