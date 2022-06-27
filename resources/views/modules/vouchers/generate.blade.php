@extends('includes.body')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1>Generate Vouchers</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('vouchers.generate') }}" method="post" class="form form-horizontal create-form" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="count" class="control-label">No of Vouchers</label>
                        <input type="text" name="count" id="count" class="form-control">
                    </div>
                    <div class="form-group ">
                        <label for="product_type" class="control-label">Product</label>
                        <select name="product" id="product" class="form-control select2" >
                            @foreach($products as $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="form-group form-row">
                        <button type="submit" class="btn btn-outline-dark  ml-auto">Generate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

