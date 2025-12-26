<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(CategoryController::class)->prefix('categories')->group(function()    {
    Route::get('/', 'getCategories');
    Route::post('/', 'createCategory');
    Route::get('/{categoryId}', 'getCategoryById');
    Route::put('/{categoryId}', 'updateCategory');
    Route::delete('/{categoryId}', 'deleteCategory');
});

Route::controller(ProductController::class)->prefix('products')->group(function()    {
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