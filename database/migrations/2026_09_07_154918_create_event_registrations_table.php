<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->string('nama');
            $table->string('email');
            $table->string('no_wa', 20);
            $table->string('asal_kota')->nullable();
            $table->enum('follow_verified', ['yes', 'no'])->default('no');
            $table->enum('zoom_sent', ['yes', 'no'])->default('no');
            $table->enum('reminder_sent', ['yes', 'no'])->default('no');
            $table->enum('attended', ['yes', 'no'])->default('no');
            $table->enum('sertif_sent', ['yes', 'no'])->default('no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_registrations');
    }
};
