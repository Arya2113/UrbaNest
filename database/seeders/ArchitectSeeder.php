<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Architect;

class ArchitectSeeder extends Seeder
{
    public function run(): void
    {

        $architects = [
            [
                'name' => 'Raka Aditya',
                'photo' => 'photos/raka.jpg',
                'title' => 'Junior Architect',
                'rating' => 4.5,
                'reviews_count' => 35,
                'experience_years' => 3,
                'location' => 'Jakarta',
                'styles' => ['Minimalist', 'Modern'],
            ],
            [
                'name' => 'Nadya Putri',
                'photo' => 'photos/nadya.jpg',
                'title' => 'Interior Architect',
                'rating' => 4.6,
                'reviews_count' => 40,
                'experience_years' => 4,
                'location' => 'Bandung',
                'styles' => ['Classic', 'Contemporary'],
            ],
            [
                'name' => 'Fauzan Hidayat',
                'photo' => 'photos/fauzan.jpg',
                'title' => 'Design Architect',
                'rating' => 4.7,
                'reviews_count' => 50,
                'experience_years' => 5,
                'location' => 'Yogyakarta',
                'styles' => ['Industrial', 'Modern'],
            ],
            [
                'name' => 'Tiara Salsabila',
                'photo' => 'photos/tiara.jpg',
                'title' => 'Architect Consultant',
                'rating' => 4.4,
                'reviews_count' => 28,
                'experience_years' => 3,
                'location' => 'Surabaya',
                'styles' => ['Minimalist', 'Tropical'],
            ],
            [
                'name' => 'Daffa Alvaro',
                'photo' => 'photos/daffa.jpg',
                'title' => 'Concept Architect',
                'rating' => 4.8,
                'reviews_count' => 60,
                'experience_years' => 6,
                'location' => 'Depok',
                'styles' => ['Tropical', 'Modern'],
            ],
            [
                'name' => 'Zahra Lestari',
                'photo' => 'photos/zahra.jpg',
                'title' => 'Junior Architect',
                'rating' => 4.5,
                'reviews_count' => 38,
                'experience_years' => 2,
                'location' => 'Tangerang',
                'styles' => ['Classic', 'Contemporary'],
            ],
            [
                'name' => 'Rizky Maulana',
                'photo' => 'photos/rizky.jpg',
                'title' => 'Architect Designer',
                'rating' => 4.6,
                'reviews_count' => 42,
                'experience_years' => 4,
                'location' => 'Bekasi',
                'styles' => ['Modern', 'Futuristic'],
            ],
            [
                'name' => 'Keisha Ramadhani',
                'photo' => 'photos/keisha.jpg',
                'title' => 'Interior Architect',
                'rating' => 4.7,
                'reviews_count' => 55,
                'experience_years' => 5,
                'location' => 'Malang',
                'styles' => ['Contemporary', 'Classic'],
            ],
            [
                'name' => 'Iqbal Ferdiansyah',
                'photo' => 'photos/iqbal.jpg',
                'title' => 'Project Architect',
                'rating' => 4.3,
                'reviews_count' => 30,
                'experience_years' => 3,
                'location' => 'Bogor',
                'styles' => ['Minimalist', 'Industrial'],
            ],
            [
                'name' => 'Aulia Rahma',
                'photo' => 'photos/aulia.jpg',
                'title' => 'Sustainable Architect',
                'rating' => 4.9,
                'reviews_count' => 70,
                'experience_years' => 6,
                'location' => 'Semarang',
                'styles' => ['Eco-Friendly', 'Modern'],
            ],
        ];

        foreach ($architects as $architect) {
            Architect::create($architect);
        }
    }
}