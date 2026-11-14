<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Sosial media yang dimiliki seorang downline.
 *
 * Satu downline boleh punya beberapa akun, termasuk beberapa akun di platform
 * yang sama — karena itu tabel terpisah, bukan kolom-kolom di `downlines`.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('downline_social_media', function (Blueprint $table) {
            $table->id();

            $table->foreignId('downline_id')->constrained('downlines')->cascadeOnDelete();

            // Sengaja varchar, bukan ENUM. Daftar platform yang sah ada di
            // DownlineSocialMedia::PLATFORM dan ditegakkan oleh validasi, jadi
            // menambah platform baru cukup mengubah satu const — tanpa migrasi
            // dan tanpa risiko daftar di skema berbeda dari daftar di kode.
            $table->string('platform', 20);

            // Satu kolom untuk dua bentuk, supaya tidak ada kolom yang selalu
            // kosong: untuk sosial media isinya username tanpa "@", untuk blog
            // isinya URL lengkap. Tautan utuhnya dibentuk oleh accessor
            // DownlineSocialMedia::url().
            $table->string('akun', 255);

            $table->timestamps();

            // Mencegah akun yang sama persis dicatat dua kali.
            $table->unique(['downline_id', 'platform', 'akun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('downline_social_media');
    }
};
