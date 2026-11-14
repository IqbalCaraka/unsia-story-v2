<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Menambah role "downline" beserta tabel datanya.
 *
 * downline : mitra yang mereferensikan pendaftar. Login memakai email seperti
 *            pengelola, tetapi TIDAK punya akses panel admin — sama seperti
 *            mahasiswa, hanya bisa membuka profilnya sendiri.
 *
 * Data khusus downline ditaruh di tabel terpisah, bukan sebagai kolom tambahan
 * di `users`, supaya kolom-kolom itu tidak menggantung kosong bagi tiga role
 * lainnya.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Hanya MySQL yang punya tipe ENUM. SQLite — dipakai saat pengujian —
        // memakai varchar dengan CHECK, dan CHECK itulah yang akan menolak
        // nilai role baru. Di sana kolomnya cukup varchar biasa; daftar role
        // yang sah ditegakkan validasi di UserController.
        if (DB::getDriverName() === 'mysql') {
            DB::statement(
                "ALTER TABLE users MODIFY role
                 ENUM('superadmin','admin','mahasiswa','downline') NOT NULL DEFAULT 'mahasiswa'"
            );
        } else {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('mahasiswa')->change();
            });
        }

        Schema::create('downlines', function (Blueprint $table) {
            $table->id();

            // Satu akun paling banyak punya satu baris downline. Barisnya ikut
            // terhapus kalau akunnya dihapus.
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();

            // Disimpan sebagai char, bukan integer, supaya tidak ada angka nol
            // di depan yang hilang dan panjangnya selalu tetap 8. Nilainya
            // digenerate di Downline::idBaru() pada rentang 10000000-99999999.
            $table->char('id_downline', 8)->unique();

            // Kode yang dibagikan downline ke calon pendaftar. Digenerate dari
            // id_downline, tetapi tetap disimpan agar bisa diganti kelak tanpa
            // mengubah id_downline yang mungkin sudah tersebar.
            $table->string('kode_downline', 50)->unique();

            // Nonaktif dipakai, bukan hapus baris, supaya id_downline sebuah
            // mitra tetap sama kalau suatu hari diaktifkan kembali.
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('downlines');

        // Downline dikembalikan jadi mahasiswa supaya tidak ada baris yang
        // nilainya di luar enum setelah kolomnya dipersempit.
        DB::table('users')->where('role', 'downline')->update(['role' => 'mahasiswa']);

        if (DB::getDriverName() === 'mysql') {
            DB::statement(
                "ALTER TABLE users MODIFY role
                 ENUM('superadmin','admin','mahasiswa') NOT NULL DEFAULT 'mahasiswa'"
            );
        }
    }
};
