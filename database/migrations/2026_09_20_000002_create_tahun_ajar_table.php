<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tahun_ajar', function (Blueprint $table) {
            $table->id();
            $table->enum('ganjil_genap', ['ganjil', 'genap']);
            $table->string('tahun_ajar', 20);
            $table->timestamps();

            // Satu semester hanya boleh ada sekali, mis. 2025/2026 ganjil.
            $table->unique(['tahun_ajar', 'ganjil_genap']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tahun_ajar');
    }
};
