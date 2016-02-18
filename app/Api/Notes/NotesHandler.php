<?php

namespace App\Api\Notes;

use Illuminate\Support\Facades\DB;

class NotesHandler {

    private $mongo_connection;
    private $event_collection;
    private $listing_collection;

    function __construct() {
        $this->mongo_connection = 'mongoDB';
        $this->event_collection = 'event_notes';
        $this->listing_collection = 'user_notes';
    }

    /*
     *
     * Start Event Notes
     *
     */

    /**
     * Get Events Notes By EventID & UserID
     * @param $event_id
     * @param $user_id
     * @return bool|array
     */
    public function get_event_notes($event_id, $user_id)
    {
        $result = DB::connection($this->mongo_connection)
            ->collection($this->event_collection)
            ->where("event_id" , $event_id)
            ->where("user_id" , $user_id)
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }


    /**
     * Get Aggregated Event Notes Group By EventID 7 UserID
     * @param $user_id
     * @return bool
     */
    public function get_event_notes_aggregate($user_id)
    {
        $result = DB::connection($this->mongo_connection)
            ->collection($this->event_collection)
            ->raw()->aggregate(array('$group' => array('_id' => array('event_id' =>
                    '$event_id', 'user_id' => $user_id), 'Count' => array('$sum' => 1))));
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Get Aggregated Event Notes By UserID GroupBy EventID & UserID
     * @param $user_id
     * @return bool
     */
    public function get_event_notes_aggregate_by_user_id($user_id)
    {

        $result = DB::connection($this->mongo_connection)
            ->collection($this->event_collection)
            ->raw()->aggregate(array('$match'=>array('user_id'=>$user_id)),array('$group' =>
                array('_id' => array('event_id' => '$event_id', 'user_id' => $user_id), 'Count' => array('$sum' => 1))));
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Add New Event Notes
     * @param $event_id
     * @param $note
     * @param $date
     * @param $user_id
     * @return bool
     */
    public function add_event_notes($event_id, $note, $date, $user_id)
    {
        $result = DB::connection($this->mongo_connection)
            ->collection($this->event_collection)
            ->insertGetId([
                'event_id' => $event_id,
                'Note' => $note,
                'date' => $date,
                'user_id' => $user_id
            ]);
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Delete Event Notes By UserID & NoteID
     * @param $user_id
     * @param $note_id
     * @return bool
     */
    public function remove_event_notes($user_id, $note_id)
    {
        $theObjId = new \MongoId($note_id);

        if($theObjId) {
            $check = DB::connection($this->mongo_connection)
                ->collection($this->event_collection)
                ->where('_id', '=', $theObjId)
                ->where('user_id', '=', $user_id)
                ->get();
            if($check) {
                $result = DB::connection($this->mongo_connection)
                    ->collection($this->event_collection)
                    ->where('_id', '=', $theObjId)
                    ->where('user_id', '=', $user_id)
                    ->delete();
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    /**
     * Update Event Notes By UserID & NoteID
     * @param $user_id
     * @param $note_id
     * @param $new_note
     * @param $date
     * @return bool
     */
    public function update_event_notes($user_id, $note_id, $new_note, $date)
    {
        $theObjId = new \MongoId($note_id);

        if($theObjId) {
            $check = DB::connection($this->mongo_connection)
                ->collection($this->event_collection)
                ->where('_id', '=', $theObjId)
                ->where('user_id', '=', $user_id)
                ->get();
            if($check) {
            $result = DB::connection($this->mongo_connection)
                ->collection($this->event_collection)
                ->where('_id', '=', $theObjId)
                ->where('user_id', '=', $user_id)
                ->update(['Note' => $new_note, 'date'=>$date]);
                return true;
            } else {
                return false;
            }
        } else {
                return false;
        }
    }

    /*
     *
     * End Event Notes
     *
     */
}