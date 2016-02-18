<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Api\brokergeniusApp\Download\Download;
Use App\Api\Response\Response;

class DownloadController extends Controller
{
    protected $download;
    protected $request;
    protected $response;

    public function __construct(Download $download, Request $request, Response $response)
    {
        $this->download = $download;
        $this->request = $request;
        $this->response = $response;
    }

    public function get_data() {
        $download = $this->download->get_data();
        if($download === 404){
            return $this->response->not_found('No Updates Available');
        } else {
            return $this->response->success($download);
        }
    }

    public function get_dataV3() {
        $download = $this->download->get_dataV3();
        if($download === 404){
            return $this->response->not_found('No Updates Available');
        } else {
            return $this->response->success($download);
        }
    }

    public function get_data1() {
        $download = $this->download->get_data1();
        if($download === 404){
            return $this->response->not_found('No Updates Available');
        } else {
            return $this->response->success($download);
        }
    }

    public function get_autopricertt() {
        $download = $this->download->get_autopricertt();
        if($download === 404){
            return $this->response->not_found('No Updates Available');
        } else {
            return $this->response->success($download);
        }
    }

    public function get_autopricer() {
        $download = $this->download->get_autopricer();
        if($download === 404){
            return $this->response->not_found('No Updates Available');
        } else {
            return $this->response->success($download);
        }
    }

    public function get_pricegeniustt() {
        $download = $this->download->get_pricegeniustt();
        if($download === 404){
            return $this->response->not_found('No Updates Available');
        } else {
            return $this->response->success($download);
        }
    }
}