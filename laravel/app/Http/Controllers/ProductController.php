<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class ProductController extends Controller
{

    // List all products
    public function getProducts()
    {
        return Product::all();
    }

    // Create a new product (manager/admin only)
    public function createProduct(Request $request)
    {
        $user = Auth::user();
        
        // Check role-based access
        if (!$user->hasRole('manager') && !$user->hasRole('admin')) {
            return response()->json(['message' => 'Only managers and admins can create products'], 403);
        }

        // Also use policy for additional authorization
        $this->authorize('create', Product::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'pricing' => 'required|numeric',
            'description' => 'nullable|string',
            'images' => 'nullable|string',
        ]);

        $validated['created_by'] = auth()->user()->id;
        $product = Product::create($validated);
        return response()->json($product, 201);
    }

    // Get a product by id
    public function getProductById($productId)
    {
        $product = Product::findOrFail($productId);
        $this->authorize('view', $product);
        return $product;
    }

    // Update product
    public function updateProduct(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $this->authorize('update', $product);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'category_id' => 'sometimes|required|integer|exists:categories,id',
            'pricing' => 'sometimes|required|numeric',
            'description' => 'nullable|string',
            'images' => 'nullable|string',
        ]);

        $product->fill($validated);
        $product->save();
        return $product;
    }

    // Delete product
    public function deleteProduct($productId)
    {
        $product = Product::findOrFail($productId);
        $this->authorize('delete', $product);
        $product->delete();
        return response()->noContent();
    }

    // Example: get first product with specific pricing
    public function firstByPricing($amount)
    {
        return Product::where('pricing', $amount)->first();
    }

    // Example: process products in chunks (demonstrates Collection usage)
    public function chunkProcess()
    {
        $processed = 0;
        Product::chunk(200, function (Collection $products) use (&$processed) {
            // Example processing: count products in this chunk
            $processed += $products->count();
        });

        return ['processed' => $processed];
    }

    // Example: stats (count and max pricing)
    public function stats()
    {
        return [
            'count' => Product::count(),
            'max_pricing' => Product::max('pricing'),
        ];
    }

    // Example: demonstrate Collection transformations after get()/all()
    public function collectionDemo()
    {
        $products = Product::get(); // Illuminate\Database\Eloquent\Collection
        $transformed = $products->map(function (Product $p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'pricing' => $p->pricing,
                'name_upper' => strtoupper($p->name),
            ];
        });

        // You can also filter, pluck, reduce, etc.
        // $filtered = $products->filter(fn($p) => $p->pricing > 100);
        // $names = $products->pluck('name');

        return $transformed; // still a Collection, auto-serialized to JSON
    }

}
