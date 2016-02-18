<?php
Route::get('/', function () {
    return view('index');
});
	Route::group(['prefix' => 'v1'], function(){

		//POS Routes
		Route::post('pos/sold_status', "POSController@get_sold_status");
		Route::put('pos/sold_status', "POSController@sold_status");
		Route::post('pos/active_status', "POSController@get_active_status");
		Route::put('pos/active_status', "POSController@active_status");
		Route::post('pos/sync_status', "POSController@get_sync_status");
		Route::put('pos/sync_status', "POSController@sync_status");
	});
	
	
	Route::group(['prefix' => 'v1', 'middleware' => 'broker_key'], function () {
		Route::post('user/add', 'UsersController@add_user');
		Route::get('products', 'UsersController@get_products');

		Route::get('groups/auto/group', 'AutoGroupsController@get_group_data');
		Route::get('groups/auto/criteria', 'AutoGroupsController@get_group_criteria');
		Route::put('groups/auto', 'AutoGroupsController@update');
		Route::put('groups/auto/name', 'AutoGroupsController@update_group_name');
		Route::post('groups/auto/add_listing', 'AutoGroupsController@insert_listing');
		Route::delete('groups/auto', "AutoGroupsController@delete");
		Route::delete('groups/auto/listing', "AutoGroupsController@delete_listing");
		Route::resource('groups/auto', 'AutoGroupsController');


	    //Manual Groups Routes

	    Route::post('groups/manual', 'ManualGroupsController@save');
	    Route::get('groups/manual', 'ManualGroupsController@get_user_groups');
	    Route::put('groups/manual', 'ManualGroupsController@edit');
	    Route::get('groups/manual/group', 'ManualGroupsController@get_group_data');
		Route::get('groups/manual/criteria', 'ManualGroupsController@get_group_criteria');
		Route::put('groups/manual/name', 'ManualGroupsController@update_group_name');
		Route::post('groups/manual/add_listing', 'ManualGroupsController@insert_listing');
		Route::delete('groups/manual/delete', "ManualGroupsController@delete");
		Route::delete('groups/manual/listing', "ManualGroupsController@delete_listing");

		//Seasons Routes
		Route::get('groups/', "GroupsController@index");
		Route::get("groups/seasons", "GroupsController@get_season");
		Route::post("groups/seasons", "GroupsController@create_season");
		Route::delete("groups/seasons", "GroupsController@delete_season");

		

		//Notifications
		Route::post('notify/slack', "NotificationsController@push_to_slack");
		Route::post('notify/email', "NotificationsController@push_email");
		/*
	     *
	     * Notes Route
	     *
        */
		Route::get('notes/event', 'NotesController@event_notes');
		Route::get('notes/event/user', 'NotesController@event_notes_aggregate');
		Route::post('notes/event/add', 'NotesController@add_event_notes');
		Route::delete('notes/event/delete', 'NotesController@delete_event_notes');
		Route::put('notes/event/update', 'NotesController@update_event_notes');

		/*
	     *
	     * PriceSettings Route
	     *
	    */
		Route::get('exchange/{id}/sellerfee', 'PriceSettingsController@price_settings_by_event');
		Route::post('exchange/{id}/sellerfee/add', 'PriceSettingsController@add_price_settings');
		Route::put('exchange/{id}/sellerfee/update', 'PriceSettingsController@update_price_settings');
		Route::delete('exchange/{id}/sellerfee/delete', 'PriceSettingsController@delete_price_settings');

		/*
	     *
	     * CronTrackers Route
	     *
	    */
		Route::post('crontracker', 'CronTrackerController@crontracker');
		Route::get('crontracker', 'CronTrackerController@get_all_crontracker');
		Route::get('crontracker/user', 'CronTrackerController@get_user_crontracker');
		/*
	     *
	     * ExchangeMapping Route
	     *
	    */
		Route::post('exchange/{id}/event/add', 'ExchangeMappingController@save_exchange_event');
		Route::put('exchange/{id}/event/update_id', 'ExchangeMappingController@update_exchange_event_id');
		Route::put('exchange/{id}/event/update_status', 'ExchangeMappingController@update_exchange_event_status');
		Route::get('exchange/{id}/events', 'ExchangeMappingController@get_exchange_event');
		Route::get('exchange/{id}/mapped', 'ExchangeMappingController@get_exchange_event_by_status');
		Route::get('exchange/{id}/not_mapped', 'ExchangeMappingController@get_exchange_event_by_status');

		/*
	     *
	     * Stats Route
	     *
	    */
		Route::get('stat/user', 'StatsController@user_stats');
		Route::get('stat/floor', 'StatsController@floor_stats');
		Route::get('stat/sold', 'StatsController@sold_stats');
		Route::get('stat/active', 'StatsController@active_stats');
		Route::get('stat/unsync', 'StatsController@unsync_stats');
		Route::get('stat/compare', 'StatsController@compare_stats');

		/*
	     *
	     * Download Route
	     *
	    */
		Route::get('download/data', 'DownloadController@get_data');
		Route::get('download/dataV3', 'DownloadController@get_dataV3');
		Route::get('download/dataV1', 'DownloadController@get_data1');
		Route::get('download/autopricer', 'DownloadController@get_autopricer');
		Route::get('download/autopricertt', 'DownloadController@get_autopricertt');
		Route::get('download/pricegeniustt', 'DownloadController@get_pricegeniustt');

		 /**
		  * Plans Routes
		  */
		 
		Route::get('users', 'UsersController@get_all_users');
		Route::get('user/info', 'UsersController@get_user_info');
		Route::get('plans', 'UsersController@get_all_plans');
		Route::put('user/update/plan', 'UsersController@update_plan');
		Route::post('user/add/seller_id', 'UsersController@add_seller_id');
		Route::put('user/update/seller_id', 'UsersController@update_seller_id');
		Route::put('user/update/password', 'UsersController@update_password');
		Route::put('user/update/productname', 'UsersController@update_productname');
		Route::put('user/update/version', 'UsersController@update_version');
		Route::put('user/update/version_bit', 'UsersController@update_version_bit');
		Route::get('products', 'UsersController@get_products');
		Route::get('versions', 'UsersController@get_versions');
		Route::post('user/add', 'UsersController@add_user');

		 //Criteria Routes
		
	    Route::post('criteria/save', 'CriteriasController@save');
	    Route::post('criteria/saving_mass_operation', 'CriteriasController@saving_mass_operation');
	    Route::post('criteria/movefloor', 'CriteriasController@getting_moveFloor');
	    Route::get('criteria/getting_criteria', 'CriteriasController@getting_criteria');
	    Route::put('criteria/update', 'CriteriasController@edit');
	    Route::delete('criteria/delete_criteria', 'CriteriasController@delete_criteria');

	    //Color Routes
        Route::get('colors/event', 'ColorsController@event_color');
        Route::get('colors/listing', 'ColorsController@listing_color');
        Route::get('colors/listing_by_event', 'ColorsController@listing_color_by_event');
        //Create OR Update colors
        Route::post('colors/event', 'ColorsController@post_event_color');
        Route::post('colors/listing', 'ColorsController@post_listing_color');
        //Update Color
        Route::put('colors/event', 'ColorsController@put_event_color');
        Route::put('colors/listing', 'ColorsController@put_listing_color');
        //Delete Colors
        Route::delete('colors/event', 'ColorsController@delete_event_color');
        Route::delete('colors/listing', 'ColorsController@delete_listing_color');

        Route::get('config/global', 'ConfigController@get_global');
		Route::get('config/global/download', 'ConfigController@get_global_downloads');
		Route::post('config/global/add', 'ConfigController@save_global');

		Route::get('config/userglobal', 'ConfigController@get_userglobal');
		Route::post('config/userglobal/add', 'ConfigController@save_userglobal');

		Route::get('config/pos', 'ConfigController@get_pos_by_ip');
		Route::get('config/pos/tu', 'ConfigController@get_pos_tu');
		Route::get('config/pos/seller', 'ConfigController@get_pos_seller');
		Route::post('config/pos/add', 'ConfigController@save_pos');
		Route::put('config/pos/append/userid', 'ConfigController@append_pos_userid');
		Route::put('config/pos/update/userids', 'ConfigController@update_pos_userids');
		Route::put('config/pos/update/status', 'ConfigController@update_pos_script_status');
		/*
	      *
	      * SellerFee Route
	      *
	     */
		Route::get('exchange/{id}/sellerfee', 'SellerFeeController@sellerfee_by_event');
		Route::post('exchange/{id}/sellerfee/add', 'SellerFeeController@add_sellerfee');
		Route::put('exchange/{id}/sellerfee/update', 'SellerFeeController@update_sellerfee');
		Route::delete('exchange/{id}/sellerfee/delete', 'SellerFeeController@delete_sellerfee');

		/*
		 *
		 * Profiles Route
		 *
		 */

		Route::get('profile/venue', 'ProfilesController@get_profile_by_venue');
		Route::get('profile/type', 'ProfilesController@get_profile_types');
		Route::post('profile/create', 'ProfilesController@create_profile');
		Route::post('profile/duplicate', 'ProfilesController@duplicate_profile');
		Route::put('profile/update', 'ProfilesController@update_profile');
		Route::delete('profile/delete', 'ProfilesController@delete_profile');
		Route::put('profile/update/listing_criteria', 'ProfilesController@update_listings_criteria');

	});
	
	//admin panel group
	Route::group(['middleware'=>['web']], function(){
		Route::controller('adminpanel', 'AdminPanelController');
	});
	//admin panel login group
	Route::group(['middleware' => 'web'], function () {
		Route::get('adminpanel', array('as'=>'getadminpanel','uses'=>'AdminPanelController@Index'));
	Route::post('adminpanel', array('uses'=>'AdminPanelController@Login'));
	});