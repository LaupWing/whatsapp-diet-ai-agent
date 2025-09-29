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
        Schema::create('meal_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meal_id')
                ->constrained()
                ->onDelete('cascade');

            $table->string('name');
            $table->decimal('quantity', 10, 2);
            $table->string('unit', 50);
            $table->decimal('estimated_weight_grams', 10, 2)->nullable();
            $table->decimal('total_calories', 10, 2);
            $table->decimal('total_protein_grams', 10, 2);
            $table->decimal('total_carbs_grams', 10, 2);
            $table->decimal('total_fat_grams', 10, 2);
            $table->decimal('confidence', 3, 2)->default(0.80);
            $table->string('source', 50)->default('ai_vision');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_items');
    }
};
