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

// To get users
Route::post('/user/find', 'UserController@getOne');
Route::get('/users', 'UserController@getAll');

// To add users
Route::post('/user/new', 'UserController@insertOne');
Route::post('/users/new', 'UserController@insertMany');

// To delete users
Route::delete('/user', 'UserController@deleteOne');
//Route::post('/user/delete', 'UserController@deleteMany');

// To update users
Route::post('/user/update/{id}', 'UserController@updateOne');

// To connect user
Route::post('/user/connect', 'UserController@connect');
