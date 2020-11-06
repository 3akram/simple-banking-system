@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between m-4">
        <h3>User Transactions</h3>
        <a class="btn btn-primary" href="/transactions/create" >Create New Transaction</a>
    </div>
    <div>
        <h4>Filter Transactions By Date</h4>
{{--        {!! Form::open(['action' => 'App\Http\Controllers\AccountsController@applyFilter', 'method' => 'POST']) !!}--}}
{{--        <label>--}}
{{--            <select class="browser-default custom-select" name="bankId">--}}
{{--                <option selected value="{{-1}}">All</option>--}}
{{--                @foreach($banks as $bank)--}}
{{--                    <option value="{{$bank->id}}" >{{$bank->bank_name}}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--        </label>--}}
{{--        {!! Form::submit('Filter', ['class' => 'btn btn-success']) !!}--}}
{{--        {!! Form::close() !!}--}}
    </div>

    @if(count($transactions) > 0)
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Created At</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <th scope="row">{{$transaction->id}}</th>
                    <td>{{$transaction->created_at}}</td>
                    <td>
                        {!!Form::open(['action' => ['App\Http\Controllers\TransactionsController@destroy', $transaction->id], 'method' => 'POST'])!!}
                        {!! Form::hidden('_method', 'PUT') !!}
                        @if(1)
                            {!! Form::submit('Delete', ['class' => 'btn btn-outline-danger']) !!}
                        @endif
                        {!!Form::close()!!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    @else
        <p>You don't have any transactions yet!</p>
        <hr>
        <a class="btn btn-outline-primary" href="/transactions/create" >Create One</a>
    @endif
@endsection
