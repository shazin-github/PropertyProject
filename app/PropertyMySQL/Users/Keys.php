<?php

	namespace App\PropertyMySQL\Users;

	/**
	* @author: Mubin
	*/
	class Keys
	{

		/**
		 * $broker_id  holds broker key captured from request headers
		 * @var mixed
		 */
		
		public $broker_key;

		/**
		 * $user_id 	holds user id from database
		 * @var int
		 */
		
		public $user_id;
	

		function __construct()
		{
			$this->broker_key = false;
			$this->user_id = false;
		}

		/**
		 * set user id and broker key to class properties.
		 * @param mixed $key Broker Key
		 * @param int $id  user id
		 */
		
		public function set($key, $id){
			$this->broker_key = $key;
			$this->user_id = $id;
		}

		/**
		 * Returns assigned Broker Key
		 * @return mixed Broker Key
		 */
		
		public function get_broker_key(){
			return $this->broker_key;
		}

		/**
		 * Return User ID
		 * @return int User ID
		 */
		
		public function get_user_id(){
			return $this->user_id;
		}
	}
