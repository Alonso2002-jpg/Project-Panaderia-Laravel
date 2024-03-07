<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    public function definition(): array
    {
        $category = Category::inRandomOrder()->first();
        $provider = Provider::inRandomOrder()->first();
        return [
        'description' => fake()->text(),
        'name' => fake()->name,
        'price' => fake()->randomFloat(2, 1, 100),
        'stock' => fake()->numberBetween(0,100),
        'image' => 'https://static.vecteezy.com/system/resources/previews/005/337/799/non_2x/icon-image-not-found-free-vector.jpg',
        'category_id' => $category->id,
        'provider_id' => $provider->id,
        ];
    }
}
