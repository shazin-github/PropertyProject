 <?php
Route::get('/', function () {
    return view('index');
});

Route::group(['prefix' => 'v1'], function(){

	//User Api Route
	Route::post('user', "UsersController@addUser"); //for insert
	Route::put('user', "UsersController@updateUser"); //for update
	//Route::get('user', "UsersController@showUser"); //for select

	Route::post('user/userAuthenticate' , "UsersController@userAuthenticate");
	Route::get('user/checkemail',"UsersController@checkemail");

	Route::get('user/checkusername',"UsersController@checkusername");



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



	// Seller Api Route
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

	Route::post('property', "PropertyController@addproperty");//add
	Route::put('property/by-id' , "PropertyController@updatebyID");//update by id
	//update location
	Route::get('property/SearchById',"PropertyController@SearchByID");//search by id
	Route::get('property/SearchByStreet',"PropertyController@SearchByStreet");//search by street
	Route::get('property/SearchWithPrice',"PropertyController@SearchWithPrice");//search between two price

	Route::get('property/SearchWithMaxPrice' , "PropertyController@SearchWithMaxPrice");
	Route::get('property/SearchWithMinPrice' , "PropertyController@SearchWithMinPrice");

	//search by utility
	Route::get('property/SearchWithPropertyPurpose',"PropertyController@SearchWithPropertyPurpose");//search by purpose
	Route::get('property/SearchWithPropertyType',"PropertyController@SearchWithPropertyType");//search by type
	Route::get('property/SearchWithPropertycategory',"PropertyController@SearchWithPropertyCategory");//search by category
	Route::delete('property',"PropertyController@HideProperty");   //delete or disabled by changing status
	Route::get('property/SearchWithSatatus',"PropertyController@SearchWithStatus");//search by status
	Route::get('property/SearchLike' , "PropertyController@SearchLike");//Group Search



});

