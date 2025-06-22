<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class PropertyImageFactory extends Factory
{

    public function definition(): array
    {
        return [
            'image_url' => $this->faker->imageUrl(640, 480, 'house', true),
        ];
    }
}
