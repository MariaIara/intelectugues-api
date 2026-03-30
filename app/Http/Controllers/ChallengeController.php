<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChallengeRequest;
use App\Models\Challenge;
use App\Models\ChallengeAttempt;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChallengeController extends Controller
{
    protected UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function info(Request $request, Challenge $challenge)
    {
        $user = $request->user();

        $is_blocked = $challenge->isBlocked($user, $challenge);

        if ($is_blocked) {
            return response()->json(['error' => 'É necessário finalizar o desafio anterior.'], 400);
        }

        return response()->json([
            'data' => $challenge->load('questions.alternatives')
        ]);
    }

    public function attempt(ChallengeRequest $request, Challenge $challenge)
    {
        $user = $request->user();

        $is_blocked = $challenge->isBlocked($user, $challenge);

        if ($is_blocked) {
            return response()->json(['error' => 'É necessário finalizar o desafio anterior.'], 400);
        }

        if (!$challenge->alredyAttempted($user, $challenge)) {
            return response()->json(['response' => 'Challenge attempt answered'], 200);
        }

        DB::transaction(function () use ($user, $challenge, $request) {
            $this->userService->addSequence($user);
            $this->userService->addScore($user, $challenge, $request->boolean('without_errors'));
            $this->userService->levelUp($user, $challenge);

            ChallengeAttempt::create([
                'challenge_id' => $challenge->id,
                'user_id' => $user->id,
                'finished_at' => now()
            ]);
        });

        return response()->json([
            'response' => 'Challenge answered and attempt created successfully'
        ], 201);
    }
}
