<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Project;
use App\Models\Feedback;
use App\Models\Like;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'news_count' => News::count(),
            'projects_count' => Project::count(),
            'feedback_count' => Feedback::count(),
            'votes' => Like::getVotes(),
        ];
        
        $recentNews = News::recent()->limit(5)->get();
        $recentFeedback = Feedback::orderBy('created_at', 'desc')->limit(5)->get();
        
        return view('admin.dashboard', compact('stats', 'recentNews', 'recentFeedback'));
    }
}