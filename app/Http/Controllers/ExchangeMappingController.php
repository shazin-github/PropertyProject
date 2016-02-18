<?php

namespace App\Http\Controllers;

use App\Api\Events\Events;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\Stubhub\ExchangeMapping\ExchangeMapping;
Use App\Api\Response\Response;
use \Validator;

class ExchangeMappingController extends Controller
{
    protected $exchange_mapping;
    protected $request;
    protected $response;
    protected $pos_name;
    protected $source;

    public function __construct(ExchangeMapping $exchange_mapping, Request $request, Response $response)
    {
        $this->exchange_mapping = $exchange_mapping;
        $this->request = $request;
        $this->response = $response;
        $this->pos_name = array('tn', 'ei', 'tt');
        $this->source = array('manual', 'auto');
    }

    function save_exchange_event($exchange_id) {
        $validator = Validator::make($this->request->all(),[
            'exchange_event_id' => 'required|numeric',
            'source' => 'required|in:'.implode($this->source, ","),
            'event_name' => 'required|string',
            'pos_name' => 'required|in:'.implode($this->pos_name, ",")
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }
            $exchange_event_data = $this->request->all();
            $exchange_event = $this->exchange_mapping->save_exchange_event($exchange_id, $exchange_event_data);
            if($exchange_event === 404){
                return $this->response->not_found('User not found');
            } elseif($exchange_event === 403) {
                return $this->response->forbidden('exchange_id is invalid');
            } elseif(!$exchange_event) {
                return $this->response->not_found('ExchangeMapping Add Failed');
            } else {
                return $this->response->success('ExchangeMapping Added Successfully');
            }
    }

    public function update_exchange_event_id($exchange_id) {

        $validator = Validator::make($this->request->all(),[
            '_id' => 'required',
            'exchange_event_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }

            $id = $this->request->input('_id');
            $exchange_event_id = $this->request->input('exchange_event_id');
            $exchange_event = $this->exchange_mapping->update_exchange_event_id($exchange_id, $id, $exchange_event_id);
            if($exchange_event === 404) {
                return $this->response->not_found('User not found');
            } elseif($exchange_event === 403) {
                return $this->response->forbidden('exchange_id is invalid');
            } elseif(!$exchange_event) {
                return $this->response->not_found('ExchangeMapping Not Found');
            } else {
                return $this->response->success('ExchangeMapping Event Updated Successfully');
            }
    }

    public function update_exchange_event_status($exchange_id) {

        $validator = Validator::make($this->request->all(),[
            '_id' => 'required',
            'approve_status' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }

            $id = $this->request->input('_id');
            $approve_status = $this->request->input('approve_status');
            $exchange_event = $this->exchange_mapping->update_exchange_event_status($exchange_id, $id, $approve_status);
            if($exchange_event === 404) {
                return $this->response->not_found('User not found');
            } elseif($exchange_event === 403) {
                return $this->response->forbidden('exchange_id is invalid');
            } elseif(!$exchange_event) {
                return $this->response->not_found('ExchangeMapping Not Found');
            } else {
                return $this->response->success('ExchangeMapping Status Updated Successfully');
            }
    }

    public function get_exchange_event($exchange_id) {

        $validator = Validator::make($this->request->all(),[
            'local_event_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }

            $local_event_id = $this->request->input('local_event_id');
            $exchange_event = $this->exchange_mapping->get_exchange_event($exchange_id, $local_event_id);
            if($exchange_event === 404) {
                return $this->response->not_found('User not found');
            } elseif($exchange_event === 403) {
                return $this->response->forbidden('exchange_id is invalid');
            } elseif(!$exchange_event) {
                return $this->response->not_found('ExchangeMapping Not Found');
            } else {
                return $this->response->success($exchange_event);
            }
    }

    public function get_exchange_event_by_status($exchange_id) {

        $validator = Validator::make($this->request->all(),[
            'approve_status' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }

            $approve_status = $this->request->input('approve_status');
            $exchange_event = $this->exchange_mapping->get_exchange_event_by_status($exchange_id, $approve_status);
            if($exchange_event === 404) {
                return $this->response->not_found('User not found');
            } elseif($exchange_event === 403) {
                return $this->response->forbidden('exchange_id is invalid');
            } elseif(!$exchange_event) {
                return $this->response->not_found('ExchangeMapping Not Found');
            } else {
                return $this->response->success($exchange_event);
            }
    }
}