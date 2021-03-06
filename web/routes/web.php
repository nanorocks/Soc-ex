<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailVerifyController;

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

Route::get('/', function () {
    return redirect('login');
})->name('index');

Route::get('/register', [RegisterController::class, 'index'])->name('register');

Route::get('/login', [LoginController::class, 'login'])->name('login');

Route::get('/email/verify', [EmailVerifyController::class, 'verificationNotice'])->middleware(['auth'])->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [EmailVerifyController::class, 'verificationVerify'])->middleware(['signed'])->name('verification.verify');

Route::get('/email/verification-notification', [EmailVerifyController::class, 'verificationBeforeSend'])->name('verification.before.send');


Route::group(['middleware' => ['web']], function () {

    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.user');

    Route::post('/register', [RegisterController::class, 'registerUser'])->name('register.user');

    Route::group(['middleware' => ['auth']], function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/my/posts', [DashboardController::class, 'authUserPosts'])->name('my.posts');

        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

        Route::post('post/create', [DashboardController::class, 'createPost'])->name('post.create');

        Route::post('ajax/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');

        Route::post('ajax/profile/change/password', [ProfileController::class, 'changePassword'])->name('profile.change.password');

        Route::post('ajax/like', [DashboardController::class, 'toggleLike'])->name('toggle.like');

        Route::post('ajax/post/delete', [DashboardController::class, 'deletePost'])->name('post.delete');

        Route::post('ajax/post/edit', [DashboardController::class, 'editPost'])->name('post.edit');

    });

});
