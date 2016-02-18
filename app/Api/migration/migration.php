<?php

namespace App\Api\migration;

use App\Api\migration\mongo\mongo;
use App\Api\migration\mysql\mysql;

class migration
{
    protected $mongo;
    protected $mysql;
    public function __construct(mysql $mysql, Mongo $mongo)
    {
        $this->mongo = $mongo;
        $this->mysql = $mysql;
    }

    function mongo_handle($table, $truncate = false) {

        if($table == 'Accounts') {
            return $this->mongo->putAccounts();
        } elseif($table == 'EventNotes') {
            return $this->mongo->putEventNotes();
        } elseif($table == 'UserExperience') {
            return $this->mongo->putUserExperience();
        } elseif($table == 'ExchangeMapping') {
            return $this->mongo->putExchangeMapping();
        } elseif($table == 'SellerFee') {
            return $this->mongo->putStubhubSellerfee();
        } elseif($table == 'UserConfig') {
            return $this->mongo->putUserConfig();
        }
    }

    function mysql_handle($table, $truncate = false) {

        if($truncate)
            $this->mysql->truncateTable($table);

        if($table == 'SimpleListing') {
            return $this->mysql->listing_simple();
        } elseif($table == 'AutoGroupListing') {
            return $this->mysql->listings_auto();
        } elseif($table == 'ManualGroupListing') {
            return $this->mysql->listings_manual();
        } elseif($table == 'EventColors') {
            return $this->mysql->event_colors();
        } elseif($table == 'ListingColors') {
            return $this->mysql->listings_color();
        } elseif($table == 'CriteriaProfile') {
            return $this->mysql->criteria_profile();
        } elseif($table == 'UserPlan') {
            return $this->mysql->user_plans();
        } elseif($table == 'SellerID') {
            return $this->mysql->seller_ids();
        } elseif($table == 'Keys') {
            return $this->mysql->keys();
        } elseif($table == 'UserDetail') {
            return $this->mysql->userdetails();
        } elseif($table == 'SeasonGroups') {
            return $this->mysql->season_groups();
        }
    }
}