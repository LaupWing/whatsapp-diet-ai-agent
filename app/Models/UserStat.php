<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserStat extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'weight_kg', // canonical kg
        'bodyfat_percentage',
        'steps',
        'height_cm',
        'target',
    ];

    protected $casts = [
        'date' => 'date',
        'weight_kg' => 'decimal:3',
        'bodyfat_percentage' => 'float',
        'height_cm' => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
