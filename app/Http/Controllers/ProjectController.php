<?php

namespace App\Http\Controllers;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    $projects = Project::paginate(10);
    return view('projects.index', compact('projects'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'start_date' => 'nullable|date',
        'deadline' => 'nullable|date',
    ]);

    Project::create($request->all());

    return redirect()->route('projects.index')
        ->with('success', 'Project created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
   {
    return view('projects.show', compact('project'));
   }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
         $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'start_date' => 'nullable|date',
        'deadline' => 'nullable|date',
    ]);

    $project->update($request->all());

    return redirect()->route('projects.index')
        ->with('success', 'Project updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
         $project->delete();

    return redirect()->route('projects.index')
        ->with('success', 'Project deleted successfully');
    }
}
