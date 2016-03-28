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

use App\PropertyMySQL\Location\Location;
use App\PropertyMySQL\Features\Features;

use App\PropertyMySQL\Seller\Seller;

class PropertyController extends Controller{
    protected $request;
    protected $response;
    protected $users;
    protected $property;
    protected $location;
    protected $feature;
    protected $seller;

    public function __construct(Request $request, Response $response, Users $users,Property $property , Location $location , Features $feature , Seller $seller ){
        $this->request = $request;
        $this->response = $response;
        $this->users = $users;
        $this->property = $property;
        $this->location = $location;
        $this->feature  = $feature;
        $this->seller = $seller;
    }



    //Before Adding Property We Will Add PropertyLocation First Then Add Property.

    public function addproperty(){

        $data = $this->request->all();

        $validator = Validator::make($data,[

            'location'    => 'required',
            'property'    => 'required',
            'feature'    => 'required',
            'seller'    => 'required',
        ]);

        //return $data;

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }

        $loc = $data['location'];

        $pro = $data['property'];

        $fea = $data['feature'];

        $loc_id = $this->location->addLocation($loc);

        $pro['loc_id'] = $loc_id;

        $pro_id = $this->property->addproperty($pro);

        $fea['property_id'] = $pro_id;

        $fea['utilities'] = json_encode($fea['utilities']);

        $res = $this->feature->addFeature($fea);

        $sel['user_id'] = $data['seller'];

        $sel['property_id'] = $pro_id;

        $result = $this->seller->addSeller($sel);

        if($result){

            return $this->response->success($result);

        }else{

            return $this->response->application_error('Unable to process request');

        }



    }

    public function updatebyID(){

        $data = $this->request->all();


        $loc = $data['location'];

        $pro = $data['property'];

        $fea = $data['feature'];

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

    public function SearchByCity(){

        $data = $this->request->all();



        $validator = Validator::make($data,[

            'city'    => 'required',
        ]);

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }

        $result = $this->property->SearchByCity($data);

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

    public function showproperty(){

        $result = $this->property->showproperty();

        if($result){

            return $this->response->success($result);
        }else{

            return $this->response->not_found('No Result Found');
        }

    }

    
    public function SearchWithUser(){
        $data = $this->request->all();
        $validator = Validator::make($data,[
            'user_id'    => 'required',
        ]);

        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }

        $result = $this->property->SearchWithUser($data);

        if($result){
            return $this->response->success($result);
        }else{
            return $this->response->not_found("Requested Data not found");
        }
    }

    public function livesearch(){

        $data = $this->request->all();

        //dd($data);

        $result = $this->property->livesearch($data);

        if($result){

            return $this->response->success($result);
        }else{

            return $this->response->not_found('Not Found');
        }

    }
    public function SearchWithMaxPrice(){
        $data = $this->request->all();



        $validator = Validator::make($data,[

            'max'    => 'required'

        ]);

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }


        $result = $this->property->SearchWithMaxPrice($data);

    public function ShowRecent(){

        $result = $this->property->ShowRecent();

        if($result){

            return $this->response->success($result);
        }else{

            return $this->response->not_found('Not Recent Property Found');
        }
    }

    public function ShowMostViewed(){

        $result = $this->property->ShowMostViewed();

        if($result){

            return $this->response->success($result);
        }else{

            return $this->response->not_found('Not Property Found');
        }
    }

    public function updateviews(){

        $data = $this->request->all();

        $validator = Validator::make($data,[
            'id'    => 'required',
        ]);

        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }

        $result = $this->property->updateviews($data);

        if($result){

            return $this->response->success($result);

        }else{

            return $this->response->not_found("Requested Data not found");

        }
    }
        }else{

            return $this->response->not_found('Not Found');
        }

    }

    public function SearchWithMinPrice(){
        $data = $this->request->all();



        $validator = Validator::make($data,[

            'min'    => 'required'

        ]);

        if ($validator->fails()) {

            return $this->response->bad_request($validator->errors()->all());

        }


        $result = $this->property->SearchWithMinPrice($data);

        if($result){

            return $this->response->success($result);

        }else{

            return $this->response->not_found("Requested Data not found");

        }
    }
}