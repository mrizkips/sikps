<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ProposalPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mahasiswa = Role::firstOrCreate(['name' => 'Mahasiswa']);

        $createProposalPermission = Permission::findOrCreate('create proposal');
        $updateProposalPermission = Permission::findOrCreate('update proposal');
        $deleteProposalPermission = Permission::findOrCreate('delete proposal');
        $viewAnyProposalPermission = Permission::findOrCreate('view any proposal');
        $viewProposalPermission = Permission::findOrCreate('view proposal');

        $mahasiswa->givePermissionTo([
            $createProposalPermission,
            $updateProposalPermission,
            $deleteProposalPermission,
            $viewAnyProposalPermission,
            $viewProposalPermission
        ]);
    }
}
