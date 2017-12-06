@extends('layouts.admin.app')
@section('admin-content')
    <div class="alert alert-success col-md-6 admin__plan_alert" role="alert" style="display: none">
        <span class="message"></span><span><i class="fa fa-times float-right" aria-hidden="true"></i></span>
    </div>
    <h3>Plan:</h3>
    <table class="table">
        <thead class="thead-default">
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Stripe Id</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">{{$plan->id}}</th>
                <th>{{$plan->name}}</th>
                <th>{{$plan->stripe_id}}</th>
                <th>${{ $plan->amountInCurrency() }}</th>
            </tr>
            <tr>
                <th scope="row">{{$planUK->id}}</th>
                <th>{{$planUK->name}}</th>
                <th>{{$planUK->stripe_id}}</th>
                <th>&pound;{{ $planUK->amountInCurrency() }}</th>
            </tr>
        </tbody>
    </table>
    {!! Form::open(['route' => ['admin.plan.update', $plan->id], 'class' => 'form-inline']) !!}
    <div class="form-group">
        <label for="amount" class="col-form-label mr-sm-2">USD $:</label>
        {!! Form::number('amount', $plan->amountInCurrency(), ['class' => 'form-control mb-2 mr-sm-2 mb-sm-0', 'id' => 'inputAmount' , 'placeholder' => 'Amount', 'required' => 'required']) !!}
    </div>
    <div class="form-group">
        <label for="amount" class="col-form-label mr-sm-2">GBP &pound;:</label>
        {!! Form::number('amount_uk', $planUK->amountInCurrency(), ['class' => 'form-control mb-2 mr-sm-2 mb-sm-0', 'id' => 'inputAmount' , 'placeholder' => 'Amount', 'required' => 'required']) !!}
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
    {!! Form::close() !!}
    <div style="padding: 15px">
        <div class="form-check">
            <label class="form-check-label">
                {!! Form::checkbox('dot', null, $plan->dot, ['class' => 'form-check-input']); !!}Dot notation
            </label>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let alert = $('.admin__plan_alert');
        let dot = $('input[name=dot]');

        dot.on('change', function () {
            let checked = 0;
            if ($(this).is(":checked")) {
                checked = 1;
            }

            $.ajax({
                data: {dot: checked},
                type: 'POST',
                url: '{{route('admin.plan.dot')}}',
                success: function (data) {

                    alert.find('span.message').text('Dot notation updated!!!');
                    alert.show();
                }
            });

        });

        alert.on('click', 'span', function () {
            $(this).parent().hide();
        });
    </script>
@endsection