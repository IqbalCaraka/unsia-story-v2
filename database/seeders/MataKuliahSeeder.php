<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MataKuliahSeeder extends Seeder
{
    /**
     * Import kurikulum UNSIA dari database/data/mata_kuliah.sql
     * (di-port dari proyek unsia-story).
     */
    public function run(): void
    {
        $path = database_path('data/mata_kuliah.sql');

        if (! is_file($path)) {
            $this->command?->warn("File {$path} tidak ditemukan, seeder dilewati.");

            return;
        }

        DB::table('mata_kuliah')->truncate();

        $sql = file_get_contents($path);

        // Buang BOM dan komentar baris, lalu jalankan tiap statement INSERT.
        $sql = preg_replace('/^\xEF\xBB\xBF/', '', $sql);
        $sql = preg_replace('/^--.*$/m', '', $sql);

        foreach (array_filter(array_map('trim', preg_split('/;\s*\R/', $sql))) as $statement) {
            $statement = trim($statement, " \t\n\r\0\x0B;");

            if ($statement === '') {
                continue;
            }

            DB::unprepared($statement . ';');
        }

        $this->command?->info('Mata kuliah: ' . DB::table('mata_kuliah')->count() . ' baris.');
    }
}
