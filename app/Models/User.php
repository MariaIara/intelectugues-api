<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'general_sequence',
        'weekly_sequence',
        'general_score',
        'weekly_score',
        'avatar_id',
        'level_id',
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
        ];
    }

    public function avatar()
    {
        return $this->belongsTo(Avatar::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function challengeAttempts()
    {
        return $this->hasMany(ChallengeAttempt::class);
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'user_achievement')
            ->withPivot('created_at', 'updated_at')
            ->orderByPivot('id', 'desc');
    }

    public function words()
    {
        return $this->belongsToMany(Word::class, 'user_word')
            ->withPivot('created_at', 'updated_at');
    }
}
