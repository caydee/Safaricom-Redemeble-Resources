@extends('includes.body')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1>Add Organization</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('organization.store') }}" method="post" class="form form-horizontal create-form"  autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="organization_name" class="control-label">Organization Name</label>
                        <input type="text" name="organization_name" id="organization_name"  class="form-control"  autocomplete="false">
                    </div>
                    <div class="form-group form-row">
                        <div class="col-12 col-md">
                            <label for="admin_name" class="control-label">Admin Name</label>
                            <input type="text" name="admin_name" id="admin_name" class="form-control"  autocomplete="false">
                        </div>
                        <div class="col-12 col-md">
                            <label for="admin_email" class="control-label">Admin Email</label>
                            <input type="email" name="admin_email" id="admin_email" class="form-control"  autocomplete="false">
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="phone" class="control-label">Admin Phone No</label>
                        <input type="text" name="phone" id="phone" class="form-control"  autocomplete="false">
                    </div>
                    <div class="form-group form-row">
                        <div class="col-12 col-md">
                            <label for="password" class="control-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control"  autocomplete="false">
                        </div>
                        <div class="col-12 col-md">
                            <label for="confirm_password" class="control-label">Confirm Password</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control"  autocomplete="false">
                        </div>
                    </div>

                    <div class="form-group d-flex">
                        <button type="submit" class="btn btn-sm btn-outline-dark ml-auto">Add Organization</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
