<?php

namespace Database\Factories;

use App\Models\staff;

class staffFactory
{
    protected $model = staff::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'dni' => '03488998J',
            'email' => 'kevin@gamil.com',
            'lastname' => fake()->lastName(),
            'image' => 'https://via.placeholder.com/150',
            'isDelete' => false,
        ];
    }
}
