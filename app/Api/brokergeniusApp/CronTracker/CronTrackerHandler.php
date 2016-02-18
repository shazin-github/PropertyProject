<?php

namespace App\Api\brokergeniusApp\CronTracker;

use Illuminate\Support\Facades\DB;

class CronTrackerHandler
{

    private $mongo_connection;
    private $crontracker_collection;

    function __construct()
    {
        $this->mongo_connection = 'mongoDB';
        $this->crontracker_collection = 'cron_tracker';
    }

    /**
     * Add New CronTracker
     * @param $user_id
     * @param $filename
     * @return bool
     */
    public function insert_user_crons($user_id, $update_time) {
        $result = DB::connection($this->mongo_connection)
            ->collection($this->crontracker_collection)
            ->insertGetId([
                '_id' => $user_id,
                'user_id' => $user_id,
                'update_time' => $update_time
            ]);
        if($result) {
            return $result;
        } else {
            return false;
        }
    }


    /**
     * Get CronTracker By UserID
     * @param $user_id
     * @return array|bool
     */
    public function get_user_crons($user_id) {

        $result = DB::connection($this->mongo_connection)
            ->collection($this->crontracker_collection)
            ->where("_id" , '=', $user_id)
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Get All CronTrackers
     * @return array|bool
     */
    public function get_all_crons()
    {

        $result = DB::connection($this->mongo_connection)
            ->collection($this->crontracker_collection)
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }

    }

    /**
     * Update CronTracker By UserID
     * @param $user_id
     * @param $filename
     * @return bool
     */
    public function update_user_crons($user_id, $update_time) {
        $result = DB::connection($this->mongo_connection)
            ->collection($this->crontracker_collection)
            ->where('user_id', '=', $user_id)
            ->update([
                'update_time' => $update_time
            ]);
        if($result) {
            return true;
        } else {
            return false;
        }
    }
}