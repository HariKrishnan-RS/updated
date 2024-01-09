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


// Api web routes

Route::get('blogs',[IndexController::class,'index'])->name('blog.index');

Route::get('blogs/post',[postController::class,'show'])->name('post.create');

Route::get('draft',[DraftController::class,'show']) ->name('draft.show');

Route::get('pending',[PageController::class,'show'])->name('pending.show') ;

Route::get('blog/read', [postController::class, 'read'])->name('post.show');

Route::get('post/edit',[postController::class,'editPage'])->name('editPost.show');




Route::get('/',[postController::class,'show'])->name('addpost.show');
Route::put('/',[postController::class,'create'])->name('post.create');

Route::get('blog/{id}/read', [postController::class, 'show'])->name('post.show')->middleware(RedirectIfNotAuthenticated::class);
Route::post('blog/{id}/read', [postController::class, 'update'])->name('post.update');
Route::delete('blog/{id}/read', [postController::class, 'delete'])->name('post.delete');

Route::get('login', [LoginController::class,'show'])->name('login.show');
Route::post('login', [LoginController::class,'update'])->name('login.update');

Route::get('register', [RegisterController::class,'show'])->name('register.show');
Route::post('register', [RegisterController::class,'store'])->name('register.store');

Route::get('draft/{id}',[DraftController::class,'show'])->name('draft.show');
Route::post('draft/{id}',[DraftController::class,'update'])->name('draft.update');

Route::get('post/{id}/edit',[postController::class,'show'])->name('editPost.show');
Route::patch('post/{id}/edit',[postController::class,'edit'])->name('post.edit');

Route::get('posts',[PageController::class,'show'])->name('pending.show');

Route::get('/api/posts', [postController::class,'index']);







