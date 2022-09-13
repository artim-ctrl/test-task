<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VideoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Email\EmailNeedVerifyController;
use App\Http\Controllers\Email\EmailVerifyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', LoginController::class)->name('login');

Route::get('/email/verify/{id}/{hash}', EmailVerifyController::class)
    ->middleware('auth:sanctum')->name('verification.verify');

Route::get('/email/verify', EmailNeedVerifyController::class)
    ->middleware('auth:sanctum')->name('verification.notice');

Route::apiResource('articles', ArticleController::class, [
    'except' => ['create', 'edit'],
])->middleware('auth:sanctum');

Route::apiResource('comments', CommentController::class, [
    'except' => ['create', 'edit'],
])->middleware('auth:sanctum');

Route::apiResource('videos', VideoController::class, [
    'except' => ['create', 'edit'],
])->middleware('auth:sanctum');

Route::apiResource('users', UserController::class, [
    'except' => ['create', 'edit'],
])->middleware(['auth:sanctum', 'admin']);
