<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use App\Common\CustomResponse;

class ApiController extends Controller
{
    use CustomResponse;

    //    public function __construct()
    //    {
    //        $this->middleware( 'auth:api');
    //    }

    /*
     * desc   : Get account balance
     * method : POST
     * access : Private
     */
    public function getAccountBalance(Request $request){
        $accountId = $request->input('id');
        $account   = Account::find($accountId);
        $userId    = auth('api')->user()->id;
        $user      = User::find($userId);
        return $this->successResponse($account->balance, 'account balance', $user, 200);
    }

    /*
     * desc   : Take money from specific account
     * method : POST
     * access : Private
     */

    public function withdrawMoney(Request $request) {
        $accountId = $request->input('id');
        $amount    = $request->input('amount');
        $userId    = auth('api')->user()->id;
        $user      = User::find($userId);
        if(!isset($accountId) || !isset($amount)) {
            return $this->errorResponse('Account Id and Amount must specified', $user, 400);
        }

        $account   = Account::find($accountId);

        if(!isset($account)){
            return $this->errorResponse('Account does not exists', $user, 400);
        }

        try{
            $account->withdraw(floatval($amount));
            $account->save();
            return $this->successResponse($account, 'Operation success', $user, 200);
        } catch(\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), $user, 400);
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
        $userId    = auth()->user()->id;
        $user      = User::find($userId);

        if(!isset($accountId) || !isset($amount)) {
            return $this->errorResponse('Account Id and Amount must specified', $user, 400);
        }

        $account   = Account::find($accountId);
        $account->deposit(floatval($amount));
        $account->save();
        return $this->successResponse($account, 'Operation success', $user, 200);
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
        // transfer from_id --> to_id[]
    }
}
