<?php

namespace App\Api\migration\mysql;

use Illuminate\Support\Facades\DB;

class mysql
{

    function listing_simple() {
        $result = DB::connection('mysql_old')
            ->table('pricenotifier_criteria as pc')
            ->join('listing_groups as lg', 'pc.ticket_id', '=', 'lg.listing_id')
            ->select('pc.*')
            ->take(10)
            ->get();
        $ticketid_array = [];
        $count = 0;
        if($result) {
            foreach($result as $autogroup) {
                $ticketid_array[] = $autogroup->ticket_id;
            }
        }
        $result = DB::connection('mysql_old')
            ->table('pricenotifier_criteria as pc')
            ->join('manual_groups as mg', 'pc.ticket_id', '=', DB::raw('CONCAT(mg.user_id,",",mg.group_id)'))
            ->join('manual_groups_listings as mlg', 'mg.group_id', '=', 'mlg.group_id')
            ->select('pc.*', 'mlg.listing_id')
            ->take(10)
            ->get();
        if ($result) {
            if($result) {
                foreach($result as $manualgroup) {
                    $ticketid_array[] = $manualgroup->ticket_id;
                }
            }
        }
        if($ticketid_array) {
            $result = DB::connection('mysql_old')
                ->table('pricenotifier_criteria as pc')
                ->whereNotIn('pc.ticket_id', $ticketid_array)
                ->select('pc.*')
                ->take(10)
                ->get();
            if($result) {
                foreach($result as $simplegroup) {
                    $listing_id = explode(",", $simplegroup->ticket_id);
                    $insertid = DB::table('listings_data')
                        ->insert([
                            'listing_id' => $listing_id[1],
                            'sold_status' => 0,
                            'price_sync_status' => $simplegroup->sync,
                            'component_id' => 1,
                            'user_id' => $simplegroup->user_id,
                            'local_event_id' => $simplegroup->event_id,
                            'exchange_event_id' => $simplegroup->external_event_id,
                            'exchange_id' => 1,
                            'active' => $simplegroup->status
                        ]);
                    $criteria_object = [];
                    if($simplegroup->criteria) {
                        $increment_type = (isset($simplegroup->increment_type) && !empty($simplegroup->increment_type)) ? $simplegroup->increment_type : 0;
                        $increment_val = (isset($simplegroup->increment_val) && !empty($simplegroup->increment_val)) ? $simplegroup->increment_val : 0;
                        $criteria_object = $this->get_criteria_object($simplegroup->criteria, $increment_type, $increment_val);
                    }
                    $insert_criteriaid = DB::table('listings_criteria')
                        ->insert([
                            'listing_id' => $listing_id[1],
                            'push_price' => $simplegroup->actual_price,
                            'cp' => $simplegroup->changed_price,
                            'on_floor' => $simplegroup->price_floor,
                            'on_ceil' => $simplegroup->ceiling,
                            'comparison' => $simplegroup->comparision,
                            'component_id' => 1,
                            'exchange_event_id' => $simplegroup->external_event_id,
                            'criteria_object' => json_encode($criteria_object),
                            'exchange_id' => 1
                        ]);
                    if($insertid) $count++;
                }
            }
        }
        return $count.' Simple Listings Inserted Successfully';
    }

    function listings_auto() {
        $auto_groups = $this->auto_groups();
        $auto_groups_criteria = $this->auto_groups_criteria();
        $auto_groups_listings = $this->auto_groups_listings();
        $message = $auto_groups. ' AutoGroup Inserted Successfully'."\n";
        $message .= $auto_groups_criteria. ' AutoGroup Criteria Inserted Successfully'."\n";
        $message .= $auto_groups_listings. ' AutoGroup Listings Inserted Successfully';
        return $message;
    }

    function listings_manual() {
        $manual_groups = $this->manual_groups();
        $manual_groups_criteria = $this->manual_groups_criteria();
        $manual_groups_listings = $this->manual_groups_listings();
        $message = $manual_groups. ' ManualGroup Inserted Successfully'."\n";
        $message .= $manual_groups_criteria. ' ManualGroup Criteria Inserted Successfully'."\n";
        $message .= $manual_groups_listings. ' ManualGroup Listings Inserted Successfully';
        return $message;
    }

