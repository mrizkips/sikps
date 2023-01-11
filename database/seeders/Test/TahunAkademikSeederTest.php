<?php

namespace Database\Seeders\Test;

use App\Models\TahunAkademik;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TahunAkademikSeederTest extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TahunAkademik::create([
            'nama' => '2022/2023',
            'tahun_awal' => 2022,
            'tahun_akhir' => 2023
        ]);
    }
}
