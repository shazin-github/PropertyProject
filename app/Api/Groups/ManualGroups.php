<?php
namespace App\Api\Groups;

use App\Api\Groups\ManualGroupsHandler;

use App\Api\Helper\GroupsHelper;
use App\Api\Helper\PlanHelper;
use App\Http\Middleware\filter_broker_key;

class ManualGroups
{
    protected $handle_groups;
    protected $details;
    protected $groups_helper;
    protected $plan_helper;
    protected $component_id;
    
    //capture all requests from controller/routes here.
    //
    
    public function __construct(ManualGroupsHandler $handle_groups, filter_broker_key $broker, GroupsHelper $groups_helper, PlanHelper $plan_helper) {
        $this->handle_groups = $handle_groups;
        $this->groups_helper = $groups_helper;
        $this->plan_helper = $plan_helper;
        
        $this->details = $broker->get();
        $this->component_id = 3;
    }
    
    /**
     * Get user auto groups based on event id
     * @param  int $user_id  user id
     * @param  int $event_id exchange event id
     * @return mixed           Groups data | FALSE
     */
    public function get_user_groups($user_id, $event_id) {
        $groups = $this->groups_helper->get_user_groups("manual_groups", $user_id, $event_id);
        
        if ($groups) {
            return $groups;
        } 
        else {
            return false;
        }
    }
    
    /**
     * [save_manual_group
     * @param  [mixed] $group_data
     * @return [mixed]
     */
    public function save_manual_group($group_data) {
        
        $user_id = $this->details['user_id'];
        $group_data['user_id'] = $user_id;
        $group_data['component_id'] = $this->component_id;
        $listings_to_save = $group_data['listing_ids'];
        
        $count_listings_to_save = count($listings_to_save);
        
        // check if listings to be saved doesnt exceed the plan limit
        $plan_limit = $this->plan_helper->get_user_limit($count_listings_to_save, $user_id);
        
        if ($plan_limit) {
            $count_saved_listings = 0;
            
            $group_id = $this->handle_groups->save_manual_group($group_data);
            
            // save criteria for manual groups on the basis of group_id
            if ($this->handle_groups->save_criteria_manual_groups($group_id, $group_data)) {
                
                $listing_data = ['group_id' => $group_id];
                
                foreach ($listings_to_save as $listing_id) {
                    $listing_data['listing_id'] = $listing_id;
                    $group_data['listing_id'] = $listing_id;
                    $listing_data['inc_val'] = $group_data['inc_val'];
                    $listing_data['group_id'] = $group_id;
                    
                    // here we get the component id infact checking the listing
                    $component_id = $this->groups_helper->get_component_id($listing_id);
                    
                    if (!$component_id) {
                        
                        $group_data['component_id'] = $this->component_id;
                        $this->groups_helper->insert_listing($group_data);
                        $component_id = $this->component_id;
                    }
                    
                    //this function will check which operations will be perfomed on basis of type
                    $this->groups_helper->component_base_delete('manual', $component_id, $listing_id);
                    
                    // inserting group lisitng in manual group listing table needs to be fixed
                    $this->groups_helper->insert_group_listing('manual_group_listings', $listing_data);
                }
            }
        }
        return $group_id;
    }
    
    /**
     * [edit or update group functionality is present here
     * @param  [mixed] $group_data
     * @return [mixed]
     */
    public function edit($group_data) {
        
        // controller will tell if req fields not present
        $count = 0;
        $this->handle_groups->update_manual_group($group_data);
        
        foreach ($group_data['listing_ids'] as $listing_id) {
            
            $group_data['listing_id'] = $listing_id;
            $resp = $this->handle_groups->update_inc_val($group_data);
            if ($resp) {
                
                $count+= 1;
            }
        }
        
        return "Total Listing Updated: $count";
    }
    
    /**
     * delete_group on basis of group id 
     * @param  [int] $group_id
     * @return [mixed]
     */
    public function delete_group($group_id) {

        $listings = $this->handle_groups->get_group_listings($group_id, TRUE);

        $this->groups_helper->delete_listing($listings);

        $deleted = $this->groups_helper->delete_group('manual', $group_id);
        
        if ($deleted) {
            return true;
        } 
        else {
            return false;
        }
    }
    
    /**
     * delete listing from group
     * @param  array $delete array containing listing ids and group id
     * @return bool     TRUE|FALSE
     */
    public function delete_listing($delete_data) {
        if ($this->groups_helper->delete_listing_from_group('manual_group_listings', $delete_data['group_id'], $delete_data['listing_ids'])) {
            return true;
        } 
        else {
            return false;
        }
    }
    
    /**
     * insert listing(s) to already created group.
     * @return mixed
     */
    public function insert_listing($listing_data) {
        $listings = [];
        $listings_to_save = $listing_data['listing_ids'];
        if (!$this->plan_helper->get_user_limit(count($listings_to_save), $listing_data['user_id'])) {
            return "Limit";
        }
        unset($listing_data['listing_ids']);
        $inc_val = $listing_data['inc_val'];
        foreach ($listings_to_save as $listing) {
            $listing_data['listing_id'] = $listing;
            $inc_val = $listing_data['inc_val'];
            $component_id = $this->groups_helper->get_component_id($listing);
            if (!$component_id) {
                $listing_data['component_id'] = $this->component_id;
                $this->groups_helper->insert_listing($listing_data);
                $component_id = $this->component_id;
            } 
            else {
                $this->groups_helper->component_base_delete('manual', $component_id, $listing);
            }
            $listings[] = ['group_id' => $listing_data['group_id'], 'listing_id' => $listing, 'inc_val' => $inc_val];
        }
        if (count($listings)) {
            $this->groups_helper->insert_group_listing('manual_group_listings', $listings);
            return count($listings) . " Listings added to group";
        } 
        else {
            return FALSE;
        }
    }
    
    /**
     * Get Group details, like criteria and group listings
     * @param  int $group_id Group ID
     * @return mixed    Group data | FALSE
     */
    public function group_data($group_id) {
        $group_details = $this->groups_helper->get_group_by_id('manual_groups', $group_id);
        if ($group_details) {
            $group_details['group_details'] = $group_details[0];
            unset($group_details[0]);
            $group_listings = $this->handle_groups->get_group_listings($group_id);
            //$group_listings = $this->groups_helper->get_listing_ids($group_listings);
            if ($group_listings) {
                $group_details['listings'] = $group_listings;
                return $group_details;
            }
            $group_details['listings'] = FALSE;
            return $group_details;
        }
        return false;
    }
    
    /**
     * get_group_criteria on basis of group id 
     * @param  [int] $group_id
     * @return [mixed]
     */
    public function get_group_criteria($group_id) {
        $groups = $this->groups_helper->get_group_criteria("manual_groups_criteria", $group_id);
        
        //its returning the whole data i think we should be more specific about the object
        if ($groups) {
            return $groups;
        } 
        else {
            return false;
        }
    }
    
    /**
     * will update group name
     * @param  int $group_id   group id to update with
     * @param  string $group_name name to update
     * @return bool             TRUE|FALSE
     */
    public function update_group_name($group_id, $group_name) {
        if ($this->groups_helper->update_group_name('manual_groups', $group_id, $group_name)) {
            return true;
        }
        return false;
    }
}
