<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;;
use App\Models\Article;
use App\Models\Author;
use App\Models\Audience;

class CommentController extends Controller
{
    //
    public function index()
    {
        return Comment::with(['user', 'commentable'])->paginate(15);
    }

    public function commentOnArticle(Request $request, Article $article)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment = new Comment($validated);
        $comment->user_id = auth()->id();
        $article->comments()->save($comment);

        return response()->json([
            'message' => 'Comment added successfully',
            'comment' => $comment->load(['user', 'commentable']),
        ], 201);
    }

    public function commentOnAuthor(Request $request, Author $author)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:500'
        ]);

        $comment = new Comment($validated);
        $comment->user_id = auth()->id();
        $author->comments()->save($comment);

        return response()->json([
            'message' => 'Comment added successfully',
            'comment' => $comment->load(['user', 'commentable']),
        ], 201);
    }

    public function commentOnAudience(Request $request, Audience $audience)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:500'
        ]);

        $comment = new Comment($validated);
        $comment->user_id = auth()->id();
        $audience->comments()->save($comment);

        return response()->json([
            'message' => 'Comment added successfully',
            'comment' => $comment->load(['user', 'commentable']),
        ], 201);
    }

    public function articleComments(Article $article)
    {
        return $article->comments()->with('user')->paginate(15);
    }

    // Get comments for a specific author
    public function authorComments(Author $author)
    {
        return $author->comments()->with('user')->paginate(15);
    }

    // Get comments for a specific audience
    public function audienceComments(Audience $audience)
    {
        return $audience->comments()->with('user')->paginate(15);
    }

    // Delete a comment
    public function destroy(Comment $comment)
    {
        // Optional: check if user owns the comment
        if ($comment->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->delete();
        return response()->noContent();
    }
}
