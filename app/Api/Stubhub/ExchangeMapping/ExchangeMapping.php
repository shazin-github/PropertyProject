<?php

namespace App\Api\Stubhub\ExchangeMapping;

use App\Api\Users\Users;
use App\Api\Helper\Helper;
use App\Api\Stubhub\ExchangeMapping\ExchangeMappingHandler;

class ExchangeMapping
{

    protected $exchangemapping_handler;
    protected $user_id;
    protected $broker_key;
    protected $helper;
    protected $user;
    protected $response;

    function __construct(ExchangeMappingHandler $exchangemapping_handler, Users $user, Helper $helper)
    {
        $this->exchangemapping_handler = $exchangemapping_handler;
        $this->helper = $helper;
        $this->user = $user;
        $this->broker_key = $this->helper->get_header_key();
        $this->user_id = (string)$this->user->get_user_id($this->broker_key);
    }

    /**
     * Add New Exchange Event
     * @param $exchange_id
     * @param $exchange_event_data
     * @return bool|int
     */
    function save_exchange_event($exchange_id, $exchange_event_data) {
        $user_id = $this->user_id;
        if($user_id) {
            if($this->helper->get_exchange($exchange_id)) {
                $data = [
                    'event_name' => $exchange_event_data['event_name'],
                    'event_date' => $exchange_event_data['event_date'],
                    'event_time' => $exchange_event_data['event_time'],
                    'event_timestamp' => $exchange_event_data['event_timestamp'],
                    'venue_name' => $exchange_event_data['venue_name'],
                    'pos_name' => $exchange_event_data['pos_name'],
                    'local_event_id' => $exchange_event_data['local_event_id'],
                    'source' => $exchange_event_data['source'],
                    'approve_status' => $exchange_event_data['approve_status'],
                    'exchange_id' => $exchange_id
                ];
                $data['exchange_event_id'] = ($data['approve_status'] == false) ? "" : $exchange_event_data['exchange_event_id'];
                $data['user'] = ($exchange_event_data['acc_type'] == "pricer") ? $exchange_event_data['user'] : $user_id;

                $old_event_data = $this->exchangemapping_handler->get_exchange_event_by_pos($data['local_event_id'], $data['pos_name']);
                if ($old_event_data) {

                    $old_event_data = $old_event_data[0];
                    $id = $old_event_data['_id'];

                    $approved = (isset($old_event_data['approved'])) ? $old_event_data['approved'] : false;

                    if ($approved == false) {
                        return $this->exchangemapping_handler->update_exchange_event($id, $data);
                    }
                }
                else {
                    return $this->exchangemapping_handler->insert_exchange_event($data);
                }
            } else {
                return 403;
            }
        } else {
            return 404;
        }
    }

    /**
     * Update Exchange Event ID
     * @param $exchange_id
     * @param $id
     * @param $exchange_event_id
     * @return bool|int
     */
    function update_exchange_event_id($exchange_id, $id, $exchange_event_id) {
        $user_id = $this->user_id;
        if($user_id) {
            if($this->helper->get_exchange($exchange_id)) {
                return $this->exchangemapping_handler->update_exchange_event_id($id, $exchange_event_id);
            } else {
                return 403;
            }
        } else {
            return 404;
        }
    }

    /**
     * Update Exchange Event Status By ID
     * @param $exchange_id
     * @param $id
     * @param $approve_status
     * @return bool|int
     */
    function update_exchange_event_status($exchange_id, $id, $approve_status) {
        $user_id = $this->user_id;
        if($user_id) {
            if($this->helper->get_exchange($exchange_id)) {
                return $this->exchangemapping_handler->update_exchange_event_status($id, $approve_status);
            } else {
                return 403;
            }
        } else {
            return 404;
        }
    }

    /**
     * Get Exchange Event By ExchangeID & LocalEvent ID
     * @param $exchange_id
     * @param $local_event_id
     * @return bool|int
     */
    function get_exchange_event($exchange_id, $local_event_id) {
        $user_id = $this->user_id;
        if($user_id) {
            if($this->helper->get_exchange($exchange_id)) {
                return $this->exchangemapping_handler->get_exchange_event($exchange_id, $local_event_id);
            } else {
                return 403;
            }
        } else {
            return 404;
        }
    }

    /**
     * Get Exchange Event By Approve Status
     * @param $exchange_id
     * @param $approve_status
     * @return bool|int
     */
    function get_exchange_event_by_status($exchange_id, $approve_status) {
        $user_id = $this->user_id;
        if($user_id) {
            if($this->helper->get_exchange($exchange_id)) {
                return $this->exchangemapping_handler->get_exchange_event_by_status($approve_status);
            } else {
                return 403;
            }
        } else {
            return 404;
        }
    }
}