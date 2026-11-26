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

    // Gelombang tertinggi yang boleh dicatat pada data mahasiswa.
    //
    // 255 adalah kapasitas kolom users.gelombang yang bertipe tinyint unsigned
    // — jadi ini batas nyata penyimpanannya, bukan aturan bisnis. Angka ini
    // pernah disetel 10 berdasarkan dugaan, dan itu menolak data gelombang 12
    // yang sebenarnya sah. Jangan diturunkan tanpa alasan yang pasti.
    'gelombang_maksimal' => 255,

    // Banyaknya pilihan yang disiapkan pada dropdown template Excel. Hanya
    // demi kenyamanan mengisi: angka di luar daftar tetap boleh diketik,
    // karena dropdown-nya memakai peringatan, bukan penolakan.
    'gelombang_dropdown' => 30,

    // Tanggal dalam format Y-m-d. Hari terakhir ikut terhitung sebagai buka.
    'mulai' => '2026-11-13',
    'selesai' => '2026-11-26',

    'biaya' => 175000,

    'portal' => 'https://pmb.unsia.ac.id',

];
