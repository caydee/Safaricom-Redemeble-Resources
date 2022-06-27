@extends('includes.body')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h1>Edit User</h1>
            </div>
            <div class="card-body">
                <form action="{{ url('backend/user/'.$user->id) }}" method="post" class="form form-horizontal create-form">
                    @csrf
                    @method('PUT')
                    <div class="form-group form-row">
                        <div class="col col-md-8">
                            <label for="name" class="control-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}">
                        </div>
                        <div class="col col-md">
                            <label for="role" class="control-label">Role</label>
                            <select name="role" id="role" class="form-control select2">
                                @foreach($role as $value)
                                    <option value="{{ $value->id }}" @if($value->id == $user->role_id) selected @endif>{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}">
                    </div>

                    <div class="form-group form-row">
                        <div class="col">
                            <label for="password" class="control-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <div class="col">
                            <label for="con_password" class="control-label">Confirm Password</label>
                            <input type="password" name="con_password" id="con_password" class="form-control">
                        </div>

                    </div>
                    <div class="form-group form-row">
                        <button type="submit" class="btn  btn-dark ml-auto">Edit User</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
