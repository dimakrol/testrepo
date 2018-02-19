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
                                    <form id="my-form" method="post" action="{{route('braintree.subscribe')}}">
                                        <div id="dropin-container"></div>
                                        <input type="hidden" name="plan" value="1">
                                        {{ csrf_field() }}
                                        <hr>
                                        <input type="hidden" name="payment_nonce">
                                        <button id="payment-button" class="btn subscribe-form__submit" style="display: none" disabled><i class="fa fa-lock" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Subscribe</button>
                                        {{--<button id="payment-button" class="btn btn-primary btn-flat" type="submit">Pay now</button>--}}
                                        {{--<button id="payment-button-confirm" class="btn btn-success btn-flat" type="submit">Success</button>--}}
                                    </form>
                                    {{--<button class="subscription__paypal paypal" type="button" id="#" name="paypal"></button>--}}
                                    {{--<button id="payment-button" class="btn subscribe-form__submit"><i class="fa fa-lock" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Credit/Debit Card</button>--}}
                                    {{--{!! Form::open(['route' => 'subscription.store', 'id' => 'stripe-subscription-form']) !!}--}}
                                    {{--<input type="hidden" name="stripeToken" id="stripeToken">--}}
                                    {{--<input type="hidden" name="stripeEmail" id="stripeEmail">--}}
                                    {{--{!! Form::close() !!}--}}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://js.braintreegateway.com/web/dropin/1.9.4/js/dropin.min.js"></script>
    <script>
        $(function () {
            fbq('track', 'InitiateCheckout');

            @if(null !== session('completeRegistration'))
                fbq('track', 'CompleteRegistration');
                {{session()->forget('completeRegistration')}}
            @endif
            $.ajax({
                url: '{{ url('braintree/token') }}'
            }).done(function (response) {
                var button = document.querySelector('#payment-button');
                var form = document.querySelector('#my-form');
                // console.log('--- initialized');
                braintree.dropin.create({
                    authorization: response.data.token,
                    container: '#dropin-container',
                    paypal: {
                        flow: 'vault'
                    }
                }, function (createErr, instance) {
                    button.style.display = '';
                    console.log('--- created ');
                    if (createErr) {
                        // An error in the create call is likely due to
                        // incorrect configuration values or network issues.
                        // An appropriate error will be shown in the UI.
                        // console.error('--- here');
                        // console.error(createErr);
                        return;
                    }


                    button.addEventListener('click', function (e) {
                        e.preventDefault();
                        instance.requestPaymentMethod(function (err, payload) {
                            if (err) {
                                // Handle error
                                return;
                            }
                            // console.log('--- payment nonce ' + payload.nonce);
                            button.disabled = true;
                            form.elements.namedItem("payment_nonce").value = payload.nonce;
                            if (payload.nonce) {
                                form.submit();
                            }
                        });
                    });

                    instance.on('paymentMethodRequestable', function () {
                        button.disabled = false;
                    });

                    instance.on('noPaymentMethodRequestable', function () {
                        button.disabled = true;
                    });
                });
            });
        });
    </script>
@endsection