<?php

namespace App\Services;

use App\Models\Avatar;
use App\Models\Challenge;
use App\Models\Level;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function create(array $data)
    {
        if (!$level = Level::where('name', 'Bronze')->first()) {
            abort(404, 'Level not found');
        }

        if ($avatar = Avatar::where('is_default', true)->first()) {
            $data['avatar_id'] = $avatar->id;
        }

        return User::create([
            ...$data,
            'level_id' => $level->id,
            'password' => Hash::make($data['password'])
        ]);
    }

    public function addSequence(User $user)
    {
        if ($user->challengeAttempts()->whereDate('finished_at', today())->exists()) {
            return;
        }

        $user->general_sequence = $user->general_sequence + 1;
        $user->weekly_sequence = $user->weekly_sequence + 1;
        $user->save();
    }

    public function addScore(User $user, Challenge $challenge, bool $without_errors)
    {
        if ($user->challengeAttempts()->whereChallengeId($challenge->id)->exists()) {
            return;
        }

        $score = $without_errors
            ? $challenge->score * 2
            : $challenge->score;

        $user->general_score = $user->general_score + $score;
        $user->weekly_score = $user->weekly_score + $score;
        $user->save();
    }

    public function levelUp(User $user, Challenge $challenge)
    {
        if ($user->challengeAttempts()->whereChallengeId($challenge->id)->exists()) {
            return;
        }

        $next_level = Level::where('name', $user->level->next_level)->first();

        if ($user->general_score < $next_level?->needed_score) {
            return;
        }

        $next_level && $user->level_id = $next_level->id;
        $user->save();
    }

    public function calculateProgressLevel(User $user): float
    {
        $level = $user->level;

        $progress = (($user->general_score - $level->needed_score) / ($level->next_level->needed_score - $level->needed_score)) * 100;

        return $progress;
    }
}
