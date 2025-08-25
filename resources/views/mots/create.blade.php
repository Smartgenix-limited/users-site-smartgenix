@extends('layouts.app')

@section('content')
    <div class="container page-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center p-1">
                        {{-- <a href="{{ route('mots.index') }}" class="float-left fs-30 pl-2 text-primary"><i
                                class="bi bi-arrow-left-short"></i></a> --}}
                        <h4 class="pt-2">{{ trans('general.create_service', ['service' => 'MOT']) }}</h4>
                    </div>
                    <div class="card-body">
                        @include('partials.message')

                        @if (is_subscription())
                            <div class="alert alert-success">
                                {{ trans('general.you_left_resourses', ['resourses' => subscription()?->mots, 'type' => 'MOTs']) }}
                            </div>
                        @endif
                        <form id="form" action="{{ route('mots.store') }}" method="POST">
                            @csrf
                            @livewire('select-car', ['type' => 'mot'])

                            {{-- date time livewire --}}
                            {{-- @livewire('date-time', ['type' => 'mot']) --}}
                            <div class="form-row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bookDate">{{ trans('general.date_of', ['service' => 'MOT']) }}</label>
                                        <input id="bookDate"
                                            class="form-control form-control-sm @error('date') is-invalid @enderror"
                                            type="date" name="date" value="{{ old('date') }}"
                                            min="{{ now()->addDays(2)->format('Y-m-d') }}" onchange="checkSlot()" required>
                                        @error('date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bookTime">{{ trans('general.time_of', ['service' => 'MOT']) }}</label>
                                        <select name="time" id="bookTime"
                                            class="form-control form-control-sm @error('time') is-invalid @enderror"
                                            onchange="checkSlot()" required>
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
                                <div id="slotError" class="col-md-12 alert alert-danger d-none" role="alert">
                                    {{ trans('general.no_slot') }}
                                </div>
                            </div>
                            @if (!can_mot())
                                @include('partials.payment_script', ['type' => 'mot'])
                            @endif


                            <!-- payment end -->

                            <div id="submitBtn" class="text-center mt-4 @if (!can_mot()) d-none @endif">
                                <button type="submit" id="subBtn" class="btn btn-primary"
                                    {{ can_mot() ? 'disabled' : '' }}>{{ trans('general.book', ['service' => 'MOT']) }}</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        // check time slot avaliable or not
        function checkSlot() {
            if ($('#bookDate').val() && $('#bookTime').val()) {
                if (!$('#slotError').hasClass('d-none')) {
                    $('#slotError').addClass('d-none');
                };
                let attr = $('#showPayment').attr('disabled');
                if (typeof attr === 'undefined' || attr === false || attr === 'undefined') {
                    $('#showPayment').attr("disabled", 'disabled')
                }
                $.ajax({
                    url: "{{ route('mots.status') }}",
                    type: 'GET',
                    data: {
                        date: $('#bookDate').val(),
                        time: $('#bookTime').val(),
                        type: 'mot'
                    },
                    success: function(res) {
                        if (!res.success) {
                            $('#slotError').removeClass('d-none');
                        } else {
                            if ("{{ can_mot() }}" == 1) {
                                $('#subBtn').removeAttr('disabled');
                            } else {
                                $('#showPayment').removeAttr('disabled');
                            }

                        }
                    }
                });
            }
        }
    </script>
@endpush
