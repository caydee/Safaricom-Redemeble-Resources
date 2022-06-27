@extends('includes.body')
@section('content')
    <div class="col">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h1>Transactions</h1>
                <div class="actionbtn">
                    <a href="{{ route('transaction.create') }}" class="btn btn-sm btn-outline-dark">
                        <i class="fas fa-plus"></i> Add Payment
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-condensed" id="trans-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Receipt No</th>
                                <th>Organization</th>
                                <th>Channel</th>
                                <th>Amount</th>
                                <th>Rate</th>
                                <th>Units</th>
                                <th>Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Receipt No</th>
                                <th>Organization</th>
                                <th>Channel</th>
                                <th>Amount</th>
                                <th>Rate</th>
                                <th>Units</th>
                                <th>Time</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('header')

@endsection
@section('footer')
    <script>
        $('#trans-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ route('transaction.datatable') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columns": [
                { "data": "pos" },
                { "data": "receipt" },
                { "data": "organization" },
                { "data": "channel" },
                { "data": "amount" },
                { "data": "rate" },
                { "data": "units" },
                { "data": "time" },
                { "data": "action" }
            ],
            "order": [[ 7, "desc" ]]


        });
    </script>
@endsection
