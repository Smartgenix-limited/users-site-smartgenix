@extends('layouts.app')

@section('content')
    <div class="container page-container">

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center p-1">
                        {{-- <a href="{{ route('services.index') }}" class="float-left fs-30 pl-2 text-primary"><i
                                class="bi bi-arrow-left-short"></i></a> --}}
                        @php
                            $garage = garage();
                        @endphp
                        <h4 class="pt-2">{{ $garage->name }}</h4>
                    </div>
                    <div class="card-body">
                        <p class="fw-semibold">{{ trans('general.success_detail', ['type' => 'Service']) }}</p>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="h5">{{ trans('general.date_of', ['service' => 'Service']) }}:</span>
                            <span class="h5">{{ $service->datetime->format('d/m/Y') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="h5">{{ trans('general.time_of', ['service' => 'Service']) }}:</span>
                            <span class="h5">{{ $service->datetime->format('H:i A') }}</span>
                        </div>
                        <h5 class="text-primary mb-3">{{ trans('general.car_information') }}</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="h5">{{ trans('general.car_make') }}:</span>
                            <span class="h5">{{ $service->car->car_name }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="h5">{{ trans('general.car_model') }}:</span>
                            <span class="h5">{{ $service->car->model }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="h5">{{ trans('general.registration') }}:</span>
                            <span class="h5">{{ $service->car->reg }}</span>
                        </div>

                        <h5 class="text-primary mb-3">{{ trans('general.garage_information') }}</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="h5">{{ trans('general.name') }}:</span>
                            <span class="h5">{{ $garage->name }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="h5">{{ trans('general.address') }}:</span>
                            <span class="h5">{{ $garage->address }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="h5">{{ trans('general.telephone') }}:</span>
                            <span class="h5">{{ $garage->telephone }}</span>
                        </div>

                        <h5 class="text-primary mb-3">{{ trans('general.payment') }}</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span
                                class="h5 @if ($service->payment === 'paid') text-uppercase text-success @else text-capitalize @endif">{{ $service->payment }}</span>
                            <span class="h5 text-success">{{ trans('general.payment_total') }}:
                                {{ support_setting('currency_symbol') }}{{ $service->price }}</span>
                        </div>
                        <p class="fw-semibold">{{ trans('general.booking_confirm') }}</p>

                        @include('partials.garage')
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
