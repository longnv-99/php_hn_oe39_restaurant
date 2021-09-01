<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
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
    Route::resource('books', BookController::class);
});
Route::group(['middleware' => 'auth'], function () {
    Route::resource('comments', CommentController::class)->only([
        'destroy', 'update', 'store'
    ]);
    Route::resource('reviews', ReviewController::class)->only([
        'destroy', 'update', 'store'
    ]);
});
