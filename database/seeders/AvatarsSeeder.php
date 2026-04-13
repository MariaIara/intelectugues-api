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
                'is_default' => true,
                'created_at' => now()
            ],
            [
                'image' => '/src/assets/avatar/avatar-two.svg',
                'is_default' => false,
                'created_at' => now()
            ],
            [
                'image' => '/src/assets/avatar/avatar-three.svg',
                'is_default' => false,
                'created_at' => now()
            ],
            [
                'image' => '/src/assets/avatar/avatar-four.svg',
                'is_default' => false,
                'created_at' => now()
            ],
            [
                'image' => '/src/assets/avatar/avatar-five.svg',
                'is_default' => false,
                'created_at' => now()
            ]
        ];

        foreach ($avatars as $avatar) {
            Avatar::create($avatar);
        }
    }
}
