<?php
namespace App\Api\Users;
use \DB;
use GuzzleHttp\Client as Guzzle;
use App\Api\Users\UsersSqlHandler;
use App\Api\Users\UsersMongoHandler;

class Users{
	protected $guzzle;
	protected $UsersSqlHandler;
	protected $UsersMongoHandler;

	function __construct(Guzzle $guzzle, UsersSqlHandler $UsersSqlHandler, UsersMongoHandler $UsersMongoHandler){
		$this->guzzle = $guzzle;
		$this->UsersSqlHandler = $UsersSqlHandler;
		$this->UsersMongoHandler = $UsersMongoHandler;
	}
	
	public function addUser($data){
		DB::beginTransaction();
		try{
			$id = $this->UsersSqlHandler->addUser($data);
			if(!$id)
				throw new \Exception('User not inserted in SQL');
			$data['user_id'] = $id;
			$mongoId = $this->UsersMongoHandler->addUser($data);
			if(!$mongoId)
				throw new \Exception('User not inserted in Mongo');
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
			if(!$result)
				throw new \Exception('User not updated in SQL');
			$data['user_id'] = intval($data['id']);
			unset($data['id']);
			$mongoResult = $this->UsersMongoHandler->updateUser($data);
			if(!$mongoResult)
				throw new \Exception('User not updated in Mongo');
			
			DB::commit();
			return $result;
		} catch(\Exception $e){
			DB::rollback();
			var_dump($e);
		}
	}
}