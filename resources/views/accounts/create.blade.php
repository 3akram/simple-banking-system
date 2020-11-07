@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between">
        <h3>Create New Account</h3>
        <a class="btn btn-outline-info" href="/accounts" > Back</a>
    </div>

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
    <div class="d-flex justify-content-lg-end">
        {!! Form::submit('Submit', ['class' => 'btn btn-success']) !!}
    </div>
    {!! Form::close() !!}

@endsection
