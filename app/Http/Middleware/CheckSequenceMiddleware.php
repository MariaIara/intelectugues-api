<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSequenceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        $to_mantain = $user
            ->challengeAttempts()
            ->whereDate('finished_at', today())
            ->orWhereDate('finished_at', today()->subDays(1))
            ->exists();

        if (!$to_mantain) {
            $user->general_sequence = 0;
            $user->weekly_sequence = 0;
            $user->save();
        }

        return $next($request);
    }
}
