<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Property;
use App\Models\PropertyCheckoutTransaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadProofTest extends TestCase
{
    use RefreshDatabase;

    public function test_tamu_tidak_bisa_mengunggah_bukti_transfer()
    {
        $property = Property::factory()->create();

        $response = $this->post(route('payment.upload', $property->id), []);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error', 'Silakan login untuk mengunggah bukti transfer.');
    }

    public function test_validasi_gagal_jika_file_tidak_sesuai()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $property = Property::factory()->create([
            'locked_by_user_id' => $user->id,
            'locked_until' => now()->addMinutes(10),
        ]);

        $this->actingAs($user);
        session(['lock_checkout_info' => true]);

        $response = $this->post(route('payment.upload', $property->id), [
            'proof' => UploadedFile::fake()->create('file.txt', 100), // Salah format
        ]);

        $response->assertSessionHasErrors(['proof']);
    }

    public function test_upload_gagal_jika_properti_dikunci_oleh_user_lain()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $property = Property::factory()->create([
            'locked_by_user_id' => $otherUser->id,
            'locked_until' => now()->addMinutes(10),
        ]);

        $this->actingAs($user);
        session(['lock_checkout_info' => true]);

        Storage::fake('public');

        $response = $this->post(route('payment.upload', $property->id), [
            'proof' => UploadedFile::fake()->image('bukti.png'),
        ]);

        $response->assertRedirect(route('property.show', $property->id));
        $response->assertSessionHasErrors(['upload_error']);
    }

    public function test_pengguna_dapat_mengunggah_bukti_transfer_dengan_benar()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $property = Property::factory()->create([
            'price' => 100000000,
            'locked_by_user_id' => $user->id,
            'locked_until' => now()->addMinutes(5),
        ]);

        $this->actingAs($user);
        session(['lock_checkout_info' => true]);

        $file = UploadedFile::fake()->image('bukti.jpg');

        $now = now();
        $this->travelTo($now); 

        $response = $this->post(route('payment.upload', $property->id), [
            'proof' => $file,
        ]);

        $expectedFileName = 'Transfer_' . $user->id . '_' . $property->id . '_' . $now->timestamp . '.' . $file->getClientOriginalExtension();

        Storage::disk('public')->assertExists('bukti_transfer/' . $expectedFileName);

        $response->assertRedirectContains(route('payment.confirmation', ['transaction' => 1]));
        $response->assertSessionHas('success', 'Bukti transfer berhasil diunggah.');

        $this->assertDatabaseHas('property_checkout_transactions', [
            'user_id' => $user->id,
            'property_id' => $property->id,
            'status_transaksi' => 'uploaded',
        ]);
    }
}