<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\PostController;
use App\Http\Controllers\Web\UserController;

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

Route::get('/', [UserController::class, 'index'])->name('Home');
Route::get('Login', [UserController::class, 'login'])->name('login');
Route::get('Register', [UserController::class, 'create'])->name('register-user');
Route::post('Login', [UserController::class, 'StoreLogin'])->name('login-store');
Route::post('Register', [UserController::class, 'store'])->name('register-user-post');
Route::get('signout', [UserController::class, 'destroy'])->name('signout');
Route::get('profile/update/{id}', [UserController::class, 'profile_edit'])->name('profile.edit')->middleware('auth');
Route::post('profile/update', [UserController::class, 'update'])->name('profile.update')->middleware('auth');
Route::get('profile/{user}/{name}', [UserController::class, 'show'])->name('profile.user');
Route::get('search', [UserController::class, 'search'])->name('search.user');


/////////////////////////////////////////////////post routes //////////////////////////////

Route::middleware('auth')->group(function () {
    Route::post('delete-post/{id}', [PostController::class, 'delete'])->name('delete.post');
    Route::post('create-post', [PostController::class, 'store'])->name('create-post');
    Route::post('like', [PostController::class, 'like'])->name('like');
    Route::post('/follow/{id}',[UserController::class, 'follow'])->name('follow');

});

