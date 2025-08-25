@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header text-center p-1">
                        {{-- <a href="{{ url()->previous() }}" class="float-left fs-30 pl-2 text-primary"><i
                                class="bi bi-arrow-left-short"></i></a> --}}
                        <h4 class="pt-2">{{ __('general.payment') }}</h4>
                    </div>

                    <div class="card-body pb-5">
                        @include('partials.message')
                        <form method="POST" action="{{ route('capture_payment') }}" id="paymentForm">
                            @csrf
                            @include('partials.errors')

                            <input type="hidden" name="id" value="{{ $id }}">
                            <input type="hidden" name="for" value="{{ $payment_for }}">
                            <input type="hidden" name="stripeToken" value="">
                            <input type="hidden" name="type" value="card">

                            <!-- Promo Code -->

                            <div class="@if ($payment_for === 'history') d-none @else d-flex mb-3 @endif">
                                <div class="form-group mb-2 flex-grow">
                                    <input type="text" class="form-control" id="promocode"
                                        placeholder="{{ trans('general.enter_promo') }}">
                                </div>
                                <button type="button" id="codeForm"
                                    class="btn btn-genix mb-2 ml-3">{{ trans('general.apply_code') }}</button>
                                <input type="hidden" id="promo" name="promocode">
                            </div>
                            <div id="codeSuccess" class="alert alert-success d-none"></div>
                            <div id="codeError" class="alert alert-danger d-none"></div>

                            <!-- Stripe Elements Placeholder -->
                            <div id="cardPayment" class="row">
                                <div id="card-errors" class='form-group text-danger text-center mb-1'></div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="cardNumber"
                                            class="font-weight-bold">{{ trans('general.card_number') }}</label>
                                        <input type="number" class="form-control" id="cardNumber"
                                            placeholder="Credit Card Number"
                                            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                            maxlength="16" />
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label for="mmNumber"
                                            class="font-weight-bold">{{ trans('general.expiration_month') }}</label>
                                        <input type="number" class="form-control" id="cardMonth" placeholder="MM"
                                            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                            maxlength="2" />
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label for="cardYear"
                                            class="font-weight-bold">{{ trans('general.expiration_year') }}</label>
                                        <input type="number" class="form-control" id="cardYear" placeholder="Year"
                                            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                            maxlength="4" />
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label for="cardCVC"
                                            class="font-weight-bold">{{ trans('general.card_cvc') }}</label>
                                        <input type="number" class="form-control" id="cardCVC" placeholder="CVC"
                                            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                            maxlength="3" />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="payAmount">{{ trans('general.total_fee') }}</label>
                                        <div class="input-group">
                                            <div class="input-group-text" id="btnGroupAddon">
                                                {{ support_setting('currency_symbol') }}</div>

                                            <input id="payAmount" type="number" class="form-control"
                                                value="{{ $price }}" name="amount"
                                                placeholder="{{ trans('general.total_fee') }}" readonly
                                                aria-describedby="btnGroupAddon">
                                        </div>
                                    </div>
                                </div>

                                <!-- stripe payment button -->
                                <div class="col-12">
                                    <button id="card-button" type="submit" class="btn btn-primary" data-cc-on-file="false"
                                        data-stripe-publishable-key="{{ support_setting('stripe_key') }}">
                                        {{ __('general.complete_payment') }}
                                    </button>
                                </div>
                            </div>
                            <!-- payment end-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('#codeForm').on('click', function(e) {
            e.preventDefault();
            $('#codeSuccess').addClass('d-none');
            $('#codeError').addClass('d-none');
            $(this).attr("disabled", 'disabled');

            if ($('#promocode').val()) {
                $.ajax({
                    url: "{{ route('promo.apply') }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        code: $('#promocode').val(),
                    },
                    success: function(res) {
                        if (res.success) {
                            $('#codeSuccess').removeClass('d-none').text(res.message);
                            let price = $('#payAmount').val();
                            let discount = (price * res.value) / 100;

                            price = price - discount;
                            price = price > 0 ? price : 0;

                            $('#payAmount').val(price);
                            $('#promo').val(res.code);
                            if (price == 0) {
                                $('#card-button').attr("disabled", 'disabled');
                                changeButtonsText();
                                $('#submitBtn').removeAttr('disabled');
                            }
                        } else {
                            $('#codeForm').removeAttr('disabled');
                            $('#codeError').removeClass('d-none').text(res.message);
                        }
                    }
                });
            }
        });

        // payment type change
        $("input[name='type']").on('change', function(e) {
            if (e.target.value === 'card') {
                $('#cardPayment').removeClass('d-none')
                $('#cashPayment').addClass('d-none');
            } else {
                $('#cardPayment').addClass('d-none')
                $('#cashPayment').removeClass('d-none');
            }
        });


        // automatically change calculate
        $("input[name='cash_given']").on('input', function(e) {
            let cashGiven = e.target.value;
            let total = $('#amountfromBill').val();
            let changeToGiven = cashGiven - total;
            if (cashGiven) {
                $('#changeToGiven').val(changeToGiven);
            } else {
                $('#changeToGiven').val(0);
            }
        });
    </script>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script>
        $('#card-button').on('click', function(e) {
            e.preventDefault();
            disabledButtons();
            Stripe.setPublishableKey($(this).data('stripe-publishable-key'));
            Stripe.createToken({
                number: $('#cardNumber').val(),
                cvc: $('#cardCVC').val(),
                exp_month: $('#cardMonth').val(),
                exp_year: $('#cardYear').val()
            }, stripeHandleResponse);
        });

        // stripeHandlerResponse Function
        function stripeHandleResponse(status, response) {
            if (response.error) {
                $('#card-errors')
                    .text(response.error.message);
                enabledButtons()
            } else {
                let total = $('#payAmount').val();
                $("input[name='stripeToken']").val(response['id']);
                $("#paymentForm").submit();
            }
        }
        // ajax payment submission
        function paymentSubmission(type, amount, token = null) {
            disabledButtons();
            $.ajax({
                url: "{{ route('payment.save') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    type: type,
                    amount: amount,
                    stripeToken: token,
                    purpose: "{{ $purpose }}",
                },
                success: function(res) {
                    $('#transactionId').val(res.transaction);
                    changeButtonsText()

                },
                error: function(error) {
                    enabledButtons()
                }
            });
        }
        // disabled buttons
        function disabledButtons() {
            $('#cashPaymentButton').html("<i class='fas fa-circle-notch fa-spin'></i>");
            $('#card-button').html("Please Wait <i class='fas fa-circle-notch fa-spin'></i>");
            $("#cashPaymentButton").prop("disabled", true);
            $('#card-button').prop("disabled", true);
        }

        // changeButton Text
        function changeButtonsText() {
            $('#cashPaymentButton').text("Complete Payment");
            $('#card-button').text("Complete Payment");
        }
        // enabled buttons
        function enabledButtons() {
            $('#cashPaymentButton').text("Complete Payment");
            $('#card-button').text("Complete Payment");
            $("#cashPaymentButton").prop("disabled", false);
            $('#card-button').prop("disabled", false);
        }
    </script>
@endpush
