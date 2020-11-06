<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionOperation extends Model
{
    use HasFactory;

    public function transaction() {
        return $this->belongsTo('App\Models\Transaction');
    }
    public function transactionType(){
        return $this->belongsTo('App\Models\TransactionType');
    }
    public function account(){
        return $this->belongsTo('App\Models\Account');
    }
}
