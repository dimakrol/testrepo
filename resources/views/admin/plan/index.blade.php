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

@endsection