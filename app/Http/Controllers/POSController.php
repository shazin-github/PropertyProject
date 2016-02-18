<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Api\POS\POS;
use App\Http\Middleware\filter_broker_key;
use App\Api\Response\Response;
use \Validator;
class POSController extends Controller
{
	/**
	 * POS business logic's object
	 * @var Object
	 */
	
    protected $pos;
    
    /**
	 * HTTP Request object
	 * @var Object
	 */
    
    protected $request;
    
    /**
	 * HTTP Response object
	 * @var Object
	 */
    
    protected $response;
    
    /**
     * @param POS
     * @param Request
     * @param Response
     */
    
    public function __construct(POS $pos, Request $request, Response $response){
    	$this->pos = $pos;
    	$this->request = $request;
    	$this->response = $response;
    }
    
    /**
     * Set Listing Sold Status
     * @return HTTP Response Object
     */
    
    public function sold_status(){
    	//validate
    	$validator = Validator::make($this->request->all(),[
    		'listing_ids' => 'required|array',
    		'status' => 'required|string',
		]);
		if ($validator->fails()) {
			return $this->response->bad_request($validator->errors()->all());
		}
    	$request_data = $this->request->all();
		$response = $this->pos->set_sold_status($request_data['listing_ids'], ['sold_status' => $request_data['status']]);

		if($response){
			return $this->response->success("Sold Status set to $request_data[status]");
		}else{
			return $this->response->success(['Already Updted']);
		}
    }

    /**
     * Get Listing Sold Status
     * @return HTTP Response Object
     */
    
    public function get_sold_status(){
    	$validator = Validator::make($this->request->all(),[
    		'listing_ids' => 'required|array'
		]);
		if ($validator->fails()) {
			return $this->response->bad_request($validator->errors()->all());
		}
    	$request_data = $this->request->all();
		$response = $this->pos->get_sold_status($request_data['listing_ids']);

		if($response){
			return $this->response->success($response);
		}else{
			return $this->response->not_found(['No Listing found with this listing id']);
		}
    }

    /**
     * Set Listing Active Status
     * @return HTTP Response Object
     */
    
     public function active_status(){
     	$validator = Validator::make($this->request->all(),[
    		'listing_ids' => 'required|array',
    		'status' => 'required|string'
		]);
		if ($validator->fails()) {
			return $this->response->bad_request($validator->errors()->all());
		}
    	$request_data = $this->request->all();
		$response = $this->pos->set_active_status($request_data['listing_ids'], ['active' => $request_data['status']]);

		if($response){
			return $this->response->success("Active Status set to $request_data[status]");
		}else{
			return $this->response->success(['Already Updted']);
		}
    }

    /**
     * Get Listing Active Status
     * @return HTTP Response Object
     */
    
    public function get_active_status(){
    	$validator = Validator::make($this->request->all(),[
    		'listing_ids' => 'required|array'
		]);
		if ($validator->fails()) {
			return $this->response->bad_request($validator->errors()->all());
		}
    	$request_data = $this->request->all();
		
		$response = $this->pos->get_active_status($request_data['listing_ids']);

		if($response){
			return $this->response->success($response);
		}else{
			return $this->response->not_found(['No Listing found with this listing id']);
		}
    }

    /**
     * Set Listing Price Sync Status
     * @return HTTP Response Object
     */
    
    public function sync_status(){
    	$validator = Validator::make($this->request->all(),[
    		'listing_ids' => 'required|array',
    		'status' => 'required|string'
		]);
		if ($validator->fails()) {
			return $this->response->bad_request($validator->errors()->all());
		}
    	$request_data = $this->request->all();
		
		$response = $this->pos->set_sync_status($request_data['listing_ids'], ['price_sync_status' => $request_data['status']]);

		if($response){
			return $this->response->success("Price Sync Status set to $request_data[status]");
		}else{
			return $this->response->success(['Already Updted']);
		}
    }

    /**
     * Get Listing Price Sync Status
     * @return HTTP Response Object
     */
    
    public function get_sync_status(){
    	$validator = Validator::make($this->request->all(),[
    		'listing_ids' => 'required|array'
		]);
		if ($validator->fails()) {
			return $this->response->bad_request($validator->errors()->all());
		}
    	$request_data = $this->request->all();
		$response = $this->pos->get_sync_status($request_data['listing_ids']);

		if($response){
			return $this->response->success($response);
		}else{
			return $this->response->not_found(['No Listing found with this listing id']);
		}
    }
    
}
