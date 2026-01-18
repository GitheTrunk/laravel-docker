<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AudienceController;

// Public routes
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');
    
    // Find user and verify password
    $user = \App\Models\User::where('email', $credentials['email'])->first();
    if (!$user || !\Illuminate\Support\Facades\Hash::check($credentials['password'], $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    // Create Passport token
    $token = $user->createToken('mobile')->accessToken;

    return response()->json([
        'token' => $token,
        'user' => $user->load('roles')
    ]);
})->withoutMiddleware(['web']);

// Add this line here (before the protected routes)
Route::post('/authors', [AuthorController::class, 'store']);
Route::post('/articles', [ArticleController::class, 'store']);
Route::get('/articles', [ArticleController::class, 'index']);

// Protected routes
Route::middleware('auth:api')->group(function () {
    Route::get('/me', function (Request $request) {
        return $request->user()->load('roles', 'roles.permissions');
    });

    Route::get('/users', function () {
        return \App\Models\User::select('id', 'name', 'email', 'created_at')->get();
    });

    Route::controller(CategoryController::class)->prefix('categories')->group(function() {
        Route::get('/', 'getCategories');
        Route::post('/', 'createCategory');
        Route::get('/{categoryId}', 'getCategoryById');
        Route::put('/{categoryId}', 'updateCategory');
        Route::patch('/{categoryId}/status', 'updateCategoryStatus');
        Route::delete('/{categoryId}', 'deleteCategory');
    });

    Route::controller(ProductController::class)->prefix('products')->group(function() {
        Route::get('/', 'getProducts');
        Route::post('/', 'createProduct');
        Route::get('/{productId}', 'getProductById');
        Route::put('/{productId}', 'updateProduct');
        Route::delete('/{productId}', 'deleteProduct');
        // Extra examples
        Route::get('/pricing/first/{amount}', 'firstByPricing');
        Route::get('/chunk-process', 'chunkProcess');
        Route::get('/stats', 'stats');
        Route::get('/collection-demo', 'collectionDemo');
    });

    Route::controller(AudienceController::class)->prefix('audiences')->group(function(){
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{audience}', 'show');
        Route::put('/{audience}', 'update');
        Route::delete('/{audience}', 'destroy');
    });
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');