    function auto_groups() {
        $result = DB::connection('mysql_old')
            ->table('groups as ag')
            ->select('ag.*')
            ->take(50)
            ->get();
        if ($result) {
            $count = 0;
            foreach($result as $group) {
                $insertid = DB::table('auto_groups')
                    ->insert([
                        'user_id' => $group->user_id,
                        'group_id' => $group->group_id,
                        'exchange' => 1,
                        'exchange_event_id' => $group->sh_event_id,
                        'local_event_id' => $group->tm_event_id,
                        'group_inc_type' => $group->increment_type,
                        'tix_start' => $group->tix_start,
                        'cp_start' => $group->cp_start,
                        'group_name' => $group->group_name,
                        'auto_bc' => $group->auto_bc,
                        'auto_bc_rank' => $group->auto_bc_rank
                    ]);
                if($insertid) $count++;
            }

            return $count;
        } else {
            return false;
        }
    }

    function auto_groups_criteria() {
        $result = DB::connection('mysql_old')
            ->table('groups as ag')
            ->join('listing_groups as lg', 'ag.group_id', '=', 'lg.group_id')
            ->join('pricenotifier_criteria as pc', 'lg.listing_id', '=', 'pc.ticket_id')
            ->select('ag.group_id', 'ag.criteria', 'pc.actual_price', 'pc.changed_price', 'pc.price_floor',
                'pc.ceiling', 'pc.comparision', 'ag.sh_event_id', 'ag.increment_type', 'ag.increment_val')
            ->groupBy('lg.group_id')
            ->take(50)
            ->get();
        if ($result) {
            $count = 0;
            foreach($result as $group_criteria) {
                $criteria_object = [];
                if($group_criteria->criteria) {
                    $increment_type = (isset($group_criteria->increment_type) && !empty($group_criteria->increment_type)) ? $group_criteria->increment_type : 0;
                    $increment_val = (isset($group_criteria->increment_val) && !empty($group_criteria->increment_val)) ? $group_criteria->increment_val : 0;
                    $criteria_object = $this->get_criteria_object($group_criteria->criteria, $increment_type, $increment_val);
                }
                $insertid = DB::table('auto_groups_criteria')
                    ->insert([
                        'group_id' => $group_criteria->group_id,
                        'push_price' => $group_criteria->actual_price,
                        'cp' => $group_criteria->changed_price,
                        'on_floor' => $group_criteria->price_floor,
                        'on_ceil' => $group_criteria->ceiling,
                        'comparison' => $group_criteria->comparision,
                        'component_id' => 2,
                        'exchange_event_id' => $group_criteria->sh_event_id,
                        'criteria_object' => json_encode($criteria_object),
                        'exchange_id' => 1
                    ]);
                if($insertid) $count++;
            }

            return $count;
        } else {
            return false;
        }
    }

    function auto_groups_listings() {
        $result = DB::connection('mysql_old')
            ->table('listing_groups as lg')
            ->select('lg.*')
            ->take(50)
            ->get();
        if ($result) {
            $count = 0;
            foreach($result as $listgroup) {
                $listing_id = explode(',', $listgroup->listing_id);
                $insertid = DB::table('autogroup_listings')
                    ->insert([
                        'group_id' => $listgroup->group_id,
                        'listing_id' => $listing_id[1],
                        'priority' => $listgroup->priority
                    ]);
                if($insertid) $count++;
            }

            return $count;
        } else {
            return false;
        }
    }

    function manual_groups() {
        $result = DB::connection('mysql_old')
            ->table('manual_groups as mg')
            ->select('mg.*')
            ->take(50)
            ->get();
        if ($result) {
            $count = 0;
            foreach($result as $group) {
                $insertid = DB::table('manual_groups')
                    ->insert([
                        'user_id' => $group->user_id,
                        'group_id' => $group->group_id,
                        'group_name' => $group->group_name,
                        'group_mode' => $group->group_mode,
                        'exchange' => 1,
                        'exchange_event_id' => $group->sh_event_id,
                        'local_event_id' => $group->event_id,
                        'tix_start' => $group->tix_start,
                        'cp_start' => $group->cp_start,
                        'season_saved' => $group->season_saved,
                        'base_price' => $group->base_price,
                        'auto_bc' => $group->auto_bc,
                        'auto_bc_rank' => $group->auto_bc_rank
                    ]);
                if($insertid) $count++;
            }

            return $count;
        } else {
            return false;
        }
    }

