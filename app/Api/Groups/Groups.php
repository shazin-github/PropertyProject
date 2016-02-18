<?php

namespace App\Api\Groups;

use App\Api\Groups\GroupsHandler;

class Groups{
    protected $handle_groups;
    //capture all requests from controller/routes here.
    //
    public function __construct(GroupsHandler $handle_groups){
        $this->handle_groups = $handle_groups;
    }

    /**
     * Get Tickets Price based on User ID
     * @param $user_id
     * @return mixed
     */
    public function get_prices($user_id){
        return $this->handle_groups->get_prices($user_id);
    }

    /**
     * Get Increment Type Based on Group ID
     * @param $group_id
     * @return mixed
     */
    public function get_anchor_increment($group_id){
        return $this->handle_groups->get_anchor_increment($group_id);
    }

    /**
     * Get Groups Based on UserID and EventID
     * @param $user_id
     * @param $event_id
     * @return mixed
     */
    public function get_user_groups($user_id, $event_id) {
        return $this->handle_groups->get_user_groups($user_id, $event_id);
    }

    /**
     * Get Group Detail By GroupID
     * @param $group_id
     * @return mixed
     */
    public function get_group_by_id($group_id) {
        return $this->handle_groups->get_group_by_id($group_id);
    }

    /**
     * Get Group Detail By GroupID (Duplicate Function)
     * @param $group_id
     * @return mixed
     */
    public function get_group_details($group_id) {
        return $this->handle_groups->get_group_details($group_id);
    }

    /**
     * Create New User Group
     * @param $user_id
     * @param $group_name
     * @param $criteria
     * @param $event_id
     * @param $tm_event_id
     * @param int $inc_type
     * @param int $inc_val
     * @param int $tix_start
     * @param $cp_start
     * @return integer GroupID
     */
    public function create_group($user_id, $group_name, $criteria, $event_id, $tm_event_id, $inc_type=0, $inc_val=0, $tix_start = 0, $cp_start) {
        return $this->handle_groups->create_group($user_id, $group_name, $criteria, $event_id, $tm_event_id, $inc_type, $inc_val, $tix_start, $cp_start);
    }

    /**
     * Check User Group based on UserID, EventID and GroupName
     * @param $user_id
     * @param $group_name
     * @param $event_id
     * @return mixed
     */
    public function chk_group_exist($user_id,$group_name,$event_id){
        return $this->handle_groups->chk_group_exist($user_id,$group_name,$event_id);
    }

    /**
     * Insert Group Listings
     * @param $group_id
     * @param $listing_id
     * @param $priorty
     * @return mixed
     */
    public function insert_listing_to_groups($group_id, $listing_id, $priorty) {
        return $this->handle_groups->insert_listing_to_groups($group_id, $listing_id, $priorty);
    }

    /**
     * Check Group Listings based on GroupID & ListingID
     * @param $group_id
     * @param $listing_id
     * @return bool
     */
    public function check_groups($group_id, $listing_id) {
        return $this->handle_groups->check_groups($group_id, $listing_id);
    }

    /*
     *
     * check_listings($listing_id), listing_info($listing_id), check_listing($user_id,$listing_id) ar similar
     * function with differnet names so they are renamed to get_listing_by_id($listing_id)
     *
     */

    /**
     * Get Listings based on ListingID
     * @param $listing_id
     * @return mixed
     */
    public function get_listing_by_id($listing_id) {
        return $this->handle_groups->get_listing_by_id($listing_id);
    }

    /**
     * Update Group Priorty By GroupID & ListingID
     * @param $group_id
     * @param $listing_id
     * @param $priorty
     * @return bool
     */
    public function update_group_priority($group_id, $listing_id, $priorty) {
        return $this->handle_groups->update_group_priority($group_id, $listing_id, $priorty);
    }

    /**
     * Update Group Increments By GroupID
     * @param $group_id
     * @param $increment_type
     * @param $increment_val
     * @return bool
     */
    public function update_group_increments($group_id, $increment_type, $increment_val) {
        return $this->handle_groups->update_group_increments($group_id, $increment_type, $increment_val);
    }

    /**
     * Update Group AutoBC by GroupID
     * @param $group_id
     * @param $auto_bc
     * @param $auto_bc_rank
     * @return bool
     */
    public function update_group_auto_bc($group_id, $auto_bc, $auto_bc_rank) {
        return $this->handle_groups->update_group_auto_bc($group_id, $auto_bc, $auto_bc_rank);
    }

    /**
     * Get Group Listing GroupID
     * @param $group_id
     * @return bool
     */
    public function get_group_listings($group_id) {
        return $this->handle_groups->get_group_listings($group_id);
    }

    /**
     * Get Group Listing Count
     * @param $group_id
     * @return bool|int
     */
    public function listing_count_for_group($group_id){
        return $this->handle_groups->listing_count_for_group($group_id);
    }

    /**
     * Get Groups Listing By EventID
     * @param $event_id
     * @return mixed
     */
    public function get_listing_by_event($event_id){
        return $this->handle_groups->get_listing_by_event($event_id);
    }

    /**
     * Delete All Listings from group
     * @param $group_id
     * @return bool
     */
    public function delete_listings_from_group($group_id){
        return $this->handle_groups->delete_listings_from_group($group_id);
    }

    /**
     * Delete Single Listing from group by ListingID
     * @param $group_id
     * @param $listing_id
     * @return bool
     */
    public function delete_single_listings_from_group($group_id, $listing_id){
        return $this->handle_groups->delete_single_listings_from_group($group_id, $listing_id);
    }

    /**
     * Delete Group
     * @param $group_id
     * @return bool
     */
    public function delete_group($group_id){
        return $this->handle_groups->delete_group($group_id);
    }

    /**
     * Update Group Name
     * @param $group_id
     * @param $group_name
     * @return bool
     */
    public function update_group_name($group_id, $group_name){
        return $this->handle_groups->update_group_name($group_id, $group_name);
    }

    /**
     * Update Group Criteria
     * @param $criteria
     * @param $group_id
     * @return bool
     */
    public function update_criteria_in_group($criteria, $group_id){
        return $this->handle_groups->update_criteria_in_group($criteria, $group_id);
    }

    /**
     * Get User Listing By UserID & TicketID
     * @param $user_id
     * @param $ticket_id
     * @return mixed
     */
    public function get_user_listing($user_id, $ticket_id){
        return $this->handle_groups->get_user_listing($user_id, $ticket_id);
    }

}

