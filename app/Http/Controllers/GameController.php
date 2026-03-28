<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameScore;

class GameController extends Controller
{
    /**
     * Display the Boba game page.
     */
    public function boba()
    {
        return view('boba');
    }

    /**
     * Save game score.
     */
    public function saveScore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'score' => 'required|integer|min:0',
        ]);

        $score = GameScore::create([
            'name' => $request->name,
            'score' => $request->score,
            'game_type' => 'boba',
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Score saved successfully!',
            'score' => $score
        ]);
    }

    /**
     * Get leaderboard.
     */
    public function getLeaderboard()
    {
        $scores = GameScore::getLeaderboard(10);
        
        return response()->json($scores);
    }
}