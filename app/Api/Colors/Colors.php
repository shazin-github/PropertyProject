<?php

	namespace App\Api\Colors;

	use App\Api\Users\Users;
	use App\Api\Helper\Helper;
	use App\Api\Colors\ColorsHandler;



	/**
	* @author: Mubin
	*/
	class Colors
	{
		protected $colors_handler;
		protected $user_id;
		protected $broker_key;
		protected $helper;
		protected $user;
		
		function __construct(ColorsHandler $colors_handler, Users $user, Helper $helper)
		{
			$this->colors_handler = $colors_handler;
			$this->helper = $helper;

		}
		/**
		 * Get Event Color based on $user_id
		 * @param  $user_id
		 * @return $result|FALSE
		 */
		public function get_event_color($user_id){ 
			$result = $this->colors_handler->get_event_color($user_id);
			if($result){
				return $result;
			}
			else{
				return false;
			}
		}
		/**
		 * Get Listing Color based on $user_id
		 * @param  $user_id
		 * @return $result|FALSE
		 */
		public function get_listing_color($user_id){
			$result = $this->colors_handler->get_listing_color($user_id);
			if($result){
				return $result;
			}
			else{
				return false;
			}
		}
		/**
		 * Get Listing Color based on User ID, Event ID
		 * @param  array $data
		 * @return $result|FALSE
		 */
		public function listing_color_by_event($data){
			$result = $this->colors_handler->listing_color_by_event($data);
			if($result){
				return $result;
			}
			else{
				return FALSE;
			}
		}
		/**
		 * Create OR Update Event Color based on User ID and Event ID
		 * @param  array
		 * @return $result|FALSE
		 */
		public function post_event_color($data){
			$event_exist = $this->colors_handler->check_event($data);
			if($event_exist){
				$status = $this->colors_handler->update_event_color($data);
				if($status){
					return 'updated';
					
				}else{
					return 403;
				}
			}else{
				$status = $this->colors_handler->save_event_color($data);
				if($status){
					return 'applied';
				}else{
					return 404;
				}
			}
			
		}
		/**
		 * Create OR Update Listing Color based on User ID and Listing ID
		 * @param  array
		 * @return mixed
		 */

		public function post_listing_color($data){
			if($this->colors_handler->check_listing($data)){
				$status = $this->colors_handler->update_listing_color($data);
				if($status){
					return 'updated';
				}else{
					return 403;
				}
			}else{
				$status = $this->colors_handler->save_listing_color($data);
				if($status){
					return 'applied';
				}else{
					return 404;
				}
			}
		}
		/**
		 * Update Event Color based on User ID and Event ID
		 * @param  array
		 * @return $result|FALSE
		 */

		public function put_event_color($data){
			$event_exist = $this->colors_handler->check_event($data);
			if($event_exist){
				$result = $this->colors_handler->update_event_color($data);
				if ($result) {
					return TRUE;
				} else {
					return FALSE;
				}
			}else{
				return 404;
			}
		}
		/**
		 * Update Listing Color based on User ID and Listing ID
		 * @param  array
		 * @return mixed
		 */

		public function put_listing_color($data) {
			if($this->colors_handler->check_listing($data)){		
				$result = $this->colors_handler->update_listing_color($data);
				if ($result) {
					return TRUE;
				} else {
					return FALSE;
				}
			}else{
				return 404;
			}
		}

		/**
		 * Deletes Event Color based on Event ID and User ID
		 * @param  array
		 * @return bool
		 */
		function delete_event_color($data) {
			$result = $this->colors_handler->delete_event_color($data);
			if ($result) {
				return true;
			} else {
				return false;
			}
		}
		/**
		 * Deletes Listing Color based on Listing ID and User ID
		 * @param  array
		 * @return bool
		 */
		function delete_listing_color($data) {
			$result = $this->colors_handler->delete_listing_color($data);
			if ($result) {
				return true;
			} else {
				return false;
			}
		}

	}