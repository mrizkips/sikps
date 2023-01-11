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
        Schema::create('jadwal_pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->enum('jenis', [1, 2, 3])->comment('1 => Proposal, 2 => Pra-Sidang, 3 => Sidang');
            $table->date('tgl_pembukaan');
            $table->date('tgl_penutupan');
            $table->enum('semester', [1, 2, 3])->comment('1 => Ganjil, 2 => Genap, 3 => Antara');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jadwal_pendaftaran');
    }
};
