<?php

use App\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Student::insert([
            [
                'code' => '192039485',
                'name' => 'Andriyan',
                'level' => '10',
                'program' => 'IPA',
                'room' => '2',
                'class' => '10 IPA 2',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'code' => '918291039',
                'name' => 'Budiyanto',
                'level' => '12',
                'program' => 'IPS',
                'room' => '4',
                'class' => '11 IPS 4',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}
