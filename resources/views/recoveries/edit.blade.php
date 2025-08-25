@extends('layouts.app')

@section('content')
    <div class="container page-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @include('partials.card-header', ['title' => 'Edit Recovery'])
                    <div class="card-body">
                        @include('partials.message')

                        <form id="form" action="{{ route('recoveries.update', $recovery) }}" method="POST">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for="description">{{ __('recoveries.description') }}</label>
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description"
                                    rows="3">{{ old('description', $recovery->description) }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="location">{{ __('recoveries.location') }}</label>
                                <input id="location" class="form-control @error('location') is-invalid @enderror"
                                    type="text" name="location" value="{{ old('location', $recovery->location) }}">
                                @error('location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="nearby_places">{{ __('recoveries.instructions') }}</label>
                                <textarea id="nearby_places" class="form-control @error('nearby_places') is-invalid @enderror" name="nearby_places"
                                    rows="3">{{ old('nearby_places', $recovery->nearby_places) }}</textarea>
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
                                                value="{{ $type }}" @checked(old('type', $recovery->type) === $type)>
                                            {{ $type }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div id="otherdiv" class="form-group @if (old('type', $recovery->type) !== 'other') d-none @endif">
                                <label for="other">{{ __('recoveries.other') }}</label>
                                <input id="other" class="form-control @error('other') is-invalid @enderror"
                                    type="text" name="other" value="{{ old('other', $recovery->other) }}">
                                @error('other')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="location" class="d-block">{{ __('recoveries.assistance') }}</label>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    @foreach ($data['assistance'] as $value)
                                        <label class="btn custom-btn btn-sm btn-outline-genix shadow-none text-capitalize">
                                            <input type="radio" name="roadside_assistance" id="{{ $value }}"
                                                value="{{ $value }}" @checked(old('roadside_assistance', $recovery->roadside_assistance) === ($value === 'yes' ? 1 : 0))>
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
                                                value="{{ $payment }}" @checked(old('payment_type', $recovery->payment_type) === $payment)>
                                            {{ $payment }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div id="submitBtn" class="text-center mt-4">
                                <button type="submit" class="btn btn-primary">Update</button>
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
        $("[name='type']").on('change', function(e) {
            if (e.target.value === 'other') {
                $('#otherdiv').removeClass('d-none');
            } else {
                $('#otherdiv').addClass('d-none');
            }
        })
    </script>
@endpush
