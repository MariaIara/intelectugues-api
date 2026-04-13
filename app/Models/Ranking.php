<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
    protected $fillable = [
        'top_users',
    ];

    protected $casts = [
        'top_users' => 'array',
    ];
}
