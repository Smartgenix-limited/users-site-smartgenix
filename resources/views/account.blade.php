@extends('layouts.app')

@section('content')
    <div class="container page-container">
        <div class="row justify-content-center">
            {{-- account fields --}}
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center p-1">
                        {{-- <a href="{{ route('dashboard') }}" class="float-left fs-30 pl-2 text-primary"><i
                                class="bi bi-arrow-left-short"></i></a> --}}
                        <h4 class="pt-2">{{ trans('general.my_account') }}</h4>
                    </div>
                    <div class="card-body">
                        @include('partials.message')

                        <form action="{{ route('account.update') }}" method="POST">
                            @csrf

                            <label for="type">{{ trans('general.account_type') }}</label>
                            <div class="mb-3 d-flex align-items-center gap-3">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="solo" name="type" class="custom-control-input"
                                        value="solo" @checked(old('type', auth()->user()->type) === 'solo') required>
                                    <label class="custom-control-label" for="solo">{{ trans('general.solo') }}</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="trader" name="type" class="custom-control-input"
                                        value="trader" @checked(old('type', auth()->user()->type) === 'trader') required>
                                    <label class="custom-control-label" for="trader">{{ trans('general.trader') }}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="first_name">{{ trans('general.first_name') }}</label>
                                <input id="first_name" class="form-control @error('first_name') is-invalid @enderror"
                                    type="text" name="first_name" value="{{ auth()->user()->first_name }}">
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="first_name">{{ trans('general.last_name') }}</label>
                                <input id="last_name" class="form-control @error('last_name') is-invalid @enderror"
                                    type="text" name="last_name" value="{{ auth()->user()->last_name }}">
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="email">{{ trans('general.email_address') }}</label>
                                <input id="email" class="form-control @error('email') is-invalid @enderror"
                                    type="email" name="email" value="{{ auth()->user()->email }}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="mobile">{{ trans('general.mobile_number') }}</label>
                                <input id="mobile" class="form-control @error('mobile') is-invalid @enderror"
                                    type="phone" name="mobile" value="{{ auth()->user()->mobile }}">
                                @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            @livewire('register-country', ['type' => 'account'])
                            {{-- <div class="form-group">
                                <label for="address">Address</label>
                                <input id="address" class="form-control @error('address') is-invalid @enderror"
                                    type="text" name="address" value="{{ auth()->user()->address }}">
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="postcode">Post Code</label>
                                <input id="postcode" class="form-control @error('postcode') is-invalid @enderror"
                                    type="text" name="postcode" value="{{ auth()->user()->postcode }}">
                                @error('postcode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> --}}

                            <div class="form-group">
                                <label for="password">{{ trans('general.password') }}</label>
                                <input id="password" class="form-control @error('password') is-invalid @enderror"
                                    type="password" name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;">
                                <small class="text-genix">{{ trans('general.old_password_keep') }}</small>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">{{ trans('general.confirm_password') }}</label>
                                <input id="password_confirmation" class="form-control" type="password"
                                    name="password_confirmation"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;">
                            </div>

                            <button type="submit"
                                class="btn btn-primary">{{ trans('general.update', ['type' => '']) }}</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
