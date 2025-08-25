<!-- payment -->
<h4 class="pl-3 text-left">{{ trans('payment.title') }}</h4>
<div class="col-md-12 mb-3">
    <!-- payment type -->
    @if ($cash)
        <div class="d-flex mb-3">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="type" id="card" value="card" checked>
                <label class="form-check-label" for="card">{{ trans('payment.card') }}</label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="type" id="cash" value="cash">
                <label class="form-check-label" for="cash">{{ trans('payment.cash') }}</label>
            </div>
        </div>
    @endif

    <!-- cash payment -->
    <div id="cashPayment" class="d-none">
        <div class="form-group mb-3">
            <label for="amountfromBill">{{ trans('payment.card') }}</label>
            <div class="input-group">
                <div class="input-group-text" id="btnGroupAddon">
                    {{ support_setting('currency_symbol') }}</div>
                <input type="number" name="price_convert" id="amountfromBillConvert"
                    value="{{ isset($price) ? convert_price($price) : '' }}" class="form-control form-control-sm"
                    readonly>
                <input type="hidden" name="price" id="amountfromBill" value="{{ isset($price) ? $price : '' }}"
                    readonly>
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="cashGiven">{{ trans('payment.cash_given') }}</label>
            <input type="number" id="cashGiven" class="form-control form-control-sm" name="cash_given"
                placeholder="Cash Given">
        </div>
        <div class="form-group mb-3">
            <label for="changeToGiven">{{ trans('payment.change_given') }}</label>
            <input type="number" id="changeToGiven" class="form-control form-control-sm" name="change_to_given"
                placeholder="Change To Given">
        </div>

        <!-- cash payment button -->
        <div class="d-flex justify-content-between align-items-center">
            <button id="cashPaymentButton" type="submit" class="btn btn-sm btn-genix" disabled>
                {{ __('payment.complete_payment') }}
            </button>
        </div>
    </div>

    <!-- Stripe Elements Placeholder -->
    <div id="cardPayment" class="row">
        <div id="card-errors" class='text-danger fw-bold'></div>
        <div class="col-md-12 mb-3">
            <div class="form-group text-left">
                <label for="cardNumber" class="fw-normal">{{ __('payment.card_number') }}
                    *</label>
                <input type="number" class="form-control form-control-sm" id="cardNumber"
                    placeholder="Credit Card Number"
                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    maxlength="16" />
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group text-left">
                <label for="mmNumber" class="fw-normal">{{ __('payment.expiry_date') }}</label>
                <input type="number" class="form-control form-control-sm" id="cardMonth" placeholder="MM"
                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    maxlength="2" />
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group text-left">
                <label for="cardYear" class="fw-normal">{{ __('payment.expiry_year') }}</label>
                <input type="number" class="form-control form-control-sm" id="cardYear" placeholder="Year"
                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    maxlength="4" />
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group text-left">
                <label for="cardCVC" class="fw-normal">{{ __('payment.card_cvc') }}</label>
                <input type="number" class="form-control form-control-sm" id="cardCVC" placeholder="CVC"
                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    maxlength="3" />
            </div>
        </div>

        <div class="col-md-6 form-group mb-3 text-left">
            <label for="payAmount">{{ __('payment.total_fee') }}</label>
            <div class="input-group input-group-sm">
                <div class="input-group-text input-group-text-sm" id="btnGroupAddon">
                    {{ support_setting('currency_symbol') }}</div>

                <input id="payAmount" type="number" class="form-control" value="{{ isset($price) ? $price : '' }}"
                    name="price" readonly aria-describedby="btnGroupAddon">
            </div>
        </div>

        <!-- stripe payment button -->
        <div class="d-flex justify-content-between align-items-center ml-3">
            <button id="card-button" type="button" class="btn btn-sm btn-genix" data-cc-on-file="false"
                data-stripe-publishable-key="{{ support_setting('stripe_key') }}"
                {{ $is_disable ? 'disabled' : '' }}>
                {{ __('payment.complete_payment') }}
            </button>
        </div>
    </div>
</div>
<!-- payment id -->
<input type="hidden" id="transactionId" name="payment_id" value="">
<!-- payment end -->

@push('scripts')
    <script>
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

        // cash payment capture
        $('#cashPaymentButton').on('click', function(e) {
            e.preventDefault();
            disabledButtons();
            let total = $('#amountfromBill').val();
            let type = $("input[name='type']").val()
            if (total !== '' || total !== 0) {
                paymentSubmission(type, total);
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
                enabledButtons()
                $('#card-errors')
                    .text(response.error.message);
            } else {
                let total = $('#payAmount').val();
                var token = response['id'];
                paymentSubmission('card', total, token);
            }
        }
        // ajax payment submission
        function paymentSubmission(type, amount, token = null) {
            $.ajax({
                url: "{{ route('payment.save') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    type: type,
                    amount: amount,
                    stripeToken: token
                },
                success: function(res) {
                    $('#transactionId').val(res.transaction);
                    changeButtonsText();
                    $("#submitBtn").prop("disabled", false);

                },
                error: function(error) {
                    console.log(error);
                    enabledButtons()
                }
            });
        }
        // disabled buttons
        function disabledButtons() {
            $('#cashPaymentButton').html(
                "{{ trans('payment.please_wait') }} <i class='fas fa-circle-notch fa-spin'></i>");
            $('#card-button').html("{{ trans('payment.please_wait') }} <i class='fas fa-circle-notch fa-spin'></i>");
            $("#cashPaymentButton").prop("disabled", true);
            $("#card-button").prop("disabled", true);
        }

        // changeButton Text
        function changeButtonsText() {
            $('#cashPaymentButton').text("{{ trans('payment.payment_completed') }}");
            $('#card-button').text("{{ trans('payment.payment_completed') }}");
        }
        // enabled buttons
        function enabledButtons() {
            $('#cashPaymentButton').text("{{ trans('payment.complete_payment') }}");
            $('#card-button').text("{{ trans('payment.complete_payment') }}");
            $("#cashPaymentButton").prop("disabled", false);
            $("#card-button").prop("disabled", false);
        }
    </script>
@endpush
