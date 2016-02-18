<?php

namespace App\Api\EventMapping;

use Illuminate\Support\Facades\DB;

class EventMappingHandler
{

    /**
     *  TicketMaster
     */

    /**
     * Get Events By Name & Date
     * @param $name
     * @param $date
     * @return bool|array
     */
    function get_tm_event($name, $date)
    {

        $result = DB::table('ticketmaster_data')
            ->where('event_name', 'like', '%' . $name . '%')
            ->where('event_date', 'like', $date)
            ->get();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Create New Stubhub Event
     * @param $event_name
     * @param $event_date
     * @param $stub_id
     * @return bool
     */
    public function create_tm_event($event_name, $event_date, $stub_id)
    {

        $eventID = DB::table('ticketmaster_data')->insertGetId([
            'event_name' => $event_name,
            'event_date' => $event_date,
            'stubhub_id' => $stub_id
        ]);

        if ($eventID) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Update Event By Event Name
     * @param $event_name
     * @param $event_date
     * @param $stub_id
     * @return bool
     */
    public function update_tm_event($event_name, $event_date, $stub_id)
    {

        $data = array('event_date' => $event_date, 'stubhub_id' => $stub_id);
        $eventID = DB::table('ticketmaster_data')
            ->where('event_name', '=', $event_name)
            ->update($data);

        if ($eventID) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete Event By Stubhub ID
     * @param $stubhub_id
     * @return bool
     */
    public function delete_tm_event($stubhub_id)
    {

        $eventID = DB::table('ticketmaster_data')
            ->where('stubhub_id', '=', $stubhub_id)
            ->delete();

        if ($eventID) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get all Events
     * @return bool|array
     */
    public function get_all_tm_events()
    {

        $result = DB::table('ticketmaster_data')
            ->get();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Event_ids
     */

    /**
     * Create New entry in event_ids
     * @param $user_id
     * @param $pos_event_id
     * @param $stubhub_event_id
     * @return bool
     */
    public function add_event_ids($user_id, $pos_event_id, $stubhub_event_id) {

        $eventID = DB::table('event_ids')->insertGetId([
            'user_id' => $user_id,
            'pos_event_id' => $pos_event_id,
            'stubhub_event_id' => $stubhub_event_id
        ]);

        if ($eventID) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Find event_ids By user_id & pos_event_id
     * @param $user_id
     * @param $pos_event_id
     * @return bool|array
     */
    public function find_event_ids_by_eventid($user_id, $pos_event_id) {

        $result = DB::table('event_ids')
            ->where('user_id', '=', $user_id)
            ->where('pos_event_id', '=', $pos_event_id)
            ->take(1)
            ->get();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Find event_ids By user_id
     * @param $user_id
     * @return bool|array
     */
    public function find_event_ids_by_user($user_id) {

        $result = DB::table('event_ids')
            ->select('pos_event_id', 'stubhub_event_id')
            ->where('user_id', '=', $user_id)
            ->get();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Update event_ids by pos_event_id
     * @param $user_id
     * @param $pos_event_id
     * @param $stubhub_event_id
     * @return bool
     */
    public function update_event_ids($user_id, $pos_event_id, $stubhub_event_id) {

        $data = array(
            'user_id' => $user_id,
            'pos_event_id' => $pos_event_id,
            'stubhub_event_id' => $stubhub_event_id
        );
        $eventID = DB::table('event_ids')
            ->where('pos_event_id', '=', $pos_event_id)
            ->update($data);

        if ($eventID) {
            return true;
        } else {
            return false;
        }
    }
}