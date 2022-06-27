@extends('includes.body')
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h1>Units</h1>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-condensed" id="units-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Organization</th>
                            <th>Product</th>
                            <th>Units</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Organization</th>
                            <th>Product</th>
                            <th>Units</th>
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
        $('#units-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ route('credits.datatable') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columns": [
                { "data": "pos" },
                { "data": "organization" },
                { "data": "product" },
                { "data": "units" },
                { "data": "action" }
            ],
            "order": [[ 1, "asc" ]]


        });
    </script>
@endsection
