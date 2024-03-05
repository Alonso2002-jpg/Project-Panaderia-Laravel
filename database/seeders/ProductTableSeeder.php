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
                [
                    'id' => Str::uuid(),
                    'name' => 'Chocolate Bar',
                    'description' => 'Rich and creamy chocolate bar perfect for indulging your sweet tooth.',
                    'price' => 2.0,
                    'stock' => 80,
                    'category_id' => 2, // ID de CANDIES
                    'provider_id' => 2, // ID de Sweet Distributions
                ],
                [
                    'id' => Str::uuid(),
                    'name' => 'Fruit Punch',
                    'description' => 'Refreshing fruit punch beverage bursting with fruity flavors.',
                    'price' => 1.5,
                    'stock' => 120,
                    'category_id' => 3, // ID de DRINKS
                    'provider_id' => 4, // ID de Drink Suppliers
                ],
                [
                    'id' => Str::uuid(),
                    'name' => 'Whole Wheat Bread',
                    'description' => 'Nutritious whole wheat bread with a hearty texture, perfect for sandwiches.',
                    'price' => 2.25,
                    'stock' => 90,
                    'category_id' => 4, // ID de BREADS
                    'provider_id' => 3, // ID de Flour and More
                ],
                [
                    'id' => Str::uuid(),
                    'name' => 'Vanilla Cupcake',
                    'description' => 'Delicate vanilla cupcake topped with smooth buttercream frosting.',
                    'price' => 3.0,
                    'stock' => 60,
                    'category_id' => 5, // ID de CUPCAKES
                    'provider_id' => 2, // ID de Sweet Distributions
                ],
                [
                    'id' => Str::uuid(),
                    'name' => 'Spinach Dip',
                    'description' => 'Creamy spinach dip served with crispy tortilla chips, perfect for sharing.',
                    'price' => 4.5,
                    'stock' => 40,
                    'category_id' => 6, // ID de APPETIZERS
                    'provider_id' => 1, // ID de SIN PROVEEDOR
                ],
                [
                    'id' => Str::uuid(),
                    'name' => 'Red Velvet Cake',
                    'description' => 'Decadent red velvet cake with cream cheese frosting, a classic favorite.',
                    'price' => 5.75,
                    'stock' => 30,
                    'category_id' => 7, // ID de CAKES
                    'provider_id' => 2, // ID de Sweet Distributions
                ],
                [
                    'id' => Str::uuid(),
                    'name' => 'Oatmeal Cookies',
                    'description' => 'Homemade oatmeal cookies with plump raisins and a hint of cinnamon.',
                    'price' => 2.75,
                    'stock' => 100,
                    'category_id' => 8, // ID de COOKIES
                    'provider_id' => 3, // ID de Flour and More
                ],
                [
                    'id' => Str::uuid(),
                    'name' => 'Iced Tea',
                    'description' => 'Refreshing iced tea made with freshly brewed tea leaves and a splash of lemon.',
                    'price' => 1.75,
                    'stock' => 150,
                    'category_id' => 3, // ID de DRINKS
                    'provider_id' => 4, // ID de Drink Suppliers
                ],
                [
                    'id' => Str::uuid(),
                    'name' => 'French Baguette',
                    'description' => 'Classic French baguette with a crispy crust and soft interior, perfect for dipping in olive oil.',
                    'price' => 3.0,
                    'stock' => 70,
                    'category_id' => 4, // ID de BREADS
                    'provider_id' => 3, // ID de Flour and More
                ],
                [
                    'id' => Str::uuid(),
                    'name' => 'Peanut Butter Cookies',
                    'description' => 'Buttery cookies packed with crunchy peanuts and creamy peanut butter flavor.',
                    'price' => 3.25,
                    'stock' => 80,
                    'category_id' => 8, // ID de COOKIES
                    'provider_id' => 2, // ID de Sweet Distributions
                ],
            ]
        );

    }
}
