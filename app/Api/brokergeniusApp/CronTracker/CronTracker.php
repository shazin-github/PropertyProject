<?php

namespace App\Api\brokergeniusApp\CronTracker;

use App\Api\Users\Users;
use App\Api\Helper\Helper;
use App\Api\brokergeniusApp\CronTracker\CronTrackerHandler;

class CronTracker
{

    protected $crontracker_handler;
    protected $user_id;
    protected $broker_key;
    protected $helper;
    protected $user;
    protected $response;

    function __construct(CronTrackerHandler $crontracker_handler, Users $user, Helper $helper)
    {
        $this->crontracker_handler = $crontracker_handler;
        $this->helper = $helper;
        $this->user = $user;
        $this->broker_key = $this->helper->get_header_key();
        $this->user_id = (string)$this->user->get_user_id($this->broker_key);
    }

    /**
     * Add/Update CronTracker
     * @param $filename
     * @return bool|int
     */
    public function crontracker($update_time){
        $user_id = $this->user_id;
        if($user_id) {
            $user_data = $this->crontracker_handler->get_user_crons($user_id);
            if($user_data){
                $user_data = $user_data[0];
                $inserted_data = $this->crontracker_handler->update_user_crons($user_data['_id'], $update_time);
                if($inserted_data) {
                    return true;
                }else{
                    return 404;
                }
            }else{
                    $inserted_data = $this->crontracker_handler->insert_user_crons($user_id,$update_time);
                    if($inserted_data){
                        return true;
                    }else{
                        return 404;
                    }
            }
        } else {
            return 401;
        }
    }

    /**
     * Get CronTrackers By UserID
     * @return array|bool|int
     */
    public function get_user_crontracker() {
        $user_id = $this->user_id;
        if($user_id) {
            return $this->crontracker_handler->get_user_crons($user_id);
        } else {
            return 404;
        }
    }

    /**
     * Get all CronTrackers
     * @return array|bool|int
     */
    public function get_all_crontracker() {
        $user_id = $this->user_id;
        if($user_id) {
            return $this->crontracker_handler->get_all_crons();
        } else {
            return 404;
        }
    }
}