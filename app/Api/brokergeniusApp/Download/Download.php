<?php

namespace App\Api\brokergeniusApp\Download;

use App\Api\Users\Users;
use App\Api\Helper\Helper;
use App\Api\brokergeniusApp\Download\DownloadHandler;
use App\Api\Helper\PlanHelper;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Exception\ClientException;

class Download
{

    protected $download_handler;
    protected $user_id;
    protected $broker_key;
    protected $helper;
    protected $plan_helper;
    protected $user;
    protected $response;
    protected $pos_name;
    protected $guzzle;

    function __construct(DownloadHandler $download_handler, Users $user, Helper $helper, PlanHelper $plan_helper, Guzzle $guzzle)
    {
        $this->download_handler = $download_handler;
        $this->helper = $helper;
        $this->plan_helper = $plan_helper;
        $this->guzzle = $guzzle;
        $this->user = $user;
        $this->broker_key = $this->helper->get_header_key();
        $this->user_id = (string)$this->user->get_user_id($this->broker_key);
    }

    /**
     * Download Data
     * @return int|\Psr\Http\Message\StreamInterface|string
     */
    function get_data() {

        $user_id = $this->user_id;

        $user_date = $this->download_handler->get_download_date($user_id);

        $last_update_date = $this->download_handler->get_latest_update_date();

        if (!empty($user_date)) {

            $resp = $this->guzzle_request("https://api.github.com/repos/davidandorf/pricegenius_secure/commits?since=" .
                $user_date);
            if ($last_update_date > $user_date) {
                return 404; // "error" => "No Updates Available"
            } else {

                $date = date('Y-m-d h:i:s');
                $date1 = strtotime($date);
                $this->download_handler->update_download_date($user_id, $date1);
                $data = $this->guzzle_request("https://api.github.com/repos/davidandorf/pricegenius_secure/zipball");
                header("Content-Type: application/zip");
                header("Content-Disposition: attachment; filename=pricegenius");
                if($data == null) return 404;
                return $data;
            }
        } else {
            $date = date('Y-m-d h:i:s');
            $date1 = strtotime($date);
            $this->download_handler->update_download_date($user_id, $date1);
            $data = $this->guzzle_request("https://api.github.com/repos/davidandorf/pricegenius_secure/zipball");
            header("Content-Type: application/zip");
            header("Content-Disposition: attachment; filename=pricegenius");
            if($data == null) return 404;
            return $data;
        }
    }

    /**
     * Download Data V3
     * @return int|\Psr\Http\Message\StreamInterface|string
     */
    function get_dataV3() {

        $user_id = $this->user_id;

        $user_date = $this->download_handler->get_download_date($user_id);

        $last_update_date = $this->download_handler->get_latest_update_date();

        if (!empty($user_date)) {

            $resp = $this->guzzle_request("https://api.github.com/repos/davidandorf/pricegenius_secure/commits?since=" .
                $user_date);

            if ($last_update_date < $user_date) {
                return 404; // "error" => "No Updates Available"
            } else {

                $date = date('Y-m-d h:i:s');
                $date1 = strtotime($date);
                $this->download_handler->update_download_date($user_id, $date1);
                $data = $this->guzzle_request("https://api.github.com/repos/davidandorf/pricegenius_v3/releases/latest");
                $data1 = $this->guzzle_request($data['zipball_url']);
                header("Content-Type: application/zip");
                header("Content-Disposition: attachment; filename=pricegenius");
                if($data1 == null) return 404;
                return $data1;
            }
        } else {
            $date = date('Y-m-d h:i:s');
            $date1 = strtotime($date);
            $this->download_handler->update_download_date($user_id, $date1);
            $data = $this->guzzle_request("https://api.github.com/repos/davidandorf/pricegenius_v3/releases/latest");
            $data1 = $this->guzzle_request($data['zipball_url']);
            header("Content-Type: application/zip");
            header("Content-Disposition: attachment; filename=pricegenius");
            if($data1 == null) return 404;
            return $data1;
        }

    }

    /**
     * Download Data V1
     * @return int|\Psr\Http\Message\StreamInterface|string
     */
    function get_data1() {
        $user_id = $this->user_id;

        $user_date = $this->download_handler->get_download_date($user_id);

        $last_update_date = $this->download_handler->get_latest_update_date();

        if (!empty($user_date)) {
            $resp = $this->guzzle_request("https://api.github.com/repos/davidandorf/pricegenius/commits?since=" .
                $user_date);
            if ($last_update_date < $user_date) {
                return 404; // "error" => "No Updates Available"
            } else {

                $date = date('Y-m-d h:i:s');
                $date1 = strtotime($date);
                $this->download_handler->update_download_date($user_id, $date1);
                $data = $this->guzzle_request("https://api.github.com/repos/davidandorf/pricegenius/zipball");
                header("Content-Type: application/zip");
                header("Content-Disposition: attachment; filename=pricegenius");
                if($data == null) return 404;
                return $data;
            }
        } else {

            $date = date('Y-m-d h:i:s');
            $date1 = strtotime($date);
            $this->download_handler->update_download_date($user_id, $date1);
            $data = $this->guzzle_request("https://api.github.com/repos/davidandorf/pricegenius/zipball");
            header("Content-Type: application/zip");
            header("Content-Disposition: attachment; filename=pricegenius");
            if($data == null) return 404;
            return $data;
        }

    }

