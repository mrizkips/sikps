<?php

namespace Database\Seeders\Test;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MahasiswaSeederTest extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'nama' => 'Rizki Pratama',
            'username' => '3218609',
            'password' => '3218609',
        ]);

        $user->assignRole('Mahasiswa');

        $user->mahasiswa()->create([
            'nim' => '3218609',
            'nama' => 'Rizki Pratama',
            'jurusan' => 1
        ]);
    }
}
