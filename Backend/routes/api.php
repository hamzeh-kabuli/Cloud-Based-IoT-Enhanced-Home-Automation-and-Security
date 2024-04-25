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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('app/auth/login', 'AuthController@login');

Route::group([
	'prefix' => 'app',
	// 'middleware' => 'auth:api',
],function(){
	Route::put('auth/change-password', 'AuthController@password');
	Route::post('auth/logout', 'AuthController@logout');
    Route::post('auth/refresh', 'AuthController@refresh');
    Route::get('auth/user', 'AuthController@me');
	
	
	Route::get('current-state', 'StateController@index');
	
	Route::get('log/state', 'LogController@state');
	Route::get('log/fan', 'LogController@fan');
	Route::get('log/light', 'LogController@light');
	Route::get('log/buzzer', 'LogController@buzzer');

	Route::post('switch', 'SwitchController@store');
});


Route::group([
	'prefix' => 'raspberry',
	// 'middleware' => 'auth:api',
],function(){
	
	Route::post('record', 'RaspberryController@store');

	Route::get('switch', 'RaspberryController@switch');
});