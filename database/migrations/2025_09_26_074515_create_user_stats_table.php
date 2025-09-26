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
        Schema::create('user_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('date');
            $table->decimal('weight_kg', 8, 3); // canonical kg
            $table->decimal('target_weight_kg', 8, 3); // canonical kg
            $table->float('bodyfat_percentage');
            $table->float('height_cm');

            // training/goal preferences
            $table->enum('goal', ['lose', 'maintain', 'gain'])->default('lose');
            $table->float('desired_rate_kg_per_week')->default(0.5); // +/- kg per week
            $table->enum('activity_level', [
                'sedentary',
                'light',
                'moderate',
                'active',
                'very_active'
            ])->default('moderate');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_stats');
    }
};
