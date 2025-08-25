@extends('layouts.app')

@section('content')
    <div class="container page-container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                @livewire('service-notices')
                <h3>{{ trans('general.hello') }} {{ auth()->user()->name }}</h3>
                <hr />
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                {{-- what you want to do start --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <span class="h4">{{ trans('general.like_to_do') }}</span>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="row">
                                    @if (garage()?->is_mot && is_uk())
                                        <div class="col-md-6 col-lg-4 mb-2">
                                            <div class="card bg-orange shadow text-black rounded-0 d-card">
                                                <a href="{{ route('mots.create') }}"
                                                    class="text-black text-decoration-none">
                                                    <div class="card-body text-center">
                                                        <span class="d-block fs-18"><i
                                                                class="bi bi-cone-striped"></i></span>
                                                        {!! trans('general.book_a_mot') !!}
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endif

                                    @if (garage()?->is_services)
                                        <div class="col-md-6 col-lg-4 mb-2">
                                            <div class="card bg-white shadow text-black rounded-0 d-card">
                                                <a href="{{ route('services.create') }}"
                                                    class="text-black text-decoration-none">
                                                    <div class="card-body text-center">
                                                        <span class="d-block fs-18"><i class="bi bi-gear"></i></span>
                                                        {!! trans('general.book_service') !!}
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endif

                                    @if (garage()?->is_repairs)
                                        <div class="col-md-6 col-lg-4 mb-2">
                                            <div class="card bg-genix shadow text-white rounded-0 d-card">
                                                <a href="{{ route('repairs.create') }}"
                                                    class="text-white text-decoration-none ">
                                                    <div class="card-body text-center">
                                                        <span class="d-block fs-18"><i class="bi bi-car-front"></i></span>
                                                        {!! trans('general.book_a_repair') !!}
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-md-6 col-lg-4 mb-2">
                                        <div class="card bg-orange shadow text-black rounded-0 d-card">
                                            <a href="{{ route('recoveries.create') }}"
                                                class="text-black text-decoration-none">
                                                <div class="card-body text-center">
                                                    <span class="d-block fs-18"><i class="bi bi-cone-striped"></i></span>
                                                    {{ trans('general.recovery') }}
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-lg-4 mb-2">
                                        <div class="card bg-white shadow text-black rounded-0 d-card">
                                            <a href="{{ route('marketplace.index') }}"
                                                class="text-black text-decoration-none">
                                                <div class="card-body text-center">
                                                    <span class="d-block fs-18"><i class="bi bi-shop"></i></span>
                                                    {{ trans('general.marketplace') }}
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-2">
                                        <div class="card bg-genix shadow text-white rounded-0 d-card">
                                            <a href="{{ route('communities.index') }}"
                                                class="text-white text-decoration-none ">
                                                <div class="card-body text-center">
                                                    <span class="d-block fs-18"><i
                                                            class="bi bi-chat-square-text"></i></span>
                                                    {{ trans('general.community') }}
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                {{-- what you want to do end --}}

                {{-- pending quote start --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <span class="h4">{{ trans('general.your_quotes') }}</span>
                    </div>
                    {{-- text-black-original --}}
                    <div class="card-body w-100">
                        <div class="d-flex scroll-section">
                            @if (count($data['quotes']) == 0 && count($data['recoveries_quotes']) == 0)
                                <span class="ml-3">{{ trans('general.no_quote') }}</span>
                            @else
                                @foreach ($data['quotes'] as $quote)
                                    <div class="col-md-3 mb-2">
                                        @if ($quote->job_approval === 'requested')
                                            <div class="card bg-orange shadow text-black d-flex h-100">
                                                <a href="{{ route('repairs.show', $quote) }}"
                                                    class="text-decoration-none text-black">
                                                    <div class="card-body text-center rounded quote">
                                                        <i class="bi bi-send"></i>
                                                        <span class="d-block">
                                                            {!! trans('general.repair_quote_send') !!}
                                                        </span>
                                                    </div>
                                                </a>
                                            </div>
                                        @else
                                            <div class="card bg-white shadow text-black d-flex h-100">
                                                <a href="{{ route('repairs.show', $quote) }}"
                                                    class="text-decoration-none text-black">
                                                    <div class="card-body text-center rounded quote">
                                                        <i class="bi bi-check2-all"></i>
                                                        <span class="d-block">
                                                            {!! $quote->job_approval === 'pending' ? trans('general.approve_repair_quote') : trans('general.quote_approved') !!}
                                                        </span>
                                                    </div>
                                                </a>
                                            </div>
                                        @endif

                                    </div>
                                @endforeach

                                @foreach ($data['recoveries_quotes'] as $recovery)
                                    <div class="col-md-3 mb-2">
                                        @if ($recovery->quotes_count == 0)
                                            <div class="card bg-orange shadow text-black d-flex h-100">
                                                <a href="{{ route('recoveries.show', $recovery) }}"
                                                    class="text-decoration-none text-black">
                                                    <div class="card-body text-center rounded quote">
                                                        <i class="bi bi-send"></i>
                                                        <span class="d-block">
                                                            {!! trans('general.recovery_quote') !!}
                                                        </span>
                                                    </div>
                                                </a>
                                            </div>
                                        @else
                                            <div class="card bg-white shadow text-black d-flex h-100">
                                                <a href="{{ route('recoveries.show', $recovery) }}"
                                                    class="text-decoration-none text-black">
                                                    <div class="card-body text-center rounded quote">
                                                        <i class="bi bi-check2-all"></i>
                                                        <span class="d-block">
                                                            {!! trans('general.approve_recovery_quote') !!}
                                                        </span>
                                                    </div>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>
                {{-- pending quote end --}}

                {{-- upcomming mot appointment start --}}
                @if (garage()?->is_mot && is_uk())
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span class="h4 m-0 p-0">{{ trans('general.upcomming_mot_appointments') }}</span>
                            <a href="{{ route('mots.index') }}" class="float-left fs-25 text-primary"><i
                                    class="bi bi-arrow-right-short"></i></a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @forelse ($data['mots'] as $mot)
                                    <div class="col-md-4 mb-2">
                                        <div class="card bg-orange d-flex h-100">
                                            <a href="{{ route('mots.show', $mot) }}"
                                                class="text-decoration-none text-black">
                                                <div class="card-body text-center rounded">
                                                    <div class="d-flex justify-content-between">
                                                        <span class="h5">{{ trans('general.car') }}:</span>
                                                        <span>{{ $mot->car->car_name }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span class="h5">{{ trans('general.reg') }}:</span>
                                                        <span>{{ $mot->car->reg }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span class="h5">{{ trans('general.date') }}:</span>
                                                        <span>{{ $mot->datetime->format('d/m/Y') }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span class="h5">{{ trans('general.time') }}:</span>
                                                        <span>{{ $mot->datetime->format('H:i A') }}</span>
                                                    </div>
                                                </div>
                                            </a>

                                        </div>
                                    </div>
                                @empty
                                    <span class="ml-3">{{ trans('general.no_mot') }}</span>
                                @endforelse
                                @if ($data['mots_count'] > 3)
                                    <div class="col-12 text-center mt-2">
                                        <a href="{{ route('mots.index') }}"
                                            class="btn btn-sm btn-orange">{{ trans('general.view_more') }}</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
                {{-- upcomming mot appointment end --}}

                {{-- upcomming service start --}}
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="h4 m-0 p-0">{{ trans('general.upcomming_service_appointments') }}</span>
                        <a href="{{ route('services.index') }}" class="float-left fs-25 text-primary"><i
                                class="bi bi-arrow-right-short"></i></a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @forelse ($data['services'] as $service)
                                <div class="col-md-4 mb-2">
                                    <div class="card d-flex h-100">
                                        <a href="{{ route('services.show', $service) }}"
                                            class="text-decoration-none text-black-original">
                                            <div class="card-body text-center border rounded">
                                                <div class="d-flex justify-content-between">
                                                    <span class="h5">{{ trans('general.car') }}:</span>
                                                    <span>{{ $service->car->car_name }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span class="h5">{{ trans('general.reg') }}:</span>
                                                    <span>{{ $service->car->reg }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span class="h5">{{ trans('general.date') }}:</span>
                                                    <span>{{ $service->datetime->format('d/m/Y') }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span class="h5">{{ trans('general.time') }}:</span>
                                                    <span>{{ $service->datetime->format('H:i A') }}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <span class="ml-3">{{ trans('general.no_service') }}</span>
                            @endforelse
                            @if ($data['services_count'] > 3)
                                <div class="col-12 text-center mt-2">
                                    <a href="{{ route('services.index') }}"
                                        class="btn btn-sm btn-genix">{{ trans('general.view_more') }}</a>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
                {{-- upcomming service end --}}

                {{-- upcomming repair start --}}
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="h4 m-0 p-0">{{ trans('general.upcomming_repair_appointments') }}</span>
                        <a href="{{ route('repairs.index') }}" class="float-left fs-25 text-primary"><i
                                class="bi bi-arrow-right-short"></i></a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @forelse ($data['repairs'] as $repair)
                                <div class="col-md-4 mb-2">
                                    <div class="card bg-genix d-flex h-100">
                                        <a href="{{ route('repairs.show', $repair) }}"
                                            class="text-decoration-none text-white">
                                            <div class="card-body text-center rounded">
                                                <div class="d-flex justify-content-between">
                                                    <span class="h5">{{ trans('general.car') }}:</span>
                                                    <span>{{ $repair->car->car_name }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span class="h5">{{ trans('general.reg') }}:</span>
                                                    <span>{{ $repair->car->reg }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span class="h5">{{ trans('general.date') }}:</span>
                                                    <span>{{ $repair->datetime->format('d/m/Y') }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span class="h5">{{ trans('general.time') }}:</span>
                                                    <span>{{ $repair->datetime->format('H:i A') }}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <span class="ml-3">{{ trans('general.no_repair') }}</span>
                            @endforelse
                            @if ($data['repairs_count'] > 3)
                                <div class="col-12 text-center mt-2">
                                    <a href="{{ route('repairs.index') }}"
                                        class="btn btn-sm btn-genix">{{ trans('general.view_more') }}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                {{-- upcomming repair end --}}

                {{-- recoveries start --}}
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="h4 m-0 p-0">{{ trans('general.recovery_appointments') }}</span>
                        <a href="{{ route('recoveries.index') }}" class="float-left fs-25 text-primary"><i
                                class="bi bi-arrow-right-short"></i></a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @forelse ($data['recoveries'] as $recovery)
                                <div class="col-md-4 mb-2">
                                    <div class="card bg-genix d-flex h-100">
                                        <a href="{{ route('recoveries.show', $recovery) }}"
                                            class="text-decoration-none text-white">
                                            <div class="card-body text-center rounded">
                                                <div class="d-flex justify-content-between">
                                                    <span class="h5">{{ trans('general.car') }}:</span>
                                                    <span>{{ $recovery->car->car_name }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span class="h5">{{ trans('general.reg') }}:</span>
                                                    <span>{{ $recovery->car->reg }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span class="h5">{{ trans('general.status') }}:</span>
                                                    <span
                                                        class="text-capitalize">{{ $recovery->completer_count > 0 ? trans('general.started') : ($recovery->quotes_count > 0 ? trans('general.review') : $recovery->status) }}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <span class="ml-3">{{ trans('general.no_recovery') }}</span>
                            @endforelse
                            @if ($data['recoveries_count'] > 3)
                                <div class="col-12 text-center mt-2">
                                    <a href="{{ route('recoveries.index') }}"
                                        class="btn btn-sm btn-genix">{{ trans('general.view_more') }}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                {{-- recoveries end --}}
            </div>
        </div>

    </div>
@endsection
