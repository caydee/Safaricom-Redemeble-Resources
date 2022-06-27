@extends('includes.body')
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h1>Subscribers</h1>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="subscriber_table" class="table table-striped table-condensed">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>End Point</th>
                            <th>Product</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>End Point</th>
                            <th>Product</th>
                            <th>Created At</th>
                            <th>Updated At</th>
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
    <script type="application/javascript">
        $('#subscriber_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ url('backend/subscribers/get') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columns": [
                { "data": "pos" },
                { "data": "endpoint" },
                { "data": "product" },
                { "data": "created" },
                { "data": "updated" }

            ],
            "order": [[ 0, "desc" ]]
        });
    </script>
@endsection
