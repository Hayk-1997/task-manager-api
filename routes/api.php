<?php

use App\Http\Controllers\StatusController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'getAuthenticatedUser']);

    Route::get('statuses', [StatusController::class, 'index']);

    // Task routes
    Route::get('task/all', [TaskController::class, 'index']);
    Route::put('task/{id}', [TaskController::class, 'update']);
    Route::delete('task/{task}', [TaskController::class, 'destroy']);
    Route::post('task/store', [TaskController::class, 'store']);

    // User routes
    Route::get('/users', [UserController::class, 'index']);
    Route::patch('/users/{user}/toggle-availability', [UserController::class, 'toggleAvailability']);
});
