<?php
Route::get('/', function () {
    return view('index');
});

Route::group(['prefix' => 'v1'], function(){
	
	Route::post('user', "UsersController@addUser"); //for insert
	Route::put('user', "UsersController@updateUser"); //for update
	Route::get('user', "UsersController@showUser"); //for select
});

