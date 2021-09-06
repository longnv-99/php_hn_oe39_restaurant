<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('language/{lang}', [HomeController::class, 'changeLanguage'])->name('change-language');
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.home');
    Route::get('users/enable/{user}', [UserController::class, 'enable'])->name('users.enable');
    Route::get('users/disable/{user}', [UserController::class, 'disable'])->name('users.disable');
    Route::get('reviews/hide/{review}', [ReviewController::class, 'hide'])->name('reviews.hide');
    Route::get('reviews/view/{review}', [ReviewController::class, 'view'])->name('reviews.view');
    Route::get('comments/hide/{comment}', [CommentController::class, 'hide'])->name('comments.hide');
    Route::get('comments/view/{comment}', [CommentController::class, 'view'])->name('comments.view');
    Route::resource('books', BookController::class);
    Route::resource('users', UserController::class);
});
Route::group(['middleware' => 'auth'], function () {
    Route::get('users/home', [UserController::class, 'home'])->name('users.home');
    Route::get('books/searchByTitle', [BookController::class, 'searchByTitle'])->name('books.search-title');
    Route::get('books/searchByCategory/{category}', [BookController::class, 'searchByCategory'])
        ->name('books.search-category');
    Route::resource('comments', CommentController::class)->only([
        'destroy', 'update', 'store'
    ]);
    Route::resource('reviews', ReviewController::class)->only([
        'destroy', 'update', 'store'
    ]);
    Route::get('profile', [UserController::class, 'myProfile'])->name('my-profile');
    Route::get('profile/{id}', [UserController::class, 'getUserProfile'])->name('profile');
});
