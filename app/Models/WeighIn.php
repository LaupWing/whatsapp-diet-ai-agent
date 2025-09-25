<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeighIn extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'weight_kilogram',
        'body_fat_percentage'
    ];

    protected $casts = [
        'date' => 'date',
        'weight_kg' => 'float',
        'body_fat_percentage' => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
