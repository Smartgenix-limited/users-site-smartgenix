@extends('layouts.app')

@section('content')
    <div class="container page-container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center p-1">
                        {{-- <a href="{{ route('mots.index') }}" class="float-left fs-30 pl-2 text-primary"><i
                                class="bi bi-arrow-left-short"></i></a> --}}
                        <h4 class="pt-2">{{ trans('general.update', ['type' => 'MOT']) }}</h4>
                    </div>
                    <div class="card-body">
                        @include('partials.message')

                        <form action="{{ route('mots.update', $mot) }}" method="POST">
                            @csrf
                            @method('put')

                            <div class="form-row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date">{{ trans('general.date_of', ['service' => 'MOT']) }}</label>
                                        <input id="date"
                                            class="form-control form-control-sm @error('date') is-invalid @enderror"
                                            type="date" name="date" value="{{ $mot->datetime->format('Y-m-d') }}"
                                            required>
                                        @error('date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="time">{{ trans('general.time_of', ['service' => 'MOT']) }}</label>
                                        {{-- <input id="time"
                                            class="form-control form-control-sm @error('time') is-invalid @enderror"
                                            type="time" name="time" value="{{ $mot->datetime->format('H:i') }}"
                                            required> --}}
                                        <select name="time" id="time"
                                            class="form-control form-control-sm @error('time') is-invalid @enderror">
                                            @foreach (hours() as $time)
                                                <option {{ $time === $mot->datetime->format('H:i') ? 'selected' : '' }}
                                                    value="{{ $time }}">{{ $time }}</option>
                                            @endforeach
                                        </select>
                                        @error('time')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
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
