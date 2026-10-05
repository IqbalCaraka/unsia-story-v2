<?php

namespace Database\Seeders;

use App\Models\Prodi;
use Illuminate\Database\Seeder;

class ProdiSeeder extends Seeder
{
    public function run(): void
    {
        $daftar = [
            'Manajemen',
            'Akuntansi',
            'Komunikasi',
            'Informatika',
            'Sistem Informasi',
            'Teknologi Informasi',
        ];

        foreach ($daftar as $nama) {
            Prodi::firstOrCreate(['nama_prodi' => $nama]);
        }
    }
}
