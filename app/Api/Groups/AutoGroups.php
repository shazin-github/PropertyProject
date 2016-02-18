<?php
	namespace App\Api\Groups;
	use App\Api\Groups\AutoGroupsHandler;
	use App\Api\Helper\GroupsHelper;
	use App\Api\Helper\PlanHelper;
	/**
	* @author : Mubin <mubin@brokergenius.com>
	*/
	class AutoGroups
	{
		protected $group_helper;
		protected $plan_helper;
		protected $group_handler;
		function __construct(GroupsHelper $group_helper, PlanHelper $plan_helper, AutoGroupsHandler $group_handler)
		{
			$this->group_helper = $group_helper;
			$this->group_handler = $group_handler;
			$this->plan_helper = $plan_helper;
		}
		/**
		 * Get user auto groups based on event id
		 * @param  int $user_id  user id
		 * @param  int $event_id exchange event id
		 * @return mixed           Groups data | FALSE
		 */
		public function user_groups($user_id, $event_id){
			$groups = $this->group_helper->get_user_groups("auto_groups", $user_id, $event_id);
			if($groups){
				return $groups;
			}else{
				return false;
			}
		}

		/**
		 * Get Group details, like criteria and group listings
		 * @param  int $group_id Group ID
		 * @return mixed  	Group data | FALSE
		 */
		public function group_data($group_id){
			$group_details = $this->group_helper->get_group_by_id('auto_groups', $group_id);
			if($group_details){
				$group_details['group_details'] = $group_details[0];
				unset($group_details[0]);
				$group_listings = $this->group_handler->get_group_listings($group_id);
				if($group_listings){
					$group_details['listings'] = $group_listings;
					return $group_details;
				}
				$group_details['listings'] = FALSE;
				return $group_details;
			}
			return false;
		}

		public function get_group_criteria($group_id){
			$groups = $this->group_helper->get_group_criteria("auto_groups_criteria", $group_id);
			if($groups){
				return $groups;
			}else{
				return false;
			}
		}
		/**
		 * Update Criteria, auto_bc, auto_bc_rank listing status and listing priority
		 * @param  array $request_update Group's data to udate
		 * @return array                array that will hold update and inserted listing status $status['inserted' => 2, 'updated' => 2]
		 */
		public function update($request_update){
			
			$priority = 1;
			$this->group_handler->update_criteria($request_update);
			$this->group_helper->update_auto_bc('auto_groups', $request_update);
			$listing_data = ['group_id' => $request_update['group_id']];
            foreach ($request_update['listing_ids'] as $listing_id) {
                $listing_data['listing_id'] = $listing_id;
                $listing_data['priority'] = $priority;
                $this->group_handler->update_priority($listing_id, $priority);
                $priority += 1;
            }
            $priority -= 1;
            return "Total Listing Updated: $priority";
		}
		/**
		 * will update group name
		 * @param  int $group_id   group id to update with
		 * @param  string $group_name name to update
		 * @return bool             TRUE|FALSE
		 */
		public function update_group_name($group_id, $group_name){
			if($this->group_helper->update_group_name('auto_groups', $group_id, $group_name)){
				return true;
			}
			return false;
		}
		/**
		 * create group
		 * @param  array $group_data data to create with
		 * @return mixed
		 */
		public function create($group_data){
			$listings_to_save = $group_data['listing_ids'];
	        if(!$this->plan_helper->get_user_limit(count($listings_to_save), $group_data['user_id'])){
	            return FALSE;	//user limit reached
	        }
	        $group_id = $this->group_handler->create_group($group_data);
	        return $group_id;
		}
		/**
		 * insert listing(s) to already created group.
		 * @return mixed
		 */
		public function insert_listing($listing_data){
			$listings = [];
			$listings_to_save = $listing_data['listing_ids'];
	        if(!$this->plan_helper->get_user_limit(count($listings_to_save), $listing_data['user_id'])){
	            return "Limit";	//limit reached
	        }
	        unset($listing_data['listing_ids']);
	        $priority = $this->group_handler->get_priority($listing_data['group_id']);
	        foreach($listings_to_save as $listing){
	        	$listing_data['listing_id'] = $listing;
	        	$priority += 1;
	        	$component_id = $this->group_helper->get_component_id($listing);
		        if(!$component_id){
		            $this->group_helper->insert_listing($listing_data);
		            $component_id = $listing_data['component_id'];
		        }else{
			        $this->group_helper->component_base_delete('auto', $component_id, $listing);
		        }
	        	$listings[] = [
	                'group_id' => $listing_data['group_id'],
	                'listing_id' => $listing,
	                'priority' => $priority
	            ];
	        }
	        if(count($listings)){
	        	$this->group_helper->insert_group_listing('autogroup_listings', $listings);
	        	return count($listings)." Listings added to group";
	        }else{
	        	return FALSE;
	        }
		}
		/**
		 * delete group
		 * @param  int $group_id 
		 * @return bool 	true
		 */
		public function delete_group($group_id){
			$listings = $this->group_handler->get_group_listings($group_id, TRUE);
			$this->group_helper->delete_listing($listings);
			$name = $this->group_helper->delete_group('auto', $group_id);
			return TRUE;
		}

		/**
		 * delete listing from group
		 * @param  array $delete array containing listing ids and group id
		 * @return bool 	TRUE|FALSE
		 */
		public function delete_listing($delete){
			if($this->group_helper->delete_listing_from_group('autogroup_listings', $delete['group_id'], $delete['listing_ids'])){
				return true;
			}else{
				return false;
			}
		}
		
	}