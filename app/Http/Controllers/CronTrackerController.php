<?php

namespace App\Http\Controllers;

use App\Api\Events\Events;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\brokergeniusApp\CronTracker\CronTracker;
Use App\Api\Response\Response;
use \Validator;

class CronTrackerController extends Controller
{
    protected $crontracker;
    protected $request;
    protected $response;

    public function __construct(CronTracker $crontracker, Request $request, Response $response)
    {
        $this->crontracker = $crontracker;
        $this->request = $request;
        $this->response = $response;
    }

    public function crontracker()
    {
        $validator = Validator::make($this->request->all(),[
            'update_time' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }
            $update_time = $this->request->input('update_time');
            $crontracker = $this->crontracker->crontracker($update_time);
            if($crontracker === 404) {
                return $this->response->not_found('CronTracker not found');
            } elseif($crontracker === 401) {
                return $this->response->not_found('User not found');
            } else {
                return $this->response->success('CronTracker Added Successfully');
            }
    }

    public function get_user_crontracker() {
        $crontracker = $this->crontracker->get_user_crontracker();
        if($crontracker === 401) {
            return $this->response->not_found('User not found');
        } elseif(!$crontracker) {
            return $this->response->success('No CronTracker Found');
        } else {
            return $this->response->success($crontracker);
        }
    }

    public function get_all_crontracker() {
        $crontracker = $this->crontracker->get_all_crontracker();
        if($crontracker === 401) {
            return $this->response->not_found('User not found');
        } elseif(!$crontracker) {
            return $this->response->success('No CronTracker Found');
        } else {
            return $this->response->success($crontracker);
        }
    }
}