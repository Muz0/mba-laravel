<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\MediaController;

Route::prefix('v1')->group(function () {
    Route::get('posts', [PostController::class, 'index']);
    Route::get('posts/{post}', [PostController::class, 'show']);
    Route::get('media', [MediaController::class, 'index']);
});

// Optional: Protected routes with Sanctum
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    // Add authenticated API routes here if needed
});