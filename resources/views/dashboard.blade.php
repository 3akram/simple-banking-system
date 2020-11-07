@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="d-flex justify-content-around" >
                        <a class="btn btn-outline-primary" href="/accounts" >Accounts</a>
                        <a class="btn btn-outline-primary" href="/transactions" >Transactions</a>
                        <a class="btn btn-outline-success" href="/accounts" >Transfer Money</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
