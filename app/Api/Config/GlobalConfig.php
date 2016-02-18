<?php

namespace App\Api\Config;

use App\Api\Users\Users;
use App\Api\Helper\Helper;
use App\Api\Config\ConfigHandler;

class GlobalConfig
{

    protected $config_handler;
    protected $user_id;
    protected $broker_key;
    protected $helper;
    protected $user;
    protected $response;

    function __construct(ConfigHandler $config_handler, Users $user, Helper $helper)
    {
        $this->config_handler = $config_handler;
        $this->helper = $helper;
        $this->user = $user;
        $this->broker_key = $this->helper->get_header_key();
        $this->user_id = (string)$this->user->get_user_id($this->broker_key);
    }

    /**
     * Save Globals
     * @return bool|int
     */
    public function save_global() {
        $user_id = $this->user_id;
        if ($user_id == '209') {

            $raw_request = array(
                              "_id" => "210",
                              "db_details" => [
                                              "server_ip" => "db.brokergenius.com",
                                              "username"=> "bd_pos",
                                              "pass"=> "Tixonomy16",
                                              "db"=> "bd_new"
                                            ],
                                "downloading_paths"=>[
                                    "sajan1" => "http://168.144.187.26/~sajan1/data/events.zip",
                                    "data1" => "http://50.31.1.37/~data1/data/events.zip",
                                    "price6" => "https://s3.amazonaws.com/user_listing_data/events.zip",
                                    "data2"=> "http://68.169.50.71/~data2/data/events.zip",
                                    "lota" => "http://199.229.255.128/~lota/data/events.zip",
                                    "lotahop"=> "http://198.20.91.179/~lotahop/data/events.zip"
                                ]
        );
            return $this->config_handler->save_config_global($raw_request);
        } else {
            return 404;
        }
    }

    /**
     * Get All Globals
     * @return array|bool|int
     */
    public function get_global() {
        $user_id = $this->user_id;
        if ($user_id == '209') {
            return $this->config_handler->get_config_global($user_id);
        } else {
            return 404;
        }
    }

    /**
     * Get Global Downloads
     * @return array|bool|int
     */
    public function get_global_downloads() {

        $user_id = $this->user_id;
        if ($user_id == '209') {
            return $this->config_handler->get_config_global_download($user_id);
        } else {
            return 404;
        }
    }
}