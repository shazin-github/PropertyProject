<?php

namespace App\Api\Accounts;

use App\Api\Users\Users;
use App\Api\Helper\Helper;
use App\Api\Accounts\AccountsHandler;

class Accounts
{

    protected $accounts_handler;
    protected $user_id;
    protected $broker_key;
    protected $helper;
    protected $user;
    protected $response;
    protected $pos_name;

    function __construct(AccountsHandler $accounts_handler, Users $user, Helper $helper)
    {
        $this->accounts_handler = $accounts_handler;
        $this->helper = $helper;
        $this->user = $user;
        $this->broker_key = $this->helper->get_header_key();
        $this->user_id = (string)$this->user->get_user_id($this->broker_key);
    }

    /**
     * Add New Account
     * @param $account_data
     * @return bool
     */
    public function save_account($account_data){

        $acc_type = $account_data["report_type"];
        $acc_email = $account_data["acc_email"];
        $acc_passw = $account_data["password"];
        $acc_name = $account_data["name_acc"];
        $data=array(
            'acc_type' => $acc_type,
            'acc_email '=> $acc_email,
            'acc_password' => $acc_passw,
            'acc_name' => $acc_name
        );
        if(isset($account_data["user_auto"])) {

            $acc_userauto = $account_data["user_auto"];
            $str_auto = explode("(", $acc_userauto);
            $str2_auto = explode(")", $str_auto[1]);
            $user_id = $str2_auto[0];
            $data['broker_key'] = $this->user->get_broker_key($user_id);
            $data['main_acc'] = $user_id;
        }

        return $this->accounts_handler->add_account($data);
    }
}