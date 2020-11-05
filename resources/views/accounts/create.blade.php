@extends('layouts.app')

@section('content')
    <h1>Create New Account</h1>

    {!! Form::open(['action' => 'App\Http\Controllers\AccountsController@store', 'method' => 'POST']) !!}
    <label>
        <select name="bankId" class="browser-default custom-select">
            <option selected>Select Bank</option>
            @foreach($banks as $bank)
                <option value={{$bank->id}}>{{$bank->bank_name}}</option>
            @endforeach
        </select>
    </label>
    <hr>
    <label>
        <select name="accountTypeId" class="browser-default custom-select">
            <option selected>Select Account Type</option>
            @foreach($accountTypes as $accountType)
                <option value={{$accountType->id}}>{{$accountType->account_type}}</option>
            @endforeach
        </select>
    </label>
    <hr>
    <label>
        <select name="currencyTypeId" class="browser-default custom-select">
            <option selected>Select Account Currency</option>
            @foreach($currencies as $currency)
                <option value={{$currency->id}}>{{$currency->currency_type}}</option>
            @endforeach
        </select>
    </label>
    <hr>
    {!! Form::submit('Submit') !!}
    {!! Form::close() !!}

@endsection
