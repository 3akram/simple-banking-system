@extends('layouts.app')

@section('content')
    <h1>User Accounts</h1>
    @if(count($accounts) > 0)
        @foreach($accounts as $account)
            <p>{{$account->id}}</p>
            @endforeach
    @else
        <p>You don't have accounts yet!</p>
        <hr>
        <a class="btn btn-outline-primary" href="/accounts/create" >Create One</a>
    @endif
@endsection
