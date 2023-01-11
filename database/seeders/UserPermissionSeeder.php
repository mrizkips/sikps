<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserPermissionSeeder extends Seeder
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

        $createUserPermission = Permission::findOrCreate('create user');
        $updateUserPermission = Permission::findOrCreate('update user');
        $deleteUserPermission = Permission::findOrCreate('delete user');
        $viewAnyUserPermission = Permission::findOrCreate('view any user');
        $viewUserPermission = Permission::findOrCreate('view user');

        $admin->givePermissionTo([
            $createUserPermission,
            $updateUserPermission,
            $deleteUserPermission,
            $viewAnyUserPermission,
            $viewUserPermission
        ]);

        $staff->givePermissionTo([
            $createUserPermission,
            $updateUserPermission,
            $deleteUserPermission,
            $viewAnyUserPermission,
            $viewUserPermission
        ]);

        $prodi->givePermissionTo([
            $viewAnyUserPermission,
            $viewUserPermission
        ]);

        $keuangan->givePermissionTo([
            $viewAnyUserPermission,
            $viewUserPermission
        ]);

        $mahasiswa->givePermissionTo([
            $viewUserPermission
        ]);

        $dosen->givePermissionTo([
            $viewAnyUserPermission,
            $viewUserPermission
        ]);
    }
}
