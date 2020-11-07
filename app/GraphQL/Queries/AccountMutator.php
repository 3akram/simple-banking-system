<?php


namespace App\GraphQL\Queries;

use App\Models\Account;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AccountMutator
{
    /** \
     * @param $root
     * @param $args
     * @return
     */
    public function withdrawMoney($root, $args)
    {
          $amount = $args['amount'];
          $accountId = $args['id'];
          if(!isset($amount) || !isset($accountId)){
              throw new HttpException('Account ID and Amount must be specified', 400);
          }
          $account = Account::find($accountId);
          if(!isset($account))
          {
              throw new HttpException('Account ID is not valid', 400);
          }
          $account->withdraw(floatval($amount));
          $account->save();
          return $account;
    }

    /**
     *
     * @param $root
     * @param $args
     * @return Account
     */

    public function depositMoney($root, $args)
    {
        $amount = $args['amount'];
        $accountId = $args['id'];
        if(!isset($amount) || !isset($accountId))
        {
            throw new HttpException('Account ID and Amount must be specified', 400);
        }

        $account = Account::find($accountId);
        if(!isset($account))
        {
            throw new HttpException('Account ID is not valid', 400);
        }

        $account->deposit(floatval($amount));
        $account->save();
        return $account;

    }

    /**
     * @param $root
     * @param $args
     * @return
     */
    public function getAccountBalance($root, $args)
    {
        $accountId = $args['id'];
        if(!isset($accountId))
        {
            throw new HttpException('Account ID must be specified', 400);
        }
        $account = Account::find($accountId);
        if(!isset($account))
        {
            throw new HttpException('Account ID is not valid', 400);
        }
        return $account->balance;
    }
}
