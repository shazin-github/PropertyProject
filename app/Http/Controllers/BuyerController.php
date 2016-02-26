<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use \Validator;
use \Cache;
Use App\PropertyMySQL\Response\Response;

use App\PropertyMySQL\Users\Users;

use App\PropertyMySQL\Buyer\Buyer;


class BuyerController extends Controller{
    protected $request;
    protected $response;
    protected $users;
    protected $buyer;

    public function __construct(Request $request, Response $response, Users $users , Buyer $buyer){
        $this->request = $request;
        $this->response = $response;
        $this->users = $users;
        $this->buyer = $buyer;
    }


    public function addBuyer() {


        $data = $this->request->all();

        $validator = Validator::make($data,[
            'property_id'=> 'required',
            'user_id'=> 'required'

        ]);

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }

        $result = $this->buyer->addBuyer($data);

        if($result){

            return $this->response->success($result);

        } else {

            return $this->response->application_error('Missing Some Fields OR check Field Spell');

        }
    }

    public function ShowBuyerbyId(){

        $data = $this->request->all();

        $validator = Validator::make($data,[

            'id' => 'required'

        ]);

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }

        $result = $this->buyer->ShowBuyerbyId($data);

        if($result){

            return $this->response->success($result);

        } else {

            return $this->response->not_found('Invalid Request ID');

        }
    }

    public function ShowBuyerbyProperty_Id(){

        $data = $this->request->all();

        $validator = Validator::make($data,[

            'property_id' => 'required'

        ]);

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }

        $result = $this->buyer->ShowBuyerbyProperty_Id($data);

        if($result){

            return $this->response->success($result);

        } else {

            return $this->response->not_found('Invalid Request ID');

        }
    }

    public function ShowBuyerbyuser_Id(){

        $data = $this->request->all();

        $validator = Validator::make($data,[

            'user_id' => 'required'

        ]);

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }

        $result = $this->buyer->ShowBuyerbyuser_Id($data);

        if($result){

            return $this->response->success($result);

        } else {

            return $this->response->not_found('Invalid Request ID');

        }
    }
}