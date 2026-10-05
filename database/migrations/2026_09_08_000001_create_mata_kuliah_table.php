<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mata_kuliah', function (Blueprint $table) {
            $table->id();
            $table->string('prodi', 100);
            $table->string('kode_mk', 50)->nullable();
            $table->string('nama_mk', 200);
            $table->unsignedTinyInteger('sks')->default(0);
            $table->unsignedTinyInteger('semester')->default(0);
            $table->string('kategori', 20)->nullable();
            $table->string('peminatan', 100)->nullable();
            $table->text('keywords')->nullable();

            $table->index('prodi');
            $table->index('nama_mk');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mata_kuliah');
    }
};
