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

// To get a user
Route::post('/user/get', 'UserController@getOne');

// To add a user
Route::post('/user/insert', 'UserController@insertOne');

// To delete a user
Route::post('/user/delete', 'UserController@deleteOne');

// To update a user
Route::post('/user/update', 'UserController@updateOne');

// Home page
Route::get('/', 'UserController@getAll');
