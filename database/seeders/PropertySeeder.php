<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Property;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data statis yang ada jika sebelumnya sudah dijalankan
        // Property::truncate(); // Opsional: Jika Anda ingin mengosongkan tabel sebelum seeding

        // Buat 20 properti menggunakan factory
        Property::factory()->count(3)->create();
    }
}
