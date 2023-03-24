<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->insert([
        //     'name' => 'Administrator',
        //     'email' => 'administrator'.'@gmail.com',
        //     'password' => bcrypt('123456'),
        // ]);
        User::insert([
            'name' => 'Andini, S.Pd',
            'email' => 'administrator' . '@gmail.com',
            'password' => bcrypt('123456')
        ]);
    }
}
