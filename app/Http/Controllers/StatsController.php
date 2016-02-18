<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Api\Stats\Stats;
Use App\Api\Response\Response;
use App\Api\Helper\Helper;
use Cache;

class StatsController extends Controller
{
    protected $stats;
    protected $request;
    protected $response;
    protected $helper;

    public function __construct(Stats $stats, Request $request, Response $response, Helper $helper)
    {
        $this->stats = $stats;
        $this->request = $request;
        $this->response = $response;
        $this->helper = $helper;
    }

    public function user_stats() {

        $user = $this->request->get('user_id');
        $cache_key = 'user_stats'.$user;
        if($stats = $this->helper->has_cache($cache_key)) {
            return $this->response->success($stats);
        } else {
            $stats = $this->stats->get_user_stat($user);
            if ($stats === 404) {
                return $this->response->not_found('User not found');
            } else {
                $this->helper->save_cache($cache_key, $stats, 10);
                return $this->response->success($stats);
            }
        }
    }

    public function floor_stats() {
        $user = $this->request->get('user_id');
        $floor_stats = $this->stats->get_floor_stat($user);
        if($floor_stats === 404){
            return $this->response->not_found('User not found');
        } elseif(!$floor_stats){
            return $this->response->not_found('No Stats Present');
        } else {
            return $this->response->success($floor_stats);
        }
    }

    public function sold_stats() {
        $user = $this->request->get('user_id');
        $sold_stats = $this->stats->get_total_sold_listing($user);
        if($sold_stats === 404){
            return $this->response->not_found('User not found');
        } elseif(!$sold_stats){
            return $this->response->not_found('No Stats Present');
        } else {
            return $this->response->success($sold_stats);
        }
    }

    public function active_stats() {
        $user = $this->request->get('user_id');
        $active_stats = $this->stats->get_total_active_listing($user);
        if($active_stats === 404){
            return $this->response->not_found('User not found');
        } elseif(!$active_stats){
            return $this->response->not_found('No Stats Present');
        } else {
            return $this->response->success($active_stats);
        }
    }

    public function unsync_stats() {
        $user = $this->request->get('user_id');
        $unsync_stats = $this->stats->get_unsync_listing($user);
        if($unsync_stats === 404){
            return $this->response->not_found('User not found');
        } elseif(!$unsync_stats){
            return $this->response->not_found('No Stats Present');
        } else {
            return $this->response->success($unsync_stats);
        }
    }

    public function compare_stats() {
        $user = $this->request->get('user_id');
        $compare_stats = $this->stats->get_compare_listing($user);
        if($compare_stats === 404){
            return $this->response->not_found('User not found');
        } elseif(!$compare_stats){
            return $this->response->not_found('No Stats Present');
        } else {
            return $this->response->success($compare_stats);
        }
    }
}