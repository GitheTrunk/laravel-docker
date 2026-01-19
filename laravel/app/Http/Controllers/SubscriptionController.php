<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    // Subscribe a user to an article
    public function subscribe(Request $request, Article $article)
    {
        $user = $request->user();

        if ($user->subscribedArticles()->where('article_id', $article->id)->exists()) {
            return response()->json(['message' => 'Already subscribed'], 400);
        }

        $user->subscribedArticles()->attach($article->id);

        return response()->json([
            'message' => 'Subscribed successfully',
            'article' => $article,
        ], 201);
    }

    public function unsubscribe(Request $request, Article $article)
    {
        $user = $request->user();
        $user->subscribedArticles()->detach($article->id);

        return response()->json(['message' => 'Unsubscribed successfully']);
    }

    // List all subscriptions for the authenticated user
    public function mySubscriptions(Request $request)
    {
        $user = auth()->user();
        return $user->subscribedArticles()->with('author')->paginate(15);
    }

    // List all subscribers for a specific article
    public function articlesSubscsribers(Article $article)
    {
        return $article->subscribers()->paginate(15);
    }
}
