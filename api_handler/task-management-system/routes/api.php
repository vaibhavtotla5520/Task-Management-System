<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// User Registration and Login
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->name('login');

// Route to get the authenticated user
Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'user']);

// Group routes that require authentication
Route::middleware('auth:sanctum')->group(function () {

    // Board Routes
    Route::get('boards', [BoardController::class, 'index']);
    Route::post('boards', [BoardController::class, 'store']);

    // Routes that need to ensure board ownership
    Route::middleware('ensure.board.ownership')->group(function () {
        Route::get('boards/{board}', [BoardController::class, 'show']);
        Route::put('boards/{board}', [BoardController::class, 'update']);
        Route::delete('boards/{board}', [BoardController::class, 'destroy']);

        // Task Routes within a board
        Route::get('boards/{board}/tasks', [TaskController::class, 'index']);
        Route::post('boards/{board}/tasks', [TaskController::class, 'store']);
        Route::get('boards/{board}/tasks/{task}', [TaskController::class, 'show']);
        Route::put('boards/{board}/tasks/{task}', [TaskController::class, 'update']);
        Route::delete('boards/{board}/tasks/{task}', [TaskController::class, 'destroy']);
    });

    // Logout Route
    Route::post('logout', [AuthController::class, 'logout']);
});


Route::middleware('auth:sanctum')->post('boards/{board}/tasks', [TaskController::class, 'store']);
