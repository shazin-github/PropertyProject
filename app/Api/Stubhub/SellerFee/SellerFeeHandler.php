<?php

namespace App\Api\Stubhub\SellerFee;

use Illuminate\Support\Facades\DB;

class SellerFeeHandler
{

    private $mongo_connection;
    private $sellerfee_collection;

    function __construct()
    {
        $this->mongo_connection = 'mongoDB';
        $this->sellerfee_collection = 'stubhub_sellerfee';
    }

    /**
     * Get SellerFee By EventID
     * @param $event_id
     * @return bool|array
     */
    public function get_sellerfee_by_event($event_id)
    {
        $result = DB::connection($this->mongo_connection)
            ->collection($this->sellerfee_collection)
            ->where("exchange_event_id" , $event_id)
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Add New SellerFee
     * @param $event_id
     * @param $buy_percentage
     * @param $delivery_fees
     * @return bool
     */
    public function add_sellerfee($event_id, $buy_percentage, $delivery_fees)
    {
        $result = DB::connection($this->mongo_connection)
            ->collection($this->sellerfee_collection)
            ->where('_id' , '=', $event_id)
            ->update([
                'exchange_event_id' => $event_id,
                'buy_percentage' => $buy_percentage,
                'delivery_fees' => $delivery_fees
            ], array('upsert' => true));
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Delete SellerFee By Event ID
     * @param $event_id
     * @return bool
     */
    public function remove_sellerfee($event_id)
    {
         $result = DB::connection($this->mongo_connection)
                ->collection($this->sellerfee_collection)
                ->where('exchange_event_id', '=', $event_id)
                ->delete();
        if($result) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Update SellerFee By EventID
     * @param $event_id
     * @param $buy_percentage
     * @param $delivery_fees
     * @return bool
     */
    public function update_sellerfee($event_id, $buy_percentage, $delivery_fees)
    {
        $check = $result = DB::connection($this->mongo_connection)
            ->collection($this->sellerfee_collection)
            ->where('exchange_event_id', '=', $event_id)
            ->get();
        if($check) {
            $result = DB::connection($this->mongo_connection)
                ->collection($this->sellerfee_collection)
                ->where('exchange_event_id', '=', $event_id)
                ->update([
                    'buy_percentage' => $buy_percentage,
                    'delivery_fees' => $delivery_fees
                ]);
            if ($result) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}