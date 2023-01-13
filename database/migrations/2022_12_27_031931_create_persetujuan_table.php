<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persetujuan', function (Blueprint $table) {
            $table->id();
            $table->enum('status', [0, 1, 2])->comment('0 => Menunggu, 1 => Diterima, 2 => Ditolak')->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('pengajuan_id')->constrained('pengajuan')->onDelete('cascade');
            $table->string('role_name');
            $table->foreign('role_name')->references('name')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persetujuan');
    }
};
