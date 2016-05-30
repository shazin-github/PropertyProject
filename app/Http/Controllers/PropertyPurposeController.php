<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use \Validator;
use App\Http\Controllers\Controller;
use App\PropertyMySQL\Response\Response;
use App\PropertyMySQL\PropertyPurpose\PropertyPurpose;

class PropertyPurposeController extends Controller
{
    protected $request;
    protected $response;
    protected $property_purpose;

    public function __construct(Request $request, Response $response, PropertyPurpose $property_purpose){

    	$this->request = $request;
    	$this->response = $response;
        $this->property_purpose = $property_purpose;
    }

    public function getPurposeList(){

        $result = $this->property_purpose->getPurposeList();

        if($result){
            return $this->response->success($result);
        }
        else{
            return $this->response->not_found('Not Found');
        }

    }

    public function getPurposeById(){

        $data = $this->request->all();
        $validator = Validator::make($data,[

            'id'    => 'required',
        ]);

        //return $data;

        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }

        $result = $this->property_purpose->getPurposeById($data);

        if($result){

            return $this->response->success($result);

        }else{

            return $this->response->not_found("Requested Data not found");

        }
    }
}
