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
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->enum('status', [0, 1, 2, 3, 4, 5])->comment('0 => Menunggu, 1 => Diterima, 2 => Ditolak, 3 => Belum bayar, 4 => Aktif, 5 => Lulus')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->enum('status', [0, 1, 2, 3, 4])->comment('0 => Menunggu, 1 => Diterima, 2 => Ditolak, 3 => Belum bayar, 4 => Aktif')->default(0)->change();
        });
    }
};
