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
