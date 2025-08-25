@extends('layouts.app')

@section('content')
    <div class="container page-container">

        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    @include('partials.card-header', ['title' => trans('marketplace.update_product')])
                    <div class="card-body">
                        @include('partials.message')
                        <form action="{{ route('marketplace.update', $market) }}" method="post" id="submitForm">
                            @csrf
                            @method('put')
                            @livewire('market-place.create', ['product' => $market, 'is_promoted' => false, 'is_updated' => true])

                            <div class="row d-none" id="validatedFields">
                                <div class="col-md-12">
                                    @include('partials.payment-livewire', [
                                        'show_promo' => false,
                                        'type' => 'product',
                                        'fee' => 10,
                                        'is_disable' => false,
                                    ])
                                </div>
                                <div class="col-md-12 text-center mt-3">
                                    <button type="submit" id="submitBtn" class="btn btn-genix"
                                        disabled>{{ trans('general.update', ['type' => '']) }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="promoModel" tabindex="-1" aria-labelledby="promoModelLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header px-3 py-2">
                                <h5 class="modal-title text-capitalize" id="promoModelLabel">
                                    {{ __('marketplace.promo_title') }}
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                    style="margin-top: -85px; margin-right:-35px;">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body py-2 px-3">
                                <p>{{ trans('marketplace.promo_message') }}</p>
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
        window.addEventListener('dataValidated', (event) => {
            $('#validatedFields').removeClass('d-none')
        });

        window.addEventListener('dataValidatedUpdated', () => {
            $('#submitForm').submit();
        });

        window.addEventListener('feeUpdated', event => {
            $('#payAmount').val(event.detail.fee);
        });
    </script>
@endpush
