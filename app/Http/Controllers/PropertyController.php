<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use \Validator;
use \Cache;
Use App\PropertyMySQL\Response\Response;

use App\PropertyMySQL\Users\Users;

use App\PropertyMySQL\Property\Property;

class PropertyController extends Controller{
    protected $request;
    protected $response;
    protected $users;
    protected $property;

    public function __construct(Request $request, Response $response, Users $users,Property $property ){
        $this->request = $request;
        $this->response = $response;
        $this->users = $users;
        $this->property = $property;
    }



    //Before Adding Property We Will Add PropertyLocation First Then Add Property.
    public function addproperty(){

        $data = $this->request->all();

        $validator = Validator::make($data,[
            'loc_id'    => 'required',
            'street'    => 'required',
            'purpose'   =>'required',
            'type'      =>'required',
            'category'  =>'required',
            'area'      =>'required',
            'price'     =>'required'


        ]);

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }


        $result = $this->property->addproperty($data);



        if($result){

            return $this->response->success($result);

        }else{

            return $this->response->application_error('Unable to process request');

        }



    }

    public function updatebyID(){

        $data = $this->request->all();


        switch ($data['update']){
            case 'location':



                break;
            case 'feature':
                break;
            case 'property':
                break;
        }

        $validator = Validator::make($data,[

            'id'    => 'required',
        ]);

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }

        $result = $this->property->updatebyID($data);

        if($result){

            return $this->response->success($result);

        }else{

            return $this->response->not_found("Requested Data not updated");

        }



    }

    public function SearchByID(){

        $data = $this->request->all();



        $validator = Validator::make($data,[

            'id'    => 'required',
        ]);

        //return $data;

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }

        $result = $this->property->SearchByID($data);

        if($result){

            return $this->response->success($result);

        }else{

            return $this->response->not_found("Requested Data not found");

        }

    }

    public function SearchByStreet(){

        $data = $this->request->all();



        $validator = Validator::make($data,[

            'street'    => 'required',
        ]);

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }

        $result = $this->property->SearchByStreet($data);

        if($result){

            return $this->response->success($result);

        }else{

            return $this->response->not_found("Requested Data not found");

        }

    }

    public function SearchWithPrice(){

        $data = $this->request->all();



        $validator = Validator::make($data,[

            'min'    => 'required',
            'max'    => 'required'

        ]);

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }


        $result = $this->property->SearchWithPrice($data);

        if($result){

            return $this->response->success($result);

        }else{

            return $this->response->not_found("Requested Data not found");

        }

    }



}