<?php

	namespace App\Api\POS;
	use \DB;
	/**
	* @author: Mubin
	*/
	class POSHandler
	{
		
		function __construct()
		{
			
		}
		/**
		 * set listing sold status in db
		 * @param array $status listing_id, sold_status
		 * @return: bool   TRUE|FALSE
		 */
		public function set_sold_status($listing_id ,$status){
			$update = DB::table('listings_data')
				->whereIn('listing_id', $listing_id)
				->update($status);
			if($update){
				if($status['sold_status'] === '1'){
					$component_id = $this->get_component_id($listing_id);
					$this->set_active_status($listing_id, ['active' => 0]);
					$this->delete($component_id, $listing_id);
				}
				return TRUE;
			}else{
				return FALSE;
			}
		}
		/**
		 * get listing sold status from db
		 * @param int $listing_id listing_id
		 * @return: mixed   TRUE|FALSE
		 */
		public function get_sold_status($listing_id){
			$result = DB::table('listings_data')
				->whereIn('listing_id', $listing_id)
				->select('listing_id', 'sold_status')
				->get();
			if($result){
				return $result;
			}else{
				return FALSE;
			}
		}
		/**
		 * set listing price_sync status in db
		 * @param array $status listing_id, price_sync_status
		 * @return: bool   TRUE|FALSE
		 */
		public function set_price_sync_status($listing_id ,$status){
			$component_id = $this->get_component_id($listing_id);
			$update = DB::table('listings_data')
				->whereIn('listing_id', $listing_id)
				->update($status);
			if($update){
				return TRUE;
			}else{
				return FALSE;
			}
		}
		/**
		 * get listing price_sync status from db
		 * @param int $listing_id listing_id
		 * @return: mixed   TRUE|FALSE
		 */
		public function get_price_sync_status($listing_id){
			$result = DB::table('listings_data')
				->whereIn('listing_id', $listing_id)
				->select('listing_id', 'price_sync_status')
				->get();
			if($result){
				return $result;
			}else{
				return FALSE;
			}
		}
		/**
		 * set listing active status in db
		 * @param array active_status
		 * @return: bool   TRUE|FALSE
		 */
		public function set_active_status($listing_id ,$status){
			$component_id = $this->get_component_id($listing_id);
			$update = DB::table('listings_data')
				->whereIn('listing_id', $listing_id)
				->update($status);
			if($update){
				return TRUE;
			}else{
				return FALSE;
			}
		}
		/**
		 * get listing active status in db
		 * @param int $listing_id listing_id
		 * @return: mixed   TRUE|FALSE
		 */
		public function get_active_status($listing_id){
			$result = DB::table('listings_data')
				->whereIn('listing_id', $listing_id)
				->select('listing_id', 'active')
				->get();
			if($result){
				return $result;
			}else{
				return FALSE;
			}
		}

		public function get_component_id($listing_id){
			$result = DB::table('listings_data')
				->whereIn('listing_id', $listing_id)
				->select('component_id')
				->get();
			if($result){
				return $result[0]->component_id;
			}else{
				return false;
			}
		}

		public function delete($component_id, $listing_id){
			if($component_id == 1){
				$table = "listings_criteria";
			}elseif($component_id == 2){
				$table = "autogroup_listings";
			}elseif($component_id == 3){
				$table = "manual_group_listings";
			}
			DB::table($table)
				->whereIn("listing_id", $listing_id)
				->delete();
			return true;
		}
	}