    /**
     * Download Data AutopricerTT
     * @return int|\Psr\Http\Message\StreamInterface|string
     */
    function get_autopricertt() {

        $user_id = $this->user_id;

        $user_date = $this->download_handler->get_download_date($user_id);

        $last_update_date = $this->download_handler->get_latest_update_date();
        if (!empty($user_date)) {
            $resp = $this->guzzle_request("https://api.github.com/repos/davidandorf/pricegenius_secure/commits?since=" .
                $user_date);
            if ($last_update_date < $user_date) {
                return 404; // "error" => "No Updates Available"
            } else {

                $date = date('Y-m-d h:i:s');
                $date1 = strtotime($date);
                $this->download_handler->update_download_date($user_id, $date1);
                $data = $this->guzzle_request("https://api.github.com/repos/davidandorf/pricegenius_secure/zipball");
                header("Content-Type: application/zip");
                header("Content-Disposition: attachment; filename=pricegenius");
                if($data == null) return 404;
                return $data;
            }
        } else {

            $date = date('Y-m-d h:i:s');
            $date1 = strtotime($date);
            $this->download_handler->update_download_date($user_id, $date1);
            $data = $this->guzzle_request("https://api.github.com/repos/davidandorf/pricegenius_secure/zipball");
            header("Content-Type: application/zip");
            header("Content-Disposition: attachment; filename=pricegenius");
            if($data == null) return 404;
            return $data;
        }

    }

    /**
     * Download Data AutoPricer
     * @return int|\Psr\Http\Message\StreamInterface|string
     */
    function get_autopricer() {

        $user_id = $this->user_id;

        $user_date = $this->download_handler->get_download_date($user_id);

        $last_update_date = $this->download_handler->get_latest_update_date();

        if (!empty($user_date)) {

            $resp = $this->guzzle_request("https://api.github.com/repos/davidandorf/pricegenius_secure/commits?since=" .
                $user_date);
            if ($last_update_date < $user_date) {
                return 404; // "error" => "No Updates Available"
            } else {

                $date = date('Y-m-d h:i:s');
                $date1 = strtotime($date);
                $this->download_handler->update_download_date($user_id, $date1);
                $data = $this->guzzle_request("https://api.github.com/repos/davidandorf/pricegenius_secure/zipball");
                header("Content-Type: application/zip");
                header("Content-Disposition: attachment; filename=pricegenius");
                if($data == null) return 404;
                return $data;
            }
        } else {

            $date = date('Y-m-d h:i:s');
            $date1 = strtotime($date);
            $this->download_handler->update_download_date($user_id, $date1);
            $data = $this->guzzle_request("https://api.github.com/repos/davidandorf/pricegenius_secure/zipball");
            header("Content-Type: application/zip");
            header("Content-Disposition: attachment; filename=pricegenius");
            if($data == null) return 404;
            return $data;
        }
    }

    /**
     * Download Data PricegeniusTT
     * @return int|\Psr\Http\Message\StreamInterface|string
     */
    function get_pricegeniustt() {

        $user_id = $this->user_id;

        $user_date = $this->download_handler->get_download_date($user_id);

        $last_update_date = $this->download_handler->get_latest_update_date();
        if (!empty($user_date)) {
            $resp = $this->guzzle_request("https://api.github.com/repos/davidandorf/pricegenius_secure/commits?since=" .
                $user_date);
            if ($last_update_date < $user_date) {
                return 404; // "error" => "No Updates Available"
            } else {

                $date = date('Y-m-d h:i:s');
                $date1 = strtotime($date);
                $this->download_handler->update_download_date($user_id, $date1);
                $data = $this->guzzle_request("https://api.github.com/repos/davidandorf/pricegenius_secure/zipball");
                header("Content-Type: application/zip");
                header("Content-Disposition: attachment; filename=pricegenius");
                if($data == null) return 404;
                return $data;
            }
        } else {

            $date = date('Y-m-d h:i:s');
            $date1 = strtotime($date);
            $this->download_handler->update_download_date($user_id, $date1);
            $data = $this->guzzle_request("https://api.github.com/repos/davidandorf/pricegenius_secure/zipball");
            header("Content-Type: application/zip");
            header("Content-Disposition: attachment; filename=pricegenius");
            if($data == null) return 404;
            return $data;
        }
    }

    function guzzle_request($url) {
        try {
            $res = $this->guzzle->get($url, [
                    'headers' => [
                        'User-Agent' => 'davidandrof',
                        'Authorization'     => 'token 3223e87b3952181273bff2e0fa806f8364d439a7',
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