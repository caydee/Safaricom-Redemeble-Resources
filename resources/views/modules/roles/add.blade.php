@extends('includes.body')
@section('content')
    <div class="card" aria-labelledby="add-role"  id="add-role">
        <div class="card-header">
            <h1>
                Add Role
            </h1>
        </div>
        <div class="card-body">
            <form action="{{ route('user.role.create',$user_id??0) }}" method="post" class="form form-horizontal create-form" enctype="multipart/form-data">
                @csrf
                <div class="form-group form-row">
                    <div class="col-3">
                        <label for="role" class="control-label">Role Name</label>
                        <input type="text" name="role" id="role" class="form-control">
                    </div>
                    <div class="col">
                        <label class="control-label">Access</label>
                        @php($x=1)
                        <div class="row px-3">
                            @foreach($perm as $value)

                                <div class="form-check col-3">
                                    <input class="form-check-input" type="checkbox" id="perm{{ $x }}" name="perm[]" value="{{ $value->id }}">
                                    <label class="form-check-label" for="perm{{ $x }}">{{ $value->name }}</label>
                                </div>
                                @php($x++)
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="form-row form-group">
                    <button type="submit" class="ml-auto mr-2 btn btn-dark btn-sm">Save</button>

                </div>
            </form>

        </div>
    </div>
@endsection
