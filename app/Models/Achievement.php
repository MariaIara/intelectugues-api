<?php

namespace App\Models;

use App\Enums\AchievementTypeEnum;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $fillable = [
        'value',
        'description',
        'image',
        'type',
    ];

    protected function casts(): array
    {
        return [
            'type' => AchievementTypeEnum::class,
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function users()
    {
        return $this->belongsToMany(Achievement::class, 'user_achievement')
            ->withPivot('created_at', 'updated_at');
    }
}
