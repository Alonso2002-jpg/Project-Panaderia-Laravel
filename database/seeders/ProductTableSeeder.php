<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::truncate();
        DB::table('products')->insert(
            [
                [
                    'id' => 'f1c3f5a4-bebd-4619-b136-ba2bcfbd5c9a',
                    'name' => 'Milk Bread',
                    'description' => 'Soft and fluffy bread enriched with milk, creating a tender crumb and a slightly sweet flavor.',
                    'price' => 2.5,
                    'stock' => 100,
                    'category_id' =>  4,
                    'provider_id' => 3
                ],
                [
                    'id' => Str::uuid(),
                    'name' => 'Chocolate Cookies',
                    'description' => 'Decadent cookies with rich cocoa flavor and a perfect balance of sweetness.',
                    'price' => 3.0,
                    'stock' => 150,
                    'category_id' => 2,
                    'provider_id' => 2
                ],
                [
                    'id' => Str::uuid(),
                    'name' => 'Mineral Water',
                    'description' => 'Refreshing and natural beverage packed with essential minerals.',
                    'price' => 1.0,
                    'stock' => 200,
                    'category_id' => 3,
                    'provider_id' => 4
                ],
                [
                    'id' => Str::uuid(),
                    'name' => 'Chocolate Cupcake',
                    'description' => 'Delightful and indulgent treat with rich chocolate flavor.',
                    'price' => 3.75,
                    'stock' => 50,
                    'category_id' => 5,
                    'provider_id' => 2
                ],
            ]
        );

    }
}
