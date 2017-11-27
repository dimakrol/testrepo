@extends('layouts.admin.app')
@section('admin-content')
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
                <th>&pound;{{ $plan->amountInPounds() }}</th>
            </tr>
        </tbody>
    </table>
    {!! Form::open(['route' => ['admin.plan.update', $plan->id], 'class' => 'form-inline']) !!}
    <div class="form-group">
        <label for="amount" class="col-form-label mr-sm-2">Amount:</label>
        {!! Form::number('amount', $plan->amountInPounds(), ['class' => 'form-control mb-2 mr-sm-2 mb-sm-0', 'id' => 'inputAmount' , 'placeholder' => 'Amount', 'required' => 'required']) !!}
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
    {!! Form::close() !!}

@endsection