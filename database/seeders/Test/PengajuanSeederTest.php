<?php

namespace Database\Seeders\Test;

use App\Models\JadwalPendaftaran;
use App\Models\Mahasiswa;
use App\Models\Proposal;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PengajuanSeederTest extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(JadwalPendaftaranSeederTest::class);
        $this->call(MahasiswaSeederTest::class);

        Storage::fake('local');
        $file = UploadedFile::fake()->create('document.pdf', 1024);

        $proposal = Proposal::create([
            'judul' => fake()->text(20),
            'jenis' => fake()->randomElement(['1', '2']),
            'file_proposal' => $file,
            'deskripsi' => fake()->text(100),
            'organisasi' => fake()->company(),
            'mahasiswa_id' => Mahasiswa::first()->id,
        ]);

        $proposal->submit(JadwalPendaftaran::first()->id, Mahasiswa::first());
    }
}
