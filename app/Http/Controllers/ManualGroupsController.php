<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Api\Response\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Middleware\filter_broker_key;
use App\Api\Groups\ManualGroups;
use \Validator;
class ManualGroupsController extends Controller
{
    protected $response;
    protected $manual_groups;
    protected $detail;
    public function __construct(Response $response, ManualGroups $manual_groups, filter_broker_key $broker) {
        $this->response = $response;
        $this->manual_groups = $manual_groups;
        $this->details = $broker->get();
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_user_groups(Request $request) {
        $validator = Validator::make($request->all(),[
            'exchange_event_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }
        $data = $request->all();
        $user_id = $this->details['user_id'];
        $exchange_event_id = $data['exchange_event_id'];
        $resp = $this->manual_groups->get_user_groups($user_id, $exchange_event_id);
        if ($resp) {
            return $this->response->success($resp, 'groups_data');
        }
        return $this->response->success(["no group found"], 'groups_data');
    }
    
    /**
     * [save description]
     * @param  Request $request
     * @return [mixed]
     */
    public function save(Request $request) {
        $validator = Validator::make($request->all(),[
                'exchange_id' => 'required',
                'group_name' => 'required',
                'exchange_event_id' => 'required',
                'tix_start' => 'required',
                'cp_start' => 'required',
                'auto_bc' => 'required|string',
                'inc_val' => 'required|string',
                'group_mode' => 'required|string',
                'auto_bc_rank' => 'required|string',
                'push_price' => 'required',
                'criteria_object' => 'required',
                'listing_ids' => 'required|array',
                'local_event_id' => 'required|string',
                'season_saved' => 'required|string',
                'base_price' => 'required',
                ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }
        $request_data = $request->all();
        $resp = $this->manual_groups->save_manual_group($request_data);
        if ($resp) {
            return $this->response->success(['group_id' => $resp, 'message' => "Group created"]);
        }
        return $this->response->application_error("Unable to preocess request.");
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {
        $validator = Validator::make($request->all(),[
                'group_id' => 'required',
                'auto_bc' => 'required|string',
                'inc_val' => 'required|string',
                'auto_bc_rank' => 'required|string',
                'criteria_object' => 'required',
                'listing_ids' => 'required|array',
                'group_mode' => 'required|string',
                'base_price' => 'required'
                ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }
        $group_data = $request->all();
        $resp = $this->manual_groups->edit($group_data);
        
        if ($resp) {
            return $this->response->success($resp);
        }
        return $this->response->not_found();
    }
    
    /**
     * Get group details alongwith group listings
     * @return response object
     */
    public function get_group_data(Request $request) {
        $validator = Validator::make($request->all(),[
            'group_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }
        $request_data = $request->all();
        $group_data = $this->manual_groups->group_data($request_data['group_id']);
        if ($group_data) {
            return $this->response->success($group_data, "group_data");
        }
        return $this->response->not_found('No Group found');
    }
    
    /**
     * This function will return group criteria based on group id
     * @return HTTP Response object
     */
    public function get_group_criteria(Request $request) {
        $validator = Validator::make($request->all(),[
            'group_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }
        $request_data = $request->all();
        $criteria = $this->manual_groups->get_group_criteria($request_data['group_id']);
        if ($criteria) {
            return $this->response->success($criteria, "group_criteria");
        }
        return $this->response->not_found('No Group found');
    }
    
    /**
     * Update group name
     * @return HTTP Response object
     */
    public function update_group_name(Request $request) {
        $validator = Validator::make($request->all(),[
            'group_id' => 'required',
            'group_name' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }
        $request_data = $request->all();
        if ($this->manual_groups->update_group_name($request_data['group_id'], $request_data['group_name'])) {
            return $this->response->success("Group Name Updated");
        }
        return $this->response->success("Already Updated");
    }
    
    /**
     * insert listing to already present group
     * @return HTTP Response object
     */
    public function insert_listing(Request $request) {
        $validator = Validator::make($request->all(),[
            'group_id' => 'required',
            'listing_ids' => 'required|array',
            'exchange_event_id' => 'required',
            'local_event_id' => 'required',
            'exchange_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }
        $request_data = $request->all();
        $request_data['user_id'] = $this->details['user_id'];
        $response = $this->manual_groups->insert_listing($request_data);
        if ($response == "Limit") {
            return $this->response->unauthorize("Limit Plan Exceed");
        } 
        elseif ($response) {
            return $this->response->success($response);
        } 
        else {
            return $this->response->application_error("Unable to process request.");
        }
    }
    
    /**
     * delete group
     * @return HTTP Response object
     */
    public function delete(Request $request) {
         $validator = Validator::make($request->all(),[
            'group_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }
        $request_data = $request->all();
        $resp = $this->manual_groups->delete_group($request_data['group_id']);
        
        if ($resp) {
            return $this->response->success("Group Deleted");
        } 
        else {
            return $this->response->not_found("Group not deleted");
        }
    }
    
    /**
     * delete listing
     * @param  int $group_id
     * @return HTTP Response object
     */
    public function delete_listing(Request $request) {
        $validator = Validator::make($request->all(),[
            'group_id' => 'required',
            'listing_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }
        $request_data = $request->all();
        $request_data['listing_ids'] = [$request_data['listing_id']];
        $response = $this->manual_groups->delete_listing($request_data);
        return $this->response->success("Listing Deleted");
    }
}
