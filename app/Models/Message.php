<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = [
        'user_id',
        'agent_session_id',

        'direction',            // 'inbound' | 'outbound'
        'channel',              // 'whatsapp'
        'provider_message_id',  // dedupe key from provider
        'provider_timestamp',

        'text',
        'has_media',
        'media_url',
        'media_mime',

        'status',               // 'received' | 'queued' | 'sent' | 'delivered' | 'failed' | 'error'
        'error_message',

        'agent_name',           // which agent handled it
        'tool_name',            // which tool was called
        'tool_args',
        'tool_result',
        'adk_run_id',           // optional run id

        'raw_payload',
    ];

    protected $casts = [
        'provider_timestamp' => 'datetime',
        'has_media' => 'boolean',
        'tool_args' => 'array',
        'tool_result' => 'array',
        'raw_payload' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function session(): BelongsTo
    {
        return $this->belongsTo(AgentSession::class, 'agent_session_id');
    }
}
