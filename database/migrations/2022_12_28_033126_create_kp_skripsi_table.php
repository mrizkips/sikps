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
        Schema::create('kp_skripsi', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis', [1, 2])->comment('1 => Kerja Praktek, 2 => Skripsi');
            $table->smallInteger('form_bimbingan_printed_count')->default(0);
            $table->timestamp('form_bimbingan_last_printed_at')->nullable();
            $table->timestamps();
            $table->foreignId('proposal_id')->constrained('proposal');
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa');
            $table->foreignId('pengajuan_id')->constrained('pengajuan');
            $table->foreignId('tahun_akademik_id')->constrained('tahun_akademik');
            $table->foreignId('jadwal_pendaftaran_id')->constrained('jadwal_pendaftaran');
            $table->foreignId('dosen_pembimbing_id')->nullable()->constrained('dosen');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kp_skripsi');
    }
};
