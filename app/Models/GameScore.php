<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'score',
        'game_type',
        'ip_address',
    ];

    protected $casts = [
        'score' => 'integer',
    ];

    public static function getLeaderboard($limit = 10)
    {
        return self::where('game_type', 'boba')
            ->orderBy('score', 'desc')
            ->limit($limit)
            ->get(['name', 'score']);
    }
}