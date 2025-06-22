<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\Amenity;
use App\Models\propertyImage;
class PropertySeeder extends Seeder
{

    public function run(): void
    {
        $properties = [
            [
                'title' => 'Villa Santai di Ubud',
                'description' => 'Villa mewah dengan kolam renang pribadi dan view hutan tropis.',
                'location' => 'Ubud, Bali',
                'address' => 'Jl. Raya Nyuh Kuning No.10',
                'price' => 3500000000,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'area' => 240,
            ],
            [
                'title' => 'Rumah Minimalis Bintaro',
                'description' => 'Rumah dua lantai dengan desain modern dan garasi luas.',
                'location' => 'Bintaro, Tangerang Selatan',
                'address' => 'Jl. RC Veteran No.21',
                'price' => 1700000000,
                'bedrooms' => 4,
                'bathrooms' => 3,
                'area' => 180,
            ],
            [
                'title' => 'Villa Laut Jimbaran',
                'description' => 'Villa dengan akses langsung ke pantai dan sunset epic tiap sore.',
                'location' => 'Jimbaran, Bali',
                'address' => 'Jl. Bukit Permai No.9',
                'price' => 4750000000,
                'bedrooms' => 5,
                'bathrooms' => 4,
                'area' => 420,
            ],
            [
                'title' => 'Rumah Asri di Dago',
                'description' => 'Rumah nyaman dengan udara sejuk dan kebun belakang.',
                'location' => 'Dago, Bandung',
                'address' => 'Jl. Dago Pakar No.5',
                'price' => 2500000000,
                'bedrooms' => 4,
                'bathrooms' => 3,
                'area' => 300,
            ],
            [
                'title' => 'Townhouse BSD City',
                'description' => 'Cluster elite dekat ICE BSD, cocok buat keluarga muda.',
                'location' => 'BSD City, Tangerang',
                'address' => 'Jl. Anggrek Loka No.3',
                'price' => 1900000000,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'area' => 160,
            ],
            [
                'title' => 'Villa Lembang View Gunung',
                'description' => 'Suasana tenang dengan panorama gunung dan udara segar.',
                'location' => 'Lembang, Bandung',
                'address' => 'Jl. Sersan Bajuri No.88',
                'price' => 2200000000,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'area' => 250,
            ],
            [
                'title' => 'Rumah Klasik Menteng',
                'description' => 'Bangunan heritage yang cocok untuk kantor atau hunian.',
                'location' => 'Menteng, Jakarta',
                'address' => 'Jl. Diponegoro No.12',
                'price' => 4900000000,
                'bedrooms' => 5,
                'bathrooms' => 4,
                'area' => 400,
            ],
            [
                'title' => 'Villa Private Pool Canggu',
                'description' => 'Lokasi strategis, desain tropikal, 10 menit ke Pantai Batu Bolong.',
                'location' => 'Canggu, Bali',
                'address' => 'Jl. Pantai Berawa No.55',
                'price' => 3750000000,
                'bedrooms' => 4,
                'bathrooms' => 3,
                'area' => 280,
            ],
            [
                'title' => 'Rumah Cluster Bekasi Timur',
                'description' => 'Dekat tol dan fasilitas umum, harga bersahabat.',
                'location' => 'Bekasi Timur',
                'address' => 'Jl. KH Noer Ali No.88',
                'price' => 950000000,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'area' => 140,
            ],
        ];
        foreach ($properties as $index => $data) {
            $number = $index + 1;  
            $data['image_path'] =  "properties/" ."{$number}_1.png";

            $property = Property::create($data);

             
            $amenities = Amenity::inRandomOrder()->limit(rand(2, 3))->pluck('id');
            $property->amenities()->attach($amenities);

             
            for ($i = 2; $i <= 3; $i++) {
                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_url' => "properties/"."{$number}_{$i}.png",
                ]);
            }
        }

    }
}
