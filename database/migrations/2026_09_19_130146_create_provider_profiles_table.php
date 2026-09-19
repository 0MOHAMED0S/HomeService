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
        Schema::create('provider_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('profession_id')->nullable()->constrained()->nullOnDelete();
            $table->json('skills')->nullable();
            $table->json('languages')->nullable();
            $table->integer('experience_years')->nullable();
            $table->text('bio')->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            
            // Document uploads
            $table->string('profile_picture')->nullable();
            $table->string('id_front')->nullable();
            $table->string('id_back')->nullable();
            $table->string('police_clearance')->nullable();
            $table->string('commercial_register')->nullable();
            
            // Review Status
            $table->enum('status', ['pending', 'approved', 'rejected', 'requires_changes'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->json('field_statuses')->nullable(); // Stores status per input
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_profiles');
    }
};
