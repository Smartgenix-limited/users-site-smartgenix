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
                        <h4 class="pt-2">{{ trans('general.feedback') }}</h4>
                    </div>
                    <div class="card-body">
                        @include('partials.message')

                        <form action="{{ route('feedback.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">{{ trans('general.name') }}</label>
                                <input id="name" class="form-control @error('name') is-invalid @enderror"
                                    type="text" name="name" value="{{ old('name', auth()->user()->name) }}" readonly>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">{{ trans('general.email_address') }}</label>
                                <input id="email" class="form-control @error('email') is-invalid @enderror"
                                    type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                                    readonly>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="message">{{ trans('general.your_message') }}</label>
                                <textarea id="message" class="form-control @error('message') is-invalid @enderror" name="message">{{ old('message', $feedback?->message) }}</textarea>
                                @error('message')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="what_do_you_like">{{ trans('general.what_do_you_like') }}</label>
                                <textarea id="what_do_you_like" class="form-control @error('what_do_you_like') is-invalid @enderror"
                                    name="what_do_you_like">{{ old('what_do_you_like', $feedback?->what_do_you_like) }}</textarea>
                                @error('what_do_you_like')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="how_improved">{{ trans('general.how_improved') }}</label>
                                <textarea id="how_improved" class="form-control @error('how_improved') is-invalid @enderror" name="how_improved">{{ old('how_improved', $feedback?->how_improved) }}</textarea>
                                @error('how_improved')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">{{ trans('general.send_feedback') }}</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
