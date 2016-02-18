<?php

	namespace App\Api\Helper;
	use \DB;

	/**
	* @author :Mubin <mubin@brokergenius.com>
	* @author :Asad <asad@brokergenius.com>
	*/
	class GroupsHelper
	{
		protected $criterias_handler;
		function __construct()
		{
			
		}
		/**
		 * will delete listing(s) from listings_data table
		 * @param array $listing_ids array of one or more listing ids(must be an array)
		 * @return bool 	TRUE|FALSE 
		 */
		public function delete_listing($listing_ids){
			is_array($listing_ids)?$listing_ids:[$listing_ids];
			
			$result = DB::table('listings_data')
				->whereIn('listing_id', $listing_ids)
				->delete();
			if($result){
				return TRUE;
			}
			return FALSE;
		}
		
		/**
		 * will delete criteria(s) from listings_criterias table
		 * @param array $listing_ids array of one or more listing ids(must be an array)
		 * @return bool 	TRUE|FALSE 
		 */
		public function delete_criteria($listing_ids) {
			is_array($listing_ids)?$listings_ids:[$listing_ids];
	        $result = DB::table('listings_criteria')
		        ->whereIn('listing_id', $listing_ids)
		        ->delete();
	        if ($result) {
	            return true;
	        } else {
	            return false;
	        }
	    }

	    function delete_listing_from_group($table, $group_id, $listing_id) {
	    	is_array($listing_id)?$listing_id:[$listing_id];
            $result = DB::table($table)
                ->where('group_id', '=', $group_id)
                ->whereIn('listing_id',$listing_id)
                ->delete();
	        if ($result) {
	        	$this->delete_listing($listing_id);
	            return true;
	        } else {
	            return false;
	        }
	    }
	    /**
	     * Updates group name
	     * @param  string $table      table to update in
	     * @param  int $group_id   group id to update of
	     * @param  string $group_name group name to be updated
	     * @return bool             TRUE|FALSE
	     */
	    public function update_group_name($table, $group_id, $group_name){
	    	return DB::table($table)
	    		->where('group_id', $group_id)
	    		->update(
	    			['group_name' => $group_name]
    			);
	    }
	     /**
	     * Check Group Listings based on GroupID & ListingID
	     * @param $group_id
	     * @param $listing_id
	     * @return bool
	     */
	    public function check_listing_by_group_id($table, $group_id){
	    	$result = DB::table($table)
	            ->where('group_id', $group_id)
	            ->where('listing_id', $listing_id)
	            ->get();
	        if($result) {
	            return true;
	        } else {
	            return false;
	        }
	    }
	    /**
	     * return group criteria by group id
	   * @param  string $table      table to update in
	     * @param  int $group_id   group id to update of
	     * @return mixed           Criteria|FALSE
	     */
	    public function get_group_criteria($table, $group_id){
	    	$result = DB::table($table)
	            ->where('group_id', $group_id)
	            
	            ->get();
	        if($result) {
	        	$result[0]->criteria_object = json_decode($result[0]->criteria_object, true);
	            return $result;
	        } else {
	            return false;
	        }
	    }

	    /**
	     * will check listing from listings_data table on the basis of listing_id
	     * @param int $listing_id $listing_id to check with
	     * @return mixed 	returns array or false
	     */
	    public function get_component_id($listing_id){
	    	$result = DB::table('listings_data')
	    		->select('component_id')
	    		->where('active', 1)
	    		->where('listing_id', $listing_id)	
	    		->get();
	    	if($result){
	    		return $result[0]->component_id;
	    	}else{
	    		return FALSE;
	    	}
	    }
	    
	    /**
	     * inserts listing to listings data table
	     * @param  [type] $listing_data [description]
	     * @return [type]               [description]
	     */
	    public function insert_listing($listing_data) {
   
	        $data['local_event_id'] = $listing_data['local_event_id'];
	        $data['active'] = 1;
	        $data['price_sync_status'] = 0;
	        $data['sold_status'] = 0;	           
	        $data['component_id'] = $listing_data['component_id'];      
	        $data['exchange_id'] = $listing_data['exchange_id'];      
	        $data['user_id'] = $listing_data['user_id'];      
	        $data['listing_id'] = $listing_data['listing_id']; 
	        $data['exchange_event_id'] = $listing_data['exchange_event_id'];

	        $result = DB::table('listings_data')->insert($data);
	        if ($result) {
	            return true;
	        } else {
	            return false;
	        }
	    }


	    public function update_listing($listing_id, $component_id){
	    	$result = DB::table('listings_data')
	    		->where('listing_id', $listing_id)
	    		->update([
	    			'component_id' => $component_id,
	    			'price_sync_status' => 0,
	    			'sold_status' => 0
    			]);
    		if($result){
    			return TRUE;
    		}else{
    			return FALSE;
    		}
	    }
	    /**
	     * Get Group based on GroupID
	     * @param $user_id
	     * @param $group_name
	     * @param $event_id
	     * @return mixed
	     */
	    function get_group($table, $group_id){

	        $result = DB::table($table)
	            ->where('group_id', '=', $group_id)
	            ->get();
	        if($result) {
	            return $result;
	        } else {
	            return false;
	        }
	    }
	    
	    /**
	     * Get Groups Based on UserID and EventID
	     * @param $user_id
	     * @param $event_id
	     * @return mixed
	     */
    
	    function get_user_groups($table, $user_id, $event_id) {
	        $result = DB::table($table)
	            ->where('user_id', $user_id)
	            ->where('exchange_event_id', $event_id)
	            ->get();
	        if($result) {
	            return $result;
	        } else {
	            return false;
	        }
	    }

       /**
	     * Get Group Detail By GroupID
	     * @param $group_id
	     * @return mixed
	     */
	    function get_group_by_id($table, $group_id) {
	        $result = DB::table($table)
	            ->where('group_id', '=', $group_id)
	            ->get();

	        if($result) {
	            return $result;
	        } else {
	            return false;
	        }
	    }
	    /**
	     * Get Listings based on ListingID
	     * @param string $table table name to fetch
	     * @param $listing_id
	     * @param bool $check function will return only true if this property set to true, otherwise will return full listing data
	     * @return mixed
	     */
	    function get_listing($table, $listing_id, $check = false) {

	        $result = DB::table($table)
	            ->where('listing_id', '=', $listing_id)
	            ->get();
	        if($result) {
	            if($check){
	                return TRUE;
	            }
	            return $result;
	        } else {
	            return false;
	        }
	    }

	    /**
		 * Update Group AutoBC by GroupID
		 * @param $group_id
		 * @param $auto_bc
		 * @param $auto_bc_rank
		 * @return bool
		 */
		function update_auto_bc($table, $update) {
		    if($this->get_group_by_id($table, $update['group_id'])) {
		        DB::table($table)
		            ->where('group_id', $update['group_id'])
		            ->update([
		                'auto_bc' => $update['auto_bc'],
		                'auto_bc_rank' => $update['auto_bc_rank']
		            ]);
		        return true;
		    } else {
		        return false;
		    }
		}
		/**
		 * function will take Laravel DB object and will return plain array of listing ids
		 * @param  DB Object $listing_id_object Laravel DB Object contains listing ids
		 * @return array                    array of listing ids
		 */
		public function get_listing_ids($listing_id_object){
			return array_map(function($object){ return $object->listing_id; }, $listing_id_object);
		}

		public function delete_group($mode = 'default', $group_id){
			$tables = [];
			
			if($mode == 'default'){
				return 'Unable to delete';
			}
			if($mode == 'auto'){
				$tables = ['auto_groups', 'autogroup_listings', 'auto_groups_criteria'];
			}
			else{
				$tables = ['manual_groups', 'manual_group_listings', 'manual_groups_criteria'];
			}
			
			foreach($tables as $table){
				DB::table($table)
					->where('group_id', $group_id)
					->delete();
			}

			return true;
		}

		/**
	     * Get User Listing By UserID & Listing ID
	     * @param $user_id
	     * @param $listing_id
	     * @return mixed
	     */
	    public function get_single_listing($user_id, $listing_id){

	        $result = DB::table('listings_data')
	            ->where('listing_id', '=', $listing_id)
	            ->where('user_id', '=', $user_id)
	            ->get();
	        if ($result) {
	            return $result;
	        } else {
	            return false;
	        }
	    }
	    /**
	     * component_base_delete will delete listing from different tables based on $component_id
	     * @param  string $mode         auto|manual
	     * @param  int $component_id component id to indicate listing group[auto, manual, plain]
	     * @param  [type] $listing_id   Listing ID to check 
	     * @return bool               TRUE
	     */
	    public function component_base_delete($mode = 'auto', $component_id, $listing_id){
	    	if($mode == 'auto'){
	    		$component = 2;
	    	}else{
	    		$component = 3;
	    	}
	        if($component_id == 1){
	            $this->delete_criteria($listing_id);
	            $this->update_listing($listing_id, $component);
	        }elseif($component_id == 3){
	            $this->update_listing($listing_id, $component);
	            $this->delete_group_listing('manual_group_listings', $listing_id);
	        }else{
	            $this->update_listing($listing_id, $component);
	            $this->delete_group_listing('autogroup_listings', $listing_id);
	            
	        }
	        return TRUE;
	    }

	    public function delete_group_listing($table, $listing_id){
			$result = DB::table($table)
				->where('listing_id', $listing_id)
				->delete();
			if($result){
				return TRUE;
			}
			return FALSE;
		}
	    /**
	     * Insert listing(s) to already present group. priority will be last highest priority from table
	     * @param $listing_data
	     * @param $table 	Table name
	     * @return mixed 	bool
	     */
	    public function insert_group_listing($table, $listing_data){
	        $save = DB::table($table)
	            ->insert($listing_data);
	        if($save){
	            return true;
	        }
	        else{
	            return false;
	        }
	    }
	    /**
	     * saves criteria in specified table
	     * @param  string $table    table to save in
	     * @param  array $criteria criteria object
	     * @return mixed           criteria id | FALSE
	     */
	    public function save_criteria($table, $criteria){
	        $save_criteria = DB::table($table)
	            ->insertGetId($criteria);
	        if($save_criteria){
	            return $save_criteria;
	        }else{
	            return FALSE;
	        }
	    }
	    /**
	     * insert listnig(s) to group
	     * @param array $listings array containing multiple listings to insert
	     * @return [type] [description]
	     */


	}