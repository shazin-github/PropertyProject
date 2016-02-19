<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use \Validator;
use \Cache;

Use App\Api\Response\Response;
use App\Api\Users\Users;
use App\Api\Property\Property;

class UsersController extends Controller{
    protected $request;
    protected $response;

    protected $users;
    protected $property;

    public function __construct(Request $request, Response $response, Users $users, Property $property){
        $this->request = $request;
        $this->response = $response;

        $this->users = $users;
        $this->property = $property;
    }

    public function addUser() {
        $data = $this->request->all();
        $validator = Validator::make($data,[
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
            'loc_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }
        $result = $this->users->addUser($data);
        
        if($result){
            return $this->response->success($result);
        } else {
            return $this->response->application_error('Unable to process request');
        }
    }

    public function updateUser() {
        $data = $this->request->all();
        $validator = Validator::make($data,[
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }
        $result = $this->users->updateUser($data);
        
        if($result){
            return $this->response->success($result);
        } else {
            return $this->response->application_error('Unable to process request');
        }
    }

    public function addLocation() {
        $data = $this->request->all();
        $validator = Validator::make($data,[
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }
        $result = $this->property->addLocation($data);
        
        if($result){
            return $this->response->success($result);
        } else {
            return $this->response->application_error('Unable to process request');
        }
    }

    public function updateLocation() {
        $data = $this->request->all();
        $validator = Validator::make($data,[
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }
        $result = $this->property->updateLocation($data);
        
        if($result){
            return $this->response->success($result);
        } else {
            return $this->response->application_error('Unable to process request');
        }
    }

    public function addFeatures() {
        $data = $this->request->all();
        $validator = Validator::make($data,[
            'property_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }
        $result = $this->property->addFeatures($data);
        
        if($result){
            return $this->response->success($result);
        } else {
            return $this->response->application_error('Unable to process request');
        }
    }

    public function updateFeatures() {
        $data = $this->request->all();
        $validator = Validator::make($data,[
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }
        $result = $this->property->updateFeatures($data);
        
        if($result){
            return $this->response->success($result);
        } else {
            return $this->response->application_error('Unable to process request');
        }
    }

    public function addProperty() {
        $data = $this->request->all();
        $validator = Validator::make($data,[
            'user_id' => 'required',
            'loc_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }
        $result = $this->property->addProperty($data);
        
        if($result){
            return $this->response->success($result);
        } else {
            return $this->response->application_error('Unable to process request');
        }
    }

    public function updateProperty() {
        $data = $this->request->all();
        $validator = Validator::make($data,[
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }
        $result = $this->property->updateProperty($data);
        
        if($result){
            return $this->response->success($result);
        } else {
            return $this->response->application_error('Unable to process request');
        }
    }

    public function addSeller() {
        $data = $this->request->all();
        $validator = Validator::make($data,[
            'user_id' => 'required',
            'property_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }
        $result = $this->property->addSeller($data);
        
        if($result){
            return $this->response->success($result);
        } else {
            return $this->response->application_error('Unable to process request');
        }
    }

    public function updateSeller() {
        $data = $this->request->all();
        $validator = Validator::make($data,[
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }
        $result = $this->property->updateSeller($data);
        
        if($result){
            return $this->response->success($result);
        } else {
            return $this->response->application_error('Unable to process request');
        }
    }
}