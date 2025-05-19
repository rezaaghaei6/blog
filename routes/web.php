<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\DashboardController;

// Public Routes
Route::get('/', [App\Http\Controllers\ArticleController::class, 'index'])->name('home');
Route::get('/articles', [App\Http\Controllers\ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article:slug}', [App\Http\Controllers\ArticleController::class, 'show'])->name('articles.show');
Route::get('/categories/{category:slug}', [App\Http\Controllers\ArticleController::class, 'category'])->name('articles.category');
Route::get('/tags/{tag:slug}', [App\Http\Controllers\ArticleController::class, 'tag'])->name('articles.tag');
Route::get('/search', [App\Http\Controllers\ArticleController::class, 'search'])->name('articles.search');

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Article Routes
    Route::resource('articles', ArticleController::class);
    Route::post('articles/{article}/publish', [ArticleController::class, 'publish'])->name('articles.publish');
    Route::post('articles/{article}/unpublish', [ArticleController::class, 'unpublish'])->name('articles.unpublish');

    // Category Routes
    Route::resource('categories', CategoryController::class);

    // Tag Routes
    Route::resource('tags', TagController::class);
});

require __DIR__.'/auth.php';