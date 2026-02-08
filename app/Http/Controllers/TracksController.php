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

    public function info(Request $request)
    {
        return response()->json(['data' => Track::find($request->id)]);
    }

    public function challenges(Request $request)
    {
        $track = Track::find($request->id);

        return response()->json([
            'data' => $track->challenges
        ]);
    }
}
