<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware( 'auth:api');
    }

    /*
     * desc   : Get account balance
     * method : POST
     * access : Private
     */
    public function getAccountBalance(Request $request){
        $accountId = $request->input('id');
        $account   = Account::find($accountId);
        return $account->balance;
    }

    /*
     * desc   : Take money from specific account
     * method : POST
     * access : Private
     */

    public function withdrawMoney(Request $request) {
        $accountId = $request->input('id');
        $amount    = $request->input('amount');

        if(!isset($accountId) || !isset($amount)) {
            return ['success' => false, 'message' => 'Account Id and Amount must specified'];
        }

        $account   = Account::find($accountId);

        if(!isset($account)){
            return ['success' => false, 'message' => 'Account does not exists'];
        }

        try{
            $account->withdraw(floatval($amount));
            $account->save();
            return ['success' => true, 'message' => 'Operation success'];
        } catch(\Exception $exception) {
            return ['success' => true, 'message' => $exception->getMessage()];
        }

    }

    /*
     * desc   : Add money to specific account
     * method : POST
     * access : Private
     */

    public function depositMoney(Request $request) {
        $accountId = $request->input('id');
        $amount    = $request->input('amount');

        if(!isset($accountId) || !isset($amount)) {
            return ['success'=> false, 'message' => 'Account Id and Amount must specified'];
        }

        $account   = Account::find($accountId);
        $account->deposit(floatval($amount));
        $account->save();
        return ['success'=>true];
    }

    /*
     * desc   : Transfer Money from account to another one or more accounts
     * method : POST
     * access : Private
     */

    public function transferMoney(Request $request) {
        $to_id   = $request->input('to_id');
        $from_id = $request->input('from_id');
        $amount  = $request->input('amount');
        // transfer from_id --> to_id
    }
}
