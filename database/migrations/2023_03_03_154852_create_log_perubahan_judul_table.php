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
        Schema::create('log_perubahan_judul', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kp_skripsi_id')->constrained('kp_skripsi');
            $table->string('judul_lama');
            $table->string('judul_baru');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_perubahan_judul');
    }
};
