<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\DraftController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use \App\Http\Middleware\RedirectIfNotAuthenticated;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\postController;
use \App\Http\Controllers\IndexController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/test.page', function () {
    return view('test');
})->name('test.page');



Route::get('blogs',[IndexController::class,'index'])->name('blog.page');
Route::post('blogs', [LogoutController::class,'update'])->name('logout.user');

Route::get('blogs/post',[postController::class,'show'])->name('add.page');
Route::put('blogs/post',[postController::class,'create'])->name('store.post');

Route::get('blog/{id}/read', [postController::class, 'show'])->name('read.page')->middleware(RedirectIfNotAuthenticated::class);
Route::post('blog/{id}/read', [postController::class, 'update'])->name('read.page');
Route::delete('blog/{id}/read', [postController::class, 'delete'])->name('read.page');



Route::get('login', [LoginController::class,'show'])->name('login.page');
Route::post('login', [LoginController::class,'update']);

Route::get('register', [RegisterController::class,'show'])->name('register.page');
Route::post('register', [RegisterController::class,'store'])->name('register.submit');

Route::get('blogs/draft/{id}',[DraftController::class,'show'])->name('draft.page');
Route::post('blogs/draft/{id}',[DraftController::class,'update'])->name('draft.post');

Route::post('/editPost/{id}',[postController::class,'editPost'])->name('edit.post');

Route::get('pending}',[PageController::class,'pendingPage'])->name('pending.page');
Route::get('editPage/{id}',[PageController::class,'editPage'])->name('edit.page');
Route::get('/api/posts', [postController::class,'index']);

