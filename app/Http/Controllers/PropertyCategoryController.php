<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use \Validator;
use App\Http\Controllers\Controller;
use App\PropertyMySQL\Response\Response;
use App\PropertyMySQL\PropertyCategory\PropertyCategory;

class PropertyCategoryController extends Controller
{
    protected $request;
    protected $response;
    protected $property_category;

    public function __construct(Request $request, Response $response, PropertyCategory $property_category){

    	$this->request = $request;
    	$this->response = $response;
        $this->property_category = $property_category;
    }

    public function getCategoryList(){

        $result = $this->property_category->getCategoryList();

        if($result){
            return $this->response->success($result);
        }
        else{
            return $this->response->not_found('Not Found');
        }

    }

    public function getCategoryById(){

        $data = $this->request->all();
        $validator = Validator::make($data,[

            'id'    => 'required',
        ]);

        //return $data;

        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }

        $result = $this->property_category->getCategoryById($data);

        if($result){

            return $this->response->success($result);

        }else{

            return $this->response->not_found("Requested Data not found");

        }
    }
}
