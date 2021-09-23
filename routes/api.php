<?php

use Illuminate\Http\Request;
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

// Route::middleware('auth:api')->Route::group(['prefix' => 'profile/'], function () {


route::post('login', App\Http\Controllers\Api\Auth\LoginController::class);
route::post('register', App\Http\Controllers\Api\Auth\RegisterController::class);
Route::group(['prefix' => '/', 'middleware' => 'auth:api', 'namespace' => 'App\Http\Controllers\Api'], function () {
    Route::get('user/details', UserController::class);
    Route::apiResource('posts', App\Http\Controllers\Api\PostController::class);
    Route::get('category/posts/{category}', App\Http\Controllers\Api\CategoryPostsController::class);
    Route::get('search/posts/{q}', App\Http\Controllers\Api\SearchPostsController::class);
});
