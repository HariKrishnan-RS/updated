<?php

use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\DraftController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post("register", [ApiController::class, "register"]);
Route::post("login", [ApiController::class, "login"]);
Route::get("login", [ApiController::class, "show"]);
Route::get("blogs", [PageController::class, "index"])->middleware('jwt.exception');

Route::group([
    "middleware" => ["auth:api","jwt.exception"]
], function(){
    Route::get("post/{id}", [PostController::class, "show"]);
    Route::post("post", [PostController::class, "store"]);
    Route::get("post", [PostController::class, "view"]);
    Route::put("post/{id}", [PostController::class, "edit"]);
    Route::delete("post/{id}", [PostController::class, "destroy"]);
    Route::patch("post/{id}", [PostController::class, "update"]);

    Route::post("post/{id}/comment", [CommentController::class, "store"]);
    Route::get("post/{id}/comment", [CommentController::class, "show"]);

    Route::post("draft", [DraftController::class, "store"]);
    Route::get("draft", [DraftController::class, "show"]);
    Route::put("draft", [DraftController::class, "edit"]);


    Route::get("profile", [ApiController::class, "profile"]);
    Route::get("refresh", [ApiController::class, "refreshToken"]);
    Route::get("logout", [ApiController::class, "logout"]);
});



