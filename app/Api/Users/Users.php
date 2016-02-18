<?php

	namespace App\Api\Users;

	use App\Api\Helper\Helper;
	use App\Api\Helper\PlanHelper;
	use \DB;
	use GuzzleHttp\Client as Guzzle;

	/**
	* contains user related functionality
	*/
	class Users
	{
		protected $helper;
		protected $stats;
		protected $plan;
		protected $experience;
		protected $guzzle;

		function __construct(Helper $helper, PlanHelper $plan, Guzzle $guzzle)
		{
			$this->helper = $helper;
			$this->plan = $plan;
			$this->guzzle = $guzzle;
			$this->broker_key = $this->helper->get_header_key();
			$this->user_id = (string)$this->get_user_id($this->broker_key);
		}

		/**
		 * Users::get_user_id()
		 * This function is used to reterive the user_id on the bases of $key
		 * @param mixed $key
		 * @return 
		 */
		
		public function get_user_id($key) {
			$user_id = $this->helper->has_cache($key);
			if(!$user_id){
				$result = DB::table('keys')
					->select('user_id')
					->where('key', '=', $key)
					->take(1)
					->get();
				if($result){
					$user_id = $result[0]->user_id;
					$this->helper->save_cache($key, $user_id);
					return $user_id;
				}else{
					return FALSE;
				}
			}else{
				return $user_id;
			}
		}

		function get_username_by_id($user_id){

			if($user_id) {
				$result = DB::table('userdetails')
						->select('user_name')
						->where('user_id', '=', $user_id)
						->take(1)
						->get();
				if($result){
					$user_name = $result[0]->user_name;
					return $user_name;
				}else{
					return FALSE;
				}
			} else {
				return FALSE;
			}
		}

		function get_all_user_details() {

				$users_detail = [];
				$result = DB::table('userdetails')
						->join('user_plans', 'userdetails.user_id', '=', 'user_plans.user_id')
						->join('plans', 'user_plans.plan_id', '=', 'plans.id')
						->select('userdetails.user_id', 'userdetails.user_name', 'userdetails.user_email',
								'userdetails.user_pass', 'userdetails.user_status', 'user_plans.product_desc',
								'plans.plan_limit')
						->get();
				if($result){
					$user_ids = array();
					$user_ids_str = array();
					foreach($result as $thisUser) {
						$user_ids[] = $thisUser->user_id;
						$user_ids_str[] = strval($thisUser->user_id);
						$user['user_id'] = $thisUser->user_id;
						$user['user_name'] = $thisUser->user_name;
						$user['user_email'] = $thisUser->user_email;
						$user['user_pass'] = $thisUser->user_pass;
						$user['user_product'] = $thisUser->product_desc;
						$user['user_status'] = $thisUser->user_status;
						$user['plan_limit'] = $thisUser->plan_limit;
						$user['total_listings'] = 0;
						$user['active_listings'] = 0;
						$user['daily_listings'] = 0;
						$user['experience'] = "";
						$users_detail[$thisUser->user_id] = $user;
					}
					$total_listings = DB::table('listings_data')
							->select(DB::raw('user_id, count(*) as total_listings'))
							->whereIn('user_id', $user_ids)
							->where('sold_status', '=', 0)
							->groupBy('user_id')
							->get();
					$active_listings = DB::table('listings_data')
							->select(DB::raw('user_id, count(*) as active_listings'))
							->whereIn('user_id', $user_ids)
							->where('active', '=', 1)
							->groupBy('user_id')
							->get();
					$today = date('Y-m-d');
					$daily_listings = DB::table('listings_data')
							->select(DB::raw('user_id, count(*) as daily_listings'))
							->whereIn('user_id', $user_ids)
							->where(DB::raw('date(created)'), '=', $today)
							->where('sold_status', '=', 0)
							->groupBy('user_id')
							->get();
					$user_experience = DB::connection('mongoDB')
							->collection('user_experience')
							->whereIn('_id', $user_ids_str)
							->get();
						foreach($total_listings as $tlist) {
								$users_detail[$tlist->user_id]['total_listings'] = $tlist->total_listings;
						}
						foreach($active_listings as $alist) {
							$users_detail[$tlist->user_id]['active_listings'] = $alist->active_listings;
						}
						foreach($daily_listings as $dlist) {
								$users_detail[$tlist->user_id]['daily_listings'] = $dlist->daily_listings;
						}
						foreach($user_experience as $experience) {
							$users_detail[$tlist->user_id]['experience'] = $experience['experience'];
						}
				}
			return $users_detail;
		}

		function get_user_info($user_id) {
			$result = DB::table('userdetails')
					->leftJoin('seller_ids', 'userdetails.user_id', '=', 'seller_ids.user_id')
					->join('user_plans', 'userdetails.user_id', '=', 'user_plans.user_id')
					->leftJoin('user_version', 'userdetails.user_id', '=', 'user_version.user_id')
					->select('userdetails.*', 'seller_ids.seller_id', 'user_plans.plan_id', 'user_version.version', 'user_version.update_version')
					->where('userdetails.user_id', '=', $user_id)
					->take(1)
					->get();
			$user_mongo = DB::connection('mongoDB')
					->collection('user_config')
					->where('_id', $user_id)
					->get();
			$result[0]->mongo = $user_mongo;
			return $result;
		}

		public function get_seller_id($user_id) {

			if($user_id) {
				$result = DB::table('seller_ids')
						->select('seller_id')
						->where('user_id', '=', $user_id)
						->take(1)
						->get();
				if($result){
					$seller_id = $result[0]->seller_id;
					return $seller_id;
				}else{
					return FALSE;
				}
			} else {
				return FALSE;
			}
		}

		public function get_all_plans() {
			return $this->plan->get_all_plans();
		}

		public function plan_change($user_id, $plan_id) {
			$check = DB::table('user_plans')
					->select('user_plans.plan_id', 'plans.plan_limit')
					->where('user_plans.user_id', '=', $user_id)
					->join('plans', 'user_plans.plan_id', '=', 'plans.id')
					->take(1)
					->get();
			if($check) {
				$plan_limit = $check[0]->plan_limit;
				$result = DB::table('user_plans')
					->where('user_id', '=', $user_id)
					->update([
						'plan_id' => $plan_id
					]);
			if($result){
				$user_mongo = DB::connection('mongoDB')
						->collection('user_config')
						->where('_id', strval($user_id))
						->update([
								'listing_capacity' => $plan_limit
						]);
				return TRUE;
			}else{
				return FALSE;
			}
			} else {
				return 404;
			}
		}

		public function add_seller_id($user_id, $seller_id) {
			$check = DB::table('seller_ids')
				->select('seller_id')
				->where('user_id', '=', $user_id)
				->take(1)
				->get();
			if(!$check) {
				$result = DB::table('seller_ids')
					->insertGetId([
						'seller_id' => $seller_id,
						'user_id' => $user_id
					]);
				return TRUE;
			} else {
				$result = DB::table('seller_ids')
					->where('user_id', '=', $user_id)
					->update([
						'seller_id' => $seller_id
					]);
				return FALSE;
			}
		}

		public function update_seller_id($user_id, $seller_id) {
			$check = DB::table('seller_ids')
				->select('seller_id')
				->where('user_id', '=', $user_id)
				->take(1)
				->get();
			if($check) {
				$result = DB::table('seller_ids')
					->where('user_id', '=', $user_id)
					->update([
						'seller_id' => $seller_id
					]);
				if($result){
					return TRUE;
				}else{
					return FALSE;
				}
			} else {
				return 404;
			}
		}

		public function update_password($user_id, $password) {
			$check = DB::table('userdetails')
				->select('user_pass')
				->where('user_id', '=', $user_id)
				->take(1)
				->get();
			if($check) {
				$result = DB::table('userdetails')
					->where('user_id', '=', $user_id)
					->update([
						'user_pass' => $password
					]);
				if($result){
					return TRUE;
				}else{
					return FALSE;
				}
			} else {
				return 404;
			}
		}

		public function update_productname($user_id, $productname) {
			$check = DB::table('user_plans')
				->select('product_desc')
				->where('user_id', '=', $user_id)
				->take(1)
				->get();
			if($check) {
				$result = DB::table('user_plans')
					->where('user_id', '=', $user_id)
					->update([
						'product_desc' => $productname
					]);
				if($result){
					$user_mongo = DB::connection('mongoDB')
						->collection('user_config')
						->where('_id', strval($user_id))
						->update([
							'product_name' => $productname
						]);
					return TRUE;
				}else{
					return FALSE;
				}
			} else {
				return 404;
			}
		}

		public function update_version($user_id, $version) {
			$check = DB::table('user_version')
				->select('version')
				->where('user_id', '=', $user_id)
				->take(1)
				->get();
			if($check) {
				$result = DB::table('user_version')
					->where('user_id', '=', $user_id)
					->update([
						'version' => $version,
						'update_date' => date('Y-m-d h:i:s'),
						'update_version' => 1,
					]);
				if($result){
					return TRUE;
				}else{
					return FALSE;
				}
			} else {
				return 404;
			}
		}

		public function update_version_bit($user_id, $version_bit) {
			$check = DB::table('user_version')
				->select('version')
				->where('user_id', '=', $user_id)
				->take(1)
				->get();
			if($check) {
				$result = DB::table('user_version')
					->where('user_id', '=', $user_id)
					->update([
						'update_version' => $version_bit,
						'update_date' => date('Y-m-d h:i:s')
					]);
				if($result){
					return TRUE;
				} else {
					return FALSE;
				}
			} else {
				return 404;
			}
		}

		public function get_products() {
			$products = [
				'pricegenius-tn',
				'pricegenius-ei',
				'pricegenius-tt',
				'pricegenius-vs',
				'pricegenius-tu',
				'autopricer-tn',
				'autopricer-ei',
				'autopricer-tt',
				'autopricer-vs',
				'autopricer-tu'
			];
				return $products;
		}

		public function get_versions() {
			$tags = $this->guzzle_request("https://api.github.com/repos/brokergenius/pricegenius_laravel/tags");
			$versions = [];
			foreach($tags as $version) {
				$versions[] = $version->name;
			}
			if($tags == null) return 404;
			return $versions;
		}

		public function update_status($user_id, $status) {
			$check = DB::table('userdetails')
				->select('user_id')
				->where('user_id', '=', $user_id)
				->take(1)
				->get();
			if($check) {
				$result = DB::table('userdetails')
					->where('user_id', '=', $user_id)
					->update([
						'user_status' => $status
					]);
				if($result){
					return TRUE;
				} else {
					return FALSE;
				}
			} else {
				return 404;
			}
		}

		public function add_user($data) {
			$user_id = $data['_id'];
			$check = DB::connection('mongoDB')
				->collection('user_config')
				->where('_id', '=', $user_id)
				->get();
			if(!$check) {
				$result = DB::connection('mongoDB')
					->collection('user_config')
					->insertGetId($data);
				return TRUE;
			} else {
				$result = DB::connection('mongoDB')
					->collection('user_config')
					->where('_id', '=', $user_id)
					->update($data);
				return FALSE;
			}
		}

		function guzzle_request($url) {
			try {
				$this->guzzle->setDefaultOption('verify', false);
				$res = $this->guzzle->get($url, [
					'headers' => [
						'User-Agent' => 'davidandrof',
						'Authorization'     => 'token 3223e87b3952181273bff2e0fa806f8364d439a7',
						'verify' => false
					]
				]);
				$data = $res->getBody(true);
			}
			catch (ClientException $e) {
				$response = $e->getResponse();
				$data = $response->getBody(true)->getContents();
			}
			return json_decode($data);
		}
	}