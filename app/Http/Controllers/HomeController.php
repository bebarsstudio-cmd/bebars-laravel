<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Project;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $news = News::latest()->take(6)->get();
        $projects = Project::orderBy('order')->get();
        
        return view('home', compact('news', 'projects'));
    }

    public function vote(Request $request, $user)
    {
        return response()->json(['success' => false, 'message' => 'Coming soon!']);
    }

    public function getVotes()
    {
        return response()->json(['bebars' => 0, 'ahmed' => 0]);
    }
}