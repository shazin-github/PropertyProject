<?php
Route::get('/', function () {
    return view('index');
});

Route::group(['prefix' => 'v1'], function(){
	
	Route::post('user', "MainController@addUser");
	Route::put('user', "MainController@updateUser");
	// Route::get('user', "MainController@showUser");

	// Route::post('property/location', "MainController@addLocation");
	// Route::put('property/location', "MainController@updateLocation");

	// Route::post('property', "MainController@addProperty");
	// Route::put('property', "MainController@updateProperty");
	
});

