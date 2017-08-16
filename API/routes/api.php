<?php

use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
    //return $request->user();
//});

Route::post('auth_login', 'AuthController@authenticate');
Route::post('auth_email', 'AuthController@auth_email');
Route::post('users', 'UserController@store');

Route::group(['middleware' => 'jwt.auth'], function () {
	Route::get('auth_session', 'AuthController@getAuthUser');
    Route::post('auth_user', 'AuthController@auth');
    Route::post('profile', 'ArchiveController@profile');
    Route::resource('archives','ArchiveController',['only' => ['store','show','destroy']]);
});

