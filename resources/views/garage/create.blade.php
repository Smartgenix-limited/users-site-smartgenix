@extends('layouts.app')

@section('content')
    <div class="container page-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center p-1">
                        {{-- <a href="{{ route('garage.index') }}" class="float-left fs-30 pl-2 text-primary"><i
                                class="bi bi-arrow-left-short"></i></a> --}}
                        <h4 class="pt-2">{{ trans('car.add_car') }}</h4>
                    </div>
                    <div class="card-body">
                        @include('partials.message')
                        @include('partials.errors')
                        <form id="form" action="{{ route('garage.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            {{-- <div class="form-group">
                                <label for="car_name">{{ trans('car.car_name') }}</label>
                                <input id="car_name"
                                    class="form-control form-control-sm @error('car_name') is-invalid @enderror"
                                    type="text" name="car_name" value="{{ old('car_name') }}">
                                @error('car_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="model">{{ trans('car.model') }}</label>
                                <input id="model"
                                    class="form-control form-control-sm @error('model') is-invalid @enderror" type="text"
                                    name="model" value="{{ old('model') }}">
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
                                    name="year" value="{{ old('year') }}">
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
                                    type="text" name="colour" value="{{ old('colour') }}">
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
                                    name="reg" value="{{ old('reg') }}">
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
                                    type="number" name="mileage" value="{{ old('mileage') }}">
                                @error('mileage')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="last_mot_date">{{ trans('car.last_mot') }}</label>
                                <input id="last_mot_date"
                                    class="form-control form-control-sm @error('last_mot_date') is-invalid @enderror"
                                    type="date" name="last_mot_date" value="{{ old('last_mot_date') }}"
                                    max="{{ now()->format('Y-m-d') }}">
                                @error('last_mot_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="last_service_date">{{ trans('car.last_service') }}</label>
                                <input id="last_service_date"
                                    class="form-control form-control-sm @error('last_service_date') is-invalid @enderror"
                                    type="date" name="last_service_date" value="{{ old('last_service_date') }}"
                                    max="{{ now()->format('Y-m-d') }}">
                                @error('last_service_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> --}}
                            {{-- @livewire('car-image') --}}

                            @livewire('add-car')

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        window.addEventListener('validatedGarage', event => {
            if (event.detail.validated) {
                $('#form').submit();
            }
        });
    </script>
@endpush
