@extends('layouts.auth')

@section('content')
    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-md-6">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row justify-content-center">
                        {{-- <div class="col-lg-6 d-none d-lg-block bg-login-image">
                        </div> --}}
                        <div class="col-12">
                            <div class="px-5 pb-5 pt-3">
                                <div class="d-flex justify-content-center mb-3">
                                    <img src="{{ asset('images/logo.jpeg') }}" alt="{{ config('app.name') }}" width="200">
                                </div>

                                {{-- <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                </div> --}}
                                @if (session('error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <form class="user" method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <label for="">Account Type</label>
                                    <div class="mb-3 d-flex gap-3">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="solo" name="type" class="custom-control-input"
                                                value="solo" onchange="typeChanged(this.value)"
                                                @checked(old('type', 'solo') === 'solo') required>
                                            <label class="custom-control-label" for="solo">Solo</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="trader" name="type" class="custom-control-input"
                                                value="trader" onchange="typeChanged(this.value)"
                                                @checked(old('type') === 'trader') required>
                                            <label class="custom-control-label" for="trader">Trader</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="first_name"
                                            class="form-control form-control-user @error('first_name') is-invalid @enderror"
                                            id="first_name" aria-describedby="first_name" placeholder="Enter First Name"
                                            value="{{ old('first_name') }}">
                                        @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="last_name"
                                            class="form-control form-control-user @error('last_name') is-invalid @enderror"
                                            id="last_name" aria-describedby="last_name" placeholder="Enter Last Name"
                                            value="{{ old('last_name') }}">
                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    @livewire('register-country', ['type' => 'register'])
                                    {{-- <div class="form-group">
                                        <input type="text" name="username"
                                            class="form-control form-control-user @error('username') is-invalid @enderror"
                                            id="name" aria-describedby="username" placeholder="Enter Username"
                                            value="{{ old('username') }}">
                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div> --}}

                                    <div class="form-group">
                                        <input type="email" name="email"
                                            class="form-control form-control-user @error('email') is-invalid @enderror"
                                            id="exampleInputEmail" aria-describedby="emailHelp"
                                            placeholder="Enter Email Address" value="{{ old('email') }}">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <input type="tel" name="mobile"
                                            class="form-control form-control-user @error('mobile') is-invalid @enderror"
                                            id="mobile" aria-describedby="mobile" placeholder="Enter Your Mobile Number"
                                            value="{{ old('mobile') }}">
                                        @error('mobile')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div id="companyDiv" class="form-group @if (old('type') !== 'trader') d-none @endif">
                                        <input type="text" name="company"
                                            class="form-control form-control-user @error('company') is-invalid @enderror"
                                            id="company" aria-describedby="company" placeholder="Enter Your Company Name"
                                            value="{{ old('company') }}">
                                        @error('company')
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
                                        <input type="password" name="password_confirmation"
                                            class="form-control form-control-user" id="exampleRepeatPassword"
                                            placeholder="Comfirm Password">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Register
                                    </button>
                                </form>
                                <hr>
                                {{-- <div class="text-center">
                                    <a class="small" href="{{ route('password.request') }}">Forgot Password?</a>
                                </div> --}}
                                <div class="text-center">
                                    <a class="small" href="{{ route('login') }}">Already have an account? Login!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function typeChanged(type) {
            let company = document.getElementById('companyDiv');
            if (type === 'trader') {
                company.classList.remove("d-none");
            } else {
                company.classList.add("d-none");
            }
        }
    </script>
@endpush
