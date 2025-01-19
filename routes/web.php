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

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\IssueController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\ArticleManagementController;

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
    Route::prefix('theme-manager')->name('theme-manager.')->group(function () {
        Route::get('/dashboard', [ThemeManagerDashboardController::class, 'index'])->name('dashboard');
        Route::get('/content', [ThemeManagerContentController::class, 'index'])->name('content');
        Route::get('/members', [ThemeManagerMembershipController::class, 'index'])->name('members');
        Route::get('/moderation', [ModeratorController::class, 'index'])->name('moderation');
    });

    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('issues', IssueController::class);
        Route::resource('users', UserManagementController::class);
        Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
        Route::resource('articles', ArticleManagementController::class);
    });
});




?>







