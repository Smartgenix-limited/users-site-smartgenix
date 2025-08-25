@extends('layouts.auth')

@section('content')
    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9 mt-4">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row ">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image">
                        </div>
                        <div class="col-lg-6">
                            <div class="px-5 pb-5 pt-3">
                                <div class="d-flex justify-content-center mb-3">
                                    <img src="{{ asset('images/logo.jpeg') }}" alt="{{ config('app.name') }}" width="200">
                                </div>

                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">{{ __('general.welcome_back') }}</h1>
                                </div>
                                @if (session('success'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <form class="user" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" name="email"
                                            class="form-control form-control-user @error('email') is-invalid @enderror"
                                            id="exampleInputEmail" aria-describedby="emailHelp"
                                            placeholder="Enter Email Address..." value="{{ old('email') }}">
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
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" name="remember" class="custom-control-input"
                                                id="customCheck" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="custom-control-label"
                                                for="customCheck">{{ __('general.remember_me') }}</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        {{ __('general.login') }}
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small"
                                        href="{{ route('password.request') }}">{{ __('general.forget_password') }}</a>
                                </div>
                                <div class="text-center">
                                    <a class="small"
                                        href="{{ route('register') }}">{{ __('general.create_account') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
