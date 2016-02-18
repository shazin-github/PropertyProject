<?php

namespace App\Api\UserExperience;

use Illuminate\Support\Facades\DB;

class UserExperienceStatusHandler
{

    private $mongo_connection;
    private $userexperience_status_collection;

    function __construct()
    {
        $this->mongo_connection = 'mongoDB';
        $this->userexperience_status_collection = 'user_experience_status';
    }

    /**
     * Add New UserExperience Status
     * @param $userexperience_status_data
     * @return bool
     */
    public function add_userexperience_status($userexperience_status_data) {

        $result = DB::connection($this->mongo_connection)
            ->collection($this->userexperience_status_collection)
            ->insertGetId($userexperience_status_data);
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Get UserExperience Status By UserID
     * @param $user_id
     * @return bool|array
     */
    public function get_userexperience_status($user_id) {

        $result = DB::connection($this->mongo_connection)
            ->collection($this->userexperience_status_collection)
            ->where('_id', '=', $user_id)
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Update UserExperience Status By UserID
     * @param $user_id
     * @param $userexperience_status_data
     * @return bool
     */
    public function update_userexperience_status($user_id, $userexperience_status_data) {

        $result = DB::connection($this->mongo_connection)
            ->collection($this->userexperience_status_collection)
            ->where('_id', '=', $user_id)
            ->update($userexperience_status_data);
        if($result) {
            return $result;
        } else {
            return false;
        }
    }
}