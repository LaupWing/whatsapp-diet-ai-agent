<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NutritionTarget extends Model
{
    protected $fillable = [
        'user_id',
        'effective_from',
        'calorie_target',
        'protein_gram',
        'carbohydrate_gram',
        'fat_gram',
        'method',
        'reason',
        'inputs_json',
    ];

    protected $casts = [
        'effective_from' => 'date',
        'inputs_json' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
