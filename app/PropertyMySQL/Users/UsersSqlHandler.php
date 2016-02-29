<?php
namespace App\PropertyMySQL\Users;
use \DB;

use Illuminate\Support\Facades\Auth;

class UsersSqlHandler{
	
	public function addUser($data){
		$data['created_at'] = date('Y-m-d', strtotime('now'));
		$data['loc_id'] = 1;


		//$data['password'] = \Hash::make($data['password']);
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

	public function userAuthenticate($data){

		//$pass = \Hash::make($data['password']);


		$result = DB::table('users')
			->select('users.id as user_id')
			->where('email' , $data['email'])
			->where('password' , $data['password'])
			->get();

		if($result) {

			return $result[0];
		}
		else
			return false;

	}

	public function checkemail($data){

		$result = DB::table('users')
			->where('email' , $data['email'])
			->get();


		if($result)
			return true;
		else
			return false;


	}

	public function checkusername($data){

		$result = DB::table('users')
			->where('username' , $data['username'])
			->get();


		if($result)
			return true;
		else
			return false;


	}

	public function showUser($data){

		$result = DB::table('users')
			->where('id' , $data['id'])
			->get();


		if($result)
			return $result;
		else
			return false;

	}
}