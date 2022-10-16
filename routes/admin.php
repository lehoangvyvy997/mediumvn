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
    return response()->json(['message' => 'admin'], 200);
});

Route::post('login', 'AuthController@login')->name('admin.login');
Route::post('signup', 'AuthController@signup')->name('admin.signup');

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('logout', 'AuthController@logout')->name('admin.logout');
    Route::get('user', 'AuthController@user')->name('admin.user.infor');
});
