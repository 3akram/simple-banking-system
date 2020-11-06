<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TransactionOperation;

class Transaction extends Model
{
    use HasFactory;

    // transaction has many transaction operations
    public function transactionOperations(){
        return $this->hasMany('App\Models\TransactionOperation');
    }

    // Create Transaction
    public function create(TransactionOperations $transactionOperations) {
        //... TODO:// is to fire transaction operations and save each one of them
        //... TODO:// Start a timer to flip permanent flag to 1 after 24 hrs
    }

}
