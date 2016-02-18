<?php

namespace App\Http\Middleware;
use App\AdminPanel\UsersHandler as Users;
use App\Api\Response\Response;
use Closure;

class AdminPanel{
    
    protected $users;

    public function __construct(Users $users){
        $this->users = $users;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){

        if(Session::has('email')){
            return $next($request);
        } else if($request::has('email') && $request::has('password')){
            if($users->getUser($request::has('email'), $request::has('password'))){
                return $next($request);
            } else{
                return $this->response->unauthorize("Invalid Email/Password. Please try again");        
            }
            //return response(array(array('error' =>'Api key missing!'), 'code' => 401), 401);
        }
        return $this->response->unauthorize("Your session has expired. Please login again");
    }
}
