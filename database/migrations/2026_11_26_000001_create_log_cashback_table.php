<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Riwayat setiap perubahan status pengajuan cashback.
 *
 * Tabel pengajuan_cashback hanya menyimpan keadaan terakhir — siapa yang
 * memverifikasi dan siapa yang membayar — sehingga jejak penolakan yang
 * kemudian diajukan ulang hilang sama sekali. Di sini setiap peristiwa dicatat
 * terpisah, supaya riwayatnya utuh kalau suatu saat ada sengketa.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_cashback', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pengajuan_cashback_id')
                ->constrained('pengajuan_cashback')
                ->cascadeOnDelete();

            // Varchar, bukan ENUM: daftar aksi yang sah ada di
            // LogCashback::AKSI, jadi menambah jenis peristiwa baru tidak
            // perlu migrasi dan tidak ada risiko daftar di skema berbeda dari
            // daftar di kode.
            $table->string('aksi', 20);

            // Pelakunya bisa mahasiswa (mengajukan, membatalkan) atau admin
            // (verifikasi, bayar, tolak). Dibiarkan null kalau akunnya kelak
            // dihapus — lognya sendiri harus tetap ada.
            $table->foreignId('oleh_user_id')->nullable()
                ->constrained('users')->nullOnDelete();

            $table->string('status_lama', 20)->nullable();
            $table->string('status_baru', 20);

            // Alasan penolakan, atau keterangan lain yang menyertai peristiwa.
            $table->text('catatan')->nullable();

            // Hanya created_at: baris log tidak pernah diubah setelah ditulis.
            $table->timestamp('created_at')->nullable();

            $table->index(['pengajuan_cashback_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_cashback');
    }
};
