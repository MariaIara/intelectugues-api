<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    protected $fillable = [
        'name',
        'description',
        'score',
        'index',
        'track_id',
        'score'
    ];
}
