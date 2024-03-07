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
                    'stock' => 5,
                    'image' => 'https://i2.wp.com/recetasecuatorianas.com/wp-content/uploads/2018/05/Receta-del-pan-de-leche.jpg?fit=900%2C600',
                    'category_id' =>  4,
                    'provider_id' => 3
                ],
                [
                    'id' => Str::uuid(),
                    'name' => 'Chocolate Cookies',
                    'description' => 'Decadent cookies with rich cocoa flavor and a perfect balance of sweetness.',
                    'price' => 3.0,
                    'stock' => 150,
                    'image' => 'https://scientificallysweet.com/wp-content/uploads/2020/04/IMG_4556-feature.jpg',
                    'category_id' => 2,
                    'provider_id' => 2
                ],
                [
                    'id' => Str::uuid(),
                    'name' => 'Mineral Water',
                    'description' => 'Refreshing and natural beverage packed with essential minerals.',
                    'price' => 1.0,
                    'stock' => 200,
                    'image' => 'https://prd-webrepository.firabarcelona.com/wp-content/uploads/2019/04/05132158/doce-envases-espanoles-entran-en-la-elite-del-packaging-mundial.jpg',
                    'category_id' => 3,
                    'provider_id' => 4
                ],
                [
                    'id' => Str::uuid(),
                    'name' => 'Chocolate Cupcake',
                    'description' => 'Delightful and indulgent treat with rich chocolate flavor.',
                    'price' => 3.75,
                    'stock' => 50,
                    'image' => 'https://www.iheartnaptime.net/wp-content/uploads/2022/10/chocolate-cupcakes-from-scratch.jpg',
                    'category_id' => 5,
                    'provider_id' => 2
                ],
                [
                    'id' => Str::uuid(),
                    'name' => 'Chocolate Bar',
                    'description' => 'Rich and creamy chocolate bar perfect for indulging your sweet tooth.',
                    'price' => 2.0,
                    'stock' => 80,
                    'image' => 'https://i.ebayimg.com/images/g/ecUAAOSw91ZhG4rW/s-l1200.webp',
                    'category_id' => 2, // ID de CANDIES
                    'provider_id' => 2, // ID de Sweet Distributions
                ],
                [
                    'id' => Str::uuid(),
                    'name' => 'Fruit Punch',
                    'description' => 'Refreshing fruit punch beverage bursting with fruity flavors.',
                    'price' => 1.5,
                    'stock' => 120,
                    'image' => 'https://pepsimidamerica.com/wp-content/uploads/2021/03/pepsi-mid-america-marion-illinois-hawaiian-punch-products.jpg',
                    'category_id' => 3, // ID de DRINKS
                    'provider_id' => 4, // ID de Drink Suppliers
                ],
                [
                    'id' => Str::uuid(),
                    'name' => 'Whole Wheat Bread',
                    'description' => 'Nutritious whole wheat bread with a hearty texture, perfect for sandwiches.',
                    'price' => 2.25,
                    'stock' => 90,
                    'image' => 'https://www.31daily.com/wp-content/uploads/2021/04/md-100-Whole-Wheat-Bread-11-1-of-1-scaled.jpg',
                    'category_id' => 4, // ID de BREADS
                    'provider_id' => 3, // ID de Flour and More
                ],
                [
                    'id' => Str::uuid(),
                    'name' => 'Vanilla Cupcake',
                    'description' => 'Delicate vanilla cupcake topped with smooth buttercream frosting.',
                    'price' => 3.0,
                    'stock' => 60,
                    'image' => 'https://joyfoodsunshine.com/wp-content/uploads/2021/12/best-vanilla-cupcakes-recipe-1x1-1.jpg',
                    'category_id' => 5, // ID de CUPCAKES
                    'provider_id' => 2, // ID de Sweet Distributions
                ],
                [
                    'id' => Str::uuid(),
                    'name' => 'Spinach Dip',
                    'description' => 'Creamy spinach dip served with crispy tortilla chips, perfect for sharing.',
                    'price' => 4.5,
                    'stock' => 40,
                    'image' => 'https://www.allrecipes.com/thmb/8kbhYaWoVfu0Pj9kLwmTvZKoxhE=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/228778-creamy-cheesy-spinach-dip-mfs-4-2e6cb097935f4b61981f575516d58fe6.jpg',
                    'category_id' => 6, // ID de APPETIZERS
                    'provider_id' => 1, // ID de SIN PROVEEDOR
                ],
                [
                    'id' => Str::uuid(),
                    'name' => 'Red Velvet Cake',
                    'description' => 'Decadent red velvet cake with cream cheese frosting, a classic favorite.',
                    'price' => 5.75,
                    'stock' => 30,
                    'image' => 'https://laneandgreyfare.com/wp-content/uploads/2022/02/Strawberry-Red-Velvet-Cake-1.jpg',
                    'category_id' => 7, // ID de CAKES
                    'provider_id' => 2, // ID de Sweet Distributions
                ],
                [
                    'id' => Str::uuid(),
                    'name' => 'Oatmeal Cookies',
                    'description' => 'Homemade oatmeal cookies with plump raisins and a hint of cinnamon.',
                    'price' => 2.75,
                    'stock' => 100,
                    'image' => 'https://www.wholesomeyum.com/wp-content/uploads/2023/11/wholesomeyum-Healthy-Oatmeal-Cookies-31.jpg',
                    'category_id' => 8, // ID de COOKIES
                    'provider_id' => 3, // ID de Flour and More
                ],
                [
                    'id' => Str::uuid(),
                    'name' => 'Iced Tea',
                    'description' => 'Refreshing iced tea made with freshly brewed tea leaves and a splash of lemon.',
                    'price' => 1.75,
                    'stock' => 150,
                    'image' => 'https://i5.walmartimages.com/asr/4265810e-5725-48c1-a715-fbf69f3c8946.7e4e1ac01b5109dd9e5744341a8c095f.jpeg?odnHeight=768&odnWidth=768&odnBg=FFFFFF',
                    'category_id' => 3, // ID de DRINKS
                    'provider_id' => 4, // ID de Drink Suppliers
                ],
                [
                    'id' => Str::uuid(),
                    'name' => 'French Baguette',
                    'description' => 'Classic French baguette with a crispy crust and soft interior, perfect for dipping in olive oil.',
                    'price' => 3.0,
                    'stock' => 70,
                    'image' => 'https://www.seriouseats.com/thmb/1zaAyK0pDdUhiIK-pvEDeC44lFc=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/20221109-BAGUETTE-ANDREW-JANJIGIAN-90-hero-01-af123a1fb939461384c94269db629642.JPG',
                    'category_id' => 4, // ID de BREADS
                    'provider_id' => 3, // ID de Flour and More
                ],
                [
                    'id' => Str::uuid(),
                    'name' => 'Peanut Butter Cookies',
                    'description' => 'Buttery cookies packed with crunchy peanuts and creamy peanut butter flavor.',
                    'price' => 3.25,
                    'stock' => 80,
                    'image' => 'https://www.smalltownwoman.com/wp-content/uploads/2018/10/Peanut-Butter-Cookies-Soft-Recipe-Cards.jpg',
                    'category_id' => 8, // ID de COOKIES
                    'provider_id' => 2, // ID de Sweet Distributions
                ],
            ]
        );

    }
}
