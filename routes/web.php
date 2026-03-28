<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ConverterController;
use App\Http\Controllers\YoutubeController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\FeedbackController as AdminFeedbackController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/converter', [ConverterController::class, 'index'])->name('converter');
Route::post('/converter/convert', [ConverterController::class, 'convert'])->name('converter.convert');
Route::get('/youtube', [YoutubeController::class, 'index'])->name('youtube');
Route::post('/youtube/download', [YoutubeController::class, 'download'])->name('youtube.download');
Route::get('/boba', [GameController::class, 'boba'])->name('boba');

// VS Section Routes
Route::post('/vote/{user}', [HomeController::class, 'vote'])->name('vote');
Route::get('/votes', [HomeController::class, 'getVotes'])->name('votes.get');

// Feedback Routes
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

// Admin Routes (protected)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // News Management
    Route::resource('news', NewsController::class);
    
    // Projects Management
    Route::resource('projects', ProjectController::class);
    
    // Admin Management
    Route::resource('admins', AdminController::class);
    Route::post('admins/{admin}/reset-password', [AdminController::class, 'resetPassword'])->name('admins.reset-password');
    
    // Feedback Management
    Route::get('feedback', [AdminFeedbackController::class, 'index'])->name('feedback.index');
    Route::delete('feedback/{feedback}', [AdminFeedbackController::class, 'destroy'])->name('feedback.destroy');
});

// Auth Routes (Laravel UI)
Auth::routes();