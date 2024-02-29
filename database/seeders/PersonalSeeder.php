<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PersonalSeeder extends Seeder
{
    public function run()
    {

        DB::table('staff')->insert([

            [
                'id' => (string)Str::uuid(),
                'name' => 'Juan',
                'dni' => '12345678',
                'lastname' => 'Perez',
                'email' => 'juan@gmail.com',
                'startDate' => '2024-02-20',
                'endDate' => '2024-02-20',
                'role' => 'cocinero',
                'image' => 'https://via.placeholder.com/150',
            ],
            [
                'id' => (string)Str::uuid(),
                'name' => 'Pedro',
                'dni' => '87654321',
                'lastname' => 'Gomez',
                'email' => 'Gomez@gmail.com',
                'startDate' => '2024-02-20',
                'endDate' => '2024-02-20',
                'role' => 'vendedor',
                'image' => 'https://via.placeholder.com/150',
            ],
        ]);

    }
}
