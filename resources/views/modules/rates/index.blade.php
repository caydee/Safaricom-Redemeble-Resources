@extends('includes.body')
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1>Rates</h1>
            <div class="actbtn">
                <a href="{{ route('rates.create') }}" class="btn btn-sm btn-outline-dark">
                    <i class="fas fa-plus"></i> Add Rate
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-seponsive">
                <table class="table table-condensed table-striped" id="rate-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Organization</th>
                            <th>Min Val</th>
                            <th>Max Val</th>
                            <th>Unit Cost</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Organization</th>
                        <th>Min Val</th>
                        <th>Max Val</th>
                        <th>Unit Cost</th>
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
        $('#rate-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ route('rates.datatable') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columns": [
                { "data": "pos" },
                { "data": "product" },
                { "data": "organization" },
                { "data": "min_value" },
                { "data": "max_value" },
                { "data": "unit_cost" },
                { "data": "action" }
            ],
            "order": [[ 1, "asc" ]]


        });
    </script>

@endsection

