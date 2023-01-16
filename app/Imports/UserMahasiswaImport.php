<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserMahasiswaImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collections
    */
    public function collection(Collection $collections)
    {
        DB::beginTransaction();
        foreach ($collections as $collection) {
            $nim = $collection['nim'];
            $jurusan = str($nim)->is('32*') ? '1' : (str($nim)->is('12*') ? '2' : false);
            $nama = $collection['nama'];
            $jk = str($collection['jenis_kelamin'])->upper();

            $user = User::updateOrCreate(
                ['username' => $nim],
                ['nama' => $nama, 'password' => $nim . '@sikps', 'jk' => $jk]
            );

            $user->assignRole('Mahasiswa');

            Mahasiswa::updateOrCreate(
                ['nim' => $nim],
                ['nama' => $nama, 'jurusan' => $jurusan, 'user_id' => $user->id]
            );
        }
        DB::commit();
    }
}
