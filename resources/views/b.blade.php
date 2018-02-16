@extends('layouts.frontend.app')
@section('content')

    @include('flash::message')
    <form id="my-form" method="post" action="{{route('braintree.subscribe')}}">
        <div id="dropin-container"></div>
        <input type="hidden" name="plan" value="1">
        {{ csrf_field() }}
        <hr>
        <input type="hidden" name="payment_nonce">
        <button id="payment-button" class="btn btn-primary btn-flat" type="submit">Pay now</button>
    </form>


@endsection

@section('script')
    <script src="https://js.braintreegateway.com/web/dropin/1.9.4/js/dropin.min.js"></script>

    <script>
        $.ajax({
            url: '{{ url('braintree/token') }}'
        }).done(function (response) {
            var button = document.querySelector('#payment-button');
            var form = $('#my-form');
            console.log(response.data);
            braintree.dropin.create({
                authorization: response.data.token,
                container: '#dropin-container',
                // paypal: {
                //     flow: 'vault'
                // }
            }, function (createErr, instance) {
                if (createErr) {
                    // An error in the create call is likely due to
                    // incorrect configuration values or network issues.
                    // An appropriate error will be shown in the UI.
                    console.error(createErr);
                    return;
                }


                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    instance.requestPaymentMethod(function (err, payload) {
                        if (err) {
                            // Handle error
                            console.error(err);
                            return;
                        }
                        console.log(payload.nonce);
                        form.find('input[name=payment_nonce]').val(payload.nonce);
                        e.preventDefault();
                        form.submit();

                        // if (payload.liabilityShifted || payload.type !== 'CreditCard') {
                        //     // hiddenNonceInput.value = payload.nonce;
                        //     console.log('here success submit');
                        //     form.submit();
                        // } else {
                        //     console.log('error submit');
                        //     // Decide if you will force the user to enter a different
                        //     // payment method if liablity was not shifted
                        //     instance.clearSelectedPaymentMethod();
                        // }
                    });
                });
            });


            // braintree.setup(response.data.token, 'dropin', {
            //     container: 'dropin-container',
            //     onReady: function () {
            //         $('#payment-button').removeClass('hidden');
            //     }
            // });
        });
    </script>
@endsection