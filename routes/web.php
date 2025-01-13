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

// use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
// use App\Http\Controllers\Admin\ArticleController as AdminArticleController;

use App\Http\Controllers\Editeur\DashboardController as EditeurDashboardController;
use App\Http\Controllers\Editeur\NumeroController;
use App\Http\Controllers\Editeur\UserController;
use App\Http\Controllers\Editeur\StatisticsController;
use App\Http\Controllers\Editeur\ArticleController as EditeurArticleController;

use Illuminate\Support\Facades\Route;

// use App\Http\Middleware\CheckRole;

// Routes publiques
Route::get('/', function() {
    return view('home');
})->name('home');

// Routes d'authentification
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    // Ajouter la route pour la page d'attente
    Route::get('/pending', [AuthController::class, 'showPendingPage'])->name('auth.pending');
});

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
        Route::get('/articles', [ThemeArticleController::class, 'index'])->name('articles');
        Route::get('/articles/{article}', [ThemeArticleController::class, 'show'])->name('articles.show');
        Route::post('/articles/{article}/propose', [ThemeArticleController::class, 'proposeForPublication'])
            ->name('articles.propose')
            ->middleware('web');
        Route::post('/articles/{article}/reject', [ThemeArticleController::class, 'reject'])
            ->name('articles.reject')
            ->middleware('web');
        Route::post('/articles/{article}/accept', [ThemeArticleController::class, 'accept'])->name('articles.accept');

        // Gestion des abonnements
        Route::get('/subscriptions', [ThemeSubscriptionController::class, 'index'])->name('subscribers');
        Route::delete('/subscriptions/{subscriptionId}', [ThemeSubscriptionController::class, 'remove'])
            ->name('subscriptions.remove')
            ->middleware('web');

        // Statistiques
        Route::get('/statistics', [ThemeStatisticsController::class, 'index'])->name('stats');

        // Modération
        Route::get('/moderation', [ThemeModerationController::class, 'index'])->name('moderation.index');
        Route::delete('/moderation/messages/{message}', [ThemeModerationController::class, 'deleteMessage'])->name('moderation.delete');
        Route::post('/moderation/messages/{message}/warn', [ThemeModerationController::class, 'warnUser'])->name('moderation.warn');
    });




    // Routes pour l'éditeur
    Route::prefix('editeur')->name('editeur.')->middleware(['auth'])->group(function () {
        Route::get('/dashboard', [EditeurDashboardController::class, 'index'])->name('dashboard');

        // Gestion des numéros
        Route::get('/numeros', [NumeroController::class, 'index'])->name('numeros.index');
        Route::get('/numeros/create', [NumeroController::class, 'create'])->name('numeros.create');
        Route::post('/numeros', [NumeroController::class, 'store'])->name('numeros.store');
        Route::get('/numeros/{numero}/edit', [NumeroController::class, 'edit'])->name('numeros.edit');
        Route::put('/numeros/{numero}', [NumeroController::class, 'update'])->name('numeros.update');
        Route::delete('/numeros/{numero}', [NumeroController::class, 'destroy'])->name('numeros.destroy');
        Route::post('/numeros/{numero}/publish', [NumeroController::class, 'publish'])->name('numeros.publish');
        Route::post('/numeros/{numero}/unpublish', [NumeroController::class, 'unpublish'])->name('numeros.unpublish');
        Route::post('/numeros/{numero}/toggle-visibility', [NumeroController::class, 'toggleVisibility'])->name('numeros.toggleVisibility');
        
        // Gestion des articles dans un numéro
        Route::get('/numeros/{numero}/articles', [NumeroController::class, 'manageArticles'])->name('numeros.articles');
        Route::post('/numeros/{numero}/articles', [NumeroController::class, 'addArticle'])->name('numeros.articles.add');
        Route::delete('/numeros/{numero}/articles/{article}', [NumeroController::class, 'removeArticle'])->name('numeros.articles.remove');

        // Gestion des utilisateurs
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/pending', [UserController::class, 'pendingRequests'])->name('users.pending');
        Route::post('/users/{user}/approve', [UserController::class, 'approveUser'])->name('users.approve');
        Route::delete('/users/{user}/reject', [UserController::class, 'rejectUser'])->name('users.reject');
        Route::post('/users/{user}/block', [UserController::class, 'block'])->name('users.block');
        Route::post('/users/{user}/unblock', [UserController::class, 'unblock'])->name('users.unblock');
        Route::put('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // Gestion des articles
        Route::get('/articles', [EditeurArticleController::class, 'index'])->name('articles.index');
        Route::post('/articles/{article}/approve', [EditeurArticleController::class, 'approve'])->name('articles.approve');
        Route::post('/articles/{article}/reject', [EditeurArticleController::class, 'reject'])->name('articles.reject');
        Route::post('/articles/{article}/assign', [EditeurArticleController::class, 'assignToNumero'])->name('articles.assign');
        Route::post('/articles/{article}/toggle-status', [EditeurArticleController::class, 'toggleStatus'])->name('articles.toggle-status');
        Route::delete('/articles/{article}', [EditeurArticleController::class, 'destroy'])->name('articles.destroy');
    });
});




?>







