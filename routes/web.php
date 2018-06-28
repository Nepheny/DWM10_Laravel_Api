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

Route::group(['middleware' => ['check.auth']], function () {
    // CRUD users
    Route::post('/user/find', 'UserController@getOne');
    Route::get('/users', 'UserController@getAll');
    Route::post('/user/new', 'UserController@insertOne');
    Route::post('/users/new', 'UserController@insertMany');
    Route::delete('/user', 'UserController@deleteOne');
    Route::post('/user/update/{id}', 'UserController@updateOne');
    // CRUD roles
    Route::get('/roles', 'RoleController@getAll');
    Route::post('/role/new', 'RoleController@insertOne');
    Route::delete('/role', 'RoleController@deleteOne');
    Route::post('/role/update/{id}', 'RoleController@updateOne');
});

Route::post('/login', 'LoginController@login');
Route::post('/logout', 'LoginController@logout');