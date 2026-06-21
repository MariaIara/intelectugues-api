<?php

namespace Database\Seeders;

use App\Models\Avatar;
use App\Models\Level;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $defaultAvatar = Avatar::where('is_default', true)->first();
        $levelId = Level::first()->id;

        User::create([
            'name' => 'Iara Braga',
            'email' => 'iara@gmail.com',
            'password' => '123',
            'weekly_sequence' => 0,
            'general_score' => 0,
            'weekly_score' => 0,
            'level_id' => $levelId,
            'avatar_id' => $defaultAvatar->id,
            'created_at' => now()
        ]);

        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => "User $i",
                'email' => "user$i@gmail.com",
                'password' => '123',
                'weekly_sequence' => 0,
                'general_score' => 0,
                'weekly_score' => 0,
                'level_id' => $levelId,
                'avatar_id' => $defaultAvatar->id,
                'created_at' => now()
            ]);
        }
    }
}
