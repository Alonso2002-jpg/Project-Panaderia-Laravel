<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('clients')->insert([
           [
            'address_id' => 1,
            'fullName' => 'Joselyn Carolina Obando',
            'dni' => '01480793B',
            'telephone' => '622668595',
           ],
            [
                'address_id' => 2,
                'fullName' => 'Miguel Angel Zanotto Rojas',
                'dni' => '07880793T',
                'telephone' => '922558595',
            ],
            [
                'address_id' => 3,
                'fullName' => 'Jorge Alonso Cruz Vera',
                'dni' => '03320793Z',
                'telephone' => '813507295',
            ],
            [
                'address_id' => 4,
                'fullName' => 'Laura Garrido',
                'dni' => '09920823V',
                'telephone' => '722507295',
            ],
            [
                'address_id' => 5,
                'fullName' => 'Kevin Bermudez',
                'dni' => '09988923K',
                'telephone' => '633759095',
            ],
            [
                'address_id' => 6,
                'fullName' => 'Evelyn Obando',
                'dni' => '01321755E',
                'telephone' => '733889021',
            ]
        ]);
    }
}


