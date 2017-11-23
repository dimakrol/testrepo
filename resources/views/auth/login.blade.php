@extends('layouts.frontend.app')

@section('content')
<div class="container login-register-forms">
    <div class="row">
        <div class="col-md-6 offset-md-3 form-margin-top">
            <h3 class="font-weight-bold">Login to your Acoount</h3>
            <p class="grey-text">Need an account? <a href="{{ route('register') }}">Signup Free</a></p>
            <a href="{{route('login.facebook')}}" class="btn btn-facebook-login"><i class="fa fa-facebook" aria-hidden="true"></i> Continue with Facebook</a>
            <p class="text-center grey-text"> - OR - </p>
            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

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
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                    </label>
                </div>
                <a href="{{ route('password.request') }}">Lost your password?</a>
                <button type="submit" class="btn btn-success btn-block form-margin-top">Login</button>
                <p class="small-text grey-text">By clicking 'Create Account' I am agreeing to Words Won't Do's <a href="http://help.wordswontdo.com/important-documents/privacy-policy-policy" target="_blank">privacy policy</a> and <a href="http://help.wordswontdo.com/important-documents/terms-and-conditions-terms-of-use" target="_blank">terms of service</a>.</p>
            </form>
        </div>
    </div>
</div>
@endsection
