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
                        <div class="row no-gutters subscription__title special-offer" data-slogan="Currently - 25% Off!!!">
                            <div class="col-6 col-sm-5 text-center subscription__with-vr">
                                <p class="subscription__price special-offer__price" data-special-price="{{$plan->stripe_id != 'yearlyuk' ? '$' : '&pound;' }}{{ $plan->amountInCurrency() }}">
                                    {{$plan->stripe_id != 'yearlyuk' ? '$18' : '&pound;12' }}
                                </p>
                                <p class="subscription__term">/year*</p>
                            </div>
                            <div class="col-6 col-sm-6 offset-sm-1">
                                <ul class="subscription__features">
                                    <li>
                                        <i class="fa fa-check" aria-hidden="true"></i> Unlimited Videos.
                                    </li>
                                    <li>
                                        <i class="fa fa-check" aria-hidden="true"></i> New Content Weekly.
                                    </li>
                                    <li>
                                        <i class="fa fa-check" aria-hidden="true"></i> 10% to Charity.
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <p class="small-text grey-text text-center mb-4">*billed in advance, auto-renewal, 30 day money back guarantee</p>
                        {{--<form class="subscribe-form" id="subscribe-form" action="/subscription" method="post">--}}
                            {{--<div class="error-message-alert alert alert-danger" role="alert" style="display: none"></div>--}}
                            {{--<input type="hidden" name="stripeToken">--}}
                            {{--{{ csrf_field() }}--}}
                            {{--<div class="row mb-3">--}}
                                {{--<div class="col-6">--}}
                                    {{--<h3 class="subscribe-form__title">Credit Card</h3>--}}
                                    {{--<h4 class="subscribe-form__subtitle">Accepted payment methods</h4>--}}
                                {{--</div>--}}
                                {{--<div class="col-6 d-flex align-items-end justify-content-end">--}}
                                    {{--<img class="img-fluid" src="{{ asset('images/CC-image.png') }}">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="subscribe-form__input-container">--}}
                                {{--<label for="card-number" class="control-label mb-1 subscribe-form__label">--}}
                                    {{--<input id="card-number" type="tel" class="form-control cc-number cc-number--with-icon" placeholder="Card number">--}}
                                {{--</label>--}}
                                {{--<div class="subscription-form__card-number invalid-feedback">--}}
                                    {{--Please provide a valid credit card number.--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row no-gutters">--}}
                                {{--<div class="col-4">--}}
                                    {{--<div class="subscribe-form__input-container subscribe-form__input-container--with-space">--}}
                                        {{--<label for="card-expiry-month" class="control-label mb-1 subscribe-form__label">--}}
                                            {{--<select class="form-control" id="card-expiry-month" required>--}}
                                                {{--<option selected>01</option>--}}
                                                {{--<option>02</option>--}}
                                                {{--<option>03</option>--}}
                                                {{--<option>04</option>--}}
                                                {{--<option>05</option>--}}
                                                {{--<option>06</option>--}}
                                                {{--<option>07</option>--}}
                                                {{--<option>08</option>--}}
                                                {{--<option>09</option>--}}
                                                {{--<option>10</option>--}}
                                                {{--<option>11</option>--}}
                                                {{--<option>12</option>--}}
                                            {{--</select>--}}
                                        {{--</label>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-4">--}}
                                    {{--<div class="subscribe-form__input-container subscribe-form__input-container--with-space">--}}
                                        {{--<label for="card-expiry-year" class="control-label mb-1 subscribe-form__label">--}}
                                            {{--<select class="form-control" id="card-expiry-year" required>--}}
                                                {{--<option>2017</option>--}}
                                                {{--<option>2018</option>--}}
                                                {{--<option>2019</option>--}}
                                                {{--<option selected="">2020</option>--}}
                                                {{--<option>2021</option>--}}
                                                {{--<option>2022</option>--}}
                                                {{--<option>2023</option>--}}
                                                {{--<option>2024</option>--}}
                                                {{--<option>2025</option>--}}
                                                {{--<option>2026</option>--}}
                                                {{--<option>2027</option>--}}
                                            {{--</select>--}}
                                        {{--</label>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-4">--}}
                                    {{--<div class="subscribe-form__input-container">--}}
                                        {{--<label for="card-cvc" class="control-label mb-1 subscribe-form__label">--}}
                                            {{--<div class="input-group">--}}
                                                {{--<input type="tel" id="card-cvc" class="form-control cc-cvc" placeholder="CVC">--}}
                                                {{--<div class="input-group-addon">--}}
                                                    {{--<span class="fa fa-question-circle fa-lg" data-toggle="popover" data-container="body" data-html="true" data-title="Security Code"--}}
                                                          {{--data-content="<div class='text-center one-card'>The 3 digit code on back of the card..<div class='visa-mc-cvc-preview'></div></div>"--}}
                                                          {{--data-trigger="hover"></span>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="subscription-form__secure-code invalid-feedback">--}}
                                                {{--Please provide a valid secure code number.--}}
                                            {{--</div>--}}
                                        {{--</label>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div>--}}
                                {{--<div id="payment-button" class="btn subscribe-form__submit">--}}
                                    {{--<span id="payment-button-amount"><i class="fa fa-lock" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Make Secure Payment</span>--}}
                                    {{--<span id="payment-button-sending" style="display:none;">Sending…</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</form>--}}
                        <div class="subscription__stars">
                            <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
                                <path d="M512 198.525l-176.89-25.704-79.11-160.291-79.108 160.291-176.892 25.704 128 124.769-30.216 176.176 158.216-83.179 158.216 83.179-30.217-176.176 128.001-124.769z"></path>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
                                <path d="M512 198.525l-176.89-25.704-79.11-160.291-79.108 160.291-176.892 25.704 128 124.769-30.216 176.176 158.216-83.179 158.216 83.179-30.217-176.176 128.001-124.769z"></path>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
                                <path d="M512 198.525l-176.89-25.704-79.11-160.291-79.108 160.291-176.892 25.704 128 124.769-30.216 176.176 158.216-83.179 158.216 83.179-30.217-176.176 128.001-124.769z"></path>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
                                <path d="M512 198.525l-176.89-25.704-79.11-160.291-79.108 160.291-176.892 25.704 128 124.769-30.216 176.176 158.216-83.179 158.216 83.179-30.217-176.176 128.001-124.769z"></path>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
                                <path d="M512 198.525l-176.89-25.704-79.11-160.291-79.108 160.291-176.892 25.704 128 124.769-30.216 176.176 158.216-83.179 158.216 83.179-30.217-176.176 128.001-124.769z"></path>
                            </svg>
                        </div>
                        <div class="subscription__reviews">
                            <div class="review">
                                <img class="review__avatar" src="{{ asset('images/mike.png') }}" alt="Review user">
                                <div class="review__description">
                                    <p class="review__text">
                                        "I also subscribe to JibJab but have to say, Words Won't Do is much more fun!"
                                    </p>
                                    <p class="review__author">
                                        - Mike, Nov 2017
                                    </p>
                                </div>
                            </div>
                            <div class="review d-none d-sm-flex">
                                <img class="review__avatar" src="{{ asset('images/liz.png') }}" alt="Review user">
                                <div class="review__description">
                                    <p class="review__text">
                                        "Great fun, and very easy to use.. giggles all around"
                                    </p>
                                    <p class="review__author">
                                        - Liz, Dec 2017
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-10 mx-auto">
                                <button class="subscription__paypal paypal" type="button" id="#" name="paypal"></button>
                                <button id="payment-button" class="btn subscribe-form__submit"><i class="fa fa-lock" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Credit/Debit Card</button>
                                {!! Form::open(['route' => 'subscription.store', 'id' => 'stripe-subscription-form']) !!}
                                    <input type="hidden" name="stripeToken" id="stripeToken">
                                    <input type="hidden" name="stripeEmail" id="stripeEmail">
                                {!! Form::close() !!}
                            </div>
                        </div>
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
    <script src="https://checkout.stripe.com/checkout.js"></script>
    <script>
        $(function () {
            fbq('track', 'InitiateCheckout');

            @if(null !== session('completeRegistration'))
                fbq('track', 'CompleteRegistration');
                {{session()->forget('completeRegistration')}}
            @endif

            var stripePaymentButton = $('#payment-button');
            var subscriptionForm = $('#stripe-subscription-form');
            var stripe = StripeCheckout.configure({
                    key: WWD.stripe.stripeKey,
                    image: "{{ asset('images/logo.png') }}",
                    locale: "auto",
                    panelLabel: "Subscribe For",
                    token: function (token) {
                        $('#stripeToken').val(token.id);
                        $('#stripeEmail').val(token.email);
                        subscriptionForm.submit();
                    }
            });

            stripePaymentButton.on('click', function (e) {
                fbq('track', 'AddPaymentInfo');

                stripe.open({
                    name: 'Yearly Subscription',
                    description: 'Subscription for 1 year',
                    amount: {{$plan->amount}},
                    currency: '{{$plan->currency}}',
                    email: '{{Auth::user()->email}}'
                });
                e.preventDefault();
            });

            $(".subscription__paypal.paypal").on('click', function () {
                fbq('track', 'AddPaymentInfo');
                $('form.paypal-button').submit();
            });
        });
    </script>
@endsection