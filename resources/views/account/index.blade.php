@extends('layouts.frontend.app')

@section('content')
    <div class="container-fluid flex-grow-1">
        <div class="row">
            <div class="col mx-auto account">
                <h3 class="account__main-title">
                    Hi {{ Auth::user()->first_name }},
                </h3>
                <h4 class="account__title">
                    Facebook
                </h4>
                @if(Auth::user()->facebook_id)
                    <a href="{{ route('disconnectFacebook', Auth::user()->id) }}" class="btn btn-facebook-login">
                        <i aria-hidden="true" class="fa fa-facebook-square"></i>
                        Disconnect Facebook
                    </a>
                @else
                    <a href="{{ route('add-facebook', Auth::user()->id) }}" class="btn btn-facebook-login">
                        <i aria-hidden="true" class="fa fa-facebook-square"></i>
                        Connect Facebook
                    </a>
                @endif
                <hr>
                <h4 class="account__title">
                    Subscription
                </h4>
                @if (!Auth::user()->subscribed(['yearly', 'yearlyuk']))
                    <a href="{{ route('subscription.index') }}" class="custom-button custom-button--primary mb-5">
                        Get Yearly Unlimited
                    </a>
                @else
                    <button class="custom-button custom-button--used mb-2" type="button">
                        <span><i class="fa fa-check mr-2" aria-hidden="true"></i></span>
                        Yearly Unlimited
                    </button>
                    <p class="text-center mb-5 small grey-text">
                        Your subscription will auto renew on {{ $subscription->next_payment->format('d/m/y') }}
                        {{--<a href="#" class="text-danger">&nbsp;cancel&nbsp;</a>--}}
                    </p>
                @endif
                <hr>
                <h4 class="account__title">
                    Account Details
                </h4>
                {!! Form::open(['route' => ['user.update', Auth::user()->id]]) !!}
                    <label class="input-group">
                        <input class="form-control" type="text" name="first_name" placeholder="Full Name" value="{{ Auth::user()->first_name}}" required>
                    </label>
                    <label class="input-group">
                        <input class="form-control" type="email" name="email" placeholder="Enter your email please" value="{{ Auth::user()->email }}" required>
                    </label>
                    @if ($errors->has('email'))
                        <small class="form-text text-muted text-danger"><span class="text-danger">{{ $errors->first('email') }}</span></small>
                    @endif
                    <button class="custom-button custom-button--primary mb-4">Update</button>
                    {!! Form::close() !!}
                <hr>
                <button class="custom-button custom-button--alert" type="button" data-toggle="modal" data-target="#share-via-email">
                    Delete Account
                </button>
            </div>
        </div>
    </div>
    <div class="modal fade" id="share-via-email" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header mb-3">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Your Account?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route' => ['user.delete', Auth::user()->id]]) !!}
                    <button class="custom-button custom-button--alert mb-4">Delete</button>
                    {!! Form::close() !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="custom-button custom-button--hollow" data-dismiss="modal">Cancel</button>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
    </script>
@endsection