@extends('layouts.frontend.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3 form-margin-top">
            <h3 class="font-weight-bold">Create Your Free Account</h3>
            <p class="form-margin-top">Already have an account? <a href="{{ route('login') }}">Log in</a></p>
            <form class="form-horizontal" method="POST" action="{{ route('register') }}">
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
                <a href="redirect">FB Login</a>
            </form>
        </div>
    </div>
</div>
@endsection
