<?php

	namespace App\Api\Colors;

	use \DB;

	/**
	* @author: Mubin
	*/
	class ColorsHandler
	{
		
		function __construct()
		{
			
		}

		public function get_event_color($user_id){
			$result = DB::table('event_colors')
				->select('event_id', 'color_code', 'end_date')
				->where('user_id', $user_id)
				->get();
			if($result){
				return $result;
			}else{
				return FALSE;
			}
		}
		public function get_listing_color($user_id){
			$result = DB::table('listings_color')
				->select('event_id', 'ticket_id', 'color_code')
				->where('user_id', $user_id)
				->get();
			if($result){
				return $result;
			}else{
				return FALSE;
			}
		}
		public function listing_color_by_event($data){
			$result = DB::table('listings_color')
				->select('event_id', 'ticket_id', 'color_code')
				->where('user_id', $data['user_id'])
				->where('event_id', $data['event_id'])
				->get();
			if($result){
				return $result;
			}else{
				return FALSE;
			}
		}
		public function check_event($data){
			$result = DB::table('event_colors')
				->where('user_id', $data['user_id'])
				->where('event_id', $data['event_id'])
				->get();
			if($result){
				return TRUE;
			}else{
				return FALSE;
			}
		}
		public function update_event_color($data){
			$update = ['color_code' => $data['color_code'],'num_of_days'=>$data['num_of_days'],'end_date'=>$data['end_date']];
			 $status = DB::table('event_colors')
				->where('user_id', $data['user_id'])
				->where('event_id', $data['event_id'])
				->update($update);
			if ($status) {
				return true;
			} else {
				return false;
			}
		}
		public function save_event_color($data){
				$create = [
					'user_id' => $data['user_id'], 
					'color_code' => $data['color_code'],
					'event_id' => $data['event_id'], 
					'date' => $data['event_date'],
					'num_of_days'=> $data['num_of_days'],
					'end_date'=>$data['end_date']
				];
			$status = DB::table('event_colors')
				->insert($create);
			if ($status) {
				return true; 
			} else {
				return false;
			}
		}
		public function check_listing($data){
			$result = DB::table('listings_color')
				->where('user_id', $data['user_id'])
				->where('ticket_id', $data['listing_id'])
				->get();
			if($result){
				return TRUE;
			}else{
				return FALSE;
			}
		}
		public function update_listing_color($data){
			$update = ['color_code' => $data['color_code']];
			$result = DB::table('listings_color')
				->where('user_id', $data['user_id'])
				->where('ticket_id', $data['listing_id'])
				->update($update);
			if($result){
				return TRUE;
			}else{
				return FALSE;
			}
		}
		public function save_listing_color($data){
			$create = [
					'user_id' => $data['user_id'], 
					'color_code' => $data['color_code'],
					'ticket_id' => $data['listing_id'], 
					'event_id' => $data['event_id']
				];
			$status = DB::table('listings_color')
				->insert($create);
			if ($status) {
				return true; 
			} else {
				return false;
			}
		}
		public function delete_listing_color($data){
			$result = DB::table('listings_color')
				->where('user_id', $data['user_id'])
				->where('ticket_id', $data['listing_id'])
				->delete();
			if($result){
				return true;
			}else{
				return false;
			}
		}
		public function delete_event_color($data){
			$result = DB::table('event_colors')
				->where('user_id', $data['user_id'])
				->where('event_id', $data['event_id'])
				->delete();
			if($result){
				$result = DB::table('listings_color')
					->where('user_id', $data['user_id'])
					->where('event_id', $data['event_id'])
					->delete();
				if($result){
					return true;
				}else{
					return false;
				}
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}