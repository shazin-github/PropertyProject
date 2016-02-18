<?php
namespace App\Api\Users;
use \DB;

class UsersSqlHandler{
	
	public function addUser($data){
		$data['created_at'] = date('Y-m-d', strtotime('now'));
		$id = DB::table('users')->insertGetId($data);
		if($id)
			return $id;
		else
			return false;
	}

	public function updateUser($data){
		$data['updated_at'] = date('Y-m-d', strtotime('now'));
		$result = DB::table('users')->where('id', $data['id'])->update($data);
		if($result)
			return $result;
		else
			return false;
	}
}