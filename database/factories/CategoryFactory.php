<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'image' => 'https://thefoodtech.com/wp-content/uploads/2023/10/PANADERIA-PRINCIPAL-1.jpg',
            'isDeleted' => false,
        ];
    }
}
