<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Api\Users\Users;
Use App\Api\Response\Response;
use \Validator;
use \Cache;
use Illuminate\Support\Facades\Input;

class UsersController extends Controller
{
    protected $users;
    protected $request;
    protected $response;

    public function __construct(Users $users, Request $request, Response $response)
    {
        $this->users = $users;
        $this->request = $request;
        $this->response = $response;
    }

    public function get_all_users() {
        if(!Cache::has('all_users_data') || Input::has('refresh_cache')){
            if(!$this->refresh_users_cache())
                return $this->response->not_found("Cant't update cache");
        }
        return json_encode(Cache::get('all_users_data'));
    }

    public function refresh_users_cache(){
        $users = $this->users->get_all_user_details();
        if($users){
            Cache::forever('all_users_data', ['success' => $users] );
            return true;
        } 
        return false;
    }

    public function get_user_info() {

        $validator = Validator::make($this->request->all(),[
            'user_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }

        $user_id = $this->request->get('user_id');
        $users = $this->users->get_user_info($user_id);
        if($users){
            return $this->response->success($users);
        } else {
            return $this->response->not_found('User Not Found');
        }
    }

    public function get_all_plans() {
        $users = $this->users->get_all_plans();
        if($users){
            return $this->response->success($users);
        } else {
            return $this->response->not_found('No Plan Present');
        }
    }

    public function plan_change() {

        $validator = Validator::make($this->request->all(),[
            'user_id' => 'required',
            'plan_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }

        $user_id = $this->request->get('user_id');
        $plan_id = $this->request->get('plan_id');
        $users = $this->users->plan_change($user_id, $plan_id);
        if($users === 404) {
            return $this->response->not_found('User Not Found');
        }
        elseif(!$users){
            return $this->response->success('Already Updated');
        } else {
            return $this->response->success($users);
        }
    }

    public function add_seller_id() {

        $validator = Validator::make($this->request->all(),[
            'user_id' => 'required',
            'seller_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }

        $user_id = $this->request->get('user_id');
        $seller_id = $this->request->get('seller_id');
        $users = $this->users->add_seller_id($user_id, $seller_id);
        if(!$users){
            return $this->response->success('SellerID Already Added');
        } else {
            return $this->response->success('SellerID Added Sucessfully');
        }
    }

    public function update_seller_id() {

        $validator = Validator::make($this->request->all(),[
            'user_id' => 'required',
            'seller_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }

        $user_id = $this->request->get('user_id');
        $seller_id = $this->request->get('seller_id');
        $users = $this->users->update_seller_id($user_id, $seller_id);
        if($users === 404) {
            return $this->response->not_found('User Not Found');
        }
        elseif(!$users){
            return $this->response->success('Already Updated');
        } else {
            return $this->response->success($users);
        }
    }

    public function update_password() {

        $validator = Validator::make($this->request->all(),[
            'user_id' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }

        $user_id = $this->request->get('user_id');
        $password = $this->request->get('password');
        $users = $this->users->update_password($user_id, $password);
        if($users === 404) {
            return $this->response->not_found('User Not Found');
        }
        elseif(!$users){
            return $this->response->success('Already Updated');
        } else {
            return $this->response->success($users);
        }
    }

    public function update_productname() {

        $validator = Validator::make($this->request->all(),[
            'user_id' => 'required',
            'product_name' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }

        $user_id = $this->request->get('user_id');
        $productname = $this->request->get('product_name');
        $users = $this->users->update_productname($user_id, $productname);
        if($users === 404) {
            return $this->response->not_found('User Not Found');
        }
        elseif(!$users){
            return $this->response->success('Already Updated');
        } else {
            return $this->response->success($users);
        }
    }

    public function update_version() {

        $validator = Validator::make($this->request->all(),[
            'user_id' => 'required',
            'version' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }

        $user_id = $this->request->get('user_id');
        $version = $this->request->get('version');
        $users = $this->users->update_version($user_id, $version);
        if($users === 404) {
            return $this->response->not_found('User Not Found');
        }
        elseif(!$users){
            return $this->response->success('Already Updated');
        } else {
            return $this->response->success($users);
        }
    }

    public function update_version_bit() {

        $validator = Validator::make($this->request->all(),[
            'user_id' => 'required',
            'version_bit' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }

        $user_id = $this->request->get('user_id');
        $version_bit = $this->request->get('version_bit');
        $users = $this->users->update_version_bit($user_id, $version_bit);
        if($users === 404) {
            return $this->response->not_found('User Not Found');
        }
        elseif(!$users){
            return $this->response->success('Already Updated');
        } else {
            return $this->response->success($users);
        }
    }

    public function get_products() {

        $products = $this->users->get_products();
        if($products === 404) {
            return $this->response->not_found('No Product Found');
        } else {
            return $this->response->success($products);
        }
    }

    public function get_versions() {
        $versions = $this->users->get_versions();
        if($versions === 404) {
            return $this->response->not_found('No Version Found');
        } else {
            return $this->response->success($versions);
        }
    }

    public function add_user() {
        $product = explode('-', $this->request->get('product_name'));
        $validate = [
            '_id' => 'required',
            'stubhub_details' => 'required|array',
            'listing_capacity' => 'required',
            'product_name' => 'required'
        ];
        if($product[1] === 'vs') {
            $validate['vivid_api_key'] = 'required';
            $validate['vivid_account_id'] = 'required';
        } elseif($product[1] === 'tu') {
                $validate['tu_api_key'] = 'required';
                $validate['tu_secret'] = 'required';
        }
        $validator = Validator::make($this->request->all(),$validate);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }

        $users = $this->users->add_user($this->request->all());
        if(!$users){
            return $this->response->success('User Already Present. Details Updated Successfully');
        } else {
            return $this->response->success('User Added Successfully');
        }
    }

    public function user_activate() {

        $validator = Validator::make($this->request->all(),[
            'user_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }

        $user_id = $this->request->get('user_id');
        $users = $this->users->update_status($user_id, 1);
        if($users === 404) {
            return $this->response->not_found('User Not Found');
        }
        elseif(!$users){
            return $this->response->success('Already Active');
        } else {
            return $this->response->success('User Activated Successfully');
        }
    }

    public function user_deactivate() {

        $validator = Validator::make($this->request->all(),[
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->response->bad_request($validator->errors()->all());
        }

        $user_id = $this->request->get('user_id');
        $users = $this->users->update_status($user_id, 0);
        if($users === 404) {
            return $this->response->not_found('User Not Found');
        }
        elseif(!$users){
            return $this->response->success('Already Deactive');
        } else {
            return $this->response->success('User DeActivated Successfully');
        }
    }

}