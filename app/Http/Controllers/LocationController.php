<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use \Validator;
use \Cache;
Use App\Api\Response\Response;

use App\Api\Users\Users;

class LocationController extends Controller{
    protected $request;
    protected $response;
    protected $users;

    public function __construct(Request $request, Response $response, Users $users){
        $this->request = $request;
        $this->response = $response;
        $this->users = $users;
    }

}