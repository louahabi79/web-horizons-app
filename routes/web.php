<?php

use App\Http\Controllers\AuthController;

// Show the login form
// Show the login form
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');

// Handle the login form submission
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard'); // Admin dashboard view
    })->name('admin.dashboard');

    Route::get('/user/dashboard', function () {
        return view('user.dashboard'); // User dashboard view
    })->name('user.dashboard');

    Route::get('/home', function () {
        return view('home'); // Default home view
    })->name('home');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Show the registration form
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');

Route::get('/', function(){
    return view('home');
})




?>


