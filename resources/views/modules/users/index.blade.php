@extends('includes.body')
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1>Users</h1>
            <div class="actionbtn">
                <a href="{{ url('backend/user/create') }}" class="btn btn-outline-dark btn-sm">
                    <i class="fas fa-plus"></i> Add User
                </a>
                <a href="{{ url('backend/user/export') }}" class="btn btn-outline-dark btn-sm">
                    <i class="fas fa-file-export"></i> Export
                </a>
            </div>
        </div>
        <div class="card-body table-responsive">
            <div class="table-responsive">
                <table id="userstable" class="table table-striped table-hover table-condensed">
                    <thead>
                    <tr>
                        <th>*</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tfoot>
                    <tr>
                        <th>*</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Role</th>
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
        $('#userstable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ url('backend/user/get') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columns": [
                { "data": "id" },
                { "data": "name" },
                { "data": "email" },
                { "data": "status" },
                { "data": "role" },
                { "data": "action" }
            ],
            "order": [[ 1, "asc" ]]


        });
    </script>
@endsection
