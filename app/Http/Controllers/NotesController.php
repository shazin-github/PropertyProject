<?php

namespace App\Http\Controllers;

use App\Api\Events\Events;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Api\Notes\EventNotes;
Use App\Api\Response\Response;
use \Validator;

class NotesController extends Controller
{
    protected $event_notes;
    protected $request;
    protected $response;

    public function __construct(EventNotes $event_notes, Request $request, Response $response) {
        $this->event_notes = $event_notes;
        $this->request = $request;
        $this->response = $response;
    }

    public function event_notes() {

        $validator = Validator::make($this->request->all(),[
            'event_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }

            $event_id = $this->request->input('event_id');
            $event_notes = $this->event_notes->event_notes($event_id);
            if($event_notes === 404) {
                return $this->response->not_found('User not found');
            } elseif(!$event_notes) {
                return $this->response->not_found('No Event Note Found');
            } else {
                return $this->response->success($event_notes);
            }
    }

    public function event_notes_aggregate() {
            $event_notes = $this->event_notes->event_notes_aggregate();
            if($event_notes === 404) {
                return $this->response->not_found('User not found');
            } elseif(!$event_notes) {
                return $this->response->not_found('No Event Note Found');
            } else {
                return $this->response->success($event_notes);
            }
    }

    public function add_event_notes()
    {
        $validator = Validator::make($this->request->all(),[
            'event_id' => 'required',
            'date' => 'required',
            'Note' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }

            $event_id = $this->request->input('event_id');
            $note = $this->request->input('Note');
            $date = $this->request->input('date');
            $event_notes = $this->event_notes->event_notes_add($event_id, $note, $date);
            if ($event_notes === 404) {
                return $this->response->not_found('User not found');
            } elseif(!$event_notes) {
                return $this->response->not_found('Event Note failed');
            } else {
                $result = array('id' => $event_notes, 'message' => 'Event Note Added Successfully');
                return $this->response->success($result);
            }
    }

    public function delete_event_notes()
    {

        $validator = Validator::make($this->request->all(),[
            'note_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }

            $note_id = $this->request->input('note_id');
            $event_notes = $this->event_notes->event_notes_delete($note_id);
            if ($event_notes === 404) {
                return $this->response->not_found('User not found');
            } elseif(!$event_notes) {
                return $this->response->not_found('Event Note Not Found');
            } else {
                return $this->response->success('Event Note Deleted Successfully');
            }
    }

    public function update_event_notes()
    {

        $validator = Validator::make($this->request->all(),[
            'note_id' => 'required|size:24',
            'new_note' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }

            $note_id = $this->request->input('note_id');
            $new_note = $this->request->input('new_note');
            $event_notes = $this->event_notes->event_notes_update($note_id, $new_note);
            if ($event_notes === 404) {
                return $this->response->not_found('User not found');
            } elseif(!$event_notes) {
                return $this->response->not_found('Event Note Not Found');
            } else {
                return $this->response->success('Event Note Updated successfully');
            }
    }
}