    function manual_groups_criteria() {
        $result = DB::connection('mysql_old')
            ->table('manual_groups as mg')
            ->join('manual_groups_listings as mlg', 'mg.group_id', '=', 'mlg.group_id')
            ->join('pricenotifier_criteria as pc', DB::raw('CONCAT(mg.user_id,",",mg.group_id)'), '=', 'pc.ticket_id')
            ->select('mg.group_id', 'mg.criteria', 'pc.actual_price', 'pc.changed_price', 'pc.price_floor',
                'pc.ceiling', 'pc.comparision', 'mg.sh_event_id')
            ->take(50)
            ->groupBy('mlg.group_id')
            ->get();
        if ($result) {
            $count = 0;
            foreach($result as $group_criteria) {
                $criteria_object = [];
                if($group_criteria->criteria) {
                    $increment_type = (isset($group_criteria->increment_type) && !empty($group_criteria->increment_type)) ? $group_criteria->increment_type : 0;
                    $increment_val = (isset($group_criteria->increment_val) && !empty($group_criteria->increment_val)) ? $group_criteria->increment_val : 0;
                    $criteria_object = $this->get_criteria_object($group_criteria->criteria, $increment_type, $increment_val);
                }
                $insertid = DB::table('manual_groups_criteria')
                    ->insert([
                        'group_id' => $group_criteria->group_id,
                        'push_price' => $group_criteria->actual_price,
                        'cp' => $group_criteria->changed_price,
                        'on_floor' => $group_criteria->price_floor,
                        'on_ceil' => $group_criteria->ceiling,
                        'comparison' => $group_criteria->comparision,
                        'component_id' => 3,
                        'exchange_event_id' => $group_criteria->sh_event_id,
                        'criteria_object' => json_encode($criteria_object),
                        'exchange_id' => 1
                    ]);
                if($insertid) $count++;
            }

            return $count;
        } else {
            return false;
        }
    }

    function manual_groups_listings() {
        $result = DB::connection('mysql_old')
            ->table('manual_groups_listings as mlg')
            ->select('mlg.*')
            ->take(50)
            ->get();
        if ($result) {
            $count = 0;
            foreach($result as $listgroup) {
                $listing_id = explode(',', $listgroup->listing_id);
                $insertid = DB::table('manual_group_listings')
                    ->insert([
                        'group_id' => $listgroup->group_id,
                        'listing_id' => $listing_id[1],
                        'inc_val' => $listgroup->inc_val
                    ]);
                if($insertid) $count++;
            }

            return $count;
        } else {
            return false;
        }
    }

    function event_colors(){
        $result = DB::connection('mysql_old')
            ->table('event_colors')
            ->select('*')
            ->take(10)
            ->get();
        if ($result) {
            $count = 0;
            foreach($result as $colors) {
                $insertid = DB::table('event_colors')
                    ->insert([
                        'user_id' => $colors->user_id,
                        'event_id' => $colors->event_id,
                        'color_code' => $colors->color_code,
                        'date' => $colors->date,
                        'num_of_days' => $colors->num_of_days,
                        'end_date' => $colors->end_date
                    ]);
                if($insertid) $count++;
            }

            return $count. ' Event Colors Inserted Successfully';
        } else {
            return false;
        }
    }

    function listings_color(){
        $result = DB::connection('mysql_old')
            ->table('listings_color')
            ->select('*')
            ->take(10)
            ->get();
        if ($result) {
            $count = 0;
            foreach($result as $colors) {
                $insertid = DB::table('listings_color')
                    ->insert([
                        'user_id' => $colors->user_id,
                        'event_id' => $colors->event_id,
                        'color_code' => $colors->color_code,
                        'ticket_id' => $colors->ticket_id
                    ]);
                if($insertid) $count++;
            }

            return $count. ' Listing Colors Inserted Successfully';
        } else {
            return false;
        }
    }

