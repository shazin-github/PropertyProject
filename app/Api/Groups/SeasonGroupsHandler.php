<?php

	namespace App\Api\Groups;

	use \DB;
	/**
	* @author: Mubin
	*/
	class SeasonGroupsHandler
	{
	    /**
	     * Get Season Group
	     * @param array $season_group_data  [exchange_event_id, group_name, group_type, user_id]
	     * @return mixed
    	*/
	    public function get_season_group($season_data){
	        $result = DB::table('season_groups')
	            ->where('exchange_event_id', $season_data['exchange_event_id'])
	            ->where('user_id', $season_data['user_id'])
	            ->where('group_name', $season_data['group_name'])
	            ->where('group_type', $season_data['group_type'])
	            ->get();
	        if ($result) {
	            return $result;
	        } else {
	            return false;
	        }
	    }
	    /**
	     * Save Season Group
	     * @param array $season_group_data  [exchange_event_id, group_name, group_type, user_id, group_id]
	     * @return bool 	TRUE
    	*/
	    public function save_group_season($season_group_data){
	    	if($this->get_season_by_id($season_group_data['group_id'])){
	    		$this->delete_season_group($season_group_data['group_id']);
	    	}
	        $seasonGroupID = DB::table('season_groups')->insertGetId([
	            'user_id' => $season_group_data['user_id'],
	            'exchange_event_id' => $season_group_data['exchange_event_id'],
	            'group_name' => $season_group_data['group_name'],
	            'group_type' => $season_group_data['group_type'],
	            'group_id' => $season_group_data['group_id']
	        ]);
	        return true;
	    }
	    /**
	     * Get Group season based on group id
	     * @param  intval $group_id Group ID
	     * @return bool           
	     */
	    public function get_season_by_id($group_id){
	    	$is_saved_season = DB::table('season_groups')
	    		->where('group_id', $group_id)
	    		->get();
	    	if($is_saved_season){
		        return true;
	    	}else{
	    		return false;
	    	}
	    }
	    /**
	     * Delete Season Group
	     * @param $group_id
	     * @return bool
	     */
	    function delete_season_group($group_id) {
            $status = DB::table('season_groups')
                ->where('group_id', $group_id)
                ->delete();
            if($status){
            	return TRUE;
            }else{
            	return FALSE;
            }
	    }
	}