@extends('layouts.auth')

@section('content')
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                <div class="col-lg-6">
                    <div class="px-5 pb-5 pt-3">
                        <div class="d-flex justify-content-center mb-3">
                            <img src="{{ asset('images/logo.jpeg') }}" alt="{{ config('app.name') }}" width="200">
                        </div>
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">{{ __('Reset Password') }}</h1>
                        </div>
                        <form class="user" method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group">
                                <input type="email" name="email"
                                    class="form-control form-control-user @error('email') is-invalid @enderror"
                                    id="exampleInputEmail" placeholder="Email Address" value="{{ $email ?? old('email') }}"
                                    required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" name="password"
                                    class="form-control form-control-user @error('password') is-invalid @enderror"
                                    id="exampleInputPassword" placeholder="Password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" name="password_confirmation" class="form-control form-control-user"
                                    id="exampleRepeatPassword" placeholder="Comfirm Password">
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                {{ __('Reset Password') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
