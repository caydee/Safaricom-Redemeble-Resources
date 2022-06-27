@extends('includes.body')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1>Organizations</h1>
                <div class="actionbtn">
                    <a href="{{ route('organization.create') }}" class="btn btn-sm btn-outline-dark">
                        <i class="fas fa-plus"></i> Organization
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-condensed table-hover" id="organization_table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Company Name</th>
                                <th>Parent Company</th>
                                <th>Status</th>
                                <th>Contact Name</th>
                                <th>Contact Email</th>
                                <th>Contact PhoneNo</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Company Name</th>
                                <th>Parent Company</th>
                                <th>Status</th>
                                <th>Contact Name</th>
                                <th>Contact Email</th>
                                <th>Contact PhoneNo</th>
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
        $('#organization_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ route('organization.datatable') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columns": [
                { "data": "pos" },
                { "data": "name" },
                { "data": "parent" },
                { "data": "status" },
                { "data": "owner" },
                { "data": "email" },
                { "data": "phone_no" },
                { "data": "action" }
            ],
            "order": [[ 1, "asc" ]]


        });
    </script>
@endsection
