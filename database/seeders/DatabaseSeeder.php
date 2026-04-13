<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            LevelsSeeder::class,
        ]);

        $this->call([
            AvatarsSeeder::class,
        ]);

        $this->call([
            UsersSeeder::class,
        ]);

        $this->call([
            WordsSeeder::class,
        ]);

        $this->call([
            PortugueseLearningSeeder::class,
        ]);

        $this->call([
            AchievementsSeeder::class,
        ]);
    }
}
