<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Mengembalikan kolom-kolom yang ada di situs v1 tapi belum ada di v2,
 * supaya data lama bisa dipindahkan utuh tanpa ada yang dibuang.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->text('deskripsi')->nullable()->after('nama_event');
            $table->string('lokasi', 200)->nullable()->default('Online (Zoom)')->after('jam_event');
            $table->string('poster', 300)->nullable()->after('lokasi');
            $table->unsignedInteger('kuota')->default(0)->after('poster');
            $table->enum('presensi_status', ['on', 'off'])->default('off')->after('status');
        });

        Schema::table('event_registrations', function (Blueprint $table) {
            $table->text('pekerjaan')->nullable()->after('asal_kota');
            $table->string('sumber_info', 200)->nullable()->after('pekerjaan');
            // 'us' = Universitas Siber Asia, 'sdp' = Sahabat Digital Preneur.
            $table->string('info_asal', 10)->nullable()->default('us')->after('sumber_info');
            $table->timestamp('presensi_time')->nullable()->after('attended');

            $table->string('sosmed_sdp_platform', 20)->nullable();
            $table->string('sosmed_sdp_username', 100)->nullable();
            $table->string('sosmed_us_platform', 20)->nullable();
            $table->string('sosmed_us_username', 100)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['deskripsi', 'lokasi', 'poster', 'kuota', 'presensi_status']);
        });

        Schema::table('event_registrations', function (Blueprint $table) {
            $table->dropColumn([
                'pekerjaan', 'sumber_info', 'info_asal', 'presensi_time',
                'sosmed_sdp_platform', 'sosmed_sdp_username',
                'sosmed_us_platform', 'sosmed_us_username',
            ]);
        });
    }
};
