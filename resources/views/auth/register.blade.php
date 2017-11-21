@extends('layouts.frontend.app')
@section('styles')
    <style>

    </style>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3 form-margin-top">
            <h3 class="font-weight-bold">Create Your Free Account</h3>
            <p class="form-margin-top">Already have an account? <a href="{{ route('login') }}">Log in</a></p>
            <p class="text-center">
                <a href="{{route('login.facebook')}}" class="font-weight-bold"><i class="fa fa-facebook" aria-hidden="true"></i> Continue with Facebook</a>
            </p>
            <p class="text-center"> - OR - </p>
            <hr>
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

                <div class="form-group form-margin-top">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required autofocus>
                </div>

                <button type="submit" class="btn btn-success btn-block form-margin-top">Sign Up</button>
                <hr>
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
