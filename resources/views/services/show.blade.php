@extends('layouts.app')

@section('content')
    <div class="container page-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center p-1">
                        {{-- <a href="{{ route('services.index') }}" class="float-left fs-30 pl-2 text-primary"><i
                                class="bi bi-arrow-left-short"></i></a> --}}
                        <h4 class="pt-2">{{ trans('general.view', ['type' => 'Service']) }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="h5">{{ trans('general.date_of', ['service' => 'Service']) }}:</span>
                                    <span class="h5">{{ $service->datetime->format('d/m/Y') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="h5">{{ trans('general.time_of', ['service' => 'Service']) }}:</span>
                                    <span class="h5">{{ $service->datetime->format('H:i A') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="h5">{{ trans('general.service_type') }}:</span>
                                    <span class="h5 text-capitalize">{{ $service->type_of_service }}</span>
                                </div>
                                <h5 class="text-primary mb-3">{{ trans('general.car_information') }}</h4>
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
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="h5">{{ trans('general.mileage') }}:</span>
                                        <span class="h5">{{ $service->car->mileage }}</span>
                                    </div>
                                    <h5 class="text-primary mb-3">{{ trans('general.payment') }}</h5>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span
                                            class="h5 @if ($service->payment === 'paid') text-uppercase text-success @else text-capitalize @endif">{{ $service->payment }}</span>
                                        <span class="h5 text-success">{{ trans('general.payment_total') }}:
                                            {{ support_setting('currency_symbol') }}{{ $service->price }}</span>
                                    </div>

                                    {{-- task carried out --}}
                                    @if ($service->tasks->count() > 0)
                                        <hr>
                                        <h4 class="mb-3">{{ trans('general.task_carried_out') }}</h4>
                                        @foreach ($service->tasks as $task)
                                            <div class="pl-3 mb-2">
                                                <h6>{{ $loop->iteration }}: {{ $task->task }}</h6>
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

                                        {{-- task carried out end --}}
                                        <p class="mt-3 text-primary">{{ trans('general.task_carried_standard') }}</p>
                                        <div class="text-center mt-3">
                                            @if (garage()?->is_mot && is_uk())
                                                <a href="{{ route('mots.create') }}"
                                                    class="btn btn-primary">{{ trans('general.book_mot') }}</a>
                                            @endif
                                            <a href="{{ route('repairs.create') }}"
                                                class="btn btn-primary">{{ trans('general.book_repair') }}</a>
                                        </div>
                                    @endif
                                    @include('partials.garage')
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
            // // Get the modal
            var modal = document.getElementById("myModal");

            var modalImg = document.getElementById("img01");
            var captionText = document.getElementById("caption");
            modal.style.display = "block";
            modalImg.src = image;
            // captionText.innerHTML = img.alt;

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none";
            };
        }
    </script>
@endpush
