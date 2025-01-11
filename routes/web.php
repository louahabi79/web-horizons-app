<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\ArticleController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\SubscriptionController;
use App\Http\Controllers\User\HistoryController;
use App\Http\Controllers\User\CreateArticleController;
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
    Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/articles', [ArticleController::class, 'index'])->name('articles');
        Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
        Route::get('/createPoste', [CreateArticleController::class, 'showCreatePoste'])->name('createPoste.form');
        Route::post('/createPoste', [CreateArticleController::class, 'createPoste'])->name('createPoste.submit');
        Route::get('/history', [HistoryController::class, 'index'])->name('history');
        Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions');
        Route::post('/themes/{theme}/subscribe', [SubscriptionController::class, 'subscribe'])->name('theme.subscribe');
        Route::post('/themes/{theme}/unsubscribe', [SubscriptionController::class, 'unsubscribe'])->name('theme.unsubscribe');
    });
});



?>


