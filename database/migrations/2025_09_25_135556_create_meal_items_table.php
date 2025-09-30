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
            $table->float('quantity');
            $table->string('unit', 50);
            $table->float('estimated_weight_grams')->nullable();
            $table->float('total_calories');
            $table->float('total_protein_grams');
            $table->float('total_carbs_grams');
            $table->float('total_fat_grams');
            $table->float('confidence')->default(0.80);
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
