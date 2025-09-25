<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgentSession extends Model
{
    protected $fillable = [
        'user_id',
        'channel',
        'channel_user_id',
        'adk_app',
        'adk_user_id',
        'adk_session_id',
        'is_active',
        'last_activity_at',
        'state',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_activity_at' => 'datetime',
        'state' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
