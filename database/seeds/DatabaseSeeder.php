<?php

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
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(KbbTableSeeder::class);
        $this->call(JurusanSeeder::class);
        $this->call(FormPenilaianSeeder::class);
        $this->call(FormPenilaianItemSeeder::class);
    }
}
