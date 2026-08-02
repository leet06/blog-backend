<?php

use App\Http\Controllers\Api\LoginController;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\IndexPostController;
use App\Http\Controllers\Api\MyPostController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/posts', [IndexPostController::class, 'index']);

Route::middleware('auth:sanctum')->group(function ()
{
    Route::post('/posts', [PostController::class, 'store']);
    Route::get('/posts/my', [MyPostController::class, 'index']);
});
