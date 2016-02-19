<?php
namespace App\Api\Property;
use \DB;

class PropertySqlHandler{
	
	public function addLocation($data){
		$data['created_at'] = date('Y-m-d', strtotime('now'));
		$id = DB::table('location')->insertGetId($data);
		if($id)
			return $id;
		else
			return false;
	}

	public function updateLocation($data){
		$data['updated_at'] = date('Y-m-d', strtotime('now'));
		$result = DB::table('location')->where('id', $data['id'])->update($data);
		if($result)
			return $result;
		else
			return false;
	}

	public function addFeatures($data){
		$data['created_at'] = date('Y-m-d', strtotime('now'));
		$id = DB::table('features')->insertGetId($data);
		if($id)
			return $id;
		else
			return false;
	}

	public function updateFeatures($data){
		$data['updated_at'] = date('Y-m-d', strtotime('now'));
		$result = DB::table('features')->where('id', $data['id'])->update($data);
		if($result)
			return $result;
		else
			return false;
	}

	public function addProperty($data){
		$data['created_at'] = date('Y-m-d', strtotime('now'));
		$id = DB::table('property')->insertGetId($data);
		if($id)
			return $id;
		else
			return false;
	}

	public function updateProperty($data){
		$data['updated_at'] = date('Y-m-d', strtotime('now'));
		$result = DB::table('property')->where('id', $data['id'])->update($data);
		if($result)
			return $result;
		else
			return false;
	}

	public function addSeller($data){
		$data['created_at'] = date('Y-m-d', strtotime('now'));
		$id = DB::table('seller')->insertGetId($data);
		if($id)
			return $id;
		else
			return false;
	}

	public function updateSeller($data){
		$data['updated_at'] = date('Y-m-d', strtotime('now'));
		$result = DB::table('seller')->where('id', $data['id'])->update($data);
		if($result)
			return $result;
		else
			return false;
	}
}