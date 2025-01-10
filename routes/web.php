<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CreatePosteControlle;
use App\Http\Controllers\UserDashboardController;
// use App\Http\Controllers\UserArticleController;
// use App\Http\Controllers\UserSubscriptionController;
// use App\Http\Controllers\UserHistoryController;
use Illuminate\Support\Facades\Route;

// use App\Http\Middleware\CheckRole;

// Routes publiques
Route::get('/', function() {
    return view('home');
})->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// Routes protégées
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Routes pour l'éditeur
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard')->middleware('role:Éditeur');

    // Routes pour l'abonné
    Route::middleware(['auth'])->prefix('user')->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
        Route::get('/articles', [UserArticleController::class, 'index'])->name('user.articles');
        Route::get('/subscriptions', [UserSubscriptionController::class, 'index'])->name('user.subscriptions');
        Route::get('/history', [UserHistoryController::class, 'index'])->name('user.history');
        Route::get('/createPoste', [CreatePosteControlle::class, 'showCreatePoste'])->name('createPoste.form');
        Route::post('/createPoste', [CreatePosteControlle::class, 'createPoste'])->name('createPoste.submit');
    });
});



?>


