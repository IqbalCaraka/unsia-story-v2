<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Menambah status "dibatalkan" pada pengajuan cashback.
 *
 * Sebelumnya pembatalan oleh mahasiswa menghapus barisnya. Dengan adanya
 * log_cashback, penghapusan itu merugikan: baris lognya ikut terhapus oleh
 * cascade, sehingga justru peristiwa yang ingin dicatat hilang seluruhnya.
 *
 * Kini barisnya tetap ada dengan status "dibatalkan". Status itu tidak termasuk
 * STATUS_AKTIF, jadi mahasiswa tetap bisa mengajukan ulang seperti sebelumnya.
 */
return new class extends Migration
{
    public function up(): void
    {
        self::ubahEnum("'menunggu','diverifikasi','dibayar','ditolak','dibatalkan'");
    }

    public function down(): void
    {
        // Baris yang terlanjur dibatalkan tidak bisa dikembalikan jadi
        // "menunggu" — itu akan menghidupkan lagi klaim yang sudah ditutup.
        // Diperlakukan sebagai ditolak, yang sama-sama tidak mengunci.
        DB::table('pengajuan_cashback')->where('status', 'dibatalkan')->update(['status' => 'ditolak']);

        self::ubahEnum("'menunggu','diverifikasi','dibayar','ditolak'");
    }

    /**
     * Hanya MySQL yang punya tipe ENUM. SQLite — dipakai saat pengujian —
     * memakai varchar dengan CHECK yang akan menolak nilai baru, jadi di sana
     * kolomnya dijadikan varchar biasa.
     */
    private static function ubahEnum(string $nilai): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE pengajuan_cashback MODIFY status ENUM($nilai) NOT NULL DEFAULT 'menunggu'");

            return;
        }

        Schema::table('pengajuan_cashback', function (Blueprint $table) {
            $table->string('status', 20)->default('menunggu')->change();
        });
    }
};
