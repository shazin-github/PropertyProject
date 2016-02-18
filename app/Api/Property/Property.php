<?php
namespace App\Api\Property;
use \DB;
use GuzzleHttp\Client as Guzzle;
use App\Api\Property\PropertyqlHandler;
use App\Api\Property\PropertyMongoHandler;
use App\Api\Users\Users;

class Property{
	protected $guzzle;
	protected $PropertySqlHandler;
	protected $PropertyMongoHandler;

	function __construct(Guzzle $guzzle, PropertySqlHandler $PropertySqlHandler, PropertyMongoHandler $PropertyMongoHandler){
		$this->guzzle = $guzzle;
		$this->PropertySqlHandler = $PropertySqlHandler;
		$this->PropertyMongoHandler = $PropertyMongoHandler;
	}
	
	// public function addProperty($data){
	// 	DB::beginTransaction();
	// 	try{
	// 		$id = $this->PropertySqlHandler->addProperty($data);
	// 		if(!$id)
	// 			throw new \Exception('Property not inserted in SQL');
	// 		$data['Property_id'] = $id;
	// 		$mongoId = $this->PropertyMongoHandler->addProperty($data);
	// 		if(!$mongoId)
	// 			throw new \Exception('Property not inserted in Mongo');
	// 		DB::commit();
	// 		return $id;
	// 	} catch(\Exception $e){
	// 		DB::rollback();
	// 		var_dump($e);
	// 	}
	// }

	// public function updateProperty($data){
	// 	DB::beginTransaction();
	// 	try{
	// 		$result = $this->PropertySqlHandler->updateProperty($data);
	// 		var_dump($result);
	// 		if(!$result)
	// 			throw new \Exception('Property not updated in SQL');
	// 		$data['Property_id'] = $data['id'];
	// 		unset($data['id']);
	// 		$mongoResult = $this->PropertyMongoHandler->updateProperty($data);
	// 		if(!$mongoResult)
	// 			throw new \Exception('Property not updated in Mongo');
			
	// 		DB::commit();
	// 		return $result;
	// 	} catch(\Exception $e){
	// 		DB::rollback();
	// 		var_dump($e);
	// 	}
	// }
}