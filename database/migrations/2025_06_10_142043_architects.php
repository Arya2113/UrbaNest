<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
    Schema::create('architects', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('photo')->nullable(); // untuk URL atau path foto profil
        $table->string('title'); // seperti "Sustainable architecture expert"
        $table->float('rating', 2, 1); // contoh: 4.9
        $table->integer('reviews_count'); // jumlah review
        $table->integer('experience_years'); // tahun pengalaman
        $table->string('location'); // contoh: "San Francisco, CA"
        $table->json('styles'); // untuk menampung banyak gaya seperti ["Modern", "Sustainable"]
        $table->timestamps();
        });
    }

    public function down(): void {
    Schema::dropIfExists('architects');
    }
};
