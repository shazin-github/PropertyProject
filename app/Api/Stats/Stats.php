<?php

namespace App\Api\Stats;

use App\Api\Users\Users;
use App\Api\Helper\Helper;
use App\Api\Stats\StatsHandler;
use App\Api\Helper\PlanHelper;

class Stats
{

    protected $stats_handler;
    protected $user_id;
    protected $broker_key;
    protected $helper;
    protected $plan_helper;
    protected $user;
    protected $response;
    protected $pos_name;

    function __construct(StatsHandler $stats_handler, Users $user, Helper $helper, PlanHelper $plan_helper)
    {
        $this->stats_handler = $stats_handler;
        $this->helper = $helper;
        $this->plan_helper = $plan_helper;
        $this->user = $user;
        $this->broker_key = $this->helper->get_header_key();
        $this->user_id = (string)$this->user->get_user_id($this->broker_key);
    }

    /**
     * Get User Stats
     * param $user UserID
     * @return array|bool|int
     */
    function get_user_stat($user)
    {
        $user_id = $this->user_id;
        if($user_id) {
                $user_plan_limit = $this->plan_helper->get_user_plan_limit($user);
                $user_saved_listings = $this->stats_handler->get_user_saved_listing($user);
                $user_saved_filter_listing = $this->filter_listings($user_saved_listings);
                $user_active_listings = $this->stats_handler->get_user_active_listing($user);
                $user_active_filter_listing = $this->filter_listings($user_active_listings);
                $user_stats = array(
                    'plan_limit' => $user_plan_limit,
                    'save_listing' => $user_saved_filter_listing,
                    'active_listing' => $user_active_filter_listing
                );
                return $user_stats;
        } else {
            return 404;
        }
    }

    /**
     * Get Floor Stats
     * param $user UserID
     * @return array|bool|int
     */
    function get_floor_stat($user)
    {
        $user_id = $this->user_id;
        if($user_id) {
            $plain_floor_listings = $this->stats_handler->get_plain_floor_listings($user);
            $auto_floor_listings = $this->stats_handler->get_auto_floor_listings($user);
            $manual_floor_listings = $this->stats_handler->get_manual_floor_listings($user);
            $floor_listings = [$plain_floor_listings, $auto_floor_listings, $manual_floor_listings];
            $filter_floor_listings = $this->filter_multi_listings($floor_listings);
            if($filter_floor_listings['count'] == 0)  $filter_floor_listings = false;
            return $filter_floor_listings;
        } else {
            return 404;
        }
    }

    /**
     * Get Sold Listings
     * param $user UserID
     * @return array|bool|int
     */
    function get_total_sold_listing($user)
    {
        $user_id = $this->user_id;
        if($user_id) {
            $sold_listing = $this->stats_handler->get_total_sold_listing($user);
            $filter_sold_listing = $this->filter_listings($sold_listing);
            if($filter_sold_listing['count'] == 0)  $filter_sold_listing = false;
            return $filter_sold_listing;
        } else {
            return 404;
        }
    }

    /**
     * Get Active Listings
     * param $user UserID
     * @return array|bool|int
     */
    function get_total_active_listing($user)
    {
        $user_id = $this->user_id;
        if($user_id) {
            $active_listing = $this->stats_handler->get_total_active_listing($user);
            $filter_active_listing = $this->filter_listings($active_listing);
            if($filter_active_listing['count'] == 0)  $filter_active_listing = false;
            return $filter_active_listing;
        } else {
            return 404;
        }
    }

    /**
     * Get Unsync Listings
     * param $user UserID
     * @return array|bool|int
     */
    function get_unsync_listing($user)
    {
        $user_id = $this->user_id;
        if($user_id) {
            $unsync_listing = $this->stats_handler->get_unsync_listings($user);
            $filter_unsync_listing = $this->filter_listings($unsync_listing);
            if($filter_unsync_listing['count'] == 0)  $filter_unsync_listing = false;
            return $filter_unsync_listing;
        } else {
            return 404;
        }
    }

    /**
     * Get Compare Listings
     * param $user UserID
     * @return array|bool|int
     */
    function get_compare_listing($user)
    {
        $user_id = $this->user_id;
        if($user_id) {
            $plain_compare_listings = $this->stats_handler->get_plain_compare_listings($user);
            $auto_compare_listings = $this->stats_handler->get_auto_compare_listings($user);
            $manual_compare_listings = $this->stats_handler->get_manual_compare_listings($user);
            $compare_listings = [$plain_compare_listings, $auto_compare_listings, $manual_compare_listings];
            $filter_compare_listings = $this->filter_multi_listings($compare_listings);
            if($filter_compare_listings['count'] == 0)  $filter_compare_listings = false;
            return $filter_compare_listings;
        } else {
            return 404;
        }
    }

    function filter_listings($listings)
    {
        $filter_listing = array('count' => 0, 'listing_id' => array(), 'local_event_id' => array());
        if ($listings) {
        foreach ($listings as $thislisting) {
            $filter_listing['count']++;
            $filter_listing['listing_id'][] = $thislisting->listing_id;
            $filter_listing['local_event_id'][] = $thislisting->local_event_id;
        }
        }
        return $filter_listing;
    }

    function filter_multi_listings($listings_array) {
        $filter_multi_listing = array('count' => 0, 'listing_id' => array(), 'local_event_id' => array());
        foreach($listings_array as $thislisting) {
            if ($thislisting) {
            foreach ($thislisting as $sublist) {
                $filter_multi_listing['count']++;
                $filter_multi_listing['listing_id'][] = $sublist->listing_id;
                $filter_multi_listing['local_event_id'][] = $sublist->local_event_id;
            }
        }
        }
        return $filter_multi_listing;
    }
}