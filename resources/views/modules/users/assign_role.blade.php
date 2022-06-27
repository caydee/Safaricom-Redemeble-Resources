@extends('includes.body')
@section('content')
<div class="col-12">
    <div class="card shadow-lg m-0">
        <div class="card-header d-flex justify-content-between">
            <h5 class="modal-title">Assign Roles</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="card-body">
            <form action="{{ url('management/users/roles/assign') }}" class="form form-horizontal create-form" method="post">
                @csrf
                <input type="hidden" name="userid" id="add-user-id">
                <div class="form-group">
                    <label for="add-role" class="control-label">Role</label>
                    <select name="role" id="add-role" class="custom-select">
                        @foreach(\App\Models\Role::get() as $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group form-row">
                    <div class="ml-auto">
                        <button type="submit" class="btn btn-primary">Save</button>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
