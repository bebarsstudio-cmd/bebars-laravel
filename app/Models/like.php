<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        'user_type', 'count', 'ip_address', 'vote_date'
    ];

    public static function getVotes()
    {
        $bebars = self::where('user_type', 'bebars')->sum('count');
        $ahmed = self::where('user_type', 'ahmed')->sum('count');
        
        return [
            'bebars' => $bebars,
            'ahmed' => $ahmed,
            'total' => $bebars + $ahmed
        ];
    }

    public static function canVote($userType, $ip)
    {
        $today = now()->toDateString();
        $existing = self::where('user_type', $userType)
            ->where('ip_address', $ip)
            ->where('vote_date', $today)
            ->exists();
        
        return !$existing;
    }
}