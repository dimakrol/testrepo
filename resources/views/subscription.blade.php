@extends('layouts.frontend.app')

@section('content')

    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-12 col-sm-8 col-md-8 col-lg-4 mx-auto">
                <div id="pay-invoice" class="subscription card">
                    @if(Auth::user()->subscribed($plan->stripe_id))
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center">You have <span class="text-danger">{{ ucfirst($plan->name) }}</span> subscription</h3>
                            </div>
                        </div>
                    @else
                    <div class="card-body">
                        <div class="card-title">
                            <h3 class="text-center">Buy early subscription for {{ $plan->amountInDollars() }} $</h3>
                        </div>
                        <hr>
                        <form id="subscribe-form" action="/subscription" method="post">
                            <div class="error-message-alert alert alert-danger" role="alert" style="display: none"></div>
                            <input type="hidden" name="stripeToken">
                            {{ csrf_field() }}
                            <div class="form-group text-center">
                                <ul class="list-inline">
                                    <li class="list-inline-item"><i class="text-muted fa fa-cc-visa fa-2x"></i></li>
                                    <li class="list-inline-item"><i class="fa fa-cc-mastercard fa-2x"></i></li>
                                    <li class="list-inline-item"><i class="fa fa-cc-amex fa-2x"></i></li>
                                    <li class="list-inline-item"><i class="fa fa-cc-discover fa-2x"></i></li>
                                </ul>
                            </div>
                            <div class="form-group">
                                <label for="card-number" class="control-label mb-1">Card number</label>
                                <input id="card-number" type="tel" class="form-control cc-number">
                                <div class="invalid-feedback">
                                    Please provide a valid credit card number.
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        <label for="card-expiry-month" class="control-label mb-1">Month Expiration</label>
                                        <select class="form-control" id="card-expiry-month" required>
                                            <option selected>01</option>
                                            <option>02</option>
                                            <option>03</option>
                                            <option>04</option>
                                            <option>05</option>
                                            <option>06</option>
                                            <option>07</option>
                                            <option>08</option>
                                            <option>09</option>
                                            <option>10</option>
                                            <option>11</option>
                                            <option>12</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        <label for="card-expiry-year" class="control-label mb-1">Year Expiration</label>
                                        <select class="form-control" id="card-expiry-year" required>
                                            <option>2017</option>
                                            <option>2018</option>
                                            <option>2019</option>
                                            <option selected="">2020</option>
                                            <option>2021</option>
                                            <option>2022</option>
                                            <option>2023</option>
                                            <option>2024</option>
                                            <option>2025</option>
                                            <option>2026</option>
                                            <option>2027</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                    <label for="card-cvc" class="control-label mb-1">Security code</label>
                                        <div class="input-group">
                                            <input type="tel" id="card-cvc" class="form-control cc-cvc">
                                            <div class="input-group-addon">
                                            <span class="fa fa-question-circle fa-lg" data-toggle="popover" data-container="body" data-html="true" data-title="Security Code"
                                                  data-content="<div class='text-center one-card'>The 3 digit code on back of the card..<div class='visa-mc-cvc-preview'></div></div>"
                                                  data-trigger="hover"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div id="payment-button" class="btn btn-lg btn-info btn-block">
                                    <span id="payment-button-amount">Subscribe</span>
                                    <span id="payment-button-sending" style="display:none;">Sending…</span>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://js.stripe.com/v2/"></script>
    <script>
        $(function () {
            Stripe.setPublishableKey(WWD.stripe.stripeKey);

            $('[data-toggle="popover"]').popover();

            var form = $("#subscribe-form");


            $('#payment-button-amount').on('click', function(e) {
                e.preventDefault();
                deleteErrorMessages();
                toggleSubscribeButton();

                if (!validate()) {
                    toggleSubscribeButton();
                    return false;
                }

                Stripe.createToken({
                    number: $('#card-number').val(),
                    cvc: $('#card-cvc').val(),
                    exp_month: $('#card-expiry-month').val(),
                    exp_year: $('#card-expiry-year').val()
                }, stripeResponseHandler);
                return false; // submit from callback
            });

            function validate() {
                var cardNumber = $('#card-number');
                var cardSecurity = $('#card-cvc');
                if (!valid_credit_card(cardNumber.val())) {
                    cardNumber.addClass('is-invalid');
                    return false;
                }
                if (!valid_securuty_code(cardSecurity.val())) {
                    cardSecurity.addClass('is-invalid');
                    $('.error-message-alert').text('Please provide a valid security code.').show();
                    return false;
                }
                return true;
            }

            function stripeResponseHandler(status, response) {

                if (response.error) {
                    toggleSubscribeButton();
                    $('.error-message-alert').text('Error while processing your card...').show();
                    return false;
                } else {
                    if (response.id) {
                        $('input[name=stripeToken]').val(response.id);
                        fbq('track', 'Purchase', {
                            content_name: "User id: {{Auth::user()->id}}; email: {{Auth::user()->email}}"
                        });
                        form.submit();
                    }
                }
            }

            function deleteErrorMessages() {
                $('#card-number,#card-cvc').removeClass('is-invalid');
                $('.error-message-alert').hide();
            }

            function toggleSubscribeButton() {
                $('#payment-button').prop('disabled', function(i, v) { return !v; });
                $('#payment-button-amount,#payment-button-sending').toggle();
            }

            function valid_credit_card(value) {
                //validate if empty
                if (!value) return false;
                // accept only digits, dashes or spaces
                if (/[^0-9-\s]+/.test(value)) return false;

                // The Luhn Algorithm. It's so pretty.
                var nCheck = 0, nDigit = 0, bEven = false;
                value = value.replace(/\D/g, "");

                for (var n = value.length - 1; n >= 0; n--) {
                    var cDigit = value.charAt(n),
                        nDigit = parseInt(cDigit, 10);

                    if (bEven) {
                        if ((nDigit *= 2) > 9) nDigit -= 9;
                    }

                    nCheck += nDigit;
                    bEven = !bEven;
                }

                return (nCheck % 10) == 0;
            }

            function valid_securuty_code(value) {
                if (!value || !/^[0-9]{3,4}$/.test(value)) {
                    return false;
                }
                return true;
            }
        });
    </script>
@endsection