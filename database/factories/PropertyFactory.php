<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\Amenity;
use App\Models\PropertyImage;
use Illuminate\Database\Eloquent\Factories\Factory;


class PropertyFactory extends Factory
{

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'location' => $this->faker->city(),
            'address' => $this->faker->address(),  
            'price' => $this->faker->randomFloat(2, 100000000, 5000000000),
            'bedrooms' => $this->faker->numberBetween(1, 5),
            'bathrooms' => $this->faker->numberBetween(1, 4),
            'area' => $this->faker->randomFloat(2, 50, 500),
            'image_path' => $this->faker->imageUrl(640, 480, 'house', true),  
             
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Property $property) {
             
            $amenities = Amenity::all();

             
            if ($amenities->count() > 0) {
                $randomAmenities = $amenities->random(rand(1, min(3, $amenities->count())));
                $property->amenities()->attach($randomAmenities->pluck('id'));
            }

             
            PropertyImage::factory()->count(3)->create([
                'property_id' => $property->id,
            ]);
        });
    }
}
