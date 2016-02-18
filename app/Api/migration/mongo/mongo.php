<?php
namespace App\Api\migration\mongo;
use Illuminate\Support\Facades\DB;
set_time_limit(0);
class mongo{

	const oldMongo = 'oldMongoDB';
  	const newMongo = 'mongoDB'; 

	function __construct(){
		date_default_timezone_set('Europe/paris');
    }
    
    #It will migrate all accounts at once
    function putAccounts() {
        $count = 0;
        $data = $this->getAccounts();
        if($data == false)
            return 'No data found';

        foreach ($data as $key => $val) {
            $result = DB::connection(mongo::newMongo)
                ->collection('accounts')
                ->insertGetId($val);
            $count++;
        }

        if($count > 0) {
            return $count.' documents inserted!';
        } else {
            return false;
        }
    }

    function getAccounts(){
        $result = DB::connection(mongo::oldMongo)
            ->collection("accounts")
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    function putEventNotes() {
        $data = $this->getEventNotes();
        if($data == false)
            return 'No data found';
        $count = 0;
        foreach ($data as $key => $value) {
            $result = DB::connection(mongo::newMongo)
                ->collection('event_notes')
                ->insertGetId($value);
            $count++;
        }
        if($count > 0) {
            return $count.' documents inserted!';
        } else {
            return false;
        }
    }

    function getEventNotes(){
        $result = DB::connection(mongo::oldMongo)
            ->collection("event_notes")
            // ->where("event_id" , $event_id)
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    function putUserExperience() {
        $data = $this->getUserExperience();
        if($data == false)
            return 'No data found';
        $count = 0;
        foreach ($data as $key => $val) {
            $new = [];
            $user_id = array_key_exists("user", $val) ? $this->getGlobalConfig($val["user"]) : null;
            $new["_id"] = $val["_id"];
            $new["experience"] = $val["experience"];
            $new["user_id"] = $user_id;
            $new["timestamp"] = $val["arrived"];
            
            $result = DB::connection(mongo::newMongo)
            ->collection('user_experience')
            ->insertGetId($new);            
            if($result) {
                $count++;
            }
        }

        if($count > 0) {
            return $count.' documents inserted!';
        } else {
            return false;
        }
    }

    function getUserExperience(){
        $result = DB::connection(mongo::oldMongo)
            ->collection("user_experience")
            // ->where("user" , $username)
            ->get();

        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    function getGlobalConfig($username){
        $result = DB::connection(mongo::oldMongo)
            ->collection("global_config")
            ->select('_id')
            ->where("db_details.username" , $username)
            ->first();
        if($result) {
            return $result;
        } else {
            return null;
        }
    }


	function putUserConfig() {
		$data = $this->getUserConfig();
        if($data == false)
            return 'No data found';
        $count = 0;
        foreach ($data as $key => $value) {
            $result = DB::connection(mongo::newMongo)
                ->collection('user_config')
                ->insertGetId($value);
            if($result){
                $count++;
            }
        }

        if($count > 0) {
            return $count.' documents inserted!';
        } else {
            return false;
        }
    }

    function getUserConfig(){
    	$result = DB::connection(mongo::oldMongo)
            ->collection("user_config")
            // ->where("_id" , $user_id)
            //->where("exchange_id" , intval($exchange_id))
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

	function putExchangeMapping() {
		$data = $this->getStubhubEventsMapping();
        if($data == false)
            return 'No data found';
		$count = 0;
    	foreach ($data as $key => $val) {
    		$new = [];
    		$new["_id"]	= $val["_id"];
    		$new["event_name"] = $val["event_name"];
    		$new["event_date"] = date("Y-m-d", strtotime($val["event_date"]));
    		$new["event_time"] = date("H:m", strtotime($val["event_date"]));
    		$date = new \DateTime($new["event_date"]);
			$new["event_timestamp"] = $date->format("U");
			$new["venue_name"] = "N/A";

            if(array_key_exists("product_name", $val))
			    $new["pos_name"] = explode("-", $val["product_name"])[1];
            else if(array_key_exists("pos_name", $val))
                $new["pos_name"] = $val["pos_name"];
            else
                $new["pos_name"] = "N/A";

            $new["local_event_id"] = array_key_exists("event_id", $val) ? $val["event_id"] : null;
    		$new["source"] = $val["mapping_source"];
    		$new["approve_status"] = 'N/A';
    		$new["exchange_id"] = 1; //for stubhub
    		$new["exchange_event_id"] = $val["stubhub_id"];
    		$new["user"] = $val["user_id"];
    		
            $result = DB::connection(mongo::newMongo)
            ->collection('exchange_mapping')
            ->insertGetId($new);
            if($result){
                $count++;
            }
     	}
        
        if($count > 0) {
            return $count.' documents inserted!';
        } else {
            return false;
        }
    }

    function getStubhubEventsMapping(){
    	$result = DB::connection(mongo::oldMongo)
            ->collection("stubhubEventsMapping")
            // ->where("user_id" , $user_id)
            //->where("exchange_id" , intval($exchange_id))
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }    

    function putStubhubSellerfee() {
		$data = $this->getStubhubSellerfee();
        if($data == false)
            return 'No data found';
		$count = 0;
    	foreach ($data as $key => $val) {
    		$new = [];
    		$new["_id"]	= $val["_id"];
            $new["exchange_event_id"] = array_key_exists("event_id", $val) ? $val["event_id"] : null;
    		$new["buy_percentage"] =  array_key_exists("buy_percentage", $val) ? $val["buy_percentage"] : null;
            $new["delivery_fees"] = array_key_exists("delivery_fees", $val) ? $val["delivery_fees"] : null;
            $result = DB::connection(mongo::newMongo)
            ->collection('stubhub_sellerfee')
            ->insertGetId($new);
            if($result){
                $count++;
            }
     	}

        if($count > 0) {
            return $count.' documents inserted!';
        } else {
            return false;
        }
    }

    function getStubhubSellerfee(){
    	$result = DB::connection(mongo::oldMongo)
            ->collection("price_calculation_settings")
            // ->where("_id" , $event_id)
            //->where("exchange_id" , intval($exchange_id))
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }
}