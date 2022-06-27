@extends('includes.body')
@section('content')
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h1>Add Payment</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('transaction.store') }}" method="post" class="form form-horizontal create-form">
                    @csrf()
                    <div class="form-group form-row">
                        <div class="col">
                            <label for="organization" class="control-label">Organization</label>
                            <select name="organization_id" id="organization" class="form-control select2">
                                <option value="0" selected>select Value</option>
                                @foreach($organization as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="product" class="control-label">Product</label>
                            <select name="product_id" id="product" class="form-control select2">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="receipt_no" class="control-label">Receipt No</label>
                        <input type="text" name="receipt" id="receipt_no" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="amount" class="control-label">Amount</label>
                        <input type="text" name="amount" id="amount" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="channel" class="control-label">Channel</label>
                        <input type="text" name="channel" id="channel" class="form-control">
                    </div>
                    <div class="form-group form-row">
                        <button type="submit" class="btn btn-outline-dark btn-sm ml-auto">Add Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('header')

@endsection
@section('footer')
    <script type="application/javascript">
        $('#organization').on('select2:select', function (e) {
            var dt      =    e.params.data.element.value;
            var link    =   '{{ url("backend/organization/") }}/'+dt+'/check';
            console.log(link);
            var product =   $('#product');
            product.empty().trigger("change");
            $.ajax({
                type: 'GET',
                url: link
            }).then(function (data) {
                console.log(data);
                // create the option and append to Select2
                $.each(data, function(key,value) {
                    console.log(value);
                    var option = new Option(value.product.name, value.product.id, true, true);
                    product.append(option).trigger('change');
                });

            });

        });


    </script>
@endsection
