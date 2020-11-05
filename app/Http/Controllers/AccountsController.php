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
        return view('accounts.accounts')->with('accounts', $user->accounts);
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

        $account = new Account();
        $account->user_id         = auth()->user()->id;
        $account->bank_id         = $request->input('bankId');
        $account->account_type_id = $request->input('accountTypeId');
        $account->currency_id     = $request->input('currencyTypeId');
        $account->save();
        return redirect('/accounts')->with('success', 'Bank Account Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
