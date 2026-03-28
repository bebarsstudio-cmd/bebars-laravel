<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::recent()->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category' => 'required|in:general,announcement,release,upcoming',
        ]);

        News::create([
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
            'author' => auth()->user()->name,
            'date' => now(),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.news.index')
            ->with('success', 'News published successfully!');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category' => 'required|in:general,announcement,release,upcoming',
        ]);

        $news->update([
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
        ]);

        return redirect()->route('admin.news.index')
            ->with('success', 'News updated successfully!');
    }

    public function destroy(News $news)
    {
        $news->delete();
        
        return redirect()->route('admin.news.index')
            ->with('success', 'News deleted successfully!');
    }
}