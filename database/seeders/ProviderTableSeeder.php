<?php

namespace Database\Seeders;

use App\Models\Provider;
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
        Provider::truncate();
        DB::table('providers')->insert([
            [
                'name' => 'SIN PROVEEDOR',
                'nif' => '00000000A',
                'telephone' => '000000000',
            ],
          [
              'name' => 'Sweet Distributions',
              'nif' => '12345678A',
              'telephone' => '123456789',
          ],
            [
                'name' => 'Flour and More',
                'nif' => '98765432B',
                'telephone' => '987654321',
            ],
            [
                'name' => 'Drink Suppliers',
                'nif' => '87654321C',
                'telephone' => '123987456',
            ],
        ]);
    }
}
