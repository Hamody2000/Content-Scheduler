<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PlatformController;

// Public Routes (Authentication)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// Protected Routes (Require Authentication)
Route::middleware('auth:sanctum')->group(function () {
    // User Info
    Route::get('/user', function (Request $request) {
        return $request->user();
    });


    Route::post('/logout', [AuthController::class, 'logout']);

    // Posts (RESTful API)
    Route::apiResource('/posts', PostController::class);



    // Platforms Management
    Route::get('/platforms', [PlatformController::class, 'index']);
    Route::patch('/platforms/{platform}/toggle', [PlatformController::class, 'toggle']);
});

