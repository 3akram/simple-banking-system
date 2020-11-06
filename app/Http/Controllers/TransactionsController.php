<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\TransactionType;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionOperation;
use Illuminate\Support\Facades\DB;

class TransactionsController extends Controller
{
    const WITHDRAW = 'withdraw';
    const DEPOSIT  = 'deposit';
    const TRANSFER = 'transfer';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $transactions = Transaction::all();
        return view('transactions.transactions')->with('transactions', $transactions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $userId           = auth()->user()->id;
        $user             = User::find($userId);
        $transactionTypes = TransactionType::all();
        $data             = array('accounts'=>$user->accounts, 'transactionTypes'=>$transactionTypes);
        return view('transactions.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Routing\Redirector
     * @throws Exception
     */
    public function store(Request $request)
    {
        $transactionOperations = $request->input('transactionOperation');
        // create new transaction

        DB::beginTransaction();
        try{
            $transaction = new Transaction();
            $transaction->user_id = auth()->user()->id;

            // save transaction
            $transaction->save();
            // start timer run update to the transaction after 24 hours flip permanent flag (important)

            foreach($transactionOperations as $operation) {
                $accountId                                 = $operation['accountId'];
                $accountTypeId                             = $operation['transactionTypeId'];

                // create new transaction operation
                $transactionOperation                      = new TransactionOperation();
                $transactionOperation->account_id          = $accountId;
                $transactionOperation->transaction_type_id = $accountTypeId;
                $transactionOperation->amount              = floatval($operation['amount']);
                $transactionOperation->transaction_id      = $transaction->id;

                // save transaction operation
                $transactionOperation->save();

                // update balance
                $account = Account::find($accountId);

                // withdraw case
                if($transactionOperation->transactionType->transaction_type == self::WITHDRAW){
                    // check if the balance >= amount if so take amount from balance
                    if($account->balance >= $transactionOperation->amount){
                        $account->balance = $account->balance - $transactionOperation->amount;
                    } else {
                        throw new Exception('Operation Field!');
                    }

                } else if ($transactionOperation->transactionType->transaction_type == self::DEPOSIT) {
                    // Add amount to the balance
                    $account->balance = $account->balance + $transactionOperation->amount;
                }
                $account->save();
            }
            // if the code run with no errors
            DB::commit();
        } catch (Exception $exception) {
            DB::rollback();
            throw $exception;
        }
        return redirect('/transactions');
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
