<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       DB::table('address')->insert([
           [
               'street' => 'Calle Polvoranca',
               'number' => '19, 1B',
               'city' => 'Leganés',
               'province' => 'Madrid',
               'country' => 'Spain',
               'postCode' => '28911',
           ],
           [
               'street' => 'Calle Lucitana',
               'number' => '7, 3B',
               'city' => 'Madrid',
               'province' => 'Madrid',
               'country' => 'Spain',
               'postCode' => '28716',
           ],
           [
               'street' => 'Av. Salamanca',
               'number' => '2, 1A',
               'city' => 'Madrid',
               'province' => 'Madrid',
               'country' => 'Spain',
               'postCode' => '28911',
           ],
           [
               'street' => 'Av. Rey Juan Carlos I',
               'number' => '80, 1C',
               'city' => 'Leganés',
               'province' => 'Madrid',
               'country' => 'Spain',
               'postCode' => '28916',
           ],
           [
               'street' => 'Calle Oporto',
               'number' => '68, 3A',
               'city' => 'Madrid',
               'province' => 'Madrid',
               'country' => 'Spain',
               'postCode' => '28929',
           ],
           [
               'street' => 'Grove Hill',
               'number' => '3, 2C',
               'city' => 'Madrid',
               'province' => 'Madrid',
               'country' => 'Spain',
               'postCode' => '28978',
           ],
       ]);
    }
}
