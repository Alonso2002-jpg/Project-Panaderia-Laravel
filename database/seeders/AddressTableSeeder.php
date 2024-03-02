<?php

namespace Database\Seeders;

use App\Models\Address;
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
        Address::truncate();
       DB::table('addresses')->insert([
           [
               'user_id' => 1,
               'name' => 'Paul',
               'lastName' => 'Loor',
               'dni' => '03480730B',
               'street' => 'Calle Polvoranca',
               'number' => '19, 1B',
               'city' => 'Leganés',
               'province' => 'Madrid',
               'country' => 'Spain',
               'postCode' => '28911',
           ],
           [
               'user_id' => 2,
               'name' => 'Camila',
               'lastName' => 'Flores',
               'dni' => '03780590W',
               'street' => 'Calle Lucitana',
               'number' => '7, 3B',
               'city' => 'Madrid',
               'province' => 'Madrid',
               'country' => 'Spain',
               'postCode' => '28716',
           ],
           [
               'user_id' => 3,
               'name' => 'Miguel',
               'lastName' => 'Zanotto',
               'dni' => '02480730Z',
               'street' => 'Av. Salamanca',
               'number' => '2, 1A',
               'city' => 'Madrid',
               'province' => 'Madrid',
               'country' => 'Spain',
               'postCode' => '28911',
           ],
           [
               'user_id' => 4,
               'name' => 'Alonso',
               'lastName' => 'Cruz',
               'dni' => '03460200C',
               'street' => 'Av. Rey Juan Carlos I',
               'number' => '80, 1C',
               'city' => 'Leganés',
               'province' => 'Madrid',
               'country' => 'Spain',
               'postCode' => '28916',
           ],
           [
               'user_id' => 5,
               'name' => 'Mayra',
               'lastName' => 'Tigse',
               'dni' => '03480880B',
               'street' => 'Calle Oporto',
               'number' => '68, 3A',
               'city' => 'Madrid',
               'province' => 'Madrid',
               'country' => 'Spain',
               'postCode' => '28929',
           ],
           [
               'user_id' => 1,
               'name' => 'Evelyn',
               'lastName' => 'Obando',
               'dni' => '03420780B',
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
