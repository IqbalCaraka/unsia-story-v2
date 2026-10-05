<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_bantuan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap', 200);
            $table->string('nim', 50);
            $table->string('email', 200);
            $table->string('whatsapp', 20);
            $table->string('prodi', 100);
            $table->decimal('ip_semester_1', 3, 2);
            $table->string('transkrip_path', 500);
            $table->string('transkrip_nama', 255);
            $table->string('motivasi_path', 500);
            $table->string('motivasi_nama', 255);
            $table->text('catatan')->nullable();
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->timestamps();

            $table->index('status');
            $table->index('ip_semester_1');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_bantuan');
    }
};
