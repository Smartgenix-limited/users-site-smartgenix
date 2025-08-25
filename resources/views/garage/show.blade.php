@extends('layouts.app')

@section('content')
    <div class="container page-container">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <h3>{{ trans('garage.car_history') }}</h3>
                <hr />
            </div>
        </div>
        {{-- car history --}}
        <div class="card mb-2">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-5 mb-2 text-center">
                        @if (is_uk())
                            <div class="row align-items-center">
                                <div class="col-sm-8">
                                    <div class="d-flex justify-content-between">
                                        <p class="h5 fw-semibold">{{ trans('garage.last_mot') }}</p>
                                        <p class="fw-semibold">{{ $garage->last_mot_date?->format('d/m/Y') }}</p>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <p class="h5 fw-semibold">{{ trans('garage.next_mot') }}</p>
                                        <p class="fw-semibold">{{ now()->diffInDays($garage->last_mot_date?->addYear()) }}
                                            {{ trans('garage.days') }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    @livewire('garage-reminder', ['car' => $garage, 'type' => 'mot'])
                                </div>
                            </div>
                        @endif
                        <div class="row align-items-center">
                            <div class="col-sm-8">
                                <div class="d-flex justify-content-between">
                                    <p class="h5 fw-semibold">{{ trans('garage.last_service') }}</p>
                                    <p class="fw-semibold">{{ $garage->last_service_date?->format('d/m/Y') }}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="h5 fw-semibold">{{ trans('garage.next_service') }}</p>
                                    <p class="fw-semibold">{{ now()->diffInDays($garage->last_service_date?->addYear()) }}
                                        {{ trans('garage.days') }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                @livewire('garage-reminder', ['car' => $garage, 'type' => 'service'])
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-2 text-center">
                        @if ($garage->image)
                            <img src="{{ $garage->image }}" alt="Car Image" class="img-circle">
                        @else
                            <span>{{ trans('garage.no_image') }}</span>
                        @endif

                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="d-flex justify-content-between">
                            <p class="h5 fw-semibold">{{ trans('garage.car') }}:</p>
                            <p class="fw-semibold">{{ $garage->car_name . ' ' . $garage->model }}</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="h5 fw-semibold">{{ trans('garage.colour') }}:</p>
                            <p class="fw-semibold">{{ $garage->colour }}</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="h5 fw-semibold">{{ trans('garage.mileage') }}:</p>
                            <p class="fw-semibold">{{ $garage->mileage }} {{ is_uk() ? 'Miles' : 'KM' }} </p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="h5 fw-semibold">{{ trans('garage.reg') }}#:</p>
                            <p class="fw-semibold">{{ $garage->reg }}</p>
                        </div>
                        @if (is_uk())
                            <div class="d-flex justify-content-between">
                                <p class="h5 fw-semibold">{{ trans('garage.tax') }}:</p>
                                <p class="fw-semibold">{{ $garage->tax_paid_at?->format('d/m/Y') }}</p>
                            </div>
                        @endif

                    </div>
                    <div class="col-md-12 text-center mt-4">
                        @if (is_uk())
                            <a href="{{ route('mots.create', ['car' => $garage]) }}"
                                class="btn btn-sm btn-primary mb-2">{{ trans('garage.hpi_check') }}</a>
                            <a href="{{ route('mots.create', ['car' => $garage]) }}"
                                class="btn btn-sm btn-primary mb-2">{{ trans('garage.book_mot') }}</a>
                        @endif
                        <a href="{{ route('services.create', ['car' => $garage]) }}"
                            class="btn btn-sm btn-primary mb-2">{{ trans('garage.book_service') }}</a>
                        <a href="{{ route('repairs.create', ['car' => $garage]) }}"
                            class="btn btn-sm btn-primary mb-2">{{ trans('garage.book_repair') }}</a>
                        <a href="{{ route('car.transfer', $garage) }}"
                            class="btn btn-sm btn-primary mb-2">{{ trans('garage.transfer_car') }}</a>
                        <a href="{{ route('car.history', $garage) }}"
                            class="btn btn-sm btn-primary mb-2">{{ trans('garage.download_history') }}</a>
                        <a href="{{ route('marketplace.create', ['car' => $garage]) }}"
                            class="btn btn-sm btn-primary mb-2">{{ trans('garage.sell_car') }}</a>
                        <button onclick="deleteCar()"
                            class="btn btn-sm btn-primary mb-2">{{ trans('garage.delete_car') }}</button>
                        <form id="delete-car" action="{{ route('garage.destroy', $garage) }}" method="POST">
                            @csrf
                            @method('delete')
                        </form>

                    </div>
                </div>
            </div>
        </div>
        {{-- car history end --}}

        {{-- mot history --}}
        @if (is_uk())
            <div class="card mb-2">
                <div class="card-body">
                    <h3 class="pb-3">{{ trans('garage.mot_history') }}</h3>
                    <div class="d-flex justify-content-center text-center">
                        <div class="">
                            <h4 class="fw-semibold">{{ trans('garage.total_test') }}</h4>
                            <h4 class="fw-semibold">{{ $data['mot_completed'] }}</h4>
                        </div>
                        <div class="mx-3">
                            <h4 class="fw-semibold">{{ trans('garage.passed') }}</h4>
                            <h4 class="fw-semibold">{{ $data['pass_mots'] }}</h4>
                        </div>
                        <div class="">
                            <h4 class="fw-semibold">{{ trans('garage.failed') }}</h4>
                            <h4 class="fw-semibold">{{ $data['fail_mots'] }}</h4>
                        </div>
                    </div>

                    @forelse ($garage->mots as $mot)
                        @php
                            $task = $mot->mot_task;
                            $status = $task ? $task->mot_status : 'pending';
                        @endphp
                        <div class="row align-items-center border-bottom py-3">
                            <div class="col-sm-6 col-md-3">
                                @if ($task)
                                    <div class="">
                                        <h5 class="fw-semibold">{{ trans('garage.date_tested') }}</h5>
                                        <h5 class="">{{ $mot->completed_at->format('j F Y') }}</h5>
                                    </div>
                                    <p
                                        class="h4 pt-2 text-uppercase fw-semibold @if ($status === 'pass') text-success @elseif($status === 'fail') text-danger @else 'text-secondary' @endif">
                                        {{ $status }}</p>
                                @else
                                    <div class="">
                                        <h5 class="fw-semibold">{{ trans('garage.date') }}</h5>
                                        <h5 class="">{{ $mot->datetime->format('d/m/Y') }}</h5>
                                    </div>
                                    <div class="">
                                        <h5 class="fw-semibold">{{ trans('garage.time') }}</h5>
                                        <h5 class="">{{ $mot->datetime->format('H:i A') }}</h5>
                                    </div>
                                @endif

                            </div>

                            <div class="col-sm-6 col-md-3">
                                <div class="">
                                    <h5 class="fw-semibold">{{ trans('garage.mileage') }}</h5>
                                    <h5 class="">{{ $mot->car->mileage }}</h5>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-3">
                                @if ($task)
                                    {{-- <div class="">
                                        <h5 class="fw-semibold">{{ trans('garage.test_number') }}</h5>
                                        <h5 class="pl-5">{{ $mot->test_number }}</h5>
                                    </div> --}}
                                    @if ($status === 'pass')
                                        <div class="">
                                            <h5 class="fw-semibold">{{ trans('garage.expiry_date') }}</h5>
                                            <h5 class="">{{ $mot->completed_at->addYear()->format('j F Y') }}</h5>
                                        </div>
                                    @endif

                                    @if ($status === 'fail')
                                        <div class="">
                                            <h5 class="fw-semibold">{{ trans('garage.major_defects') }}</h5>
                                            <h5 class="pl-5">{{ count($task->tasks) }}</h5>
                                            {{-- <div class="pl-2 text-left">
                                                @foreach ($task->majors as $reason)
                                                    <span class="d-block">{{ $loop->iteration . ': ' }}
                                                        {{ $reason }}</span>
                                                @endforeach

                                            </div> --}}
                                        </div>
                                    @endif
                                @else
                                    <div class="">
                                        <h5 class="fw-semibold">{{ trans('garage.payment') }}</h5>
                                        <h5 class="text-capitalize text-success">{{ $mot->payment }}</h5>
                                    </div>
                                    <div class="">
                                        <h5 class="fw-semibold">{{ trans('garage.status') }}</h5>
                                        <h5 class="text-capitalize">{{ $status }}</h5>
                                    </div>
                                @endif

                            </div>

                            {{-- @if ($mot->mot_task)
                            <div class="col-5">
                                @php
                                    $task = $mot->mot_task;
                                    $status = $task->mot_status;
                                @endphp
                                <p
                                    class="h4 text-uppercase fw-semibold @if ($status === 'pass') text-success @elseif($status === 'fail') text-danger @else 'text-secondary' @endif">
                                    {{ $status }}</p>
                                @if ($status === 'pass')
                                    <p class="h5">Test Number: {{ $mot->test_number }}</p>
                                @endif
                                @if ($status === 'fail')
                                    <p><span class="h5">Dangerous: </span>{{ count($task->dangerous) }}</p>
                                    <p><span class="h5">Minor: </span>{{ count($task->minors) }}</p>
                                    <p><span class="h5">Major: </span>{{ count($task->majors) }}</p>
                                    <p><span class="h5">Advisory: </span>{{ count($task->advisories) }}</p>
                                @endif

                            </div>
                        @else
                            <div class="col-5">
                                <p class="h4 text-genix">{{ trans('garage.pending') }}</p>
                            </div>
                        @endif --}}
                            <div class="col-2 text-right">
                                <a href="{{ route('mots.show', $mot) }}" class="text-decoration-none text-primary"
                                    title="{{ trans('garage.view_detail') }}"><i
                                        class="bi bi-chevron-right fs-25"></i></a>
                            </div>

                        </div>
                    @empty
                        <p>{{ trans('garage.no_mot') }}</p>
                    @endforelse

                    @if ($garage->mots->count() < $garage->mots_count)
                        <div class="text-center mt-4">
                            <a href="{{ route('mots.index', ['car' => $garage]) }}"
                                class="btn btn-sm btn-primary">{{ trans('garage.view_more') }}</a>
                        </div>
                    @endif

                </div>
            </div>
        @endif
        {{-- mot history end --}}

        {{-- service history --}}
        <div class="card mb-2">
            <div class="card-body">
                <h3 class="pb-3">{{ trans('garage.service_history') }}</h3>
                @forelse ($garage->services as $service)
                    <div class="row align-items-center">
                        <div class="col-10">
                            <div class="row">
                                <div class="col-md-6 mb-2 d-flex justify-content-between">
                                    <span class="h5">{{ trans('garage.service_type') }}:</span>
                                    <span class="h5 text-capitalize">{{ $service->type_of_service }}</span>
                                </div>
                                <div class="col-md-6 mb-2 d-flex justify-content-between">
                                    <span class="h5">{{ trans('garage.status') }}:</span>
                                    <span class="h5 text-capitalize">{{ $service->status }}</span>
                                </div>
                                <div class="col-md-6 mb-2 d-flex justify-content-between">
                                    <span class="h5">{{ trans('garage.date') }}:</span>
                                    <span class="h5">{{ $service->datetime->format('d/m/Y') }}</span>
                                </div>
                                <div class="col-md-6 mb-2 d-flex justify-content-between">
                                    <span class="h5">{{ trans('garage.time') }}:</span>
                                    <span class="h5">{{ $service->datetime->format('H:i A') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 text-center">
                            <a href="{{ route('services.show', $service) }}" class="text-decoration-none text-primary"
                                title="{{ trans('garage.view_detail') }}"><i class="bi bi-chevron-right fs-25"></i></a>
                        </div>
                    </div>
                    <hr>
                @empty
                    <p>{{ trans('garage.no_service') }}</p>
                @endforelse
                @if ($garage->services->count() < $garage->services_count)
                    <div class="text-center mt-4">
                        <a href="{{ route('services.index', ['car' => $garage]) }}"
                            class="btn btn-sm btn-primary">{{ trans('garage.view_more') }}</a>
                    </div>
                @endif
            </div>
        </div>
        {{-- service history end --}}

        {{-- repair history --}}
        @php
            $currency = support_setting('currency_symbol');
        @endphp
        <div class="card mb-2">
            <div class="card-body">
                <h3 class="pb-3">{{ trans('garage.repair_history') }}</h3>
                @forelse ($garage->repairs as $repair)
                    <div class="row align-items-center">
                        <div class="col-10">
                            <div class="row">
                                @if ($repair->job_approval === 'requested')
                                    <div class="col-md-6 mb-2 d-flex justify-content-between">
                                        <span class="h5">{{ trans('general.message') }}:</span>
                                        <span
                                            class="h5 text-capitalize">{{ $repair->repair_work_message?->description }}</span>
                                    </div>
                                    <div class="col-md-6 mb-2 d-flex justify-content-between">
                                        <span class="h5">{{ trans('general.created') }}:</span>
                                        <span class="h5 text-capitalize">{{ $repair->created_at->format('d/m/Y') }}</span>
                                    </div>
                                @else
                                    <div class="col-md-6 mb-2 d-flex justify-content-between">
                                        <span class="h5">{{ trans('garage.status') }}:</span>
                                        <span
                                            class="h5 text-capitalize fw-semibold">{{ $repair->status === 'pending' ? trans('general.reply_pending') : $repair->status }}</span>
                                    </div>
                                    <div class="col-md-6 mb-2 d-flex justify-content-between">
                                        <span class="h5">{{ trans('garage.price') }}:</span>
                                        <span
                                            class="h5 text-capitalize">{{ $currency }}{{ $repair->price ?? 0 }}</span>
                                    </div>
                                @endif

                                @if ($repair->datetime)
                                    <div class="col-md-6 mb-2 d-flex justify-content-between">
                                        <span class="h5">{{ trans('garage.date') }}:</span>
                                        <span class="h5">{{ $repair->datetime?->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="col-md-6 mb-2 d-flex justify-content-between">
                                        <span class="h5">{{ trans('garage.time') }}:</span>
                                        <span class="h5">{{ $repair->datetime?->format('H:i A') }}</span>
                                    </div>
                                @endif

                            </div>
                        </div>
                        <div class="col-2 text-center">
                            <a href="{{ route('repairs.show', $repair) }}" class="text-decoration-none text-primary"
                                title="{{ trans('garage.view_detail') }}"><i class="bi bi-chevron-right fs-25"></i></a>
                        </div>
                    </div>
                    <hr>
                @empty
                    <p>{{ trans('garage.no_repair') }}</p>
                @endforelse
                @if ($garage->repairs->count() < $garage->repairs_count)
                    <div class="text-center mt-4">
                        <a href="{{ route('repairs.index', ['car' => $garage]) }}"
                            class="btn btn-sm btn-primary">{{ trans('garage.view_more') }}</a>
                    </div>
                @endif
            </div>
        </div>
        {{-- repair history end --}}
    </div>
@endsection
@push('scripts')
    <script>
        function deleteCar() {
            if (confirm("Are you sure?")) {
                document.getElementById(`delete-car`).submit();
            }
        }
    </script>
@endpush
