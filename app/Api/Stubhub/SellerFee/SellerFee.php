<?php

namespace App\Api\Stubhub\SellerFee;

use App\Api\Users\Users;
use App\Api\Helper\Helper;
use App\Api\Stubhub\SellerFee\SellerFeeHandler;

class SellerFee
{

    protected $sellerfee_handler;
    protected $user_id;
    protected $broker_key;
    protected $helper;
    protected $user;
    protected $response;

    function __construct(SellerFeeHandler $sellerfee_handler, Users $user, Helper $helper)
    {
        $this->sellerfee_handler = $sellerfee_handler;
        $this->helper = $helper;
        $this->user = $user;
        $this->broker_key = $this->helper->get_header_key();
        $this->user_id = (string)$this->user->get_user_id($this->broker_key);
    }

    /**
     * Get SellerFee By EventID
     * @param $exchange_id
     * @param $event_id
     * @return array|bool|int
     */
    public function sellerfee_by_event($exchange_id, $event_id)
    {
        $user_id = $this->user_id;
        if($user_id) {
            if($this->helper->get_exchange($exchange_id)) {
                return $this->sellerfee_handler->get_sellerfee_by_event($event_id);
            } else {
                return 403;
            }
        } else {
            return 404;
        }
    }

    /**
     * Add New SellerFee
     * @param $exchange_id
     * @param $event_id
     * @param $buy_percentage
     * @param $delivery_fees
     * @return bool|int
     */
    public function add_sellerfee($exchange_id, $event_id, $buy_percentage, $delivery_fees)
    {
        $user_id = $this->user_id;
        if($user_id) {
            if($this->helper->get_exchange($exchange_id)) {
                return $this->sellerfee_handler->add_sellerfee($event_id, $buy_percentage, $delivery_fees);
            } else {
                return 403;
            }
        } else {
            return 404;
        }
    }

    /**
     * Delete SellerFee By EventID
     * @param $exchange_id
     * @param $event_id
     * @return bool|int
     */
    public function delete_sellerfee($exchange_id, $event_id)
    {
        $user_id = $this->user_id;
        if($user_id) {
            if($this->helper->get_exchange($exchange_id)) {
                return $this->sellerfee_handler->remove_sellerfee($event_id);
            } else {
                return 403;
            }
        } else {
            return 404;
        }
    }

    /**
     * Update SellerFee By EventID
     * @param $exchange_id
     * @param $event_id
     * @param $buy_percentage
     * @param $delivery_fees
     * @return bool|int
     */
    public function update_sellerfee($exchange_id, $event_id, $buy_percentage, $delivery_fees)
    {
        $user_id = $this->user_id;
        if($user_id) {
            if($this->helper->get_exchange($exchange_id)) {
                return $this->sellerfee_handler->update_sellerfee($event_id, $buy_percentage, $delivery_fees);
            } else {
                return 403;
            }
        } else {
            return 404;
        }
    }
}