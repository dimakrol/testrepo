@extends('layouts.frontend.app')
@section('styles')
    <style>

    </style>
@endsection
@section('content')
<div class="container login-register-forms">
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
                    @if ($errors->has('name'))
                        <small class="form-text text-muted text-danger"><span class="text-danger">{{ $errors->first('name') }}</span></small>
                    @endif
                </div>

                <div class="form-group form-margin-top">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email Address" required autofocus>
                    @if ($errors->has('email'))
                        <small class="form-text text-muted text-danger"><span class="text-danger">{{ $errors->first('email') }}</span></small>
                    @endif
                </div>

                <div class="form-group form-margin-top">
                    <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password" required autofocus>
                    @if ($errors->has('password'))
                        <small class="form-text text-muted text-danger"><span class="text-danger">{{ $errors->first('password') }}</span></small>
                    @endif
                </div>

                <button type="submit" class="btn btn-success btn-block form-margin-top">Sign Up</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(function () {
            let alert = $('.register-alert-message');
            $('form.register-form').on('submit', function (e) {
                alert.hide();
                e.preventDefault();
                let data = $(this).serialize();
                $.ajax({
                    url: '{{route('register')}}',
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    success: function(data) {
                        fbq('track', 'CompleteRegistration');
                        window.location.replace('{{ route('subscription.index') }}');
                    },
                    error: function(data) {
                        var result = '';
                        for (err in JSON.parse(data.responseText).errors) {
                            result += JSON.parse(data.responseText).errors[err].toString() + "\n";
                        }
                        alert.show().find('span.message').text(result);
                    }
                });
            });
        })
    </script>
@endsection
