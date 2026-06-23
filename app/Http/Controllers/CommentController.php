<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreCommentRequest;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
   {
    $comments = Comment::where('issue_id', $request->issue_id)
        ->orderBy('created_at', 'desc')
        ->paginate(5);

    return response()->json($comments);
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
public function store(StoreCommentRequest $request)
{
    $comment = Comment::create($request->all());
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
