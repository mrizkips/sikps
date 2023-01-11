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
        Schema::table('jadwal_pendaftaran', function (Blueprint $table) {
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
        Schema::table('jadwal_pendaftaran', function (Blueprint $table) {
            $table->dropConstrainedForeignId('tahun_akademik_id');
        });
    }
};
