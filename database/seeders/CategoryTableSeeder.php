<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'SIN CATEGORY'],
            ['name' => 'CANDIES'],
            ['name' => 'DRINKS'],
            ['name' => 'BREADS'],
            ['name' => 'CUPCAKES']
        ]);
    }
}
