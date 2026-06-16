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

// Admin panel
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Redirect /users to students page
    Route::get('/users', fn() => redirect()->route('admin.users.students'))->name('admin.users.index');

    Route::get('/users/students', [UserController::class, 'students'])->name('admin.users.students');
    Route::get('/users/teachers', [UserController::class, 'teachers'])->name('admin.users.teachers');
    Route::get('/users/admins',   [UserController::class, 'admins'])->name('admin.users.admins');

    Route::post('/users',          [UserController::class, 'store'])->name('admin.users.store');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});
