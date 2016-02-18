<?php

	namespace App\Api\Helper;

	use Illuminate\Http\Request;
	use \Cache;

	class Helper{
		protected $request;
		public function __construct(Request $request){
			$this->request = $request;
		}
		/**
		 * Filters the Requests(GET, POST) against the Broker-Key
		 * @return bool TRUE|FALSE [depends either Broker Key is present in request or not]
		 */
		public function has_broker_key(){
			if($this->request->has('Broker-Key')){
				return TRUE;
			}else{
				return FALSE;
			}
		}
		/**
		 * visualize the HTTP Headers and returns true|false on the basis of Broker-Key 
		 * @return boolean TRUE|FALSE
		 */
		public function has_header_key(){
			if($this->request->headers->get('Broker-Key')){
				return TRUE;
			}else{
				return FALSE;
			}
		}
		/**
		 *Get and returns the Broker-Key from HTTP Header
		 * @return void 
		 */
		public function get_header_key(){
			return $this->request->headers->get('Broker-Key');
		}
		/**
		 * Checks Cache and returns TRUE|FALSE on the basis of provided key
		 * @param  mixed  $key Key to check from Cache
		 * @return boolean      TRUE|FALSE
		 */
		public function has_cache($key){
			if(Cache::has($key)){
				return Cache::get($key);
			}else{
				return FALSE;
			}
		}

		/**
		 * save key values to Chache
		 * @param  mixed $key   Key to store in Cache
		 * @param  mixed $value Value to store on specified Key
		 * @return void        
		 */
		public function save_cache($key, $value, $minutes = 60){
			Cache::put($key, $value, $minutes);
		}

		/**
		 * Get Exchange By ID
		 * @param $exchange_id
		 * @return string
         */
		public function get_exchange($exchange_id) {
			$exchange = array("", "stubhub" => 1, "vividseat" => 2, "utils" => 3);
			return array_search($exchange_id, $exchange);
		}
	}