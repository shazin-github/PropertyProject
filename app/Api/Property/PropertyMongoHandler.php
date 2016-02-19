<?php
namespace App\Api\Property;
use \DB;

class PropertyMongoHandler{
	protected $connMongo = "mongoDB";

	public function addLocation($data){
		$data['created_at'] = date('Y-m-d', strtotime('now'));
		$Id = DB::connection($this->connMongo)->collection('location')->insertGetId($data);
		if($Id)
			return $Id;
		else
			false;
	}

	public function updateLocation($data){
		$data['updated_at'] = date('Y-m-d', strtotime('now'));
		$result = DB::connection($this->connMongo)
				->collection('location')
				->where('location_id', intval($data['location_id']))
				->update($data);
		if($result)
			return $result;
		else
			return false;
	}

	public function addFeatures($data){
		$data['created_at'] = date('Y-m-d', strtotime('now'));
		$Id = DB::connection($this->connMongo)->collection('features')->insertGetId($data);
		if($Id)
			return $Id;
		else
			false;
	}

	public function updateFeatures($data){
		$data['updated_at'] = date('Y-m-d', strtotime('now'));
		$result = DB::connection($this->connMongo)
				->collection('features')
				->where('features_id', intval($data['features_id']))
				->update($data);
		if($result)
			return $result;
		else
			return false;
	}

	public function addProperty($data){
		$data['created_at'] = date('Y-m-d', strtotime('now'));
		$Id = DB::connection($this->connMongo)->collection('property')->insertGetId($data);
		if($Id)
			return $Id;
		else
			false;
	}

	public function updateProperty($data){
		$data['updated_at'] = date('Y-m-d', strtotime('now'));
		$result = DB::connection($this->connMongo)
				->collection('property')
				->where('property_id', intval($data['property_id']))
				->update($data);
		if($result)
			return $result;
		else
			return false;
	}

	public function addSeller($data){
		$data['created_at'] = date('Y-m-d', strtotime('now'));
		$Id = DB::connection($this->connMongo)->collection('seller')->insertGetId($data);
		if($Id)
			return $Id;
		else
			false;
	}

	public function updateSeller($data){
		$data['updated_at'] = date('Y-m-d', strtotime('now'));
		$result = DB::connection($this->connMongo)
				->collection('seller')
				->where('seller_id', intval($data['seller_id']))
				->update($data);
		if($result)
			return $result;
		else
			return false;
	}
}