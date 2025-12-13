<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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