<?php

namespace App\Api\Config;

use App\Api\Users\Users;
use App\Api\Helper\Helper;
use App\Api\Config\ConfigHandler;
use \GuzzleHttp\Client;

class Config
{

    protected $config_handler;
    protected $user_id;
    protected $broker_key;
    protected $helper;
    protected $user;
    protected $response;
    protected $guzzle;

    function __construct(ConfigHandler $config_handler, Users $user, Helper $helper, Client $guzzle)
    {
        $this->config_handler = $config_handler;
        $this->helper = $helper;
        $this->user = $user;
        $this->broker_key = $this->helper->get_header_key();
        $this->user_id = (string)$this->user->get_user_id($this->broker_key);
        $this->guzzle = $guzzle;
    }

    public function get_sales_report_status() {

        $user_id =$this->user_id;
        if ($user_id) {
            return $this->config_handler->get_sales_report_status($user_id);
        } else {
            return 404;
        }
    }

    public function update_sales_report_status($change_status, $file_name) {

        $user_id = $this->user_id;
        if ($user_id) {
            return $this->config_handler->update_sales_report_status($user_id, $change_status, $file_name);
        } else {
            return 404;
        }
    }

    public function get_config_cronjobs() {

        $user_id = $this->user_id;

        if ($user_id) {
            $url = "https://brokergenius.com/index.php/v1/configurations/Userconfig";
            $header = array('Broker-Key' => $this->broker_key);
            $res = $this->guzzle->request('GET', $url, [
                'headers' => $header
            ]);
            $data = $res->getBody(true);

            $product_name = $data[0]['product_name'];
            $configs = '';
            $login_token_time = ($user_id == "318") ? '900000' : '600000';
            $login_token_time = ($user_id == "330") ? '300000' : '600000';
            $login_token_time = ($user_id == "208") ? '2700000' : '600000';
            if ($product_name == "autopricer-tn" || $product_name == "autopricer-tt" || $product_name == "autopricer-ei") {
                $configs = '{
                "app_name": "autopricer",
                "tray": {
                    "title": "Brokergenius Server"
                },

                "cron_jobs":  [{
                        "url": "unsync_price_tracker.php",
                        "time": 900000
                    }, {
                        "url": "code_update.php",
                        "time": 900000
                    }, {
                        "url": "login_token.php",
                        "time": ' . $login_token_time . '
                    }, {
                        "url": "calculate_group_price.php",
                        "time": 900000
                    }, {
                        "url": "force_changes.php",
                        "time": 900000
                    }, {
                        "url": "price_changes.php",
                        "time": 900000
                    }, {
                        "url": "listing_status.php",
                        "time": 3600000
                    }, {
                        "url": "generate_sales.php",
                        "time": 900000
                    }
                    , {
                        "url": "calc_group_auto.php",
                        "time": 900000
                    }
                    , {
                        "url": "calc_group_manual.php",
                        "time": 900000
                    }
                    ]
            }
            ';
            } else {
                $configs = '
               {
                "app_name": "pricegenius",
                "tray": {
                    "title": "Brokergenius Server"
                },

                "cron_jobs":  [{
                        "url": "unsync_price_tracker.php",
                        "time": 900000
                    }, {
                        "url": "code_update.php",
                        "time": 900000
                    }, {
                        "url": "login_token.php",
                        "time": ' . $login_token_time . '
                    }, {
                        "url": "listing_status.php",
                        "time": 3600000
                    }, {
                        "url": "generate_sales.php",
                        "time": 900000
                    }]
              }
            ';
            }
            return $configs;
        } else {
            return 404;
        }
    }

    public function get_sellerids() {

        $user_id = $this->user_id;

        if ($user_id == '209') {
            return $seller_ids = $this->config_handler->get_all_seller_ids();
        } else {
            return 404;
        }
    }

    public function get_sellerfee($event_id) {

        $user_id = $this->user_id;

        if ($user_id == '209') {
            $url = "http://lotaovh2.brokergenius.com/Brokergenius_misc/fixSellerFee/".$event_id."/true" ;
            $res = $this->guzzle->request('GET', $url);
            $data = $res->getBody(true);
            return $data;
        } else {
            $this->response(array('error' => 'You are not authorized'), 401);
        }
    }

    function app_get() {
        $file_path = "https://brokergenius.com/app/latest.php";

        $user_id = $this->user_id;

        $update_date = $this->config_handler->update_status($user_id);
        
        if($update_date)
            $data = array('updated' => true, 'updated_date' => date("d F Y", $update_date));
        else
            $data = array('updated' => false, "file_path" => $file_path);
        return $data;
    }
}