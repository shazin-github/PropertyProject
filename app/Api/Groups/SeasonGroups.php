<?php

namespace App\Api\Groups;

use App\Api\Groups\SeasonGroupsHandler;

class SeasonGroups
{
    protected $group_handler;
    //capture all requests from controller/routes here.
    //
    public function __construct(SeasonGroupsHandler $group_handler)
    {
        $this->group_handler = $group_handler;
    }

    /**
     * Get Season Group
     * @param array $season_group_data  [exchange_event_id, group_name, group_type]
     * @return mixed
     */
    public function get_season_group($season_group_data){
        $result = $this->group_handler->get_season_group($season_group_data);
        if($result){
            return $result;
        }
        else{
            return false;
        }
    }
    /**
     * Save Season Group
     * @param array $season_group_data  [exchange_event_id, group_name, group_type, user_id, group_id]
     * @return mixed    Season Group ID| FALSE
     */
    public function save_group_season($season_group_data){
        $result = $this->group_handler->save_group_season($season_group_data);
         if($result){
            return $result;
        }
        else{
            return false;
        }
    }

    /**
     * Delete Season Group
     * @param $group_id
     * @return bool
     */
    public function delete_season_group($group_id) {
        $result = $this->group_handler->delete_season_group($group_id) ;
         if($result){
            return TRUE;
        }
        else{
            return false;
        }
    }
}