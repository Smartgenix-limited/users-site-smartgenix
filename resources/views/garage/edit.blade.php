@extends('layouts.app')

@section('content')
    <div class="container page-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center p-1">
                        {{-- <a href="{{ route('garage.index') }}" class="float-left fs-30 pl-2 text-primary"><i
                                class="bi bi-arrow-left-short"></i></a> --}}
                        <h4 class="pt-2">{{ trans('general.update', ['type' => 'Car']) }}</h4>
                    </div>
                    <div class="card-body">
                        @include('partials.message')
                        <form action="{{ route('garage.update', $garage) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for="car_name">{{ trans('general.name') }}</label>
                                <input id="car_name"
                                    class="form-control form-control-sm @error('car_name') is-invalid @enderror"
                                    type="text" name="car_name" value="{{ $garage->car_name }}">
                                @error('make')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="model">{{ trans('car.model') }}</label>
                                <input id="model"
                                    class="form-control form-control-sm @error('model') is-invalid @enderror" type="text"
                                    name="model" value="{{ $garage->model }}">
                                @error('model')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="year">{{ trans('car.year') }}</label>
                                <input id="year"
                                    class="form-control form-control-sm @error('year') is-invalid @enderror" type="number"
                                    name="year" value="{{ $garage->year }}">
                                @error('year')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="colour">{{ trans('car.colour') }}</label>
                                <input id="colour"
                                    class="form-control form-control-sm @error('colour') is-invalid @enderror"
                                    type="text" name="colour" value="{{ $garage->colour }}">
                                @error('colour')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="reg">{{ trans('car.registration') }}</label>
                                <input id="reg"
                                    class="form-control form-control-sm @error('reg') is-invalid @enderror" type="text"
                                    name="reg" value="{{ $garage->reg }}">
                                @error('reg')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="mileage">{{ trans('car.mileage') }}</label>
                                <input id="mileage"
                                    class="form-control form-control-sm @error('mileage') is-invalid @enderror"
                                    type="number" name="mileage" value="{{ $garage->mileage }}">
                                @error('mileage')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            @if (garage()?->is_mot && is_uk())
                                <div class="form-group">
                                    <label for="last_mot_date">{{ trans('car.last_mot') }}</label>
                                    <input id="last_mot_date"
                                        class="form-control form-control-sm @error('last_mot_date') is-invalid @enderror"
                                        type="date" name="last_mot_date"
                                        value="{{ $garage->last_mot_date->format('Y-m-d') }}"
                                        max="{{ now()->format('Y-m-d') }}">
                                    @error('last_mot_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="last_service_date">{{ trans('car.last_service') }}</label>
                                <input id="last_service_date"
                                    class="form-control form-control-sm @error('last_service_date') is-invalid @enderror"
                                    type="date" name="last_service_date"
                                    value="{{ $garage->last_service_date->format('Y-m-d') }}"
                                    max="{{ now()->format('Y-m-d') }}">
                                @error('last_service_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            @livewire('car-image', ['photo' => $garage->image])

                            <button type="submit"
                                class="btn btn-primary">{{ trans('general.update', ['type' => '']) }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
