<div id="payError" class="alert alert-danger d-none"></div>

<!-- payment -->
<div id="paymentSection">
    <h4 class="mb-3">{{ trans('general.payment') }}</h4>
    @if ($show_promo)
        <!-- Promo Code -->
        <div class="d-flex">
            <div class="form-group mb-2 flex-grow">
                <input type="text" class="form-control form-control-sm" id="promocode"
                    placeholder="{{ trans('general.enter_promo') }}">
            </div>
            <button type="button" id="codeForm"
                class="btn btn-genix mb-2 ml-3">{{ trans('general.apply_code') }}</button>
            <input type="hidden" id="promo">
        </div>
    @endif
    <div id="codeSuccess" class="alert alert-success d-none"></div>
    <div id="codeError" class="alert alert-danger d-none"></div>

    <!-- Stripe Elements Placeholder -->
    <div id="cardPayment" class="row mt-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="cardNumber" class="fw-normal">{{ trans('general.card_number') }}</label>
                <input type="number" class="form-control form-control-sm" id="cardNumber"
                    placeholder="Credit Card Number"
                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    maxlength="16" />
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="mmNumber" class="fw-normal">{{ trans('general.expiration_month') }}</label>
                <input type="number" class="form-control form-control-sm" id="cardMonth" placeholder="MM"
                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    maxlength="2" />
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="cardYear" class="fw-normal">{{ trans('general.expiration_year') }}</label>
                <input type="number" class="form-control form-control-sm" id="cardYear" placeholder="Year"
                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    maxlength="4" />
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="cardCVC" class="fw-normal">{{ trans('general.card_cvc') }}</label>
                <input type="number" class="form-control form-control-sm" id="cardCVC" placeholder="CVC"
                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    maxlength="3" />
            </div>
        </div>

        <div class="col-md-6 form-group">
            <label for="payAmount">{{ trans('general.total_fee') }}</label>
            <div class="input-group">
                <div class="input-group-prepend" id="btnGroupAddon">
                    <span class="input-group-text input-group-text-sm" id="motPrice" data-price="{{ $fee }}"
                        data-type="{{ $type }}">{{ support_setting('currency_symbol') }}</span>
                </div>
                {{-- <input id="payAmountConvert" type="number" class="form-control form-control-sm"
                    value="{{ convert_price($fee) }}" name="fee_convert" placeholder="Fee" readonly
                    aria-describedby="btnGroupAddon"> --}}

                <input id="payAmount" type="number" class="form-control form-control-sm" value="{{ $fee }}"
                    name="fee" placeholder="Fee" readonly aria-describedby="btnGroupAddon">
            </div>
        </div>

        <!-- stripe payment button -->
        <div class="d-flex justify-content-between align-items-center col-12">
            <button id="card-button" type="button" class="btn btn-sm btn-primary" data-cc-on-file="false"
                data-stripe-publishable-key="{{ support_setting('stripe_key') }}" {{ $is_disable ? 'disabled' : '' }}>
                {{ __('general.complete_payment') }}
            </button>
        </div>
    </div>
</div>
{{-- </div> --}}
<!-- payment id -->
<input type="hidden" id="transactionId" name="payment_id" value="">

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
                            }
                        } else {
                            $('#codeForm').removeAttr('disabled');
                            $('#codeError').removeClass('d-none').text(res.message);
                        }
                    }
                });
            }
        });
    </script>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script>
        document.addEventListener('livewire:load', function() {
            $('#card-button').on('click', function(e) {
                e.preventDefault();
                $('#payError').addClass('d-none');
                Livewire.emit('disableCheckbox', true);
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
                    Livewire.emit('disableCheckbox', false);
                    enabledButtons();
                    $('#payError').removeClass('d-none').text(response.error.message);
                } else {
                    let total = $('#payAmount').val();
                    let token = response['id'];
                    paymentSubmission('card', total, token, $('#promo').val());
                }
            }
            // ajax payment submission
            function paymentSubmission(type, amount, token = null, code = null) {
                $.ajax({
                    url: "{{ route('payment.save') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        type: type,
                        amount: amount,
                        stripeToken: token,
                        promocode: code,
                        purpose: 'smartgenix',
                    },
                    success: function(res) {
                        $('#transactionId').val(res.transaction);
                        $('#submitBtn').removeAttr('disabled')
                        changeButtonsText();
                    },
                    error: function(error) {
                        enabledButtons()
                    }
                });
            }
            // disabled buttons
            function disabledButtons() {
                $('#card-button').html("Please Wait <i class='fas fa-circle-notch fa-spin'></i>");
                $("#card-button").prop("disabled", true);
            }

            // changeButton Text
            function changeButtonsText() {
                $('#card-button').text("Payment Completed");
            }
            // enabled buttons
            function enabledButtons() {
                $('#card-button').text("Complete Payment");
                $("#card-button").prop("disabled", false);
            }
        })
    </script>
@endpush
