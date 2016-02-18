<?php

namespace App\Api\UserExperience;

use Illuminate\Support\Facades\DB;

class UserExperienceHandler
{

    private $mongo_connection;
    private $userexperience_collection;

    function __construct()
    {
        $this->mongo_connection = 'mongoDB';
        $this->userexperience_collection = 'user_experience';
    }

    /**
     * Add User Experience
     * @param $userexperience_data
     * @return bool
     */
    public function add_userexperience($userexperience_data) {

        $result = DB::connection($this->mongo_connection)
            ->collection($this->userexperience_collection)
            ->insertGetId($userexperience_data);
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Get All User Experience
     * @return bool|array
     */
    public function get_userexperience() {

        $result = DB::connection($this->mongo_connection)
            ->collection($this->userexperience_collection)
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }


    /**
     * Get User Experience By UserID
     * @param $user_id
     * @return bool|array
     */
    public function get_userexperience_by_user($user_id) {

        $result = DB::connection($this->mongo_connection)
            ->collection($this->userexperience_collection)
            ->where('_id', '=', $user_id)
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }
}