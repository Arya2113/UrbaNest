<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoritePropertyTest extends TestCase
{
    use RefreshDatabase;

    public function test_tamu_tidak_bisa_menambahkan_ke_favorit()
    {
        $property = Property::factory()->create();

        $response = $this->postJson("/property/{$property->id}/favorite");

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Silakan login untuk menambahkan ke favorit.'
        ]);
    }


    public function test_pengguna_dapat_menambahkan_properti_ke_favorit()
    {
        $user = User::factory()->create();
        $property = Property::factory()->create();

        $this->actingAs($user);

        $response = $this->postJson("/property/{$property->id}/favorite");

        $response->assertStatus(200);
        $response->assertJson(['isFavorited' => true]);

        $this->assertDatabaseHas('property_user', [
            'user_id' => $user->id,
            'property_id' => $property->id
        ]);
    }

    public function test_pengguna_dapat_menghapus_favorit_dari_properti()
    {
        $user = User::factory()->create();
        $property = Property::factory()->create();

        $user->properties()->attach($property->id);
        $this->actingAs($user);

        $response = $this->postJson("/property/{$property->id}/favorite");

        $response->assertStatus(200);
        $response->assertJson(['isFavorited' => false]);

        $this->assertDatabaseMissing('property_user', [
            'user_id' => $user->id,
            'property_id' => $property->id
        ]);
    }
}