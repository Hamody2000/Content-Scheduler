<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\PostController;
use App\Http\Controllers\PlatformController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('posts', PostController::class);
    Route::get('/posts/analytics', [PostController::class, 'analytics']);
    Route::get('platforms', [PlatformController::class, 'index']);
    Route::post('platforms/toggle', [PlatformController::class, 'toggle']);
});
