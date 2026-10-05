<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tahun_ajar', function (Blueprint $table) {
            // Besaran cashback per periode. 0 berarti periode itu tidak membuka cashback.
            $table->decimal('nominal_cashback', 12, 2)->default(0)->after('tahun_ajar');
        });
    }

    public function down(): void
    {
        Schema::table('tahun_ajar', function (Blueprint $table) {
            $table->dropColumn('nominal_cashback');
        });
    }
};
