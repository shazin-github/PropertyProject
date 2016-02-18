<?php

namespace App\Api\Stubhub\ExchangeMapping;

use Illuminate\Support\Facades\DB;

class ExchangeMappingHandler
{

    private $mongo_connection;
    private $exchangemapping_collection;

    function __construct()
    {
        $this->mongo_connection = 'mongoDB';
        $this->exchangemapping_collection = 'exchange_mapping';
    }

    /**
     * Add New Exchange Event
     * @param $exchange_event
     * @return bool
     */
    function insert_exchange_event($exchange_event) {
        $result = DB::connection($this->mongo_connection)
            ->collection($this->exchangemapping_collection)
            ->insertGetId($exchange_event);
        if($result) {
            return $result;
        } else {
            return false;
        }
    }


    /**
     * Update Exchange Event By ID
     * @param $id
     * @param $exchange_event
     * @return bool
     */
    public function update_exchange_event($id, $exchange_event) {
        $result = DB::connection($this->mongo_connection)
            ->collection($this->exchangemapping_collection)
            ->where('_id', '=', $id)
            ->update($exchange_event);
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Update Exchange Event ID
     * @param $id
     * @param $exchange_event_id
     * @return bool
     */
    function update_exchange_event_id($id, $exchange_event_id) {

        $check = DB::connection($this->mongo_connection)
            ->collection($this->exchangemapping_collection)
            ->where('_id', '=', $id)
            ->get();
        if($check) {
        $result = DB::connection($this->mongo_connection)
            ->collection($this->exchangemapping_collection)
            ->where('_id', '=', $id)
            ->update([
                'exchange_event_id' => $exchange_event_id
            ]);
        if($result) {
            return $result;
        } else {
            return false;
        }
        } else {
            return false;
        }
    }

    /**
     * Update Exchange Event Status By ID
     * @param $id
     * @param $approve_status
     * @return bool
     */
    function update_exchange_event_status($id, $approve_status) {

        $check = DB::connection($this->mongo_connection)
            ->collection($this->exchangemapping_collection)
            ->where('_id', '=', $id)
            ->get();
        if($check) {
        $result = DB::connection($this->mongo_connection)
            ->collection($this->exchangemapping_collection)
            ->where('_id', '=', $id)
            ->update([
                'approve_status' => $approve_status
            ]);
        if($result) {
            return $result;
        } else {
            return false;
        }
        } else {
            return false;
        }
    }

    /**
     * Get Exchange Event By ExchangeID & LocalEvent ID
     * @param $exchange_id
     * @param $local_event_id
     * @return bool
     */
    function get_exchange_event($exchange_id, $local_event_id) {
        $result = DB::connection($this->mongo_connection)
            ->collection($this->exchangemapping_collection)
            ->where("local_event_id" , $local_event_id)
            ->where("exchange_id" , intval($exchange_id))
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Get Exchange Event By POS Name & LocalEvent ID
     * @param $local_event_id
     * @param $pos_name
     * @return bool
     */
    function get_exchange_event_by_pos($local_event_id, $pos_name) {
        $result = DB::connection($this->mongo_connection)
            ->collection($this->exchangemapping_collection)
            ->where("local_event_id" , $local_event_id)
            ->where("pos_name" , $pos_name)
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Get Exchange Event By Approve Status
     * @param $approve_status
     * @return bool
     */
    function get_exchange_event_by_status($approve_status) {
        $result = DB::connection($this->mongo_connection)
            ->collection($this->exchangemapping_collection)
            ->where("approve_status" , $approve_status)
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }
}