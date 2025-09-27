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
                ->cascadeOnDelete();

            $table->string('name');
            $table->float('quantity');
            $table->string('unit');
            $table->float('total_calories');
            $table->float('total_protein_grams');
            $table->float('total_carbs_grams');
            $table->float('total_fat_grams');
            $table->float('total_grams');
            $table->float('confidence');

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
