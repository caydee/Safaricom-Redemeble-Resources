@extends('includes.body')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1>Edit Product</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('product.update',$product->id) }}" method="post" class="form form-horizontal create-form" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="name" class="control-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control"  value="{{ $product->name }}">
                    </div>
                    <div class="form-group">
                        <label for="sender_name" class="control-label">Sender Name</label>
                        <input type="text" name="sender_name" id="sender_name" class="form-control"  value="{{ $product->sender_name }}">
                    </div>
                    <div class="form-group">
                        <label for="product_type" class="control-label">Product Type</label>
                        <select name="product_type" id="product_type" class="form-control select2" >
                            @foreach($product_type as $value)
                                <option value="{{ $value->id }}" @if( $value->id === $product->product_type_id) selected @endif>{{ $value->product_type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group form-row">
                        <button type="submit" class="btn btn-dark ml-auto">Edit Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
