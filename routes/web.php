<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;

Route::get('/', fn() => redirect()->route('admin.login'));

// Auth
Route::get('/login',  [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout',[AuthController::class, 'logout'])->name('admin.logout');

// Admin panel — requires auth + admin role
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/users',           [UserController::class, 'index'])->name('admin.users.index');
    Route::post('/users',          [UserController::class, 'store'])->name('admin.users.store');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});
