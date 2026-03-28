<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Project;
use App\Models\Like;

class HomeController extends Controller
{
    public function index()
    {
        $news = News::latest()->take(6)->get();
        $projects = Project::orderBy('order')->get();
        $votes = Like::getVotes();
        
        return view('home', compact('news', 'projects', 'votes'));
    }
}