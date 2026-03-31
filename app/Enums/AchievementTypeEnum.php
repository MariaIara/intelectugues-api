<?php

namespace App\Enums;

enum AchievementTypeEnum: string
{
    case Track = 'track';
    case Sequence = 'sequence';
    case Ranking = 'ranking';
    case FavoriteWords = 'favorite_words';
}
