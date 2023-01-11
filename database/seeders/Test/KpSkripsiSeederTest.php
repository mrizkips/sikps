<?php

namespace Database\Seeders\Test;

use App\Models\Dosen;
use App\Models\KpSkripsi;
use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Database\Seeder;

class KpSkripsiSeederTest extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PengajuanSeederTest::class);

        $pengajuan = Pengajuan::first();
        $pengajuan->update(['status' => 4]);

        $dosen = User::create([
            'nama' => 'Dosen',
            'username' => 'DN',
            'password' => 'DN',
        ])->assignRole('Dosen');

        $dosen->dosen()->create([
            'kd_dosen' => 'DN',
            'nama' => 'Dosen',
            'inisial' => 'DN',
        ]);

        KpSkripsi::create([
            'jenis' => $pengajuan->proposal->jenis == 'Kerja Praktek' ? 1 : 2,
            'proposal_id' => $pengajuan->proposal_id,
            'mahasiswa_id' => $pengajuan->mahasiswa_id,
            'pengajuan_id' => $pengajuan->id,
            'tahun_akademik_id' => $pengajuan->tahun_akademik_id,
            'jadwal_pendaftaran_id' => $pengajuan->jadwal_pendaftaran_id,
        ]);
    }
}
