<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $comments = Comment::with('issue')->paginate(10);

         return view('comments.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'issue_id' => 'required|exists:issues,id',
        'author_name' => 'required|string|max:100',
        'body' => 'required|string',
    ]);

    $comment = Comment::create($validated);

    return response()->json([
        'author_name' => $comment->author_name,
        'body' => $comment->body,
        'created_at' => $comment->created_at->format('d M Y H:i'),
    ]);
}

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
         
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
         
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

    return redirect()
        ->route('comments.index')
        ->with('success', 'Comment deleted successfully');
    }
}
