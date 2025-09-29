<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MealItem extends Model
{
    protected $fillable = [
        'meal_id',
        'name',
        'quantity',
        'unit',
        'total_calories',
        'total_protein_grams',
        'total_carbs_grams',
        'total_fat_grams',
        'estimated_weight_grams',
        'confidence',
    ];

    protected $casts = [
        'quantity' => 'decimal',
        'total_calories' => 'decimal',
        'total_protein_grams' => 'decimal',
        'total_carbs_grams' => 'decimal',
        'total_fat_grams' => 'decimal',
        'estimated_weight_grams' => 'decimal',
        'confidence' => 'decimal',
    ];

    public function meal(): BelongsTo
    {
        return $this->belongsTo(Meal::class);
    }
}
