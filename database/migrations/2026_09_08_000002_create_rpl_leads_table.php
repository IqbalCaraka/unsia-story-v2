<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rpl_leads', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 200);
            $table->string('email', 200);
            $table->string('whatsapp', 20);
            $table->string('sumber', 50)->default('RPL Konversi');
            $table->string('prodi_cocok', 100)->nullable();
            $table->string('jenis_rpl', 50)->nullable();
            $table->longText('input_mk')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rpl_leads');
    }
};
