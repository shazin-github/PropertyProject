<?php

namespace App\Api\UserExperience;

use App\Api\Users\Users;
use App\Api\Helper\Helper;
use App\Api\UserExperience\UserExperienceHandler;

class UserExperience
{

    protected $userexperience_handler;
    protected $user_id;
    protected $broker_key;
    protected $helper;
    protected $user;
    protected $response;
    protected $pos_name;

    function __construct(UserExperienceHandler $userexperience_handler, Users $user, Helper $helper)
    {
        $this->userexperience_handler = $userexperience_handler;
        $this->helper = $helper;
        $this->user = $user;
        $this->broker_key = $this->helper->get_header_key();
        $this->user_id = (string)$this->user->get_user_id($this->broker_key);
    }
}