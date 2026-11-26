<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Mencatat kapan sebuah akun terakhir berhasil masuk.
 *
 * Dipakai fitur "Buat Akun": pembuatan password hanya boleh dilakukan selama
 * akunnya belum pernah dipakai masuk. Tanpa catatan ini, siapa pun yang tahu
 * email seorang mahasiswa bisa terus menekan tombol itu, passwordnya berganti
 * tiap kali, dan mahasiswanya sendiri tidak bisa masuk lagi.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('terakhir_login_pada')->nullable()->after('remember_token');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('terakhir_login_pada');
        });
    }
};
