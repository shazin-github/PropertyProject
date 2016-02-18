<?php

namespace App\Api\Groups;

use App\Api\Groups\GroupsHandler;

class VerifyGroups
{
    protected $handle_groups;
    //capture all requests from controller/routes here.
    //
    public function __construct(GroupsHandler $handle_groups)
    {
        $this->handle_groups = $handle_groups;
    }

    /**
     * Get GroupID By ListingID & GroupType
     * @param $listing_id
     * @param $group_type
     * @return mixed
     */
    public function get_group_id($listing_id, $group_type){
        return $this->handle_groups->get_group_id($listing_id, $group_type);
    }

    /**
     * Get Group Detail By GroupID, GroupType, UserID
     * @param $group_id
     * @param $group_type
     * @param $user_id
     * @return mixed
     */
    public function get_group_data($group_id, $group_type, $user_id){
        return $this->handle_groups->get_group_data($group_id, $group_type, $user_id);
    }
}