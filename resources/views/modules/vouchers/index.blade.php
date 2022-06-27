@extends('includes.body')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1>Vouchers</h1>
                <div class="actionbtn">
                    <a href="{{ route('vouchers.generate.get') }}" class="btn btn-sm btn-outline-dark"><i class="fas fa-plus"></i> Generate vouchers</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-hover" id="products-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Voucher</th>
                            <th>Batch #</th>
                            <th>Company</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Voucher</th>
                            <th>Batch #</th>
                            <th>Company</th>
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
    <script type="application/javascript">
        $('#products-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ route('vouchers.get') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
            "columns": [
                { "data": "pos" },
                { "data": "voucher" },
                { "data": "batch" },
                { "data": "company"},
                { "data": "status" },
                { "data": "action" }

            ],
            "order": [[ 0, "desc" ]]
        });
    </script>
@endsection

