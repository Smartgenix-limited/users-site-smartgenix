@extends('layouts.app')

@section('content')
    <div class="container page-container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @include('partials.card-header', ['title' => $package->name])
                    <div class="card-body">

                        <div class="row text-center">
                            @if ($package->mots != 0)
                                <div class="col-md-6 fw-semibold mb-3">{{ trans('membership.mot_numbers') }}:</div>
                                <div class="col-md-6 mb-3">{{ $package->mots }}</div>
                            @endif

                            @if ($package->services != 0)
                                <div class="col-md-6 fw-semibold mb-3">{{ trans('membership.servvice_numbers') }}:</div>
                                <div class="col-md-6 mb-3">{{ $package->services }}</div>
                            @endif

                            @if ($package->repairs != 0)
                                <div class="col-md-6 fw-semibold mb-3">{{ trans('membership.repair_numbers') }}:</div>
                                <div class="col-md-6 mb-3">{{ $package->repairs }}</div>
                            @endif

                            @if ($package->recoveries != 0)
                                <div class="col-md-6 fw-semibold mb-3">{{ trans('membership.recovery_numbers') }}:</div>
                                <div class="col-md-6 mb-3">{{ $package->recoveries }}</div>
                            @endif

                            @if ($package->features)
                                <div class="col-12 fw-semibold mb-3">
                                    {{ trans('membership.extra_features') }}
                                </div>
                                @foreach ($package->features as $feature)
                                    <div class="col-md-6 fw-semibold mb-3">{{ $feature['feature'] }}:</div>
                                    <div class="col-md-6 mb-3">{{ $feature['value'] }}</div>
                                @endforeach
                            @endif

                            <div class="col-md-6 fw-semibold mb-3">
                                {{ trans('membership.price') }}:</div>
                            <div class="col-md-6 mb-3">
                                {{ support_setting('currency_symbol') . $package->price . ' (' . trans('membership.p/y') . ')' }}
                            </div>

                            <div id="signDiv" class="col-12 text-center mt-2">
                                <button id="signup" class="btn btn-genix">{{ trans('membership.sign_up') }}</button>
                            </div>

                            <div id="paymentDiv" class="col-12 text-left d-none mt-2">
                                <form action="{{ route('memberships.store') }}" method="POST" class="text-center">
                                    @csrf
                                    @include('partials.payment_script2', [
                                        'cash' => false,
                                        'is_disable' => false,
                                        'price' => $package->price,
                                    ])
                                    <input type="hidden" name="membership_id" value="{{ $package->id }}">

                                    <button id="submitBtn" type="submit" class="btn btn-genix"
                                        disabled>{{ trans('membership.subscribe') }}</button>
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
        $('#signup').on('click', function() {
            $('#signDiv').addClass('d-none');
            $('#paymentDiv').removeClass('d-none');
        })
    </script>
@endpush
