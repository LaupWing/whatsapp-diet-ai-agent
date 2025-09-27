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
        'total_grams',
        'confidence',
    ];

    protected $casts = [
        'quantity' => 'float',
        'total_calories' => 'float',
        'total_protein_grams' => 'float',
        'total_carbs_grams' => 'float',
        'total_fat_grams' => 'float',
        'total_grams' => 'float',
        'confidence' => 'float',
    ];

    public function meal(): BelongsTo
    {
        return $this->belongsTo(Meal::class);
    }
}
