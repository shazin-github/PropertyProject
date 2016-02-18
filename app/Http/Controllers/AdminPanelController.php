<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session as Session;
use Illuminate\Support\Facades\Response;
use View;
use DB;
use \Log;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\AdminPanel\UsersHandler as Users;

class AdminPanelController extends Controller{
	protected $users, $usersController;
	function __construct(Users $users, UsersController $usersController){
		$this->users = $users;
		$this->usersController =  $usersController;
	}

    public function Index(){
		return View::make('welcome');
    }

    public function Login(Request $request){
    	$data = [ 'email'=> Input::get('email'), 'password'=> Input::get('password') ];
		$rules = [ 'email' => 'required|min:3', 'password' => 'required|min:3' ];
		$validator = Validator::make($data, $rules);

		if($validator->passes()){
	    	if( $this->users->getUser($data['email'], $data['password']) ){
	    		// Session::start();
	    		// Session::put('email', $data['email']);
	    		session(['email'=>$data['email']]);
	    		return Response::json(['success' => true, 'email'=> $data['email'], 'error' => 'No Error']);
	    	} else {
	    		return Response::json(['success' => false, 'error' => 'Invalid Username/Password']);
	    	}
	    } else{
	    	$msg = $validator->messages()->toJson();
			return Response::json(array('success'=>false, 'error' => array($msg)));
	    }
    }

    public function getSignout(){
    	Session::flush();
		return redirect()->route('getadminpanel');
    }

    public function getNotMappedEvents(){
    	return view('NotMappedEvents');
    }

    public function getUsersStats(){
    	return view('UsersStats');
    }

    public function getUsersDetails(){
    	return view('Users');
    }

    public function getAddUserSellerId(){
    	return view('AddUserSellerId');
    }

    public function getAddPosUser(){
    	return view('AddPosUser');
    }

    public function getUserInfo(){
    	$data = [
    		'userInfo' => $this->usersController->get_user_info(),
    	];
        return view('UserInfo')->with('data', $data);
    }

    public function getStats(){
    	if(Input::get('draw') == 2){
    		$draw = '{
		    			  "draw": '.Input::get('draw').',
		    			  "recordsTotal": 1,
		    			  "recordsFiltered": 1,
		    			  "data": [
		    			    [
		    			      "Airi",
		    			      "Satou",
		    			      "Accountant",
		    			      "Tokyo",
		    			      "28th Nov 08",
		    			      "$162,700"
		    			    ]]
		    			}';
    		return $draw;
    	}
    	$draw = Input::get('draw') + 0;
					$data=	'{
		    			  "draw": '.$draw.',
		    			  "recordsTotal": 57,
		    			  "recordsFiltered": 57,
		    			  "data": [
		    			    [
		    			      "Airi",
		    			      "Satou",
		    			      "Accountant",
		    			      "Tokyo",
		    			      "28th Nov 08",
		    			      "$162,700"
		    			    ],
		    			    [
		    			      "Angelica",
		    			      "Ramos",
		    			      "Chief Executive Officer (CEO)",
		    			      "London",
		    			      "9th Oct 09",
		    			      "$1,200,000"
		    			    ],
		    			    [
		    			      "Ashton",
		    			      "Cox",
		    			      "Junior Technical Author",
		    			      "San Francisco",
		    			      "12th Jan 09",
		    			      "$86,000"
		    			    ],
		    			    [
		    			      "Bradley",
		    			      "Greer",
		    			      "Software Engineer",
		    			      "London",
		    			      "13th Oct 12",
		    			      "$132,000"
		    			    ],
		    			    [
		    			      "Brenden",
		    			      "Wagner",
		    			      "Software Engineer",
		    			      "San Francisco",
		    			      "7th Jun 11",
		    			      "$206,850"
		    			    ],
		    			    [
		    			      "Brielle",
		    			      "Williamson",
		    			      "Integration Specialist",
		    			      "New York",
		    			      "2nd Dec 12",
		    			      "$372,000"
		    			    ],
		    			    [
		    			      "Bruno",
		    			      "Nash",
		    			      "Software Engineer",
		    			      "London",
		    			      "3rd May 11",
		    			      "$163,500"
		    			    ],
		    			    [
		    			      "Caesar",
		    			      "Vance",
		    			      "Pre-Sales Support",
		    			      "New York",
		    			      "12th Dec 11",
		    			      "$106,450"
		    			    ],
		    			    [
		    			      "Cara",
		    			      "Stevens",
		    			      "Sales Assistant",
		    			      "New York",
		    			      "6th Dec 11",
		    			      "$145,600"
		    			    ],
		    			    [
		    			      "Cedric",
		    			      "Kelly",
		    			      "Senior Javascript Developer",
		    			      "Edinburgh",
		    			      "29th Mar 12",
		    			      "$433,060"
		    			    ]
		    			  ]
		    			}';    	
    	return $data;
    }
}
