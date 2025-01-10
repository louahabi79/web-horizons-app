<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CreatePosteControlle;


// Show the login form
// Show the login form
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

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
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
// User dashboard route
Route::middleware('auth')->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
});

Route::get('/', function(){
    return view('home');
})->name('home');

// Route::get('/createPoste', [CreatePosteControlle::class, 'showCreatePoste'])->name('createPost');
// Route::post('/createPoste', [CreatePosteControlle::class, 'CreatePoste'])->name('createPost');


// Protect the routes with the 'auth' middleware
Route::middleware('auth')->group(function () {
    // Show the form to create a post
    Route::get('/createPoste', [CreatePosteControlle::class, 'showCreatePoste'])->name('createPoste.form');

    // Handle the form submission to create a post
    Route::post('/createPoste', [CreatePosteControlle::class, 'createPoste'])->name('createPoste.submit');
});



?>


