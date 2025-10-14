<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;

Route::get('/', [MainController::class, 'index'])->name('index');

Route::get('/auth/register', [RegisterController::class, 'showRegistrationForm'])->name('register.show');
Route::post('/auth/register', [RegisterController::class, 'register'])->name('register');
Route::get('/auth/login', [LoginController::class, 'showLoginForm'])->name('login.show');
Route::post('/auth/login', [LoginController::class, 'login'])->name('login');
Route::post('/auth/logout', [LogoutController::class, 'logout'])->name('logout');

Route::get('/articles/create', [ArticleController::class, 'create'])->middleware('auth')->name('articles.create');
Route::post('/articles', [ArticleController::class, 'store'])->middleware('auth')->name('articles.store');
Route::get('/articles/{id}/edit', [ArticleController::class, 'edit'])->middleware('auth')->name('articles.edit');
Route::put('/articles/{id}', [ArticleController::class, 'update'])->middleware('auth')->name('articles.update');
Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->middleware('auth')->name('articles.destroy');
Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');
Route::middleware('auth')->group(function () {
    Route::post('/articles/{article}/like', [ArticleController::class, 'like'])->name('articles.like');
    Route::post('/articles/{article}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');  
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});