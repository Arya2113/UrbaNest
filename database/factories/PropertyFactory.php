<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\Amenity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'location' => $this->faker->location(),
            'price' => $this->faker->randomFloat(2, 100000000, 5000000000),
            'bedrooms' => $this->faker->numberBetween(1, 5),
            'bathrooms' => $this->faker->numberBetween(1, 4),
            'area' => $this->faker->randomFloat(2, 50, 500),
            'image_path' => $this->faker->imageUrl(640, 480, 'house', true),
            // Removed 'status' and 'environment_facilities'
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Property $property) {
            // Get all amenities
            $amenities = Amenity::all();

            // Attach a random number of amenities (between 1 and 3) to the property
            if ($amenities->count() > 0) {
                $randomAmenities = $amenities->random(rand(1, min(3, $amenities->count())));
                $property->amenities()->attach($randomAmenities->pluck('id'));
            }
        });
    }
}
