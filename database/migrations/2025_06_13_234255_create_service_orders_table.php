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
        Schema::create('service_orders', function (Blueprint $table) {
            Schema::create('service_orders', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('architect_id')->nullable()->constrained('architects')->onDelete('set null');
            
                $table->string('full_name');
                $table->string('email');
                $table->string('phone_number');
                $table->string('project_location');
                $table->string('project_type');
                $table->decimal('estimated_budget', 15, 2)->nullable();
                $table->date('project_date')->nullable();
                $table->text('project_description')->nullable();
            
                $table->enum('status', [
                    'pending',        // Baru dibuat
                    'consultation',   // Konsultasi/awal kontak
                    'site_survey',    // Survey lokasi
                    'designing',      // Proses mendesain
                    'in_progress',    // Eksekusi lapangan
                    'review',         // Review/revisi (khusus desain)
                    'completed',      // Selesai
                    'cancelled'       // Dibatalkan
                ])->default('pending');            
                $table->timestamps();
            });
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_orders');
    }
};
