<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\Amenity;
use App\Models\propertyImage;
class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $properties = [
            [
                'title' => 'Villa Santai di Ubud',
                'description' => 'Villa mewah dengan kolam renang pribadi dan view hutan tropis.',
                'location' => 'Ubud, Bali',
                'alamat' => 'Jl. Raya Nyuh Kuning No.10',
                'price' => 3500000000,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'area' => 240,
                'image_path' => 'https://via.placeholder.com/640x480.png?text=Villa+Ubud',
            ],
            [
                'title' => 'Rumah Minimalis Bintaro',
                'description' => 'Rumah dua lantai dengan desain modern dan garasi luas.',
                'location' => 'Bintaro, Tangerang Selatan',
                'alamat' => 'Jl. RC Veteran No.21',
                'price' => 1700000000,
                'bedrooms' => 4,
                'bathrooms' => 3,
                'area' => 180,
                'image_path' => 'https://via.placeholder.com/640x480.png?text=Rumah+Bintaro',
            ],
            [
                'title' => 'Villa Laut Jimbaran',
                'description' => 'Villa dengan akses langsung ke pantai dan sunset epic tiap sore.',
                'location' => 'Jimbaran, Bali',
                'alamat' => 'Jl. Bukit Permai No.9',
                'price' => 4750000000,
                'bedrooms' => 5,
                'bathrooms' => 4,
                'area' => 420,
                'image_path' => 'https://via.placeholder.com/640x480.png?text=Villa+Jimbaran',
            ],
            [
                'title' => 'Rumah Asri di Dago',
                'description' => 'Rumah nyaman dengan udara sejuk dan kebun belakang.',
                'location' => 'Dago, Bandung',
                'alamat' => 'Jl. Dago Pakar No.5',
                'price' => 2500000000,
                'bedrooms' => 4,
                'bathrooms' => 3,
                'area' => 300,
                'image_path' => 'https://via.placeholder.com/640x480.png?text=Rumah+Dago',
            ],
            [
                'title' => 'Townhouse BSD City',
                'description' => 'Cluster elite dekat ICE BSD, cocok buat keluarga muda.',
                'location' => 'BSD City, Tangerang',
                'alamat' => 'Jl. Anggrek Loka No.3',
                'price' => 1900000000,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'area' => 160,
                'image_path' => 'https://via.placeholder.com/640x480.png?text=Rumah+BSD',
            ],
            [
                'title' => 'Villa Lembang View Gunung',
                'description' => 'Suasana tenang dengan panorama gunung dan udara segar.',
                'location' => 'Lembang, Bandung',
                'alamat' => 'Jl. Sersan Bajuri No.88',
                'price' => 2200000000,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'area' => 250,
                'image_path' => 'https://via.placeholder.com/640x480.png?text=Villa+Lembang',
            ],
            [
                'title' => 'Rumah Klasik Menteng',
                'description' => 'Bangunan heritage yang cocok untuk kantor atau hunian.',
                'location' => 'Menteng, Jakarta',
                'alamat' => 'Jl. Diponegoro No.12',
                'price' => 4900000000,
                'bedrooms' => 5,
                'bathrooms' => 4,
                'area' => 400,
                'image_path' => 'https://via.placeholder.com/640x480.png?text=Rumah+Menteng',
            ],
            [
                'title' => 'Villa Private Pool Canggu',
                'description' => 'Lokasi strategis, desain tropikal, 10 menit ke Pantai Batu Bolong.',
                'location' => 'Canggu, Bali',
                'alamat' => 'Jl. Pantai Berawa No.55',
                'price' => 3750000000,
                'bedrooms' => 4,
                'bathrooms' => 3,
                'area' => 280,
                'image_path' => 'https://via.placeholder.com/640x480.png?text=Villa+Canggu',
            ],
            [
                'title' => 'Rumah Cluster Bekasi Timur',
                'description' => 'Dekat tol dan fasilitas umum, harga bersahabat.',
                'location' => 'Bekasi Timur',
                'alamat' => 'Jl. KH Noer Ali No.88',
                'price' => 950000000,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'area' => 140,
                'image_path' => 'https://via.placeholder.com/640x480.png?text=Rumah+Bekasi',
            ],
            [
                'title' => 'Smart Home Ciputat',
                'description' => 'Rumah teknologi pintar, bisa dikontrol dari smartphone.',
                'location' => 'Ciputat, Tangerang Selatan',
                'alamat' => 'Jl. Ir. H. Juanda No.42',
                'price' => 1450000000,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'area' => 160,
                'image_path' => 'https://via.placeholder.com/640x480.png?text=Smart+Home+Ciputat',
            ],
        ];
        foreach ($properties as $index => $data) {
            $number = $index + 1; // biar mulai dari 1
            $data['image_path'] =  "properties/" ."{$number}_1.png";

            $property = Property::create($data);

            // Attach 2-3 random amenities
            $amenities = Amenity::inRandomOrder()->limit(rand(2, 3))->pluck('id');
            $property->amenities()->attach($amenities);

            // Tambahkan 2 gambar tambahan: {n}_2.png dan {n}_3.png
            for ($i = 2; $i <= 3; $i++) {
                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_url' => "properties/"."{$number}_{$i}.png",
                ]);
            }
        }

    }
}
