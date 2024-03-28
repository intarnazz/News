<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\UserController;
use App\Http\Controllers\NewsController;

Route::post('/registration', [UserController::class, 'reg']);
Route::post('/authorization', [UserController::class, 'login']);

Route::prefix('news')->group(function () {
  Route::get('/', [NewsController::class, 'get']);
});

Route::middleware('auth:sanctum')->group(function () {
  Route::post('/logout', [UserController::class, 'logout']);
  Route::prefix('news')->group(function () {
    Route::get('/unpublished', [NewsController::class, 'unpublished']);
    Route::post('/upload', [NewsController::class, 'add']);
    Route::get('/publish/{id}', [NewsController::class, 'publish']);
  });
});
