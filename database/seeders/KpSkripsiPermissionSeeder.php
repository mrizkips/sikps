<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class KpSkripsiPermissionSeeder extends Seeder
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

        $viewKpSkripsiPermission = Permission::findOrCreate('view kp skripsi');
        $viewAnyKpSkripsiPermission = Permission::findOrCreate('view any kp skripsi');
        $assignDosenKpSkripsiPermission = Permission::findOrCreate('assign dosen kp skripsi');
        $printFormBimbinganKpSkripsiPermission = Permission::findOrCreate('print form bimbingan kp skripsi');

        $admin->givePermissionTo([
            $viewKpSkripsiPermission,
            $viewAnyKpSkripsiPermission,
            $assignDosenKpSkripsiPermission,
            $printFormBimbinganKpSkripsiPermission
        ]);

        $staff->givePermissionTo([
            $viewKpSkripsiPermission,
            $viewAnyKpSkripsiPermission,
            $assignDosenKpSkripsiPermission,
            $printFormBimbinganKpSkripsiPermission
        ]);

        $prodi->givePermissionTo([
            $viewKpSkripsiPermission,
            $viewAnyKpSkripsiPermission,
        ]);

        $keuangan->givePermissionTo([
            $viewKpSkripsiPermission,
            $viewAnyKpSkripsiPermission,
        ]);

        $dosen->givePermissionTo([
            $viewKpSkripsiPermission,
            $viewAnyKpSkripsiPermission,
        ]);

        $mahasiswa->givePermissionTo([
            $viewKpSkripsiPermission,
            $printFormBimbinganKpSkripsiPermission
        ]);
    }
}
