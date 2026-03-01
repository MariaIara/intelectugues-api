<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    public function info(Request $request, Challenge $challenge)
    {
        $user = $request->user();

        $is_bloked = $challenge->isBlocked($user, $challenge);

        if ($is_bloked) {
            return response()->json(['error' => 'É necessário finalizar o desafio anterior.'], 400);
        }

        return response()->json([
            'data' => $challenge->load('questions.alternatives')
        ]);
    }
}
