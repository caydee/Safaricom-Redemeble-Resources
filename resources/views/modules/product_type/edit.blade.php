@extends('includes.body')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h1>Edit Product Type</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('product_type.update',$producttype->id) }}" method="post" class="form form-horizontal create-form">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="product_type" class="control-label">Name</label>
                        <input type="text" name="product_type" id="product_type" class="form-control" value="{{ $producttype->product_type }}">
                    </div>
                    <div class="form-group">
                        <label for="product_description" class="control-label">Description</label>
                        <textarea name="product_description" id="product_description" class="form-control editor">{{ $producttype->product_type_description }}</textarea>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="active" name="active" @if($producttype->product_type_status == 1)checked @endif value="1">
                        <label class="form-check-label" for="active">Active</label>
                    </div>
                    <div class="form-group form-row">
                        <button class="btn ml-auto btn-primary" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('header')

@endsection
@section('footer')
@endsection
