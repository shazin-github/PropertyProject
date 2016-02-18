<?php

namespace App\Api\Groups;

use Illuminate\Support\Facades\DB;
use App\Api\Helper\GroupsHelper;
use App\Api\Helper\PlanHelper;
class AutoGroupsHandler{

    protected $groups_helper;
    protected $plan_helper;
    protected $component_id;
    public function __construct(GroupsHelper $groups_helper, PlanHelper $plan_helper){
        $this->groups_helper = $groups_helper;
        $this->plan_helper = $plan_helper;
        $this->component_id = 2;
    }
    /*
     *
     * Start Groups
     *
     */

    /**
     * Get Tickets Price based on User ID
     * @param $user_id
     * @return mixed
     */
    /*public function get_prices($user_id) {
        $result = DB::table('auto_groups')
                ->join('autogroup_listings')
                ->join();
        $result = DB::table('listing_groups')
            ->join('pricenotifier_criteria', 'pricenotifier_criteria.ticket_id', '=', 'listing_groups.listing_id')
            ->join('groups', 'groups.group_id', '=', 'listing_groups.group_id')
            ->select('ticket_id' , 'priority' , 'changed_price' , 'price_floor' , 'groups.group_id' ,
                'groups.increment_type' , 'increment_val' , 'groups.criteria' , 'groups.auto_bc', 'groups.auto_bc_rank')
            ->where('status', '=', 1)
            ->where('pricenotifier_criteria.user_id', '=', $user_id)
            ->whereNotNull('pricenotifier_criteria.changed_price')
            ->orderBy('groups.group_id', 'desc')
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }*/


/**
 * 1) create group
 */
 

    

    /**
     * Create New User Group
     * @param array $data holds all stuff that is required to create new group
     */
    function create_group($group_data) {
        //$user_id, $group_name, $criteria, $event_id, $tm_event_id, $inc_type=0, $inc_val=0, $tix_start = 0, $cp_start
        
        $group_id = DB::table('auto_groups')->insertGetId([
                'user_id' => $group_data['user_id'],
                'group_name' => $group_data['group_name'],
                'exchange' => $group_data['exchange_id'],
                'exchange_event_id' => $group_data['exchange_event_id'],
                'group_inc_type' => $group_data['group_inc_type'],
                'tix_start' => $group_data['tix_start'],
                'listing_start' => $group_data['listing_start'],
                'cp_start' => $group_data['cp_start'],
                'auto_bc' => $group_data['auto_bc'],
                'auto_bc_rank' => $group_data['auto_bc_rank']
            ]);
        if($this->save_criteria($group_id, $group_data)){
            $listing_data = ['group_id' => $group_id];
            $priority = 1;
            foreach ($group_data['listing_ids'] as $listing_id) {
                $group_data['listing_id'] = $listing_id;
                $listing_data['listing_id'] = $listing_id;
                $listing_data['priority'] = $priority;
                $component_id = $this->groups_helper->get_component_id($listing_id);
                if(!$component_id){
                    $this->groups_helper->insert_listing($group_data);
                    $component_id = $this->component_id;
                }
                $this->groups_helper->component_base_delete('auto', $component_id, $listing_id);
                $this->groups_helper->insert_group_listing('autogroup_listings', $listing_data);
                $priority += 1;
            }
        }

        return $group_id;

    }

    public function save_criteria($group_id, $criteria){
        $save_criteria = [
                'group_id' => $group_id,
                'push_price' => $criteria['push_price'],
                'cp' => 0,
                'on_floor' => 0,
                'on_ceil' => 0,
                'comparison' => 0,
                'component_id' => $criteria['component_id'],
                'exchange_event_id' => $criteria['exchange_event_id'],
                'criteria_object' => $criteria['criteria_object'],
                'exchange_id' => $criteria['exchange_id'],
            ];
        $save_criteria = $this->groups_helper->save_criteria("auto_groups_criteria", $save_criteria);
        if($save_criteria){
            return $save_criteria;
        }else{
            return FALSE;
        }
    }

    public function get_priority($group_id){
        $priority = DB::table('autogroup_listings')
            ->max('priority');
        if($priority){
            return $priority;
        }else{
            return 1;
        }
        
    }    


