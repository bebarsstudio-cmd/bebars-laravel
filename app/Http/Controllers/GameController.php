<?php

namespace App\Http\Controllers;

use App\Models\GameScore;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function boba()
    {
        $leaderboard = GameScore::getLeaderboard(10);
        return view('boba', compact('leaderboard'));
    }

    public function saveScore(Request $request)
    {
        $request->validate([
            'player_name' => 'required|string|max:100',
            'score' => 'required|integer|min:0',
            'duration' => 'nullable|integer',
        ]);

        $score = GameScore::create([
            'player_name' => $request->player_name,
            'score' => $request->score,
            'game_type' => 'boba',
            'ip_address' => $request->ip(),
            'duration' => $request->duration,
        ]);

        $leaderboard = GameScore::getLeaderboard(10);

        return response()->json([
            'success' => true,
            'message' => 'Score saved successfully!',
            'score' => $score,
            'leaderboard' => $leaderboard
        ]);
    }

    public function getLeaderboard()
    {
        $leaderboard = GameScore::getLeaderboard(10);
        return response()->json($leaderboard);
    }
}