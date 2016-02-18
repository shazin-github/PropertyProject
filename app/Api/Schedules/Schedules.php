<?php

namespace App\Api\Schedules;

use App\Api\Users\Users;
use App\Api\Helper\Helper;
use App\Api\Schedules\SchedulesHandler;

class Schedules
{

    protected $schedules_handler;
    protected $user_id;
    protected $broker_key;
    protected $helper;
    protected $user;
    protected $response;
    protected $pos_name;

    function __construct(SchedulesHandler $schedules_handler, Users $user, Helper $helper)
    {
        $this->schedules_handler = $schedules_handler;
        $this->helper = $helper;
        $this->user = $user;
        $this->broker_key = $this->helper->get_header_key();
        $this->user_id = (string)$this->user->get_user_id($this->broker_key);
    }

    /**
     * Get Schedules By UserID & EventID
     * @param $event_id
     * @return array|bool|int
     */
    function schedule_get($event_id) {
        $user_id = $this->user_id;
        if($user_id) {
            return $this->schedules_handler->get_tasks($user_id, $event_id);
        } else {
            return 404;
        }
    }

    /**
     * Delete Schedule By ScheduleID & UserID
     * @param $task_id
     * @return bool|int
     */
    function schedule_delete($task_id) {

        $user_id = $this->user_id;
        if($user_id) {
            return $this->schedules_handler->delete_task($user_id, $task_id);
        } else {
            return 404;
        }
    }

    /**
     * Update Schedule By ScheduleID
     * @param $task_id
     * @param $time
     * @param $raw_command
     * @return bool|int
     */
    function schedule_update($task_id, $time, $raw_command) {

        $user_id = $this->user_id;
        if($user_id) {
            return $this->schedules_handler->update_task($task_id, $time, $raw_command);
        } else {
            return 404;
        }
    }

    /**
     * Add New Schedule
     * @param $event_id
     * @param $time
     * @param $raw_command
     * @return bool|int
     */
    function schedule_add($event_id, $time, $raw_command) {

        $user_id = $this->user_id;
        if($user_id) {
            return $this->schedules_handler->save_task($user_id, $event_id, $time, $raw_command);
        } else {
            return 404;
        }
    }
}