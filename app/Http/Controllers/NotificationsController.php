<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Api\Notifications\Notifications;
use App\Api\Response\Response;
use \Validator;
class NotificationsController extends Controller
{
    protected $notify;
    protected $request;
    protected $response;
    public function __construct(Notifications $notify, Request $request, Response $response){
    	$this->notify = $notify;
    	$this->request = $request;
    	$this->response = $response;
    }

    public function push_to_slack(){
        $validator = Validator::make($this->request->all(),[
            'message' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }
    	$message = $this->request->all();
    	
		if(!isset($message['channel']) || $message['channel'] == ""){
			$message['channel'] = 'general';
		}
		$message['channel'] = ltrim($message['channel'], '#');
    	
    	$response = $this->notify->slack($message);
    	if($response == 'ok'){
	    	return $this->response->success('Notification Pushed to: #'.$message['channel']);
    	}else{
    		return $this->response->forbidden('Unable to push notification');
    	}
    }

    public function push_email(){
    	$validator = Validator::make($this->request->all(),[
            'message' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }
        $message = $this->request->all();
        
		if(!isset($message['email']) || $message['email'] == ""){
			$message['email'] = 'support@brokergenius.com';
		}
    	$response = $this->notify->email($message);
    	if($response){
	    	return $this->response->success('Notification Pushed to email');
    	}else{
    		return $this->response->forbidden('Unable to push email notification');
    	}
    }
}
