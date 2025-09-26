<?php

namespace App\Models;

use Illuminate\Support\Str;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\WeightUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'unit_weight'        => WeightUnit::class,
            'unit_for_exercises' => WeightUnit::class,
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (User $user) {
            if (empty($user->public_id)) {

                do {
                    $pid = (string) Str::ulid();
                } while (User::where('public_id', $pid)->exists());

                $user->public_id = $pid;
            }
        });
    }


    public function agentSessions(): HasMany
    {
        return $this->hasMany(AgentSession::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function meals(): HasMany
    {
        return $this->hasMany(Meal::class);
    }

    public function stat(): HasOne
    {
        return $this->hasOne(UserStat::class);
    }

    public function weighIns(): HasMany
    {
        return $this->hasMany(WeighIn::class);
    }

    public function nutritionTargets(): HasMany
    {
        return $this->hasMany(NutritionTarget::class);
    }
}
