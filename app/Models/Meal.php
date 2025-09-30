<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Meal extends Model
{
    protected $fillable = [
        'user_id',
        'meal_type',
        'source',
        'notes'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function items(): HasMany
    {
        return $this->hasMany(MealItem::class);
    }

    // Scopes for cleaner queries
    public function scopeForDate($query, $date)
    {
        return $query->when($date, function ($q) use ($date) {
            try {
                $q->whereDate('created_at', $date);
            } catch (\Exception $e) {
                abort(422, 'Invalid date format. Use YYYY-MM-DD.');
            }
        });
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }
}
