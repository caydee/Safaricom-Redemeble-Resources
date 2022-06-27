@extends('includes.body')
@section('content')
    <div class="col">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1>{{ $org->name }}</h1>
                <div class="actionbtn">
                    <a href="{{ route('organization.product.create',$org->id) }}" class="btn btn-sm btn-outline-dark">
                        <i class="fas fa-plus"></i>
                        Assign Product
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-condensed table-striped" id="orgprod-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Units</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Units</th>
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
    <script type="application/javascript">
        $('#orgprod-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ route('organization.product.datatable',$org->id) }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columns": [
                { "data": "pos" },
                { "data": "product" },
                { "data": "units" },
                { "data": "action" }

            ],
            "order": [[ 1, "asc" ]]
        });
    </script>
@endsection
