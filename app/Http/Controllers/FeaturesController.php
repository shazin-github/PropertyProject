<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use \Validator;
use \Cache;
Use App\PropertyMySQL\Response\Response;

use App\PropertyMySQL\Users\Users;

use App\PropertyMySQL\Features\Features;

class FeaturesController extends Controller{
    protected $request;
    protected $response;
    protected $users;
    protected $features;

    public function __construct(Request $request, Response $response, Users $users , Features $features){
        $this->request = $request;
        $this->response = $response;
        $this->users = $users;

        $this->features = $features;
    }

    public function addFeature() {


        $data = $this->request->all();

        $validator = Validator::make($data,[

            'property_id'=> 'required',

        ]);

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }

        $result = $this->features->addFeature($data);

        if($result){

            return $this->response->success($result);

        } else {

            return $this->response->application_error('Unable to process request');

        }
    }

    public function updateFeaturebyproperty_Id(){

        $data = $this->request->all();

        $validator = Validator::make($data,[

            'property_id' => 'required'

        ]);

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }

        $result = $this->features->updatefeaturebyPropertyId($data);

        if($result){

            return $this->response->success($result);

        } else {

            return $this->response->not_found('Invalid Request ID');

        }
    }

    public function updateFeaturebyId(){

        $data = $this->request->all();



        $validator = Validator::make($data,[

            'id' => 'required'

        ]);

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }

        $result = $this->features->updateFeaturebyId($data);

        if($result){

            return $this->response->success($result);

        } else {

            return $this->response->not_found('Invalid Request ID');

        }
    }


    public function ShowFeaturebyProperty_Id(){

        $data = $this->request->all();

        $validator = Validator::make($data,[

            'property_id' => 'required'

        ]);

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }

        $result = $this->features->ShowFeaturebyProperty_Id($data);

        if($result){

            return $this->response->success($result);

        } else {

            return $this->response->not_found('Invalid Request ID');

        }
    }


    public function ShowFeaturebyId(){

        $data = $this->request->all();

        $validator = Validator::make($data,[

            'id' => 'required'

        ]);

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }

        $result = $this->features->ShowFeaturebyId($data);

        if($result){

            return $this->response->success($result);

        } else {

            return $this->response->not_found('Invalid Request ID');

        }
    }

    public function ShowByNumberOfBedrooms(){

        $data = $this->request->all();


        $validator = Validator::make($data,[

            'beds' => 'required'

        ]);

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }

        $result = $this->features->ShowByNumberOfBedrooms($data);

        if($result)
        {
            return $this->response->success(($result));
        }else{

            return $this->response->not_found('Requested Data Not Found');
        }

    }

    public function ShowByNumberOfBathrooms(){

        $data = $this->request->all();


        $validator = Validator::make($data,[

            'bath' => 'required'

        ]);

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }

        $result = $this->features->ShowByNumberOfBathrooms($data);

        if($result)
        {
            return $this->response->success(($result));
        }else{

            return $this->response->not_found('Requested Data Not Found');
        }


    }

    public function ShowWithBathAndBedroomd(){

        $data = $this->request->all();

        $validator = Validator::make($data,[

            'bath' => 'required',
            'bed'  => 'required'

        ]);

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }

        $result = $this->features->ShowWithBathAndBedroomd($data);

        if($result)
        {
            return $this->response->success(($result));
        }else{

            return $this->response->not_found('Requested Data Not Found');
        }


    }
}