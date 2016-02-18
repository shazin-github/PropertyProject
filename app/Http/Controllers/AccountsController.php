<?php

namespace App\Http\Controllers;

use App\Api\Events\Events;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\Accounts\Accounts;
Use App\Api\Response\Response;

class AccountsController extends Controller
{
    protected $accounts;
    protected $request;
    protected $response;

    public function __construct(Accounts $accounts, Request $request, Response $response)
    {
        $this->accounts = $accounts;
        $this->request = $request;
        $this->response = $response;
    }

    public function add_account() {
        if($this->request->has('acc_email')) {
            $account_data = $this->request->all();
            $accounts = $this->accounts->save_account($account_data);
            if($accounts === 404) {
                return $this->response->not_found('User not found');
            } else {
                return $this->response->success($accounts);
            }
        } else {
            return $this->response->forbidden('Request Paramaters are incorrect');
        }
    }
}