@extends('layouts.frontend.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3 form-margin-top">
            <h3 class="font-weight-bold">Login to your Acoount</h3>
            <p class="form-margin-top">Need an account? <a href="{{ route('register') }}">Signup Free</a></p>
            <p class="text-center">
                <a href="{{route('login.facebook')}}" class="font-weight-bold"><i class="fa fa-facebook" aria-hidden="true"></i> Continue with Facebook</a>
            </p>
            <p class="text-center"> - OR - </p>
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

                <button type="submit" class="btn btn-success btn-block form-margin-top">Login</button>
            </form>
        </div>
    </div>
</div>
@endsection
