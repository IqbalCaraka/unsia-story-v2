<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Mahasiswa login pakai NIM, admin pakai email. Keduanya tetap pakai password.
            $table->string('email')->nullable()->change();

            $table->string('nim', 20)->nullable()->unique()->after('id');
            $table->string('nama')->nullable()->after('nim');
            $table->foreignId('prodi_id')->nullable()->after('nama')
                ->constrained('prodi')->nullOnDelete();
            $table->enum('role', ['admin', 'mahasiswa'])->default('mahasiswa')->after('password');
            $table->foreignId('tahun_ajar_id')->nullable()->after('role')
                ->constrained('tahun_ajar')->nullOnDelete();
        });

        // Akun yang sudah ada sebelum migration ini semuanya akun admin.
        DB::table('users')->update(['role' => 'admin']);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('tahun_ajar_id');
            $table->dropConstrainedForeignId('prodi_id');
            $table->dropColumn(['role', 'nama']);
            $table->dropUnique(['nim']);
            $table->dropColumn('nim');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable(false)->change();
        });
    }
};
