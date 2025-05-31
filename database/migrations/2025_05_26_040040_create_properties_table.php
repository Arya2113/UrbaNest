<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('location');
            $table->text('alamat')->nullable(); // Added alamat column
            $table->decimal('price', 15, 2);
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->decimal('area', 10, 2)->nullable();
            $table->string('image_path')->nullable(); // Optional: path to a main image
            $table->text('environment_facilities'); // Keep or remove this based on previous migrations, assuming it's needed
            $table->foreignId('locked_by_user_id')->nullable()->constrained('users')->onDelete('set null'); // Added locked_by_user_id
            $table->timestamp('locked_until')->nullable(); // Added locked_until
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
