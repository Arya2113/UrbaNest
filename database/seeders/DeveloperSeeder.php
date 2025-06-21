<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Developer;
use App\Models\Property;

class DeveloperSeeder extends Seeder
{
    public function run(): void
    {
        $developerData = [
            [
                'name' => 'PT Rumah Indah',
                'email' => 'indah@developer.com',
                'phone' => '081234567890',
                'description' => 'Developer properti rumah tapak dan villa modern.',
                'website' => 'https://rumahindah.co.id',
            ],
            [
                'name' => 'CV Hunian Nyaman',
                'email' => 'nyaman@developer.com',
                'phone' => '089876543210',
                'description' => 'Spesialis properti minimalis di area urban.',
                'website' => 'https://hunian-nyaman.id',
            ],
            [
                'name' => 'Bali Dream Estates',
                'email' => 'dream@bali-estates.com',
                'phone' => '082112223333',
                'description' => 'Villa dan resort premium di Bali.',
                'website' => 'https://balidream.com',
            ],
            [
                'name' => 'Jakarta Living Co.',
                'email' => 'jakarta@living.co',
                'phone' => '0811000000',
                'description' => 'High-rise living in the heart of Jakarta.',
                'website' => 'https://jakartaliving.co.id',
            ],
            [
                'name' => 'Surabaya Property Group',
                'email' => 'surabaya@spg.id',
                'phone' => '087711223344',
                'description' => 'Properti keluarga di Jawa Timur.',
                'website' => 'https://spg-surabaya.id',
            ],
            [
                'name' => 'Bandung Skyline',
                'email' => 'info@bandungskyline.com',
                'phone' => '083355577799',
                'description' => 'Hunian modern dan asri di kawasan Bandung.',
                'website' => 'https://bandungskyline.com',
            ],
        ];

        // Buat semua developer lengkap
        $developers = collect();
        foreach ($developerData as $data) {
            $developers->push(Developer::create($data));
        }

        // Acak dan assign semua properti ke developer random
        $properties = Property::all()->shuffle();

        foreach ($properties as $property) {
            $property->developer_id = $developers->random()->id;
            $property->save();
        }
    }
}