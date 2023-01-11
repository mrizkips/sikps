<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserRoleSeeder::class);
        $this->call(UserPermissionSeeder::class);
        $this->call(AkademikPermissionSeeder::class);
        $this->call(ProposalPermissionSeeder::class);
        $this->call(PengajuanPermissionSeeder::class);
        $this->call(KpSkripsiPermissionSeeder::class);
    }
}
