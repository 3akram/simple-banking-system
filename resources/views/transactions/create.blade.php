@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between">
        <h3>Create New Transaction</h3>
        <a class="btn btn-outline-info" href="/transactions"> Back</a>
    </div>

    {!! Form::open(['action' => 'App\Http\Controllers\TransactionsController@store', 'method' => 'POST']) !!}
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (Session::has('success'))

            <div class="alert alert-success text-center">

                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>

                <p>{{ Session::get('success') }}</p>

            </div>

        @endif
        <table class="table table-bordered" id="dynamicTable">
            <tr>
                <th>Account Id</th>
                <th>Transaction Type</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
            <tr>
                <td>
                    <div class="form-group" >
                        <select name="transactionOperation[0][accountId]" class="browser-default custom-select">
                            <option>Select Account</option>
                            @foreach($accounts as $account)
                                <option value={{$account->id}}>{{$account->id}}</option>
                            @endforeach
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group" >
                        <select name="transactionOperation[0][transactionTypeId]" class="browser-default custom-select">
                            <option >Select Transaction Type</option>
                            @foreach($transactionTypes as $transactionType)
                                <option value={{$transactionType->id}}>{{$transactionType->transaction_type}}</option>
                            @endforeach
                        </select>
                    </div>

                </td>
                <td><input type="text" name="transactionOperation[0][amount]" placeholder="Enter Transaction Amount" class="form-control"/>
                </td>
                <td>
                    <button type="button" name="add" value="value" id="add" class="btn btn-success">Add More</button>
                </td>
            </tr>
        </table>
        <button type="submit" class="btn btn-success">Save</button>
    {!! Form::close() !!}

    <script type="text/javascript">
        var accounts = {!! json_encode($accounts->toArray()) !!};
        var transactionTypes = {!! json_encode($transactionTypes->toArray()) !!}
        var i = 0;

        $("#add").click(function () {
            ++i;
            var row = '<tr>';
            row += '<td><div class="form-group"><select name="transactionOperation['+i+'][accountId]" class="browser-default custom-select"><option>Select Account</option>';

            // account id section
            $.each(accounts, function(i, account){
                var accountId = account.id;
                row += '<option value='+accountId+'>'+accountId+'</option>'
            });
            row += '</select></div></td>'

            // transaction type section
            row += '<td><div class="form-group"><select name="transactionOperation['+i+'][transactionTypeId]" class="browser-default custom-select"><option>Select Transaction Type</option>';
            $.each(transactionTypes, function(i, transType){
                var transactionType = transType.transaction_type;
                var transactionTypeId = transType.id;
                row += '<option value='+transactionTypeId+'>'+transactionType+'</option>'
            });
            row += '</select></div></td>'

            // amount section
            row += '<td><div class="form-group">';
            row += '<input type="text" name="transactionOperation['+i+'][amount]" placeholder="Enter Amount" class="form-control" />'
            row += '</td></div>'

            // Action Section
            row += '<td><div class="form-group">';
            row += '<button type="button" class="btn btn-danger remove-tr">Remove</button>';
            row += '</td>'

            // closing tr
            row += '</tr>'

            $("#dynamicTable").append(row);
        });


        $(document).on('click', '.remove-tr', function () {

            $(this).parents('tr').remove();

        });
    </script>

@endsection
