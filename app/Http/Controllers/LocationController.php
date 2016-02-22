<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use \Validator;
use \Cache;
Use App\PropertyMySQL\Response\Response;

use App\PropertyMySQL\Users\Users;
use App\PropertyMySQL\Location\Location;

class LocationController extends Controller{

    protected $request;

    protected $response;

    protected $users;

    protected $location;

    public function __construct(Request $request, Response $response, Users $users , Location $location){

        $this->request = $request;

        $this->response = $response;

        $this->users = $users;

        $this->location = $location;
    }

    public function addLocation() {


        $data = $this->request->all();

        $validator = Validator::make($data,[
            'address' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',

        ]);

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }

        $result = $this->location->addLocation($data);

        if($result){

            return $this->response->success($result);

        } else {

            return $this->response->application_error('Unable to process request');

        }
    }

    public function updateLocationbyID() {

        $data = $this->request->all();

        $validator = Validator::make($data,[

            'id' => 'required'

        ]);

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }

        $result = $this->location->updateLocation($data);

        if($result){

            return $this->response->success($result);

        } else {

            return $this->response->application_error('Unable to process request');

        }
    }

    public function ShowLocationbyId(){

        $data = $this->request->all();

        $validator = Validator::make($data,[

            'id' => 'required'

        ]);

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }

        $result = $this->location->ShowLocationbyId($data);

        if($result){

            return $this->response->success($result);

        } else {

            return $this->response->application_error('Unable to process request');

        }
    }

    public  function DisableLocaionbyId(){

        $data = $this->request->all();

        $validator = Validator::make($data,[

            'id' => 'required'

        ]);

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }

        $result = $this->location->DisableById($data);


        if($result){

            return $this->response->success($result);

        } else {

            return $this->response->application_error('Unable to process request');

        }
    }

}