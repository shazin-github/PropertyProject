<?php

	namespace App\PropertyMySQL\Response;

	//Use base status codes
	use Illuminate\Http\Response as code;
	use \Response as http;
	/**
	 * Returns proper HTTP Response Codes with delgated data/message.
	 * @author: Mubin
	 */
	class Response{

		/**
		 * Return HTTP 400 and delegeated error message
		 * @param  string $message message to respond with
		 * @return HTTP Response          Returns HTTP Response object with 400 status code
		 */

		public function bad_request($message){
			if(!is_array($message))	$message = [$message];
			return http::json(
				[
					"error" => $message,
					"status_code" => code::HTTP_BAD_REQUEST
				],
				code::HTTP_BAD_REQUEST
			);
		}

		/**
		 * Return HTTP 401 and delegeated error message
		 * @param  string $message message to respond with
		 * @return HTTP Response          Returns HTTP Response object with 400 status code
		 */
		public function unauthorize($message = "You're not authorize to access"){
			if(!is_array($message))	$message = [$message];
			return http::json(
				[
					"error" => $message,
					"status_code" => code::HTTP_UNAUTHORIZED
				],
				code::HTTP_UNAUTHORIZED
			);
		}
		/**
		 * Returns HTTP 200 code with provided data
		 * @param  array  $data Data to return on success
		 * @return HTTP Response       returns data with 200, OR, 404 if found nothing
		 */
		public function success($data = [], $type = "success"){
			if(!is_array($data))	$data = [$data];
			if($data){
				return http::json(
					[
						$type => $data,
						"status_code" => code::HTTP_OK
					],
					code::HTTP_OK
				);
			}else{
				return http::json(
					[
						$type => '',
						"status_code" => code::HTTP_OK
					],
					code::HTTP_OK
				);
			}
		}
		/**
		 * Returns 404 and delegeated error message
		 * @param  string $message message to respond with
		 * @return HTTP Response          Returns HTTP Response object with 404 status code
		 */
		public function not_found($message = "Requested object could not be located"){
			if(!is_array($message))	$message = [$message];
			return http::json(
				[
					"error" => $message,
					"status_code" => code::HTTP_NOT_FOUND
				],
				code::HTTP_NOT_FOUND
			);
		}
		/**
		 * Returns 403 and delegeated error message
		 * @param  string $message Message to return back to consumer
		 * @return  HTTP Response  Returns HTTP Response object with 403 status code
		 */
		public function forbidden($message = "Forbidden"){
			if(!is_array($message))	$message = [$message];
			return http::json(
				[
					"error" => $message,
					"status_code" => code::HTTP_FORBIDDEN
				],
				code::HTTP_FORBIDDEN
			);
		}
		//array("error" => array('message'));
		public function application_error($message){
			if(!is_array($message))	$message = [$message];
			return http::json(
				[
					"error" => $message,
					"status_code" => code::HTTP_INTERNAL_SERVER_ERROR
				],
				code::HTTP_INTERNAL_SERVER_ERROR
			);
		}

	}