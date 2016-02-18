<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Api\UserExperience\UserExperience;
Use App\Api\Response\Response;

class UserExperienceController extends Controller
{
    protected $userexperience;
    protected $request;
    protected $response;

    public function __construct(UserExperience $userexperience, Request $request, Response $response)
    {
        $this->userexperience = $userexperience;
        $this->request = $request;
        $this->response = $response;
    }

    public function add_userexperience() {
        if($this->request->has('experience') && $this->request->has('user')) {
            $experience = $this->request->input('experience');
            $user = $this->request->input('user');
            $userexperience = $this->userexperience->add_userexperience($experience, $user);
            if($userexperience === 404){
                return $this->response->not_found('User not found');
            } else {
                return $this->response->success($userexperience);
            }
        } else {
            return $this->response->forbidden('EventID not present in request');
        }
    }

    public function get_userexperience() {

        $userexperience = $this->userexperience->get_userexperience();
        if($userexperience === 404){
            return $this->response->not_found('User not found');
        } else {
            return $this->response->success($userexperience);
        }
    }

    public function get_userexperience_status() {

        $userexperience_status = $this->userexperience->get_userexperience_status();
        if($userexperience_status === 404){
            return $this->response->not_found('User not found');
        } else {
            return $this->response->success($userexperience_status);
        }
    }

    public function update_userexperience_status() {
        $userexperience_status = $this->userexperience->update_userexperience_status();
        if($userexperience_status === 404){
            return $this->response->not_found('User not found');
        } else {
            return $this->response->success($userexperience_status);
        }
    }

    public function add_userexperience_status() {
        $userexperience_status = $this->userexperience->add_userexperience_status();
        if($userexperience_status === 404){
            return $this->response->not_found('User not found');
        } else {
            return $this->response->success($userexperience_status);
        }
    }
}