<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use Illuminate\Http\Request;

class AvatarController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Avatar::all()
        ]);
    }
}
