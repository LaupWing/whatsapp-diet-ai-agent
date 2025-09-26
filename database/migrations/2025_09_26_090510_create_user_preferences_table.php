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
        Schema::create('user_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // Dietary preferences
            $table->string('dietary_type')->nullable(); // vegan, vegetarian, keto, etc.
            $table->json('food_allergies')->nullable(); // ['dairy', 'nuts', 'gluten']
            $table->json('disliked_foods')->nullable(); // ['mushrooms', 'olives']
            $table->json('cuisine_preferences')->nullable(); // ['italian', 'mexican', 'asian']

            // Cooking preferences
            $table->enum('cooking_skill_level', ['beginner', 'intermediate', 'advanced'])
                ->default('intermediate');
            $table->integer('typical_cooking_time_minutes')->default(30);
            $table->json('kitchen_equipment')->nullable(); // ['oven', 'airfryer', 'instapot']
            $table->string('meal_prep_day')->nullable(); // 'sunday', 'saturday'

            // Portion preferences
            $table->enum('default_portion_size', ['small', 'medium', 'large'])->default('medium');

            $table->timestamps();

            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_preferences');
    }
};
