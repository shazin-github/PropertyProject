<?php

namespace App\Api\Notes;

use App\Api\Users\Users;
use App\Api\Helper\Helper;
use App\Api\Notes\NotesHandler;

class EventNotes {

    protected $notes_handler;
    protected $user_id;
    protected $broker_key;
    protected $helper;
    protected $user;
    protected $response;

    function __construct(NotesHandler $notes_handler, Users $user, Helper $helper)
    {
        $this->notes_handler = $notes_handler;
        $this->helper = $helper;
        $this->user = $user;
        $this->broker_key = $this->helper->get_header_key();
        $this->user_id = (string)$this->user->get_user_id($this->broker_key);
    }

    /**
     * Get Events Notes By EventID & UserID
     * @return bool|array
     */
    public function event_notes($event_id) {
        $user_id = $this->user_id;
        if($user_id) {
            return $this->notes_handler->get_event_notes($event_id, $user_id);
        } else {
            return 404;
        }
    }

    /**
     * Get Aggregated Event Notes By UserID GroupBy EventID & UserID
     * @return bool|array
     */
    public function event_notes_aggregate() {
        $user_id = $this->user_id;
        if($user_id) {
            return $this->notes_handler->get_event_notes_aggregate_by_user_id($user_id);
        } else {
            return 404;
        }
    }

    /**
     * Add New Event Notes
     * @param $event_id
     * @param $note
     * @return bool
     */
    public function event_notes_add($event_id, $note) {
        $user_id = $this->user_id;
        if ($user_id) {
            date_default_timezone_set("EST");
            $date = date('m-d-Y g:i a');
            return $this->notes_handler->add_event_notes($event_id, $note, $date, $user_id);
        } else {
            return 404;
        }
    }

    /**
     * Delete Event Notes By UserID & NoteID
     * @param $note_id
     * @return bool
     */
    public function event_notes_delete($note_id) {
        $user_id = $this->user_id;
        if ($user_id) {
            return $this->notes_handler->remove_event_notes($user_id, $note_id);
        } else {
            return 404;
        }
    }

    /**
     * Update Event Notes By UserID & NoteID
     * @param $note_id
     * @param $new_note
     * @return bool
     */
    public function event_notes_update($note_id, $new_note) {

        $user_id = $this->user_id;
        if ($user_id) {
            date_default_timezone_set("EST");
            $date = date('m-d-Y g:i a');
            return $this->notes_handler->update_event_notes($user_id, $note_id, $new_note, $date);
        } else {
            return 404;
        }
    }
}