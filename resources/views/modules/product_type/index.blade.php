@extends('includes.body')
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1>Product Type</h1>
            <div class="action-btn">
                <a href="{{ url('backend/product-type/create') }}" class="btn btn-sm btn-outline-dark">
                    <i class="fas fa-plus"></i>
                    Add Product Type
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-condensed" id="product-type-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
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
        $('#product-type-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ route('product_type.datatable') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columns": [
                { "data": "pos" },
                { "data": "product_type" },
                { "data": "product_description" },
                { "data": "status" },
                { "data": "action" }
            ],
            "order": [[ 1, "asc" ]]


        });
    </script>

@endsection
