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
            ['name' => 'NOT CATEGORY',
                'image' => 'https://as1.ftcdn.net/v2/jpg/01/06/81/50/1000_F_106815012_XS82FPKIZDRDiCs4HJmUElRLTRW9HIvf.jpg'],
            ['name' => 'CANDIES',
             'image' => 'https://as1.ftcdn.net/v2/jpg/01/06/81/50/1000_F_106815012_XS82FPKIZDRDiCs4HJmUElRLTRW9HIvf.jpg'
            ],
            ['name' => 'DRINKS',
             'image' => 'https://i.redd.it/yyr6vtruhzbb1.jpg'
            ],
            ['name' => 'BREADS',
             'image' => 'https://www.datocms-assets.com/20941/1697039308-best-breads.jpg?auto=compress&fm=jpg&w=850'
            ],
            ['name' => 'CUPCAKES',
             'image' => 'https://www.barleyandsage.com/wp-content/uploads/2023/02/mini-cupcakes-1200x1200-1.jpg'
            ],
            ['name' => 'APPETIZERS',
             'image' => 'https://www.budgetbytes.com/wp-content/uploads/2023/10/Easy-Appetizers-H1.jpg'
            ],
            ['name' => 'CAKES',
             'image' => 'https://del.h-cdn.co/assets/16/38/1600x900/hd-aspect-1474650684-cakes-group-193.jpg'
            ],
            ['name' => 'COOKIES',
             'image' => 'https://thebigmansworld.com/wp-content/uploads/2022/10/vegan-cookie-recipes.jpg'
            ]
        ]);
    }
}
