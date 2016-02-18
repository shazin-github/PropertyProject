<?php
namespace App\Api\Groups;

use Illuminate\Support\Facades\DB;
use App\Api\Helper\GroupsHelper;

class ManualGroupsHandler
{
    
    protected $groups_helper;
    public function __construct(GroupsHelper $groups_helper) {
        
        $this->groups_helper = $groups_helper;
    }
    
    /*
     *
     * Start Groups
     *
    */
    
    /**
     * Get User Manual Groups By UserID & EventID
     * @param $user_id
     * @param $event_id
     * @return mixed
     */
    public function get_user_manual_groups($user_id, $event_id) {
        
        $result = DB::table('manual_groups')->where('user_id', $user_id)->where('exchange_event_id', $event_id)->get();
        
        if ($result) {
            return $result;
        } 
        else {
            return false;
        }
    }
    
    
    public function save_criteria_manual_groups($group_id, $criteria) {
        
        $save_criteria = DB::table('manual_groups_criteria')->insertGetId(['group_id' => $group_id, 'push_price' => $criteria['push_price'], 'cp' => 0, 'on_floor' => 0, 'on_ceil' => 0, 'comparison' => 0, 'component_id' => $criteria['component_id'], 'updated' => date("Y-m-d h:m:i", time()), 'exchange_event_id' => $criteria['exchange_event_id'], 'criteria_object' => json_encode($criteria['criteria_object']), 'exchange_id' => $criteria['exchange_id'], ]);
        if ($save_criteria) {
            return $save_criteria;
        } 
        else {
            return FALSE;
        }
    }
    
    /**
     * Get Group Listing GroupID
     * @param $group_id
     * @return bool
     */
    function get_group_listings($group_id, $internal = false) {
        $result = DB::table('manual_group_listings')
            ->select('listing_id', 'inc_val')
            ->where('group_id', $group_id)
            ->orderBy('inc_val', 'desc')->get();
        if ($result) {
            if ($internal) {
                return $this->groups_helper->get_listing_ids($result);
            }
            return $result;
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
        
        $group_id = DB::table('manual_groups')->insertGetId(['user_id' => $group_data['user_id'], 'group_name' => $group_data['group_name'], 'group_mode' => $group_data['group_mode'], 'exchange' => $group_data['exchange_id'], 'exchange_event_id' => $group_data['exchange_event_id'], 'tix_start' => $group_data['tix_start'], 'cp_start' => $group_data['cp_start'], 'base_price' => $group_data['base_price'], 'auto_bc' => $group_data['auto_bc'], 'local_event_id' => $group_data['local_event_id'], 'auto_bc_rank' => $group_data['auto_bc_rank'], 'season_saved' => $group_data['season_saved'], ]);
        if ($group_id) {
            return $group_id;
        } 
        else {
            return FALSE;
        }
    }
    
    /**
     * [update_manual_group on the bases of requested data
     * @param  [mixed] $group_update
     * @return [mixed]
     */
    public function update_manual_group($group_update) {
        $update = DB::table('manual_groups')->where('group_id', $group_update['group_id'])->update(['group_mode' => $group_update['group_mode'], 'auto_bc' => $group_update['auto_bc'], 'base_price' => $group_update['base_price'], 'auto_bc_rank' => $group_update['auto_bc_rank']]);
        
        $update_criteria = DB::table('manual_groups_criteria')->where('group_id', $group_update['group_id'])->update(['updated' => date("Y-m-d h:m:i", time()), 'criteria_object' => json_encode($group_update['criteria_object']) ]);
        
        return true;
    }
    
    /**
     * [update_inc_val for every listing id
     * @param  [mixed] $group_update
     * @return [mixed]
     */
    public function update_inc_val($group_update) {
        
        $update_listing = DB::table('manual_group_listings')->where('listing_id', $group_update['listing_id'])->update(['inc_val' => $group_update['inc_val']]);
        return true;
    }
}
