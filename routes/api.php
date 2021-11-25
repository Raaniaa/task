<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdsController;
use App\Http\Controllers\CommentController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/signUp',[UserController::class, 'signUp']);
Route::post('/login',[UserController::class, 'login']);
Route::post('/location',[UserController::class, 'location']);
Route::post('/uploadImage',[AdsController::class, 'upload']);
Route::post('/ads',[AdsController::class, 'store']);
Route::get('/ads',[AdsController::class, 'show']);
Route::post('/comment',[CommentController::class, 'store']);
Route::get('/comment',[CommentController::class, 'show']);