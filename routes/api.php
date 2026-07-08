<?php

use App\Http\Controllers\Api\LoginController;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Api\IndexPostController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/login', LoginController::class);
Route::post('/register', RegisterController::class);
Route::middleware('auth:sanctum')->post('/posts', PostController::class);
Route::get('/posts', IndexPostController::class);
