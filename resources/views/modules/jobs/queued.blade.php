@extends('includes.body')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h1>Queued Jobs</h1>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="queued_jobs_table" class="table table-striped table-condensed" >
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Attempts</th>
                        <th>Queue</th>
                        <th>Payload</th>
                        <th>Reserved at</th>
                        <th>Available at</th>
                        <th>Created at</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Attempts</th>
                        <th>Queue</th>
                        <th>Payload</th>
                        <th>Reserved at</th>
                        <th>Available at</th>
                        <th>Created at</th>
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
        $('#queued_jobs_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ url('backend/jobs/queued/get') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columns": [
                { "data": "id" },
                { "data": "attempt" },
                { "data": "queue" },
                { "data": "payload" },
                { "data": "reserved_at" },
                { "data": "available_at"},
                { "data": "created_at"}
            ],
            "order": [[ 1, "asc" ]]
        });
    </script>
@endsection

