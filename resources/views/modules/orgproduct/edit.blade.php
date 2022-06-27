@extends('includes.body')
@section('content')
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h1>{{ $org->name }} : Edit Product</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('organization.product.update',$org->id) }}" method="post" class="form form-horizontal create-form">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="product" class="control-label">Product</label>
                        <select name="product" id="product" class="select2 form-control">
                            @foreach($product as $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="access" class="control-label">Access</label>
                        <select name="access" id="access" class="select2 form-control">
                            @foreach($access as $value)
                                <option value="{{ $value->id }}">{{ $value->access_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="reply_sms" class="control-label">Sms Reply</label>
                        <textarea name="reply_sms" id="reply_sms"  class="form-control"></textarea>
                    </div>
                    <div class="form-group form-row">
                        <button type="submit" class="btn btn-outline-dark">Assign Product</button>
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
