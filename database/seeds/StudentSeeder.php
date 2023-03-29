<?php

use App\Student;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 50; $i++) {
            $level = $faker->numberBetween($min = 10, $max = 12);
            $program = [
                'IPA',
                'IPS',
                'Bahasa',
            ];
            $chooseprogram = $program[rand(0, 2)];
            $room = $faker->numberBetween($min = 1, $max = 5);
            Student::insert([
                'code' => $faker->numerify('#########'),
                'name' => $faker->firstName . ' ' . $faker->lastName,
                'level' => $level,
                'program' => $chooseprogram,
                'room' => $room,
                'class' => $level . ' ' . $chooseprogram . ' ' . $room,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
