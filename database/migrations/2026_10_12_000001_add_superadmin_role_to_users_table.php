<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Menambah role "superadmin" di atas "admin".
 *
 * superadmin : seluruh panel, termasuk kelola pengguna
 * admin      : panel konten saja, tidak boleh kelola pengguna
 * mahasiswa  : hanya profil dan cashback miliknya sendiri
 */
return new class extends Migration
{
    public function up(): void
    {
        // Hanya MySQL yang punya tipe ENUM. SQLite — dipakai saat pengujian —
        // memakai varchar dengan CHECK, dan CHECK itulah yang menolak nilai
        // role baru. Di sana kolomnya cukup dijadikan varchar biasa; daftar
        // role yang sah sudah ditegakkan validasi di UserController.
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('superadmin','admin','mahasiswa') NOT NULL DEFAULT 'mahasiswa'");
        } else {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('mahasiswa')->change();
            });
        }

        // Admin yang sudah ada dinaikkan jadi superadmin. Tanpa ini tidak ada
        // satu pun akun yang bisa membuka menu Pengguna, dan panel terkunci.
        DB::table('users')->where('role', 'admin')->update(['role' => 'superadmin']);
    }

    public function down(): void
    {
        DB::table('users')->where('role', 'superadmin')->update(['role' => 'admin']);

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('admin','mahasiswa') NOT NULL DEFAULT 'mahasiswa'");
        }
    }
};
