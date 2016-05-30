<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use \Validator;
use App\Http\Controllers\Controller;
Use App\PropertyMySQL\Response\Response;
use App\PropertyMySQL\PropertyType\PropertyType;

class PropertyTypeController extends Controller
{
    protected $request;
    protected $response;
    protected $property_type;

    public function __construct(Request $request, Response $response, PropertyType $property_type){

    	$this->request = $request;
    	$this->response = $response;
        $this->property_type = $property_type;
    }

    public function getTypeList(){

        $result = $this->property_type->getTypeList();

        if($result){
            return $this->response->success($result);
        }
        else{
            return $this->response->not_found('Not Found');
        }

    }

    public function getTypeById(){

        $data = $this->request->all();
        $validator = Validator::make($data,[

            'id'    => 'required',
        ]);

        //return $data;

        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }

        $result = $this->property_type->getTypeById($data);

        if($result){

            return $this->response->success($result);

        }else{

            return $this->response->not_found("Requested Data not found");

        }
    }
}
