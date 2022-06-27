@extends('includes.body')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                    <h2>Permissions</h2>
                    <a class="btn btn-outline-dark btn-sm " href="{{ route('user.permission.create',$id??0) }}">
                        <i class="align-middle" data-feather="plus"></i> Add Permission
                    </a>
            </div>
            <div class="card-body ">
                <div class="table-responsive">
                    <table class="table table-striped " id="permissions-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Access</th>
                                <th>Roles</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Access</th>
                                <th>Roles</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
    </div>

@endsection
@section("header")

@endsection

@section("footer")
    <script>
        $('#permissions-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ route('user.permission.datatable',$id??0) }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columns": [
                { "data": "pos" },
                { "data": "name" },
                { "data": "access" },
                { "data": "roles" },
                { "data": "action" }
            ],
            "order": [[ 1, "asc" ]]
        });
    </script>
@endsection
