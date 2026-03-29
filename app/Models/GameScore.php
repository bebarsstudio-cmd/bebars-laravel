<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameScore extends Model
{
    use HasFactory;

    protected $table = 'game_scores';

    protected $fillable = [
        'player_name',
        'score',
        'game_type',
        'ip_address',
        'duration'
    ];

    protected $casts = [
        'score' => 'integer',
        'created_at' => 'datetime',
    ];

    // Get top scores for leaderboard
    public static function getLeaderboard($limit = 10)
    {
        return self::where('game_type', 'boba')
            ->orderBy('score', 'desc')
            ->limit($limit)
            ->get(['player_name', 'score', 'created_at']);
    }

    // Get player's best score
    public static function getPlayerBestScore($playerName)
    {
        return self::where('player_name', $playerName)
            ->where('game_type', 'boba')
            ->max('score');
    }
}