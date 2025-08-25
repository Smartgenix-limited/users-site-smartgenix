@extends('layouts.app')

@section('content')
    <div class="container page-container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @include('partials.card-header', ['title' => 'Selected Garage'])
                    <div class="card-body">
                        @include('partials.message')
                        <h4 class="text-center">{{ $garage->name }}</h4>
                        <div class="row flex-column align-items-center justify-content-center mt-3">
                            <div class="col-md-8 mb-2">
                                <div class="center-between">
                                    <span class="fw-semibold">{{ trans('garage.country') }}: </span>
                                    <span class="">{{ $garage->country }}</span>
                                </div>
                            </div>
                            <div class="col-md-8 mb-2">
                                <div class="center-between">
                                    <span class="fw-semibold">{{ trans('garage.city') }}: </span>
                                    <span class="">{{ $garage->city }}</span>
                                </div>
                            </div>
                            <div class="col-md-8 mb-2">
                                <div class="center-between">
                                    <span class="fw-semibold">{{ trans('garage.address') }}: </span>
                                    <span class="">{{ $garage->address }}</span>
                                </div>
                            </div>
                            <div class="col-md-8 mb-2">
                                <div class="center-between">
                                    <span class="fw-semibold">{{ trans('garage.telephone') }}: </span>
                                    <span class="">{{ country($garage->country)?->code . $garage->telephone }}</span>
                                </div>
                            </div>
                            <div class="col-md-8 mb-2">
                                <div class="center-between">
                                    <span class="fw-semibold">{{ trans('garage.opening') }}: </span>
                                    <span class="">{{ $garage->opening->format('h:i A') }}</span>
                                </div>
                            </div>
                            <div class="col-md-8 mb-2">
                                <div class="center-between">
                                    <span class="fw-semibold">{{ trans('garage.closing') }}: </span>
                                    <span class="">{{ $garage->closing->format('h:i A') }}</span>
                                </div>
                            </div>
                            <div class="col-md-8 mb-2">
                                <div class="center-between">
                                    <span class="fw-semibold">{{ trans('garage.out_hour_response') }}</span>
                                    <span class="">{{ $garage->out_of_hour_response ? 'Yes' : 'No' }}</span>
                                </div>
                            </div>
                            @php
                                $is_sub = is_subscription();
                            @endphp
                            <div class="col-md-8 mb-2">
                                <div class="center-between">
                                    <span class="fw-semibold">{{ trans('membership.title') }}</span>
                                    <span
                                        class="{{ $is_sub ? 'text-success' : 'text-danger' }}">{{ $is_sub ? trans('membership.yes') : trans('membership.no') }}</span>
                                </div>
                            </div>
                            @if ($is_sub)
                                <div class="col-md-8 mb-2">
                                    <div class="center-between">
                                        <span class="fw-semibold">{{ trans('membership.package') }}</span>
                                        <span>{{ request()->user()->subscription->package->name }}</span>
                                    </div>
                                </div>
                                <div class="col-md-8 mb-2">
                                    <div class="center-between">
                                        <span class="fw-semibold">{{ trans('membership.price') }}</span>
                                        <span>{{ support_setting('currency_symbol') . request()->user()->subscription->package->price }}</span>
                                    </div>
                                </div>
                                <div class="col-md-8 mb-2">
                                    <div class="center-between">
                                        <span class="fw-semibold">{{ trans('membership.expiry_date') }}</span>
                                        <span>{{ request()->user()->subscription->expired_at->format('d-m-Y') }}</span>
                                    </div>
                                </div>
                            @endif

                            <div class="col-12">
                                <div class="text-center mt-3">
                                    <a href="{{ route('garage.review') }}"
                                        class="btn btn-sm btn-genix">{{ trans('garage.review_garage') }}</a>
                                    {{-- <a href="{{ route('garages.index') }}"
                                        class="btn btn-sm btn-genix mx-2">{{ trans('garage.change_garage') }}</a> --}}
                                    <button onclick="confirmChange()"
                                        class="btn btn-sm btn-genix mx-2">{{ trans('garage.change_garage') }}</button>
                                    @if (is_reported('garage', active_garage()))
                                        <button class="btn btn-sm btn-genix"
                                            disabled>{{ trans('garage.reported') }}</button>
                                    @else
                                        <button id="reportBtn"
                                            class="btn btn-sm btn-genix">{{ trans('garage.report_garage') }}</button>
                                    @endif

                                </div>
                            </div>
                            @if (is_reported('garage', active_garage()))
                                <div class="col-md-8 mt-3">
                                    <h6 class="fw-semibold">{{ trans('garage.report_reason') }}</h6>
                                    <p>{{ report_reason('garage', active_garage()) }}</p>
                                </div>
                            @endif
                            <div id="reportForm" class="col-md-8 d-none mt-3">
                                <form action="{{ route('garage.report') }}" method="POST">
                                    @csrf
                                    <div class="form-group text-left">
                                        <label for="reason">{{ trans('garage.reasons_to_report') }}</label>
                                        <textarea id="reason" class="form-control" name="reason" rows="4"
                                            placeholder="{{ trans('garage.tell_us_reason') }}" required></textarea>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-genix">{{ trans('garage.report') }}</button>
                                    </div>
                                </form>
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
        $('#reportBtn').on('click', function() {
            $('#reportForm').toggleClass('d-none')
        })

        function confirmChange() {
            if (confirm("{{ trans('garage.confirm_change') }}")) {
                window.location.href = "{{ route('garages.index') }}";
            }
        }
    </script>
@endpush
