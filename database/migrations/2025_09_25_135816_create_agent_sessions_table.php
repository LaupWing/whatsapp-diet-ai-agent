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
        Schema::create('agent_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('channel')->default('whatsapp');
            $table->string('channel_user_id')->nullable();

            $table->string('adk_app')->nullable();
            $table->string('adk_user_id')->nullable();
            $table->string('adk_session_id')->unique();

            $table->boolean('is_active')->default(true);
            $table->timestamp('last_activity_at')->nullable();

            $table->json('state')->nullable();

            $table->index(['user_id', 'is_active']);
            $table->index(['channel', 'channel_user_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agent_sessions');
    }
};
