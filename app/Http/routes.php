<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::group(['middleware' => 'guest'], function() {
    Route::get('login', 'Auth\AuthController@getLogin');
    Route::post('login', 'Auth\AuthController@postLogin');
});
Route::group(['middleware' => 'auth'], function() {
    Route::get('logout', 'Auth\AuthController@getLogout');

    // Registration routes...
    Route::get('users/register', 'Auth\AuthController@getRegister');
    Route::post('users/register', 'Auth\AuthController@postRegister');
    Route::get('users/detail/{id}', 'Auth\AuthController@getDetail');
    Route::match(['get', 'post'], 'users/management', 'Auth\AuthController@getManagement');
    // Route::post('register', 'Auth\AuthController@postRegister');
});

// Route::auth();

Route::get('/home', 'HomeController@index');
