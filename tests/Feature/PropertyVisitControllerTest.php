<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PropertyVisitControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_tamu_tidak_bisa_menjadwalkan_kunjungan()
    {
        $property = Property::factory()->create();

        $response = $this->postJson("/property/{$property->id}/visit", [
            'scheduled_at' => now()->addDay()->toDateTimeString()
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Anda harus login untuk menjadwalkan kunjungan.'
        ]);
    }

    public function test_pengguna_terautentikasi_dapat_menjadwalkan_kunjungan()
    {
        $user = User::factory()->create();
        $property = Property::factory()->create();

        $this->actingAs($user);

        $response = $this->postJson("/property/{$property->id}/visit", [
            'scheduled_at' => now()->addDays(2)->toDateTimeString()
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Kunjungan properti berhasil dijadwalkan. Kami akan menghubungi Anda segera untuk konfirmasi.'
        ]);

        $this->assertDatabaseHas('property_visits', [
            'user_id' => $user->id,
            'property_id' => $property->id,
            'status' => 'pending'
        ]);
    }

    public function test_validasi_gagal_jika_format_tanggal_tidak_valid()
    {
        $user = User::factory()->create();
        $property = Property::factory()->create();

        $this->actingAs($user);

        $response = $this->postJson("/property/{$property->id}/visit", [
            'scheduled_at' => now()->subDay()->toDateTimeString()
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => ['scheduled_at']
        ]);
    }
}