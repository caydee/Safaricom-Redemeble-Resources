@extends('includes.body')
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1>Access Type</h1>
            <div class="actionbtn">
                <a href="{{ route('access_type.create') }}" class="btn btn-sm btn-outline-dark">
                    <i class="fas fa-plus"></i>
                    Add Access Type
                </a>
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-condensed table-hover" id="access-type-table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Access Type</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Access Type</th>
                        <th>Description</th>
                        <th>Status</th>
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
        $('#access-type-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ route('access_type.datatable') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columns": [
                { "data": "pos" },
                { "data": "access_type" },
                { "data": "access_description" },
                { "data": "status" },
                { "data": "action" }
            ],
            "order": [[ 1, "asc" ]]


        });
    </script>
@endsection
