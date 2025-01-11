<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\ArticleController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\SubscriptionController;
use App\Http\Controllers\User\HistoryController;
use App\Http\Controllers\User\CreateArticleController;
use App\Http\Controllers\User\ConversationController;
use App\Http\Controllers\User\ArticlePropositionController;


use App\Http\Controllers\Theme\DashboardController as ThemeDashboardController;
use App\Http\Controllers\Theme\ArticleController as ThemeArticleController;
use App\Http\Controllers\Theme\SubscriptionController as ThemeSubscriptionController;
use App\Http\Controllers\Theme\StatisticsController as ThemeStatisticsController;
use App\Http\Controllers\Theme\ModerationController as ThemeModerationController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

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

    // Routes pour l'abonné
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Articles
        Route::get('/articles', [ArticleController::class, 'index'])->name('articles');
        Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
        Route::post('/articles/{article}/rate', [ArticleController::class, 'rate'])->name('articles.rate');
        
        // Propositions d'articles
        Route::get('/create-article', [CreateArticleController::class, 'showCreatePoste'])->name('createPoste');
        Route::post('/create-article', [CreateArticleController::class, 'createPoste'])->name('createPoste.submit');
        Route::get('/propositions', [ArticlePropositionController::class, 'index'])->name('propositions');
        Route::delete('/propositions/{article}', [ArticlePropositionController::class, 'retirer'])->name('propositions.retirer');
        
        // Conversations
        Route::get('/articles/{article}/conversation', [ConversationController::class, 'show'])->name('conversations.show');
        Route::post('/articles/{article}/conversation', [ConversationController::class, 'store'])->name('conversations.store');
        
        // Abonnements
        Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions');
        Route::post('/themes/{theme}/subscribe', [SubscriptionController::class, 'subscribe'])->name('theme.subscribe');
        Route::post('/themes/{theme}/unsubscribe', [SubscriptionController::class, 'unsubscribe'])->name('theme.unsubscribe');
        
        // Historique
        Route::get('/history', [HistoryController::class, 'index'])->name('history');
    });

    // Routes pour le responsable de thème
    Route::prefix('theme')->name('theme.')->group(function () {
        Route::get('/dashboard', [ThemeDashboardController::class, 'index'])->name('dashboard');

        // Gestion des articles
        Route::get('/articles', [ThemeArticleController::class, 'index'])->name('articles.index');
        Route::get('/articles/{article}', [ThemeArticleController::class, 'show'])->name('articles.show');
        Route::post('/articles/{article}/propose', [ThemeArticleController::class, 'proposeForPublication'])->name('articles.propose');
        Route::post('/articles/{article}/reject', [ThemeArticleController::class, 'reject'])->name('articles.reject');

        // Gestion des abonnements
        Route::get('/subscriptions', [ThemeSubscriptionController::class, 'index'])->name('subscriptions.index');
        Route::delete('/subscriptions/{subscription}', [ThemeSubscriptionController::class, 'remove'])->name('subscriptions.remove');

        // Statistiques
        Route::get('/statistics', [ThemeStatisticsController::class, 'index'])->name('statistics');

        // Modération
        Route::get('/moderation', [ThemeModerationController::class, 'index'])->name('moderation.index');
        Route::delete('/moderation/messages/{message}', [ThemeModerationController::class, 'deleteMessage'])->name('moderation.delete');
        Route::post('/moderation/messages/{message}/warn', [ThemeModerationController::class, 'warnUser'])->name('moderation.warn');
    });

    // Routes pour l'admin
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/users', [AdminDashboardController::class, 'users'])->name('users');
        Route::get('/themes', [AdminDashboardController::class, 'themes'])->name('themes');
        Route::get('/stats', [AdminDashboardController::class, 'stats'])->name('stats');
    });
});





?>







