@extends('layouts.frontend.app')

@section('content')
<div class="container flex-grow-1">
    <div class="row">
        <div class="col-md-6 offset-md-3 mt-5">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <h3 class="font-weight-bold mb-5" align="center">Reset Password</h3>
            <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}

                <div class="form-group form-margin-top">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email Address" required autofocus>
                    @if ($errors->has('email'))
                        <small class="form-text text-muted text-danger"><span class="text-danger">{{ $errors->first('email') }}</span></small>
                    @endif
                </div>
                <button type="submit" class="custom-button custom-button--primary">Send Reset Link</button>
            </form>
        </div>
    </div>
</div>
@endsection
