<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PublicSite\HomeController;
use App\Http\Controllers\PublicSite\ArticleController;
use App\Http\Controllers\PublicSite\CategoryController;
use App\Http\Controllers\PublicSite\TagController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\TagController as AdminTagController;
use Illuminate\Support\Facades\Route;

// Auth routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/article/{article}', [ArticleController::class, 'show'])->name('article.show');
Route::get('/category/{category}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/tag/{tag}', [TagController::class, 'show'])->name('tag.show');
Route::get('/feed', [HomeController::class, 'feed'])->name('feed');
Route::get('/sitemap.xml', [HomeController::class, 'sitemap'])->name('sitemap');

// Admin routes
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('articles', AdminArticleController::class);
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    Route::resource('tags', AdminTagController::class)->except(['show']);
});
