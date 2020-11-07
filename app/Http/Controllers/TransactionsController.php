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
                $accountId         = $operation['accountId'];
                $transactionTypeId = $operation['transactionTypeId'];
                $account           = Account::find($accountId);

                $transactionOperation = $this->createTransactionOperation(
                    $account,
                    $transactionTypeId,
                    floatval($operation['amount']),
                    $transaction
                );
                $transactionOperation->save();
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
     * @param $account
     * @param $transactionTypeId
     * @param $amount
     * @param $transaction
     * @return TransactionOperation
     */
    function createTransactionOperation($account, $transactionTypeId, $amount, $transaction)
    {
        // create new transaction operation
        $transactionOperation                       = new TransactionOperation();
        $transactionOperation->account_id           = $account->id;
        $transactionOperation->transaction_type_id  = $transactionTypeId;
        $transactionOperation->amount               = $amount;
        $transactionOperation->transaction_id       = $transaction->id;

        return $transactionOperation;
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
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function transferMoney()
    {
        return view('transactions.transfer');
    }

    public function createTransfer(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $fromAccountId       = $request->input('from');
            $transferOperations  = $request->input('transferOperation');

            $userId  = auth()->user()->id;
            $user    = User::find($userId);
            $account = Account::find($fromAccountId);

            // create new transaction
            $transaction          = new Transaction();
            $transaction->user_id = $userId;
            $transaction->save();

            //.. check if from account is valid and belongs to the current user
            $isValid = $this->isValidAccount($fromAccountId);
            if(!$isValid)
            {
                throw new Exception('Account Does Not Exists');
            }

            // calculate total transfer amount
            $totalAmount = $this->calculateTransferTotalAmount($transferOperations);

            // make withdraw with total transfer amount
            // throw error if user account balance is not enough
            $account->withdraw(floatval($totalAmount));
            $account->save();

            foreach($transferOperations as $transferOperation)
            {
                $transactionOperation = $this->createTransactionOperation(
                    $account,
                    '3', //Needs Optimization
                    $totalAmount,
                    $transaction
                );
                $transactionOperation->save();
                $this->handleTransferOperation($transferOperation, $account);
            }
            DB::commit();
        }
        catch(Exception $exception)
        {
            DB::rollBack();
            throw $exception;
        }
        return redirect('/transactions');
    }

    public function handleTransferOperation($transfer, $currentAccount)
    {
        $currentAccountCurrency = $currentAccount->currency->currency_type;
        $targetAccountId        = $transfer['target'];
        $targetAccount          = Account::find($targetAccountId);
        $targetAccountCurrency  = $targetAccount->currency->currency_type;
        $amount                 = $transfer['amount'];

        //... use curl to make http request to perform currency conversion
        $targetAccount->deposit(floatval($amount));
        $targetAccount->save();
    }

    /**
     * @param $transferOperations
     * @return int|mixed
     */
    public function calculateTransferTotalAmount($transferOperations)
    {
        $totalAmount = 0;
        foreach($transferOperations as $transferOperation)
        {
            $totalAmount += floatval($transferOperation['amount']);
        }
        return $totalAmount;
    }


    /**
     * check if account belongs to the user
     * @param $accountId
     * @return bool
     */
    public function isValidAccount($accountId)
    {
        $userId = auth()->user()->id;
        $user   = User::find($userId);
        $userAccounts = $user->accounts;
        foreach($userAccounts as $userAccount)
        {
            if($userAccount->id == $accountId)
            {
                return true;
            }
        }
        return false;
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