    function criteria_profile() {
        $result = DB::connection('mysql_old')
            ->table('criteria_profile')
            ->take(10)
            ->get();
        if ($result) {
            $count = 0;
            foreach($result as $profiles) {
                $criteria_object = $this->get_criteria_object($profiles->criteria, $profiles->increment_type, 0);
                $insertid = DB::table('criteria_profile')
                    ->insert([
                        'profile_id' => $profiles->profile_id,
                        'user_id' => $profiles->user_id,
                        'venue_id' => $profiles->venue_id,
                        'profile_type_id' => $profiles->profile_type_id,
                        'criteria_object' => json_encode($criteria_object),
                        'profile_name' => $profiles->profile_name
                    ]);
                if($insertid) $count++;
            }
            $profile_type = $this->profile_type();
            return $count. ' Profile Criteria Inserted Successfully';
        } else {
            return false;
        }
    }

    function profile_type() {
        $result = DB::connection('mysql_old')
            ->table('profile_type')
            ->take(10)
            ->get();
        if ($result) {
            $count = 0;
            foreach($result as $profile_type) {
                $insertid = DB::table('profile_type')
                    ->insert([
                        'profile_type_id' => $profile_type->profile_type_id,
                        'profile_type_name' => $profile_type->profile_type_name,
                    ]);
                if($insertid) $count++;
            }

            return $count. ' Profile Type Inserted Successfully';
        } else {
            return false;
        }
    }

    function seller_ids() {
        $result = DB::connection('mysql_old')
            ->table('seller_ids')
            ->get();
        if ($result) {
            $count = 0;
            foreach($result as $seller_id) {
                $insertid = DB::table('seller_ids')
                    ->insert([
                        'account_id' => $seller_id->account_id,
                        'seller_id' => $seller_id->seller_id,
                        'user_id' => $seller_id->user_id,
                    ]);
                if($insertid) $count++;
            }

            return $count. ' Seller_ids Inserted Successfully';
        } else {
            return false;
        }
    }

    function keys() {
        $result = DB::connection('mysql_old')
            ->table('keys')
            ->get();
        if ($result) {
            $count = 0;
            foreach($result as $key) {
                $insertid = DB::table('keys')
                    ->insert([
                        'key' => $key->key,
                        'level' => $key->level,
                        'ignore_limits' => $key->ignore_limits,
                        'is_private_key' => $key->is_private_key,
                        'ip_addresses' => $key->ip_addresses,
                        'date_created' => $key->date_created,
                        'user_id' => $key->user_id,
                        'status' => $key->status,
                    ]);
                if($insertid) $count++;
            }

            return $count. ' User Keys Inserted Successfully';
        } else {
            return false;
        }
    }

    function userdetails() {
        $result = DB::connection('mysql_old')
            ->table('userdetails')
            ->get();
        if ($result) {
            $count = 0;
            foreach($result as $user) {
                $insertid = DB::table('userdetails')
                    ->insert([
                        'user_id' => $user->user_id,
                        'user_name' => $user->user_name,
                        'user_pass' => $user->user_pass,
                        'user_type' => $user->user_type,
                        'user_pricing_plan' => $user->user_pricing_plan,
                        'pricing_id' => $user->pricing_id,
                        'user_start_date' => $user->user_end_date,
                        'user_end_date' => $user->user_end_date,
                        'user_email' => $user->user_email,
                        'phone_num' => $user->phone_num,
                        'customer_id' => $user->customer_id,
                        'sale_force_link' => $user->sale_force_link,
                        'download_date' => $user->download_date,
                        'app_update_date' => $user->app_update_date,
                        'internal_link' => $user->internal_link,
                        'v3_internal_link' => $user->v3_internal_link,
                        'external_link' => $user->external_link,
                        'user_status' => $user->user_status,
                    ]);
                if($insertid) $count++;
            }

            return $count. ' Users Detail Inserted Successfully';
        } else {
            return false;
        }
    }

    function season_groups() {
        $result = DB::connection('mysql_old')
            ->table('season_groups')
            ->take(10)
            ->get();
        if ($result) {
            $count = 0;
            foreach($result as $season_group) {
                $insertid = DB::table('season_groups')
                    ->insert([
                        'user_id' => $season_group->user_id,
                        'exchange_event_id' => $season_group->event_id,
                        'group_name' => $season_group->group_name,
                        'group_type' => $season_group->group_type,
                        'group_id' => $season_group->group_id,
                    ]);
                if($insertid) $count++;
            }

            return $count. ' Season Groups Inserted Successfully';
        } else {
            return false;
        }
    }

