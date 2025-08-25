@extends('layouts.app')

@section('content')
    <div class="container page-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center p-1">
                        {{-- <a href="{{ route('mots.index') }}" class="float-left fs-30 pl-2 text-primary"><i
                                class="bi bi-arrow-left-short"></i></a> --}}
                        <h4 class="pt-2">{{ __('reviews.title') }}</h4>
                    </div>
                    <div class="card-body">
                        @include('partials.message')

                        <form id="form" action="{{ route('reviews.store') }}" method="POST">
                            @csrf

                            @foreach ($types as $type)
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="form-group">
                                        <label for="location" class="d-block">{{ __('reviews.' . $type) }}</label>
                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                            @foreach ($numbers as $number)
                                                <label
                                                    class="btn btn-circle btn-sm btn-outline-genix shadow-none fs-18 d-flex align-items-center">
                                                    <input type="radio" name="{{ $type }}"
                                                        id="{{ $type }}{{ $number }}"
                                                        value="{{ $number }}">
                                                    {{ $number }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                    <h4 id="{{ $type }}" class="fw-semibold text-center d-none">4/5</h4>
                                </div>
                            @endforeach


                            <div class="form-group">
                                <label for="description">{{ __('reviews.comment') }}</label>
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description"
                                    rows="3"></textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div id="submitBtn" class="text-center mt-4">
                                <button type="submit" class="btn btn-primary">{{ __('general.submit') }}</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
