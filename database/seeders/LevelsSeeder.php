<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Seeder;

class LevelsSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            [
                'name' => 'Bronze',
                'image' => 'images/level1.png',
                'created_at' => now(),
                'needed_score' => 0,
                'next_level' => 'Prata'
            ],
            [
                'name' => 'Prata',
                'image' => 'images/level1.png',
                'created_at' => now(),
                'needed_score' => 80,
                'next_level' => 'Ouro'
            ],
            [
                'name' => 'Ouro',
                'image' => 'images/level1.png',
                'created_at' => now(),
                'needed_score' => 160,
                'next_level' => 'Platina'
            ],
            [
                'name' => 'Platina',
                'image' => 'images/level1.png',
                'created_at' => now(),
                'needed_score' => 240,
                'next_level' => 'Diamante'
            ],
            [
                'name' => 'Diamante',
                'image' => 'images/level1.png',
                'created_at' => now(),
                'needed_score' => 320,
                'next_level' => 'Mestre'
            ],
            [
                'name' => 'Mestre',
                'image' => 'images/level1.png',
                'created_at' => now(),
                'needed_score' => 400,
                'next_level' => null
            ]
        ];

        foreach ($levels as $level) {
            Level::create($level);
        }
    }
}
