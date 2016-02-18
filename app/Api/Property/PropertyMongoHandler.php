<?php
namespace App\Api\Property;
use \DB;

class PropertyMongoHandler{
	protected $connMongo = "mongoDB";

	// public function addUser($data){
	// 	$data['created_at'] = date('Y-m-d', strtotime('now'));
	// 	$Id = DB::connection($this->connMongo)->collection('users')->insertGetId($val);
	// 	if($Id)
	// 		return $Id;
	// 	else
	// 		false;
	// }

	// public function updateUser($data){
	// 	$data['updated_at'] = date('Y-m-d', strtotime('now'));
	// 	$result = DB::connection($this->connMongo)
	// 			->collection('users')
	// 			->where('user_id', $data['user_id'])
	// 			->update($data);
	// 	if($result)
	// 		return $result;
	// 	else
	// 		return false;
	// }
}