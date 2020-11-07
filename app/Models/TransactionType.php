<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    const WITHDRAW = 'withdraw';
    const DEPOSIT  = 'deposit';
    const TRANSFER = 'transfer';

    use HasFactory;

    public function transactionOperations() {
        return $this->hasMany('App\Models\TransactionOperation');
    }
}
