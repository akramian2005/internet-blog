<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;

Route::get('/', [MainController::class, 'index'])->name('index');

Route::get('/auth/register', [RegisterController::class, 'showRegistrationForm'])->name('register.show');
Route::post('/auth/register', [RegisterController::class, 'register'])->name('register');

Route::get('/auth/login', [LoginController::class, 'showLoginForm'])->name('login.show');
Route::post('/auth/login', [LoginController::class, 'login'])->name('login');

Route::post('/auth/logout', [LogoutController::class, 'logout'])->name('logout');

use App\Http\Controllers\ArticleController;


Route::get('/articles/create', [ArticleController::class, 'create'])->middleware('auth')->name('articles.create');
Route::post('/articles', [ArticleController::class, 'store'])->middleware('auth')->name('articles.store');
Route::get('/articles/{id}/edit', [ArticleController::class, 'edit'])->middleware('auth')->name('articles.edit');
Route::put('/articles/{id}', [ArticleController::class, 'update'])->middleware('auth')->name('articles.update');
Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->middleware('auth')->name('articles.destroy');
Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');

