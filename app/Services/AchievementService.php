<?php

namespace App\Services;

use App\Enums\AchievementTypeEnum;
use App\Models\Achievement;
use App\Models\ChallengeAttempt;
use App\Models\Track;
use App\Models\User;

class AchievementService
{
    public function checkSequence(User $user): void
    {
        Achievement::where('type', AchievementTypeEnum::Sequence)
            ->where('value', '<=', $user->general_sequence)
            ->get()
            ->each(fn($achievement) => $this->award($user, $achievement));
    }

    public function checkFavoriteWords(User $user): void
    {
        $count = $user->words()->count();

        Achievement::where('type', AchievementTypeEnum::FavoriteWords)
            ->where('value', '<=', $count)
            ->get()
            ->each(fn($achievement) => $this->award($user, $achievement));
    }

    public function checkTrack(User $user, Track $track): void
    {
        $total = $track->challenges()->count();
        $completed = ChallengeAttempt::where('user_id', $user->id)
            ->whereHas('challenge', fn($q) => $q->where('track_id', $track->id))
            ->count();

        if ($completed < $total) {
            return;
        }

        $completedTracksCount = Track::all()->filter(function (Track $t) use ($user) {
            $total = $t->challenges()->count();
            $done = ChallengeAttempt::where('user_id', $user->id)
                ->whereHas('challenge', fn($q) => $q->where('track_id', $t->id))
                ->count();
            return $done >= $total;
        })->count();

        Achievement::where('type', AchievementTypeEnum::Track)
            ->where('value', '<=', $completedTracksCount)
            ->get()
            ->each(fn($achievement) => $this->award($user, $achievement));
    }

    public function checkRanking(User $user): void
    {
        $position = User::orderByDesc('weekly_score')
            ->pluck('id')
            ->search($user->id);

        if ($position === false) {
            return;
        }

        $position = $position + 1;

        Achievement::where('type', AchievementTypeEnum::Ranking)
            ->where('value', '>=', $position)
            ->get()
            ->each(fn($achievement) => $this->award($user, $achievement));
    }

    private function award(User $user, Achievement $achievement): void
    {
        if ($user->achievements()->whereKey($achievement->id)->exists()) {
            return;
        }

        $user->achievements()->attach($achievement->id);
    }
}
