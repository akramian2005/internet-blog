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

use App\Http\Controllers\CategoryController;


// Группа маршрутов для админов (только авторизованные админы)
Route::middleware(['auth', 'admin'])->group(function () {
    
    // Список всех категорий
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    
    // Форма для создания новой категории
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    
    // Сохранение новой категории
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');

    // Просмотр одной категории
    // Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');

    // Форма редактирования категории
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    
    // Обновление категории
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    
    // Удаление категории
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

// Просмотр одной категории — доступно всем
Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');

use App\Http\Controllers\CommentController;

// Просмотр статьи
Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');

// Защищённые маршруты (только для авторизованных)
Route::middleware('auth')->group(function () {
    // Лайки
    Route::post('/articles/{article}/like', [ArticleController::class, 'like'])->name('articles.like');

    // Комментарии
    Route::post('/articles/{article}/comments', [CommentController::class, 'store'])->name('comments.store');

    // 🔹 Новый: редактирование комментариев
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');

    // 🔹 Новый: удаление комментариев
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});
