<?php

namespace App\Services;

use App\Models\Avatar;
use App\Models\Level;
use App\Models\User;
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
}
