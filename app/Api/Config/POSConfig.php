<?php

namespace App\Api\Config;

use App\Api\Users\Users;
use App\Api\Helper\Helper;
use App\Api\Config\ConfigHandler;

class POSConfig
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
     * Get POS By IP
     * @param $ip
     * @return array|bool|int
     */
    public function get_pos_by_ip($ip) {
        $user_id = $this->user_id;
        if ($user_id == '209') {
            return $this->config_handler->get_config_pos($ip);
        } else {
            return 404;
        }
    }

    /**
     * Get POS TU Users
     * @return array|bool|int
     */
    public function get_pos_tu() {

        $user_id = $this->user_id;
        if ($user_id == '209') {
            return $this->config_handler->get_config_users_tu();
        } else {
            return 404;
        }
    }

    /**
     * Get POS Users Seller IDs
     * @return array|int
     */
    public function get_pos_seller() {

        $user_id = $this->user_id;
        if ($user_id == '209') {
            $data = array();
            $vs_tu_users = $this->config_handler->get_config_users_vs_tu();
            $tu_users = $this->config_handler->get_config_users_tu();
            $data[] = $vs_tu_users;
            $data[] = $tu_users;
            $seller_ids = array();
            $counter = 0;
            foreach ($data as $value) {
                foreach ($value as $value1) {
                    $id = $value1["_id"];
                    $api = $value1["api_key"];

                    $seller_ids[$counter]["seller_id"] = $this->user->get_seller_id($id);
                    $seller_ids[$counter]["api_key"] = $api;
                    $counter++;
                }
            }

            return $seller_ids;
        } else {
            return 404;
        }
    }

    /**
     * Insert New POS Configuration
     * @param $pos_data
     * @return bool|int
     */
    public function save_pos($pos_data) {

        $user_id = $this->user_id;
        if ($user_id == '209') {
            return $this->config_handler->save_config_pos($pos_data);
        } else {
            return 404;
        }
    }

    /**
     * Append POS Configuration UserID
     * @param $ip
     * @param $scriptname
     * @param $user
     * @return int
     */
    public function append_pos_userid($ip, $scriptname, $user) {

        $user_id = $this->user_id;

        if ($user_id == '209') {
            return $this->config_handler->append_config_pos_userid($ip, $scriptname, $user);
        } else {
            return 404;
        }
    }

    /**
     * Update POS Configuration UserIDs
     * @param $ip
     * @param $scriptname
     * @param $user_ids
     * @return bool|int
     */
    public function update_pos_userids($ip, $scriptname, $user_ids) {

        $user_id = $this->user_id;

        if ($user_id == '209') {
            return $this->config_handler->update_config_pos_userid($ip, $scriptname, $user_ids);
        } else {
            return 404;
        }
    }

    /**
     * Update POS Configuration Status
     * @param $ip
     * @param $scriptname
     * @param $status
     * @return bool|int
     */
    public function update_pos_script_status($ip, $scriptname, $status) {

        $user_id = $this->user_id;

        if ($user_id == '209') {
            return $this->config_handler->update_config_pos_status($ip, $scriptname, $status);
        } else {
            return 404;
        }
    }
}