<?php

namespace App\Api\Accounts;

use Illuminate\Support\Facades\DB;

class AccountsHandler
{

    private $mongo_connection;
    private $accounts_collection;

    function __construct()
    {
        $this->mongo_connection = 'mongoDB';
        $this->accounts_collection = 'accounts';
    }

    /**
     * Add New Account
     * @param $account_data
     * @return bool
     */
    public function add_account($account_data) {

        $result = DB::connection($this->mongo_connection)
            ->collection($this->accounts_collection)
            ->insertGetId($account_data);
        if($result) {
            return $result;
        } else {
            return false;
        }
    }
}