<?php

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

Route::group(['prefix' => 'auth'], function () {
	Route::get('install', 'AppsController@installApp')->name('apps.installApp');
    Route::post('installHandle', 'AppsController@installAppHandle')->name('apps.installHandle');
    Route::get('auth', 'AppsController@auth')->name('apps.auth');
    Route::get('404', 'AppsController@errors')->name('errors.404');
    Route::get('logout','AppsController@logout')->name('apps.logout');
});

Route::get('/', function () {
    return view('welcome');
});
