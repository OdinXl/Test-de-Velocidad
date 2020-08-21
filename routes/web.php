<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'UserController@index');


Route::get('/user/any_data', 'UserController@anyData')->name('user.data'); //muestra los datos del index
Route::get('/user/{id}/change_status', 'UserController@changeStatus')->name('user.change_status'); //elimina o activa el registro