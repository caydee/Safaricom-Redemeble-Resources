@extends('includes.body')
@section('content')
    <div class="card" aria-labelledby="add-role" id="edit-role-collapse">
        <div class="card-header">Edit Role</div>
        <div class="card-body">
            <form action="{{ route('user.role.update',[$user_id??0,$role->id]) }}" method="post" class="form form-horizontal create-form" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group form-row">
                    <div class="col-3">
                        <label for="role" class="control-label">Role Name</label>
                        <input type="text" name="role" id="edit-role" class="form-control" value="{{ $role->name }}">
                    </div>
                    <div class="col access">
                        <label class="control-label">Access</label>
                        @php($x=1)
                        <div class="row px-3">
                            @foreach(\App\Models\Permission::whereNotNull("name")->orderBy('name','asc')->get() as $value)

                                <div class="form-check col-3">
                                    <input class="form-check-input" type="checkbox" id="edit-perm-{{ $value->id }}" name="perm[]" value="{{ $value->id }}" >
                                    <label class="form-check-label" for="edit-perm-{{ $value->id }}">{{ $value->name }}</label>
                                </div>
                                @php($x++)
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="form-row form-group">
                    <button type="submit" class="ml-auto mr-2 btn btn-sgblue">Save</button>
                    <button class="btn btn-rr btn-sm add-button" data-toggle="collapse" data-target="#view-table" aria-expanded="true" aria-controls="view-table">
                        Close
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection
