<?php

	namespace App\Http\Controllers;

	use Illuminate\Http\Request; 

	use App\Http\Requests;
	use App\Http\Controllers\Controller;
	use App\Api\Colors\Colors;
	use App\Api\Response\Response;
	use App\Http\Middleware\filter_broker_key;
	use \Validator;
	class ColorsController extends Controller
	{
		/**
		 * Colors class instance
		 * @var Object
		 */
		protected $colors;
		/**
		 * Response class instance
		 * @var Object
		 */
		protected $response;
		/**
		 * Request class instance
		 * @var Object
		 */
		protected $request;
		/**
		 * User Details[Broker-Key and User ID]
		 * @var array
		 */
		protected $details;
		
		/**
		 * @param Colors
		 * @param Response
		 * @param Request
		 * @param filter_broker_key
		 */
		
		public function __construct(Colors $colors, Response $response, Request $request, filter_broker_key $broker){
			$this->colors = $colors;
			$this->response = $response;
			$this->request = $request;
			$this->broker = $broker;
			$this->details = $broker->get();

		}
		/**
		 * Get Request to /v1/colors/event to get Event color based on User Token
		 * @return Response
		 */
		public function event_color(){
			$response = $this->colors->get_event_color($this->details['user_id']);
			if($response){
				return $this->response->success($response);
			}else{
				return $this->response->not_found("No Event Color Found.");
			}
			
		}
		/**
		 * Get Listings Color based on User ID 
		 * @return [type]
		 */
		public function listing_color(){
			$response = $this->colors->get_listing_color($this->details['user_id']);
			if($response){
				return $this->response->success($response);
			}else{
				return $this->response->not_found("No Listing Color Found.");
			}
			
		}
		/**
		 * Returns listing color on the basis of provided Event ID via POST HTTP Request
		 * @return Response  Returns HTTP Reponse object
		 */
		public function listing_color_by_event(){
			$validator = Validator::make($this->request->all(),[
	    		'event_id' => 'required',
			]);
			if ($validator->fails()) {
				return $this->response->bad_request($validator->errors()->all());
			}
			$data = $this->request->all();
			$data['user_id'] = $this->details['user_id'];
			$response = $this->colors->listing_color_by_event($data);
			if($response){
				return $this->response->success($response);
			}else{
				return $this->response->not_found("Event Color Found.");
			}
			
		}

		public function post_event_color(){
			$validator = Validator::make($this->request->all(),[
	    		'event_id' => 'required',
	    		'color_code' => 'required',
	    		'num_of_days' => 'required|string',
	    		'end_date' => 'required',
	    		'event_date' => 'required',
			]);
			if ($validator->fails()) {
				return $this->response->bad_request($validator->errors()->all());
			}
			$colors_data = $this->request->all();
			$colors_data['user_id'] = $this->details['user_id'];
			$response = $this->colors->post_event_color($colors_data);
			if($response == 'updated'){
				return $this->response->success(['Pricing Mode updated!']);
			}elseif($response == 403){
				return $this->response->success(["Already Updated"]);
			}elseif($response == 'applied'){
				return $this->response->success(['Pricing Mode Applied!']);
			}elseif($response == 404){
				return $this->response->not_found(["Some thing went wrong try again"]);
			}else{
				return $this->response->not_found(["Some thing went wrong try again"]);
			}
		}

		public function post_listing_color(){
			$validator = Validator::make($this->request->all(),[
	    		'event_id' => 'required',
	    		'color_code' => 'required',
	    		'listing_id' => 'required',
			]);
			if ($validator->fails()) {
				return $this->response->bad_request($validator->errors()->all());
			}
			$data = $this->request->all();
			
			$data['user_id'] = $this->details['user_id'];
			$response = $this->colors->post_listing_color($data);
			if($response == 'updated'){
				return $this->response->success([sprintf('Pricing mode Updated on listing %s', $data['listing_id'])]);
			}elseif($response == 403){
				return $this->response->success("Already Updated");
			}elseif($response == 'applied'){
				return $this->response->success([sprintf('Pricing mode Appied on listing %s', $data['listing_id'])]);
			}elseif($response == 404){
				return $this->response->not_found(["Some thing went wrong, try again"]);
			}else{
				return $this->response->not_found(["Some thing went wrong, try again"]);
			}
		}

		public function put_event_color(){
			$validator = Validator::make($this->request->all(),[
	    		'event_id' => 'required',
	    		'color_code' => 'required',
			]);
			if ($validator->fails()) {
				return $this->response->bad_request($validator->errors()->all());
			}
			$data = $this->request->all();
			$data['user_id'] = $this->details['user_id'];

			$result = $this->colors->put_event_color($data);
			if($result == 404){
				return $this->response->not_found(['Event not found']);
			}elseif($result){
				return $this->response->success(['Pricing mode on Event Updated']);
			}else{
				return $this->response->success(['Pricing mode on Event already updated']);
			}
		}
		public function put_listing_color(){
			$validator = Validator::make($this->request->all(),[
	    		'event_id' => 'required',
	    		'listing_id' => 'required',
	    		'color_code' => 'required',
			]);
			if ($validator->fails()) {
				return $this->response->bad_request($validator->errors()->all());
			}
			$data = $this->request->all();

			$data['user_id'] = $this->details['user_id'];

			$result = $this->colors->put_listing_color($data);
			if($result == 404){
				return $this->response->not_found(['Listing not found']);
			}elseif($result){
				return $this->response->success(['Pricing mode on Listing Updated']);
			}else{
				return $this->response->success(['Pricing mode on Listing already updated']);
			}
		}

		public function delete_event_color(){
			$validator = Validator::make($this->request->all(),[
	    		'event_id' => 'required',
			]);
			if ($validator->fails()) {
				return $this->response->bad_request($validator->errors()->all());
			}
			$data = $this->request->all();
			$data['user_id'] = $this->details['user_id'];

			$result = $this->colors->delete_event_color($data);
			if($result){
				return $this->response->success(['Pricing mode on Event Removed']);
			}else{
				return $this->response->not_found('Event Color not found');
			}
		}

		public function delete_listing_color(){
			$validator = Validator::make($this->request->all(),[
	    		'listing_id' => 'required',
			]);
			if ($validator->fails()) {
				return $this->response->bad_request($validator->errors()->all());
			}
			$data = $this->request->all();
			
			$data['user_id'] = $this->details['user_id'];

			$result = $this->colors->delete_listing_color($data);
			if($result){
				return $this->response->success(['Pricing mode on Listing Removed']);
			}else{
				return $this->response->not_found(['Listing Color not found']);
			}
		}

	}