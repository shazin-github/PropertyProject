<?php

	namespace App\Api\Notifications;
	use \Config;
	use \Mail;
	use GuzzleHttp\Client;
	/**
	 * pushes notifications to emails and Slack 
	 * @author: Mubin
	*/
	class Notifications
	{
		protected $client;
		function __construct(Client $client)
		{
			$this->client = $client;
		}
		/**
		 * Push Notifications to slack
		 * @param json $notification json object having message and channel
		 * @return mixed
		 */
		public function slack($notification){
			$webhook = config::get('slack')['webhook'];
			$headers = [
				'Content-Type' => 'application/json',
			];
			$body = json_encode(['text' => $notification['message'], 'channel' => "#$notification[channel]"]);
			$resp = $this->client->post(
					$webhook,
					[
							'headers' => $headers,
							'body' => $body,
							'verify' => FALSE,
							'exceptions' => false
					]);
			return $resp->getBody();
		}
		/**
		 * send email to support
		 * @param  array $notification notification to send
		 * @return bool 	true
		 */
		public function email($notification){
			$user = [];
			Mail::send('email', ['email_to_send' => $notification['message']], function ($m) use ($notification){
	            $m->from('support@brokergenius.com', 'Bug Reporter');

	            $m->to($notification['email'], "Support")->subject('API Notification');
	        });

	        return true;
		}
	}
