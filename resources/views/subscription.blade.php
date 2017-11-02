@extends('layouts.frontend.app')
@section('content')
    {{--<checkout-form :user="user"></checkout-form>--}}

    <div class="container">
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <form action="/stripe_js/checkout" method="post" id="subscribe-form">
                <h3 class="page-header">Payment Information</h3>
                <div class="row">
                    <div class="col-sm-12">

                        <div class="form-group">
                            <label for="card_no">Credit Card Number</label>
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="text" class="card-number form-control" id="card_no"
                                           required data-msg-required="cannot be blank">
                                </div>
                                <div class="col-sm-6">
                                                <span class="cb-cards hidden-xs">
                                                    <span class="visa"></span>
                                                    <span class="mastercard"></span>
                                                    <span class="american_express"></span>
                                                    <span class="discover"></span>
                                                </span>
                                </div>
                            </div>
                            <small for="card_no" class="text-danger"></small>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="expiry_month">Card Expiry</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <select class="card-expiry-month form-control" id="expiry_month"
                                            required data-msg-required="empty">
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
                                <div class="col-xs-6">
                                    <select class="card-expiry-year form-control" id="expiry_year"
                                            required data-msg-required="empty">
                                        <option>2013</option>
                                        <option>2014</option>
                                        <option>2015</option>
                                        <option>2016</option>
                                        <option>2017</option>
                                        <option>2018</option>
                                        <option>2019</option>
                                        <option selected="">2020</option>
                                        <option>2021</option>
                                        <option>2022</option>
                                        <option>2023</option>
                                    </select>
                                </div>
                            </div>
                            <small for="expiry_month" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="ccv">CVC</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input type="text" class="card-cvc form-control" id="cvc" placeholder="CVC"
                                           required data-msg-required="empty">
                                </div>
                                <div class="col-xs-6">
                                    <h6 class="cb-cvv"><small>(Last 3-4 digits)</small></h6>
                                </div>
                            </div>
                            <small for="cvc" class="text-danger"></small>
                        </div>
                    </div>
                </div>
                <hr>
                <p>By clicking Subscribe, you agree to our privacy policy and terms of service.</p>
                <p><small class="text-danger" style="display:none;">There were errors while submitting</small></p>
                <p><input type="submit" class="btn btn-success btn-lg pull-left" value="Subscribe">&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="subscribe_process process" style="display:none;">Processing&hellip;</span>
                    <small class="alert-danger text-danger"></small>
                </p>
            </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://js.stripe.com/v2/"></script>
    <script>
        Stripe.setPublishableKey(WWD.stripe.stripeKey);

        $("#subscribe-form").on('submit', function(e) {
            e.preventDefault();
            // form validation
//            formValidationCheck(this);
//            if(!$(this).valid()){
//                return false;
//            }
//            // Disable the submit button to prevent repeated clicks and form submit
//            $('.submit-button').attr("disabled", "disabled");
            // createToken returns immediately - the supplied callback
            // submits the form if there are no errors
            Stripe.createToken({
                number: $('.card-number').val(),
                cvc: $('.card-cvc').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val()
            }, stripeResponseHandler);
            return false; // submit from callback
        });


        function stripeResponseHandler(status, response) {
            console.log(response);
            return false;
//            if (response.error) {
//                // Re-enable the submit button
//                $('.submit-button').removeAttr("disabled");
//                // Show the errors on the form
//                stripeErrorDisplayHandler(response);
//                $('.subscribe_process').hide();
//            } else {
//                var form = $("#subscribe-form");
//                // Getting token from the response json.
//                var token = response['id'];
//                // insert the token into the form so it gets submitted to the server
//                if ($("input[name='stripeToken']").length == 1) {
//                    $("input[name='stripeToken']").val(token);
//                } else {
//                    form.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
//                }
//                var options = {
//                    // post-submit callback when error returns
//                    error: subscribeErrorHandler,
//                    // post-submit callback when success returns
//                    success: subscribeResponseHandler,
//                    complete: function() {
//                        $('.subscribe_process').hide()
//                    },
//                    contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
//                    dataType: 'json'
//                };
//                // Doing AJAX form submit to your server.
//                form.ajaxSubmit(options);
//                return false;
//            }
        }




    </script>
@endsection