<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProviderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        DB::table('providers')->insert([
          [
              'name' => 'Sweet Distributions',
              'nif' => '12345678A',
              'telephone' => '123-45-6789',
          ],
            [
                'name' => 'Flour and More',
                'nif' => '98765432B',
                'telephone' => '987-65-4321',
            ],
            [
                'name' => 'Drink Suppliers',
                'nif' => '87654321C',
                'telephone' => '123-98-7456',
            ],
        ]);
    }
}
