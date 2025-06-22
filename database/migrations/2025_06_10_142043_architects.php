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
        $table->string('photo')->nullable();  
        $table->string('title');  
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->float('rating', 2, 1);  
        $table->integer('reviews_count');  
        $table->integer('experience_years');  
        $table->string('location');  
        $table->json('styles');  
        $table->timestamps();
        });
    }

    public function down(): void {
    Schema::dropIfExists('architects');
    }
};
