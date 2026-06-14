<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\ScheduleController;

Route::prefix('v1')->group(function () {

    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me',      [AuthController::class, 'me']);

        Route::get('/courses',      [CourseController::class, 'index']);
        Route::get('/courses/{id}', [CourseController::class, 'show']);

        Route::get('/schedule', [ScheduleController::class, 'index']);
    });
});