    /**
     * Update priority ListingID
     * @param array $data contains listing id and priority to update
     * @return bool
     */
    function update_priority($listing_id, $priority) {

        if($this->groups_helper->get_listing('autogroup_listings', $listing_id, TRUE)) {
            DB::table('autogroup_listings')
                ->where('listing_id', $listing_id)
                ->update([
                    'priority' => $priority
                ]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Update Group criteria By GroupID
     * @param array $date   contains Group ID and Criteria Object
     * @return bool
     */
    function update_criteria($to_update) {
        if($this->check_group_by_id($to_update['group_id'])) {
            DB::table('auto_groups_criteria')
                ->where('group_id', $to_update['group_id'])
                ->update([
                    'criteria_object' => $to_update['criteria_object'],
                    'updated' => date("Y-m-d h:m:i", time())
                ]);
            return true;
        } else {
            return false;
        }
    }

    public function check_group_by_id($group_id){
        $result = DB::table('auto_groups_criteria')
            ->where('group_id', '=', $group_id)
            ->get();
        if($result){
            return TRUE;
        }else{
            return FALSE;
        }
    }


/**
 * Get Group Listing GroupID
 * @param $group_id
 * @return bool
 */
function get_group_listings($group_id, $internal = false) {
        $result = DB::table('autogroup_listings')
            ->where('group_id', $group_id)
            ->orderBy('priority', 'desc')
            ->select('listing_id', 'priority')
            ->get();
        if ($result) {
            if($internal){
                return $this->groups_helper->get_listing_ids($result);
            }
            return $result;
        } else {
            return false;
        }
    }

/**
 * Get Group Listing Count
 * @param $group_id
 * @return bool|int
 */
function listing_count_for_group($group_id) {
        $result = DB::table('autogroup_listings')
            ->where('group_id', $group_id)
            ->orderBy('priority', 'desc')
            ->get();
        if ($result) {
            return count($result);
        } else {
            return false;
        }
    }

/**
 * Get Groups Listing By EventID
 * @param $event_id
 * @return mixed
 */
function get_listing_by_event($event_id) {

    $result = DB::table('auto_groups')
        ->join('autogroup_listings', 'auto_groups.group_id', '=', 'autogroup_listings.group_id')
        ->where('exchange_event_id', '=', $event_id)
        ->select('auto_groups.group_id' , 'listing_id' , 'priority', 'auto_groups.group_name')
        ->get();
    if ($result) {
        return $result;
    } else {
        return false;
    }
}

    /**
     * Delete group listings(all)
     * @param $group_id
     * @return bool
     */
    /*function delete_listings_from_group($group_id) {
        $listing_ids = $this->get_group_listings($group_id);
        if($listing_ids) {
            $ids = [];
            foreach($listing_ids as $listing_id){
                $ids[] = $listing_id->listing_id;
            }
            $this->groups_handler->
        } else {
            return false;
        }
    }*/

    /**
     * Delete Single Listing from group by ListingID
     * @param $group_id
     * @param $listing_id
     * @return bool
     */
    function delete_listing_from_group($group_id, $listing_id) {

        $this->groups_helper->delete_listing_from_group('autogroup_listings', $group_id, $listing_id);
        $this->groups_helper->delete_listing($listing_id);
        return true;
    }

    /**
     * Delete Group
     * @param $group_id
     * @return bool
     */
    function delete_group($group_id) {

        $ids = DB::table('autogroup_listings')
            ->where('group_id', $group_id)
            ->select('listing_id')
            ->get();
        $this->groups_helper->delete_group('auto', $group_id);
        if(count($ids)) {
            $this->groups_helper->delete_listing($ids);
        }
        return TRUE;
    }


    /**
     * Update Group Name
     * @param $group_id
     * @param $group_name
     * @return bool
     */
    function update_group_name($group_id, $group_name) {

        $result = DB::table('groups')
            ->where('group_id', '=', $group_id)
            ->get();
        if($result) {
            DB::table('groups')
                ->where('group_id', $group_id)
                ->update([
                    'group_name' => $group_name,
                ]);
            return true;
        } else {
            return false;
        }
    }
}