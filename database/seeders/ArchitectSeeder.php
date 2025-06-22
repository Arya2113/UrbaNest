<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Architect;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ArchitectSeeder extends Seeder
{
    public function run(): void
    {
        $architects = [
            [
                'name' => 'Raka Aditya',
                'email' => 'raka@example.com',
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
                'email' => 'nadya@example.com',
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
                'email' => 'fauzan@example.com',
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
                'email' => 'tiara@example.com',
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
                'email' => 'daffa@example.com',
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
                'email' => 'zahra@example.com',
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
                'email' => 'rizky@example.com',
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
                'email' => 'keisha@example.com',
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
                'email' => 'iqbal@example.com',
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
                'email' => 'aulia@example.com',
                'photo' => 'photos/aulia.jpg',
                'title' => 'Sustainable Architect',
                'rating' => 4.9,
                'reviews_count' => 70,
                'experience_years' => 6,
                'location' => 'Semarang',
                'styles' => ['Eco-Friendly', 'Modern'],
            ],
        ];

        foreach ($architects as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => '08' . rand(1000000000, 9999999999),
                'password' => Hash::make('architect123'),
                'role' => 'architect',
                'email_verified_at' => now(),
            ]);

            Architect::create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'photo' => $data['photo'],
                'title' => $data['title'],
                'rating' => $data['rating'],
                'reviews_count' => $data['reviews_count'],
                'experience_years' => $data['experience_years'],
                'location' => $data['location'],
                'styles' => $data['styles'],
            ]);
        }
    }
}