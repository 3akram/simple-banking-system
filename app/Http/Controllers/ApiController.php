<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ApiController extends Controller
{
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

        $account   = Account::find($accountId);
        // Check if the withdraw can be fulfilled
        if($account->balance - floatval($amount) >= 0) {
            $account->balance = $account->balance - floatval($amount);
            $account->save();
            return ['success' => true, 'message' => 'Operation success'];
        } else {
            return ['success' => true, 'message' => "Not enough balance"];
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

        $account   = Account::find($accountId);
        $account->balance = $account->balance + floatval($amount);

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
