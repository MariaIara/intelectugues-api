<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Track;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function info(Request $request)
    {
        $user = $request
            ->user()
            ->load('avatar', 'level');

        $user->level->next_level = Level::where('name', $user->level->next_level)->first();

        return response()->json([
            'data' => $user
        ]);
    }

    public function favoriteWords(Request $request)
    {
        $words = $request->user()->words()->get();

        return response()->json([
            'data' => $words
        ]);
    }

    public function challengesByTrack(Request $request, Track $track)
    {
        $challenges = $track->challenges()->withCount('questions')->get();

        $attempts = $request->user()
            ->challengeAttempts()
            ->whereIn('challenge_id', $challenges->pluck('id'))
            ->get();

        foreach ($challenges as $challenge) {
            $challenge->finished = $attempts->contains('challenge_id', $challenge->id);
        }

        return response()->json([
            'data' => [
                'track' => $track,
                'challenges' => $challenges
            ]
        ]);
    }

    public function challengeAttemptsByTrack(Request $request, Track $track)
    {
        $challenges = $track->challenges->pluck('id');

        $attempts = $request->user()
            ->challengeAttempts()
            ->whereIn('challenge_id', $challenges)
            ->get();

        return response()->json([
            'data' => [
                'track_progress' => $attempts->count() / $challenges->count() * 100,
                'attempts' => $attempts
            ]
        ]);
    }
}
