<?php

namespace App\Api\Config;

use Illuminate\Support\Facades\DB;

class ConfigHandler
{

    private $mongo_connection;
    private $config_global_collection;
    private $config_pos_collection;
    private $config_user_collection;
    private $config_userglobal_collection;

    function __construct()
    {
        $this->mongo_connection = 'mongoDB';
        $this->config_global_collection = 'global_config';
        $this->config_pos_collection = 'pos_config';
        $this->config_user_collection = 'user_config';
        $this->config_userglobal_collection = 'userglobal_config';
    }

    /*
     *
     * Start Global Configuration
     *
     */

    /**
     * Get Global Configuration By UserID
     * @param $user_id
     * @return bool|array
     */
    function get_config_global($user_id) {
        $result = DB::connection($this->mongo_connection)
            ->collection($this->config_global_collection)
            ->where("_id" , '=', $user_id)
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Insert New Global Configuration
     * @param $config_data
     * @return bool
     */
    function save_config_global($config_data) {
        $result = DB::connection($this->mongo_connection)
            ->collection($this->config_global_collection)
            ->insertGetId($config_data);
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Get Global Configuration Downloading Paths
     * @param $user_id
     * @return bool|array
     */
    function get_config_global_download($user_id) {

        $result = DB::connection($this->mongo_connection)
            ->collection($this->config_global_collection)
            ->select('downloading_paths')
            ->where('_id', '=', $user_id)
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Update Global Configuration Path By UserID
     * @param $user_id
     * @param $pathname
     * @param $url
     * @return bool
     */
    function update_config_global_path($user_id, $pathname, $url) {

        $result = DB::connection($this->mongo_connection)
            ->collection($this->config_global_collection)
            ->where('_id', '=', $user_id)
            ->update([
                "downloading_paths.".$pathname => $url
            ],array("upsert" => true));
        if($result) {
            return true;
        } else {
            return false;
        }
    }

    /*
     *
     * End Global Configuration
     *
     */

    /*
     *
     * Start User Configuration
     *
     */

    /**
     * Get All Users Configuartion
     * @return bool|array
     */
    function get_all_config_users(){

        $result = DB::connection($this->mongo_connection)
            ->collection($this->config_user_collection)
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Get VS & TU Users Configuration
     * @return bool
     */
    function get_config_users_vs_tu() {

        $result = DB::connection($this->mongo_connection)
            ->collection($this->config_user_collection)
            ->where('product_name', '=', 'pricegenius-vs')
            //->orWhere('product_name', '=', 'pricegenius-tu')
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Get VS AutoPricer Users Configuration
     * @return bool|array
     */
    function get_config_users_skybox_autopricer() {

        $result = DB::connection($this->mongo_connection)
            ->collection($this->config_user_collection)
            ->where('product_name', '=', 'pricegenius-vs')
            ->where('skybox_autopricing', '=', 'on')
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Get TU AutoPricer Users Configuration
     * @return bool|array
     */
    function get_config_users_tu_autopricer() {

        $result = DB::connection($this->mongo_connection)
            ->collection($this->config_user_collection)
            ->where('product_name', '=', 'pricegenius-tu')
            ->where('tu_autopricing', '=', 'on')
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Get Complete Service Users Configuration
     * @return bool|array
     */
    function get_config_users_fullservice() {

        $result = DB::connection($this->mongo_connection)
            ->collection($this->config_user_collection)
            ->where('product_name', '=', 'autopricer-tn')
            ->orWhere('tu_autopricing', '=', 'on')
            ->orWhere('product_name', '=', 'autopricer-tt')
            ->orWhere('product_name', '=', 'autopricer-ei')
            ->orWhere('skybox_autopricing', '=', 'on')
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Get AutoPricer Users Configuration
     * @return bool|array
     */
    function get_config_users_autopricer() {

        $result = DB::connection($this->mongo_connection)
            ->collection($this->config_user_collection)
            ->where('product_name', 'regex', new \MongoRegex("/^autopricer/i"))
            ->project(array('_id' => true))
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Get TU Users Configuration
     * @return bool|array
     */
    function get_config_users_tu() {

        $result = DB::connection($this->mongo_connection)
            ->collection($this->config_user_collection)
            ->where('product_name', '=', 'pricegenius-tu')
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Get User Configuration By API Key
     * @param $api_key
     * @return bool|array
     */
    function get_config_user($api_key) {

        $result = DB::connection($this->mongo_connection)
            ->collection($this->config_user_collection)
            ->where('api_key', '=', $api_key)
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Get User Configuration By UserID
     * @param $user_id
     * @return bool|array
     */
    function get_config_single_user($user_id) {

        $result = DB::connection($this->mongo_connection)
            ->collection($this->config_user_collection)
            ->where('_id', '=', $user_id)
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Insert New User Configuration
     * @param $user_data
     * @return bool
     */
    function save_config_user($user_data) {

        $result = DB::connection($this->mongo_connection)
            ->collection($this->config_user_collection)
            ->insertGetId($user_data);
        if($result) {
            return $result;
        } else {
            return false;
        }
    }


    /*
     *
     * End User Configuration
     *
     */

    /*
    *
    * Start POS Configuration
    *
    */

    /**
     * Get POS Configuration By ServerID
     * @param $server_id
     * @return bool|array
     */
    function get_config_pos($server_id) {
        $result = DB::connection($this->mongo_connection)
            ->collection($this->config_pos_collection)
            ->where('_id', '=', $server_id)
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Update POS Configuration Status
     * @param $ip
     * @param $script
     * @param $status
     * @return bool
     */
    function update_config_pos_status($ip, $script, $status) {

            $result = DB::connection($this->mongo_connection)
                ->collection($this->config_pos_collection)
                ->where('_id', '=', $ip)
                ->update([
                    $script.".script_process" => $status
                ]);
            if($result) {
                return true;
            } else {
                return false;
            }
    }

    /**
     * Update POS Configuration UserID By IP
     * @param $ip
     * @param $script
     * @param $id_array
     * @return bool
     */
    function update_config_pos_userid($ip, $script, $id_array) {

        $result = DB::connection($this->mongo_connection)
            ->collection($this->config_pos_collection)
            ->where('_id', '=', $ip)
            ->update([
                $script.".user_ids" => $id_array
            ]);
        if($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Append POS Configuration UserID By IP
     * @param $ip
     * @param $script
     * @param $user_id
     * @return bool
     */
    function append_config_pos_userid($ip, $script, $user_id) {
        $result = DB::connection($this->mongo_connection)
            ->collection($this->config_pos_collection)
            ->where('_id', '=', $ip)
            ->raw(array('$push' => array($script . '.user_ids' => array('$each'=>array($user_id)))));
        if($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Update POS Configuration DB Details By IP
     * @param $ip
     * @param $db_details
     * @return bool
     */
    function update_config_pos_dbdetails($ip, $db_details) {

        $result = DB::connection($this->mongo_connection)
            ->collection($this->config_pos_collection)
            ->where('_id', '=', $ip)
            ->update([
                'db_details' => $db_details
            ]);
        if($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete POS Configuration By IP
     * @param $ip
     * @return bool
     */
    function delete_config_pos($ip) {

        $result = DB::connection($this->mongo_connection)
            ->collection($this->config_pos_collection)
            ->where('_id', '=', $ip)
            ->delete();
        if($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Insert New POS Configuration
     * @param $pos_data
     * @return bool
     */
    function save_config_pos($pos_data) {

        $result = DB::connection($this->mongo_connection)
            ->collection($this->config_pos_collection)
            ->insertGetId($pos_data);
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /*
    *
    * End POS Configuration
    *
    */

    /*
    *
    * Start UserGlobal Configuration
    *
    */

    /**
     * Insert New UserGlobal Configuration
     * @param $userglobal_data
     * @return bool
     */
    function save_config_userglobal($userglobal_data) {

        $result = DB::connection($this->mongo_connection)
            ->collection($this->config_userglobal_collection)
            ->insertGetId($userglobal_data);
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Get UserGlobal Configuration By UserID
     * @param $user_id
     * @return bool
     */
    function get_config_userglobal($user_id) {

        $result = DB::connection($this->mongo_connection)
            ->collection($this->config_userglobal_collection)
            ->where('_id', '=', $user_id)
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /*
    *
    * End UserGlobal Configuration
    *
    */

    function get_sales_report_status($user_id) {

        $today = date("m/d/Y");
        $result = DB::table('gen_sales_report')
            ->where('generated', '=', false)
            ->where('requested_time', '=', $user_id)
            ->where('user_id', '=', 0)
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    function update_sales_report_status($user_id,$status_sales,$sales_file) {
        $today = date('m/d/Y');
        $time=time();
        $result = DB::table('gen_sales_report')
            ->where('generated', '=', false)
            ->where('requested_time', '=', $user_id)
            ->where('user_id', '=', 0)
            ->update([
                'generated' => 'true',
                'file_name' => $sales_file,
                'generated_time' => $time
            ]);
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function get_all_seller_ids() {

        $result = DB::table('seller_ids')
            ->select('seller_id', 'user_id')
            ->get();
        if($result) {
            foreach ($result as $ids) {
                $data[$ids['user_id']] = array('seller_id' => $ids['seller_id'], 'user_id' => $ids['user_id']);
            }
            return $data;
        } else {
            return false;
        }
    }

    function update_status($user_id) {

        $result = DB::table('userdetails')
            ->where('user_id', $user_id)
            ->get();
        if(count($result) == 1) {
            $update_date = $result[0]['app_update_date'];
            return $update_date;
        } else {
            return false;
        }
    }

    /*function marketdata_config_get($server_id) {
        try {
            $connection = new MongoClient();
            $database = $connection->Config_library;
            $collection = $database->user_config;
        }
        catch (MongoConnectionException $e) {
            die("Failed to connect to database " . $e->getMessage());
        }
        $data = array();
        $cursor = $collection->find(array('_id' => $server_id));
        while ($cursor->hasNext()) {
            $single_object = $cursor->getNext();
            $data[] = $single_object;

        }
        return json_encode($data);
    }

    function marketdata_config_save($raw_request) {
        try {
            $connection = new MongoClient();
            $database = $connection->Config_library;
            $collection = $database->market_config;
            $request = json_decode($raw_request, true);

            if ($collection->save($request)) {
                return true;
            }
        }
        catch (MongoConnectionException $e) {
            die("Failed to connect to database " . $e->getMessage());
        }
        catch (MongoException $e) {
            die('Failed to insert data ' . $e->getMessage());
        }
    }*/
}