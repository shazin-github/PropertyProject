<?php
namespace App\PropertyMySQL\Users;
use \DB;
use GuzzleHttp\Client as Guzzle;
use App\PropertyMySQL\Users\UsersSqlHandler;

class Users{
	protected $guzzle;
	protected $UsersSqlHandler;
	//protected $UsersMongoHandler;

	function __construct(Guzzle $guzzle, UsersSqlHandler $UsersSqlHandler){
		$this->guzzle = $guzzle;
		$this->UsersSqlHandler = $UsersSqlHandler;
		//$this->UsersMongoHandler = $UsersMongoHandler;
	}
	
	public function addUser($data){
		//dd($data);
		DB::beginTransaction();
		try{
			$id = $this->UsersSqlHandler->addUser($data);

			DB::commit();
			return $id;
		} catch(\Exception $e){
			DB::rollback();
			var_dump($e);
		}
	}

	public function updateUser($data){
		DB::beginTransaction();
		try{
			$result = $this->UsersSqlHandler->updateUser($data);
			var_dump($result);
			DB::commit();
			return $result;
		} catch(\Exception $e){
			DB::rollback();
			var_dump($e);
		}
	}

	public function userAuthenticate($data){

		$result = $this->UsersSqlHandler->userAuthenticate($data);


		if($result)
			return true;
		else{
			return false;
		}
	}

	public function checkemail($data){

		$result = $this->UsersSqlHandler->checkemail($data);

		if($result)
			return true;
		else{
			return false;
		}

	}

	public function checkusername($data){

		$result = $this->UsersSqlHandler->checkusername($data);

		if($result)
			return true;
		else{
			return false;
		}

	}
}