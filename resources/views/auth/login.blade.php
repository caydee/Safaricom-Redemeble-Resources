@extends('layouts.app')

@section('content')
    <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
        <div class="d-table-cell align-middle">



            <div class="card">
                <div class="card-body">
                    <div class="m-sm-4">
                        <div class="text-center">
                            <img src="{{ asset('assets/img/logo.png') }}" width="250" alt="Tamaituk Logo">
                        </div>
                        <form  method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email">{{ __('Email') }}</label>
                                <input type="email" placeholder="Enter your email" class=" form-control-lg form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus />
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" type="password" placeholder="Enter your password" />
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small class="w-100 d-flex">
                                    <a href="{{ url('reset') }}">Forgot password?</a>
                                </small>
                            </div>
                            <div>
                                <div class="custom-control custom-checkbox align-items-center">
                                    <input type="checkbox" class="custom-control-input" value="remember-me" name="remember-me" checked>
                                    <label class="custom-control-label text-small">Remember me next time</label>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-lg btn-primary">Sign in</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @if($message = Session::get('error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-d.ismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif
        </div>
    </div>




@endsection
