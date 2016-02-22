 <?php
Route::get('/', function () {
    return view('index');
});

Route::group(['prefix' => 'v1'], function(){

	//User Api Route
	Route::post('user', "UsersController@addUser"); //for insert
	Route::put('user', "UsersController@updateUser"); //for update
	Route::get('user', "UsersController@showUser"); //for select



	// Location Api Route
	Route::post('location', "LocationController@addLocation"); // for insert
	Route::put('location' ,"LocationController@updateLocationbyID"); // for update
	Route::get('location' , "LocationController@ShowLocationbyId" );   // for select
	Route::delete('location' , "LocationController@DisableLocaionbyId"); // change status



	// Buyer Api Route
	Route::post('Buyer', "BuyerController@addBuyer"); // for insert
	Route::get('Buyer' , "BuyerController@ShowBuyerbyId" );   // for select
	Route::get('Buyer/ByProperty' , "BuyerController@ShowBuyerbyProperty_Id" );   // for select
	Route::get('Buyer/ByUser' , "BuyerController@ShowBuyerbyuser_Id" );   // for select


	//Feature Api Route
	Route::post('Feature', "FeaturesController@addFeature"); // for insert
	Route::Put('Feature' , "FeaturesController@updateFeaturebyproperty_Id" );   // for update
	Route::put('Feature/Id' , "FeaturesController@updateFeaturebyId" );   // for update
	Route::get('Feature/Property' , "FeaturesController@ShowFeaturebyProperty_Id" );   // for select
	Route::get('Feature' , "FeaturesController@ShowFeaturebyId" );   // for select



});

