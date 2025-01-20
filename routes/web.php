<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Member\ContentController;
use App\Http\Controllers\Member\DashboardController;
use App\Http\Controllers\Member\MembershipController;
use App\Http\Controllers\Member\ReadingHistoryController;
use App\Http\Controllers\Member\SubmissionController;
use App\Http\Controllers\Member\DiscussionController;

use App\Http\Controllers\ThemeManager\DashboardController as ThemeManagerDashboardController;
use App\Http\Controllers\ThemeManager\ContentController as ThemeManagerContentController;
use App\Http\Controllers\ThemeManager\MembershipController as ThemeManagerMembershipController;
use App\Http\Controllers\ThemeManager\ModeratorController;

use App\Http\Controllers\editeur\DashboardController as AdminDashboardController;
use App\Http\Controllers\editeur\NumeroController as EditorIssueController;
use App\Http\Controllers\editeur\UserController;
use App\Http\Controllers\editeur\ArticleController;

use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/articles/{article}', [HomeController::class, 'showArticle'])->name('public.articles.show');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    Route::get('/pending', [AuthController::class, 'showPendingPage'])->name('auth.pending');
});


Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Member routes
    Route::prefix('member')->name('member.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Articles/Content
        Route::get('/articles', [ContentController::class, 'index'])->name('articles');
        Route::get('/articles/{article}', [ContentController::class, 'show'])->name('articles.show');
        Route::post('/articles/{article}/rate', [ContentController::class, 'rate'])->name('articles.rate');
        
        // Submissions
        Route::get('/submit', [SubmissionController::class, 'create'])->name('submit');
        Route::post('/submit', [SubmissionController::class, 'store'])->name('submit.store');
        Route::get('/submissions', [SubmissionController::class, 'index'])->name('submissions');
        Route::delete('/submissions/{article}', [SubmissionController::class, 'delete'])->name('submissions.delete');
        
        // Discussions
        Route::get('/discussions/{article}', [DiscussionController::class, 'show'])->name('discussions.show');
        Route::post('/discussions/{article}', [DiscussionController::class, 'store'])->name('discussions.store');
        
        // Memberships
        Route::get('/memberships', [MembershipController::class, 'index'])->name('memberships');
        Route::post('/memberships/{theme}', [MembershipController::class, 'subscribe'])->name('memberships.subscribe');
        Route::delete('/memberships/{theme}', [MembershipController::class, 'unsubscribe'])->name('memberships.unsubscribe');
        
        // Reading History
        Route::get('/history', [ReadingHistoryController::class, 'index'])->name('history');
    });

    // Theme Manager routes
    Route::prefix('theme-manager')->name('theme-manager.')->middleware(['auth'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [ThemeManagerDashboardController::class, 'index'])->name('dashboard');
        
        // Gestion du contenu/articles
        Route::prefix('content')->name('content.')->group(function () {
            Route::get('/', [ThemeManagerContentController::class, 'index'])->name('index');
            Route::get('/show/{article}', [ThemeManagerContentController::class, 'show'])->name('show');
            Route::post('/accept/{article}', [ThemeManagerContentController::class, 'accept'])->name('accept');
            Route::post('/reject/{article}', [ThemeManagerContentController::class, 'reject'])->name('reject');
            Route::post('/propose/{article}', [ThemeManagerContentController::class, 'proposeForPublication'])->name('propose');
        });
        
        // Gestion des abonnés
        Route::prefix('members')->name('members.')->group(function () {
            Route::get('/', [ThemeManagerMembershipController::class, 'index'])->name('index');
            Route::get('/export', [ThemeManagerMembershipController::class, 'export'])->name('export');
            Route::delete('/{user}', [ThemeManagerMembershipController::class, 'remove'])->name('remove');
        });
        
        // Gestion de la modération
        Route::prefix('moderation')->name('moderation.')->group(function () {
            Route::get('/', [ModeratorController::class, 'index'])->name('index');
            Route::post('/comment/{article}', [ModeratorController::class, 'addComment'])->name('comment');
            Route::delete('/message/{message}', [ModeratorController::class, 'deleteMessage'])->name('delete-message');
        });
    });



    // Editor routes
    Route::prefix('editor')->name('editor.')->middleware(['auth'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Articles à valider
        Route::prefix('articles')->name('articles.')->group(function () {
            Route::get('/', [ArticleController::class, 'index'])->name('index');
            Route::get('/{article}', [ArticleController::class, 'show'])->name('show');
            Route::post('/{article}/toggle-status', [ArticleController::class, 'toggleStatus'])->name('toggle-status');
            Route::post('/{article}/assign-to-numero', [ArticleController::class, 'assignToNumero'])->name('assign-to-numero');
            Route::delete('/{article}', [ArticleController::class, 'destroy'])->name('destroy');
        });
        
        // Gestion des numéros
        Route::prefix('issues')->name('issues.')->group(function () {
            Route::get('/', [EditorIssueController::class, 'index'])->name('index');
            Route::get('/create', [EditorIssueController::class, 'create'])->name('create');
            Route::post('/', [EditorIssueController::class, 'store'])->name('store');
            Route::get('/{numero}/edit', [EditorIssueController::class, 'edit'])->name('edit');
            Route::put('/{numero}', [EditorIssueController::class, 'update'])->name('update');
            Route::delete('/{numero}', [EditorIssueController::class, 'destroy'])->name('destroy');
            Route::post('/{numero}/publish', [EditorIssueController::class, 'publish'])->name('publish');
            Route::post('/{numero}/unpublish', [EditorIssueController::class, 'unpublish'])->name('unpublish');
            Route::post('/{numero}/toggle-visibility', [EditorIssueController::class, 'toggleVisibility'])->name('toggle-visibility');
        });
        
        // Gestion des utilisateurs
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/pending', [UserController::class, 'pendingRequests'])->name('pending');
            Route::post('/{user}/approve', [UserController::class, 'approveUser'])->name('approve');
            Route::post('/{user}/reject', [UserController::class, 'rejectUser'])->name('reject');
            Route::post('/{user}/block', [UserController::class, 'block'])->name('block');
            Route::post('/{user}/unblock', [UserController::class, 'unblock'])->name('unblock');
            Route::post('/{user}/update-role', [UserController::class, 'updateRole'])->name('update-role');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
            
        });
    });
});




?>







