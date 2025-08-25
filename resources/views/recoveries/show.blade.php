@extends('layouts.app')

@section('content')
    <div class="container page-container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header text-center p-1">
                        {{-- <a href="{{ route('mots.index') }}" class="float-left fs-30 pl-2 text-primary"><i
                                class="bi bi-arrow-left-short"></i></a> --}}
                        <h4 class="pt-2">
                            {{ !$recovery->completer ? trans('recoveries.quotes') : trans('recoveries.view_recovery') }}
                        </h4>
                    </div>
                    <div class="card-body">
                        @include('partials.message')
                        @php
                            $currency = support_setting('currency_symbol');
                            if (can_recovery()) {
                                $percentage = request()->user()?->subscription?->package?->recovery_percentage;
                            } else {
                                $percentage = 0;
                            }
                        @endphp
                        <div class="row">
                            @if (!$recovery->completer)
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">{{ __('recoveries.company') }}</th>
                                                    <th scope="col">{{ __('general.price') }}</th>
                                                    <th scope="col">{{ __('recoveries.time_to_come') }}</th>
                                                    <th scope="col">{{ __('recoveries.select') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($recovery->quotes as $quote)
                                                    <tr>
                                                        <td>{{ $quote->user->first_name . ' ' . $quote->user->last_name }}
                                                        </td>
                                                        <td>{!! quote_price($quote->price, $quote->quote_user_id, $percentage) !!}</td>
                                                        <td>{{ $quote->time_to_come }}</td>
                                                        <td>
                                                            <form action="{{ route('recoveries.quotes', $recovery) }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="quote_id"
                                                                    value="{{ $quote->id }}">
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-outline-genix">{{ __('recoveries.yes') }}</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4">{{ __('recoveries.no_quote') }}</td>
                                                    </tr>
                                                @endforelse

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @else
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6 col-md-3 text-center mb-2">
                                            <span class="fw-semibold d-block mb-2">{{ __('recoveries.company') }}</span>
                                            <span class="">{{ $recovery->completer?->user?->company }}</span>
                                        </div>
                                        <div class="col-6 col-md-3 text-center mb-2">
                                            <span class="fw-semibold d-block mb-2">{{ __('general.price') }}</span>
                                            <span
                                                class="">{{ $currency }}{{ $recovery->completer->price }}</span>
                                        </div>
                                        <div class="col-6 col-md-3 text-center mb-2">
                                            <span
                                                class="fw-semibold d-block mb-2">{{ __('recoveries.time_to_come') }}</span>
                                            <span class="">{{ $recovery->completer->time_to_come }}</span>
                                        </div>
                                        <div class="col-6 col-md-3 text-center mb-2">
                                            <span class="fw-semibold d-block mb-2">{{ __('recoveries.started_at') }}</span>
                                            <span
                                                class="">{{ $recovery->completer->created_at->format('d/m/Y H:i A') }}</span>
                                        </div>
                                    </div>
                                </div>


                                @if ($recovery->completer)
                                    {{-- converstaion --}}
                                    @livewire('comments', ['recovery' => $recovery])

                                    @if ($recovery->payment_id)
                                        @if ($recovery->status !== App\Enums\RecoveryStatus::Completed)
                                            <div class="col-12 text-center mt-3">
                                                <hr />
                                                <form action="{{ route('recoveries.complete', $recovery) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button class="btn btn-genix">{{ __('recoveries.completed') }}</button>
                                                </form>
                                            </div>
                                        @elseif ($recovery->status === App\Enums\RecoveryStatus::Completed && !$recovery->approved)
                                            <div class="col-12 text-center mt-3">
                                                <hr />
                                                <form action="{{ route('recoveries.complete', $recovery) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button class="btn btn-genix">{{ __('recoveries.approve') }}</button>
                                                </form>
                                            </div>
                                        @else
                                            <h4 class="fw-semibold text-success text-center pt-3 w-100 border-top">
                                            </h4>
                                        @endif
                                    @else
                                        <div class="col-12 text-center mt-3">
                                            <hr />
                                            <a href="{{ route('payment', ['payment_for' => 'recoveries', 'id' => $recovery->completer->id]) }}"
                                                class="btn btn-genix">{{ __('recoveries.pay_now') }}</a>
                                        </div>
                                    @endif
                                @endif
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
