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
Route::get('test', function() {
    return response()->json(['message' => 'client'], 200);
});

Route::post('login', 'AuthController@login')->name('client.login');
Route::post('signup', 'AuthController@signup')->name('client.signup');

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('logout', 'AuthController@logout')->name('client.logout');
    Route::get('user', 'AuthController@user')->name('client.user.info');
});