    function user_plans() {
        $result = DB::connection('mysql_old')
            ->table('user_plans')
            ->get();
        if ($result) {
            $count = 0;
            foreach($result as $plans) {
                $insertid = DB::table('user_plans')
                    ->insert([
                        'user_id' => $plans->user_id,
                        'plan_id' => $plans->plan_id,
                        'plan_type' => $plans->plan_type,
                        'product_desc' => $plans->product_desc,
                        'plan_status' => $plans->plan_status,
                        'start_date' => $plans->start_date,
                        'end_date' => $plans->end_date
                    ]);
                if($insertid) $count++;
            }

            return $count. ' User Plans Inserted Successfully';
        } else {
            return false;
        }
    }

    function get_criteria_object($criteria_text, $increment_type, $increment_val) {
        $criteria = explode('|', $criteria_text);
        $criteria_object['zone'] = (isset($criteria[0]) && !empty($criteria[0])) ? $criteria[0] : "";
        $criteria_object['sections'] = (isset($criteria[1]) && !empty($criteria[1])) ? $criteria[1] : "";
        $criteria_object['rows'] = (isset($criteria[2]) && !empty($criteria[2])) ? $criteria[2] : "";
        $criteria_object['price_change'] = (isset($criteria[3]) && !empty($criteria[3])) ? $criteria[3] : "";
        $criteria_object['price_min'] = (isset($criteria[4]) && !empty($criteria[4])) ? $criteria[4] : "";
        $criteria_object['be'] = (isset($criteria[5]) && !empty($criteria[5])) ? $criteria[5] : "";
        $criteria_object['packs'] = (isset($criteria[6]) && !empty($criteria[6])) ? $criteria[6] : "";
        $criteria_object['ticket_types'] = (isset($criteria[7]) && !empty($criteria[7])) ? $criteria[7] : "";
        $criteria_object['celing'] = (isset($criteria[8]) && $criteria[8] != "NaN") ? $criteria[8] : "";
        $criteria_object['increment_type'] = $increment_type;
        $criteria_object['increment_val'] = $increment_val;
        return $criteria_object;
    }

    function truncateTable($table) {
        if($table == 'SimpleListing') {
            DB::table('listings_data')->truncate();
            DB::table('listings_criteria')->truncate();
        } elseif($table == 'AutoGroupListing') {
            DB::table('auto_groups')->truncate();
            DB::table('auto_groups_criteria')->truncate();
            DB::table('autogroup_listings')->truncate();
        } elseif($table == 'ManualGroupListing') {
            DB::table('manual_groups')->truncate();
            DB::table('manual_groups_criteria')->truncate();
            DB::table('manual_group_listings')->truncate();
        } elseif($table == 'EventColors') {
            DB::table('event_colors')->truncate();
        } elseif($table == 'ListingColors') {
            DB::table('listings_color')->truncate();
        } elseif($table == 'CriteriaProfile') {
            DB::table('criteria_profile')->truncate();
            DB::table('profile_type')->truncate();
        } elseif($table == 'UserPlan') {
            DB::table('user_plans')->truncate();
        } elseif($table == 'SellerID') {
            DB::table('seller_ids')->truncate();
        } elseif($table == 'Keys') {
            DB::table('keys')->truncate();
        } elseif($table == 'UserDetail') {
            DB::table('userdetails')->truncate();
        } elseif($table == 'SeasonGroups') {
            DB::table('season_groups')->truncate();
        }
    }

    function clearAll() {
        DB::table('listings_data')->truncate();
        DB::table('listings_criteria')->truncate();
        DB::table('auto_groups')->truncate();
        DB::table('auto_groups_criteria')->truncate();
        DB::table('autogroup_listings')->truncate();
        DB::table('manual_groups')->truncate();
        DB::table('manual_groups_criteria')->truncate();
        DB::table('manual_group_listings')->truncate();
        DB::table('event_colors')->truncate();
        DB::table('listings_color')->truncate();
        DB::table('criteria_profile')->truncate();
        DB::table('profile_type')->truncate();
        DB::table('user_plans')->truncate();
        DB::table('seller_ids')->truncate();
        DB::table('keys')->truncate();
        DB::table('userdetails')->truncate();
        DB::table('season_groups')->truncate();
    }
}