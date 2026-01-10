<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Author;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'author_name' => 'required|string|exists:authors,name',
        ]);

        $author = Author::where('name', $validated['author_name'])->first();

        if (!$author) {
            return response()->json([
                'message' => 'Author not found'
            ], 404);
        }

        $article = Article::create([
            'name' => $validated['name'],
            'author_id' => $author->id,
        ]);

        return response()->json([
            'message' => 'Article created successfully',
            'data' => [
                'article' => $article->load('author'),
            ]
        ], 201);
    }

    public function index()
    {
        $articles = Article::with('author')->get();

        return response()->json([
            'message' => 'Articles retrieved successfully',
            'data' => $articles
        ]);
    }
}
