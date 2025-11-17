<?php

namespace Database\Factories;

use App\Models\Block;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BlockFactory extends Factory
{
    public function definition(): array
    {
        return [
            'site_id' => 1,
            'name' => $this->faker->company(),
            'description' => $this->faker->sentence(),
            'water_price' => $this->faker->randomFloat(2, 0, 100),
            'electric_price' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
