<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_cashback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('tahun_ajar_id')->constrained('tahun_ajar')->restrictOnDelete();

            // Tujuan transfer
            $table->enum('metode', ['bank', 'ewallet']);
            $table->string('penyedia', 50);          // nama bank atau nama e-wallet
            $table->string('nomor', 50);             // no. rekening atau no. HP e-wallet
            $table->string('atas_nama', 150);
            $table->text('catatan')->nullable();     // keterangan dari mahasiswa

            // Nominal disalin dari tahun_ajar saat pengajuan dibuat, supaya perubahan
            // besaran cashback di kemudian hari tidak mengubah klaim yang sudah berjalan.
            $table->decimal('jumlah', 12, 2);

            $table->enum('status', ['menunggu', 'diverifikasi', 'dibayar', 'ditolak'])
                ->default('menunggu');
            $table->text('catatan_admin')->nullable();

            // Bukti transfer disimpan di disk private, bukan public/.
            $table->string('bukti_path', 500)->nullable();
            $table->string('bukti_nama', 255)->nullable();

            $table->foreignId('diverifikasi_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('diverifikasi_pada')->nullable();
            $table->foreignId('dibayar_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('dibayar_pada')->nullable();

            $table->timestamps();

            $table->index(['status', 'created_at']);
            // Sengaja index biasa, bukan unique: klaim yang ditolak harus boleh diajukan
            // ulang untuk periode yang sama. Pembatasan satu klaim aktif per periode
            // ditegakkan di PengajuanCashback::adaKlaimAktif().
            $table->index(['user_id', 'tahun_ajar_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_cashback');
    }
};
