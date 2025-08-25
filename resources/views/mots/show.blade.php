@extends('layouts.app')

@section('content')
    <div class="container page-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center p-1">
                        {{-- <a href="{{ route('mots.index') }}" class="float-left fs-30 pl-2 text-primary"><i
                                class="bi bi-arrow-left-short"></i></a> --}}
                        <h4 class="pt-2">{{ trans('general.view', ['type' => 'MOT']) }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="h5">{{ trans('general.date_of', ['service' => 'MOT']) }}:</span>
                                    <span class="h5">{{ $mot->datetime->format('d/m/Y') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="h5">{{ trans('general.time_of', ['service' => 'MOT']) }}:</span>
                                    <span class="h5">{{ $mot->datetime->format('H:i A') }}</span>
                                </div>
                                @if ($mot->status === 'completed')
                                    {{-- <div class="d-flex justify-content-between mb-2">
                                        <span class="h5">{{ trans('general.test_number') }}:</span>
                                        <span class="h5">{{ $mot->test_number }}</span>
                                    </div> --}}
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="h5">{{ trans('general.mileage') }}:</span>
                                        <span class="h5">{{ $mot->car->mileage }}</span>
                                    </div>
                                @endif

                                @if ($mot->status !== 'completed')
                                    <h5 class="text-primary mb-3">{{ trans('general.car_information') }}</h4>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="h5">{{ trans('general.car_make') }}:</span>
                                            <span class="h5">{{ $mot->car->car_name }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="h5">{{ trans('general.car_model') }}:</span>
                                            <span class="h5">{{ $mot->car->model }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="h5">{{ trans('general.registration') }}:</span>
                                            <span class="h5">{{ $mot->car->reg }}</span>
                                        </div>
                                        <h5 class="text-primary mb-3">{{ trans('general.payment') }}</h5>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span
                                                class="h5 @if ($mot->payment === 'paid') text-uppercase text-success @else text-capitalize @endif">{{ $mot->payment }}</span>
                                            <span class="h5 text-success">{{ trans('general.payment_total') }}:
                                                {{ support_setting('currency_symbol') }}{{ $mot->price }}</span>
                                        </div>
                                @endif
                                {{-- if mot is completed --}}
                                @if ($mot->status === 'completed')
                                    <div class="d-flex justify-content-center mt-2">
                                        <span
                                            class="h3 @if ($mot->mot_task->mot_status === 'pass') text-success @else text-danger @endif text-uppercase">{{ $mot->mot_task->mot_status }}</span>
                                    </div>
                                    <!-- dangerous --->
                                    @if (count($mot->mot_task->dangerous) > 0)
                                        <h4>{{ trans('general.dangerous') }}</h4>
                                        <ul class="pl-4">
                                            @foreach ($mot->mot_task->dangerous as $reason)
                                                <li>{{ $reason }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    <!-- dangerous end --->

                                    <!-- majors --->
                                    @if (count($mot->mot_task->majors) > 0)
                                        <h4>{{ trans('general.majors') }}</h4>
                                        <ul class="pl-4">
                                            @foreach ($mot->mot_task->majors as $reason)
                                                <li>{{ $reason }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    <!-- majors end --->

                                    <!-- minors --->
                                    @if (count($mot->mot_task->minors) > 0)
                                        <h4>{{ trans('general.minors') }}</h4>
                                        <ul class="pl-4">
                                            @foreach ($mot->mot_task->minors as $reason)
                                                <li>{{ $reason }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    <!-- minors end --->

                                    <!-- advisories --->
                                    @if (count($mot->mot_task->advisories) > 0)
                                        <h4>{{ trans('general.advisories') }}</h4>
                                        <ul class="pl-4">
                                            @foreach ($mot->mot_task->advisories as $reason)
                                                <li>{{ $reason }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    <!-- advisories end --->

                                    {{-- mot fail reasons end --}}

                                    {{-- if fail then show book repair and book service --}}
                                    @if ($mot->mot_task->mot_status !== 'pass')
                                        <div class="text-center mt-3">
                                            <a href="{{ route('services.create') }}"
                                                class="btn btn-sm btn-primary">{{ trans('general.book_a_service') }}</a>
                                            <a href="{{ route('repairs.create') }}"
                                                class="btn btn-sm btn-primary">{{ trans('general.book_repair') }}</a>
                                        </div>
                                    @endif
                                    <hr>
                                    {{-- mot task details --}}
                                    @foreach ($mot->mot_task->tasks as $task)
                                        <div class="d-flex mb-2">
                                            <span class="h6">{{ trans('general.task_comment') }}:</span>
                                            <span class="h6 pl-3">{{ $task['comment'] ?? '' }}</span>
                                        </div>
                                        <div class="d-flex mb-2">
                                            <span class="h6">{{ trans('general.task_type') }}:</span>
                                            <span class="h6 pl-3 text-capitalize">{{ $task['type'] ?? '' }}</span>
                                        </div>

                                        <hr>
                                    @endforeach
                                    {{-- mot task details end --}}
                                    {{-- mot fail reasons --}}
                                @endif
                                @include('partials.garage')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
