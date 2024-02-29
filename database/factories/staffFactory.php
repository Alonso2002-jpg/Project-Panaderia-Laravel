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
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'uuid' => $this->faker->uuid(),
            'name' => $this->faker->name(),
            'dni' => $this->faker->word(),
            'lastname' => $this->faker->lastName(),
            'startDate' => Carbon::now(),
            'endDate' => Carbon::now(),
            'updateDate' => Carbon::now(),
            'creationDate' => Carbon::now(),
            'image' => $this->faker->word(),
        ];
    }
}
