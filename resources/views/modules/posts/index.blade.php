@extends('includes.body')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Notifications</h3>
            <div class="actionbtn">
                <a href="{{ url('backend/notification/create') }}" class="btn btn-sm btn-outline-dark"><i class="fas fa-plus mr-1"></i>Add Notification</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="notificationtable" class="table table-striped table-condensed" >
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>title</th>
                            <th>Date</th>
                            <th>Deliveries</th>
                            <th>Author</th>
                            <th>status</th>
                            <th>Product</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>title</th>
                            <th>Date</th>
                            <th>Deliveries</th>
                            <th>Author</th>
                            <th>status</th>
                            <th>Product</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('header')

@endsection
@section('footer')
    <script type="application/javascript">
        $('#notificationtable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ url('backend/notification/get') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columns": [
                { "data": "pos" },
                { "data": "title" },
                { "data": "date" },
                { "data": "deliveries" },
                { "data": "author" },
                { "data": "status" },
                { "data": "product" }

            ],
            "order": [[ 0, "desc" ]]
        });
    </script>
@endsection
