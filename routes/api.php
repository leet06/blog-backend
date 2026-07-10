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

Route::post('/login', LoginController::class);
Route::post('/register', RegisterController::class);
Route::get('/posts', IndexPostController::class);

Route::middleware('auth:sanctum')->group(function ()
{
    Route::post('/posts', PostController::class);
    Route::get('/posts/my', MyPostController::class);
});
