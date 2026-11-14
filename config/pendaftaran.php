<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Periode Pendaftaran Mahasiswa Baru
    |--------------------------------------------------------------------------
    |
    | Satu-satunya sumber info gelombang pendaftaran. Sebelumnya gelombang dan
    | tanggalnya ditulis terpisah di beranda dan di FAQ, sehingga saat salah
    | satu diperbarui yang lain tertinggal — FAQ pernah menyebut gelombang dan
    | bulan yang sudah lewat sementara beranda sudah ganti.
    |
    | Setiap kali gelombang berganti, ubah di sini saja. Format tanggal dan
    | status buka/tutup dihitung oleh App\Support\Pendaftaran.
    |
    */

    'gelombang' => 'Gelombang 1',
    'jalur' => 'Jalur Reguler',

    // Tanggal dalam format Y-m-d. Hari terakhir ikut terhitung sebagai buka.
    'mulai' => '2026-11-13',
    'selesai' => '2026-11-26',

    'biaya' => 175000,

    'portal' => 'https://pmb.unsia.ac.id',

];
