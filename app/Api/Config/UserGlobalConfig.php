<?php

namespace App\Api\Config;

use App\Api\Users\Users;
use App\Api\Helper\Helper;
use App\Api\Config\ConfigHandler;

class UserGlobalConfig
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
     * Get User Global Configuration
     * @return bool|array
     */
    public function get_userglobal() {

        $data = $this->config_handler->get_config_userglobal('209');
        $data = $data[0];
        $user_id = $this->user_id;
        $user_name = $this->user->get_username_by_id($user_id);
        if($user_name){
            $data['user_name'] =  $user_name;
        }
        return $data;
    }

    /**
     * Save UserGlobal Configuration
     * @param $userglobal_data
     * @return bool|int
     */
    public function save_userglobal($userglobal_data) {

        $user_id = $this->user_id;

        if ($user_id == '209') {

            $request = array(
                "_id" => '209',
                "api_url_autopricer" => $userglobal_data['api_url_autopricer'],
                "api_url_event" => $userglobal_data['api_url_event'],
                "login_url" => $userglobal_data['login_url'],
                "stats_url" => $userglobal_data['stats_url'],
                "logs_url" => $userglobal_data['logs_url'],
                "api_url_group" => $userglobal_data['api_url_group'],
                "api_url_mass_op" => $userglobal_data['api_url_mass_op'],
                "profile_url" => $userglobal_data['profile_url'],
                "schedule_url" => $userglobal_data['schedule_url']
            );

            return $this->config_handler->save_config_userglobal($request);
            } else {
            return 404;
        }
    }
}