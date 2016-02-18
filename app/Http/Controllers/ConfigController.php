<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Api\Config\GlobalConfig;
use App\Api\Config\UserGlobalConfig;
use App\Api\Config\POSConfig;
use App\Api\Config\UserConfig;
use App\Api\Config\Config;
Use App\Api\Response\Response;
use \Validator;

class ConfigController extends Controller
{
    protected $global_config;
    protected $userglobal_config;
    protected $pos_config;
    protected $user_config;
    protected $config;
    protected $request;
    protected $response;

    public function __construct(GlobalConfig $global_config, UserGlobalConfig $userglobal_config,
                                POSConfig $pos_config, UserConfig $user_config,
                                Config $config, Request $request, Response $response)
    {
        $this->global_config = $global_config;
        $this->userglobal_config = $userglobal_config;
        $this->pos_config = $pos_config;
        $this->user_config = $user_config;
        $this->config = $config;
        $this->request = $request;
        $this->response = $response;
    }

    public function save_global() {
        $config_global = $this->global_config->save_global();
        if($config_global === 404){
            return $this->response->not_found('User not found');
        } else {
            return $this->response->success($config_global);
        }
    }

    public function get_global() {
        $config_global = $this->global_config->get_global();
        if($config_global === 404){
            return $this->response->not_found('User not found');
        } else {
            return $this->response->success($config_global);
        }
    }

    public function get_global_downloads() {
        $config_global = $this->global_config->get_global_downloads();
        if($config_global === 404){
            return $this->response->not_found('User not found');
        } else {
            return $this->response->success($config_global);
        }
    }

    public function save_userglobal() {
        $userglobal_data = $this->request->all();
        $config_userglobal = $this->userglobal_config->save_userglobal($userglobal_data);
        if($config_userglobal === 404){
            return $this->response->not_found('User not found');
        } else {
            return $this->response->success($config_userglobal);
        }
    }

    public function get_userglobal() {
        $config_userglobal = $this->userglobal_config->get_userglobal();
        if($config_userglobal === 404){
            return $this->response->not_found('User not found');
        } else {
            return $this->response->success($config_userglobal);
        }
    }

