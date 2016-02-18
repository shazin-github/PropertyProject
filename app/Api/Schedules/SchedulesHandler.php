<?php

namespace App\Api\Schedules;

use Illuminate\Support\Facades\DB;

class SchedulesHandler {

    /**
     * Get Schedules By UserID & EventID
     * @param $user_id
     * @param $event_id
     * @return bool|array
     */
    public function get_tasks($user_id, $event_id)
    {

        $result = DB::table('schedule_tasks')
            ->where('user_id', '=', $user_id)
            ->where('event_id', '=', $event_id)
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Get Today Schedules By UserID
     * @param $user_id
     * @return bool|array
     */
    public function get_todo_tasks($user_id)
    {
        $date = date("m/d/Y");
        $result = DB::table('schedule_tasks')
            ->select('command')
            ->where('user_id', '=', $user_id)
            ->where('time', '=', $date)
            ->where('task_status', '=', 0)
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Add New Schedule
     * @param $user_id
     * @param $event_id
     * @param $time
     * @param $command
     * @return bool
     */
    public function save_task($user_id, $event_id, $time, $command)
    {
        $taskID = DB::table('schedule_tasks')->insertGetId([
            'user_id' => $user_id,
            'event_id' => $event_id,
            'time' => $time,
            'command' => $command
        ]);

        return true;
    }

    /**
     * Update Schedule By ScheduleID
     * @param $task_id
     * @param $time
     * @param $command
     * @return bool
     */
    public function update_task($task_id, $time, $command)
    {

        $result = DB::table('schedule_tasks')
            ->where('task_id', '=', $task_id)
            ->get();
        if($result) {
            $data = array(
                'time' => $time,
                'command' => $command
            );
            DB::table('schedule_tasks')
                ->where('task_id', $task_id)
                ->update($data);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete Schedule By ScheduleID & UserID
     * @param $user_id
     * @param $task_id
     * @return bool
     */
    public function delete_task($user_id, $task_id)
    {
        $result = DB::table('schedule_tasks')
            ->where('task_id', '=', $task_id)
            ->where('user_id', $user_id)
            ->get();
        if($result) {
            DB::table('schedule_tasks')
                ->where('task_id', '=', $task_id)
                ->where('user_id', $user_id)
                ->delete();
            return true;
        } else {
            return false;
        }
    }
}