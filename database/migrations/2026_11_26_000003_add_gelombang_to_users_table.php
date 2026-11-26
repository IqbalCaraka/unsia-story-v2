<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Gelombang pendaftaran mahasiswa.
 *
 * Tahun ajar saja belum cukup mengenali kapan seorang mahasiswa mendaftar:
 * satu periode dibuka dalam beberapa gelombang. Keduanya bersama-sama yang
 * menjawab "masuk kapan" — mis. Gelombang 3, 2026/2027 Genap.
 *
 * Nullable karena hanya mahasiswa yang punya; pengelola dan downline tidak.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // tinyint sudah menampung 0-255; gelombang tidak akan sebanyak itu.
            // Batas atas yang berlaku ditegakkan validasi, dari
            // config/pendaftaran.php, supaya bisa diubah tanpa migrasi.
            $table->unsignedTinyInteger('gelombang')->nullable()->after('tahun_ajar_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('gelombang');
        });
    }
};
