<?php

	namespace App\Http\Controllers;

	use App\Api\Groups\ManualGroups;
	use Illuminate\Http\Request;
	use App\Http\Requests;
	use App\Http\Controllers\Controller;
	use App\Api\Groups\AutoGroups;
	use App\Http\Middleware\filter_broker_key;
	use App\Api\Response\Response;
	use App\Api\Groups\SeasonGroups;
	use \Validator;
	class GroupsController extends Controller
	{
		protected $auto_groups;
		protected $manual_groups;
		protected $request;
		protected $response;
		protected $seasons;

		public function __construct(AutoGroups $auto_groups, ManualGroups $manual_groups,Request $request, filter_broker_key $broker, Response $response, SeasonGroups $seasons){
			$this->auto_groups = $auto_groups;
			$this->manual_groups = $manual_groups;
			$this->request = $request;
			$this->response = $response;
			$this->seasons = $seasons;
			$this->request['user_id'] = $broker->get()['user_id'];
		}
		/**
		 * Get User all groups(auto, manual) based on user_id and exchange_id
		 * @return HTTP Response Object 
		 */
		public function index(){
			$validator = Validator::make($this->request->all(),[
	    		'exchange_event_id' => 'required'
			]);
			if ($validator->fails()) {
				return $this->response->bad_request($validator->errors()->all());
			}
			$request_data = $this->request->all();
			$auto_groups = $this->auto_groups->user_groups($request_data['user_id'], $request_data['exchange_event_id']);
			$manual_groups = $this->manual_groups->get_user_groups($request_data['user_id'], $request_data['exchange_event_id']);
			if(!$auto_groups){
				$auto_groups = [];
			}
			if(!$manual_groups){
				$manual_groups = [];
			}
			$manual_groups?$manual_groups:[];
			return $this->response->success(['auto_groups' => $auto_groups, 'manual_groups' => $manual_groups], "groups_overview");
		}
		/**
		 * get_season   Get Season based on requested data
		 * @return HTTP Response Object
		 */
		public function get_season(){
			$validator = Validator::make($this->request->all(),[
	    		'exchange_event_id' => 'required',
	    		'group_name' => 'required|string',
	    		'group_type' => 'required|string',
			]);
			if ($validator->fails()) {
				return $this->response->bad_request($validator->errors()->all());
			}
			$request_data = $this->request->all();
			$seasons = $this->seasons->get_season_group($request_data);
			if($seasons){
				return $this->response->success($seasons, "season");
				
			}else{
				return $this->response->not_found(['No Season Found']);
			}
		}
		/**
		 * [create_season Create Group Season based on Requested Data]
		 * @return HTTP Response Object 
		 */
		public function create_season(){
			$validator = Validator::make($this->request->all(),[
	    		'exchange_event_id' => 'required',
	    		'group_name' => 'required|string',
	    		'group_type' => 'required|string',
	    		'group_id' => 'required',
			]);
			if ($validator->fails()) {
				return $this->response->bad_request($validator->errors()->all());
			}
			$request_data = $this->request->all();

			$season_id = $this->seasons->save_group_season($request_data);
			if($season_id){
				return $this->response->success("Season Group Created");;
			}else{
				$this->response->not_found(["Unable to process request"]);
			}
		}
		/**
		 * [delete_season Delete Group Season based on Group ID]
		 * @return HTTP Response Object 
		 */
		public function delete_season(){
			$validator = Validator::make($this->request->all(),[
	    		'group_id' => 'required'
			]);
			if ($validator->fails()) {
				return $this->response->bad_request($validator->errors()->all());
			}
			$request_data = $this->request->all();
			
			$seasons = $this->seasons->delete_season_group($request_data['group_id']);
			if($seasons){
				return $this->response->success(["Season Deleted"], "success");
			}else{
				return $this->response->not_found(['No Season Found']);
			}
		}
	}

