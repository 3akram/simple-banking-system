@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between">
        <h3>User Account</h3>
        <a class="btn btn-outline-info" href="/accounts" > Back</a>
    </div>

    <label>
        <select name="bankId" class="browser-default custom-select">
            <option >{{$account->bank->bank_name}}</option>
        </select>
    </label>
    <hr>
    <label>
        <select name="accountTypeId" class="browser-default custom-select">
            <option >{{$account->accountType->account_type}}</option>
        </select>
    </label>
    <hr>
    <label>
        <select name="currencyTypeId" class="browser-default custom-select">
            <option>{{$account->currency->currency_type}}</option>
        </select>
    </label>
    <hr>
    <div class="d-flex justify-content-between">
        <h5>Created at {{$account->created_at}}</h5>
        <h5>Balance is {{$account->balance}}</h5>
    </div>

@endsection
