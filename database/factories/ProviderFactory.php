<?php

namespace Database\Factories;

use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;


class ProviderFactory extends Factory
{
    protected $model = Provider::class;
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'nif' => '034807315',
            'telephone' => '602796989',
            'image' => 'https://static.vecteezy.com/system/resources/previews/005/337/799/non_2x/icon-image-not-found-free-vector.jpg',
            'isDeleted' => false,
        ];
    }
}

