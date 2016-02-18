<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Api\Profiles\Profiles;
Use App\Api\Response\Response;
use \Validator;

class ProfilesController extends Controller
{
	protected $profiles;
	protected $request;
	protected $response;

	public function __construct(Profiles $profiles, Request $request, Response $response){
		$this->profiles = $profiles;
		$this->request = $request;
		$this->response = $response;
	}

	public function get_profile_by_venue(){

		$validator = Validator::make($this->request->all(),[
			'venue_id' => 'required'
		]);
		if ($validator->fails()) {
			return $this->response->bad_request($validator->errors()->all());
		}

		$venue_id = $this->request->input('venue_id');
		$profiles = $this->profiles->get_profiles($venue_id);
		if($profiles === 404){
			return $this->response->not_found('User not found');
		} else {
			return $this->response->success($profiles);
		}
	}

	public function get_profile_types(){
			$profile_type = $this->profiles->get_profile_types();
			if($profile_type === 404){
				return $this->response->not_found('User not found');
			} else {
				return $this->response->success($profile_type);
			}
		}

	public function create_profile(){

		$validator = Validator::make($this->request->all(),[
			'profile_name' => 'required',
			'venue_id' => 'required',
			'profile_type_id' => 'required',
			'criteria' => 'required',
		]);
		if ($validator->fails()) {
			return $this->response->bad_request($validator->errors()->all());
		}

		$profile_name = $this->request->input('profile_name');
		$venue_id = $this->request->input('venue_id');
		$profile_type_id = $this->request->input('profile_type_id');
		$criteria = $this->request->input('criteria');
		$profiles = $this->profiles->create_profile($profile_name, $venue_id, $profile_type_id, $criteria);
		if($profiles === 404){
			return $this->response->not_found('User not found');
		} else {
			return $this->response->success('Profile Created Successfully');
		}
	}

	public function duplicate_profile(){

		$validator = Validator::make($this->request->all(),[
			'clone_of' => 'required',
			'splits' => 'required',
			'increment' => 'required',
			'ceiling' => 'required',
			'floor' => 'required',
			'profile_name' => 'required'
		]);
		if ($validator->fails()) {
			return $this->response->bad_request($validator->errors()->all());
		}

		$clone_of = $this->request->input('clone_of');
		$splits = $this->request->input('splits');
		$increment = $this->request->input('increment');
		$ceiling = $this->request->input('ceiling');
		$floor = $this->request->input('floor');
		$profile_name = $this->request->input('profile_name');
		$profiles = $this->profiles->duplicate_profile($profile_name, $clone_of, $splits, $increment, $ceiling, $floor);
		if($profiles === 404){
			return $this->response->not_found('User not found');
		} elseif($profiles === 403) {
			return $this->response->not_found('Profile not found');
		} else {
			return $this->response->success('Profile Duplicated Successfully');
		}
	}

	public function update_profile(){

		$validator = Validator::make($this->request->all(),[
			'profile_id' => 'required',
			'profile_type_id' => 'required',
			'profile_name' => 'required',
			'splits' => 'required',
			'increment' => 'required',
			'increment_type' => 'required',
			'ceiling' => 'required',
			'floor' => 'required'
		]);
		if ($validator->fails()) {
			return $this->response->bad_request($validator->errors()->all());
		}

			$profile_id = $this->request->input('profile_id');
			$profile_type_id = $this->request->input('profile_type_id');
			$profile_name = $this->request->input('profile_name');
			$splits = $this->request->input('splits');
			$increment_type = $this->request->input('increment_type');
			$increment = $this->request->input('increment');
			$ceiling = $this->request->input('ceiling');
			$floor = $this->request->input('floor');
			$profiles = $this->profiles->update_profile_criteria($profile_name, $profile_type_id, $profile_id, $splits,
					$increment_type, $increment, $ceiling, $floor);
			if($profiles === 404){
				return $this->response->not_found('User not found');
			} elseif($profiles === 403 || !$profiles) {
				return $this->response->not_found('Profile Not Found');
			} else {
				return $this->response->success('Profile Updated Successfully');
			}
	}

	public function delete_profile() {

		$validator = Validator::make($this->request->all(),[
			'profile_id' => 'required'
		]);
		if ($validator->fails()) {
			return $this->response->bad_request($validator->errors()->all());
		}

		$profile_id = $this->request->input('profile_id');
		$profiles = $this->profiles->delete_profile($profile_id);
		if($profiles === 404){
			return $this->response->not_found('User not found');
		} elseif(!$profiles) {
			return $this->response->not_found('Profile Not Found');
		} else {
			return $this->response->success('Profile Deleted Successfully');
		}
	}

	public function update_listings_criteria() {

		$validator = Validator::make($this->request->all(),[
			'profile_id' => 'required',
			'listings' => 'required',
			'event_id' => 'required'
		]);
		if ($validator->fails()) {
			return $this->response->bad_request($validator->errors()->all());
		}

		$profile_id = $this->request->input('profile_id');
		$listings = $this->request->input('listings');
		$event_id = $this->request->input('event_id');
		$profiles = $this->profiles->update_listings_criteria($listings, $profile_id, $event_id);
		if($profiles === 404){
			return $this->response->not_found('User not found');
		} elseif($profiles === 403) {
			return $this->response->forbidden('User Account Listings limit reached');
		} else {
			return $this->response->success('Listings Criteria Updated Successfully');
		}
	}

}
