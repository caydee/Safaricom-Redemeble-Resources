@extends('includes.body')
@section('content')
    <div class="col-5 mx-auto">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">
                    Bulk Disbursement : Upload Contacts
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('disbursement.store') }}" class="form form-horizontal create-form">
                    <div class="form-group">
                        <label for="product" class="control-label">Product</label>
                        <select name="product" id="product" class="form-control select2">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="contact" class="control-label">Contact</label>
                        <input type="file" name="contact" id="contact">
                        <br>
                        <a href="">Sample csv</a>
                    </div>
                    <div class="form-group form-row">
                        <button class="btn btn-sm btn-primary ml-auto">
                            Send
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

@endsection
