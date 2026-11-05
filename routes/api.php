<?php
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Route::prefix('v1')->middleware(['auth:sanctum', App\Http\Middleware\EnsureApiTokenAbility::class])->group(function () {
    Route::get('/user', fn (Request $request) => $request->user());
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('products', ProductController::class);
});
