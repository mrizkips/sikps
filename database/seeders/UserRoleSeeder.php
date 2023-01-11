<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleAdmin = Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'Staff']);
        Role::firstOrCreate(['name' => 'Prodi']);
        Role::firstOrCreate(['name' => 'Keuangan']);
        Role::firstOrCreate(['name' => 'Mahasiswa']);
        Role::firstOrCreate(['name' => 'Dosen']);

        DB::table('users')->insert([
            'nama' => 'Admin',
            'username' => 'admin',
            'password' => '$2a$12$R1dvootxVSdpNxEOp.qO0.m7.o.ouPHIQFEfm3BGcFxUSNzgnDzBu',
        ]);

        $admin = User::first();
        $admin->assignRole($roleAdmin);
    }
}
