<?php

namespace App\Http\Controllers;

use App\Api\Events\Events;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\Stubhub\SellerFee\SellerFee;
Use App\Api\Response\Response;
use \Validator;

class SellerFeeController extends Controller
{
    protected $sellerfee;
    protected $request;
    protected $response;

    public function __construct(SellerFee $sellerfee, Request $request, Response $response)
    {
        $this->sellerfee = $sellerfee;
        $this->request = $request;
        $this->response = $response;
    }

    public function sellerfee_by_event($exchange_id)
    {

        $validator = Validator::make($this->request->all(),[
            'exchange_event_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }

            $event_id = $this->request->input('exchange_event_id');
            $price_settings = $this->sellerfee->sellerfee_by_event($exchange_id, $event_id);
            if($price_settings === 404) {
                return $this->response->not_found('User not found');
            } elseif($price_settings === 403) {
                return $this->response->forbidden('exchange_id is invalid');
            } elseif(!$price_settings) {
                return $this->response->not_found('SellerFee Not Found');
            } else {
                return $this->response->success($price_settings);
            }
    }

    public function add_sellerfee($exchange_id)
    {

        $validator = Validator::make($this->request->all(),[
            'exchange_event_id' => 'required',
            'buy_percentage' => 'required',
            'delivery_fees' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }

            $event_id = $this->request->input('exchange_event_id');
            $buy_percentage = $this->request->input('buy_percentage');
            $delivery_fees = $this->request->input('delivery_fees');
            $price_settings = $this->sellerfee->add_sellerfee($exchange_id, $event_id, $buy_percentage, $delivery_fees);
            if($price_settings === 404) {
                return $this->response->not_found('User not found');
            } elseif($price_settings === 403) {
                return $this->response->forbidden('exchange_id is invalid');
            } elseif(!$price_settings) {
                return $this->response->not_found('SellerFee Add failed');
            } else {
                $result = array('id' => $price_settings, 'message' => 'Sellerfee Added Successfully');
                return $this->response->success($result);
            }
    }

    public function update_sellerfee($exchange_id)
    {

        $validator = Validator::make($this->request->all(),[
            'exchange_event_id' => 'required',
            'buy_percentage' => 'required',
            'delivery_fees' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }

            $event_id = $this->request->input('exchange_event_id');
            $buy_percentage = $this->request->input('buy_percentage');
            $delivery_fees = $this->request->input('delivery_fees');
            $price_settings = $this->sellerfee->update_sellerfee($exchange_id, $event_id, $buy_percentage, $delivery_fees);
            if($price_settings === 404) {
                return $this->response->not_found('User not found');
            } elseif($price_settings === 403) {
                return $this->response->forbidden('exchange_id is invalid');
            } elseif(!$price_settings) {
                return $this->response->not_found('SellerFee Not Found');
            } else {
                return $this->response->success('SellerFee Updated Successfully');
            }
    }

    public function delete_sellerfee($exchange_id)
    {

        $validator = Validator::make($this->request->all(),[
            'exchange_event_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }
            $event_id = $this->request->input('exchange_event_id');
            $price_settings = $this->sellerfee->delete_sellerfee($exchange_id, $event_id);
            if($price_settings === 404) {
                return $this->response->not_found('User not found');
            } elseif($price_settings === 403) {
                return $this->response->forbidden('exchange_id is invalid');
            } elseif(!$price_settings) {
                return $this->response->not_found('SellerFee Not Found');
            } else {
                return $this->response->success('SellerFee Deleted Successfully');
            }
    }
}