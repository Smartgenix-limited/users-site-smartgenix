@extends('layouts.app')

@section('content')
    <div class="container page-container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center p-1">
                        {{-- <a href="{{ route('dashboard') }}" class="float-left fs-30 pl-2 text-primary"><i
                                class="bi bi-arrow-left-short"></i></a> --}}
                        <h4 class="pt-2">{{ trans('general.create_service', ['service' => 'Service']) }}</h4>
                    </div>
                    <div class="card-body">
                        @include('partials.message')
                        {{-- @include('partials.errors') --}}
                        @if (is_subscription())
                            <div class="alert alert-success">
                                {{ trans('general.you_left_resourses', ['resourses' => subscription()?->services, 'type' => 'services']) }}
                            </div>
                        @endif
                        <form id="form" action="{{ route('services.store') }}" method="POST">
                            @csrf
                            @livewire('select-car', ['type' => 'service'])

                            <!-- service type -->
                            <div class="row align-items-center mb-3">
                                <div class="col-12 col-sm-4 mb-2 mb-sm-0">
                                    <h5 class="m-0 p-0">{{ trans('general.service_type') }}</h5>
                                </div>
                                <div class="col-12 col-sm-8">
                                    <!-- payment type -->
                                    <div class="d-flex flex-wrap">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input class="custom-control-input" type="radio" name="type_of_service"
                                                id="interm" value="interm" checked>
                                            <label class="custom-control-label"
                                                for="interm">{{ trans('general.interm') }}</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input class="custom-control-input" type="radio" name="type_of_service"
                                                id="full" value="full">
                                            <label class="custom-control-label"
                                                for="full">{{ trans('general.full') }}</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input class="custom-control-input" type="radio" name="type_of_service"
                                                id="major" value="major">
                                            <label class="custom-control-label"
                                                for="major">{{ trans('general.major') }}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-8 d-flex flex-row-reverse mt-2">
                                    <span class="text-genix cursor-pointer" data-toggle="modal"
                                        data-target="#serviceModal">{{ trans('general.what_are_services') }}</span>
                                    {{-- <a href="{{ route('services.information') }}" class="text-genix text-decoration-none"
                                        target="_blank">{{ trans('general.what_are_services') }}</a> --}}
                                </div>

                            </div>

                            <div class="form-row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label
                                            for="bookDate">{{ trans('general.date_of', ['service' => 'Service']) }}</label>
                                        <input id="bookDate"
                                            class="form-control form-control-sm @error('date') is-invalid @enderror"
                                            type="date" name="date" value="{{ old('date') }}"
                                            min="{{ now()->addDay()->format('Y-m-d') }}" onchange="checkStatus()" required>
                                        @error('date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label
                                            for="bookTime">{{ trans('general.time_of', ['service' => 'Service']) }}</label>
                                        <select name="time" id="bookTime"
                                            class="form-control form-control-sm @error('time') is-invalid @enderror"
                                            onchange="checkStatus()" required>
                                            <option value="">{{ trans('general.select_time') }}</option>
                                            @foreach (hours() as $time)
                                                <option @selected(old('time') === $time) value="{{ $time }}">
                                                    {{ $time }}</option>
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
                            <!-- payment -->
                            @if (!can_service())
                                @include('partials.payment_script', ['type' => 'service'])
                            @endif
                            <!-- payment end -->

                            <div id="submitBtn" class="text-center mt-4 @if (!can_service()) d-none @endif">
                                <button type="submit" id="subBtn" class="btn btn-primary"
                                    {{ can_service() ? 'disabled' : '' }}>{{ trans('general.book', ['service' => 'Service']) }}</button>
                            </div>

                        </form>

                        {{-- service instruction model --}}
                        <div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel"
                            aria-hidden="true" style="top:-50px;">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header p-2">
                                        <h4 class="modal-title" id="serviceModalLabel">{{ __('services.service_info') }}
                                        </h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                            style="margin-top: -85px; margin-right:-35px;">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h3>{{ __('services.how_often_far') }}</h3>
                                        <p>{{ __('services.recommended_time') }}
                                            <span class="text-danger fw-semibold">{{ __('services.every_miles') }}</span>
                                            {{ __('services.or_every') }} <span
                                                class="text-danger fw-semibold">{{ __('services.12_month') }}</span>
                                            {{ __('services.come_sooner') }}
                                        </p>
                                        <p> {{ __('services.more_general') }}</p>
                                        <div class="table-responsive mb-2">
                                            <table class="table table-sm table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" style="width: 30%">
                                                            {{ __('services.service_type') }}</th>
                                                        <th scope="col">{{ __('services.service_interval') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 30%">{{ __('services.interm_service') }}</td>
                                                        <td>{{ __('services.interm_interval') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 30%">{{ __('services.full_service') }}</td>
                                                        <td>{{ __('services.full_interval') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 30%">{{ __('services.major_service') }}</td>
                                                        <td>{{ __('services.major_interval') }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <p>{{ __('services.regular_service_do') }}
                                        </p>
                                        <p>{{ __('services.regular_service_extra_do') }}</p>
                                        <h3>{{ __('services.what_include') }}</h3>
                                        <p class="fw-semibold">{{ __('services.what_we_do') }}</p>
                                        <p>{{ __('services.we_arrange') }} </p>
                                        <p>{{ __('services.service_carried_out') }}</p>
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered">
                                                <thead>
                                                    @php
                                                        $currency = support_setting('currency_symbol');
                                                    @endphp
                                                    <tr class="text-center">
                                                        <th scope="col" colspan="3">
                                                            {{ __('services.service_table') }}</th>
                                                    </tr>
                                                    <tr>
                                                        <th scope="col">{{ __('services.interim') }}</th>
                                                        <th scope="col">{{ __('services.full') }}</th>
                                                        <th scope="col">{{ __('services.major') }}</th>
                                                    </tr>
                                                    <tr>
                                                        <th scope="col">
                                                            {{ $currency }}{{ setting('interm_service') }}</th>
                                                        <th scope="col">
                                                            {{ $currency }}{{ setting('full_service') }}</th>
                                                        <th scope="col">
                                                            {{ $currency }}{{ setting('major_service') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{ __('services.check_guage') }}
                                                        </td>
                                                        <td>{{ __('services.check_guage') }}
                                                        </td>
                                                        <th>{{ __('services.full_recommended') }}</th>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('services.check_horn') }}</td>
                                                        <td>{{ __('services.check_horn') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('services.check_windscreen') }}</td>
                                                        <td>{{ __('services.check_windscreen') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('services.check_eolys') }}</td>
                                                        <td>{{ __('services.check_eolys') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('services.check_interior') }}</td>
                                                        <td>{{ __('services.check_interior') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('services.check_clutch') }}</td>
                                                        <td>{{ __('services.check_clutch') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('services.check_seat') }}</td>
                                                        <td>{{ __('services.check_seat') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('services.reset_service_light') }}</td>
                                                        <td>{{ __('services.reset_service_light') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('services.check_climate') }}
                                                        </td>
                                                        <td>{{ __('services.check_climate') }}
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('services.check_engine') }}</td>
                                                        <td>{{ __('services.') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('services.check_system') }}</td>
                                                        <td>{{ __('services.check_system') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('services.check_exterior') }}</td>
                                                        <td>{{ __('services.check_exterior') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('services.check_door') }}</td>
                                                        <td>{{ __('services.') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('services.check_boot') }}</td>
                                                        <td>{{ __('services.check_boot') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('services.check_fuel_cap') }}
                                                        </td>
                                                        <td>{{ __('services.check_fuel_cap') }}
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('services.check_steering') }}</td>
                                                        <td>{{ __('services.check_mirrors') }}
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('services.check_suspension') }}</td>
                                                        <td>{{ __('services.check_warning_lights') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('services.check_tyer') }} </td>
                                                        <td>{{ __('services.check_interior_lights') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('services.check_tpms') }}</td>
                                                        <td>{{ __('services.check_clutch_operation') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('services.check_battery') }} </td>
                                                        <td>{{ __('services.check_sealt_belts') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('services.check_bettery_wirirng') }}</td>
                                                        <td>{{ __('services.check_service_light') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('services.check_electrics') }}</td>
                                                        <td>{{ __('services.check_climate_control') }}
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('services.full_coolant_level') }}</td>
                                                        <td>{{ __('services.check_engine') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('services.check_inverter_coolant') }}</td>
                                                        <td>{{ __('services.check_system') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('services.check_inspection_high') }}</td>
                                                        <td>{{ __('services.check_exterior') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('services.check_brake_fluid') }}</td>
                                                        <td>{{ __('services.check_door') }}
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('services.full_bonnet_catch') }}</td>
                                                        <td>{{ __('services.check_boot') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('services.check_brake_piper_hoses') }}</td>
                                                        <td>{{ __('services.check_fuel_cap') }}
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('services.check_visual_brake') }}</td>
                                                        <td>{{ __('services.check_mirrors') }}
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('services.check_replace_engine_oil') }}</td>
                                                        <td>{{ __('services.check_steering') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('services.check_top_up') }}</td>
                                                        <td>{{ __('services.check_suspension') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('services.check_veicle_road') }}</td>
                                                        <td>{{ __('services.full_tyre_inspection') }} </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('services.check_stamp_book') }}</td>
                                                        <td>{{ __('services.check_tpms') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ __('services.check_battery') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ __('services.check_bettery_wiring') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ __('services.check_electrics') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ __('services.check_inverter_coolant') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ __('services.check_inspection_high') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ __('services.check_brake_fluid') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ __('services.check_bonnets') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ __('services.check_brake_piper_hoses') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ __('services.check_power_stearing') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ __('services.check_auxiliary') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ __('services.check_radiator') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ __('services.check_visual_brake') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ __('services.check_full_brake') }} </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ __('services.check_fuel_pipes') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ __('services.check_transmission_axle') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ __('services.check_drive_shaft') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ __('services.check_exhaust_system') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ __('services.check_replace_engine_oil') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ __('services.check_top_up') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ __('services.check_replace_air') }}</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ __('services.check_veicle_road') }} </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ __('services.check_stamp_book') }}</td>
                                                        <td></td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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
        function checkStatus() {
            if ($('#bookDate').val() && $('#bookTime').val()) {
                if ("{{ can_service() }}" == 1) {
                    $('#subBtn').removeAttr('disabled');
                } else {
                    $('#showPayment').removeAttr('disabled');
                }
            } else {
                let attr = $('#showPayment').attr('disabled');
                if (typeof attr === 'undefined' || attr === false || attr === 'undefined') {
                    $('#showPayment').attr("disabled", 'disabled')
                }
            }
        }
    </script>
@endpush
