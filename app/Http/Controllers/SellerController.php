<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use \Validator;
use \Cache;
Use App\PropertyMySQL\Response\Response;

use App\PropertyMySQL\Users\Users;

use App\PropertyMySQL\Seller\Seller;

class SellerController extends Controller{
    protected $request;
    protected $response;
    protected $users;

    protected $seller;

    public function __construct(Request $request, Response $response, Users $users , Seller $seller){
        $this->request = $request;
        $this->response = $response;
        $this->users = $users;
        $this->seller = $seller;
    }


    public function addSeller(){

        $data = $this->request->all();

        $validator = Validator::make($data,[
            'property_id'=> 'required',
            'user_id'=> 'required'

        ]);

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }

        $result = $this->seller->addSeller($data);

        if($result){

            return $this->response->success($result);

        } else {

            return $this->response->application_error('Unable to process request');

        }
    }


    public function ShowSellerbyId(){

        $data = $this->request->all();

        $validator = Validator::make($data,[

            'id' => 'required'

        ]);

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }

        $result = $this->seller->ShowSellerbyId($data);

        if($result){

            return $this->response->success($result);

        } else {

            return $this->response->not_found('Invalid Request ID');

        }
    }

    public function ShowSellerbyProperty_Id(){

        $data = $this->request->all();

        $validator = Validator::make($data,[

            'property_id' => 'required'

        ]);

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }

        $result = $this->seller->ShowSellerbyProperty_Id($data);

        if($result){

            return $this->response->success($result);

        } else {

            return $this->response->not_found('Invalid Request ID');

        }
    }

    public function ShowSellerbyuser_Id(){

        $data = $this->request->all();

        $validator = Validator::make($data,[

            'user_id' => 'required'

        ]);

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }

        $result = $this->seller->ShowSellerbyuser_Id($data);

        if($result){

            return $this->response->success($result);

        } else {

            return $this->response->not_found('Invalid Request ID');

        }
    }

}