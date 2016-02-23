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
	Route::put('Feature/bypropertyid' , "FeaturesController@updateFeaturebyproperty_Id" );   // for update
	Route::put('Feature/byId' , "FeaturesController@updateFeaturebyId" );   // for update
	Route::get('Feature/Property' , "FeaturesController@ShowFeaturebyProperty_Id" );   // for select
	Route::get('Feature' , "FeaturesController@ShowFeaturebyId" );   // for select
	Route::get('Feature/showBybedrooms', "FeaturesController@ShowByNumberOfBedrooms");//search by number of bedrooms
	Route::get('Feature/showBybathrooms', "FeaturesController@ShowByNumberOfBathrooms");//search by number of bathrooms
	Route::get('Feature/ShowWithBathAndBedroomd' , "FeaturesController@ShowWithBathAndBedroomd");//group search



	// Buyer Api seller
	Route::post('Seller', "SellerController@addSeller"); // for insert
	Route::get('Seller' , "SellerController@ShowSellerbyId" );   // for select
	Route::get('Seller/ByProperty' , "SellerController@ShowSellerbyProperty_Id" );   // for select
	Route::get('Seller/ByUser' , "SellerController@ShowSellerbyuser_Id" );   // for select
	//search property by buyer id
	//search property by property id
	//search property by user id



	//SaleHistory Api Route

	Route::post('SaleHistory', "SaleHistoryController@addSaleHistory"); // for insert
	Route::get('SaleHistory/ById' , "SaleHistoryController@ShowByid" );   // for select
	Route::get('SaleHistory/Property_id' , "SaleHistoryController@ShowbyPropertyId" );   // for select
	Route::get('SaleHistory/Buyer-Id' , "SaleHistoryController@ShowbybuyerId" );   // for select
	Route::get('SaleHistory/seller-Id' , "SaleHistoryController@ShowSellerbysellerId" );   // for select


	//property Api Route

	//add
	//update by id
	//update location
	//search by add
	//search by street
	//search between two price
	//search by utility
	//search by purpose
	//search by type
	//search by category
	//delete or disabled by changing status
	//search by status


});

