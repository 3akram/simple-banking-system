<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Exception;
class Account extends Model
{
    use HasFactory;
    /*
     * desc: Account to Bank relation
     * One     to Many
     * return Bank
     */

    public function setUserId($userId) {
        $this->user_id = $userId;
    }

    public function setBankId($bankId){
        $this->bank_id = $bankId;
    }

    public function setAccountTypeId($accountTypeId) {
        $this->account_type_id = $accountTypeId;
    }

    public function setCurrencyTypeId ($currencyTypeId) {
        $this->currency_id = $currencyTypeId;
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo('App\Models\Bank');
    }
    /*
     * desc: Account to AccountType relation
     * One     to One
     * return AccountType
     */
    public function accountType() {
        return $this->belongsTo('App\Models\AccountType');
    }

    /*
     * desc: Account to AccountType relation
     * One     to One
     * return AccountType
     */

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    /*
     * desc: Account to AccountType relation
     * One     to One
     * return AccountType
     */
    public function currency() {
        return $this->belongsTo('App\Models\Currency');
    }

    /*
     * desc: Account to Transaction relation
     * One     to Many
     * return AccountType
     */
    public function transactions() {
        return $this->hasMany('App\Models\Transaction');
    }

    /**
     * @param $amount
     * @return $this
     * @throws Exception
     */
    public function withdraw($amount)
    {
        // check if the balance >= amount if so take amount from balance
        if ($this->balance >= $amount) {
            $this->balance -= $amount;
            return $this;
        }
        throw new Exception('Your balance does have enough money');
    }

    /**
     * @param $amount
     * @return $this
     */
    public function deposit($amount)
    {
        $this->balance += $amount;
        return $this;
    }



}
