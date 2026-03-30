<?php

namespace Database\Seeders;

use App\Models\Avatar;
use Illuminate\Database\Seeder;

class AvatarsSeeder extends Seeder
{
    public function run(): void
    {
        $avatars = [
            [
                'image' => '/src/assets/avatar/avatar-one.svg',
                'created_at' => now()
            ],
            [
                'image' => '/src/assets/avatar/avatar-two.svg',
                'created_at' => now()
            ],
            [
                'image' => '/src/assets/avatar/avatar-three.svg',
                'created_at' => now()
            ],
            [
                'image' => '/src/assets/avatar/avatar-four.svg',
                'created_at' => now()
            ],
            [
                'image' => '/src/assets/avatar/avatar-five.svg',
                'created_at' => now()
            ]
        ];

        foreach ($avatars as $avatar) {
            Avatar::create($avatar);
        }
    }
}
