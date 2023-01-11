<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PengajuanPermissionSeeder extends Seeder
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
        $mahasiswa = Role::firstOrCreate(['name' => 'Mahasiswa']);
        $dosen = Role::firstOrCreate(['name' => 'Dosen']);

        $createPengajuanPermission = Permission::findOrCreate('create pengajuan');
        $deletePengajuanPermission = Permission::findOrCreate('delete pengajuan');
        $viewAnyPengajuanPermission = Permission::findOrCreate('view any pengajuan');
        $viewPengajuanPermission = Permission::findOrCreate('view pengajuan');
        $acceptPengajuanPermission = Permission::findOrCreate('accept pengajuan');
        $rejectPengajuanPermission = Permission::findOrCreate('reject pengajuan');

        $admin->givePermissionTo([
            $viewAnyPengajuanPermission,
            $viewPengajuanPermission
        ]);

        $staff->givePermissionTo([
            $viewAnyPengajuanPermission,
            $viewPengajuanPermission
        ]);

        $prodi->givePermissionTo([
            $viewAnyPengajuanPermission,
            $viewPengajuanPermission,
            $acceptPengajuanPermission,
            $rejectPengajuanPermission,

        ]);

        $keuangan->givePermissionTo([
            $viewAnyPengajuanPermission,
            $viewPengajuanPermission,
            $acceptPengajuanPermission,
            $rejectPengajuanPermission,
        ]);

        $dosen->givePermissionTo([
            $viewAnyPengajuanPermission,
            $viewPengajuanPermission
        ]);

        $mahasiswa->givePermissionTo([
            $viewAnyPengajuanPermission,
            $viewPengajuanPermission,
            $createPengajuanPermission,
            $deletePengajuanPermission
        ]);
    }
}
