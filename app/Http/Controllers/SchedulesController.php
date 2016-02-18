<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Api\Schedules\Schedules;
Use App\Api\Response\Response;

class SchedulesController extends Controller
{
    protected $schedules;
    protected $request;
    protected $response;

    public function __construct(Schedules $schedules, Request $request, Response $response)
    {
        $this->schedules = $schedules;
        $this->request = $request;
        $this->response = $response;
    }

    public function get_schedule() {

        $validator = Validator::make($this->request->all(),[
            'event_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }
         $event_id = $this->request->input('event_id');
            $schedules = $this->schedules->schedule_get($event_id);
            if($schedules === 404){
                return $this->response->not_found('User not found');
            } else {
                return $this->response->success($schedules);
            }
    }

    public function add_schedule() {

        $validator = Validator::make($this->request->all(),[
            'event_id' => 'required',
            'schedule_date' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }
            $event_id = $this->request->input('event_id');
            $time = $this->request->input('schedule_date');
            $raw_command = json_encode($this->request->all());
            $schedules = $this->schedules->schedule_add($event_id, $time, $raw_command);
            if($schedules === 404){
                return $this->response->not_found('User not found');
            } else {
                return $this->response->success($schedules);
            }
    }

    public function update_schedule() {

        $validator = Validator::make($this->request->all(),[
            'task_id' => 'required',
            'schedule_date' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }
            $task_id = $this->request->input('task_id');
            $time = $this->request->input('schedule_date');
            $raw_command = json_encode($this->request->all());
            $schedules = $this->schedules->schedule_update($task_id, $time, $raw_command);
            if($schedules === 404){
                return $this->response->not_found('User not found');
            } else {
                return $this->response->success($schedules);
            }
    }

    public function delete_schedule() {

        $validator = Validator::make($this->request->all(),[
            'task_id' => 'required'
        ]);
            $task_id = $this->request->input('task_id');
            $schedules = $this->schedules->schedule_delete($task_id);
            if($schedules === 404){
                return $this->response->not_found('User not found');
            } else {
                return $this->response->success($schedules);
            }
    }
}