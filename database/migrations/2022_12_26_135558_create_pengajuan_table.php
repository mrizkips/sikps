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
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->id();
            $table->enum('status', [0, 1, 2, 3, 4, 5])->comment('0 => Menunggu, 1 => Diterima, 2 => Ditolak, 3 => Belum bayar, 4 => Aktif, 5 => Lulus')->default(0);
            $table->enum('jenis', [1, 2, 3])->comment('1 => Proposal, 2 => Pra-sidang, 3 => Sidang');
            $table->timestamps();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa');
            $table->foreignId('proposal_id')->constrained('proposal');
            $table->foreignId('jadwal_pendaftaran_id')->constrained('jadwal_pendaftaran');
            $table->foreignId('tahun_akademik_id')->constrained('tahun_akademik');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengajuan');
    }
};
