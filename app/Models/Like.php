<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $table = 'likes';

    protected $fillable = [
        'user_type',
        'count',
        'ip_address',
        'vote_date',
    ];

    protected $casts = [
        'vote_date' => 'date',
        'count' => 'integer',
    ];

    /**
     * Get votes for both users
     */
    public static function getVotes()
    {
        $bebars = self::where('user_type', 'bebars')->sum('count');
        $ahmed = self::where('user_type', 'ahmed')->sum('count');
        
        return [
            'bebars' => (int) $bebars,
            'ahmed' => (int) $ahmed,
            'total' => (int) ($bebars + $ahmed),
        ];
    }

    /**
     * Check if user can vote today
     */
    public static function canVote($userType, $ip)
    {
        $today = now()->toDateString();
        $existing = self::where('user_type', $userType)
            ->where('ip_address', $ip)
            ->whereDate('vote_date', $today)
            ->exists();
        
        return !$existing;
    }

    /**
     * Add a vote
     */
    public static function addVote($userType, $ip)
    {
        $today = now()->toDateString();
        
        return self::create([
            'user_type' => $userType,
            'count' => 1,
            'ip_address' => $ip,
            'vote_date' => $today,
        ]);
    }
}