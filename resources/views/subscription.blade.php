@extends('layouts.frontend.app')

@section('content')

    <div class="container-fluid flex-grow-1">
        <div class="row">
            <div class="col mx-auto subscription">
                <div id="pay-invoice" class="subscription__card">
                    @if(Auth::user()->subscribed(['yearly', 'yearlyuk']))
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center">You have <span class="text-danger">Yearly</span> subscription</h3>
                            </div>
                        </div>
                    @else
                    <div class="subscription__body">
                        <h2 class="subscription__membership-name">Annual Membership</h2>
                        <!--<div class="card-title">
                            <h3 class="text-center">Buy early subscription for  </h3>
                        </div>-->
                        <div class="row no-gutters subscription__title">
                            <div class="col-5 text-center">
                                <p class="subscription__price">{{$plan->stripe_id != 'yearlyuk' ? '$' : '&pound;' }}{{ $plan->amountInCurrency() }}</p>
                                <p class="subscription__term">/year*</p>
                            </div>
                            <div class="col-7">
                                <ul class="subscription__features">
                                    <li>
                                        <i class="fa fa-check" aria-hidden="true"></i> Unlimited Videos.
                                    </li>
                                    <li>
                                        <i class="fa fa-check" aria-hidden="true"></i> New Content Weekly.
                                    </li>
                                    <li>
                                        <i class="fa fa-check" aria-hidden="true"></i> Smile Guaranteed.
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <button class="subscription__paypal paypal" type="button" id="#" name="paypal"></button>
                        <hr>
                        <form class="subscribe-form" id="subscribe-form" action="/subscription" method="post">
                            <div class="error-message-alert alert alert-danger" role="alert" style="display: none"></div>
                            <input type="hidden" name="stripeToken">
                            {{ csrf_field() }}
                            <div class="row mb-3">
                                <div class="col-6">
                                    <h3 class="subscribe-form__title">Credit Card</h3>
                                    <h4 class="subscribe-form__subtitle">Accepted payment methods</h4>
                                </div>
                                <div class="col-6 d-flex align-items-end justify-content-end">
                                    <img class="img-fluid" src="{{ asset('images/CC-image.png') }}">
                                </div>
                            </div>
                            <div class="subscribe-form__input-container">
                                <label for="card-number" class="control-label mb-1 subscribe-form__label">
                                    <input id="card-number" type="tel" class="form-control cc-number cc-number--with-icon" placeholder="Card number">
                                </label>
                                <div class="subscription-form__card-number invalid-feedback">
                                    Please provide a valid credit card number.
                                </div>
                            </div>
                            <div class="row no-gutters">
                                <div class="col-4">
                                    <div class="subscribe-form__input-container subscribe-form__input-container--with-space">
                                        <label for="card-expiry-month" class="control-label mb-1 subscribe-form__label">
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
                                        </label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="subscribe-form__input-container subscribe-form__input-container--with-space">
                                        <label for="card-expiry-year" class="control-label mb-1 subscribe-form__label">
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
                                        </label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="subscribe-form__input-container">
                                        <label for="card-cvc" class="control-label mb-1 subscribe-form__label">
                                            <div class="input-group">
                                                <input type="tel" id="card-cvc" class="form-control cc-cvc" placeholder="CVC">
                                                <div class="input-group-addon">
                                                    <span class="fa fa-question-circle fa-lg" data-toggle="popover" data-container="body" data-html="true" data-title="Security Code"
                                                          data-content="<div class='text-center one-card'>The 3 digit code on back of the card..<div class='visa-mc-cvc-preview'></div></div>"
                                                          data-trigger="hover"></span>
                                                </div>
                                            </div>
                                            <div class="subscription-form__secure-code invalid-feedback">
                                                Please provide a valid secure code number.
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div id="payment-button" class="btn subscribe-form__submit">
                                    <span id="payment-button-amount"><i class="fa fa-lock" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Make secure payment</span>
                                    <span id="payment-button-sending" style="display:none;">Sending…</span>
                                </div>
                            </div>
                            <p class="small-text grey-text">*billed in advance, auto-renewal - 30-Day Satisfaction Guarantee
                                <br/>
                                by clicking make secure payment, you agree to WordsWontDo’s <a href="http://help.wordswontdo.com/important-documents/terms-and-conditions-terms-of-use" target="_blank">terms of sale</a>.
                            </p>
                        </form>
                        <div class="row mx-auto" style="display: none">
                            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" class="paypal-button">
                                @if ($plan->stripe_id != 'yearlyuk')
                                    <input type="hidden" name="custom" value="{{json_encode(array('user_id' => Auth::user()->id))}}">
                                    <input type="hidden" name="cmd" value="_s-xclick">
                                    <input type="hidden" name="hosted_button_id" value="CZQU2CJKR5VG2">
                                    <input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online!">
                                    <img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
                                @else
                                    <input type="hidden" name="custom" value="{{json_encode(array('user_id' => Auth::user()->id))}}">
                                    <input type="hidden" name="cmd" value="_s-xclick">
                                    <input type="hidden" name="hosted_button_id" value="8SVLUPUG2FPGS">
                                    <input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online!">
                                    <img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
                                @endif
                            </form>
                        </div>
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
            @if(null !== session('completeRegistration'))
                fbq('track', 'CompleteRegistration');
                {{session()->forget('completeRegistration')}}
            @endif

            Stripe.setPublishableKey(WWD.stripe.stripeKey);

            $(".subscription__paypal.paypal").on('click', function () {
                fbq('track', 'AddPaymentInfo');
                $('form.paypal-button').submit();
            });

            $('[data-toggle="popover"]').popover();

            var form = $("#subscribe-form");


            $('#payment-button').on('click', function(e) {
                fbq('track', 'AddPaymentInfo');
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
                    $('.subscription-form__card-number').show();
                    return false;
                }
                if (!valid_securuty_code(cardSecurity.val())) {
                    cardSecurity.addClass('is-invalid');
                    $('.subscription-form__secure-code').show();
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
                        form.submit();
                    }
                }
            }

            function deleteErrorMessages() {
                $('#card-number,#card-cvc').removeClass('is-invalid');
                $('.error-message-alert, .subscription-form__card-number, .subscription-form__secure-code').hide();
            }

            function toggleSubscribeButton() {
                $('#payment-button').prop('disabled', function(i, v) { return !v; });
                $('#payment-button-amount,#payment-button-sending').toggle();
            }

            function valid_credit_card(value) {
                var regex = new RegExp("^[0-9]{16}$");
                if (!regex.test(value))
                    return false;

                return luhnCheck(value);
            }

            function luhnCheck(val) {
                var sum = 0;
                for (var i = 0; i < val.length; i++) {
                    var intVal = parseInt(val.substr(i, 1));
                    if (i % 2 == 0) {
                        intVal *= 2;
                        if (intVal > 9) {
                            intVal = 1 + (intVal % 10);
                        }
                    }
                    sum += intVal;
                }
                return (sum % 10) == 0;
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