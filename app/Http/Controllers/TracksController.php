<?php

namespace App\Http\Controllers;

use App\Models\Track;
use Illuminate\Http\Request;

class TracksController extends Controller
{
    public function index()
    {
        return response()->json(['data' => Track::paginate(10)]);
    }

    public function info(Track $track)
    {
        return response()->json(['data' => $track]);
    }

    public function challenges(Track $track)
    {
        return response()->json([
            'data' => $track->challenges
        ]);
    }
}
