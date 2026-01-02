<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChallengeAttempt extends Model
{
    protected $fillable = [
        'challenge_id',
        'user_id',
        'password',
        'finished_at'
    ];

    protected function casts(): array
    {
        return [
            'finished_at' => 'datetime'
        ];
    }
}
