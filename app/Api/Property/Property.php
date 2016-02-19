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
	
	public function addLocation($data){
		DB::beginTransaction();
		try{
			$id = $this->PropertySqlHandler->addLocation($data);
			if(!$id)
				throw new \Exception('Location not inserted in SQL');
			$data['location_id'] = $id;
			$mongoId = $this->PropertyMongoHandler->addLocation($data);
			if(!$mongoId)
				throw new \Exception('Location not inserted in Mongo');
			DB::commit();
			return $id;
		} catch(\Exception $e){
			DB::rollback();
			var_dump($e);
		}
	}

	public function updateLocation($data){
		DB::beginTransaction();
		try{
			$result = $this->PropertySqlHandler->updateLocation($data);
			if(!$result)
				throw new \Exception('Location not updated in SQL');
			$data['location_id'] = intval($data['id']);
			unset($data['id']);
			$mongoResult = $this->PropertyMongoHandler->updateLocation($data);
			if(!$mongoResult)
				throw new \Exception('Location not updated in Mongo');
			
			DB::commit();
			return $result;
		} catch(\Exception $e){
			DB::rollback();
			var_dump($e);
		}
	}

	public function addFeatures($data){
		DB::beginTransaction();
		try{
			$id = $this->PropertySqlHandler->addFeatures($data);
			if(!$id)
				throw new \Exception('Features not inserted in SQL');
			$data['features_id'] = $id;
			$mongoId = $this->PropertyMongoHandler->addFeatures($data);
			if(!$mongoId)
				throw new \Exception('Features not inserted in Mongo');
			DB::commit();
			return $id;
		} catch(\Exception $e){
			DB::rollback();
			var_dump($e);
		}
	}

	public function updateFeatures($data){
		DB::beginTransaction();
		try{
			$result = $this->PropertySqlHandler->updateFeatures($data);
			if(!$result)
				throw new \Exception('Features not updated in SQL');
			$data['features_id'] = intval($data['id']);
			unset($data['id']);
			$mongoResult = $this->PropertyMongoHandler->updateFeatures($data);
			if(!$mongoResult)
				throw new \Exception('Features not updated in Mongo');
			
			DB::commit();
			return $result;
		} catch(\Exception $e){
			DB::rollback();
			var_dump($e);
		}
	}

	public function addProperty($data){
		$user_id = $data['user_id'];
		unset($data['user_id']);
		DB::beginTransaction();
		try{
			$property_id = $this->PropertySqlHandler->addProperty($data);
			if(!$property_id)
				throw new \Exception('Property not inserted in SQL');
			$seller_id = $this->addSeller(['user_id'=>$user_id, 'property_id'=>$property_id]);
			if(!$seller_id)
				throw new \Exception('Seller not inserted in SQL');
			
			$data['property_id'] = $property_id;
			$mongoId = $this->PropertyMongoHandler->addProperty($data);
			if(!$mongoId)
				throw new \Exception('Property not inserted in Mongo');
			DB::commit();
			return $id;
		} catch(\Exception $e){
			DB::rollback();
			var_dump($e);
		}
	}

	public function updateProperty($data){
		DB::beginTransaction();
		try{
			$result = $this->PropertySqlHandler->updateProperty($data);
			if(!$result)
				throw new \Exception('Property not updated in SQL');
			$data['property_id'] = intval($data['id']);
			unset($data['id']);
			$mongoResult = $this->PropertyMongoHandler->updateProperty($data);
			if(!$mongoResult)
				throw new \Exception('Property not updated in Mongo');
			
			DB::commit();
			return $result;
		} catch(\Exception $e){
			DB::rollback();
			var_dump($e);
		}
	}

	public function addSeller($data){
		DB::beginTransaction();
		try{
			$id = $this->PropertySqlHandler->addSeller($data);
			if(!$id)
				throw new \Exception('Seller not inserted in SQL');
			$data['seller_id'] = $id;
			$mongoId = $this->PropertyMongoHandler->addSeller($data);
			if(!$mongoId)
				throw new \Exception('Seller not inserted in Mongo');
			DB::commit();
			return $id;
		} catch(\Exception $e){
			DB::rollback();
			var_dump($e);
		}
	}

	public function updateSeller($data){
		DB::beginTransaction();
		try{
			$result = $this->PropertySqlHandler->updateSeller($data);
			if(!$result)
				throw new \Exception('Seller not updated in SQL');
			$data['seller_id'] = intval($data['id']);
			unset($data['id']);
			$mongoResult = $this->PropertyMongoHandler->updateSeller($data);
			if(!$mongoResult)
				throw new \Exception('Seller not updated in Mongo');
			
			DB::commit();
			return $result;
		} catch(\Exception $e){
			DB::rollback();
			var_dump($e);
		}
	}
}