<?php

namespace App\Imports;

use App\Models\Dosen;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserDosenImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collections
    */
    public function collection(Collection $collections)
    {
        DB::beginTransaction();
        foreach ($collections as $collection) {
            $nama = str($collection['nama'])->trim();
            $kdDosen = str($collection['kode_dosen'])->trim();
            $nidn = str($collection['nidn'])->trim();
            $inisial = str($collection['inisial'])->trim();
            $jk = str($collection['jenis_kelamin'])->upper();

            $user = User::updateOrCreate(
                ['username' => $kdDosen],
                ['nama' => $nama, 'password' => $kdDosen . '@sikps', 'jk' => $jk],
            );

            $user->assignRole('Dosen');

            Dosen::updateOrCreate(
                ['kd_dosen' => $kdDosen],
                ['nama' => $nama, 'nidn' => $nidn == 'NULL' ? null : $nidn, 'user_id' => $user->id, 'inisial' => $inisial == 'NULL' ? null : $inisial],
            );
        }
        DB::commit();
    }
}
