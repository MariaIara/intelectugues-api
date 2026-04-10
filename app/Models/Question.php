<?php

namespace App\Models;

use App\Enums\QuestionTemplateEnum;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'statement',
        'template_type',
        'challenge_id',
    ];

    protected $casts = [
        'template_type' => QuestionTemplateEnum::class,
    ];

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }

    public function alternatives()
    {
        return $this->hasMany(Alternative::class);
    }
}
