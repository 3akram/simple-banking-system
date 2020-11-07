<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\TransactionType;
use App\Models\User;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionOperation;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;

class TransactionsController extends Controller
{

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
     * @return View
     */
    public function index()
    {
        $transactions = Transaction::all();
        return view('transactions.transactions')->with('transactions', $transactions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $userId = auth()->user()->id;
        $user = User::find($userId);
        $transactionTypes = TransactionType::offset(0)->limit(2)->get();
        $data = array('accounts' => $user->accounts, 'transactionTypes' => $transactionTypes);
        return view('transactions.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Redirector
     * @throws Exception
     */
    public function store(Request $request)
    {
        $transactionOperations = $request->input('transactionOperation');
        // create new transaction

        DB::beginTransaction();
        try {
            $transaction = new Transaction();
            $transaction->user_id = auth()->user()->id;

            // save transaction
            $transaction->save();

            // start timer run update to the transaction after 24 hours flip permanent flag (important)
            foreach ($transactionOperations as $operation) {
                $accountId     = $operation['accountId'];
                $accountTypeId = $operation['transactionTypeId'];

                // create new transaction operation
                $transactionOperation                       = new TransactionOperation();
                $transactionOperation->account_id           = $accountId;
                $transactionOperation->transaction_type_id  = $accountTypeId;
                $transactionOperation->amount               = floatval($operation['amount']);
                $transactionOperation->transaction_id       = $transaction->id;

                // save transaction operation
                $transactionOperation->save();

                // update balance
                $account = Account::find($accountId);

                $this->handleTransactionOperation($transactionOperation, $account);

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
     * @param TransactionOperation $transactionOperation
     * @param Account $account
     */
    function handleTransactionOperation(TransactionOperation $transactionOperation, Account &$account)
    {
        switch ($transactionOperation->transactionType->transaction_type) {
            case TransactionType::WITHDRAW:
                $account->withdraw($transactionOperation->amount);
                break;
            case TransactionType::DEPOSIT:
                $account->deposit($transactionOperation->amount);
                break;
            default:
                throw new HttpException(400, 'Unrecognized transaction type');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
