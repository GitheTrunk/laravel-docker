<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class CategoryController extends Controller 
{
    public function getCategories()
    {
        return Category::all();
    }

    public function createCategory(Request $request)
    {
        // Check if user has manager or admin role
        $user = Auth::user();
        if (!$user->hasRole('manager') && !$user->hasRole('admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::create($validated);
        return response()->json($category, 201);
    }

    public function getCategoryById($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $this->authorize('view', $category);
        return $category;
    }

    public function updateCategory(Request $request, $categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $this->authorize('update', $category);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
        ]);

        $category->fill($validated);
        $category->save();
        return $category;
    }

    public function updateCategoryStatus(Request $request, $categoryId)
    {
        $category = Category::findOrFail($categoryId);
        
        // Check if user has permission via policy
        $this->authorize('update', $category);

        $validated = $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $category->update($validated);
        return response()->json($category);
    }

    public function deleteCategory($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $this->authorize('delete', $category);
        $category->delete();
        return response()->noContent();
    }
}
