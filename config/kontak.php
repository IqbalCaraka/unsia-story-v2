<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Kontak
    |--------------------------------------------------------------------------
    |
    | Satu-satunya sumber data kontak yang tampil di situs. Sebelumnya nilai
    | ini ditulis ulang di sembilan berkas Blade, dan nomor yang ditampilkan
    | ke pengunjung sempat beda satu digit dari nomor di dalam tautan wa.me
    | selama berbulan-bulan tanpa terdeteksi. Ubah di sini saja, jangan lagi
    | langsung di Blade.
    |
    */

    // Penanggung jawab usaha. Nomor ini TIDAK dipakai untuk tombol WhatsApp.
    'bisnis' => [
        'nama' => 'Dianto Adwoko S.',
        'email' => 'info@unsia.my.id',
        'telepon' => '+62 811-2014-086',
    ],

    // Layanan pelanggan. SEMUA tombol dan tautan WhatsApp di situs mengarah
    // ke nomor ini.
    //
    // 'telepon' -> untuk dibaca pengunjung
    // 'wa'      -> untuk tautan wa.me: kode negara tanpa "+", tanpa "0", tanpa pemisah
    //
    // Keduanya harus merujuk satu nomor yang sama. Kalau salah satu diubah,
    // ubah juga yang lain; kecocokannya dijaga oleh tests/Feature/KontakTest.php.
    'cs' => [
        'nama' => 'Lia',
        'telepon' => '+62 813-333-1686',
        'wa' => '628133331686',
    ],

    // 'baris' dipakai saat alamat ditampilkan bertingkat (halaman Tentang),
    // 'satu_baris' saat harus memadat dalam satu kalimat (footer, disclaimer).
    'alamat' => [
        'baris' => [
            'Perumahan Wahana Pondok Gede, Q-1, 32',
            'Jatisari, Jatiasih',
            'Kota Bekasi, Jawa Barat 17426',
            'Indonesia',
        ],
        'satu_baris' => 'Perumahan Wahana Pondok Gede, Q-1, 32, Jatisari, Jatiasih, Kota Bekasi, Jawa Barat 17426, Indonesia',
    ],

];
