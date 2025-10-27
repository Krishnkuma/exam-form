<?php

use App\Http\Controllers\AdminDashboard;
use App\Http\Controllers\StudentDashboard;
use App\Http\Controllers\AuthController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Admin Routes
Route::get('admin-dashboard', [AdminDashboard::class, 'dashboard'])->name('admin-dashboard');


// Student Routes
Route::get('student-dashboard', [StudentDashboard::class, 'dashboard'])->name('student-dashboard');
Route::post('/register/create-order', [StudentDashboard::class, 'createOrder'])->name('register.createOrder');
Route::post('/register/verify', [StudentDashboard::class, 'verify'])->name('register.verify');
