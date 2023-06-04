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

Route::prefix('/user')->namespace('App\Http\Controllers\Api')->group(function(){

Route::resource('favorites', FavoriteController::class);
Route::resource('usersbookings', OrderController::class);
Route::resource('usersreviews', UserReviewController::class);
Route::resource('buyermail',SupportController::class);



});