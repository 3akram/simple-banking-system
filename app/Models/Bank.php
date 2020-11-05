<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;
    /*
     * Account to bank relation
     * Many    to One
     * return Bank Accounts
     */
    public function accounts() {
        return $this->hasMany('App\Models\Account');
    }
}
