@extends('includes.body')
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h1>Add Rate</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('rates.store') }}" method="post" class="create-form form form-horizontal">
                @csrf
                <div class="form-group form-row">
                    <div class="col">
                        <label for="organization" class="control-label">Organization</label>
                        <select name="organization" id="organization" class="form-control select2">
                            <option value="0" selected>select Value</option>
                            @foreach($organization as $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                           @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <label for="product" class="control-label">Product</label>
                        <select name="product" id="product" class="form-control select2">
                            <option value=""></option>
                        </select>
                    </div>

                </div>
                <div class="form-group">
                    <label for="min_val" class="control-label">Min Value</label>
                    <input type="text" name="min_val" id="min_val" class="form-control">
                </div>
                <div class="form-group">
                    <label for="max_val" class="control-label">Max Value</label>
                    <input type="text" name="max_val" id="max_val" class="form-control">
                </div>
                <div class="form-group">
                    <label for="unit_cost" class="control-label">Unit Cost</label>
                    <input type="text" name="unit_cost" id="unit_cost" class="form-control">
                </div>
                <div class="form-group form-row">
                    <button type="submit" class="btn btn-outline-dark ml-auto">
                        Add Rate
                    </button>
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
