<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    protected $fillable = [
        'name',
        'description',
        'score',
        'index',
        'track_id',
        'score'
    ];

    public function track()
    {
        return $this->belongsTo(Track::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function challengeAttempts()
    {
        return $this->hasMany(ChallengeAttempt::class);
    }

    public function isBlocked(User $user, Challenge $challenge): bool
    {
        $attempts = $user->challengeAttempts();

        return !$this
            ->where('track_id', $challenge->track_id)
            ->whereIn('id', $attempts->pluck('challenge_id')->toArray())
            ->where(function($q) use($challenge) {
                $q->where('index', $challenge->index - 1)
                    ->orWhere('index', 0);
            })
            ->exists();
    }
}
