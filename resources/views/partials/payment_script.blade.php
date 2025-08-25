<div id="payError" class="alert alert-danger d-none"></div>

<button id="showPayment" type="button" class="btn btn-sm btn-genix" disabled>{{ trans('general.pay_now') }}</button>
<!-- payment -->
<div id="paymentSection" class="d-none">
    <h4 class="mb-3">{{ trans('general.payment') }}</h4>
    <!-- Promo Code -->
    <div class="d-flex">
        <div class="form-group mb-2 flex-grow">
            <input type="text" class="form-control" id="promocode" placeholder="{{ trans('general.enter_promo') }}">
        </div>
        <button type="button" id="codeForm" class="btn btn-genix mb-2 ml-3">{{ trans('general.apply_code') }}</button>
        <input type="hidden" id="promo">
    </div>
    <div id="codeSuccess" class="alert alert-success d-none"></div>
    <div id="codeError" class="alert alert-danger d-none"></div>

    <!-- Stripe Elements Placeholder -->
    <div id="cardPayment" class="row mt-3">
        <div class="col-md-12">
            <div class="form-group">
                <label for="cardNumber" class="fw-normal">{{ trans('general.card_number') }}</label>
                <input type="number" class="form-control" id="cardNumber" placeholder="Credit Card Number"
                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    maxlength="16" />
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="mmNumber" class="fw-normal">{{ trans('general.expiration_month') }}</label>
                <input type="number" class="form-control" id="cardMonth" placeholder="MM"
                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    maxlength="2" />
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="cardYear" class="fw-normal">{{ trans('general.expiration_year') }}</label>
                <input type="number" class="form-control" id="cardYear" placeholder="Year"
                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    maxlength="4" />
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="cardCVC" class="fw-normal">{{ trans('general.card_cvc') }}</label>
                <input type="number" class="form-control" id="cardCVC" placeholder="CVC"
                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    maxlength="3" />
            </div>
        </div>

        <div class="col-md-6 form-group">
            <label for="payAmount">{{ trans('general.total_fee') }}</label>
            <div class="input-group">
                <div class="input-group-prepend" id="btnGroupAddon">
                    <span class="input-group-text" id="motPrice"
                        data-type="{{ $type }}">{{ support_setting('currency_symbol') }}</span>
                </div>

                <input id="payAmount" type="text" class="form-control d-none"
                    value="{{ $type === 'mot' ? setting('mot_price') : setting('interm_service') }}"
                    placeholder="Total + Fee">
                <input id="" type="text" name="amount" class="form-control"
                    value="{{ $type === 'mot' ? setting('mot_price') : setting('interm_service') }}"
                    placeholder="Total + Fee" readonly>

            </div>
        </div>

        <!-- stripe payment button -->
        <div class="d-flex justify-content-between align-items-center col-12">
            <button id="card-button" type="submit" class="btn btn-sm btn-primary" data-cc-on-file="false"
                data-stripe-publishable-key="{{ support_setting('stripe_key') }}">
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
                            let price = $("input[name='amount']").val();
                            let discount = (price * res.value) / 100;

                            price = price - discount;
                            price = price > 0 ? price : 0;

                            $("input[name='amount']").val(Number(price).toFixed(2));
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

        // show payment only if date and time selected
        $('#showPayment').on('click', function() {
            if (!$('#payError').hasClass('d-none')) {
                $('#payError').addClass('d-none');
            }
            if ($('#bookDate').hasClass('is-invalid')) {
                $('#bookDate').removeClass('is-invalid')
            }
            if ($('#bookTime').hasClass('is-invalid')) {
                $('#bookTime').removeClass('is-invalid')
                $('#bookTime').removeClass('border-danger')
            }

            if ($('#bookDate').val() && $('#bookTime').val()) {
                $(this).addClass('d-none')
                $('#paymentSection').removeClass('d-none')
            } else {
                if (!$('#bookDate').val()) {
                    $('#bookDate').toggleClass('is-invalid')
                }
                if (!$('#bookTime').val()) {
                    $('#bookTime').toggleClass('is-invalid')
                    $('#bookTime').toggleClass('border-danger')
                }
                $('#payError').toggleClass('d-none').text('Kindly select date and time.')
            }
        })

        // check if user has pad the payment
        $('#submitBtn').on('click', function(e) {
            e.preventDefault();
            $('#payError').addClass('d-none')
            if ($("#cars").val()) {
                $('#errorMesg').addClass('d-none');
                if ($('#transactionId').val()) {
                    $('#form').submit();
                }
            } else {
                $('#errorMesg').removeClass('d-none').text('Kindly select car');
                $('#car').addClass('is-invalid border-danger');
            }
        })

        // service type change
        $("input[name='type_of_service']").on('change', function(e) {
            let length = $('#carsLength').val();
            length = length == 0 ? 1 : length;
            if (e.target.value === 'interm') {
                let interm = "{{ setting('interm_service') }}";
                $("input[name='amount']").val(interm * length);
            } else if (e.target.value === 'full') {
                let full = "{{ setting('full_service') }}";
                $("input[name='amount']").val(full * length);
            } else {
                let master = "{{ setting('major_service') }}";
                $("input[name='amount']").val(master * length);
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
                enabledButtons();
                $('#payError').removeClass('d-none').text(response.error.message);
            } else {
                let total = $("input[name='amount']").val();
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
                    promocode: code
                },
                success: function(res) {
                    $('#transactionId').val(res.transaction);
                    changeButtonsText();
                    $('#repairTime').removeClass('d-none');
                    $('#submitBtn').removeClass('d-none');
                    // $("input[name='type_of_service']").prop('readonly', true)

                    // $('#submitBtn').removeAttr('disabled');
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
            $('#repairBtn').text("Create Job");
        }
        // enabled buttons
        function enabledButtons() {
            $('#card-button').text("Complete Payment");
            $("#card-button").prop("disabled", false);
        }
    </script>
@endpush
