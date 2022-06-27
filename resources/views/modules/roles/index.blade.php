@extends('includes.body')
@section('content')
    <div class="col-12">


            <div class="card" id="view-table" aria-labelledby="view-table" >
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h1>Roles</h1>
                    <a class="btn btn-outline-dark btn-sm"  href="{{ route('user.role.create',0) }}" >
                        <i class="align-middle" data-feather="plus"></i> Add Role
                    </a>

                </div>
                <div class="card-body">
                    <div class="table-responsive w-100">
                        <table class="table table-striped " id="roles-table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Role Name</th>
                                <th>Access</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Role Name</th>
                                <th>Access</th>
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
        $('#roles-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ route('user.role.datatable',$user_id??0) }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columns": [
                { "data": "pos" },
                { "data": "name" },
                { "data": "access" },
                { "data": "action" }
            ],
            "order": [[ 1, "asc" ]]
        });
    </script>
@endsection
