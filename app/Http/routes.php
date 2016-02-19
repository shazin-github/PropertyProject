<?php
Route::get('/', function () {
    return view('index');
});

Route::group(['prefix' => 'v1'], function(){
	
	Route::post('user', "MainController@addUser");
	Route::put('user', "MainController@updateUser");
	// Route::get('user', "MainController@showUser");

	Route::post('location', "MainController@addLocation");
	Route::put('location', "MainController@updateLocation");

	Route::post('features', "MainController@addFeatures");
	Route::put('features', "MainController@updateFeatures");

	Route::post('property', "MainController@addProperty");
	Route::put('property', "MainController@updateProperty");

	Route::post('seller', "MainController@addSeller");
	Route::put('seller', "MainController@updateSeller");
	
});

