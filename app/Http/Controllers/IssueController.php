<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Issue;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $issues = Issue::with(['project', 'tags'])->paginate(10);
        return view('issues.index', compact('issues'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('issues.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
             'project_id' => 'required|exists:projects,id',
             'title' => 'required|string|max:100',
             'description' => 'required|string',
             'status' => 'required|in:open,in_progress,closed',
             'priority' => 'required|in:low,medium,high',
             'due_date' => 'nullable|date',
        ]);

        Issue::create($request->all());
        return redirect()->route('issues.index')
        ->with('success', 'Issue created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Issue $issue)
      {
    $issue->load(['project', 'tags', 'comments']);

    return view('issues.show', compact('issue'));
        }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Issue $issue)
    {
        return view('issues.edit', compact('issue'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Issue $issue)
   {
    $request->validate([
        'project_id' => 'required|exists:projects,id',
        'title' => 'required|string|max:100',
        'description' => 'required|string',
        'status' => 'required|in:open,in_progress,closed',
        'priority' => 'required|in:low,medium,high',
        'due_date' => 'nullable|date',
    ]);

    $issue->update($request->all());

    return redirect()->route('issues.index')
        ->with('success', 'Issue updated successfully');
  }
 
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Issue $issue)
    {
        $issue->delete();
        return redirect()->route('issues.index')->
        with('success', 'Issue deleted successfully');
    }
}
