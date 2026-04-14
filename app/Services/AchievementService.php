<?php

namespace App\Services;

use App\Enums\AchievementTypeEnum;
use App\Models\Achievement;
use App\Models\ChallengeAttempt;
use App\Models\Track;
use App\Models\User;
use Illuminate\Support\Collection;

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

    public function checkRanking(Collection $topUsers): void
    {
        $rankingAchievements = Achievement::where('type', AchievementTypeEnum::Ranking)->get();

        $topUsers->each(function (User $user, int $index) use ($rankingAchievements) {
            $position = $index + 1;

            $rankingAchievements
                ->where('value', '>=', $position)
                ->each(fn($achievement) => $this->award($user, $achievement));
        });
    }

    private function award(User $user, Achievement $achievement): void
    {
        $user->achievements()->syncWithoutDetaching([$achievement->id]);
    }
}
