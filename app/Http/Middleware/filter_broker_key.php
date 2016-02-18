<?php

namespace App\Http\Middleware;
use App\Api\Response\Response;
use App\Api\Users\Keys;
use App\Api\Users\Users;
use App\Api\Helper\Helper;
use Closure;
use App\Jobs\Logs;
use Illuminate\Foundation\Bus\DispatchesJobs;
use \Carbon\Carbon;

class filter_broker_key
{
    protected $response;
    protected $helper;
    protected $keys;
    protected $users;
    protected $rabbit;
    use DispatchesJobs;
    public function __construct(Response $response, Helper $helper, Keys $keys, Users $users){
        $this->response = $response;
        $this->helper = $helper;
        $this->keys = $keys;
        $this->users = $users;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($this->helper->has_broker_key()){
            return $this->response->unauthorize();
        }
        if(!$this->helper->has_header_key()){
            //return response(array(array('error' =>'Api key missing!'), 'code' => 401), 401);
            return $this->response->unauthorize("You're not authorize to access. Make sure that you're passing your Broker Key");
        }
        $broker_key = $this->helper->get_header_key();
        $user_id = $this->users->get_user_id($broker_key);
        if(!$user_id){
            return $this->response->unauthorize();
        }
        $this->keys->set($broker_key, $user_id);
        if($request->method() != 'GET'){
            $message = [
                "user_id" => $user_id,
                "method" => $request->method(),
                "requested_url" => $request->url(),
                "request_body" => $request->all(),
                "requested_at" => Carbon::now()
            ];
            $job = (new Logs($message))->onQueue('api_logs');
            $this->dispatch($job);
        }    
        return $next($request);
    }

    public function get(){
        return ['broker_key' => $this->keys->get_broker_key(), "user_id" => $this->keys->get_user_id()];
    }
}
