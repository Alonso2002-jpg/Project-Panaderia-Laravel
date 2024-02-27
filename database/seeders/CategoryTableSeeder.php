<?php

namespace Database\Seeders;

use App\Models\Category;
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
        Category::truncate();
        DB::table('categories')->insert([
            ['name' => 'SIN CATEGORY'],
            ['name' => 'CANDIES'],
            ['name' => 'DRINKS'],
            ['name' => 'BREADS'],
            ['name' => 'CUPCAKES']
        ]);
    }
}
