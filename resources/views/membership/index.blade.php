@extends('layouts.app')

@section('content')
    <div class="container page-container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @php
                        $currency = support_setting('currency_symbol');
                    @endphp
                    @include('partials.card-header', ['title' => trans('membership.title')])
                    <div class="card-body">
                        @include('partials.message')

                        @if (is_subscription())
                            <div class="row text-center">
                                <div class="col-12 mb-3">
                                    <h3 class="fw-semibold">{{ trans('membership.active_membership') }}
                                    </h3>
                                </div>
                                <div class="col-md-6 fw-semibold mb-3">{{ trans('membership.name') }}:</div>
                                <div class="col-md-6 mb-3">{{ request()->user()->subscription->package->name }}</div>

                                <div class="col-md-6 fw-semibold mb-3">{{ trans('membership.started_at') }}:</div>
                                <div class="col-md-6 mb-3">
                                    {{ request()->user()->subscription->created_at->format('d-m-Y') }}
                                </div>

                                <div class="col-md-6 fw-semibold mb-3">{{ trans('membership.ending_at') }}:</div>
                                <div class="col-md-6 mb-3">
                                    {{ request()->user()->subscription->expired_at->format('d-m-Y') }}
                                </div>

                                <div class="col-md-6 fw-semibold mb-3">{{ trans('membership.remaining_mots') }}:</div>
                                <div class="col-md-6 mb-3">
                                    {{ request()->user()->subscription->mots }}
                                </div>

                                <div class="col-md-6 fw-semibold mb-3">{{ trans('membership.remaining_services') }}:</div>
                                <div class="col-md-6 mb-3">
                                    {{ request()->user()->subscription->services }}
                                </div>

                                <div class="col-md-6 fw-semibold mb-3">{{ trans('membership.remaining_repairs') }}:</div>
                                <div class="col-md-6 mb-3">
                                    {{ request()->user()->subscription->repairs }}
                                </div>

                                <div class="col-md-6 fw-semibold mb-3">{{ trans('membership.remaining_recoveries') }}:
                                </div>
                                <div class="col-md-6 mb-3">
                                    {{ request()->user()->subscription->recoveries }}
                                </div>

                                @if (request()->user()->subscription->package?->features)
                                    @foreach (request()->user()->subscription->package?->features as $feature)
                                        <div class="col-md-6 fw-semibold mb-3">{{ $feature['feature'] }}:
                                        </div>
                                        <div class="col-md-6 mb-3">{{ $feature['value'] }}</div>
                                    @endforeach
                                @endif
                            </div>
                        @endif
                        <div class="col-12 @if (is_subscription()) my-3 @endif text-center">
                            <h3 class="fw-semibold">{{ trans('membership.packages') }}
                            </h3>
                        </div>
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-stripe">
                                    <thead>
                                        <tr>
                                            <th scope="col">{{ trans('membership.name') }}</th>
                                            <th scope="col">
                                                {{ trans('membership.price') . ' (' . trans('membership.p/y') . ')' }}</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($packages as $package)
                                            <tr>
                                                <td>{{ $package->name }}</td>
                                                <td>{{ $currency . $package->price }}</td>
                                                <td>
                                                    <a href="{{ route('memberships.show', $package) }}" class="text-genix">
                                                        {{-- <i class="bi bi-eye-fill"></i> --}}
                                                        {{ trans('general.view_package') }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3">{{ trans('membership.no_package') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- @endif --}}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
