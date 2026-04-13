<?php

namespace App\Services;

use App\Models\Ranking;
use App\Models\User;

class WeeklyRankingService
{
    public function __construct(protected AchievementService $achievementService) {}

    public function resetIfNewWeek(): void
    {
        $lastRanking = Ranking::latest()->first();

        $isNewWeek = !$lastRanking || !now()->isSameWeek($lastRanking->created_at);

        if (!$isNewWeek) {
            return;
        }

        $topUsers = User::orderByDesc('weekly_score')
            ->take(3)
            ->get();

        $this->achievementService->checkRanking($topUsers);

        Ranking::create([
            'top_users' => $topUsers->map(fn($user, $index) => [
                'position' => $index + 1,
                'user_id'  => $user->id,
            ])->values()->toArray(),
        ]);

        User::query()->update([
            'weekly_score' => 0,
            'weekly_sequence' => 0,
        ]);
    }
}
