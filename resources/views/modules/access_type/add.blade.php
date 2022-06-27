@extends('includes.body')
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h1>Add Access Type</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('access_type.store') }}" method="post" class="form form-horizontal create-form">
                @csrf
                <div class="form-group">
                    <label for="access_type_name" class="control-label">Name</label>
                    <input type="text" name="access_type_name" id="access_type_name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="access_type_description" class="control-label">Description</label>
                    <textarea name="access_type_description" id="access_type_description" class="form-control editor"></textarea>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="active" name="active" checked value="1">
                    <label class="form-check-label" for="active">Active</label>
                </div>
                <div class="form-group form-row">
                    <button type="submit" class="btn btn-primary ml-auto">Save</button>
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
