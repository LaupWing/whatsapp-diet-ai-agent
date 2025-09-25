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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('agent_session_id')
                ->nullable()
                ->constrained('agent_sessions')
                ->nullOnDelete();

            // routing / identity
            $table->enum('direction', ['inbound', 'outbound']);
            $table->string('channel')->default('whatsapp');
            $table->string('provider_message_id')->nullable();
            $table->timestamp('provider_timestamp')->nullable();

            // content
            $table->text('text')->nullable();
            $table->boolean('has_media')->default(false);
            $table->text('media_url')->nullable();
            $table->string('media_mime')->nullable();

            // delivery / processing
            $table->enum('status', ['received', 'queued', 'sent', 'delivered', 'failed', 'error'])->default('received');
            $table->string('error_message')->nullable();

            // agent/tool metadata (optional but useful for analytics/debug)
            $table->string('agent_name')->nullable();
            $table->string('tool_name')->nullable();
            $table->json('tool_args')->nullable();
            $table->json('tool_result')->nullable();
            $table->string('adk_run_id')->nullable();

            // raw provider payload for audit/debug (JSON/text)
            $table->json('raw_payload')->nullable();

            $table->timestamps();

            // dedupe & fast lookups
            $table->unique(['channel', 'provider_message_id']);
            $table->index(['user_id', 'direction', 'created_at']);
            $table->index(['agent_session_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
