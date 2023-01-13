<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AkademikPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $staff = Role::firstOrCreate(['name' => 'Staff']);
        $prodi = Role::firstOrCreate(['name' => 'Prodi']);
        $keuangan = Role::firstOrCreate(['name' => 'Keuangan']);
        $dosen = Role::firstOrCreate(['name' => 'Dosen']);
        $mahasiswa = Role::firstOrCreate(['name' => 'Mahasiswa']);

        $createAkademikPermission = Permission::findOrCreate('create akademik');
        $updateAkademikPermission = Permission::findOrCreate('update akademik');
        $deleteAkademikPermission = Permission::findOrCreate('delete akademik');
        $viewAnyAkademikPermission = Permission::findOrCreate('view any akademik');

        $admin->givePermissionTo([
            $createAkademikPermission,
            $updateAkademikPermission,
            $deleteAkademikPermission,
            $viewAnyAkademikPermission
        ]);

        $staff->givePermissionTo([
            $createAkademikPermission,
            $updateAkademikPermission,
            $deleteAkademikPermission,
            $viewAnyAkademikPermission
        ]);

        $prodi->givePermissionTo([
            $viewAnyAkademikPermission
        ]);

        $keuangan->givePermissionTo([
            $viewAnyAkademikPermission
        ]);

        $dosen->givePermissionTo([
            $viewAnyAkademikPermission
        ]);

        $mahasiswa->givePermissionTo([
            $viewAnyAkademikPermission
        ]);
    }
}
