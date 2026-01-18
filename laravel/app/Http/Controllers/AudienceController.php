<?php

namespace App\Http\Controllers;

use App\Models\Audience;
use Illuminate\Http\Request;

class AudienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Audience::with(['article', 'user'])->paginate(15); // load related articles and users 15 per page
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'article_id' => 'required|exists:articles,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $audience = Audience::create($data);

        return response()->json([
            'message' => 'Audience created successfully',
            'data' => $audience->load(['article', 'user']),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Audience $audience)
    {
        return $audience->load(['article', 'user', 'comments']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Audience $audience)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'article_id' => 'sometimes|required|exists:articles,id',
            'user_id' => 'sometimes|required|exists:users,id',
        ]);
        
        $audience->update($data);

        return $audience->load(['article', 'user']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Audience $audience)
    {
        $audience->delete();

        return response()->noContent();
    }
}
