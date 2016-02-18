<?php

	namespace App\Api\POS;

	/**
	* @author: Mubin
	*/
	class POS
	{
		protected $pos_handler;
		function __construct(POSHandler $pos_handler)
		{
			$this->pos_handler = $pos_handler;
		}
		/**
		 * sets listing sold status
		 * @param array $sold_status contains listing id and status
		 */
		public function set_sold_status($sold_status, $status){
			$response = $this->pos_handler->set_sold_status($sold_status, $status);
			if($response){
				return TRUE;
			}else{
				return FALSE;
			}
		}
		/**
		 * get listing sold status
		 * @param array $sold_status contains listing id and status
		 * @return: $response 	
		 */
		public function get_sold_status($listing_id){
			$response = $this->pos_handler->get_sold_status($listing_id);
			if($response){
				return $response;
			}else{
				return FALSE;
			}
		}
		/**
		 * sets listing sync status
		 * @param array $sync_status contains listing id and status
		 */
		public function set_sync_status($sync_status, $status){
			$response = $this->pos_handler->set_price_sync_status($sync_status, $status);
			if($response){
				return TRUE;
			}else{
				return FALSE;
			}
		}
		/**
		 * get listing sync status
		 * @param array $sync_status contains listing id and status
		 * @return: $response 	
		 */
		public function get_sync_status($listing_id){
			$response = $this->pos_handler->get_price_sync_status($listing_id);
			if($response){
				return $response;
			}else{
				return FALSE;
			}
		}
		/**
		 * sets listing active status
		 * @param array $active_status contains listing id and status
		 */
		public function set_active_status($active_status, $status){
			$response = $this->pos_handler->set_active_status($active_status, $status);
			if($response){
				return TRUE;
			}else{
				return FALSE;
			}
		}
		/**
		 * get listing active status
		 * @param array $active_status contains listing id and status
		 * @return: $response 	
		 */
		public function get_active_status($listing_id){
			$response = $this->pos_handler->get_active_status($listing_id);
			if($response){
				return $response;
			}else{
				return FALSE;
			}
		}
	}