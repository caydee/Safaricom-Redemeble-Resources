@extends('includes.body')
@section('content')

        <div class="col-12">
            <div class="table-responsive">
                <div class="card">
                    <div class="card-header">
                        <h1>Logs</h1>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-condensed" id="logger">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Action</th>
                                <th>Excecutor</th>
                                <th>Model</th>
                                <th>Affected Id</th>
                                <th>Change</th>
                                <th>Time</th>
                            </tr>
                            </thead>
                            <tbody>


                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Action</th>
                                <th>Excecutor</th>
                                <th>Model</th>
                                <th>Affected Id</th>
                                <th>Change</th>
                                <th>Time</th>
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
        $('#logger').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ route('log.datatable') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columns": [
                { "data": "pos" },
                { "data": "action" },
                { "data": "executer" },
                { "data": "model" },
                { "data": "affectedid" },
                { "data": "change" },
                { "data": "time"}

            ],
            "order": [[ 0, "desc" ]]
        });
    </script>

@endsection
