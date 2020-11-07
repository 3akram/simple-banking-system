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

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

}
