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


Route::get('/', function () {
    return view('welcome');
});

// rutas oficiales
//rutas para crear usuario (clave)
Route::post('api/register','UserController@Register');
Route::post('api/login','UserController@login');
Route::put('api/user/update','UserController@update');
//rutas para tags
Route::resource('/api/Tag', 'TagController');
//rutas para message
Route::resource('/api/Message', 'MessageController');

