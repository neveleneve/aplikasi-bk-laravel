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
        $this->call(UsersTableSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(SubServiceSeeder::class);
        $this->call(MapelSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(GuruSeeder::class);
    }
}
