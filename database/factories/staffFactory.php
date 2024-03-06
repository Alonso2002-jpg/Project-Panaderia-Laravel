<?php

namespace Database\Factories;

use App\Models\staff;
use Illuminate\Support\Carbon;

class staffFactory
{
    protected $model = staff::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'dni' => '03488998J',
            'email' => 'kevin@gamil.com',
            'lastname' => 'Doe',
            'image' => 'https://via.placeholder.com/150',
            'isDelete' => false,
        ];
    }
}
