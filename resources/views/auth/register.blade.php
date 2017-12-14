@extends('layouts.frontend.app')
@section('styles')
    <style>

    </style>
@endsection
@section('content')
<div class="container login-register-forms flex-grow-1">
    <div class="row">
        <div class="col-md-6 offset-md-3 form-margin-top">
            <h3 class="font-weight-bold">Create Your Free Account</h3>
            <p class="grey-text">Already have an account? <a href="{{ route('login') }}">Log in</a></p>
            <a href="{{route('login.facebook')}}" class="btn btn-facebook-login"><i class="fa fa-facebook-square" aria-hidden="true"></i> <span>Continue with Facebook</span></a>
            <p class="text-center grey-text"> - OR - </p>
            <div class="alert alert-danger alert-dismissible fade show register-alert-message" role="alert" style="display: none">
                <span class="message"></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="register-form form-horizontal" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                <div class="form-group form-margin-top">
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Name" required autofocus>
                    <small class="signup-name-error form-text text-muted text-danger hide-block"><span class="text-danger"></span></small>
                </div>

                <div class="form-group form-margin-top">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email Address" required autofocus>
                    <small class="signup-email-error form-text text-muted text-danger hide-block"><span class="text-danger">Email error</span></small>
                </div>

                <div class="form-group form-margin-top">
                    <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password" required autofocus>
                    <small class="signup-password-error form-text text-muted text-danger hide-block"><span class="text-danger">Password error</span></small>
                </div>
                <button type="submit" class="btn btn-success btn-block form-margin-top">Sign Up</button>
                <p class="small-text grey-text">By clicking 'Create Account' I am agreeing to Words Won't Do's <a href="http://help.wordswontdo.com/important-documents/privacy-policy-policy" target="_blank">privacy policy</a> and <a href="http://help.wordswontdo.com/important-documents/terms-and-conditions-terms-of-use" target="_blank">terms of service</a>.</p>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(function () {

            let errors = {
                name: $('.signup-name-error'),
                email: $('.signup-email-error'),
                password: $('.signup-password-error')
            };

            $('form.register-form').on('submit', function (e) {
                e.preventDefault();
                hideErrors();
                let data = $(this).serialize();

                $.ajax({
                    url: '{{route('register')}}',
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    success: function(data) {
                        window.location.replace('{{ route('subscription.index') }}');
                    },
                    error: function(data) {
                        let backErrors = JSON.parse(data.responseText).errors;

                        for (err in backErrors) {
                            errors[err].show().find('span').text(backErrors[err]);
                        }
                    }
                });
            });

            function hideErrors() {
                for (const prop in errors) {
                    errors[prop].hide();
                }
            }
        })
    </script>
@endsection
