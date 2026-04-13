<?php

namespace Database\Seeders;

use App\Enums\AchievementTypeEnum;
use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementsSeeder extends Seeder
{
    public function run(): void
    {
        $achievements = [
            // Sequence
            [
                'type' => AchievementTypeEnum::Sequence,
                'value' => 3,
                'description' => 'Complete desafios por 3 dias seguidos.',
            ],
            [
                'type' => AchievementTypeEnum::Sequence,
                'value' => 7,
                'description' => 'Complete desafios por 7 dias seguidos.',
            ],
            [
                'type' => AchievementTypeEnum::Sequence,
                'value' => 30,
                'description' => 'Complete desafios por 30 dias seguidos.',
            ],

            // Favorite words
            [
                'type' => AchievementTypeEnum::FavoriteWords,
                'value' => 5,
                'description' => 'Favorite 5 palavras.',
            ],
            [
                'type' => AchievementTypeEnum::FavoriteWords,
                'value' => 10,
                'description' => 'Favorite 10 palavras.',
            ],
            [
                'type' => AchievementTypeEnum::FavoriteWords,
                'value' => 25,
                'description' => 'Favorite 25 palavras.',
            ],

            // Tracks
            [
                'type' => AchievementTypeEnum::Track,
                'value' => 1,
                'description' => 'Finalize sua primeira trilha.',
            ],
            [
                'type' => AchievementTypeEnum::Track,
                'value' => 3,
                'description' => 'Finalize 3 trilhas.',
            ],
            [
                'type' => AchievementTypeEnum::Track,
                'value' => 5,
                'description' => 'Finalize 5 trilhas.',
            ],

            // Ranking
            [
                'type' => AchievementTypeEnum::Ranking,
                'value' => 3,
                'description' => 'Termine a semana no top 3 do ranking.',
            ],
            [
                'type' => AchievementTypeEnum::Ranking,
                'value' => 1,
                'description' => 'Termine a semana em 1º lugar no ranking.',
            ],
        ];

        foreach ($achievements as $achievement) {
            Achievement::create($achievement);
        }
    }
}
