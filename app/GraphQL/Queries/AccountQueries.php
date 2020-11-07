<?php

namespace App\GraphQL\Queries;

use App\Models\Account;

class AccountQueries
{
    public function all()
    {
        return Account::all();
    }

    public function find($root, $args)
    {
        return Account::find($args['id']);
    }

}
