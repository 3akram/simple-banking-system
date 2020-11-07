@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between m-4">
        <h3>Create Transfer</h3>
        <a class="btn btn-outline-info" href="/transactions"> Back</a>
    </div>
    {!! Form::open(['action' => 'App\Http\Controllers\TransactionsController@createTransfer', 'method' => 'POST']) !!}
    <table class="table table-bordered" id="dynamicTable">
        <tr>
            <th>From</th>
            <th>Action</th>
        </tr>
        <tr>
            <td><input type="text" name="from" placeholder="Enter Your Account Id" class="form-control"/></td>
            <td>
                <button type="button" name="add" id="add" class="btn btn-success">Add Target Account</button>
            </td>
        </tr>
    </table>
    <button type="submit" class="btn btn-success">Save</button>
    {!! Form::close() !!}
    <script type="text/javascript">
        var i = 0;
        $("#add").click(function () {
            ++i;
            $("#dynamicTable").append('<tr><td><input type="text" name="transferOperation[' + i + '][target]" placeholder="Target Account Id" class="form-control" /></td><td><input type="text" name="transferOperation[' + i + '][amount]" placeholder="Amount" class="form-control" /></td><td><button type="button" class="btn btn-danger btn-sm remove-tr">Remove</button></td></tr>');
        });
        $(document).on('click', '.remove-tr', function () {

            $(this).parents('tr').remove();

        });
    </script>

@endsection
