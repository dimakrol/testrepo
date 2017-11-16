@extends('layouts.frontend.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3 form-margin-top">
            <h3 class="font-weight-bold" align="center">Reset Password</h3>
            <hr>
            <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}

                <div class="form-group form-margin-top">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email Address" required autofocus>
                    @if ($errors->has('email'))
                        <small class="form-text text-muted text-danger"><span class="text-danger">{{ $errors->first('email') }}</span></small>
                    @endif
                </div>
                <button type="submit" class="btn btn-success btn-block">Send Reset Link</button>
                <hr>
            </form>
        </div>
    </div>
</div>
@endsection
