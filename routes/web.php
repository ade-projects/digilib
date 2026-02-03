<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;

// Public route
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

Route::post('/login', [AuthController::class, 'login']);

// Redirect route
Route::get('/',function () {
    if (Auth::check()) {
        return to_route('dashboard');
    }
    return to_route('login');
});

// Register route
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Protected access
Route::middleware(['auth'])->group(function () {

    // 1. Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // 2. Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // 3. Manajemen pengguna
    Route::resource('users', UserController::class);

    // 4. middleware is_admin
    Route::resource('users', UserController::class)->middleware('is_admin');
});