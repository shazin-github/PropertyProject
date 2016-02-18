<?php

namespace App\Api\Config;

use App\Api\Users\Users;
use App\Api\Helper\Helper;
use App\Api\Config\ConfigHandler;

class UserConfig
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
     * Get Users Configuration VS & TU
     * @return bool|int
     */
    public function get_users_vs_tu() {

        $user_id = $this->user_id;
        if ($user_id == '209') {
            return $this->config_handler->get_config_users_vs_tu();
        } else {
            return 404;
        }
    }

    /**
     * Get SkyBox AutoPricer Users Configuration
     * @return array|bool|int
     */
    public function get_users_skybox_autopricer() {

        $user_id = $this->user_id;
        if ($user_id == '209') {
            return $this->config_handler->get_config_users_skybox_autopricer();
        } else {
            return 404;
        }
    }

    /**
     * Get AutoPricer Users Configuration
     * @return array|bool|int
     */
    public function get_users_autopricer() {

        $user_id = $this->user_id;
        if ($user_id == '209') {
            return $this->config_handler->get_config_users_autopricer();
        } else {
            return 404;
        }
    }

    /**
     * Get TU AutoPricer Users COnfiguration
     * @return array|bool|int
     */
    public function get_users_tu_autopricer() {

        $user_id = $this->user_id;
        if ($user_id == '209') {
            return $this->config_handler->get_config_users_tu_autopricer();
        } else {
            return 404;
        }
    }

    /**
     * Get Users By Broker Key
     * @return array|bool|int
     */
    public function get_users() {

        $user_id = $this->user_id;
        if ($user_id == '209') {
            return $this->config_handler->get_config_user($this->broker_key);
        } else {
            return 404;
        }
    }

    /**
     * Save New User Data
     * @param $user_data
     * @return bool|int
     */
    public function save_users($user_data) {

        $user_id = $this->user_id;
        if ($user_id == '209') {
            return $this->config_handler->save_config_user($user_data);
        } else {
            return 404;
        }
    }

    /**
     * Get All Users Configuration
     * @return array|bool
     */
    public function get_users_all()
    {
        return $this->config_handler->get_all_config_users();
    }

    /**
     * Get Full Service Users Configuration
     * @return array
     */
    public function get_users_full_service()
    {
        $data = $this->config_handler->get_config_users_fullservice();
        $ids = array();
        foreach ($data as $key => $user) {
            $ids[] = $user['_id'];
        }
        return $ids;
    }
}