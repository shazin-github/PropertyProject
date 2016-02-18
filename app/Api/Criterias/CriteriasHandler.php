<?php
namespace App\Api\Criterias;

use Illuminate\Support\Facades\DB;
use App\Api\Helper\GroupsHelper;

/**
 * @author: Asad
 *
 */

class CriteriasHandler
{
    protected $criteria_helper;

    public function __construct(GroupsHelper $criteria_helper){
        $this->criteria_helper = $criteria_helper;
    }
    /**
     * [save_criteria
     * @param  [array] $request_data 
     * @return [boolean]               
     */
    public function save_criteria($request_data) {
       
        $data['on_floor'] = 0;
        $data['on_ceil'] = 0;
        $data['cp'] = 0;
        $data['push_price'] = 0;
        $data['comparison'] = 0;
        $data['component_id'] = $request_data['component_id'];
        $data['criteria_object'] = json_encode($request_data['criteria_object']);
        $data['listing_id'] = $request_data['listing_id'];
        $data['exchange_event_id'] = $request_data['exchange_event_id'];
        $data['exchange_id'] = $request_data['exchange_id'];
        
        $result = DB::table('listings_criteria')->insert($data);
        
        if ($result) {
            return true;
        }
    }
    
    /**
     * [update_criteria
     * @param  [mixed] $request_data 
     * @return [mixed]               
     */
    public function update_criteria($request_data) {
     
        //setting required fields
        $data['on_floor'] = 0;
        $data['on_ceil'] = 0;
        $data['cp'] = 0;
        $data['push_price'] = 0;
        $data['comparison'] = 0;
        $data['updated'] = date("Y-m-d h:i:s", time());
        $data['component_id'] = $request_data['component_id'];
        $data['criteria_object'] = json_encode($request_data['criteria_object']);
        $data['listing_id'] = $request_data['listing_id'];
        $data['exchange_event_id'] = ($request_data['exchange_event_id']);
        $data['exchange_id'] = $request_data['exchange_id'];
        //update the criteria
        $result = DB::table('listings_criteria')->where('listing_id', $request_data['listing_id'])->update($data);
        
        //updating the status
        $this->criteria_helper->update_listing($request_data['listing_id'], '1');
        
        return true;
    }
    
    /**
     * [check_listing_criteria_type
     * @param  [mixed] $listing_id 
     * @return [mixed]             
     */
    public function check_listing_criteria_type($listing_id) {
        
        $result = DB::table('listings_data')
            ->where('listing_id', $listing_id)
            ->where('component_id', '=', 2)
            ->where('component_id', '=', 3)
            ->get();
        return $result;
    }
 
    /**
     * delete_criteria
     * @param  array $listing_ids 
     * @return [mixed]             
     */
    public function delete_criteria($listing_ids) {
        $result = DB::table('listings_criteria')
                ->whereIn('listing_id', $listing_ids)
                ->delete();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * [delete_listing
     * @param  [mix] $listing_id 
     * @return bool             
     */
    public function delete_listing($listing_ids) {
        $result = DB::table('listings_criteria')->whereIn('listing_id', $listing_ids)->delete();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
 
    
    /**
     * [get_criteria_through_listing_id
     * @param  [int] $listing_id 
     * @return [mixed]             
     */
    public function get_criteria_through_listing_id($listing_id) {
        $result = DB::table('listings_criteria')->where('listing_id', $listing_id)->get();
        if ($result) {
            return $result[0];
        } else {
            return false;
        }
    }
    
    /**
     * [get_criteria_through_user_and_event_id
     * @param  [mixed] $user_id           
     * @param  [mixed] $exchange_event_id 
     * @return [mixed]                    
     */
    public function get_criteria_through_event_id($user_id, $exchange_event_id) {
       
       $result = DB::table('listings_data')->join('listings_criteria', function ($join) use ($exchange_event_id, $user_id)  {
            $join->on('listings_data.listing_id', '=', 'listings_criteria.listing_id')
            ->where('listings_data.exchange_event_id', '=', $exchange_event_id)
            ->where('listings_data.user_id', '=', $user_id);
        })->select('listings_criteria.*')->get();

        if ($result) {
            return $result[0];
        } else {
            return false;
        }
    }
    
    /**
     * [prices_criteria
     * @param  [mixed] $user_id 
     * @return [mixed]          
     */
    public function prices_criteria($user_id) {
        $result = DB::table('listings_data')->join('listings_criteria', function ($join) use ($user_id){
            $join->on('listings_data.listing_id', '=', 'listings_criteria.listing_id')->where('listings_data.user_id', '=', $user_id);
        })->select('listings_criteria.*')->get();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function check_listing_exist($listing_id){
        $result = DB::table('listings_criteria')->where('listing_id' , $listing_id)->get();
        
        if($result){
            return true;
        }else{
            return false;
        }
    }
}
