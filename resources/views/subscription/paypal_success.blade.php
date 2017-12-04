@extends('layouts.frontend.app')

@section('content')
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-12 col-sm-8 col-md-8 col-lg-4 mx-auto">
                <div id="pay-invoice" class="subscription card">
                    <div class="card-body">
                        <div class="card-title">
                            <h3 class="text-center">Your subscription has been activated.</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function () {
            fbq('track', 'Purchase', {value: 'paypal', currency: 'paypal'});
        });
    </script>
@endsection