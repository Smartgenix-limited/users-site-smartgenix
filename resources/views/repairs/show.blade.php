@extends('layouts.app')

@section('content')
    <div class="container page-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center p-1">
                        {{-- <a href="{{ route('repairs.index') }}" class="float-left fs-30 pl-2 text-primary"><i
                                class="bi bi-arrow-left-short"></i></a> --}}
                        <h4 class="pt-2">{{ trans('general.view', ['type' => $repair->datetime ? 'Repair' : 'Quote']) }}
                        </h4>
                    </div>
                    @php
                        $symbol = support_setting('currency_symbol');
                    @endphp
                    <div class="card-body">
                        @include('partials.message')
                        <div class="row">
                            <div class="col-md-12">
                                {{-- repairs has not date and time and it is not paid --}}
                                {{-- || $repair->payment !== 'paid' --}}

                                @if (!$repair->datetime || $repair->payment !== 'paid')
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="h5">{{ trans('general.repair_requested_date') }}:</span>
                                        <span class="h5">{{ $repair->created_at->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="h5">{{ trans('general.repair_requested_time') }}:</span>
                                        <span class="h5">{{ $repair->created_at->format('H:i A') }}</span>
                                    </div>
                                    @if ($repair->job_approval !== 'requested')
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="h5">{{ trans('general.repair_updated_date') }}:</span>
                                            <span class="h5">{{ $repair->updated_at->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="h5">{{ trans('general.repair_updated_time') }}:</span>
                                            <span class="h5">{{ $repair->updated_at->format('H:i A') }}</span>
                                        </div>
                                    @endif
                                @else
                                    {{-- repair has date and time and its paid --}}
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="h5">{{ trans('general.date_of', ['service' => 'Repair']) }}:</span>
                                        <span class="h5">{{ $repair->datetime->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span
                                            class="h5">{{ trans('general.time_of', ['service' => 'Repair']) }}:</span>
                                        <span class="h5">{{ $repair->datetime->format('H:i A') }}</span>
                                    </div>
                                @endif

                                <h5 class="text-primary mb-3">{{ trans('general.car_information') }}</h4>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="h5">{{ trans('general.car_make') }}:</span>
                                        <span class="h5">{{ $repair->car->car_name }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="h5">{{ trans('general.car_model') }}:</span>
                                        <span class="h5">{{ $repair->car->model }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="h5">{{ trans('general.registration') }}:</span>
                                        <span class="h5">{{ $repair->car->reg }}</span>
                                    </div>
                                    @if ($repair->datetime && $repair->payment == 'paid')
                                        <h5 class="text-primary mb-3">{{ trans('general.payment') }}</h5>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span
                                                class="h5 @if ($repair->payment === 'paid') text-uppercase text-success @else text-capitalize @endif">{{ $repair->payment }}</span>
                                            <span class="h5 text-success">{{ trans('general.payment_total') }}:
                                                {{ support_setting('currency_symbol') }}{{ $repair->price }}</span>
                                        </div>
                                    @endif
                                    @include('partials.garage')
                                    <hr>
                                    @if ($repair->job_approval !== 'requested')
                                        @if (is_subscription() && $repair->job_approval === 'pending')
                                            <div class="alert alert-success">
                                                {{ trans('general.you_left_resourses', ['resourses' => subscription()?->repairs, 'type' => 'Repairs']) }}
                                            </div>
                                        @endif
                                        <h4 class="text-center mt-4">{{ trans('general.quote_price') }}: <span
                                                class="text-danger font-weight-bolder h3">{{ $symbol }}{{ $repair->price }}</span>
                                        </h4>
                                        @if ($repair->payment === 'paid')
                                            <h4 class="text-center mt-3 text-success">{{ trans('general.paid') }}</h4>
                                        @endif
                                    @endif
                                    @if ($repair->job_approval === 'pending')
                                        <div class="text-center mt-4">
                                            <form action="{{ route('repairs.update', $repair) }}" method="POST"
                                                id="updateRepair">
                                                @csrf
                                                @method('put')
                                                <input type="hidden" name="type">
                                            </form>
                                            <button onclick="updateRepair('approved')"
                                                class="btn btn-sm btn-primary">{{ trans('general.approve') }}</button>
                                            <button onclick="updateRepair('rejected')"
                                                class="btn btn-sm btn-primary">{{ trans('general.reject') }}</button>
                                            <p class="mt-3">{{ trans('general.everything_garage_can_do') }}</p>
                                        </div>
                                    @endif
                                    @if ($repair->payment === 'pending' && $repair->job_approval === 'approved')
                                        <div class="d-flex align-content-center justify-content-center">
                                            <a href="{{ route('payment', ['payment_for' => 'repairs', 'id' => $repair]) }}"
                                                class="btn btn-sm btn-primary ml-2">{{ trans('general.pay_now') }}</a>
                                        </div>
                                    @endif
                                    <hr>

                                    {{-- your message --}}
                                    <h4 class="mb-3 text-right">{{ trans('general.your_message') }}</h4>
                                    <div class="d-flex flex-row-reverse">
                                        <p class="border rounded p-2">
                                            {{ $repair->repair_work_message?->description }}</p>
                                    </div>
                                    <div class="service-task d-flex flex-row-reverse flex-wrap">
                                        @foreach ($repair->repair_work_message?->images ?? [] as $image)
                                            <img id="myImg1" src="{{ $image }}" alt="image"
                                                class="img-fluid mb-2 ml-2 rounded cursor-pointer"
                                                onclick="getIndex('{{ $image }}')">
                                        @endforeach
                                        @foreach ($repair->repair_work_message?->videos ?? [] as $video)
                                            <video src="{{ $video }}"
                                                class="img-fluid mb-2 ml-2 rounded cursor-pointer" controls></video>
                                        @endforeach
                                    </div>


                                    {{-- your message end --}}

                                    {{-- garage message --}}

                                    @if ($repair->job_approval !== 'requested')
                                        <hr>
                                        <h4 class="mb-3">{{ trans('general.garage_messages') }}</h4>
                                        @foreach ($repair->repair_work_details as $quote)
                                            <div class="">
                                                <p class="border rounded p-2">
                                                    <span class="h5 mt-2">{{ $loop->iteration }}:
                                                        {{ $quote->task }}</span>
                                                    <br>
                                                    <span
                                                        class="fw-semibold">{{ trans('general.task_description') }}:</span>
                                                    {{ $quote->description }}
                                                    <br>
                                                    <span
                                                        class="fw-semibold">{{ trans('general.tax') }}({{ $quote->tax_percentage }}%):</span>&nbsp;
                                                    {{ $symbol }}{{ $quote->tax_value }}
                                                    <br>
                                                    <span
                                                        class="fw-semibold">{{ trans('general.price') }}:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    {{ $symbol }}{{ $quote->price }}
                                                    <br>
                                                    <span
                                                        class="fw-semibold">{{ trans('general.total') }}:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    {{ $symbol }}{{ $quote->price + $quote->tax_value }}
                                                <p>
                                                <div class="service-task d-flex flex-wrap">
                                                    @foreach ($quote->images as $image)
                                                        <img id="myImg1" src="{{ $image }}" alt="image"
                                                            class="img-fluid mb-2 mr-2 rounded cursor-pointer"
                                                            onclick="getIndex('{{ $image }}')">
                                                    @endforeach
                                                    @foreach ($quote->videos as $video)
                                                        <video src="{{ $video }}"
                                                            class="img-fluid mb-2 mr-2 rounded cursor-pointer"
                                                            controls></video>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif



                                    @if ($repair->job_approval === 'rejected')
                                        <h4 class="text-center text-danger mt-3">{{ trans('general.quote_rejected') }}</h4>
                                    @endif
                                    {{-- garage message end --}}

                                    @if ($repair->job_approval === 'requested')
                                        <hr>
                                        <form action="{{ route('repairs.destroy', $repair) }}" method="POST"
                                            class="text-center">
                                            @csrf
                                            @method('delete')
                                            <button
                                                class="btn btn-sm btn-primary">{{ trans('general.delete', ['type' => '']) }}</button>
                                        </form>
                                    @endif
                                    <div class="text-center mb-3">
                                        @if ($repair->status !== 'pending')
                                            <h4 class="text-capitalize pt-2">{{ trans('general.job_status') }}:
                                                {{ $repair->status }}
                                </h5>
                                @endif
                            </div>
                            {{-- task carried out --}}
                            @if ($repair->tasks->count() > 0)
                                <h4 class="mb-3">{{ trans('general.garage_task_carried_out') }}</h4>
                                @foreach ($repair->tasks as $task)
                                    <div class="pl-3 mb-3">
                                        <h6>{{ $loop->iteration }}: {{ $task->task }}</h6>
                                        <p>{{ $task->note }}</p>
                                        <div class="service-task d-flex flex-wrap">
                                            @foreach (json_decode($task->files, true) as $file)
                                                @if ($file['type'] === 'image')
                                                    <img id="myImg1" src="{{ $file['file'] }}" alt="image"
                                                        class="img-fluid mb-2 mx-2 rounded cursor-pointer"
                                                        onclick="getIndex('{{ $file['file'] }}')">
                                                @else
                                                    <video src="{{ $file['file'] }}"
                                                        class="img-fluid mb-2 mx-2 rounded cursor-pointer"
                                                        controls></video>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            {{-- task carried end --}}
                            {{-- @if ($repair->payment === 'pending' && $repair->job_approval === 'approved')
                                <div class="d-flex align-content-center justify-content-center">
                                    <a href="{{ route('payment', ['payment_for' => 'repairs', 'id' => $repair]) }}"
                                        class="btn btn-sm btn-primary ml-2">{{ trans('general.pay_now') }}</a>
                                </div>
                            @endif --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal -->
    <div id="myModal" class="popup-modal">
        <span class="close">&times;</span>
        <img class="popup-modal-content" id="img01" />
        <div id="caption"></div>
    </div>
    <!-- card body end -->
    </div>
@endsection
@push('scripts')
    <script>
        function getIndex(image) {
            // Get the modal
            var modal = document.getElementById("myModal");
            var modalImg = document.getElementById("img01");
            modal.style.display = "block";
            modalImg.src = image;

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none";
            };
        }

        // update repair
        function updateRepair(type) {
            document.querySelector("input[name='type']").value = type;
            document.getElementById("updateRepair").submit();
        }
    </script>
@endpush
