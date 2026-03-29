<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ConverterController;
use App\Http\Controllers\YoutubeController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\FeedbackController as AdminFeedbackController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==================== PUBLIC ROUTES ====================

Route::name('home')->get('/', [HomeController::class, 'index']);

// Tools Section
Route::prefix('tools')->name('tools.')->group(function () {
    Route::controller(ConverterController::class)->group(function () {
        Route::get('/converter', 'index')->name('converter');
        Route::post('/converter/convert', 'convert')->name('converter.convert');
    });
});

// Media Section
Route::prefix('media')->name('media.')->group(function () {
    Route::controller(YoutubeController::class)->group(function () {
        Route::get('/youtube', 'index')->name('youtube');
        Route::post('/youtube/download', 'download')->name('youtube.download');
    });
});

// Games Section
// Boba Game Routes
Route::get('/boba', [GameController::class, 'boba'])->name('boba');
Route::post('/api/save-score', [GameController::class, 'saveScore'])->name('save.score');
Route::get('/api/leaderboard', [GameController::class, 'getLeaderboard'])->name('leaderboard');

// Voting System
Route::prefix('vote')->name('vote.')->group(function () {
    Route::post('/{user}', [HomeController::class, 'vote'])->name('store');
    Route::get('/', [HomeController::class, 'getVotes'])->name('get');
});

// Feedback
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

// ==================== AUTHENTICATION ====================

Auth::routes(['register' => true, 'reset' => true, 'verify' => false]);

// Post-login redirect
Route::get('/home', fn() => redirect()->route('home'))->name('home.redirect');

// ==================== ADMIN ROUTES ====================

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        
        // Content Management
        Route::resource('news', NewsController::class);
        Route::resource('projects', ProjectController::class);
        
        // User Management
        Route::resource('admins', AdminController::class)->except(['show']);
        Route::post('admins/{admin}/reset-password', [AdminController::class, 'resetPassword'])->name('admins.reset-password');
        // Add these routes if not already present
Route::post('/vote/{user}', [HomeController::class, 'vote'])->name('vote');
Route::get('/votes', [HomeController::class, 'getVotes'])->name('votes.get');
        // Feedback Management
        Route::get('feedback', [AdminFeedbackController::class, 'index'])->name('feedback.index');
        Route::delete('feedback/{feedback}', [AdminFeedbackController::class, 'destroy'])->name('feedback.destroy');
    });