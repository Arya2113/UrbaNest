<?php

namespace Database\Seeders;


 
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    
    public function run(): void
    {
        $this->call([
            AmenitySeeder::class,
            PropertySeeder::class,
            DeveloperSeeder::class,
            UserSeeder::class,
            ArchitectSeeder::class
        ]);
    }
}