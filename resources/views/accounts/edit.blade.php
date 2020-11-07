@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between">
        <h3>Edit User Account</h3>
        <a class="btn btn-outline-info" href="/accounts" > Back</a>
    </div>

    {!! Form::open(['action' => ['App\Http\Controllers\AccountsController@update', $account->id], 'method' => 'POST']) !!}

    <label>
        <select name="bankId" class="browser-default custom-select">
            <option >Select Bank</option>
            @foreach($banks as $bank)
                <option {{$bank->id == $account->bank_id ? "selected": ''}} value={{$bank->id}}>{{$bank->bank_name}}</option>
                <p>{{$bank->id}}</p>
            @endforeach
        </select>
    </label>
    <hr>
    <label>
        <select name="accountTypeId" class="browser-default custom-select">
            <option >Select Account Type</option>
            @foreach($accountTypes as $accountType)
                <option {{$accountType->id == $account->account_type_id ? "selected" : ''}} value={{$accountType->id}}>{{$accountType->account_type}}</option>
            @endforeach
        </select>
    </label>
    <hr>
    <label>
        <select name="currencyTypeId" class="browser-default custom-select">
            <option>Select Account Currency</option>
            @foreach($currencies as $currency)
                <option  {{$currency->id == $account->currency_id ? "selected" : ''}} value={{$currency->id}}>{{$currency->currency_type}}</option>
            @endforeach
        </select>
    </label>
    <hr>

    <div class="d-flex justify-content-lg-end">
        {{Form::hidden('_method', 'PUT')}}
        {!! Form::submit('Save', ['class' => 'btn btn-success']) !!}
    </div>
    {!! Form::close() !!}

@endsection
