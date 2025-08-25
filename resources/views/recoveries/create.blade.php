@extends('layouts.app')

@section('content')
    <div class="container page-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @include('partials.card-header', ['title' => 'Create Recovery'])
                    <div class="card-body">
                        @include('partials.message')

                        <form id="form" action="{{ route('recoveries.store') }}" method="POST">
                            @csrf
                            @livewire('select-car', ['type' => 'repair'])

                            <input type="hidden" name="latitude">
                            <input type="hidden" name="longitude">

                            <div class="form-group">
                                <label for="description">{{ __('recoveries.description') }}</label>
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description"
                                    rows="3" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="center-between mb-1">
                                    <label for="location">{{ __('recoveries.location') }}</label>
                                    <button type="button" id="locationBtn" class="btn btn-xs btn-genix"
                                        onclick="sendLocation()">{{ __('recoveries.send_location') }}</button>
                                </div>
                                @livewire('recovery-location')

                                @error('location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="alert alert-success mt-1 d-none" id="locationSuccess"></div>
                                <div class="alert alert-danger mt-1 d-none" id="locationError"></div>
                            </div>

                            <div class="form-group">
                                <label for="nearby_places">{{ __('recoveries.instructions') }}</label>
                                <textarea id="nearby_places" class="form-control @error('nearby_places') is-invalid @enderror" name="nearby_places"
                                    rows="3" required>{{ old('nearby_places') }}</textarea>
                                @error('nearby_places')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="location" class="d-block">{{ __('recoveries.to') }}</label>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    @foreach ($data['types'] as $type)
                                        <label class="btn custom-btn btn-sm btn-outline-genix shadow-none text-capitalize">
                                            <input type="radio" name="type" id="{{ $type }}"
                                                value="{{ $type }}" @checked(old('type') === $type) required>
                                            {{ $type }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div id="otherdiv" class="form-group @if (old('type') !== 'other') d-none @endif">
                                <label for="other">{{ __('recoveries.other') }}</label>
                                <input id="other" class="form-control @error('other') is-invalid @enderror"
                                    type="text" name="other" value="{{ old('other') }}">
                                @error('other')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="d-flex">
                                    <label for="location" class="d-block">{{ __('recoveries.assistance') }}</label>
                                    <span class="cursor-pointer fs-18 pl-3" data-toggle="modal" data-target="#roadModel">
                                        <i class="bi bi-info-circle"></i>
                                    </span>
                                </div>

                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    @foreach ($data['assistance'] as $value)
                                        <label class="btn custom-btn btn-sm btn-outline-genix shadow-none text-capitalize">
                                            <input type="radio" name="roadside_assistance" id="{{ $value }}"
                                                value="{{ $value }}" @checked(old('roadside_assistance') === $value) required>
                                            {{ $value }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="location" class="d-block">{{ __('recoveries.payment') }}</label>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    @foreach ($data['payments'] as $payment)
                                        <label class="btn custom-btn btn-sm btn-outline-genix shadow-none text-capitalize">
                                            <input type="radio" name="payment_type" id="{{ $payment }}"
                                                value="{{ $payment }}" @checked(old('payment_type') === $payment) required>
                                            {{ $payment }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div id="submitBtn" class="text-center mt-4">
                                <button type="submit" id="subBtn"
                                    class="btn btn-primary">{{ __('general.submit') }}</button>
                            </div>
                        </form>

                        <!-- Modal -->
                        <div class="modal fade" id="roadModel" tabindex="-1" aria-labelledby="roadModelLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header px-3 py-2">
                                        <h5 class="modal-title text-capitalize" id="roadModelLabel">
                                            {{ __('recoveries.assistance') }}
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                            style="margin-top: -85px; margin-right:-35px;">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body py-2 px-3">
                                        <p>{{ trans('recoveries.road_assistance_message') }}</p>
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
        $("[name='type']").on('change', function(e) {
            if (e.target.value === 'other') {
                $('#otherdiv').removeClass('d-none');
            } else {
                $('#otherdiv').addClass('d-none');
            }
        })

        // send location
        function sendLocation() {
            $('#locationBtn').prop("disabled", true);
            $('#locationSuccess').addClass('d-none');
            $('#locationError').addClass('d-none');
            window.navigator.geolocation.getCurrentPosition(
                (position) => {
                    $("input[name='latitude']").val(position.coords.latitude);
                    $("input[name='longitude']").val(position.coords.longitude);
                    Livewire.emit('fetchLocation', position.coords.latitude, position.coords.longitude);
                },
                (error) => {
                    $('#locationBtn').prop("disabled", false);
                    $('#locationError').removeClass('d-none');
                    $('#locationError').html(error.message);
                }
            );
        }

        window.addEventListener('locationSuccess', event => {
            $('#locationSuccess').removeClass('d-none').text(event.detail.message);
            $('#locationBtn').prop("disabled", false);
        })

        window.addEventListener('locationError', event => {
            $('#locationError').removeClass('d-none');
            $('#locationError').html(event.detail.error);
        })
    </script>
@endpush
