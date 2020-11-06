@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between">
        <h3>Create New Transaction</h3>
        <a class="btn btn-outline-info" href="/transactions" > Back</a>
    </div>

    {!! Form::open(['action' => 'App\Http\Controllers\TransactionsController@store', 'method' => 'POST']) !!}

    <div class="form-group" >
        {!! Form::label('accountId', 'Account Id'); !!}
            <select name="accountId" class="browser-default custom-select">
                <option >Select Account</option>
                @foreach($accounts as $account)
                    <option value={{$account->id}}>{{$account->id}}</option>
                @endforeach
            </select>
    </div>
    <div class="form-group" >
        {!! Form::label('amount', 'Amount'); !!}
        {!! Form::text('amount', '', ['class' => 'form-control', 'placeholder' => 'Amount']); !!}
    </div>

    <div class="d-flex justify-content-between">
        {!! Form::submit('Create', ['class' => 'btn btn-success']) !!}
        {!! Form::submit('Add', ['class' => 'btn btn-outline-secondary']) !!}
    </div>
    {!! Form::close() !!}

@endsection
