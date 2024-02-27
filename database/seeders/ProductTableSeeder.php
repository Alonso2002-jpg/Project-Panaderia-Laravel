<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert(
            [
             [
                 'id' => 'f1c3f5a4-bebd-4619-b136-ba2bcfbd5c9a',
                 'name' => 'Milk Bread',
                 'description' => 'Milk bread is a soft and fluffy type of bread enriched with milk, creating a tender crumb and a slightly sweet flavor. This popular Asian-inspired bread is characterized by its light texture, making it perfect for sandwiches, toasts, or enjoying on its own. The addition of milk contributes to its rich and delightful taste, setting it apart from regular white bread. Milk bread is a versatile and beloved choice, known for its comforting and delicate qualities.',
                 'price' => 2.5,
                 'stock' => 100,
                 'image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Ffood52.com%2Frecipes%2F89860-best-milk-bread&psig=AOvVaw3iyJIto_Vk6u5nfx6zhrdO&ust=1709137107926000&source=images&cd=vfe&opi=89978449&ved=0CBIQjRxqFwoTCOihhoT2y4QDFQAAAAAdAAAAABAE',
                 'category_id' =>  4,
                 'provider_id' => 3
             ],
                [
                    'id' => '8f1849c9-8885-4b3f-bd82-d919d585ce04',
                    'name' => 'Chocolate Cookies',
                    'description' => 'Chocolate cookies are a decadent treat that indulges the senses with rich cocoa flavor and a perfect balance of sweetness. These delightful cookies boast a chewy or crisp texture, depending on your preference, and are often studded with melty chocolate chips or chunks. The combination of butter, sugar, and high-quality cocoa results in a heavenly aroma as they bake. Whether enjoyed with a glass of milk, shared with friends, or savored as a solo indulgence, chocolate cookies are a timeless and irresistible delight for chocolate enthusiasts.',
                    'price' =>  3.0,
                 'stock' =>   150,
                 'image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Flevaduramadre.es%2Fproducto%2Fcookie-de-chocolate%2F&psig=AOvVaw1Y7omC7OKtcLWpO8b7Cg5P&ust=1709137197801000&source=images&cd=vfe&opi=89978449&ved=0CBIQjRxqFwoTCJD2obH2y4QDFQAAAAAdAAAAABAJ',
                 'category_id' =>  2,
                 'provider_id' => 2
             ],
                [
                    'id' => '44f01f9a-db5b-4dbf-aff4-074644a0391e',
                    'name' => 'Mineral Water',
                    'description' => 'Mineral water is a refreshing and natural beverage sourced from underground springs or wells. It is distinguished by its crisp and clean taste, free from artificial additives. Packed with essential minerals such as calcium, magnesium, and potassium, mineral water offers a hydrating experience with potential health benefits. Its natural purity and low calorie content make it a popular choice for those seeking a healthy and refreshing alternative to other beverages. Enjoyed chilled or at room temperature, mineral water is a thirst-quenching option that promotes well-being and hydration',
                    'price' =>  1.0,
                 'stock' =>  200,
                 'image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.craiyon.com%2Fimage%2F994-sAMsTeWrm16-rkQKQw&psig=AOvVaw0f5_d6VcGery8pKylVV8-d&ust=1709137382677000&source=images&cd=vfe&opi=89978449&ved=0CBIQjRxqFwoTCPCdoIv3y4QDFQAAAAAdAAAAABAX',
                 'category_id' =>  3,
                 'provider_id' => 4
             ],
                [
                    'id' => '207e2679-defb-4944-9791-fc270fa62669',
                    'name' => 'Chocolate Cupcake',
                    'description' => 'Chocolate cupcakes are a delightful and indulgent treat that satisfies sweet cravings with rich, moist goodness. These miniature cakes are infused with premium cocoa, creating a deep and luscious chocolate flavor. Topped with velvety chocolate frosting, sprinkles, or other delightful decorations, chocolate cupcakes offer a visually appealing and scrumptious experience. Whether enjoyed as a standalone dessert, part of a celebration, or paired with a scoop of ice cream, these delectable treats are a favorite among chocolate enthusiasts for their perfect balance of sweetness and cocoa richness.',
                    'price' =>  3.75,
                 'stock' =>    50,
                 'image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Flacavacakery.com%2F&psig=AOvVaw0jSJ4ng4_lirS-fXJW_DA0&ust=1709137513297000&source=images&cd=vfe&opi=89978449&ved=0CBIQjRxqFwoTCJCazsX3y4QDFQAAAAAdAAAAABAJ',
                 'category_id' =>  5,
                 'provider_id' => 2
             ],
            ]
        );
    }
}
