<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('order')->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'technologies' => 'nullable|array',
            'status' => 'required|in:development,beta,released,live',
            'order' => 'integer',
        ]);

        Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'technologies' => $request->technologies,
            'status' => $request->status,
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('admin.projects.index')->with('success', 'Project created!');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'technologies' => 'nullable|array',
            'status' => 'required|in:development,beta,released,live',
            'order' => 'integer',
        ]);

        $project->update([
            'title' => $request->title,
            'description' => $request->description,
            'technologies' => $request->technologies,
            'status' => $request->status,
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('admin.projects.index')->with('success', 'Project updated!');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted!');
    }
}