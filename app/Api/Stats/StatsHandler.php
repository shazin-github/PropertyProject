<?php

namespace App\Api\Stats;

use Illuminate\Support\Facades\DB;

class StatsHandler {

    /**
     * Get User Saved Listings
     * @param $user_id
     * @return int
     */
    function get_user_saved_listing($user_id) {
        $saved_listing = DB::table('listings_data')
            ->select('listing_id', 'local_event_id')
            ->where('user_id', '=', $user_id)
            ->get();
        if($saved_listing) {
            return $saved_listing;
        } else {
            return false;
        }
    }

    /**
     * Get User Active Listings
     * @param $user_id
     * @return bool|array
     */
    function get_user_active_listing($user_id) {
        $total_active = DB::table('listings_data')
            ->select('listing_id', 'local_event_id')
            ->where('user_id', '=', $user_id)
            ->where('active', '=', 1)
            ->get();
        if($total_active) {
            return $total_active;
        } else {
            return false;
        }
    }

    /**
     * Get Total Active Listings
     * @return bool|array
     */
    function get_total_active_listing() {
        $total_active = DB::table('listings_data')
            ->select('listing_id', 'local_event_id')
            ->where('active', '=', 1)
            ->get();
        if($total_active) {
            return $total_active;
        } else {
            return 0;
        }
    }

    /**
     * Get Plain Floor Listings
     * @param $user_id
     * @return bool|array
     */
    function get_plain_floor_listings($user_id) {
        $result = DB::table('listings_data')
            ->select('listings_data.listing_id', 'listings_data.local_event_id')
            ->join('listings_criteria', 'listings_data.listing_id', '=', 'listings_criteria.listing_id')
            ->where('listings_criteria.on_floor', '=', 1)
            ->where('listings_data.user_id', '=', $user_id)
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Get Auto Groups Floor Listing
     * @param $user_id
     * @return bool|array
     */
    function get_auto_floor_listings($user_id) {
        $result = DB::table('autogroup_listings')
            ->select('listings_data.listing_id', 'listings_data.local_event_id')
            ->join('auto_groups_criteria', 'autogroup_listings.group_id', '=', 'auto_groups_criteria.group_id')
            ->join('listings_data', 'autogroup_listings.listing_id', '=', 'listings_data.listing_id')
            ->where('auto_groups_criteria.on_floor', '=', 1)
            ->where('listings_data.user_id', '=', $user_id)
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Get Manual Group Floor Listing
     * @param $user_id
     * @return bool|array
     */
    function get_manual_floor_listings($user_id) {
        $result = DB::table('manual_group_listings')
            ->select('listings_data.listing_id', 'listings_data.local_event_id')
            ->join('manual_groups_criteria', 'manual_group_listings.group_id', '=', 'manual_groups_criteria.group_id')
            ->join('listings_data', 'manual_group_listings.listing_id', '=', 'listings_data.listing_id')
            ->where('manual_groups_criteria.on_floor', '=', 1)
            ->where('listings_data.user_id', '=', $user_id)
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Get Total Sold Listings
     * @param $user_id
     * @return bool|array
     */
    function get_total_sold_listing($user_id) {
        $total_active = DB::table('listings_data')
            ->select('listing_id', 'local_event_id')
            ->where('sold_status', '=', 0)
            ->where('user_id', '=', $user_id)
            ->get();
        if($total_active) {
            return $total_active;
        } else {
            return false;
        }
    }

    /**
     * Get Unsync Listings
     * @param $user_id
     * @return bool|array
     */
    function get_unsync_listings($user_id) {
        $unsync_listing = DB::table('listings_data')
            ->select('listing_id', 'local_event_id')
            ->where('price_sync_status', '=', 0)
            ->where('user_id', '=', $user_id)
            ->get();
        if($unsync_listing) {
            return $unsync_listing;
        } else {
            return false;
        }
    }

    /**
     * Get Plain Compare Listing
     * @param $user_id
     * @return bool|array
     */
    function get_plain_compare_listings($user_id) {
        $result = DB::table('listings_data')
            ->select('listings_data.listing_id', 'listings_data.local_event_id')
            ->join('listings_criteria', 'listings_data.listing_id', '=', 'listings_criteria.listing_id')
            ->where('listings_criteria.comparison', '=', 1)
            ->where('listings_data.user_id', '=', $user_id)
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Get Auto Group Compare Listing
     * @param $user_id
     * @return bool|array
     */
    function get_auto_compare_listings($user_id) {
        $result = DB::table('autogroup_listings')
            ->select('listings_data.listing_id', 'listings_data.local_event_id')
            ->join('auto_groups_criteria', 'autogroup_listings.group_id', '=', 'auto_groups_criteria.group_id')
            ->join('listings_data', 'autogroup_listings.listing_id', '=', 'listings_data.listing_id')
            ->where('auto_groups_criteria.comparison', '=', 1)
            ->where('listings_data.user_id', '=', $user_id)
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Get Manual Group Compare Listing
     * @param $user_id
     * @return bool|array
     */
    function get_manual_compare_listings($user_id) {
        $result = DB::table('manual_group_listings')
            ->select('listings_data.listing_id', 'listings_data.local_event_id')
            ->join('manual_groups_criteria', 'manual_group_listings.group_id', '=', 'manual_groups_criteria.group_id')
            ->join('listings_data', 'manual_group_listings.listing_id', '=', 'listings_data.listing_id')
            ->where('manual_groups_criteria.comparison', '=', 1)
            ->where('listings_data.user_id', '=', $user_id)
            ->get();
        if($result) {
            return $result;
        } else {
            return false;
        }
    }
}