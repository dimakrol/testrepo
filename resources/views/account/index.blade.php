@extends('layouts.frontend.app')

@section('content')
    <div class="container-fluid flex-grow-1">
        <div class="row">
            <div class="col mx-auto account">
                <h3 class="account__main-title">
                    Hi John,
                </h3>
                <h4 class="account__title">
                    Facebook
                </h4>
                <button class="btn btn-facebook-login" type="button">
                    <i aria-hidden="true" class="fa fa-facebook-square"></i>
                    Connect Facebook
                </button>
                <hr>
                <h4 class="account__title">
                    Subscription
                </h4>
                <button class="custom-button custom-button--primary mb-5" type="button">
                    Get Yearly Unlimited
                </button>
                {{--<button class="custom-button custom-button--used mb-2" type="button">--}}
                    {{--<span>--}}
                        {{--<i class="fa fa-check mr-2" aria-hidden="true"></i>--}}
                    {{--</span>--}}
                    {{--Yearly Unlimited--}}
                {{--</button>--}}
                {{--<p class="text-center mb-5 small grey-text">--}}
                    {{--Your subscription will auto renew on 5/12/18 <a href="#" class="text-danger">&nbsp;cancel&nbsp;</a>--}}
                {{--</p>--}}
                <hr>
                <h4 class="account__title">
                    Account Details
                </h4>
                <form action="#" method="post">
                    <label class="input-group">
                        <input class="form-control" type="text" name="name" placeholder="Full Name" value="{{ Auth::user()->first_name}}">
                    </label>
                    <label class="input-group">
                        <input class="form-control" type="email" name="email" placeholder="Enter your email please" value="{{ Auth::user()->email }}">
                    </label>
                    <button class="custom-button custom-button--primary mb-4">Edit</button>
                </form>
                <hr>
                <button class="custom-button custom-button--alert" type="button">
                    Delete Account
                </button>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
    </script>
@endsection