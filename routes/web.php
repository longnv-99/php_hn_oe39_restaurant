<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\LikeController;
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
Route::get('language/{lang}', [HomeController::class, 'changeLanguage'])->name('change-language');
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.home');
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('users/enable/{user}', [UserController::class, 'enable'])->name('users.enable');
    Route::get('users/disable/{user}', [UserController::class, 'disable'])->name('users.disable');
    Route::get('reviews/hide/{review}', [ReviewController::class, 'hide'])->name('reviews.hide');
    Route::get('reviews/view/{review}', [ReviewController::class, 'view'])->name('reviews.view');
    Route::get('comments/hide/{comment}', [CommentController::class, 'hide'])->name('comments.hide');
    Route::get('comments/view/{comment}', [CommentController::class, 'view'])->name('comments.view');
    Route::resource('books', BookController::class);
});
Route::group(['middleware' => 'auth'], function () {
    Route::resource('comments', CommentController::class)->only([
        'destroy', 'update', 'store'
    ]);
    Route::resource('reviews', ReviewController::class)->only([
        'destroy', 'update', 'store'
    ]);
    Route::resource('follows', FollowController::class)->only([
        'destroy', 'store'
    ]);

    Route::resource('likes', LikeController::class)->only([
        'store', 'destroy'
    ]);
    Route::resource('favorites', FavoriteController::class)->only([
        'index', 'store', 'destroy'
    ]);

    Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
    
    Route::get('reviews/rate/{review}', [ReviewController::class, 'rate'])->name('reviews.rate');
});

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('books/searchByTitle', [BookController::class, 'searchByTitle'])->name('books.search-title');
Route::get('books/searchByCategory/{category}', [BookController::class, 'searchByCategory'])
    ->name('books.search-category');
Route::get('book-detail/{id}', [BookController::class, 'getDetail'])->name('books.detail');
