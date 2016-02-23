<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use \Validator;
use \Cache;
Use App\PropertyMySQL\Response\Response;

use App\PropertyMySQL\Users\Users;

use App\PropertyMySQL\SaleHistory\SaleHistory;

class SaleHistoryController extends Controller{
    protected $request;
    protected $response;
    protected $users;
    protected $salehistory;

    public function __construct(Request $request, Response $response, Users $users , SaleHistory $saleHistory){
        $this->request = $request;
        $this->response = $response;
        $this->users = $users;
        $this->salehistory = $saleHistory;
    }


    public function addSaleHistory(){

        $data = $this->request->all();

        $validator = Validator::make($data,[

            'property_id'=> 'required',
            'seller_id' =>'required',
            'buyer_id' => 'required',
            'total_price' => 'required'

        ]);

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }

        $result = $this->salehistory->addSaleHistory($data);

        if($result){

            return $this->response->success($result);

        } else {

            return $this->response->application_error('Unable to process request');

        }

    }


    public function ShowByid(){

        $data = $this->request->all();



        $validator = Validator::make($data,[

            'id' => 'required'

        ]);

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }

        $result = $this->salehistory->ShowByid($data);

        if($result){

            return $this->response->success($result);

        } else {

            return $this->response->not_found('Invalid Request ID');

        }
    }


    public function ShowbyPropertyId(){

        $data = $this->request->all();

        $validator = Validator::make($data,[

            'property_id' => 'required'

        ]);

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }

        $result = $this->salehistory->ShowbyPropertyId($data);

        if($result){

            return $this->response->success($result);

        } else {

            return $this->response->not_found('Invalid Request ID');

        }

    }



    public function ShowbybuyerId(){

        $data = $this->request->all();

        $validator = Validator::make($data,[

            'buyer_id' => 'required'

        ]);

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }

        $result = $this->salehistory->ShowbybuyerId($data);

        if($result){

            return $this->response->success($result);

        } else {

            return $this->response->not_found('Invalid Request ID');

        }

    }


    public function ShowSellerbysellerId(){

        $data = $this->request->all();

        $validator = Validator::make($data,[

            'seller_id' => 'required'

        ]);

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }

        $result = $this->salehistory->ShowSellerbysellerId($data);

        if($result){

            return $this->response->success($result);

        } else {

            return $this->response->not_found('Invalid Request ID');

        }

    }

}