<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    public function definition(): array
    {
        return [
        'description' => fake(),
        'name' => fake()->name,
        'price' => fake()->randomFloat(2, 1, 100),
        'stock' => fake()->numberBetween(0,100),
        'image' => 'https://static.vecteezy.com/system/resources/previews/005/337/799/non_2x/icon-image-not-found-free-vector.jpg',
        'category_id' => 1,
        'provider_id' => 1,
        ];
    }
}
