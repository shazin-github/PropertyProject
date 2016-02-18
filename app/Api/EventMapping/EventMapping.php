<?php

namespace App\Api\EventMapping;

use App\Api\Users\Users;
use App\Api\Helper\Helper;
use App\Api\EventMapping\EventMapping;

class EventMapping
{

    protected $event_mapping_handler;
    protected $user_id;
    protected $broker_key;
    protected $helper;
    protected $user;
    protected $response;
    protected $guzzle;

    function __construct(EventMapping $event_mapping_handler, Users $user, Helper $helper)
    {
        $this->event_mapping_handler = $event_mapping_handler;
        $this->helper = $helper;
        $this->user = $user;
        $this->broker_key = $this->helper->get_header_key();
        $this->user_id = (string)$this->user->get_user_id($this->broker_key);
    }
}