@extends('includes.body')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1>API Credentials</h1>
            </div>
            <div class="card-body">
                <form action="{{ url('backend/security/generate') }}" method="post" class="form form-horizontal create-form">
                    @csrf
                    <div class="form-group form-row">
                        <div class="col-12 col-md-4">
                            <label for="id" class="control-label">Client ID</label>
                            <input type="text" name="id" id="credential_id" class="form-control" value="{{ !is_null($credential) ? $credential->id :'' }}" readonly>
                        </div>
                        <div class="col-12 col-md-8">

                        </div>

                    </div>
                    <div class="form-group">
                        <label for="secret" class="control-label">Client Secret</label>
                        <textarea  name="secret" rows="5" class="form-control" readonly>{{ !is_null($credential) ? $credential->secret :'' }}</textarea>

                    </div>

                    <div class="form-group d-flex">
                        <button type="submit" class="btn btn-sm btn-outline-dark ml-auto">Generate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

