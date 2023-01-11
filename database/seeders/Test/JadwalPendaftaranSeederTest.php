<?php

namespace Database\Seeders\Test;

use App\Models\TahunAkademik;
use Illuminate\Database\Seeder;

class JadwalPendaftaranSeederTest extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TahunAkademikSeederTest::class);

        $tahunAkademik = TahunAkademik::first();

        $tahunAkademik->jadwalPendaftaran()->create([
            'judul' => 'Pendaftaran Proposal',
            'jenis' => 1,
            'tgl_pembukaan' => now(),
            'tgl_penutupan' => now(),
            'semester' => 1,
        ]);
    }
}
