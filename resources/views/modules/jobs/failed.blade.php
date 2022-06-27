@extends('includes.body')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h1>Failed Jobs</h1>
        </div>
        <div class="card-body">
            <table id="failed_jobs_table" class="table table-striped table-condensed" >
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Connection</th>
                        <th>Queue</th>
                        <th>Payload</th>
                        <th>Exception</th>
                        <th>Failed At</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Connection</th>
                        <th>Queue</th>
                        <th>Payload</th>
                        <th>Exception</th>
                        <th>Failed At</th>
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
    <script>
        $('#failed_jobs_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ url('backend/jobs/failed/get') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columns": [
                { "data": "id" },
                { "data": "connection" },
                { "data": "queue" },
                { "data": "payload" },
                { "data": "exception" },
                { "data": "failed_at"}
            ],
            "order": [[ 1, "asc" ]]
        });
    </script>
@endsection
