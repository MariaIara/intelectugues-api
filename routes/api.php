<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\TracksController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WordsController;
use Illuminate\Support\Facades\Route;


// Router test
Route::get('/ping', fn() => 'pong');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum', 'check_sequence')->group(function () {
    Route::get('/avatars', [AvatarController::class, 'index']);
    Route::get('/profile', [UserController::class, 'info']);
    Route::patch('/profile', [UserController::class, 'updateProfile']);
    Route::get('/user/achievements', [UserController::class, 'achievements']);
    Route::get('/user/words', [UserController::class, 'favoriteWords']);
    Route::get('/user/tracks/{track}/challenges', [UserController::class, 'challengesByTrack']);
    Route::get('/user/tracks/{track}/challenge-attempts', [UserController::class, 'challengeAttemptsByTrack']);
    Route::get('/users/ranking', [UserController::class, 'ranking']);

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/words', [WordsController::class, 'index']);
    Route::get('/words/daily', [WordsController::class, 'dailyWord']);
    Route::get('/words/{id}', [WordsController::class, 'info']);
    Route::post('/words', [WordsController::class, 'create']);
    Route::post('/words/{id}/favorite', [WordsController::class, 'favorite']);
    Route::delete('/words/{id}', [WordsController::class, 'delete']);

    Route::get('/tracks', [TracksController::class, 'index']);
    Route::get('/tracks/{track}', [TracksController::class, 'info']);
    Route::get('/tracks/{track}/challenges', [TracksController::class, 'challenges']);

    Route::post('/challenges/{challenge}/attempt', [ChallengeController::class, 'attempt']);
    Route::get('/challenges/{challenge}', [ChallengeController::class, 'info']);

    Route::middleware('admin')->group(function () {
        Route::post('/words', [WordsController::class, 'create']);
    });
});
