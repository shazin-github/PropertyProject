<?php

	namespace App\Api\Helper;
	use \DB;
	/**
	 * PlanHelper
	* @author: Mubin<mubin@brokergenius.com>
	* @version: 1.0
	*/
	class PlanHelper
	{
		
		function __construct()
		{
			
		}
		public function get_user_limit($listings_to_save , $user_id){
			$plan_id = $this->find_user_plan($user_id);
			if($plan_id){
				$plan_limit = $this->find_plan_limit($plan_id);
				if($plan_limit){
					$user_listings = $this->get_user_listings($user_id);
					if(($listings_to_save + $user_listings) < $plan_limit){
						return TRUE;
					}
				}
			}
			return FALSE;
		}

		public function find_plan_limit($plan_id) {

        
        $result = DB::table('plans')
        	->select('plan_limit')
        	->where('id', $plan_id)
        	->take('1')
        	->get();
        if ($result) {
            return $result[0]->plan_limit;
        } else {
            return false;
        }
    }
	    public function find_user_plan($user_id) {
	        $result = DB::table('user_plans')
	        	->select('plan_id')
	        	->where('user_id', $user_id)
	        	->take(1)
	        	->get();
	        
	        if ($result) {
	            return $result[0]->plan_id;
	        } else {
	            return FALSE;
	        }
	    }

		public function get_user_plan_limit($user_id) {
			$plan_id = $this->find_user_plan($user_id);
			$plan_limit = 0;
			if($plan_id) {
				$plan_limit = $this->find_plan_limit($plan_id);
			}
			return $plan_limit;
		}

	    public function get_user_listings($user_id) {
	        $result = DB::table('listings_data')
	        	->where('user_id', $user_id)
	        	->where('sold_status', '0')
	        	->where('active', '1')
	        	->count();
	        return $result;
	    }

		public function get_all_plans() {
			$result = DB::table('plans')
					->get();
			if ($result) {
				return $result;
			} else {
				return false;
			}
		}
	}
