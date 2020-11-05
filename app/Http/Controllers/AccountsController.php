<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Bank;
use App\Models\Currency;
use App\Models\AccountType;
use App\Models\User;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $userId = auth()->user()->id;
        $user   = User::find($userId);
        $banks  = Bank::all();
        $data   = array('accounts' => $user->accounts, 'banks' => $banks);
        return view('accounts.accounts')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $banks        = Bank::all();
        $accountTypes = AccountType::all();
        $currencies   = Currency::all();
        $data = array('banks'=>$banks, 'accountTypes'=>$accountTypes, 'currencies'=>$currencies);
        return view('accounts.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
            'bankId' => 'required',
            'accountTypeId'  => 'required',
            'currencyTypeId' => 'required'
        ));

        $account        = new Account();
        $userId         = auth()->user()->id;
        $bankId         = $request->input('bankId');
        $accountTypeId  = $request->input('accountTypeId');
        $currencyTypeId = $request->input('currencyTypeId');

        $account-> setUserId($userId);
        $account-> setAccountTypeId($accountTypeId);
        $account-> setBankId($bankId);
        $account-> setCurrencyTypeId($currencyTypeId);

        $account->save();

        return redirect('/accounts')->with('success', 'Bank Account Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $account = Account::find($id);
        $banks   = Bank::all();
        $accountTypes = AccountType::all();
        $currencies   = Currency::all();
        $data = array('account' => $account, 'banks' => $banks, 'accountTypes' => $accountTypes, 'currencies' => $currencies);
        return view('accounts.account')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $account = Account::find($id);
        $banks   = Bank::all();
        $accountTypes = AccountType::all();
        $currencies   = Currency::all();
        $data = array('account' => $account, 'banks' => $banks, 'accountTypes' => $accountTypes, 'currencies' => $currencies);
        return view('accounts.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, array(
            'bankId' => 'required',
            'accountTypeId'  => 'required',
            'currencyTypeId' => 'required'
        ));

        $account = Account::find($id);
        $bankId         = $request->input('bankId');
        $accountTypeId  = $request->input('accountTypeId');
        $currencyTypeId = $request->input('currencyTypeId');

        $account-> setAccountTypeId($accountTypeId);
        $account-> setBankId($bankId);
        $account-> setCurrencyTypeId($currencyTypeId);

        $account->save();

        return redirect('/accounts')->with('success', 'Bank Account Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return void
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Flip account status 1 active, 0 not-active
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function flipStatus($id)
    {
        $account = Account::find($id);
        $account->active = $account->active == 1 ? 0 : 1;
        $account->save();
        return redirect('/accounts');
    }

    /**
     * show filter view
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function filterByBank(Request $request)
    {
        $banks = Bank::all();
        return view('accounts.filter')->with('banks', $banks);
    }

    /**
     * return user's Account in one bank
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function applyFilter(Request $request)
    {
        $bankId   = $request->input('bankId');
        $userId   = auth()->user()->id;
        $banks    = Bank::all();
        if($bankId == -1) {
            $accounts = Account::where(['user_id'=> $userId])->get();
        } else {
            $accounts = Account::where(['user_id'=> $userId, 'bank_id' => $bankId])->get();
        }
        $data     = array('accounts'=>$accounts, 'banks' => $banks);

        return view('accounts.accounts')->with($data);
    }
}
