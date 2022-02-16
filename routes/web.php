<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\HomeController;

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

/*Route::get('/', function () {
    return view('welcome');
});*/

// Home
Route::get('/', [HomeController::class, 'index']);

// User
Route::get('/login', [UsersController::class, 'login'])->name('auth.login');
Route::get('/logout', [UsersController::class, 'logout'])->name('auth.logout');
Route::post('/authenticate', [UsersController::class, 'authenticate'])->name('auth.authenticate');

// Blog
Route::resource('blog', ArticlesController::class);
Route::get('/detail/{blog_id}', [HomeController::class, 'detail'])->name('home.detail');
