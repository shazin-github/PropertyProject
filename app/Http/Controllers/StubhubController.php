<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Api\Response\Response;
use App\Api\Users\Users;
use App\Api\Stubhub\Stubhub;
use App\Api\Helper\Helper;

use App\Http\Controllers\Controller;

class StubhubController extends Controller
{

    protected $stubhub;
    protected $response;
    protected $user;
    protected $user_id;
    protected $broker_key;
    protected $pos_name;
    protected $source;

    function __construct(Response $response, Users $user, Stubhub $stubhub, Helper $helper) {
        $this->response = $response;
        
        $this->broker_key = $helper->get_header_key();
        $this->user = $user;
        $this->user_id = $this->user->get_user_id($this->broker_key);
        $this->stubhub = $stubhub;
        $this->pos_name = array('tn', 'ei', 'tt');
        $this->source = array('manual', 'auto', 'admin');
    }

    public function get_all_stubhub_events(){

        $events = $this->stubhub->get_all_stubhub_events();
        if($events === 404){
            return $this->response->not_found('User not found');
        } else {
            return $this->response->success($events);
        }
    }

    public function add_stubhub_event() {

        if($this->request->has('sh_event_id') && is_numeric('sh_event_id') &&
            $this->request->has('source') && in_array($this->request->input('source'), $this->source) &&
            $this->request->has('event_name') && is_string($this->request->input('event_name')) &&
            $this->request->has('pos_name') && in_array($this->request->input('pos_name'), $this->pos_name)) {

            $event_data = $this->request->all();
            $events = $this->stubhub->add_stubhub_event($event_data);
            if($events === 404){
                return $this->response->not_found('User not found');
            } else {
                return $this->response->success($events);
            }
        } else {
            return $this->response->forbidden('Request Paramaters are incorrect');
        }
    }

    public function get_stubhub_event() {

        if($this->request->has('externl_event_id') && $this->request->has('pos_name')) {
            $externl_event_id = $this->request->input('externl_event_id');
            $pos_name = $this->request->input('pos_name');
            $events = $this->stubhub->get_stubhub_event($externl_event_id, $pos_name);
            if ($events === 404) {
                return $this->response->not_found('User not found');
            } else {
                return $this->response->success($events);
            }
            } else {
                return $this->response->forbidden('Request Paramaters are incorrect');
            }
        }
}
