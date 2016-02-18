<?php

	namespace App\Http\Controllers;

	use Illuminate\Http\Request;

	use App\Http\Requests;
	use App\Http\Controllers\Controller;
	use App\Api\Groups\AutoGroups;
	use App\Http\Middleware\filter_broker_key;
	use App\Api\Response\Response;
	use \Validator;
	class AutoGroupsController extends Controller
	{
		/**
		 * User Details[Broker-Key and User ID]
		 * @var array
		 */
		protected $details;
		
		protected $auto_groups;
		protected $request;
		protected $response;

		/**
		 * @param AutoGroups        $auto_groups 
		 * @param Request           $request     
		 * @param filter_broker_key $broker      
		 * @param Response          $response    
		 */
		public function __construct(AutoGroups $auto_groups, Request $request, filter_broker_key $broker, Response $response){
			$this->auto_groups = $auto_groups;
			$this->request = $request;
			$this->response = $response;
			$this->details = $broker->get();
			$this->request['user_id'] = $this->details['user_id'];
			$this->request['component_id'] = 2;
			if(isset($this->request['criteria_object'])){
				$this->request['criteria_object'] = json_encode($this->request['criteria_object']);
			}
			
		}

		/**
		 * will get use groups based on broker_key(user id) and and event id 
		 * @return void
		 */
		public function index(){
			$validator = Validator::make($this->request->all(),[
	    		'exchange_event_id' => 'required',
			]);
			if ($validator->fails()) {
				return $this->response->bad_request($validator->errors()->all());
			}
			$request_data = $this->request->all();
			
			$groups = $this->auto_groups->user_groups($this->details['user_id'], $request_data['exchange_event_id']);
			if($groups){
				return $this->response->success($groups, "groups_data");
			}else{
				return $this->response->not_found(['No Group found']);
			}
		}
		/**
		 * Get group details alongwith group listings
		 * @return response object
		 */
		public function get_group_data(){
			$validator = Validator::make($this->request->all(),[
	    		'group_id' => 'required'
			]);
			if ($validator->fails()) {
				return $this->response->bad_request($validator->errors()->all());
			}
			$request_data = $this->request->all();
			$group_data = $this->auto_groups->group_data($request_data['group_id']);
			if($group_data){
				return $this->response->success($group_data, "group_data");
			}
			return $this->response->not_found(['No Group found']);
		}
		/**
		 * This function will return group criteria based on group id
		 * @return HTTP Response object
		 */
		public function get_group_criteria(){
			$validator = Validator::make($this->request->all(),[
	    		'group_id' => 'required'
			]);
			if ($validator->fails()) {
				return $this->response->bad_request($validator->errors()->all());
			}
			$request_data = $this->request->all();
			$criteria = $this->auto_groups->get_group_criteria($request_data['group_id']);
			if($criteria){
					return $this->response->success($criteria, "group_criteria");
			}
			return $this->response->not_found(['No Group found']);
		}
		/**
		 * update auto group criteria
		 * @return HTTP Response object
		 */
		public function update(){
			$validator = Validator::make($this->request->all(),[
	    		'auto_bc_rank' => 'required|string',
	    		'auto_bc' => 'required|string',
	    		'criteria_object' => 'required|string',
	    		'group_id' => 'required',
	    		'group_inc_type' => 'required',
	    		'listing_ids' => 'required|array',
			]);
			if ($validator->fails()) {
				return $this->response->bad_request($validator->errors()->all());
			}
			$request_data = $this->request->all();
			$response = $this->auto_groups->update($request_data);
			if($response){
				return $this->response->success($response);
			}else{
				return $this->response->success("Already Update");
			}
		}
		/**
		 * Update group name
		 * @return HTTP Response object
		 */
		public function update_group_name(){
			$validator = Validator::make($this->request->all(),[
	    		'group_id' => 'required',
	    		'group_name' => 'required'
			]);
			if ($validator->fails()) {
				return $this->response->bad_request($validator->errors()->all());
			}
			$request_data = $this->request->all();
			if($this->auto_groups->update_group_name($request_data['group_id'], $request_data['group_name'])){
				return $this->response->success("Group Name Updated");
			}
			return $this->response->success("Already Updated");
		}

		/**
		 * Creates new Auto Group
		 * @return HTTP Response object
		 */
		public function store(){
			$validator = Validator::make($this->request->all(),[
				'exchange_id' => 'required',
	    		'group_name' => 'required',
	    		'exchange_event_id' => 'required',
	    		'group_inc_type' => 'required|string',
	    		'tix_start' => 'required',
	    		'listing_start' => 'required',
	    		'cp_start' => 'required',
	    		'auto_bc' => 'required|string',
	    		'auto_bc_rank' => 'required|string',
	    		'push_price' => 'required',
	    		'criteria_object' => 'required',
	    		'listing_ids' => 'required|array',
	    		'local_event_id' => 'required',
				]);
			if ($validator->fails()) {
				return $this->response->bad_request($validator->errors()->all());
			}
			$request_data = $this->request->all();
			if($group_id = $this->auto_groups->create($request_data)){
				return $this->response->success(['group_id' => $group_id, 'message' => "Group created"]);
			}else{
				return $this->response->not_found(["Unable to process request."]);
			}
		}
		/**
		 * insert listing to already present group
		 * @return HTTP Response object
		 */
		public function insert_listing(){
			$validator = Validator::make($this->request->all(),[
	    		'group_id' => 'required',
	    		'listing_ids' => 'required|array',
	    		'exchange_event_id' => 'required',
	    		'local_event_id' => 'required',
	    		'exchange_id' => 'required',
			]);
			if ($validator->fails()) {
				return $this->response->bad_request($validator->errors()->all());
			}
			$request_data = $this->request->all();
			$response = $this->auto_groups->insert_listing($request_data);
			if($response == "Limit"){
				return $this->response->unauthorize("Limit Plan Exceed");
			}elseif($response){
				return $this->response->success($response);
			}else{
				return $this->response->application_error("Unable to process request.");
			}
		}

		/**
		 * delete group
		 * @return HTTP Response object
		 */
		public function delete(){$validator = Validator::make($this->request->all(),[
	    		'group_id' => 'required'
			]);
			if ($validator->fails()) {
				return $this->response->bad_request($validator->errors()->all());
			}
			$request_data = $this->request->all();
			
			$response = $this->auto_groups->delete_group($request_data['group_id']);
			return $this->response->success("Group Deleted");
		}
		/**
		 * delete listing
		 * @param  int $group_id 
		 * @return HTTP Response object
		 */
		public function delete_listing(){
			$validator = Validator::make($this->request->all(),[
	    		'group_id' => 'required',
	    		'listing_id' => 'required'
			]);
			if ($validator->fails()) {
				return $this->response->bad_request($validator->errors()->all());
			}
			$request_data = $this->request->all();
			$request_data['listing_ids'] = [$request_data['listing_id']];
			$response = $this->auto_groups->delete_listing($request_data);
			return $this->response->success("Listing Deleted");
		}
	}