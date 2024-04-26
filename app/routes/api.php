<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\Posttag;
use App\Http\Controllers\API\PassportController;
use App\Http\Controllers\UserController;

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
Route::group(['namespace' => 'API'], function () {
	Route::post('register', [PassportController::class, 'register']);
	Route::post('login', [PassportController::class, 'login']);
});

Route::group(['middleware'=>'auth:api'],function(){
	Route::post('auth', [PassportController::class,'getDetails']);
});

Route::resource('posts', PostController::class);

Route::resource('users', UserController::class);

