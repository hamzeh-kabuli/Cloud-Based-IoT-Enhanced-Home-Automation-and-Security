<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	return json_encode([
		'organization' => 'London Metropolitan University',
		'subject' => 'IoT & CC',
		'description' => 'API for IoT & CC coursework',
		'developed_by' => 'Samir Rahimy'
	]);
    return view('welcome');
});

Route::get('/upload', function(){
	return view('upload');
});

Route::post('raspberry/save', 'RaspberryController@save')->name('upload.video');
