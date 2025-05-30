<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Developer;
use App\Models\Property;
use Faker\Factory as Faker;

class DeveloperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Create 5 developers
        for ($i = 1; $i <= 5; $i++) {
            $useEmail = $faker->boolean();
            $email = $useEmail ? $faker->unique()->safeEmail() : null;

            $developer = Developer::create([
                'name' => $faker->company,
                'email' => $email,
                'phone' => $faker->optional()->phoneNumber(),
                'description' => $faker->optional()->text(),
                'website' => $faker->optional()->url(),
            ]);

            // Assign properties to the developer (IDs 1 to 4 for developer 1, 5 to 8 for developer 2, etc.)
            $startPropertyId = (($i - 1) * 4) + 1;
            $endPropertyId = min($i * 4, 20); // Ensure we don't exceed property ID 20

            $properties = Property::whereBetween('id', [$startPropertyId, $endPropertyId])->get();

            foreach ($properties as $property) {
                $property->developer_id = $developer->id;
                $property->save();
            }
        }
    }
}