    public function get_pos_by_ip() {

        $validator = Validator::make($this->request->all(),[
            'ip' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }

            $ip = $this->request->input('ip');
            $config_pricecal = $this->pos_config->get_pos_by_ip($ip);
            if($config_pricecal === 404){
                return $this->response->not_found('User not found');
            } else {
                return $this->response->success($config_pricecal);
            }
    }

    public function get_pos_tu() {
        $config_pricecal = $this->pos_config->get_pos_tu();
        if($config_pricecal === 404){
            return $this->response->not_found('User not found');
        } else {
            return $this->response->success($config_pricecal);
        }
    }

    public function get_pos_seller() {
        $config_pricecal = $this->pos_config->get_pos_seller();
        if($config_pricecal === 404){
            return $this->response->not_found('User not found');
        } else {
            return $this->response->success($config_pricecal);
        }
    }

    public function save_pos() {
        $pos_data = $this->request->all();
        $config_pricecal = $this->pos_config->save_pos($pos_data);
        if($config_pricecal === 404){
            return $this->response->not_found('User not found');
        } else {
            return $this->response->success($config_pricecal);
        }
    }

    public function append_pos_userid() {
        $validator = Validator::make($this->request->all(),[
            'ip' => 'required',
            'scriptname' => 'required',
            'user_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }
            $ip = $this->request->input('ip');
            $scriptname = $this->request->input('scriptname');
            $user = $this->request->input('user_id');
            $config_pricecal = $this->pos_config->append_pos_userid($ip, $scriptname, $user);
            if($config_pricecal === 404){
                return $this->response->not_found('User not found');
            } else {
                return $this->response->success($config_pricecal);
            }
    }

    public function update_pos_userids() {

        $validator = Validator::make($this->request->all(),[
            'ip' => 'required',
            'scriptname' => 'required',
            'user_ids' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }

            $ip = $this->request->input('ip');
            $scriptname = $this->request->input('scriptname');
            $user_ids = $this->request->input('user_ids');
            $config_pricecal = $this->pos_config->update_pos_userids($ip, $scriptname, $user_ids);
            if($config_pricecal === 404){
                return $this->response->not_found('User not found');
            } else {
                return $this->response->success($config_pricecal);
            }
    }

    public function update_pos_script_status() {

        $validator = Validator::make($this->request->all(),[
            'ip' => 'required',
            'scriptname' => 'required',
            'status' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }

            $ip = $this->request->input('ip');
            $scriptname = $this->request->input('scriptname');
            $status = $this->request->input('status');
            $config_pricecal = $this->pos_config->update_pos_script_status($ip, $scriptname, $status);
            if($config_pricecal === 404){
                return $this->response->not_found('User not found');
            } else {
                return $this->response->success($config_pricecal);
            }
    }

    public function get_users_vs_tu() {
        $config_users = $this->user_config->get_users_vs_tu();
        if($config_users === 404){
            return $this->response->not_found('User not found');
        } else {
            return $this->response->success($config_users);
        }
    }

    public function get_users_skybox_autopricer() {
        $config_users = $this->user_config->get_users_skybox_autopricer();
        if($config_users === 404){
            return $this->response->not_found('User not found');
        } else {
            return $this->response->success($config_users);
        }
    }

    public function get_users_autopricer() {
        $config_users = $this->user_config->get_users_autopricer();
        if($config_users === 404){
            return $this->response->not_found('User not found');
        } else {
            return $this->response->success($config_users);
        }
    }

    public function get_users_tu_autopricer() {
        $config_users = $this->user_config->get_users_tu_autopricer();
        if($config_users === 404){
            return $this->response->not_found('User not found');
        } else {
            return $this->response->success($config_users);
        }
    }

    public function get_users() {
        $config_users = $this->user_config->get_users();
        if($config_users === 404){
            return $this->response->not_found('User not found');
        } else {
            return $this->response->success($config_users);
        }
    }
    public function save_users() {
        $user_data = $this->request->all();
        $config_users = $this->user_config->save_users($user_data);
        if($config_users === 404){
            return $this->response->not_found('User not found');
        } else {
            return $this->response->success($config_users);
        }
    }
    public function get_users_all() {
        $config_users = $this->user_config->get_users_all();
        if($config_users === 404){
            return $this->response->not_found('User not found');
        } else {
            return $this->response->success($config_users);
        }
    }
    public function get_users_full_service() {
        $config_users = $this->user_config->get_users_full_service();
        if($config_users === 404){
            return $this->response->not_found('User not found');
        } else {
            return $this->response->success($config_users);
        }
    }

    public function get_sales_report_status() {
        $sales_report = $this->config->get_sales_report_status();
        if($sales_report === 404){
            return $this->response->not_found('User not found');
        } else {
            return $this->response->success($sales_report);
        }
    }

    public function update_sales_report_status() {
        if($this->request->has('change_status') && $this->request->has('file_name')) {
            $change_status = $this->request->input('change_status');
            $file_name = $this->request->input('file_name');
            $sales_report = $this->config->update_sales_report_status($change_status, $file_name);
            if($sales_report === 404){
                return $this->response->not_found('User not found');
            } else {
                return $this->response->success($sales_report);
            }
        } else {
            return $this->response->forbidden('Request Paramaters are incorrect');
        }
    }

    public function get_config_cronjobs() {
        $config_cron = $this->config->get_config_cronjobs();
        if($config_cron === 404){
            return $this->response->not_found('User not found');
        } else {
            return $this->response->success($config_cron);
        }
    }

    public function get_sellerids() {
        $seller_ids = $this->config->get_sellerids();
        if($seller_ids === 404){
            return $this->response->not_found('User not found');
        } else {
            return $this->response->success($seller_ids);
        }
    }

    public function get_sellerfee() {
        if($this->request->has('event_id')) {
            $event_id = $this->request->input('event_id');
            $seller_fee = $this->config->get_sellerfee($event_id);
            if($seller_fee === 404){
                return $this->response->not_found('User not found');
            } else {
                return $this->response->success($seller_fee);
            }
        } else {
            return $this->response->forbidden('Request Paramaters are incorrect');
        }
    }

    public function app_get() {
        $data = $this->config->app_get();
        if($data === 404){
            return $this->response->not_found('User not found');
        } else {
            return $this->response->success($data);
        }
    }
}