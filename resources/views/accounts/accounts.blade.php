@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between m-4">
        <h3>User Accounts</h3>
        <a class="btn btn-primary" href="/accounts/create" >Create New Account</a>
    </div>
    <div>
        <h4>Filter Accounts By Bank</h4>
        {!! Form::open(['action' => 'App\Http\Controllers\AccountsController@applyFilter', 'method' => 'POST']) !!}
        <label>
            <select class="browser-default custom-select" name="bankId">
                <option selected value="{{-1}}">All</option>
                @foreach($banks as $bank)
                    <option value="{{$bank->id}}" >{{$bank->bank_name}}</option>
                @endforeach
            </select>
        </label>
        {!! Form::submit('Filter', ['class' => 'btn btn-success']) !!}
        {!! Form::close() !!}
    </div>
{{--    <div>--}}
{{--        <a href="/accounts/filter/by-bank" >Filter Accounts By Bank</a>--}}
{{--    </div>--}}
    @if(count($accounts) > 0)
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Bank</th>
                <th scope="col">Account Type</th>
                <th scope="col">Currency</th>
                <th scope="col">Balance</th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($accounts as $account)
                <tr>
                    <th scope="row">{{$account->id}}</th>
                    <td>{{$account->bank->bank_name}}</td>
                    <td>{{$account->accountType->account_type}}</td>
                    <td>{{$account->currency->currency_type}}</td>
                    <td>{{$account->balance}}</td>
                    <td><a class="btn btn-outline-primary" href="/accounts/{{$account->id}}">Show</a></td>
                    <td><a class="btn btn-outline-primary" href="/accounts/{{$account->id}}/edit">Edit</a></td>
                    <td>
                        {!!Form::open(['action' => ['App\Http\Controllers\AccountsController@flipStatus', $account->id], 'method' => 'POST'])!!}
                        {!! Form::hidden('_method', 'PUT') !!}
                        @if($account->active == 1)
                            {!! Form::submit('Deactivate', ['class' => 'btn btn-outline-danger']) !!}
                        @else
                            {!! Form::submit('Activate', ['class' => 'btn btn-success']) !!}
                        @endif
                        {!!Form::close()!!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    @else
        <p>You don't have accounts yet!</p>
        <hr>
        <a class="btn btn-outline-primary" href="/accounts/create" >Create One</a>
    @endif
@endsection


