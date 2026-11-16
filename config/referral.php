<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Kode Referal & Nilai Manfaatnya
    |--------------------------------------------------------------------------
    |
    | Dipakai oleh simulasi biaya di beranda, yang menghitung angkanya alih-alih
    | menuliskannya. Angka yang sama masih ditulis sebagai prosa di beberapa
    | halaman; tests/Feature/SimulasiBiayaTest.php memeriksa bahwa prosa itu
    | tetap sesuai dengan nilai di sini, supaya keduanya tidak bisa menyimpang
    | diam-diam seperti yang pernah terjadi.
    |
    */

    'kode' => 'unsia.my.id',

    'ukt' => 3_000_000,

    // Potongan UKT dari UNSIA.
    'potongan' => 500_000,

    // Cashback dari UNSIA Story — pihak yang membayarnya berbeda dari potongan
    // di atas, jadi keduanya tidak boleh digabung jadi satu angka.
    'cashback' => 100_000,

    'cicilan' => [
        'jumlah' => 3,

        // Pada skema cicilan, potongan dan cashback sama-sama baru diproses di
        // cicilan terakhir — bukan dibagi rata ke setiap cicilan.
        'diproses_pada' => 3,
    ],

];
