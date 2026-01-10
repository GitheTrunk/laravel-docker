<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthorController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,name',
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $validated['username'],
                'email' => strtolower($validated['username']) . '@example.com',
                'password' => Hash::make('password'),
            ]);

            $author = Author::create([
                'name' => $validated['name'],
                'user_id' => $user->id,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Author created successfully',
                'data' => [
                    'author' => $author->load('user'),
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to create author',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
