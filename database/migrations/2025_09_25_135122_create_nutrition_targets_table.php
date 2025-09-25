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
        Schema::create('nutrition_targets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('effective_from')->index();

            $table->integer('calorie_target');
            $table->integer('protein_gram');
            $table->integer('carbohydrate_gram');
            $table->integer('fat_gram');

            $table->string('method')->default('katch_mcardle_v1');
            $table->string('reason')->default('onboarding');
            $table->json('inputs_json')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nutrition_targets');
    }
};
