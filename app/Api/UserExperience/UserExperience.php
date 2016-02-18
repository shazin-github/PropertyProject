<?php

namespace App\Api\UserExperience;

use App\Api\Users\Users;
use App\Api\Helper\Helper;
use App\Api\UserExperience\UserExperienceHandler;
use App\Api\UserExperience\UserExperienceStatusHandler;

class UserExperience
{

    protected $userexperience_handler;
    protected $userexperience_status_handler;
    protected $user_id;
    protected $broker_key;
    protected $helper;
    protected $user;
    protected $response;
    protected $pos_name;

    function __construct(UserExperienceHandler $userexperience_handler, UserExperienceStatusHandler $userexperience_status_handler, Users $user, Helper $helper)
    {
        $this->userexperience_handler = $userexperience_handler;
        $this->userexperience_status_handler = $userexperience_status_handler;
        $this->helper = $helper;
        $this->user = $user;
        $this->broker_key = $this->helper->get_header_key();
        $this->user_id = (string)$this->user->get_user_id($this->broker_key);
    }

    /**
     * Add New UserExperience
     * @param $experience
     * @param $user
     * @return bool|int
     */
    public function add_userexperience($experience, $user) {

        $user_id = $this->user_id;
        if ($user_id) {
            $dataTOSend = array(
                "_id" => $user_id,
                "experience" => $experience,
                "user" => $user,
                "arrived" => time()
            );
            return $this->userexperience_handler->add_userexperience($dataTOSend);
        } else {
            return 404;
        }
    }

    /**
     * Get All UserExperience
     * @return array|bool|int
     */
    public function get_userexperience() {

        $user_id = $this->user_id;
        if($user_id) {
            return $this->userexperience_handler->get_userexperience();
        } else {
            return 404;
        }
    }

    /**
     * Get UserExperience Status By UserID
     * @return array|bool|int
     */
    public function get_userexperience_status() {

        $user_id = $this->user_id;
        if($user_id) {
            return $this->userexperience_status_handler->get_userexperience_status($user_id);
        } else {
            return 404;
        }
    }

    /**
     * Update UserExperience Status By UserID
     * @return bool|int
     */
    public function update_userexperience_status() {

        $user_id = $this->user_id;
        if($user_id) {
            $dataTOSend = array(
                "_id" => $user_id,
                "time" => time()
            );
            return $this->userexperience_status_handler->update_userexperience_status($user_id, $dataTOSend);
        } else {
            return 404;
        }
    }

    /**
     * Add New UserExperience Status
     * @return bool|int
     */
    public function add_userexperience_status() {

        $user_id = $this->user_id;
        if($user_id) {
            $dataTOSend = array(
                "_id" => $user_id,
                "time" => time()
            );
            return $this->userexperience_status_handler->add_userexperience_status($dataTOSend);
        } else {
            return 404;
        }
    }
}