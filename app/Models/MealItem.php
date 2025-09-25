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
        'calories',
        'protein_grams',
        'carbs_grams',
        'fat_grams',
        'confidence',
    ];

    protected $casts = [
        'quantity' => 'float',
        'calories' => 'float',
        'protein_grams' => 'float',
        'carbs_grams' => 'float',
        'fat_grams' => 'float',
        'confidence' => 'float',
    ];

    public function meal(): BelongsTo
    {
        return $this->belongsTo(Meal::class);
    }
}
